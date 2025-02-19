<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SurveyResponse;
use App\Models\SurveySection;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function getUserResponses()
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            // Get all sections with their questions and responses
            $sections = SurveySection::with(['questions' => function($query) {
                $query->orderBy('order');
                $query->with(['options', 'responses' => function($query) {
                    $query->where('user_id', Auth::id());
                }]);
            }])
            ->orderBy('order')
            ->get();

            // Format the data for the frontend
            $formattedSections = $sections->map(function($section) {
                return [
                    'title' => $section->title,
                    'questions' => $section->questions->map(function($question) {
                        $response = $question->responses->first();
                        return [
                            'text' => $question->text,
                            'type' => $question->type,
                            'answer' => $response ? $response->answer : null,
                            'options' => $question->options ? $question->options->pluck('value') : null
                        ];
                    })
                ];
            });

            // Get some basic statistics
            $stats = [
                'total_questions' => $sections->sum(function($section) {
                    return $section->questions->count();
                }),
                'answered_questions' => SurveyResponse::where('user_id', $user->id)->count(),
                'completion_date' => $user->updated_at->format('d/m/Y H:i:s')
            ];

            return response()->json([
                'sections' => $formattedSections,
                'stats' => $stats
            ]);

        } catch (\Exception $e) {
            Log::error('Error fetching dashboard data:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Erro ao carregar dados do dashboard'], 500);
        }
    }
}
