<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [App\Http\Controllers\MessageController::class, 'index'])->middleware(['auth'])->name('home');

require __DIR__.'/auth.php';

Auth::routes();

Route::get('/home', [App\Http\Controllers\MessageController::class, 'index'])->name('home');

Route::get('/create-message', [App\Http\Controllers\MessageController::class, 'createMessage'])->middleware(['auth'])->name('create');
Route::post('/create-message', [App\Http\Controllers\MessageController::class, 'createMessage'])->middleware(['auth'])->name('create');
Route::get('/delete-message/{id}', [App\Http\Controllers\MessageController::class, 'deleteMessage'])->middleware(['auth'])->name('delete');
Route::get('/edit-message/{id}', [App\Http\Controllers\MessageController::class, 'editMessage'])->middleware(['auth'])->name('edit');
Route::post('/edit-message/{id}', [App\Http\Controllers\MessageController::class, 'editMessage'])->middleware(['auth'])->name('edit');
Route::get('/reply-to-message/{id}', [App\Http\Controllers\MessageController::class, 'replyToMessage'])->middleware(['auth'])->name('reply');
Route::post('/reply-to-message', [App\Http\Controllers\MessageController::class, 'replyToMessage'])->middleware(['auth'])->name('reply');