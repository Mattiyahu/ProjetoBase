<?php

use Illuminate\Support\Facades\Route;

Route::post('/test-post', function () {
    return response()->json(['message' => 'POST request is working!']);
});
