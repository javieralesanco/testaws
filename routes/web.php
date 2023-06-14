<?php

use App\Http\Controllers\PostContoller;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/posts', [PostContoller::class,'index'])->name('posts.index');
Route::post('/posts', [PostContoller::class,'store'])->name('posts.store');
Route::delete('/posts/{id}', [PostContoller::class,'destroy'])->name('posts.destroy');
