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

Route::post('/like-task', [LikeController::class, 'like'])->name('like-task');


Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::put('/home/update_profile/{id}', [HomeController::class, 'update_profile'])->name('home.update.profile');
Route::put('/home/update_task/{id}', [HomeController::class, 'update_task'])->name('home.update.task');

//ADMIN_PANEL
Route::get('/admin/posts', [AdminController::class, 'all_posts_users'])->name('all.posts.users');
Route::get('/admin/cat', [AdminController::class, 'add_cat_index'])->name('cat.index');
Route::get('/admin/users', [AdminController::class, 'admin_users'])->name('users_admin');
Route::post('/admin/cat/add', [AdminController::class, 'store_cat'])->name('cat.add');

Route::group(['middleware' => 'useradmin'], function () {
    Route::get('/admin',[AdminController::class,'index']);
});
