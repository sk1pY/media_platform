<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Http\Requests\Home\CommentUpdateRequest;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index():View
    {
        $user = Auth::user();
        $comments = $user->comments()->orderBy('created_at', 'DESC')->withCount(['likes'])->paginate(10);
        return view('home.comments', compact('comments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CommentUpdateRequest $request, Comment $comment):RedirectResponse
    {
        $validated = $request->validated();
        $validated['updated_at'] = now();
        $comment->update($validated);

        return back()->with('success', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment):RedirectResponse
    {
        $this->authorize('delete', $comment);

        $comment->delete();
        return back()->with('success', 'Успешно удален');
    }
}
