<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    public function index(Request $request)
    {
        $posts = Task::get();

        return view('index', compact('posts'));
    }
    public function task($id)
    {
        $task = Task::find($id);
        if($task == null){
            abort(404,'error');
        }
        return view('about_task', compact('task'));
    }

    public function create(Request $request)
    {
        $validationRules = ['title' => 'required|max:5',
                            'description' => 'required|max:5',];
        $errorMessages = [
            'title.required' => 'Title max 10 str',
            'title.max' => 'Title max 5 str',
        ];
        $validated = $request->validate($validationRules, $errorMessages);
        Task::create($validated);


            return redirect()->route('index');
    }

    public function delete($id)
    {
        Task::find($id)->delete();
        // Task::truncate(); удаляет все записи с таблицы и обнуляет автоинкремен в 0
        return redirect()->route('index');
    }
    public function destroy_all()
    {
        Task::truncate();
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
        $posts = Task::get();
        //dd($posts);
        return view('test', compact('posts'));

    }public function error()
    {
        return 'eror';

    }


}
