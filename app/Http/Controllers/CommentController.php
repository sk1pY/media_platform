<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{

    public function store(Request $request){
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
}
