<?php

namespace App\Http\Controllers;

use App\Models\Category;
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
        $tasks = Task::latest()->get();
        $categories = Category::get();
        return view('index', compact('tasks','categories'));
    }
    public function category_tasks($slug){
        $tasks = Task::whereHas('category', function ($query) use ($slug) {
            $query->where('name', $slug);
        })->orderBy('created_at', 'DESC')->get();


        return view('category_tasks',compact('tasks'));
    }
    public function task($id)
    {
        $task = Task::find($id);
        if ($task == null) {
            abort(404, 'error');
        }

        $comments = Comment::where('task_id', $id)->orderBy('created_at', 'desc')->get();
        return view('about_task', compact('task', 'comments'));
    }

    private const BB_VALIDATOR = [
        'title' => 'required|max:50',
        'description' => 'required',
        'image' => 'required',
        'cat_name' => 'nullable'
    ];

    public function create(Request $request)
    {
        $filePath = $request->file('image')->store('public/images');
        $validated = $request->validate(self::BB_VALIDATOR);
        $category_id = null;

        if(!empty($validated['cat_name'])){
            $category_obj = Category::where('name',$validated['cat_name'])->first();
            $category_id = $category_obj->id;
          //  Category::create(['category_id' => $category_id -> id]);
        }

        $data = Auth::user()->tasks()->create(['title' => $validated['title'],
            'description' => $validated['description'],
            'category_id' => $category_id,
            'image' => $filePath]);
        $file = $request->file('image');


        return redirect()->route('index');
    }


    public function delete($id)
    {
        Task::find($id)->delete();
        // Task::truncate(); удаляет все записи с таблицы и обнуляет автоинкремен в 0
        return redirect()->route('home');
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
