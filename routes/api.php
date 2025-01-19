<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\CommentController;
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

Route::get('/educations/{id}', [EducationController::class, 'getEducationById']);
Route::get('/education/random', [EducationController::class, 'getEducationRandom']);
Route::middleware('auth:api')->get('/educations', [EducationController::class, 'getEducationList']);
Route::middleware('auth:api')->post('/educations', [EducationController::class, 'createEducation']);
Route::middleware('auth:api')->put('/educations/{id}', [EducationController::class, 'updateEducation']);
Route::middleware('auth:api')->delete('/educations/{id}', [EducationController::class, 'deleteEducation']);

Route::post('/forum', [ForumController::class, 'createPost']);
Route::get('/forum', [ForumController::class, 'getPosts']);
Route::get('/forum/{id}', [ForumController::class, 'getPostById']);
Route::put('/forum/{id}', [ForumController::class, 'updatePost']);
Route::middleware('auth:api')->delete('/forum/{id}', [ForumController::class, 'deletePost']);

Route::post('/comments', [CommentController::class, 'createComment']);
Route::get('/comments/post/{id}', [CommentController::class, 'getCommentsByPostId']);
Route::put('/comments/{id}', [CommentController::class, 'updateComment']);
Route::middleware('auth:api')->delete('/comments/{id}', [CommentController::class, 'deleteComment']);
Route::middleware('auth:api')->get('/comments', [CommentController::class, 'getCommentsList']);