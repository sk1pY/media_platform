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
            'task_id' => 'required',
            'text' => 'required|string|max:255',
        ]);

        $comment = Comment::create([
            'task_id' => $validatedData['task_id'],
            'user_id' => Auth::user()->id,
            'text' => $validatedData['text'],
        ]);
        // Редирект на страницу поста или другую нужную страницу
        return redirect()->route('task.about', $comment->task_id);
    }
}
