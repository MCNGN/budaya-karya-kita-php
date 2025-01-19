<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EducationController;
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
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:api')->get('/users', [UserController::class, 'getUserList']);
Route::get('/users/{id}', [UserController::class, 'getUserPublicById']);
Route::middleware('auth:api')->put('/users/{id}', [UserController::class, 'updateProfile']);
Route::middleware('auth:api')->delete('/users/{id}', [UserController::class, 'deleteUser']);

Route::get('/education/random', [EducationController::class, 'getEducationRandom']);