<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Guest\HomeController as GuestHomeController;

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

Auth::routes();

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/', [ AdminDashboardController::class , 'home'])->name('home');
    Route::get('/posts/deleted', [PostController::class, 'deletedIndex'] )->name('posts.deleted');
    Route::post('/posts/deleted/{post}', [PostController::class, 'restore'] )->name('posts.restore');
    Route::delete('/posts/deleted/{post}', [PostController::class, 'obliterate'] )->name('posts.obliterate');
    Route::resource('/posts', PostController::class);
});

Route::name('guest.')->group(function () {
    Route::get('/', [ GuestHomeController::class , 'home'])->name('home');
});