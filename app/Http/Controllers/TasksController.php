<?php

namespace App\Http\Controllers;
use Illuminate\Validation\Validator;
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
        $validationRules = ['title' => 'required|alpha|max:10',
                            'description' => 'required|max:15',];
        //alpha — строка, содержащая только буквы;
        //alpha_num — строка, содержащая только буквы и цифры;
//        email[:<валидаторы через запятую>] — адрес электронной почты. В параметре можно указать следующие валидаторы электронной почты, используемые для проверки
//адреса:
//• rfc — обычная проверка соответствия адреса стандартам (его существование
//в реальности не проверяется);
//• strict — аналогично rfc, но проверка более строгая;
//• dns — проверяет, существует ли почтовый сервер, присутствующий в заданном
//адресе, на самом деле;
//• spoof — проверяет, не присутствуют ли в адресе недопустимые символы;
//• filter — использует средства валидации адресов, встроенные в PHP.
    $errorMessages = [
            'title.required' => 'Введите название заголовка',
            'title.max' => 'максимальное количество букв 10',
            'title.alpha' => 'цифры запрещены',
        ];
        $validated = $request->validate($validationRules, $errorMessages);
            Task::create($validated);
        return redirect()->route('index')->with('success', 'Post created successfully.');
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
