<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FollowController;

// User Related Routes
Route::get('/', [UserController::class, "showCorrectHomePage"])->name('login');
Route::post('/register', [UserController::class, 'register'])->middleware('guest');
Route::post('/login', [UserController::class, 'login'])->middleware('guest');
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');
Route::get('/manage-avatar', [UserController::class, 'showAvatarForm']);
Route::post('/manage-avatar', [UserController::class, 'storeAvatar']);

//Blog Related Routes
Route::get('/create-post', [PostController::class, 'showCreateForm'])->middleware('auth');
Route::post('/create-post', [PostController::class, 'storeNewPost'])->middleware('auth');
Route::get('/post/{post}', [PostController::class, 'viewSinglePost']);
Route::delete('/post/{post}', [PostController::class, 'delete'])->middleware('can:delete,post');
Route::get('/post/{post}/edit', [PostController::class, 'showEditForm'])->middleware('can:update,post');
Route::put('/post/{post}', [PostController::class, 'actuallyUpdate'])->middleware('can:update,post');

//Follow related routes
Route::post('/create-follow/{user:username}', [FollowController::class, 'createFollow']);
Route::post('/remove-follow/{user:username}', [FollowController::class, 'removeFollow']);

//Profile related routes
Route::get('/profile/{user:username}', [UserController::class, 'profile']);
Route::get('/profile/{user:username}/followers', [UserController::class, 'profileFollowers']);
Route::get('/profile/{user:username}/following', [UserController::class, 'profileFollowing']);

Route::get('/admins-only', function () {
    return "You can view this page";
})->middleware('can:visitAdminPages');
