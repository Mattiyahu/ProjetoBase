<?php

use Illuminate\Support\Facades\Route;

Route::get('/test-get', function () {
    return response()->json(['message' => 'GET request is working!']);
});
