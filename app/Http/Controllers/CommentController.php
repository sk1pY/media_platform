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
            'user_id' => Auth::id(),
            'post_id' => $post->id,
            'updated_at' => now(),
        ]);


        return redirect()->route('posts.show', $post)->with('success', 'успешно обновлен');


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post,Comment $comment)
    {
        $this->authorize('delete', $comment);

        $comment->delete();
        return redirect()->back()->with('success', 'Успешно удален');
    }
     public function allCommentsInProfile()
     {
         $user = Auth::user();
         $comments = $user->comments()->orderBy('created_at', 'DESC')->withCount(['likes'])->paginate(10);
         return view('dashboard.comments', compact('comments'));
     }
}
