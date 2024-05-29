<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(){

        return view('admin.index');
    }
    public function store(Request $request){
        $cat = new Category();
        $cat->name = $request->input('name');
        $cat->save();
        return redirect('/');
    }
}
