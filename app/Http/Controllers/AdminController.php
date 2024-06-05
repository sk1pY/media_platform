<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {

        return view('admin.index');
    }

    public function store(Request $request)
    {
        $cat = new Category();
        $cat->name = $request->input('name');
        $cat->save();
        return redirect('/');
    }

    public function add_cat_index(Request $request)
    {
        return view('admin.cat_add');
    }

    public function store_cat(Request $request)
    {
        $category = new Category();
        $category->name = $request->input('name');
        $category->save();
        return redirect('/admin');
    }

    public function all_posts_users()
    {
        $tasks = Task::get();
        return view('admin.cat_posts_users', ['tasks' => $tasks]);
    }

    public function admin_users()
    {

        return view('admin.users',['users' => User::get()]);
    }
}
