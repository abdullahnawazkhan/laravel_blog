<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// including the controllers
use App\Http\Controllers\PagesController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\HomeController;

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

Route::get('/', [PagesController::class, 'index']);
Route::get('/about', [PagesController::class, 'about']);
Route::get('/services', [PagesController::class, 'services']);

Route::resource('posts', PostsController::class);

Auth::routes();
Route::get('/home', [HomeController::class, 'index'])->name('home');
