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
Route::options('/auth/google', [AuthController::class, 'handleOptions']);
Route::options('/auth/user', [AuthController::class, 'handleOptions']);
Route::post('/auth/google', [AuthController::class, 'googleAuth']);
Route::middleware('auth:sanctum')->get('/auth/user', [AuthController::class, 'getAuthenticatedUser']);
