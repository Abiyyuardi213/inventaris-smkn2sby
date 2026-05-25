@extends('layouts.app')

@section('title', 'Detail Inventaris - Inventaris SMKN 2 SBY')
@section('page_title', 'Detail Inventaris')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <!-- Back link and Title -->
    <div>
        <a href="{{ route('inventaris.index') }}" class="inline-flex items-center gap-1.5 text-sm text-zinc-500 hover:text-zinc-950 transition-colors mb-2">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
            </svg>
            Kembali ke Daftar Inventaris
        </a>
        <h2 class="text-2xl font-bold tracking-tight text-zinc-900">Detail Inventaris</h2>
        <p class="text-sm text-zinc-500">Informasi lengkap rincian aset barang yang terdaftar.</p>
    </div>

    <!-- Details Card -->
    <div class="rounded-lg border border-zinc-200 bg-white p-6 shadow-sm space-y-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <!-- Kode Inventaris -->
            <div>
                <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider block mb-1">Kode Inventaris</span>
                <span class="inline-flex items-center rounded-md bg-zinc-100 px-2.5 py-1 text-sm font-mono font-semibold text-zinc-800 border border-zinc-200">
                    {{ $inventaris->kode_inventaris }}
                </span>
            </div>

            <!-- Nama Barang -->
            <div>
                <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider block mb-1">Nama Barang</span>
                <span class="text-lg font-medium text-zinc-900 block leading-tight">{{ $inventaris->nama_barang }}</span>
                <span class="text-xs text-zinc-400">Merek: {{ $inventaris->merek }}</span>
            </div>

            <!-- Kategori -->
            <div>
                <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider block mb-1">Kategori</span>
                <span class="text-sm text-zinc-700 block font-medium">{{ $inventaris->kategori->nama_kategori }}</span>
            </div>

            <!-- Qty & Kondisi -->
            <div>
                <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider block mb-1">Jumlah & Kondisi</span>
                <div class="flex items-center gap-2">
                    <span class="text-sm text-zinc-800 font-semibold">{{ $inventaris->jumlah_total }} Unit</span>
                    <span>&bull;</span>
                    @if($inventaris->kondisi === 'baik')
                        <span class="inline-flex items-center rounded-md bg-emerald-50 px-2 py-0.5 text-xs font-medium text-emerald-700 border border-emerald-200/50">
                            Baik
                        </span>
                    @elseif($inventaris->kondisi === 'layak')
                        <span class="inline-flex items-center rounded-md bg-amber-50 px-2 py-0.5 text-xs font-medium text-amber-700 border border-amber-200/50">
                            Layak Pakai
                        </span>
                    @else
                        <span class="inline-flex items-center rounded-md bg-red-50 px-2 py-0.5 text-xs font-medium text-red-700 border border-red-200/50">
                            Rusak
                        </span>
                    @endif
                </div>
            </div>

            <!-- Unit Kerja -->
            <div>
                <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider block mb-1">Unit Kerja</span>
                <span class="text-sm text-zinc-700 block">{{ $inventaris->jurusan->nama_jurusan }}</span>
            </div>

            <!-- Ruangan -->
            <div>
                <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider block mb-1">Ruangan / Tempat</span>
                <span class="text-sm text-zinc-700 block">{{ $inventaris->ruangan->nama_ruangan }}</span>
            </div>

            <!-- Tanggal Pengadaan -->
            <div>
                <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider block mb-1">Tanggal Pengadaan</span>
                <span class="text-sm text-zinc-700 block font-medium">
                    {{ $inventaris->tanggal_pengadaan->format('d F Y') }}
                </span>
            </div>

            <!-- Timestamps -->
            <div>
                <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider block mb-1">Terakhir Diperbarui</span>
                <span class="text-xs text-zinc-500 block">
                    {{ $inventaris->updated_at->format('d M Y, H:i') }} (terdaftar: {{ $inventaris->created_at->format('d M Y') }})
                </span>
            </div>

            <!-- Spesifikasi (Full Width) -->
            <div class="sm:col-span-2 border-t border-zinc-100 pt-6">
                <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider block mb-2">Spesifikasi Detail</span>
                <div class="rounded-lg bg-zinc-50 p-4 border border-zinc-200/60 text-sm text-zinc-700 font-sans whitespace-pre-line leading-relaxed">
                    {{ $inventaris->spesifikasi }}
                </div>
            </div>
        </div>

        <!-- Card Actions -->
        <div class="flex items-center justify-end gap-3 pt-6 border-t border-zinc-100">
            <a href="{{ route('inventaris.index') }}" class="inline-flex items-center justify-center rounded-md border border-zinc-200 text-zinc-700 hover:text-zinc-950 bg-white hover:bg-zinc-50 h-10 px-4 py-2 text-sm font-medium shadow-sm transition-all duration-150">
                Kembali
            </a>
            <a href="{{ route('inventaris.edit', $inventaris->id) }}" class="inline-flex items-center justify-center rounded-md bg-zinc-900 text-zinc-50 hover:bg-zinc-800 h-10 px-4 py-2 text-sm font-medium shadow-sm transition-all duration-150">
                Ubah Barang
            </a>
        </div>
    </div>
</div>
@endsection
