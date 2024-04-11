<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    public function index()
    {
        $posts = Task::get(); // Получаем все посты с информацией о пользователе

        return view('index', compact('posts'));
    }

    public function create(Request $request){
        Task::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
        ]);

        return redirect()->route('index');
    }
    public function delete($id){
        Task::find($id)->delete();
        return redirect()->route('index');
    }

}
