<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/user/register', [UserController::class, 'register']);

Route::group(['prefix' => 'auth'], function() {
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/logout', [AuthController::class, 'logout']);
});

Route::group(['middleware' => 'jwt'], function() {
    Route::post('/user/assign-group', [UserController::class, 'assignGroup']);

    Route::get('/group', [GroupController::class, 'index']);
    Route::post('/group/create', [GroupController::class, 'create']);

    Route::get('/note', [NoteController::class, 'index']);
    Route::post('/note/create', [NoteController::class, 'create']);
    Route::post('/note/upload-image', [NoteController::class, 'uploadImage']);
});
