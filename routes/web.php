<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TestingController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
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
    'middleware' => ['auth','admin'],
    'prefix' => 'teacher'
], function () {
    Route::get('/', [TeacherController::class, 'list']);
    Route::get('/add', [TeacherController::class, 'add']);
    Route::get('/edit/{id}', [TeacherController::class, 'edit'])->middleware('superadmin');
    Route::get('/export/excel',[TeacherController::class,'excel'])->name('export.excel');

    Route::post('/update', [TeacherController::class, 'update'])->middleware('superadmin');
    Route::post('/insert', [TeacherController::class, 'insert']);
    Route::post('/delete', [TeacherController::class, 'delete'])->middleware('superadmin');
});

Route::group([
    'middleware' => ['auth','admin'],
    'prefix' => 'student'
], function () {
    Route::get('/', [StudentController::class, 'list']);
//    Route::get('/{id}',[TeacherController::class,'detail']);
    Route::get('/add', [StudentController::class, 'add']);
    Route::get('/edit/{id}', [StudentController::class, 'edit'])->middleware('superadmin');

    Route::post('/update', [StudentController::class, 'update'])->middleware('superadmin');
    Route::post('/insert', [StudentController::class, 'insert']);
    Route::post('/delete', [StudentController::class, 'delete'])->middleware('superadmin');
});

Route::group(['middleware' => 'auth', 'prefix' => 'user'], function () {
    Route::get('/change-password', [TestingController::class, 'changePassword']);

    Route::post('/change-password', [TestingController::class, 'updatePassword']);
});

Route::get('mail/test', function () {
    \Illuminate\Support\Facades\Mail::to('jokowi@gmail.com')
        ->queue(new \App\Mail\TestMail());
});

Route::group(['prefix'=>'app','middleware'=>'auth'], function (){
    Route::get('/',[KasirController::class,'index']);
    Route::post('/search-barcode',[KasirController::class,'searchProduct']);
    Route::post('/insert', [KasirController::class, 'insert']);
});

Route::group([
    'middleware' => 'auth',
    'prefix' => 'product'
], function () {
    Route::get('/', [ProductController::class, 'list']);
//    Route::get('/{id}',[TeacherController::class,'detail']);
    Route::get('/add', [ProductController::class, 'add']);
    Route::get('/edit/{id}', [ProductController::class, 'edit']);

    Route::post('/update', [ProductController::class, 'update']);
    Route::post('/insert', [ProductController::class, 'insert']);
    Route::post('/delete', [ProductController::class, 'delete']);
});
Route::group([
    'middleware' => 'auth',
    'prefix' => 'transaksi'
], function () {
    Route::get('/',[TransactionController::class, 'index']);
    Route::get('/{id}/pdf',[TransactionController::class, 'printPDF']);
});

Route::get('/dashboard',[DashboardController::class,'index'])->middleware('auth');













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
