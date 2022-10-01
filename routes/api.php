<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/user/register', [UserController::class, 'register']);

Route::group(['prefix' => 'auth'], function() {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::group(['middleware' => 'jwt'], function() {
    Route::post('/user/assign-group', [UserController::class, 'assignGroup']);
});
