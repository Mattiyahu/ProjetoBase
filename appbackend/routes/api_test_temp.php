<?php

use Illuminate\Support\Facades\Route;

Route::get('/test-cors', function () {
    return response()->json(['message' => 'CORS is working!'])
        ->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'GET, POST, OPTIONS')
        ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
});
