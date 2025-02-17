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
                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    'unique:users',
                    'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/'
                ],
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
                'name' => trim($request->firstName . ' ' . $request->lastName),
                'email' => strtolower(trim($request->email)),
                'password' => Hash::make($request->password),
                'registration_ip' => $request->ip(),
                'registration_source' => 'email',
                'last_login_at' => now(),
                'has_completed_questionnaire' => false
            ];

            Log::info('Creating user with data:', array_diff_key($userData, ['password' => '']));

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
        Log::debug('Google Auth request started');

        try {
            $token = $request->input('token');

            $client = new \Google\Client(['client_id' => env('GOOGLE_CLIENT_ID')]);
            $payload = $client->verifyIdToken($token);

            if ($payload) {
                $userid = $payload['sub'];
                $user = User::where('google_id', $userid)->first();

                if ($user) {
                    $user->last_login_at = now();
                    $user->save();
                    
                    Auth::login($user);
                    return response()->json(['user' => $user], 200);
                } else {
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
                        Log::error('Google auth validation failed:', [
                            'errors' => $validator->errors()->toArray()
                        ]);
                        return response()->json([
                            'error' => 'Erro de validação',
                            'messages' => $validator->errors()
                        ], 422);
                    }

                    $nameParts = explode(' ', $payload['name']);
                    $firstName = $nameParts[0];
                    $lastName = count($nameParts) > 1 ? implode(' ', array_slice($nameParts, 1)) : '';

                    $user = User::create([
                        'first_name' => $firstName,
                        'last_name' => $lastName,
                        'name' => $payload['name'],
                        'email' => $payload['email'],
                        'google_id' => $userid,
                        'avatar' => $payload['picture'],
                        'password' => bcrypt(uniqid()),
                        'registration_ip' => $request->ip(),
                        'registration_source' => 'google',
                        'last_login_at' => now(),
                        'has_completed_questionnaire' => false
                    ]);

                    Auth::login($user);
                    return response()->json(['user' => $user], 200);
                }
            } else {
                Log::error('Invalid Google token');
                return response()->json(['error' => 'Token inválido'], 401);
            }
        } catch (\Exception $e) {
            Log::error('Google auth error:', [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json([
                'error' => 'Erro ao autenticar com o Google'
            ], 500);
        }
    }

    public function handleOptions()
    {
        return response()->json([], 200);
    }
}
