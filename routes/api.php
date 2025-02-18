<?php

use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('register', [UserController::class, 'parent_register'])->name('parent-register');
Route::post('login', [UserController::class, 'login'])->name('login');

Route::middleware(['auth:sanctum'])->group(function() {
    Route::group(['prefix' => 'task'], function() {
        Route::post('list', [TaskController::class, 'list'])->name('task_list');
        Route::post('view/{id}', [TaskController::class, 'view'])->name('task_view');
        Route::post('create', [TaskController::class, 'create'])->name('task_create');
        Route::post('update/{id}', [TaskController::class, 'update'])->name('task_update');
        Route::post('delete/{id}', [TaskController::class, 'delete'])->name('task_delete');
    });

    Route::get('logout', [UserController::class, 'logout'])->name('logout');
});