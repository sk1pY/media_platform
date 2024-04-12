<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
Route::get('/', [\App\Http\Controllers\TasksController::class,'index'])->name('index');
Route::get('/test', [\App\Http\Controllers\TasksController::class,'test'])->name('test');
Route::post('/store', [\App\Http\Controllers\TasksController::class,'create'])->name('create');
//Route::delete('/delete', [\App\Http\Controllers\TasksController::class,'delete'])->name('delete');
Route::delete('/delete/{id}', [\App\Http\Controllers\TasksController::class,'delete'])->name('delete');
Route::put('/update/{id}', [\App\Http\Controllers\TasksController::class,'update'])->name('update');
