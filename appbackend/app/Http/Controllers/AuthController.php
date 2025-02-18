<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        Log::info('Registration attempt:', [
            'email' => $request->email,
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'ip' => $request->ip()
        ]);

        try {
            $validator = Validator::make($request->all(), [
                'firstName' => 'required|string|max:255',
                'lastName' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed'
            ], [
                'email.regex' => 'Por favor, use um email do Gmail (@gmail.com)',
                'email.unique' => 'Este email já está em uso',
                'password.confirmed' => 'As senhas não conferem',
                'password.min' => 'A senha deve ter pelo menos 8 caracteres'
            ]);

            if ($validator->fails()) {
                Log::warning('Registration validation failed:', [
                    'errors' => $validator->errors()->toArray()
                ]);
                return response()->json([
                    'error' => $validator->errors()->first()
                ], 422);
            }

            //CORREÇÂO AQUI: use first_name e last_name, e remova registration_source e name
            $userData = [
                'first_name' => trim($request->firstName),
                'last_name' => trim($request->lastName),
                'email' => strtolower(trim($request->email)),
                'password' => Hash::make($request->password),
                'registration_ip' => $request->ip(),  // Mantenha isso
                'last_login_at' => now(), // Mantenha isso
                'has_completed_questionnaire' => false, // Mantenha isso
            ];

            Log::info('Creating user with data:', $userData); // Não precisa mais esconder a senha

            $user = User::create($userData);

            Log::info('User created successfully:', ['user_id' => $user->id]);

            $token = $user->createToken('auth_token')->plainTextToken;

            Auth::login($user);

            return response()->json([
                'user' => $user,
                'token' => $token,
                'message' => 'Registro realizado com sucesso!'
            ], 201);

        } catch (\Exception $e) {
            Log::error('Registration error:', [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'error' => 'Erro ao criar conta. Por favor, tente novamente.'
            ], 500);
        }
    }

    public function login(Request $request)
    {
        // ... (o seu método login parece correto, mas adicione logs se precisar) ...
        try {
            $validator = Validator::make($request->all(), [
                'email' => [
                    'required',
                    'email',
                    'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/'
                ],
                'password' => 'required|string'
            ], [
                'email.regex' => 'Por favor, use um email do Gmail (@gmail.com)',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 422);
            }

            if (!Auth::attempt($request->only('email', 'password'))) {
                return response()->json(['error' => 'Email ou senha inválidos'], 401);
            }

            $user = User::where('email', $request->email)->firstOrFail();
            $user->last_login_at = now();
            $user->save();

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'user' => $user,
                'token' => $token
            ]);

        } catch (\Exception $e) {
            Log::error('Login error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Erro ao fazer login'], 500);
        }
    }
     public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();
            return response()->json(['message' => 'Logout realizado com sucesso']);
        } catch (\Exception $e) {
            Log::error('Logout error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Erro ao fazer logout'], 500);
        }
    }


    public function googleAuth(Request $request)
    {
        Log::debug('-------- INÍCIO DA REQUISIÇÃO GOOGLE AUTH --------');
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

                $user = User::where('google_id', $userid)->first();

                Log::debug('4. Usuário encontrado (antes do if):', ['user' => $user]);

                if ($user) {
                    Log::debug('5. Entrou no IF (usuário existente)');
					$user->last_login_at = now(); // Atualiza o last_login_at
                    $user->save();
                    Auth::login($user);
                    Log::debug('6. Usuário autenticado com sucesso (usuário existente).');
                    return response()->json(['user' => $user], 200);

                } else {
                    Log::debug('5. Entrou no ELSE (usuário não encontrado)');

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

                    // CORREÇÃO AQUI: use first_name e last_name, e remova registration_source e name
                    $user = User::create([
                        'first_name' => $payload['given_name'], // Usa given_name do payload
                        'last_name'  => $payload['family_name'] ?? '', // Usa family_name do payload
                        'email' => $payload['email'],
                        'google_id' => $userid,
                        'avatar' => $payload['picture'],
                        'password' => bcrypt(uniqid()), // Senha aleatória (obrigatório, mas não usado com Google Sign-In)
                        'registration_ip' => $request->ip(), // Adiciona o IP de registro
                        'registration_source' => 'google',  // Define a fonte de registro
                        'last_login_at' => now(), // Define a data do último login
                        'has_completed_questionnaire' => false, // Define como falso por padrão
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
        Log::debug('-------- FIM DA REQUISIÇÃO GOOGLE AUTH --------');
    }


    //Se quiser adicionar um novo metodo para lidar com os OPTIONS, adicione isto
    public function handleOptions()
    {
        return response()->json([], 200);
    }
     /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAuthenticatedUser(Request $request)
    {
        try {
            $user = Auth::user();

            if (! $user) {
                return response()->json(['message' => 'Usuário não autenticado'], 401);
            }

            return response()->json(['user' => $user], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao obter usuário autenticado', 'error' => $e->getMessage()], 500);
        }
    }
}
