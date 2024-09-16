<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;

// User Related Routes
Route::get('/', [UserController::class, "showCorrectHomePage"]);
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout']);

//Blog Related Routes
Route::get('/create-post', [PostController::class, 'showCreateForm']);
Route::post('/create-post', [PostController::class, 'storeNewPost']);
Route::get('/post/{post}', [PostController::class, 'viewSinglePost']);
