@extends('layouts.app')

@section('title', 'Daftar Inventaris - Inventaris SMKN 2 SBY')
@section('page_title', 'Inventaris Barang')

@section('content')
<div class="space-y-6">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-1.5 text-sm text-zinc-500">
        <a href="{{ route('dashboard') }}" class="hover:text-zinc-900 transition-colors">Dashboard</a>
        <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
        </svg>
        <span class="font-medium text-zinc-900">Inventaris Barang</span>
    </nav>

    {{-- Header Section --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-zinc-900">Daftar Inventaris</h2>
            <p class="text-sm text-zinc-500">Kelola dan pantau seluruh aset sarana prasarana sekolah.</p>
        </div>
        <div class="flex flex-wrap items-center gap-2">
            <button id="btn-print-bulk" onclick="submitBulkPrint()"
                class="inline-flex items-center justify-center gap-2 rounded-md border border-zinc-200 bg-white text-zinc-700 hover:bg-zinc-50 px-3 py-2 text-sm font-medium shadow-sm transition-all duration-150 cursor-pointer">
                <svg class="w-4 h-4 text-zinc-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096a42.415 42.415 0 0 0-10.56 0m10.56 0L17.66 18m0 0a2.25 2.25 0 0 1-2.25 2.25H8.59A2.25 2.25 0 0 1 6.34 18m11.318-5.318a4.5 4.5 0 1 0-6.364-6.364 4.5 4.5 0 0 0 6.364 6.364Z" />
                </svg>
                Cetak Label Terpilih
            </button>
            <button id="btn-delete-bulk" onclick="submitBulkDelete()"
                class="inline-flex items-center justify-center gap-2 rounded-md border border-red-200 bg-red-50 text-red-700 hover:bg-red-100 px-3 py-2 text-sm font-medium shadow-sm transition-all duration-150 cursor-pointer">
                <svg class="w-4 h-4 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                </svg>
                Hapus Terpilih
            </button>
            <button id="btn-delete-all" onclick="submitDeleteAll()"
                class="inline-flex items-center justify-center gap-2 rounded-md border border-red-300 bg-red-600 text-white hover:bg-red-700 px-3 py-2 text-sm font-medium shadow-sm transition-all duration-150 cursor-pointer">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                </svg>
                Hapus Seluruh Barang
            </button>
            <a href="{{ route('inventaris.template', 'xlsx') }}"
                class="inline-flex items-center justify-center gap-2 rounded-md border border-zinc-200 bg-white text-zinc-700 hover:bg-zinc-50 px-3 py-2 text-sm font-medium shadow-sm transition-all duration-150">
                Template XLSX
            </a>
            <a href="{{ route('inventaris.imports.create') }}"
                class="inline-flex items-center justify-center gap-2 rounded-md border border-emerald-200 bg-emerald-50 text-emerald-700 hover:bg-emerald-100 px-3 py-2 text-sm font-medium shadow-sm transition-all duration-150">
                Import
            </a>
            <a href="{{ route('inventaris.export', 'xlsx') }}"
                class="inline-flex items-center justify-center gap-2 rounded-md border border-zinc-200 bg-white text-zinc-700 hover:bg-zinc-50 px-3 py-2 text-sm font-medium shadow-sm transition-all duration-150">
                Export XLSX
            </a>
            <a href="{{ route('inventaris.print-pdf') }}" target="_blank"
                class="inline-flex items-center justify-center gap-2 rounded-md border border-sky-200 bg-sky-50 text-sky-700 hover:bg-sky-100 px-3 py-2 text-sm font-medium shadow-sm transition-all duration-150">
                <svg class="h-4 w-4 text-sky-600" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096a42.415 42.415 0 0 0-10.56 0m10.56 0L17.66 18m0 0a2.25 2.25 0 0 1-2.25 2.25H8.59A2.25 2.25 0 0 1 6.34 18m11.318-5.318a4.5 4.5 0 1 0-6.364-6.364 4.5 4.5 0 0 0 6.364 6.364Z" />
                </svg>
                Cetak PDF
            </a>
            <a href="{{ route('inventaris.create') }}"
                class="inline-flex items-center justify-center gap-2 rounded-md bg-zinc-900 text-zinc-50 hover:bg-zinc-800 px-4 py-2 text-sm font-medium shadow-sm transition-all duration-150 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-950 cursor-pointer">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Tambah Inventaris
            </a>
        </div>
    </div>

    {{-- Filters Card --}}
    <div class="rounded-lg border border-zinc-200 bg-white p-5 shadow-sm">
        <form id="filter-form" method="GET" action="{{ route('inventaris.index') }}" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-8 gap-4">
            {{-- Cari Barang --}}
            <div class="space-y-1.5 sm:col-span-2 lg:col-span-2">
                <label for="search" class="text-xs font-semibold text-zinc-500 uppercase tracking-wider">Cari Barang</label>
                <div class="relative">
                    <input type="text" id="search" name="search" value="{{ request('search') }}" placeholder="Cari nama atau merek..." class="flex h-9 w-full rounded-md border border-zinc-200 bg-transparent pl-8 pr-3 py-1 text-xs text-zinc-900 placeholder:text-zinc-400 focus:outline-none focus:ring-1 focus:ring-zinc-950">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-2.5 pointer-events-none text-zinc-400">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.637 10.637Z" />
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Jenis Modal --}}
            <div class="space-y-1.5">
                <label for="jenis_modal_id" class="text-xs font-semibold text-zinc-500 uppercase tracking-wider">Jenis Modal</label>
                <select id="jenis_modal_id" name="jenis_modal_id" class="flex h-9 w-full rounded-md border border-zinc-200 bg-transparent px-3 py-1 text-xs text-zinc-900 focus:outline-none focus:ring-1 focus:ring-zinc-950">
                    <option value="">Semua Jenis Modal</option>
                    @foreach($jenisModals as $jenisModal)
                        <option value="{{ $jenisModal->id }}" {{ request('jenis_modal_id') == $jenisModal->id ? 'selected' : '' }}>
                            {{ $jenisModal->nama_jenis_modal }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Unit Kerja --}}
            <div class="space-y-1.5">
                <label for="jurusan_id" class="text-xs font-semibold text-zinc-500 uppercase tracking-wider">Unit Kerja</label>
                <select id="jurusan_id" name="jurusan_id" class="flex h-9 w-full rounded-md border border-zinc-200 bg-transparent px-3 py-1 text-xs text-zinc-900 focus:outline-none focus:ring-1 focus:ring-zinc-950">
                    <option value="">Semua Unit Kerja</option>
                    @foreach($jurusans as $jurusan)
                        <option value="{{ $jurusan->id }}" {{ request('jurusan_id') == $jurusan->id ? 'selected' : '' }}>
                            {{ $jurusan->nama_jurusan }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Ruangan --}}
            <div class="space-y-1.5">
                <label for="ruangan_id" class="text-xs font-semibold text-zinc-500 uppercase tracking-wider">Ruangan</label>
                <select id="ruangan_id" name="ruangan_id" class="flex h-9 w-full rounded-md border border-zinc-200 bg-transparent px-3 py-1 text-xs text-zinc-900 focus:outline-none focus:ring-1 focus:ring-zinc-950">
                    <option value="">Semua Ruangan</option>
                    @foreach($ruangans as $ruangan)
                        <option value="{{ $ruangan->id }}" data-jurusan-id="{{ $ruangan->jurusan_id }}" {{ request('ruangan_id') == $ruangan->id ? 'selected' : '' }}>
                            {{ $ruangan->nama_ruangan }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Kondisi --}}
            <div class="space-y-1.5">
                <label for="kondisi" class="text-xs font-semibold text-zinc-500 uppercase tracking-wider">Kondisi</label>
                <select id="kondisi" name="kondisi" class="flex h-9 w-full rounded-md border border-zinc-200 bg-transparent px-3 py-1 text-xs text-zinc-900 focus:outline-none focus:ring-1 focus:ring-zinc-950">
                    <option value="">Semua Kondisi</option>
                    <option value="baik" {{ request('kondisi') == 'baik' ? 'selected' : '' }}>Baik</option>
                    <option value="layak" {{ request('kondisi') == 'layak' ? 'selected' : '' }}>Layak Pakai</option>
                    <option value="rusak" {{ request('kondisi') == 'rusak' ? 'selected' : '' }}>Rusak</option>
                </select>
            </div>

            {{-- Tahun Pengadaan --}}
            <div class="space-y-1.5">
                <label for="tahun_pengadaan" class="text-xs font-semibold text-zinc-500 uppercase tracking-wider">Tahun</label>
                <select id="tahun_pengadaan" name="tahun_pengadaan" class="flex h-9 w-full rounded-md border border-zinc-200 bg-transparent px-3 py-1 text-xs text-zinc-900 focus:outline-none focus:ring-1 focus:ring-zinc-950">
                    <option value="">Semua Tahun</option>
                    @foreach($tahunPengadaans as $tahun)
                        <option value="{{ $tahun }}" {{ request('tahun_pengadaan') == $tahun ? 'selected' : '' }}>
                            {{ $tahun }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Reset Filters --}}
            <div class="flex items-end">
                <a href="{{ route('inventaris.index') }}" class="flex h-9 items-center justify-center w-full rounded-md border border-zinc-200 text-xs font-medium text-zinc-700 bg-white hover:bg-zinc-50 transition-colors shadow-sm gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                    </svg>
                    Reset Filter
                </a>
            </div>
        </form>
    </div>

    {{-- Table Card --}}
    <div id="inventaris-table-container" class="rounded-lg border border-zinc-200 bg-white shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs uppercase bg-zinc-50 text-zinc-500 border-b border-zinc-200">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-semibold w-10 text-center">
                            <input type="checkbox" id="select_all" class="rounded border-zinc-300 text-zinc-950 focus:ring-zinc-900 cursor-pointer">
                        </th>
                        <th scope="col" class="px-6 py-4 font-semibold w-12">Nomor</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Tanggal Pengadaan</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Kode</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Nama Barang</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Merek</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Tipe</th>
                        <th scope="col" class="px-6 py-4 font-semibold text-center">Jumlah</th>
                        <th scope="col" class="px-6 py-4 font-semibold text-right">Harga Satuan</th>
                        <th scope="col" class="px-6 py-4 font-semibold text-right">Harga Total</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Lokasi</th>
                        <th scope="col" class="px-6 py-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    @forelse ($inventaris as $item)
                        <tr class="hover:bg-zinc-50/60 transition-colors {{ $loop->even ? 'bg-zinc-50/30' : 'bg-white' }}">
                            <td class="px-6 py-4 text-center">
                                <input type="checkbox" name="selected_ids[]" value="{{ $item->id }}" class="item-checkbox rounded border-zinc-300 text-zinc-950 focus:ring-zinc-900 cursor-pointer">
                            </td>
                            <td class="px-6 py-4 text-zinc-400 font-mono text-xs">
                                {{ ($inventaris->currentPage() - 1) * $inventaris->perPage() + $loop->iteration }}
                            </td>
                            <td class="px-6 py-4 text-zinc-600">
                                <div class="font-medium text-xs text-zinc-700">{{ $item->tanggal_pengadaan?->format('d M Y') ?? '-' }}</div>
                                <div class="text-[10px] text-zinc-400">{{ $item->created_at?->format('H:i') ?? '' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center rounded-md bg-zinc-100 px-2.5 py-1 text-xs font-mono font-semibold text-zinc-700 border border-zinc-200/60 tracking-wide">
                                    {{ $item->kode_inventaris }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2 font-medium text-zinc-900">
                                    <span>{{ $item->nama_barang }}</span>
                                    @if ($item->foto_url)
                                        <a href="{{ $item->foto_url }}" target="_blank" rel="noopener noreferrer"
                                           class="inline-flex h-5 w-5 items-center justify-center rounded-md border border-sky-100 bg-sky-50 text-sky-700 hover:bg-sky-100"
                                           title="Buka foto inventaris">
                                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Z" />
                                            </svg>
                                        </a>
                                    @endif
                                </div>
                                <div class="text-xs text-zinc-400">{{ $item->spesifikasi }}</div>
                            </td>
                            <td class="px-6 py-4 text-zinc-700 font-medium">
                                {{ $item->merek }}
                            </td>
                            <td class="px-6 py-4 text-zinc-600 text-xs font-mono">
                                {{ $item->type ?: '-' }}
                            </td>
                            <td class="px-6 py-4 text-center font-semibold text-zinc-800">
                                {{ $item->jumlah_total }}
                            </td>
                            <td class="px-6 py-4 text-right font-semibold text-zinc-700">
                                Rp {{ number_format($item->harga_satuan ?? 0, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-right font-bold text-zinc-900">
                                Rp {{ number_format($item->harga_total, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-zinc-600">
                                <div class="font-medium text-xs text-zinc-700">{{ $item->ruangan->nama_ruangan ?? '-' }}</div>
                                <div class="text-[10px] text-zinc-400">{{ $item->jurusan->nama_jurusan ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="inline-flex items-center justify-end gap-2">
                                    {{-- Print QR Label --}}
                                    <a href="{{ route('inventaris.print-label', $item->id) }}" target="_blank"
                                        class="p-1.5 rounded-md border border-zinc-200 text-zinc-600 hover:text-zinc-950 bg-white hover:bg-zinc-50 transition-colors shadow-sm text-xs font-medium inline-flex items-center gap-1"
                                        title="Cetak Label QR">
                                        <svg class="w-3.5 h-3.5 text-zinc-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 3.75 9.375v-4.5ZM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 0 1-1.125-1.125v-4.5ZM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 13.5 9.375v-4.5Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.875 15.75a1.125 1.125 0 0 1-1.125-1.125v-1.5a1.125 1.125 0 0 1 1.125-1.125h1.5a1.125 1.125 0 0 1 1.125 1.125v1.5a1.125 1.125 0 0 1-1.125 1.125h-1.5ZM13.5 18.75c0-.621.504-1.125 1.125-1.125h1.5a1.125 1.125 0 0 1 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5Z" />
                                        </svg>
                                        QR
                                    </a>

                                    {{-- Lihat --}}
                                    <a href="{{ route('inventaris.show', $item->id) }}"
                                        class="p-1.5 rounded-md border border-zinc-200 text-zinc-600 hover:text-zinc-950 bg-white hover:bg-zinc-50 transition-colors shadow-sm text-xs font-medium inline-flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        </svg>
                                        Lihat
                                    </a>

                                    {{-- Edit --}}
                                    <a href="{{ route('inventaris.edit', $item->id) }}"
                                        class="p-1.5 rounded-md border border-zinc-200 text-zinc-600 hover:text-zinc-950 bg-white hover:bg-zinc-50 transition-colors shadow-sm text-xs font-medium inline-flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.83 20.013a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                        </svg>
                                        Ubah
                                    </a>

                                    {{-- Hapus dengan SweetAlert2 --}}
                                    <form id="delete-form-{{ $item->id }}"
                                        action="{{ route('inventaris.destroy', $item->id) }}"
                                        method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                            onclick="confirmDelete('{{ $item->id }}', '{{ addslashes($item->nama_barang) }}')"
                                            class="p-1.5 rounded-md border border-red-200 text-red-600 hover:text-white hover:bg-red-600 transition-colors shadow-sm text-xs font-medium inline-flex items-center gap-1 cursor-pointer">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                            </svg>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="12" class="px-6 py-16 text-center text-zinc-500">
                                <div class="flex flex-col items-center justify-center gap-3">
                                    <div class="w-14 h-14 rounded-full bg-zinc-100 flex items-center justify-center">
                                        <svg class="w-7 h-7 text-zinc-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-zinc-700">Belum ada data inventaris</p>
                                        <p class="text-xs text-zinc-400 mt-0.5">Klik tombol "Tambah Inventaris" untuk menambahkan aset pertama.</p>
                                    </div>
                                    <a href="{{ route('inventaris.create') }}"
                                        class="mt-1 inline-flex items-center gap-1.5 rounded-md bg-zinc-900 text-zinc-50 hover:bg-zinc-800 px-3 py-1.5 text-xs font-medium transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                        </svg>
                                        Tambah Inventaris
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Table Footer: total count --}}
        @if ($inventaris->isNotEmpty())
            <div class="px-6 py-4 border-t border-zinc-100 bg-zinc-50/50 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <p class="text-xs text-zinc-400">
                    Menampilkan <span class="font-medium text-zinc-600">{{ $inventaris->firstItem() }}</span> sampai <span class="font-medium text-zinc-600">{{ $inventaris->lastItem() }}</span> dari <span class="font-medium text-zinc-600">{{ $inventaris->total() }}</span> barang terdaftar
                </p>
                <div class="shrink-0 pagination-sm">
                    {{ $inventaris->links() }}
                </div>
            </div>
        @endif
    </div>

    {{-- Hidden forms for bulk actions --}}
    <form id="bulk-delete-form" action="{{ route('inventaris.destroy-bulk') }}" method="POST" class="hidden">
        @csrf
        @method('DELETE')
        <input type="hidden" name="ids" id="bulk-delete-ids">
    </form>

    <form id="delete-all-form" action="{{ route('inventaris.destroy-all') }}" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>
</div>

<script>
    // Fungsi untuk hapus massal berdasarkan checkbox terpilih
    function submitBulkDelete() {
        const checkboxes = document.querySelectorAll('.item-checkbox:checked');
        if (checkboxes.length === 0) {
            Swal.fire({
                title: 'Pilih Barang',
                text: 'Silakan pilih minimal satu barang untuk dihapus.',
                icon: 'warning',
                confirmButtonColor: '#18181b',
            });
            return;
        }

        Swal.fire({
            title: 'Hapus Barang Terpilih?',
            html: `Anda akan menghapus <strong>${checkboxes.length}</strong> data inventaris yang terpilih.<br>
                   <span class="text-sm text-gray-500">Tindakan ini tidak dapat dibatalkan.</span>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            focusCancel: true,
        }).then((result) => {
            if (result.isConfirmed) {
                const ids = Array.from(checkboxes).map(cb => cb.value);
                document.getElementById('bulk-delete-ids').value = ids.join(',');
                document.getElementById('bulk-delete-form').submit();
            }
        });
    }

    // Fungsi untuk hapus seluruh barang
    function submitDeleteAll() {
        Swal.fire({
            title: 'Hapus Seluruh Barang?',
            html: `<span class="text-red-600 font-bold">PERINGATAN!</span> Anda akan menghapus <strong>SELURUH</strong> data inventaris sekolah.<br>
                   <span class="text-sm text-gray-500">Tindakan ini tidak dapat dibatalkan dan akan menghapus semua aset.</span>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Hapus Semua',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            focusCancel: true,
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-all-form').submit();
            }
        });
    }

    function confirmDelete(id, nama) {
        Swal.fire({
            title: 'Hapus Barang?',
            html: `Anda akan menghapus data inventaris <strong>"${nama}"</strong>.<br>
                   <span class="text-sm text-gray-500">Tindakan ini tidak dapat dibatalkan.</span>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            focusCancel: true,
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }

    // Fungsi untuk menyaring opsi ruangan berdasarkan unit kerja/jurusan yang dipilih
    function filterRuanganByJurusan(resetRuangan = false) {
        const jurusanSelect = document.getElementById('jurusan_id');
        const ruanganSelect = document.getElementById('ruangan_id');
        if (!jurusanSelect || !ruanganSelect) return;

        if (resetRuangan) {
            ruanganSelect.value = "";
        }

        const selectedJurusanId = jurusanSelect.value;
        const options = ruanganSelect.options;
        let selectedRoomStillValid = false;

        for (let i = 0; i < options.length; i++) {
            const option = options[i];
            const optionJurusanId = option.getAttribute('data-jurusan-id');

            // Opsi "Semua Ruangan" tidak memiliki data-jurusan-id dan selalu ditampilkan
            if (!optionJurusanId) {
                option.hidden = false;
                option.disabled = false;
                if (option.selected) {
                    selectedRoomStillValid = true;
                }
                continue;
            }

            // Jika tidak ada jurusan yang dipilih atau jurusan ruangan sesuai, tampilkan opsi tersebut
            if (selectedJurusanId === "" || optionJurusanId === selectedJurusanId) {
                option.hidden = false;
                option.disabled = false;
                if (option.selected) {
                    selectedRoomStillValid = true;
                }
            } else {
                // Sembunyikan dan nonaktifkan opsi ruangan dari jurusan lain
                option.hidden = true;
                option.disabled = true;
            }
        }

        // Jika ruangan yang sedang terpilih berada di luar jurusan yang baru dipilih, reset pilihan ke "Semua Ruangan"
        if (!selectedRoomStillValid) {
            ruanganSelect.value = "";
        }
    }

    // Fungsi untuk cetak label massal berdasarkan checkbox terpilih
    function submitBulkPrint() {
        const selectAllCheckbox = document.getElementById('select_all');
        const baseUrl = "{{ route('inventaris.print-label-bulk') }}";

        if (selectAllCheckbox?.checked) {
            const params = new URLSearchParams(window.location.search);
            params.set('all', '1');

            window.open(baseUrl + '?' + params.toString(), '_blank');
            return;
        }

        const checkboxes = document.querySelectorAll('.item-checkbox:checked');
        if (checkboxes.length === 0) {
            Swal.fire({
                title: 'Pilih Barang',
                text: 'Silakan pilih minimal satu barang atau centang checkbox header untuk memilih semua data.',
                icon: 'warning',
                confirmButtonColor: '#18181b',
            });
            return;
        }

        const ids = Array.from(checkboxes).map(cb => cb.value);
        
        // Buat url cetak massal: route('inventaris.print-label-bulk')?ids=uuid1,uuid2
        const url = baseUrl + "?ids=" + ids.join(',');
        window.open(url, '_blank');
    }

    // Submit form via AJAX
    function submitFormAjax() {
        const filterForm = document.getElementById('filter-form');
        if (!filterForm) return;

        const formData = new FormData(filterForm);
        const params = new URLSearchParams();

        for (const [key, value] of formData.entries()) {
            if (value !== '') {
                params.append(key, value);
            }
        }

        const baseUrl = filterForm.getAttribute('action');
        const url = baseUrl + (params.toString() ? '?' + params.toString() : '');
        fetchFilteredData(url);
    }

    // Fetch filtered data via AJAX
    function fetchFilteredData(url, shouldPushState = true) {
        const container = document.getElementById('inventaris-table-container');
        if (!container) return;

        // Visual loading feedback
        container.classList.add('opacity-50', 'transition-opacity', 'duration-200');

        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.text();
        })
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newContainer = doc.getElementById('inventaris-table-container');

            if (newContainer) {
                container.innerHTML = newContainer.innerHTML;
            }
            container.classList.remove('opacity-50');

            // Sync the form values with the new URL parameters
            syncFormWithUrl(url);

            if (shouldPushState) {
                window.history.pushState({ path: url }, '', url);
            }
        })
        .catch(error => {
            console.error('Error fetching filtered data:', error);
            container.classList.remove('opacity-50');
        });
    }

    // Sync form inputs with URL parameters (for browser back/forward and AJAX pagination)
    function syncFormWithUrl(url) {
        const filterForm = document.getElementById('filter-form');
        if (!filterForm) return;

        const urlObj = new URL(url, window.location.origin);
        const params = urlObj.searchParams;

        // Sync search input
        const searchInput = document.getElementById('search');
        if (searchInput) {
            searchInput.value = params.get('search') || '';
        }

        // Sync selects
        filterForm.querySelectorAll('select').forEach(select => {
            select.value = params.get(select.name) || '';
        });

        // Re-run room filtering based on current unit kerja selection
        filterRuanganByJurusan();
    }

    // Initial setup on DOMContentLoaded
    document.addEventListener('DOMContentLoaded', function() {
        filterRuanganByJurusan();

        const filterForm = document.getElementById('filter-form');
        if (filterForm) {
            // Handle select changes via event listener instead of onchange attribute
            filterForm.querySelectorAll('select').forEach(select => {
                select.addEventListener('change', function() {
                    if (this.id === 'jurusan_id') {
                        filterRuanganByJurusan(true);
                    }
                    submitFormAjax();
                });
            });

            // Handle search input typing with 300ms debounce
            const searchInput = document.getElementById('search');
            if (searchInput) {
                let debounceTimeout;
                searchInput.addEventListener('input', function() {
                    clearTimeout(debounceTimeout);
                    debounceTimeout = setTimeout(() => {
                        submitFormAjax();
                    }, 300);
                });
            }

            // Intercept Reset Filter button click
            const resetBtn = filterForm.querySelector('a[href*="inventaris"]');
            if (resetBtn) {
                resetBtn.addEventListener('click', function(event) {
                    event.preventDefault();
                    filterForm.reset();
                    filterForm.querySelectorAll('select').forEach(select => select.value = "");
                    if (searchInput) searchInput.value = "";
                    filterRuanganByJurusan(true);
                    submitFormAjax();
                });
            }
        }

        // Intercept pagination links click (AJAX pagination)
        document.addEventListener('click', function(event) {
            const paginationLink = event.target.closest('#inventaris-table-container .pagination-sm a');
            if (paginationLink) {
                event.preventDefault();
                const url = paginationLink.getAttribute('href');
                if (url) {
                    fetchFilteredData(url);
                }
            }
        });

        // Handle select all checkbox change using event delegation
        document.addEventListener('change', function(event) {
            if (event.target && event.target.id === 'select_all') {
                const checkboxes = document.querySelectorAll('.item-checkbox');
                checkboxes.forEach(cb => {
                    cb.checked = event.target.checked;
                });
            }
        });
    });

    // Handle browser back/forward buttons
    window.addEventListener('popstate', function() {
        fetchFilteredData(window.location.href, false);
    });
</script>
@endsection
