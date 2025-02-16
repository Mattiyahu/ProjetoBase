<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log; // Certifique-se de ter este 'use'
use Illuminate\Http\Request;
use App\Models\User; // Certifique-se de ter este 'use' E que o caminho está correto
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator; // Importe o Validator

class AuthController extends Controller
{
    public function googleAuth(Request $request)
    {
        Log::debug('-------- INÍCIO DA REQUISIÇÃO GOOGLE AUTH --------'); // Separador
        Log::debug('Google Auth endpoint hit');

        try {
            $token = $request->input('token');
            Log::debug('1. Token recebido:', ['token' => $token]);

            $client = new \Google\Client(['client_id' => env('GOOGLE_CLIENT_ID')]);
            $payload = $client->verifyIdToken($token);

            Log::debug('2. Payload do Google:', ['payload' => $payload]);

            if ($payload) {
                $userid = $payload['sub'];
                Log::debug('3. User ID do Google:', ['userid' => $userid]);

                // Use *findOrNew* para obter um usuário existente OU criar uma instância
                $user = User::where('google_id', $userid)->first();

                Log::debug('4. Usuário encontrado (antes do if):', ['user' => $user]);


                if ($user) {
                    Log::debug('5. Entrou no IF (usuário existente)');
                    Auth::login($user);
                    Log::debug('6. Usuário autenticado com sucesso (usuário existente).');
                    return response()->json(['user' => $user], 200);

                } else {
                    Log::debug('5. Entrou no ELSE (usuário não encontrado)');

                    // Validação *antes* de criar:
                    $validator = Validator::make([
                        'name' => $payload['name'],
                        'email' => $payload['email'],
                        'google_id' => $userid,
                        'avatar' => $payload['picture'],
                    ], [
                        'name' => 'required|string|max:255',
                        'email' => 'required|string|email|max:255|unique:users',
                        'google_id' => 'required|string|max:255|unique:users',
                        'avatar' => 'nullable|string',
                    ]);


                    if ($validator->fails()) {
                        Log::error('Erro de validação ao criar usuário:', ['errors' => $validator->errors()]);
                        return response()->json(['error' => 'Erro de validação', 'messages' => $validator->errors()], 422);
                    }


                    // Cria o usuário *somente* se a validação passar
                    $user = User::create([
                        'name' => $payload['name'],
                        'email' => $payload['email'],
                        'google_id' => $userid,
                        'avatar' => $payload['picture'],
                        'password' => bcrypt(uniqid()), // Senha aleatória
                    ]);

                    Log::debug('7. Novo usuário criado:', ['user' => $user]);

                    Auth::login($user);
                    Log::debug('8. Usuário novo autenticado com sucesso.');
                    return response()->json(['user' => $user], 200);
                }

            } else {
                Log::error('Token inválido do Google.');
                return response()->json(['error' => 'Invalid token'], 401);
            }
        } catch (\Exception $e) {
            Log::error('Erro no googleAuth:', [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json(['error' => 'Erro interno do servidor: ' . $e->getMessage()], 500);
        }
        Log::debug('-------- FIM DA REQUISIÇÃO GOOGLE AUTH --------'); // Separador
    }
}