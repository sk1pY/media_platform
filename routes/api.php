<?php

use App\Http\Controllers\Api\V1\RegisterController;
use App\Http\Controllers\Api\V1\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\PostController as v1Post;
use App\Http\Controllers\Api\V1\CommentaryController as v1Comment;
use App\Http\Controllers\Api\V1\CategoryController as v1Category;
use App\Http\Controllers\Api\V1\LikeController as v1Like;
use App\Http\Controllers\Api\V1\UserController as v1User;
use App\Http\Controllers\Api\V1\Home\UserController as v1HomeUser;
use App\Http\Controllers\Api\V1\Home\CommentController as v1HomeComment;
use App\Http\Controllers\Api\V1\Home\BookmarkController as v1HomeBookmark;
//LOGIN&&REGISTER
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);

Route::prefix('v1')->group(function () {
    //PUBLIC
    Route::get('/users/{user}', [v1User::class, 'show']);
    //Category show
    Route::get('/categories/{category}', [v1Category::class, 'show']);
    Route::get('/special-categories/{category}', [v1Category::class, 'specialCategoriesShow']);
    //Posts
    Route::get('/posts', [v1Post::class, 'index']);
    Route::get('/posts/{post}', [v1Post::class, 'show']);
    Route::get('/posts/{post}/comments', [v1Comment::class, 'index']);

    //AUTH
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [LoginController::class, 'logout']);
        //POSTS
        Route::apiResource('posts', v1Post::class)->except(['show']);
        //COMMENTS
        Route::apiResource('posts.comments', v1Comment::class)->except(['index']);
        //LIKES
        Route::post('/posts/{post}/comments/{comment}/like', [v1Like::class, 'likeComment']);
        Route::post('/posts/{post}/like', [v1Like::class, 'likePost']);
        //Home
        Route::prefix('profile')->group(function () {
            Route::apiResource('users', v1HomeUser::class);
            Route::apiResource('comments', v1HomeComment::class);
            Route::get('/bookmarks', [v1HomeBookmark::class, 'index']);
            Route::post('/posts/{post}/bookmarks', [v1HomeBookmark::class, 'toggle']);
        });
    });
});











