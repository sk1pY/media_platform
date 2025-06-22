<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{

    public function __invoke(Request $request, Post $post):RedirectResponse
    {
        $validated = $request->validate([
            'text' => 'required|string|max:600',
        ]);

        $post->comments()->create([
            'text' => $validated['text'],
            'user_id' => Auth::id(),
        ]);

        return back()->with('success', 'success');
    }


}
