<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
Route::get('/', [\App\Http\Controllers\TasksController::class,'index'])->name('index');
Route::post('/store', [\App\Http\Controllers\TasksController::class,'create'])->name('tasks.create');
Route::delete('/delete/{id}', [\App\Http\Controllers\TasksController::class,'delete'])->name('tasks.delete');
