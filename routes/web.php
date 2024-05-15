<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\HomeController;

//Route::resource('bbs', \App\Http\Controllers\TasksController::class);
Route::controller(TasksController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/category/{slug}', 'category')->name('category');
    Route::get('/task/{id}', 'task')->name('about_task');
    Route::post('/store','create')->name('create');
    Route::delete('/delete/{id}', 'delete')->name('delete')->where('id', '[0-9]+');
});
Route::post('/store_comment',[CommentController::class,'store'])->name('comment.store');

//Route::fallback([\App\Http\Controllers\TasksController::class, 'error']);//Должен быть в самом конце списка

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::put('/home/update/{id}', [HomeController::class, 'update'])->name('home.update');
