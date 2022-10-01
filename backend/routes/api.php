<?php

use App\Http\Controllers\TaskListController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', [UserController::class, 'store'])->name('users.store');
Route::post('login', [UserController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->get('/profile', function (Request $request){
    return $request->all();
});
Route::group(['prefix' => 'v1','middleware' => ['auth:sanctum']], function () {
    
    Route::post('logout', [UserController::class, 'logout'])->name('logout');
    
    Route::apiResources([
        'tasklist'  =>  TaskListController::class,
        'tasks'     =>  TasksController::class,
    ]);

    Route::post('completedTaskList', [TaskListController::class, 'completedTaskList'])->name('tasklist.completedTaskList');

    Route::put('tasks/close/{id}', [TasksController::class, 'completedTaskList'])->name('tasks.closeTask'); 
    Route::put('list/tasks/{id}', [TasksController::class, 'tasksByList'])->name('tasks.tasksByList'); 

});