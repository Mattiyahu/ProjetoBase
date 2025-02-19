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

            $userData = [
                'first_name' => trim($request->firstName),
                'last_name' => trim($request->lastName),
                'email' => strtolower(trim($request->email)),
                'password' => Hash::make($request->password),
                'registration_ip' => $request->ip(),
                'last_login_at' => now(),
                'has_completed_questionnaire' => false,
            ];

            Log::info('Creating user with data:', $userData);

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
        try {
            $validator = Validator::make($request->all(), [
                'email' => [
                    'required',
                    'email',
                ],
                'password' => 'required|string'
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
                    $user->last_login_at = now();
                    $user->save();
                    Auth::login($user);
                    
                    // Create token for existing user
                    $token = $user->createToken('auth_token')->plainTextToken;
                    
                    Log::debug('6. Usuário autenticado com sucesso (usuário existente).');
                    return response()->json([
                        'user' => $user,
                        'token' => $token
                    ], 200);

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

                    $user = User::create([
                        'first_name' => $payload['given_name'],
                        'last_name'  => $payload['family_name'] ?? '',
                        'email' => $payload['email'],
                        'google_id' => $userid,
                        'avatar' => $payload['picture'],
                        'password' => bcrypt(uniqid()),
                        'registration_ip' => $request->ip(),
                        'registration_source' => 'google',
                        'last_login_at' => now(),
                        'has_completed_questionnaire' => false,
                    ]);

                    Log::debug('7. Novo usuário criado:', ['user' => $user]);

                    Auth::login($user);
                    
                    // Create token for new user
                    $token = $user->createToken('auth_token')->plainTextToken;
                    
                    Log::debug('8. Usuário novo autenticado com sucesso.');
                    return response()->json([
                        'user' => $user,
                        'token' => $token
                    ], 200);
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

    public function handleOptions()
    {
        return response()->json([], 200);
    }

    public function getUser(Request $request)
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return response()->json(['message' => 'Usuário não autenticado'], 401);
            }

            return response()->json(['user' => $user], 200);
        } catch (\Exception $e) {
            Log::error('Error getting user:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['message' => 'Erro ao obter usuário autenticado', 'error' => $e->getMessage()], 500);
        }
    }
}
