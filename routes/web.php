<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TestingController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
})->middleware('auth');

Route::get('/login', [AuthController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login/verify', [AuthController::class, 'verify']);

Route::get('/register', [AuthController::class, 'register']);
Route::post('/register', [AuthController::class, 'registerProceed']);
Route::get('/register/activation/{token}', [AuthController::class, 'registerVerify']);


Route::get('/logout', function () {
    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();
    return redirect('/login');
});

Route::group([
    'middleware' => 'auth',
    'prefix' => 'teacher'
], function () {
    Route::get('/', [TeacherController::class, 'list']);
//    Route::get('/{id}',[TeacherController::class,'detail']);
    Route::get('/add', [TeacherController::class, 'add']);
    Route::get('/edit/{id}', [TeacherController::class, 'edit']);

    Route::post('/update', [TeacherController::class, 'update']);
    Route::post('/insert', [TeacherController::class, 'insert']);
    Route::post('/delete', [TeacherController::class, 'delete']);
});
Route::group([
    'middleware' => 'auth',
    'prefix' => 'student'
], function () {
    Route::get('/', [StudentController::class, 'list']);
//    Route::get('/{id}',[TeacherController::class,'detail']);
    Route::get('/add', [StudentController::class, 'add']);
    Route::get('/edit/{id}', [StudentController::class, 'edit']);

    Route::post('/update', [StudentController::class, 'update']);
    Route::post('/insert', [StudentController::class, 'insert']);
    Route::post('/delete', [StudentController::class, 'delete']);
});

Route::group(['middleware' => 'auth', 'prefix' => 'user'], function () {
    Route::get('/change-password', [TestingController::class, 'changePassword']);

    Route::post('/change-password', [TestingController::class, 'updatePassword']);
});

Route::get('mail/test', function () {
    \Illuminate\Support\Facades\Mail::to('jokowi@gmail.com')
        ->queue(new \App\Mail\TestMail());
});














//Route::get('/latihan', function () {
//    echo "Hello World";
//});
//
//Route::get('/read/{judul}', [TestController::class, 'read']);
//
//Route::get('/test', [TestController::class, 'index']);
//
//Route::get('/teacher', [TestController::class, 'teacher']);
//
//Route::get('/student', [TestController::class, 'student']);
