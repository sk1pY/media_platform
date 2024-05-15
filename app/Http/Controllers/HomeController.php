<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home',['tasks' => Auth::user()->tasks()->latest()->get()]);

    }

    public function update(Request $request,Task $task)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:50',
            'description' => 'required|string|max:255',
            'image' => 'required|nullable',
        ]);
       // $task = Task::find($id);
        $task->fill(['title'=>$validatedData['title'],
            'description'=> $validatedData['description'],
            'image' => $validatedData['image'],]);
        $task->save();
      //  dd($task);
        return redirect('/home');

    }
}
