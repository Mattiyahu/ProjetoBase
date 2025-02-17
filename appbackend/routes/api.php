<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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
    return response()->json([], 200);
})->where('any', '.*');
