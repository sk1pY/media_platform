<?php

use App\Http\Controllers\api\v1\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\v1\PostController as v1Post;
use App\Http\Controllers\api\v1\CommentaryController as v1Comment;
use App\Http\Controllers\api\v1\RegisterController;

//AUTH
//Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);

Route::middleware('auth:sanctum')->prefix('v1')->group(function () {

    Route::middleware('auth:sanctum')->post('/logout', [LoginController::class, 'logout']);
    //POSTS
    Route::middleware('auth:sanctum')->apiResource('posts', v1Post::class);
    //COMMENTS
    Route::get('/posts/{post}/comments', [v1Comment::class, 'index']);
    Route::post('/posts/{post}/comments', [v1Comment::class, 'store']);
    //Category
    Route::get('/categories', [\App\Http\Controllers\api\v1\CategoryController::class, 'index']);
    //SEARCH
    //LIKES
//    Route::post('/posts/{post}/like', [Cate::class, 'store']);
    Route::post('/comments/comment}/like',[\App\Http\Controllers\api\v1\CommentaryController::class, 'store']);
});







