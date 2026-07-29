<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\JenisModalController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\InventarisImportController;
use App\Http\Controllers\InventarisController;
use App\Http\Controllers\MutasiController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengadaanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ApprovalKepsekController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'login'])->name('login');
Route::post('/', [AuthController::class, 'authenticate'])->name('login.authenticate');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware('permission:dashboard.view')
        ->name('dashboard');

    Route::middleware('permission:roles.manage')->group(function () {
        Route::resource('roles', RoleController::class);
        Route::get('roles/{role}/permissions', [RoleController::class, 'permissions'])->name('roles.permissions');
        Route::put('roles/{role}/permissions', [RoleController::class, 'updatePermissions'])->name('roles.permissions.update');
    });
    Route::resource('users', UserController::class)->middleware('permission:users.manage');
    Route::resource('unit-kerja', JurusanController::class)
        ->parameters(['unit-kerja' => 'jurusan'])
        ->names('jurusans')
        ->middleware('permission:jurusans.manage');
    Route::get('monitor-ruang', [RuanganController::class, 'monitor'])
        ->middleware('permission:monitor-ruang.view')
        ->name('ruangans.monitor');
    Route::get('monitor-ruang/{ruangan}/print-aset', [RuanganController::class, 'printAssets'])
        ->middleware('permission:monitor-ruang.view')
        ->name('ruangans.monitor.print-assets');
    Route::resource('ruangans', RuanganController::class)->middleware('permission:ruangans.manage');
    Route::resource('jenis-modals', JenisModalController::class)->middleware('permission:jenis_modals.manage');
    Route::resource('kategoris', KategoriController::class)->middleware('permission:kategoris.manage');
    Route::middleware('permission:inventaris.manage')->group(function () {
        Route::get('inventaris/import', [InventarisImportController::class, 'create'])->name('inventaris.imports.create');
        Route::post('inventaris/import', [InventarisImportController::class, 'store'])->name('inventaris.imports.store');
        Route::get('inventaris/import/{batch}', [InventarisImportController::class, 'show'])->name('inventaris.imports.show');
        Route::get('inventaris/import/{batch}/rows/{row}/edit', [InventarisImportController::class, 'editRow'])->name('inventaris.imports.rows.edit');
        Route::put('inventaris/import/{batch}/rows/{row}', [InventarisImportController::class, 'updateRow'])->name('inventaris.imports.rows.update');
        Route::patch('inventaris/import/{batch}/approve', [InventarisImportController::class, 'approve'])->name('inventaris.imports.approve');
        Route::patch('inventaris/import/{batch}/reject', [InventarisImportController::class, 'reject'])->name('inventaris.imports.reject');
        Route::get('inventaris/template/{format}', [InventarisImportController::class, 'template'])
            ->whereIn('format', ['xlsx'])
            ->name('inventaris.template');
        Route::get('inventaris/export/{format}', [InventarisImportController::class, 'export'])
            ->whereIn('format', ['xlsx'])
            ->name('inventaris.export');
        Route::get('inventaris/print-pdf', [InventarisController::class, 'printPdf'])->name('inventaris.print-pdf');
        Route::get('inventaris/print-kib-b', [InventarisController::class, 'printKibB'])->name('inventaris.print-kib-b');
        Route::get('inventaris/print-kib-c', [InventarisController::class, 'printKibC'])->name('inventaris.print-kib-c');
        Route::get('inventaris/print-kib-e', [InventarisController::class, 'printKibE'])->name('inventaris.print-kib-e');
        Route::get('inventaris/print-buku-induk', [InventarisController::class, 'printBukuInduk'])->name('inventaris.print-buku-induk');
        Route::get('inventaris/print-label-bulk', [InventarisController::class, 'printLabelBulk'])->name('inventaris.print-label-bulk');
        Route::get('inventaris/scan', [InventarisController::class, 'scan'])->name('inventaris.scan');
        Route::get('inventaris/scan/resolve', [InventarisController::class, 'resolveScan'])->name('inventaris.scan.resolve');
        Route::get('inventaris/{inventari}/print-label', [InventarisController::class, 'printLabel'])->name('inventaris.print-label');
        Route::post('inventaris/{inventari}/regenerate-qr', [InventarisController::class, 'regenerateQr'])->name('inventaris.regenerate-qr');
        Route::delete('inventaris/destroy-bulk', [InventarisController::class, 'destroyBulk'])->name('inventaris.destroy-bulk');
        Route::delete('inventaris/destroy-all', [InventarisController::class, 'destroyAll'])->name('inventaris.destroy-all');
        Route::resource('inventaris', InventarisController::class);
    });
    Route::resource('mutasis', MutasiController::class)->middleware('permission:mutasis.manage');
    Route::post('peminjamans/{peminjaman}/kembalikan', [PeminjamanController::class, 'kembalikan'])->name('peminjamans.kembalikan')->middleware('permission:peminjamans.manage');
    Route::resource('peminjamans', PeminjamanController::class)->middleware('permission:peminjamans.manage');

    // Route pengadaan — semua user yang sudah login
    Route::resource('pengadaans', PengadaanController::class)->middleware('permission:pengadaans.manage');

    // Route approval — sesuai hak akses role
    Route::middleware('permission:approvals.manage')
        ->prefix('approvals')
        ->name('approvals.')
        ->group(function () {
            Route::get('/', [ApprovalController::class, 'index'])->name('index');
            Route::patch('/{pengadaan}/approve', [ApprovalController::class, 'approve'])->name('approve');
            Route::patch('/{pengadaan}/tolak', [ApprovalController::class, 'tolak'])->name('tolak');
        });

    // Route approval Kepsek — khusus role kepala-sekolah
    Route::middleware('role:kepala-sekolah')->prefix('approvals-kepsek')->name('approvals-kepsek.')->group(function () {
        Route::get('/', [ApprovalKepsekController::class, 'index'])->name('index');
        Route::get('/riwayat', [ApprovalKepsekController::class, 'riwayat'])->name('riwayat');
        Route::patch('/{pengadaan}/approve', [ApprovalKepsekController::class, 'approve'])->name('approve');
        Route::patch('/{pengadaan}/tolak', [ApprovalKepsekController::class, 'tolak'])->name('tolak');
    });
});
