<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Subscribe;
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

            $categories = Category::get();
            //сумма лайков и коментов WithCount(*****)
            $tasks = Task::withCount(['comments','likes'])->orderBy('created_at','DESC')->get();
            $likedTaskUser = Like::where('user_id', Auth::id())->pluck('task_id')->toArray();
            $bookmarkTaskUser = Bookmark::where('user_id', Auth::id())->pluck('task_id')->toArray();
            $subAuthors = Subscribe::where('subscriber_id', Auth::id())->pluck('author_id')->toArray();

            return view('index', compact('tasks','categories','likedTaskUser','bookmarkTaskUser','subAuthors'));
        }
    public function category_tasks($slug){
        $tasks = Task::whereHas('category', function ($query) use ($slug) {
            $query->where('name', $slug);
        })->orderBy('created_at', 'DESC')->get();
        return view('layouts.categories',compact('tasks'));
    }

    public function task($id)
    {
        $likedTaskUser = Like::where('user_id', Auth::id())->pluck('task_id')->toArray();
        $bookmarkTaskUser = Bookmark::where('user_id', Auth::id())->pluck('task_id')->toArray();
        //get() Всегда возращает коллекцию
        $task = Task::where('id',$id)->withCount(['comments','likes'])->first();

        if ($task == null) {
            abort(404, 'error');
        }

        $comments = Comment::where('task_id', $id)->orderBy('created_at', 'desc')->get();
        return view('about_task', compact('task', 'comments','likedTaskUser','bookmarkTaskUser'));
    }

    private const BB_VALIDATOR = [
        'title' => 'required|max:250',
        'description' => 'required',
        'image' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048', // Например, если вы принимаете изображение
        'cat_name' => 'nullable'
    ];

    public function create(Request $request)
    {

        $filePath = $request->hasFile('image') ? $request->file('image')->store('public/images') : 'public/images/def.jpg';

        if ($request->hasFile('image')) {
            $filePath = $request->file('image')->store('public');
        }         $validated = $request->validate(self::BB_VALIDATOR);
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

    public function myfeed()
    {
        $likedTaskUser = Like::where('user_id', Auth::id())->pluck('task_id')->toArray();
        $bookmarkTaskUser = Bookmark::where('user_id', Auth::id())->pluck('task_id')->toArray();
        $subAuthors = Subscribe::where('subscriber_id', Auth::id())->pluck('author_id')->toArray();

        $authors_ids = Subscribe::where('subscriber_id', Auth::id())->pluck('author_id');
        $tasks = Task::whereIn('user_id', $authors_ids)->withCount(['comments','likes'])->get();
      //  dd($tasks);

        return view('myfeed',compact('tasks','likedTaskUser','bookmarkTaskUser','subAuthors'));
    }

    public function error()
    {
        return 'eror';

    }



}
