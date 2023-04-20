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
        Route::get('/users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('users');
        Route::get('/activity', [App\Http\Controllers\Admin\ActivityController::class, 'index'])->name('activity');
        Route::get('/data-source/activity', [App\Http\Controllers\Admin\ActivityController::class, 'dataActivity'])->name('activity.data');
        Route::get('/users/select', [App\Http\Controllers\Admin\ActivityController::class, 'searchU'])->name('users.select');
    });
    
    Route::group(['prefix' => 'users', 'middleware' => 'is_user', 'as' => 'user.'], function () {
        Route::get('/employees', [App\Http\Controllers\User\EmployeeController::class, 'index'])->name('employees');
        Route::get('/departments', [App\Http\Controllers\User\DepartmentController::class, 'index'])->name('departments');
        Route::get('/tags', [App\Http\Controllers\User\TagController::class, 'index'])->name('tags');

        // Employees

        Route::get('/employees/add', [App\Http\Controllers\User\EmployeeController::class, 'add'])->name('employees.add');
        Route::post('/employees/store', [App\Http\Controllers\User\EmployeeController::class, 'store'])->name('employees.store');
        Route::get('/employees/edit/{employee}', [App\Http\Controllers\User\EmployeeController::class, 'edit'])->name('employees.edit');
        Route::put('/employees/update/{employee}', [App\Http\Controllers\User\EmployeeController::class, 'update'])->name('employees.update');
        Route::delete('/employees/delete/{employee}', [App\Http\Controllers\User\EmployeeController::class, 'delete'])->name('employees.delete');

        // Employees ajax

        Route::get('/tags/new-option', [App\Http\Controllers\User\EmployeeController::class, 'getOption'])->name('tags.option');
        Route::get('/tags/select', [App\Http\Controllers\User\EmployeeController::class, 'searchT'])->name('tags.select');
        Route::get('/departments/select', [App\Http\Controllers\User\EmployeeController::class, 'searchD'])->name('departments.select');
        Route::get('/data-source/employees', [App\Http\Controllers\User\EmployeeController::class, 'dataEmployee'])->name('employees.data');
       
        // Departments

        Route::get('/departments/add', [App\Http\Controllers\User\DepartmentController::class, 'add'])->name('departments.add');
        Route::post('/departments/store', [App\Http\Controllers\User\DepartmentController::class, 'store'])->name('departments.store');

        Route::get('/departments/edit/{department}', [App\Http\Controllers\User\DepartmentController::class, 'edit'])->name('departments.edit');
        Route::post('/departments/update/{department}', [App\Http\Controllers\User\DepartmentController::class, 'update'])->name('departments.update');
        Route::delete('/departments/delete/{department}', [App\Http\Controllers\User\DepartmentController::class, 'delete'])->name('departments.delete');

        // Departments Ajax

        Route::get('/data-source/departments', [App\Http\Controllers\User\DepartmentController::class, 'dataDepartment'])->name('departments.data');

        // Tags

        Route::get('/tags/add', [App\Http\Controllers\User\TagController::class, 'add'])->name('tags.add');
        Route::post('/tags/store', [App\Http\Controllers\User\TagController::class, 'store'])->name('tags.store');

        Route::get('/tags/edit/{tag}', [App\Http\Controllers\User\TagController::class, 'edit'])->name('tags.edit');
        Route::put('/tags/update/{tag}', [App\Http\Controllers\User\TagController::class, 'update'])->name('tags.update');
        Route::delete('/tags/delete/{tag}', [App\Http\Controllers\User\TagController::class, 'delete'])->name('tags.delete');

        // Departments Ajax

        Route::get('/data-source/tags', [App\Http\Controllers\User\TagController::class, 'dataTag'])->name('tags.data');

        // User Log Datatable

        Route::get('/user-log', [App\Http\Controllers\User\UserLogController::class, 'index'])->name('user-log');
        Route::get('/data-source/user-log', [App\Http\Controllers\User\UserLogController::class, 'dataUserLog'])->name('user-log.data');
    });
});

Auth::routes();
Route::get('/register', function() {
    return redirect('/login');
});

Route::get('/telegram/auth', 'App\Http\Controllers\TelegramController@auth')->name('telegram.auth');

