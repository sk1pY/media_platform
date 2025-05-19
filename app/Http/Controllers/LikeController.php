<?php

// app/Http/Controllers/LikeController.php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use Illuminate\Support\Facades\Log;

// Добавлено для использования модели Task

class LikeController extends Controller
{

    public function likePost(Request $request): \Illuminate\Http\JsonResponse
    {

        $postId = $request->input('post_id');
        $userId = Auth::id();
        $post = Post::find($postId);
        $this->authorize('like', $post);

        $like = Like::where(['user_id' => $userId, 'likeable_type' => Post::class, 'likeable_id' => $postId])->first();

        if ($like) {
            $post->likes()->where('user_id', $userId)->delete();
            $post->decrement('likes');
            return response()->json(['success' => true, 'likes' => $post->likes, 'liked' => false]);
        }

        $post->likes()->create(['user_id' => $userId]);
        $post->increment('likes');

        return response()->json(['success' => true, 'likes' => $post->likes, 'liked' => true]);
    }

    public function likeComment(Request $request)
    {
        Log::info($request->input('comment_id'));
        $commentId = request('comment_id');
        $userId = Auth::id();
        $comment = Comment::find($commentId);

        $like = Like::where(['user_id' => $userId, 'likeable_type' => Comment::class, 'likeable_id' => $commentId])->first();

            if ($like) {
                $comment->likes()->where('user_id', $userId)->delete();
                $comment->decrement('like');
                return response()->json(['success' => true, 'likes' => $comment->like, 'liked' => false]);
            } else {
                $comment->increment('like');
                $comment->likes()->create(['user_id' => $userId]);
                return response()->json(['success' => true, 'likes' => $comment->like, 'liked' => true]);
            }

        return response()->json(['success' => false]);
    }
}



