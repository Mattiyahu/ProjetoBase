<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log; // Importe o Log

class QuestionnaireController extends Controller
{
    public function store(Request $request)
    {
        //Validação
        $validator = Validator::make($request->all(), [
            'answers' => 'required|array', // Valida que 'answers' é um array
            // Adicione aqui validações mais específicas para cada pergunta, se necessário. Exemplo:
            'answers.question1' => 'required|string',
            'answers.question2' => 'required|in:yes,no',
            // ... outras validações ...
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422); // Retorna erros de validação
        }

        try {
            $user = Auth::user();
            $user->preferences = $request->input('answers'); // Salva as respostas como JSON
            $user->has_completed_questionnaire = true; // Define como completo
            $user->save();

            Log::info('Questionário salvo:', ['user_id' => $user->id, 'answers' => $request->input('answers')]); // Log

            return response()->json(['message' => 'Questionário salvo com sucesso!'], 200);
        } catch (\Exception $e) {
            Log::error('Erro ao salvar questionário:', [ // Log completo do erro
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Erro ao salvar o questionário.'], 500);
        }
    }

    // Opcional: Método para obter o status do questionário (você pode usar isso, ou o getAuthenticatedUser)
    public function getStatus(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['completed' => false], 401); // Não autenticado
        }

        return response()->json(['completed' => $user->has_completed_questionnaire], 200);
    }
}