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
    
    Route::get('/tags/new-option', [App\Http\Controllers\User\EmployeeController::class, 'getOption'])->name('tags.option');
    Route::get('/tags/select', [App\Http\Controllers\User\EmployeeController::class, 'searchT'])->name('tags.select');
    Route::get('/departments/select', [App\Http\Controllers\User\EmployeeController::class, 'searchD'])->name('departments.select');

    Route::group(['prefix' => 'admin', 'middleware' => 'is_admin', 'as' => 'admin.'], function () {
        Route::get('/users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('users');
        Route::delete('/users/delete/{user}', [App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy');
    });
    
    Route::group(['prefix' => 'users', 'middleware' => 'is_user', 'as' => 'user.'], function () {
        Route::get('/employees', [App\Http\Controllers\User\HomeController::class, 'index'])->name('employees');
        Route::get('/departments', [App\Http\Controllers\User\HomeController::class, 'departments'])->name('departments');
        Route::get('/tags', [App\Http\Controllers\User\HomeController::class, 'tags'])->name('tags');

        // Employees

        Route::get('/employees/add', [App\Http\Controllers\User\EmployeeController::class, 'add'])->name('employees.add');
        Route::post('/employees/store', [App\Http\Controllers\User\EmployeeController::class, 'store'])->name('employees.store');

        Route::get('/employees/edit/{employee}', [App\Http\Controllers\User\EmployeeController::class, 'edit'])->name('employees.edit');
        Route::put('/employees/update/{employee}', [App\Http\Controllers\User\EmployeeController::class, 'update'])->name('employees.update');
        Route::delete('/employees/delete/{employee}', [App\Http\Controllers\User\EmployeeController::class, 'delete'])->name('employees.delete');

        

        // Departments

        Route::get('/departments/add', [App\Http\Controllers\User\DepartmentController::class, 'add'])->name('departments.add');
        Route::post('/departments/store', [App\Http\Controllers\User\DepartmentController::class, 'store'])->name('departments.store');

        Route::get('/departments/edit/{department}', [App\Http\Controllers\User\DepartmentController::class, 'edit'])->name('departments.edit');
        Route::put('/departments/update/{department}', [App\Http\Controllers\User\DepartmentController::class, 'update'])->name('departments.update');
        Route::delete('/departments/delete/{department}', [App\Http\Controllers\User\DepartmentController::class, 'delete'])->name('departments.delete');

        // Tags

        Route::get('/tags/add', [App\Http\Controllers\User\TagController::class, 'add'])->name('tags.add');
        Route::post('/tags/store', [App\Http\Controllers\User\TagController::class, 'store'])->name('tags.store');

        Route::get('/tags/edit/{tag}', [App\Http\Controllers\User\TagController::class, 'edit'])->name('tags.edit');
        Route::put('/tags/update/{tag}', [App\Http\Controllers\User\TagController::class, 'update'])->name('tags.update');
        Route::delete('/tags/delete/{tag}', [App\Http\Controllers\User\TagController::class, 'delete'])->name('tags.delete');
    });
});

Auth::routes();
Route::get('/register', function() {
    return redirect('/login');
});

Route::get('/telegram/auth', 'App\Http\Controllers\TelegramController@auth')->name('telegram.auth');


