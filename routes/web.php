<?php

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('dashboard')->name("dashboard.")->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('index');

    Route::prefix('projects')->middleware(["auth"])->name("projects.")->group(function () {
        Route::get('/', [App\Http\Controllers\ProjectController::class, 'index'])->name('index');
        Route::get('create', [App\Http\Controllers\ProjectController::class, 'create'])->name('create');
        Route::post('create', [App\Http\Controllers\ProjectController::class, 'store'])->name('create');
        Route::get('{project}', [App\Http\Controllers\ProjectController::class, 'show'])->name('show')->whereNumber('id');
    });
});
