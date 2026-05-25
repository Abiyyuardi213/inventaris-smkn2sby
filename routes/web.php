<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InventarisController;
use App\Http\Controllers\MutasiController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'login'])->name('login');
Route::post('/', [AuthController::class, 'authenticate'])->name('login.authenticate');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('unit-kerja', JurusanController::class)
        ->parameters(['unit-kerja' => 'jurusan'])
        ->names('jurusans');
    Route::resource('ruangans', RuanganController::class);
    Route::resource('kategoris', KategoriController::class);
    Route::resource('inventaris', InventarisController::class);
    Route::resource('mutasis', MutasiController::class);
});

