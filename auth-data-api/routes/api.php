<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DataSearchController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function() {
    Route::get('/users', [UserController::class, 'getUsers']);
    Route::post('/users', [UserController::class, 'createUsers']);
    Route::get('/users/{id}', [UserController::class, 'getUsersDetail']);
    Route::put('/users/{id}', [UserController::class, 'updateUsers']);
    Route::delete('/users/{id}', [UserController::class, 'deleteUsers']);

    Route::get('/data', [DataSearchController::class, 'getData']);
});
