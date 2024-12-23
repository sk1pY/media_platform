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

        $userId = auth()->id();
        $post = Post::find($postId);
        $like = Like::where(['post_id' => $postId, 'user_id' => $userId])->first();

        if ($like) {
            $like->delete();
            $post->decrement('likes');
            return response()->json(['success' => true, 'likes' => $post->likes, 'liked' => false]);
        } else {
            Like::create([
                'post_id' => $postId,
                'user_id' => $userId,
            ]);
            $post->increment('likes');

            return response()->json(['success' => true, 'likes' => $post->likes, 'liked' => true]);
        }

    }
}

