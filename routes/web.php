<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\HomeController;

//Route::resource('bbs', \App\Http\Controllers\TasksController::class);
Route::controller(TasksController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/cat/{slug}', 'category_tasks')->name('category');
    Route::get('/task/{id}', 'task')->name('about_task');
    Route::post('/store','create')->name('create');
    Route::delete('/delete/{id}', 'delete')->name('delete')->where('id', '[0-9]+');
});
Route::post('/store_comment',[CommentController::class,'store'])->name('comment.store');
Route::get('/admin',[AdminController::class,'index'])->name('admin.index');
Route::post('/admin/create_category',[AdminController::class,'store'])->name('admin.create.category');

Route::post('/like', [LikeController::class, 'store'])->name('like.store');
Route::delete('/like', [LikeController::class, 'destroy'])->name('like.destroy');



Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::put('/home/update/{id}', [HomeController::class, 'update'])->name('home.update');
