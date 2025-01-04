<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Like;
use App\Models\LikeComment;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'post_id' => 'required',
            'text' => 'required|string|max:600',
        ]);

        $comment = Comment::create([
            'post_id' => $validatedData['post_id'],
            'user_id' => Auth::user()->id,
            'text' => $validatedData['text'],
        ]);

        return redirect()->route('posts.show', $comment->post_id);
    }

    public function like_dislike(Request $request)
    {

        $commentId = $request->input('comment_id');
        $userId = Auth::user()->id;
        $comment = Comment::find($commentId);
        $type = $request->input('type');

        $like_dislike = Like::where(['user_id' => $userId, 'likeable_type' => Comment::class, 'likeable_id' => $commentId])->first();
        $like = Like::where(['user_id' => $userId, 'likeable_type' => Comment::class, 'likeable_id' => $commentId, 'is_liked' => true])->first();
        $dislike = Like::where(['user_id' => $userId, 'likeable_type' => Comment::class, 'likeable_id' => $commentId, 'is_liked' => false])->first();

        if ($type == 'like') {
            if ($like) {
                $comment->likes()->where('user_id', $userId)->delete();
                $comment->decrement('like');
                return response()->json(['success' => true, 'like' => $comment->like,'liked' => false]);
            } elseif ($dislike) {
                $comment->decrement('dislike');
                $comment->increment('like');
                $like_dislike->is_liked = true;
                $like_dislike->save();

                return response()->json(['success' => true, 'like' => $comment->like, 'dislike'=>$comment->dislike,'liked' => true]);
            } else {
                $comment->increment('like');
                $comment->likes()->create(['user_id' => $userId,'is_liked' => true]);
                return response()->json(['success' => true, 'like' => $comment->like, 'liked' => true]);
            }
        } elseif ($type == 'dislike') {
            if ($dislike) {
                $comment->likes()->where('user_id', $userId)->delete();
                $comment->decrement('dislike');
                return response()->json(['success' => true,'dislike' => $comment->dislike, 'disliked' => false]);
            } elseif ($like){
                $comment->decrement('like');
                $comment->increment('dislike');
                $like_dislike->is_liked = false;
                $like_dislike->save();
                return response()->json(['success' => true, 'like' => $comment->like,'dislike'=>$comment->dislike, 'disliked' => true]);
            } else {
                $comment->increment('dislike');
                $comment->likes()->create(['user_id' => $userId,'is_liked' => false]);

                return response()->json(['success' => true, 'dislike'=>$comment->dislike, 'disliked' => true]);
            }
        }
    }

}


