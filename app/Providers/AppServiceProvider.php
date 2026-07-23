<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (config('app.env') === 'production' || env('FORCE_HTTPS', false)) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        // Share peminjaman alerts to navbar and dashboard
        \Illuminate\Support\Facades\View::composer(['components.navbar', 'dashboard', 'peminjamans.index', 'peminjamans.show'], function ($view) {
            try {
                if (\Illuminate\Support\Facades\Schema::hasTable('peminjamans')) {
                    // Auto-update status Peminjaman ke Terlambat jika sudah melewati estimasi kembali
                    \App\Models\Peminjaman::where('status', 'Dipinjam')
                        ->whereNotNull('tanggal_estimasi_kembali')
                        ->whereDate('tanggal_estimasi_kembali', '<', now()->toDateString())
                        ->update(['status' => 'Terlambat']);

                    $today = now()->startOfDay();
                    $threeDaysFromNow = now()->addDays(3)->endOfDay();

                    $overdue = \App\Models\Peminjaman::with('inventaris')
                        ->whereIn('status', ['Dipinjam', 'Terlambat'])
                        ->whereNotNull('tanggal_estimasi_kembali')
                        ->whereDate('tanggal_estimasi_kembali', '<', $today)
                        ->orderBy('tanggal_estimasi_kembali')
                        ->get()
                        ->map(function ($item) {
                            $item->hari_terlambat = (int) $item->tanggal_estimasi_kembali->startOfDay()->diffInDays(now()->startOfDay());
                            return $item;
                        });

                    $approaching = \App\Models\Peminjaman::with('inventaris')
                        ->whereIn('status', ['Dipinjam', 'Terlambat'])
                        ->whereNotNull('tanggal_estimasi_kembali')
                        ->whereBetween('tanggal_estimasi_kembali', [$today, $threeDaysFromNow])
                        ->orderBy('tanggal_estimasi_kembali')
                        ->get()
                        ->map(function ($item) {
                            $item->sisa_hari = (int) now()->startOfDay()->diffInDays($item->tanggal_estimasi_kembali->startOfDay(), false);
                            return $item;
                        });

                    $view->with('peminjamanAlerts', [
                        'overdue' => $overdue,
                        'approaching' => $approaching,
                        'count' => $overdue->count() + $approaching->count(),
                    ]);
                } else {
                    $view->with('peminjamanAlerts', [
                        'overdue' => collect(),
                        'approaching' => collect(),
                        'count' => 0,
                    ]);
                }
            } catch (\Exception $e) {
                $view->with('peminjamanAlerts', [
                    'overdue' => collect(),
                    'approaching' => collect(),
                    'count' => 0,
                ]);
            }
        });
    }
}
