<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\QuestionnaireController;
use App\Http\Controllers\SurveyController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Authentication Routes
Route::prefix('auth')->group(function () {
    // Options for CORS preflight requests
    Route::options('/{any}', [AuthController::class, 'handleOptions'])
        ->where('any', '.*');

    // Public routes
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/google', [AuthController::class, 'googleAuth']);
    
    // Protected routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', [AuthController::class, 'getAuthenticatedUser']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});

// Handle CORS preflight requests for all routes
Route::options('/{any}', function() {
    return response()->json([], 200, [
        'Access-Control-Allow-Origin' => 'http://localhost:5174',
        'Access-Control-Allow-Methods' => 'GET, POST, PUT, DELETE, OPTIONS',
        'Access-Control-Allow-Headers' => 'Content-Type, Authorization, X-Requested-With, X-CSRF-TOKEN',
        'Access-Control-Allow-Credentials' => 'true'
    ]);
})->where('any', '.*');

// Protected Routes
Route::middleware('auth:sanctum')->group(function () {
    // User Routes
    Route::prefix('user')->group(function () {
        Route::post('/questionnaire', [QuestionnaireController::class, 'store']);
        Route::get('/questionnaire-status', [QuestionnaireController::class, 'getStatus']);
    });

    // Survey Routes
    Route::get('/survey/{section}', [SurveyController::class, 'getQuestions']);
    Route::post('/survey/submit', [SurveyController::class, 'submitResponse']);
    
    Route::get('/auth/user', [AuthController::class, 'getAuthenticatedUser']);
});
