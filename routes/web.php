<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\MedicineController;

Route::get('/', function (){
    return view('login');
})->name('login');
Route::post('/login', [AuthController::class, 'index'])->name('login');
Route::post('/postLogin', [AuthController::class, 'login'])->name('postlogin');
Route::get('/logout', [AuthController::class, 'signOut'])->name('logout');

Route::get('/error-permission',function() {
    return view ('errors.permission');
})->name('error.permission');

Route::post('/login', [UserController::class, 'loginAuth'])->name('login.auth');

Route::get('/logout', [AuthController::class, 'signOut'])->name('logout');

// Route::middleware('IsAdmin')->group(function (){

Route::prefix('/medicine')->name('medicine.')->middleware('auth')->group(function() {
    Route::get('/create', [MedicineController::class, 'create'])->name('create');
    Route::post('/store', [MedicineController::class, 'store'])->name('store');
    Route::get('/', [MedicineController::class, 'index'])->name('index');
    Route::get('/stock', [MedicineController::class, 'stock'])->name('stock');
    Route::get('/stock/{id}', [MedicineController::class, 'stockEdit'])->name('stock.edit');
    Route::patch('/stock/{id}', [MedicineController::class, 'stockUpdate'])->name('stock.update');
    Route::get('/{id}', [MedicineController::class, 'edit'])->name('edit');
    Route::patch('/{id}', [MedicineController::class, 'update'])->name('update');
    Route::delete('/{id}', [MedicineController::class, 'destroy'])->name('destroy');

});

Route::prefix('/pengguna')->name('pengguna.')->group(function() {
    Route::get('/', [UserController::class, 'index'])->name('index');

    Route::get('/create', [UserController::class, 'create'])->name('create');
    Route::post('/store', [UserController::class, 'store'])->name('store');

    Route::get('/{id}', [UserController::class, 'edit'])->name('edit');
    Route::patch('/{id}', [UserController::class, 'update'])->name('update');
    Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');

});
Route::prefix('/order')->name('order.')->group(function(){
    Route::get('/data', [OrderController::class, 'data'])->name('data');
    Route::get('/export-excel', [OrderController::class, 'exportExcel'])->name('export-excel');
});
// });
    Route::middleware('IsKasir')->group(function (){
        Route::prefix('/kasir')->name('kasir.')->group(function(){
            Route::prefix('/order')->name('order.')->group(function() {
                Route::get('/', [OrderController::class, 'index'])->name('index');
                Route::get('/create', [OrderController::class, 'create'])->name('create');
                Route::post('/store', [OrderController::class, 'store'])->name('store');
                Route::get('/print/id', [OrderController::class, 'show'])->name('print');
                Route::get('download/{id}', [OrderController::class, 'downloadPDF' ])->name('download');
            });
        });
    });