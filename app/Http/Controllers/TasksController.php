<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    public function index()
    {
        $posts = Task::get();
        //   dd($posts);
        return view('index', compact('posts'));
    }

    public function create(Request $request)
    {
        Task::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
        ]);

        return redirect()->route('index');
    }

    public function delete($id)
    {
        Task::find($id)->delete();
        // Task::truncate(); удаляет все записи с таблицы и обнуляет автоинкремен в 0
        return redirect()->route('index');
    }

    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        Task::update(['title' => true]);
        return redirect()->route('index',$task->id);

    }

    public function test()
    {
        $posts = Task::first();
        //   dd($posts);
        return view('delete', compact('posts'));

    }


}
