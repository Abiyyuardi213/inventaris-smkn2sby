@extends('layouts.app')

@section('title', 'Dashboard - Inventaris SMKN 2 SBY')
@section('page_title', 'Dashboard')

@section('content')
    <div class="space-y-6">

        {{-- Header --}}
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-zinc-900">Selamat datang, {{ Auth::user()?->nama ?? 'User' }}</h2>
            <p class="text-sm text-zinc-500">Berikut ringkasan data inventaris SMKN 2 Surabaya.</p>
        </div>

        {{-- Metric Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

            {{-- Total Barang --}}
            <div class="rounded-lg border border-zinc-200 bg-white shadow-sm p-5">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-sm font-medium text-zinc-500">Total Barang</span>
                    <div class="flex items-center justify-center w-8 h-8 rounded-md bg-zinc-100">
                        <svg class="w-4 h-4 text-zinc-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-.375c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v.375c0 .621.504 1.125 1.125 1.125z" />
                        </svg>
                    </div>
                </div>
                <p class="text-2xl font-bold text-zinc-900">{{ number_format($totalBarang) }}</p>
                <p class="text-xs text-zinc-400 mt-1">{{ number_format($totalJenisBarang) }} jenis barang terdaftar</p>
            </div>

            {{-- Barang Baik --}}
            <div class="rounded-lg border border-emerald-200 bg-emerald-50 shadow-sm p-5">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-sm font-medium text-emerald-700">Kondisi Baik</span>
                    <div class="flex items-center justify-center w-8 h-8 rounded-md bg-emerald-100">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                </div>
                <p class="text-2xl font-bold text-emerald-800">{{ number_format($kondisiBaik) }}</p>
                <p class="text-xs text-emerald-600 mt-1">{{ number_format($persenBaik, 1) }}% dari total</p>
            </div>

            {{-- Barang Rusak --}}
            <div class="rounded-lg border border-red-200 bg-red-50 shadow-sm p-5">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-sm font-medium text-red-700">Kondisi Rusak</span>
                    <div class="flex items-center justify-center w-8 h-8 rounded-md bg-red-100">
                        <svg class="w-4 h-4 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                </div>
                <p class="text-2xl font-bold text-red-800">{{ number_format($kondisiRusak) }}</p>
                <p class="text-xs text-red-600 mt-1">{{ number_format($persenRusak, 1) }}% dari total</p>
            </div>

            {{-- Barang Layak --}}
            <div class="rounded-lg border border-amber-200 bg-amber-50 shadow-sm p-5">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-sm font-medium text-amber-700">Layak Pakai</span>
                    <div class="flex items-center justify-center w-8 h-8 rounded-md bg-amber-100">
                        <svg class="w-4 h-4 text-amber-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                        </svg>
                    </div>
                </div>
                <p class="text-2xl font-bold text-amber-800">{{ number_format($kondisiLayak) }}</p>
                <p class="text-xs text-amber-600 mt-1">{{ number_format($persenLayak, 1) }}% dari total</p>
            </div>

        </div>

        {{-- Chart + Overdue --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

            {{-- Grafik Sebaran Aset per Unit Kerja --}}
            <div class="lg:col-span-2 rounded-lg border border-zinc-200 bg-white shadow-sm p-5">
                <div class="mb-4">
                    <h3 class="text-sm font-semibold text-zinc-900">Sebaran Aset per Unit Kerja</h3>
                <p class="text-xs text-zinc-400">Distribusi total unit barang berdasarkan unit kerja</p>
                </div>
                <canvas id="chartJurusan" height="220"></canvas>
            </div>

            {{-- Notifikasi Overdue --}}
            <div class="rounded-lg border border-zinc-200 bg-white shadow-sm p-5 flex flex-col">
                <div class="mb-4">
                    <h3 class="text-sm font-semibold text-zinc-900">Peminjaman Overdue</h3>
                    <p class="text-xs text-zinc-400">Melewati batas waktu pengembalian</p>
                </div>

                <div class="space-y-3 flex-1">
                    @forelse ($overdueList as $item)
                        <div class="flex items-start gap-3 p-3 rounded-md border border-red-100 bg-red-50">
                            <div class="flex-shrink-0 mt-0.5">
                                <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-red-100">
                                    <svg class="w-3.5 h-3.5 text-red-600" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                </span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-semibold text-zinc-900 truncate">{{ $item->nama_peminjam }}</p>
                                <p class="text-xs text-zinc-500 truncate">{{ $item->inventaris?->nama_barang ?? 'Barang tidak ditemukan' }}</p>
                                <p class="text-xs text-zinc-500 truncate">{{ $item->instansi ?: 'Tanpa instansi' }} &middot; {{ number_format($item->jumlah_pinjam) }} unit</p>
                                <p class="text-xs text-red-600 mt-0.5">Jatuh tempo: {{ $item->tanggal_estimasi_kembali?->format('d M Y') ?? '-' }} <span
                                        class="font-semibold">(+{{ $item->hari_terlambat }} hari)</span></p>
                            </div>
                        </div>
                    @empty
                        <div class="flex h-full min-h-40 items-center justify-center rounded-md border border-dashed border-zinc-200 bg-zinc-50 p-6 text-center">
                            <div>
                                <p class="text-sm font-semibold text-zinc-700">Tidak ada peminjaman overdue</p>
                                <p class="mt-1 text-xs text-zinc-400">Semua peminjaman masih sesuai batas pengembalian.</p>
                            </div>
                        </div>
                    @endforelse
                </div>

                <div class="mt-4 pt-4 border-t border-zinc-100">
                    <p class="text-xs text-zinc-400 text-center">Menampilkan {{ $overdueList->count() }} peminjaman melewati batas pengembalian.
                    </p>
                </div>
            </div>

        </div>

    </div>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
    <script>
        const ctx = document.getElementById('chartJurusan').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($chartLabels),
                datasets: [{
                    label: 'Jumlah Barang',
                    data: @json($chartData),
                    backgroundColor: [
                        '#18181b', '#3f3f46', '#52525b', '#71717a',
                        '#a1a1aa', '#d4d4d8', '#e4e4e7'
                    ],
                    borderRadius: 6,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: ctx => ` ${ctx.parsed.y} unit`
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 12
                            },
                            color: '#71717a'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#f4f4f5'
                        },
                        ticks: {
                            font: {
                                size: 12
                            },
                            color: '#71717a',
                            stepSize: 10
                        }
                    }
                }
            }
        });
    </script>
@endsection
