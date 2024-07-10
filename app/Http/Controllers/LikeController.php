<?php

// app/Http/Controllers/LikeController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use Illuminate\Support\Facades\DB;

// Добавлено для использования модели Task

class LikeController extends Controller
{
    /**
     * @throws \Throwable
     */
    public function like(Request $request)
    {
        $taskId = $request->input('task_id');
        $userId = auth()->id();
        $task = Task::find($taskId);
        $like = Like::where(['task_id' => $taskId, 'user_id' => $userId])->first();

        if ($like) {
            $like->delete();
            $task->decrement('likes');
            return response()->json(['success' => true, 'likes' => $task->likes, 'liked' => false]);
        } else {
            Like::create([
                'task_id' => $taskId,
                'user_id' => $userId,
            ]);
            $task->increment('likes');

            return response()->json(['success' => true, 'likes' => $task->likes, 'liked' => true]);
        }

    }
}

