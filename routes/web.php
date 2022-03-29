<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [TasksController::class, 'index'])->name('index');
Route::post('/add', [TasksController::class, 'storeTask'])->name('task.store');
Route::delete('/{task}', [TasksController::class, 'destroyTask'])->name('task.destroy');
Route::get('/delete/{task}', [TasksController::class, 'destroyTask'])->name('task.destroy');
Route::post('/{task}', [TasksController::class, 'setStatus'])->name('task.setStatus');