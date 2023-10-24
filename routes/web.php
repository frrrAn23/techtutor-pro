<?php

use Illuminate\Support\Facades\Auth;
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

Route::prefix('dashboard')->middleware(['auth'])->name('dashboard.')->group( function () {
    Route::get('/', App\Http\Controllers\DashboardController::class)->name('index');

    Route::group(['prefix' => 'admin', 'middleware' => ['roles:admin']], function () {
        Route::get('/', [App\Http\Controllers\UserController::class, 'getAdmin'])->name('admin.index');
        Route::get('/create', [App\Http\Controllers\UserController::class, 'createAdmin'])->name('admin.create');
        Route::post('/store', [App\Http\Controllers\UserController::class, 'storeAdmin'])->name('admin.store');
        Route::get('/edit/{id}', [App\Http\Controllers\UserController::class, 'editAdmin'])->name('admin.edit');
        Route::put('/update/{id}', [App\Http\Controllers\UserController::class, 'updateAdmin'])->name('admin.update');
        Route::delete('/delete/{id}', [App\Http\Controllers\UserController::class, 'deleteAdmin'])->name('admin.delete');
    });

    Route::group(['prefix' => 'student', 'middleware' => ['roles:admin']], function () {
        Route::get('/', [App\Http\Controllers\UserController::class, 'getStudent'])->name('student.index');
        Route::get('/create', [App\Http\Controllers\UserController::class, 'createStudent'])->name('student.create');
        Route::post('/store', [App\Http\Controllers\UserController::class, 'storeStudent'])->name('student.store');
        Route::get('/edit/{id}', [App\Http\Controllers\UserController::class, 'editStudent'])->name('student.edit');
        Route::put('/update/{id}', [App\Http\Controllers\UserController::class, 'updateStudent'])->name('student.update');
        Route::delete('/delete/{id}', [App\Http\Controllers\UserController::class, 'deleteStudent'])->name('student.delete');
    });

    Route::group(['prefix' => 'course-category', 'middleware' => ['roles:admin']], function () {
        Route::get('/', [App\Http\Controllers\CourseCategoryController::class, 'index'])->name('course-category.index');
        Route::get('/create', [App\Http\Controllers\CourseCategoryController::class, 'create'])->name('course-category.create');
        Route::post('/store', [App\Http\Controllers\CourseCategoryController::class, 'store'])->name('course-category.store');
        Route::get('/edit/{id}', [App\Http\Controllers\CourseCategoryController::class, 'edit'])->name('course-category.edit');
        Route::put('/update/{id}', [App\Http\Controllers\CourseCategoryController::class, 'update'])->name('course-category.update');
        Route::delete('/delete/{id}', [App\Http\Controllers\CourseCategoryController::class, 'destroy'])->name('course-category.delete');
    });

    Route::group(['prefix' => 'course', 'middleware' => ['roles:admin']], function () {
        Route::get('/', [App\Http\Controllers\CourseController::class, 'index'])->name('course.index');
        Route::get('/create', [App\Http\Controllers\CourseController::class, 'create'])->name('course.create');
        Route::post('/store', [App\Http\Controllers\CourseController::class, 'store'])->name('course.store');
        Route::get('/show/{id}', [App\Http\Controllers\CourseController::class, 'show'])->name('course.show');
        Route::get('/edit/{id}', [App\Http\Controllers\CourseController::class, 'edit'])->name('course.edit');
        Route::put('/update/{id}', [App\Http\Controllers\CourseController::class, 'update'])->name('course.update');
        Route::delete('/delete/{id}', [App\Http\Controllers\CourseController::class, 'destroy'])->name('course.delete');
    });
});
