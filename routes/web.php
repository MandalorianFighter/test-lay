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

Route::group(['middleware' => 'auth'], function () {

    Route::group(['prefix' => 'admin', 'middleware' => 'is_admin', 'as' => 'admin.'], function () {
        Route::get('/users', 'App\Http\Controllers\Admin\UserController@index')->name('users.index');
        Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    });
    Route::group(['prefix' => 'users', 'middleware' => 'is_user', 'as' => 'user.'], function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    });
});

Auth::routes();


