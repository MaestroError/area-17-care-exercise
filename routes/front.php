<?php

use App\Http\Controllers\Front\UserController;
use App\Http\Controllers\Front\PostController;
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

Route::get('/', [PostController::class, 'index'])->name('home');
Route::get('/{user}/{post}', [PostController::class, 'show'])->name('posts.show');
Route::get('/{user}', [UserController::class, 'show'])->name('users.show');
