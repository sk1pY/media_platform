<?php

// app/Http/Controllers/LikeController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use Illuminate\Support\Facades\DB;

// Добавлено для использования модели Task

class LikeController extends Controller
{
    /**
     * @throws \Throwable
     */
    public function like(Request $request)
    {
        $postId = $request->input('post_id');
        $userId = Auth::user()->id;

        $post = Post::find($postId);

        $like = Like::where(['post_id' => $postId, 'user_id' => $userId])->first();

        if ($like) {
            $post->likes()->detach($userId);
            $post->decrement('likes');
            return response()->json(['success' => true, 'likes' => $post->likes, 'liked' => false]);
        } else {

            $post->likes()->attach($userId);
            $post->increment('likes');

            return response()->json(['success' => true, 'likes' => $post->likes, 'liked' => true]);
        }

    }
}


