<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\PengadaanController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'login'])->name('login');
Route::post('/', [AuthController::class, 'authenticate'])->name('login.authenticate');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('jurusans', JurusanController::class);
    Route::resource('ruangans', RuanganController::class);
    Route::resource('kategoris', KategoriController::class);

    // Route pengadaan — semua user yang sudah login
    Route::resource('pengadaans', PengadaanController::class);

    // Route approval — khusus Super Admin
    Route::middleware('role:super-admin')
        ->prefix('approvals')
        ->name('approvals.')
        ->group(function () {
            Route::get('/', [ApprovalController::class, 'index'])->name('index');
            Route::patch('/{pengadaan}/approve', [ApprovalController::class, 'approve'])->name('approve');
            Route::patch('/{pengadaan}/tolak', [ApprovalController::class, 'tolak'])->name('tolak');
        });
});
