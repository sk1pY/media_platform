<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CommentaryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Post $post)
    {
        $posts = $post->comments()->get();

        return response()->json($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Post $post)
    {

        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $comments = $post->comments()->create([
            'text' => $request->input('text'),
            'user_id' => $user->id
        ]);
        return response()->json(['message' => 'success', $comments], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,Post $post,Comment $comment)
    {
        abort_if($comment->post_id !== $post->id,403);
        $this->authorize('update', $comment);

        $comment->update([
            'text' => $request->input('text'),
        ]);
        return response()->json(['message' => 'success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post,Comment $comment)
    {
        abort_if($comment->post_id !== $post->id,403);
        $this->authorize('delete', $comment);
        $comment->delete();
        return response()->json(['message' => 'success']);
    }
}
