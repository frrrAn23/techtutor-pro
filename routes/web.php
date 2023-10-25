<?php

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
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

Route::prefix('email')->middleware('auth')->group(function () {
    Route::get('/verify', [App\Http\Controllers\UserController::class, 'verifyEmail'])->name('verification.notice');
    Route::get('/verify/{id}/{hash}', [App\Http\Controllers\UserController::class, 'verifyEmailToken'])->middleware(['signed'])->name('verification.verify');
    Route::post('/verification-notification', [App\Http\Controllers\UserController::class, 'sendVerifyEmail'])->middleware(['throttle:6,1'])->name('verification.send');
});

Auth::routes();

Route::prefix('dashboard')->middleware(['auth', 'verified'])->name('dashboard.')->group( function () {
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

    Route::prefix('course')->name('course.')->middleware('roles:admin')->group(function () {
        Route::get('/', [App\Http\Controllers\CourseController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\CourseController::class, 'create'])->name('create');
        Route::post('/store', [App\Http\Controllers\CourseController::class, 'store'])->name('store');
        Route::get('/show/{id}', [App\Http\Controllers\CourseController::class, 'show'])->name('show');
        Route::get('/edit/{id}', [App\Http\Controllers\CourseController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [App\Http\Controllers\CourseController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [App\Http\Controllers\CourseController::class, 'destroy'])->name('delete');

        Route::prefix('{courseId}/topic')->name('topic.')->group(function () {
            Route::get('/create', [App\Http\Controllers\TopicController::class, 'create'])->name('create');
            Route::post('/store', [App\Http\Controllers\TopicController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [App\Http\Controllers\TopicController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [App\Http\Controllers\TopicController::class, 'update'])->name('update');
            Route::put('{id}/up', [App\Http\Controllers\TopicController::class, 'up'])->name('up');
            Route::put('{id}/down', [App\Http\Controllers\TopicController::class, 'down'])->name('down');
            Route::delete('/delete/{id}', [App\Http\Controllers\TopicController::class, 'delete'])->name('delete');
        });

        Route::prefix('topic/material')->name('material.')->group(function () {
            Route::get('{topicId}/create/', [App\Http\Controllers\MaterialController::class, 'create'])->name('create');
            Route::post('{topicId}/store', [App\Http\Controllers\MaterialController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [App\Http\Controllers\MaterialController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [App\Http\Controllers\MaterialController::class, 'update'])->name('update');
            Route::put('{id}/up', [App\Http\Controllers\MaterialController::class, 'up'])->name('up');
            Route::put('{id}/down', [App\Http\Controllers\MaterialController::class, 'down'])->name('down');
            Route::delete('/delete/{id}', [App\Http\Controllers\MaterialController::class, 'delete'])->name('delete');
        });
    });
});
