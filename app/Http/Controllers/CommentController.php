<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Post $post)
    {
        $validated = $request->validate([
            'text' => 'required|string|max:600',
        ]);

        $post->comments()->create([
            'text' => $validated['text'],
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('posts.show', $post);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post, Comment $comment)
    {
        $this->authorize('update', $comment);
        $validated = $request->validate([
            'text' => 'required|string|max:600',
        ]);

        $comment->update([
            'text' => $validated['text'],
            'updated_at' => now(),
        ]);


        return back()->with('success', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post, Comment $comment)
    {
        if ($comment->post_id !== $post->id) {
            abort(403);
        }
        $comment->delete();
        return back()->with('success', 'success');
    }

}
