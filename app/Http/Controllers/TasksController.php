<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    public function index()
    {
        $data = ['tasks' => Task::latest()->get()];
        return view('index',$data);
    }
    public function category()
    {

    }
    public function task($id)
    {
        $task = Task::find($id);
        if ($task == null) {
            abort(404, 'error');
        }

        $comments = Comment::where('task_id', $id)->orderBy('created_at', 'desc')->get();


        return view('about_task', compact('task','comments'));
    }

    private const BB_VALIDATOR = [
        'title' => 'required|max:50',
        'description' => 'required',
        'image' => 'required',
    ];
    public function create(Request $request)
    {
        $filePath = $request->file('image')->store('public/images');
      //  dd($filePath);

        //  dd($pic);
        $validated = $request->validate(self::BB_VALIDATOR);
       $data =  Auth::user()->tasks()->create(['title'=>$validated['title'],
            'description'=>$validated['description'],
            'image'=>$filePath]);
        $file = $request->file('image');



        return redirect()->route('index');
    }


    public function delete($id)
    {
        Task::find($id)->delete();
        // Task::truncate(); удаляет все записи с таблицы и обнуляет автоинкремен в 0
        return redirect()->route('index');
    }

    public function update($id)
    {
        $task = Task::findOrFail($id);

        Task::update(['title' => true]);
        return redirect()->route('index', $task->id);

    }


    public function error()
    {
        return 'eror';

    }


}
