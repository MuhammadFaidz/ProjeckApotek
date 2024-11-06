<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('users.login');
})->name('login');

Route::get('/error-permission', function() {
    return view('error.permission');
})->name('error.permission');

// Route::middleware(['Islogin'])->group(functio() {
//     Route::get('/home', function() {
//         return view('home.page');
//     })->name('home');
// });

Route::get('/home', [UserController::class, 'home'])->name('home.page');
Route::post('/login', [UserController::class, 'loginAuth'])->name('login.auth');

Route::middleware(['Islogin',  'IsAdmin'])->group(function () {
Route::get('/logout', [UserController::class, 'logout'])->name('logout');


    Route::prefix('/medicines')->name('medicines.')->group(function () {
        Route::get('/add', [MedicineController::class, 'create'])->name('create');
        Route::post('/add', [MedicineController::class, 'store'])->name('store');
        Route::get('/', [MedicineController::class, 'index'])->name('index');
        Route::delete('/delete/{id}', [MedicineController::class, 'destroy'])->name('delete');
        Route::get('/edit/{id}', [MedicineController::class, 'edit'])->name('edit');
        Route::patch('/edit/{id}', [MedicineController::class, 'update'])->name('update');
        Route::patch('/edit/stock/{id}', [MedicineController::class, 'updateStock'])->name('update.stock');
    });

    Route::prefix('/users')->name('user.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('home');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/store', [UserController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('edit');
        Route::patch('/update/{id}', [UserController::class, 'update'])->name('update');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('delete');
    });
    
});

// Route::get('/pembelian', [OrderController::class, 'index'])->name('pembelian');
// Route::get('/create/pembelian', [OrderController::class, 'create'])->name('tambah.pembelian');

Route::middleware(['Islogin', 'IsKasir'])->group(function () {
    Route::prefix('/kasir')->name('kasir.')->group(function () {
        Route::prefix('/order')->name('order.')->group(function () {
            Route::get('/pembelian', [OrderController::class, 'index'])->name('pembelian');
            Route::get('/create/pembelian', [OrderController::class, 'create'])->name('tambah.pembelian');
            Route::post('/store', [OrderController::class, 'store'])->name('store');
            Route::get('/print/{id}', [OrderController::class, 'show'])->name('print');
        }); 
    });
});