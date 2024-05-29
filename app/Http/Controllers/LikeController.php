<?php

// app/Http/Controllers/LikeController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;
use App\Models\Task; // Добавлено для использования модели Task

class LikeController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'task_id' => 'required|exists:tasks,id', // Используем поле task_id для лайков
        ]);

        $like = Like::firstOrCreate([
            'task_id' => $validated['task_id'], // Используем поле task_id для сохранения лайков
            'user_id' => Auth::id(),
        ]);

        return response()->json(['message' => 'Liked successfully!', 'like' => $like]);
    }

    public function destroy(Request $request)
    {
        $validated = $request->validate([
            'task_id' => 'required|exists:tasks,id', // Используем поле task_id для лайков
        ]);

        $like = Like::where('task_id', $validated['task_id']) // Используем поле task_id для поиска лайков
        ->where('user_id', Auth::id())
            ->first();

        if ($like) {
            $like->delete();
            return response()->json(['message' => 'Unliked successfully!']);
        }

        return response()->json(['message' => 'Like not found!'], 404);
    }
}

