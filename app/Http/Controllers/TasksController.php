<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    public function index(Request $request)
    {
        return view('index',['tasks' => Task::orderBy('created_at', 'desc')->get()]);
    }

    public function task($id)
    {
        $task = Task::find($id);
        if ($task == null) {
            abort(404, 'error');
        }
        return view('about_task', compact('task'));
    }
    private const BB_VALIDATOR = [
        'title' => 'required|max:50',
        'description' => 'required',
    ];
    public function create(Request $request)
    {
        $validated = $request->validate(self::BB_VALIDATOR);
       $data =  Auth::user()->tasks()->create(['title'=>$validated['title'],
            'description'=>$validated['description']]);
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
        return redirect()->route('index', $task->id);

    }

    public function error()
    {
        return 'eror';

    }


}
