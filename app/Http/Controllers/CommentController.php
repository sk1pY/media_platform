<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{

    public function store(Request $request)
    {
        $validated = $request->validate([
            'post_id' => 'required',
            'text' => 'required|string|max:600',
        ]);
        $validated['user_id'] = Auth::id();
        if(Auth()->check()){
            $comment = Comment::create(array_merge($validated));
        }
        return redirect()->route('posts.show', $comment->post_id);
    }

    public function likeDislike(Request $request)
    {
        $commentId = request('comment_id');
        $userId = Auth::id();
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
            }  else {
                $comment->increment('like');
                $comment->likes()->create(['user_id' => $userId,'is_liked' => true]);
                return response()->json(['success' => true, 'like' => $comment->like, 'liked' => true]);
            }
        }
        return response()->json(['success' => false]);
    }

    public function  comments()
    {
        $user = Auth::user();
        $comments = $user->comments()->orderBy('created_at', 'DESC')->withCount(['likes'])->paginate(10);
        return view('dashboard.comments',compact('comments'));
    }

    public function destroy(Comment $comment){
        $comment->delete();
        return redirect()->route('comments.index');
    }

}


