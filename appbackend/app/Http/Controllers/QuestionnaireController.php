<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\SurveySection;
use App\Models\SurveyQuestion;
use App\Models\SurveyResponse;
use Illuminate\Support\Facades\DB;

class QuestionnaireController extends Controller
{
    public function getQuestions()
    {
        Log::info('Getting questions for user:', ['user_id' => Auth::id()]);

        try {
            $user = Auth::user();
            if (!$user) {
                Log::error('No authenticated user found in getQuestions');
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            $sections = SurveySection::with(['questions' => function($query) {
                $query->orderBy('order');
                $query->with(['options' => function($q) {
                    $q->orderBy('order');
                }]);
            }])
            ->orderBy('order')
            ->get();

            Log::info('Successfully fetched sections:', [
                'section_count' => $sections->count(),
                'sections' => $sections->toArray()
            ]);

            // Debug log to check if sections are empty
            if ($sections->isEmpty()) {
                Log::warning('No sections found in the database');
            } else {
                Log::info('Section details:', [
                    'first_section' => $sections->first()->toArray(),
                    'question_count' => $sections->first()->questions->count()
                ]);
            }

            return response()->json([
                'sections' => $sections
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error fetching questionnaire:', [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Erro ao carregar questionário: ' . $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        Log::info('Received questionnaire submission', ['user' => Auth::id(), 'data' => $request->all()]);

        $user = Auth::user();
        if (!$user) {
            Log::error('No authenticated user found');
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Validate that answers is an array
        if (!$request->has('answers') || !is_array($request->input('answers'))) {
            return response()->json(['error' => 'Respostas inválidas'], 422);
        }

        try {
            DB::beginTransaction();

            // Delete any existing responses for this user
            SurveyResponse::where('user_id', $user->id)->delete();

            // Store new responses
            foreach ($request->input('answers') as $questionId => $answer) {
                // Verify that the question exists
                $question = SurveyQuestion::find($questionId);
                if (!$question) {
                    continue;
                }

                SurveyResponse::create([
                    'user_id' => $user->id,
                    'question_id' => $questionId,
                    'answer' => $answer
                ]);
            }

            // Update user's questionnaire completion status
            User::where('id', $user->id)->update([
                'has_completed_questionnaire' => true
            ]);

            DB::commit();

            Log::info('Questionnaire saved successfully', ['user_id' => $user->id]);

            // Get updated user data
            $updatedUser = User::find($user->id);

            return response()->json([
                'message' => 'Questionário salvo com sucesso!',
                'user' => $updatedUser
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saving questionnaire:', [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Erro ao salvar o questionário: ' . $e->getMessage()], 500);
        }
    }

    public function getStatus(Request $request)
    {
        Log::info('Getting questionnaire status for user:', ['user_id' => Auth::id()]);

        $user = Auth::user();
        if (!$user) {
            Log::error('No authenticated user found in getStatus');
            return response()->json(['completed' => false], 401);
        }

        $status = [
            'completed' => $user->has_completed_questionnaire,
            'responses' => $user->has_completed_questionnaire ? 
                SurveyResponse::where('user_id', $user->id)
                    ->with('question')
                    ->get() 
                : null
        ];

        Log::info('Questionnaire status:', $status);

        return response()->json($status, 200);
    }
}
