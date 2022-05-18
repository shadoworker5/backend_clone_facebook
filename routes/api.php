<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CommentController;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\RelationShipController;
use App\Http\Controllers\API\SendDataControlleur;
use App\Http\Controllers\API\UserController;
use Illuminate\Support\Facades\Route;


Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::resource('user', UserController::class);
    Route::resource('posts', PostController::class);
    // Route::resource('commente', CommentController::class);
    Route::resource('friend_request', RelationShipController::class);
    
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('send_friend_request', [UserController::class, 'sendFriendRequest']);
    Route::post('send_post', [UserController::class, 'sendPostByPost']);
    Route::post('add_commente', [PostController::class, 'addComment']);
    Route::post('add_like', [UserController::class, 'addLike']);
    
    Route::get('getPostByUser/{email}', [UserController::class, 'getPostByUser']);
    Route::get('searchUser/{name}', [UserController::class, 'searchUser']);
    Route::get('showUser/{id}', [UserController::class, 'showUser']);
    // Route::get('getAllPost', [PostController::class, 'getPost']);
    Route::get('getNofifyByUser/{user_token}', [RelationShipController::class, 'getNofifyByUser']);
    Route::get('getCommentByPost/{id}', [PostController::class, 'getCommentByPost']);
});

Route::get('getAllPost', [PostController::class, 'getPost']);
Route::resource('users', UserController::class);
Route::resource('data', SendDataControlleur::class);