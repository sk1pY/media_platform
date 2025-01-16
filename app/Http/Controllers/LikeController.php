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

        $like = Like::where(['user_id'=>$userId,'likeable_type'=>Post::class,'likeable_id'=>$postId])->first();

        if ($like) {
            $post->likes()->where('user_id', $userId)->delete();
            $post->decrement('likes');
            return response()->json(['success' => true, 'likes' => $post->likes, 'liked' => false]);
        } else {

            $post->likes()->create(['user_id'=>$userId,'is_liked' => true]);
            $post->increment('likes');

            return response()->json(['success' => true, 'likes' => $post->likes, 'liked' => true]);
        }

    }
}


