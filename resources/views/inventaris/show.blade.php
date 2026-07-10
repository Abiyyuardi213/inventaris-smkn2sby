@extends('layouts.app')

@section('title', 'Detail Inventaris - Inventaris SMKN 2 SBY')
@section('page_title', 'Detail Inventaris')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
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

    @if (session('success'))
        <div class="rounded-md bg-emerald-50 border border-emerald-200 p-4 text-sm text-emerald-800">
            {{ session('success') }}
        </div>
    @endif
    
    @if (session('error'))
        <div class="rounded-md bg-red-50 border border-red-200 p-4 text-sm text-red-800">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Details Card -->
        <div class="lg:col-span-2 rounded-lg border border-zinc-200 bg-white p-6 shadow-sm space-y-6">
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

                <!-- Harga -->
                <div>
                    <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider block mb-1">Harga Barang</span>
                    <span class="text-sm text-zinc-700 block font-medium">Rp {{ number_format($inventaris->harga_satuan ?? 0, 0, ',', '.') }}</span>
                    <span class="text-xs text-zinc-400">Total: Rp {{ number_format($inventaris->harga_total, 0, ',', '.') }}</span>
                </div>

                <!-- Sumber Dana -->
                <div>
                    <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider block mb-1">Sumber Dana</span>
                    <span class="text-sm text-zinc-700 block font-medium">{{ $inventaris->sumber_dana ?: '-' }}</span>
                </div>

                <!-- Bahan -->
                <div>
                    <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider block mb-1">Bahan</span>
                    <span class="text-sm text-zinc-700 block font-medium">{{ $inventaris->bahan ?: '-' }}</span>
                </div>

                <!-- Warna -->
                <div>
                    <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider block mb-1">Warna</span>
                    <span class="text-sm text-zinc-700 block font-medium">{{ $inventaris->warna ?: '-' }}</span>
                </div>

                <!-- Nama Penyedia -->
                <div>
                    <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider block mb-1">Nama Penyedia</span>
                    <span class="text-sm text-zinc-700 block font-medium">{{ $inventaris->nama_penyedia ?: '-' }}</span>
                </div>

                <!-- Nomor Surat BAST -->
                <div>
                    <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider block mb-1">Nomor Surat BAST</span>
                    <span class="text-sm text-zinc-700 block font-medium">{{ $inventaris->nomor_surat_bast ?: '-' }}</span>
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

        <!-- Media Cards -->
        <div class="lg:col-span-1 space-y-6">
            <div class="rounded-lg border border-zinc-200 bg-white p-6 shadow-sm space-y-4">
                <div>
                    <span class="text-xs font-bold text-zinc-400 uppercase tracking-wider">Foto Inventaris</span>
                    <p class="text-xs text-zinc-500 mt-1">Sumber foto menggunakan link Google Drive.</p>
                </div>

                @if ($inventaris->foto_url)
                    <a href="{{ $inventaris->foto_url }}" target="_blank" rel="noopener noreferrer"
                       class="block overflow-hidden rounded-lg border border-zinc-200 bg-zinc-50 aspect-[4/3] group">
                        <img src="{{ $inventaris->foto_preview_url }}" alt="Foto {{ $inventaris->nama_barang }}"
                             class="h-full w-full object-cover transition-transform duration-200 group-hover:scale-[1.02]"
                             loading="lazy"
                             onerror="this.classList.add('hidden'); this.nextElementSibling.classList.remove('hidden'); this.nextElementSibling.classList.add('flex');">
                        <div class="hidden h-full w-full items-center justify-center p-4 text-center text-xs font-medium text-zinc-500">
                            Preview tidak tersedia. Klik untuk membuka foto.
                        </div>
                    </a>

                    <a href="{{ $inventaris->foto_url }}" target="_blank" rel="noopener noreferrer"
                       class="inline-flex h-9 w-full items-center justify-center rounded-md border border-zinc-200 bg-white px-3 text-xs font-semibold text-zinc-700 shadow-sm transition-colors hover:bg-zinc-50 hover:text-zinc-950">
                        Buka Foto
                    </a>
                @else
                    <div class="flex aspect-[4/3] items-center justify-center rounded-lg border border-dashed border-zinc-200 bg-zinc-50 p-4 text-center text-xs font-medium text-zinc-400">
                        Belum ada link foto inventaris.
                    </div>
                @endif
            </div>

            <div class="rounded-lg border border-zinc-200 bg-white p-6 shadow-sm flex flex-col items-center text-center space-y-4">
                <span class="text-xs font-bold text-zinc-400 uppercase tracking-wider">QR Code Label</span>
                
                <div class="bg-zinc-50 border border-zinc-200 rounded-xl p-4 flex items-center justify-center w-full max-w-[200px] aspect-square shadow-inner">
                    @if ($inventaris->qr_code_path && Storage::disk('public')->exists($inventaris->qr_code_path))
                        <img src="{{ asset('storage/' . $inventaris->qr_code_path) }}?v={{ time() }}" alt="QR Code" class="w-full h-full object-contain">
                    @else
                        <div class="text-xs text-zinc-400 font-medium">QR Code Belum Dibuat</div>
                    @endif
                </div>

                <div class="space-y-2 w-full">
                    <a href="{{ route('inventaris.print-label', $inventaris->id) }}" target="_blank"
                       class="w-full inline-flex items-center justify-center gap-1.5 rounded-md border border-zinc-200 bg-white text-zinc-700 hover:bg-zinc-50 hover:text-zinc-950 h-9 text-xs font-semibold shadow-sm transition-all duration-150">
                        <svg class="w-3.5 h-3.5 text-zinc-500" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096a42.415 42.415 0 0 0-10.56 0m10.56 0L17.66 18m0 0a2.25 2.25 0 0 1-2.25 2.25H8.59A2.25 2.25 0 0 1 6.34 18m11.318-5.318a4.5 4.5 0 1 0-6.364-6.364 4.5 4.5 0 0 0 6.364 6.364Z" />
                        </svg>
                        Cetak Label QR
                    </a>

                    <form action="{{ route('inventaris.regenerate-qr', $inventaris->id) }}" method="POST" class="w-full">
                        @csrf
                        <button type="submit" class="w-full inline-flex items-center justify-center gap-1.5 rounded-md bg-zinc-900 text-zinc-50 hover:bg-zinc-800 h-9 text-xs font-bold transition-all duration-150 cursor-pointer">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                            </svg>
                            Perbarui QR Code
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
