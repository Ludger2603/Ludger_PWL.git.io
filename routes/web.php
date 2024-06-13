<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BkuserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ItemTrasactionController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\MotorController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SyaratSewaController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TestingController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
})->middleware('auth');

Route::get('/login', [AuthController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login/verify', [AuthController::class, 'verify'])->name('verify');

Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'registerProceed']);
Route::get('/register/activation/{token}', [AuthController::class, 'registerVerify']);


Route::get('/logout', function () {
    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();
    return redirect('/login');
});

Route::group(['middleware' => 'auth', 'prefix' => 'user'], function () {
    Route::get('/change-password', [TestingController::class, 'changePassword'])->name('change.password');

    Route::post('/change-password', [TestingController::class, 'updatePassword'])->name('update.password');
});

Route::get('mail/test', function () {
    \Illuminate\Support\Facades\Mail::to('jokowi@gmail.com')
        ->queue(new \App\Mail\TestMail());
});

Route::group(['prefix'=>'app','middleware'=>['auth','admin']], function (){
    Route::get('/',[BookingController::class,'index']);
    Route::post('/search-barcode',[BookingController::class,'searchProduct']);
    Route::post('/insert', [BookingController::class, 'insert']);
    Route::post('/delete', [BookingController::class, 'delete']);
    Route::delete('/table/clear', [BookingController::class,'clearTable'])->name('table.clear');

});

Route::group([
    'middleware' => ['auth','superadmin'],
    'prefix' => 'motor'
], function () {
    Route::get('/', [MotorController::class, 'list']);
//    Route::get('/{id}',[TeacherController::class,'detail']);
    Route::get('/add', [MotorController::class, 'add']);
    Route::get('/edit/{id}', [MotorController::class, 'edit']);

    Route::post('/update', [MotorController::class, 'update']);
    Route::post('/insert', [MotorController::class, 'insert']);
    Route::post('/delete', [MotorController::class, 'delete']);
});
Route::group([
    'middleware' => ['auth','superadmin'],
    'prefix' => 'syarat'
], function () {
    Route::get('/', [SyaratSewaController::class, 'list']);
//    Route::get('/{id}',[TeacherController::class,'detail']);
    Route::get('/add', [SyaratSewaController::class, 'add']);
    Route::get('/edit/{id}', [SyaratSewaController::class, 'edit']);

    Route::post('/update', [SyaratSewaController::class, 'update']);
    Route::post('/insert', [SyaratSewaController::class, 'insert']);
    Route::post('/delete', [SyaratSewaController::class, 'delete']);
});
Route::group([
    'middleware' => ['auth','superadmin'],
    'prefix' => 'pesanan'
], function () {
    Route::get('/', [BkuserController::class, 'list']);
    Route::get('/keranjang', [BkuserController::class, 'pesanan']);
//    Route::get('/{id}',[TeacherController::class,'detail']);
    Route::get('/add', [BkuserController::class, 'add']);
    Route::get('/edit/{id}', [BkuserController::class, 'edit']);

    Route::post('/update', [BkuserController::class, 'update']);
    Route::post('/insert', [BkuserController::class, 'insert']);
    Route::post('/delete', [BkuserController::class, 'delete']);
});
Route::group([
    'middleware' => ['auth'],
    'prefix' => 'pesanan'
], function () {
    Route::get('/keranjang', [BkuserController::class, 'pesanan']);
//    Route::get('/{id}',[TeacherController::class,'detail']);
    Route::get('/add', [BkuserController::class, 'add']);
    Route::get('/edit/{id}', [BkuserController::class, 'batal']);

    Route::post('/batal', [BkuserController::class, 'batal']);
    Route::post('/insert', [BkuserController::class, 'insert']);
});
Route::group([
    'middleware' => ['auth'],
    'prefix' => 'user'
], function () {
    Route::get('/', [UserController::class, 'list']);
//    Route::get('/{id}',[TeacherController::class,'detail']);
    Route::get('/add', [UserController::class, 'add']);
    Route::get('/edit/{id}', [UserController::class, 'edit']);
    Route::get('/profil', [UserController::class, 'profil'])->name('profil.index');
    Route::get('/export/excel',[UserController::class,'excel'])->name('export.excel');

    Route::post('/update', [UserController::class, 'update']);
    Route::post('/insert', [UserController::class, 'insert']);
    Route::post('/delete', [UserController::class, 'delete']);
});

Route::group([
    'middleware' => ['auth','superadmin'],
    'prefix' => 'transaksi'
], function () {
    Route::get('/',[TransactionController::class, 'index']);
    Route::get('/{id}/pdf',[TransactionController::class, 'printPDF']);
    Route::delete('/table/clear', [TransactionController::class, 'clearTable'])->name('table.trans');

});
Route::group([
    'middleware' => ['auth','superadmin'],
    'prefix' => 'itemtransactions'
], function () {
    Route::get('/',[ItemTrasactionController::class, 'index']);
    Route::get('/{id}/pdf',[ItemTrasactionController::class, 'printPDF']);
});
Route::middleware('auth')->get('/dashboard/profile/{id}', [ProfileController::class, 'show'])->name('profile.show');

Route::get('/dashboard',[DashboardController::class,'index'])->middleware('auth');

Route::get('files/{filename}', function ($filename){
    $path = storage_path('app/public/images/' . $filename);
    if (!File::exists($path)) {
     abort(404);
    }
    $file = File::get($path);
    $type = File::mimeType($path);
    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);
    return $response;
})->name('storage');














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
