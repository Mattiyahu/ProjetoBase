<?php

namespace App\Http\Controllers;

use App\Models\SurveyQuestion;
use App\Models\SurveyResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class SurveyController extends Controller
{
    public function getQuestions($section)
    {
        $questions = SurveyQuestion::where('section', $section)->orderBy('id')->get();
        return response()->json($questions);
    }

    public function submitResponse(Request $request)
    {
        $validated = $request->validate([
            'responses' => 'required|array',
            'responses.*.question_id' => 'required',
            'responses.*.answer' => 'required',
        ]);

        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        try {
            foreach ($validated['responses'] as $response) {
                SurveyResponse::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'question_id' => $response['question_id']
                    ],
                    ['response' => $response['answer']]
                );
            }

            // Update user's questionnaire completion status
            User::where('id', $user->id)->update([
                'has_completed_questionnaire' => true
            ]);

            return response()->json([
                'message' => 'Respostas salvas com sucesso!',
                'user' => $user
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao salvar respostas.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
