<?php

use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\v1\PostController as v1Post;
use App\Http\Controllers\api\v1\CommentaryController as v1Comment;


//TOKEN
Route::post('sanctum/token', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'device_name' => 'required',
    ]);
    $user = User::where('email', $request->email)->first();
    if (!$user || !Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }
    return $user->createToken($request->device_name)->plainTextToken;
});

Route::middleware('auth:sanctum')->apiResource('v1/posts', v1Post::class);


Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    //COMMENTS
    Route::get('/posts/{post}/comments', [v1Comment::class, 'index']);
    Route::post('/posts/{post}/comments', [v1Comment::class, 'store']);
    // Route::patch('/posts/{post}/comments/{comment}', [v1Comment::class, 'update']);
    //Route::delete('/comments/{comment}', [v1Comment::class, 'destroy']);

    //LIKES
    Route::post('/posts/{post}/like', function (Request $request, Post $post) {
        $user = auth()->user();
        $like = Like::where(['user_id' => $user->id, 'post_id' => $post->id])->first();
        if ($like) {
            $user->likes()->detach($post->id);
            return response()->json(['message' => 'likes cancel'], 200);
        }
        $user->likes()->attach($post->id);
        return response()->json(['message' => 'success'], 200);
    });

    //Category
    Route::get('/categories', [\App\Http\Controllers\api\v1\CategoryController::class, 'index']);
});







