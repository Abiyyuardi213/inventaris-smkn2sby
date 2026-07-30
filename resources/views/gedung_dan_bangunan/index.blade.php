@extends('layouts.app')

@section('title', 'Gedung dan Bangunan (KIB C)')

@section('content')
<div class="space-y-6">

    {{-- Page Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center rounded-md bg-emerald-50 px-2 py-1 text-xs font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-600/20">
                    KIB C
                </span>
                <h1 class="text-2xl font-bold text-zinc-900 tracking-tight">Gedung & Bangunan</h1>
            </div>
            <p class="text-sm text-zinc-500 mt-1">
                Kelola data sarana dan prasarana aset gedung serta bangunan sekolah.
            </p>
        </div>
        <div class="flex flex-wrap items-center gap-2">
            {{-- Tombol Cetak KIB C --}}
            <a href="{{ route('gedung-dan-bangunan.print-kib-c', request()->only(['search', 'jurusan_id', 'ruangan_id', 'tahun_pengadaan', 'tahun'])) }}" target="_blank"
                class="inline-flex items-center justify-center gap-2 rounded-md border border-emerald-200 bg-emerald-50 text-emerald-800 hover:bg-emerald-100 px-3.5 py-2 text-sm font-medium shadow-sm transition-all duration-150">
                <svg class="h-4 w-4 text-emerald-700" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z" />
                </svg>
                Cetak KIB C
            </a>

            <a href="{{ route('gedung-dan-bangunan.create') }}"
                class="inline-flex items-center justify-center gap-2 rounded-md bg-zinc-900 text-zinc-50 hover:bg-zinc-800 px-4 py-2 text-sm font-medium shadow-sm transition-all duration-150 cursor-pointer">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Tambah Gedung & Bangunan
            </a>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-4">
        <div class="rounded-xl border border-zinc-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold uppercase tracking-wider text-zinc-500">Total Bangunan</span>
                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12" />
                    </svg>
                </div>
            </div>
            <p class="mt-3 text-2xl font-bold tracking-tight text-zinc-900">{{ number_format($totalBangunan, 0, ',', '.') }}</p>
        </div>

        <div class="rounded-xl border border-zinc-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold uppercase tracking-wider text-zinc-500">Total Luas Lantai (m²)</span>
                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-indigo-50 text-indigo-600">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3.75v16.5m0-16.5h16.5m-16.5 0L20.25 20.25m-16.5 0h16.5m0-16.5v16.5" />
                    </svg>
                </div>
            </div>
            <p class="mt-3 text-2xl font-bold tracking-tight text-zinc-900">{{ number_format($totalLuasLantai, 0, ',', '.') }} m²</p>
        </div>

        <div class="rounded-xl border border-zinc-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold uppercase tracking-wider text-zinc-500">Total Nilai Aset</span>
                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-blue-50 text-blue-600">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-6h6m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
            </div>
            <p class="mt-3 text-2xl font-bold tracking-tight text-zinc-900">Rp {{ number_format($totalNilai, 0, ',', '.') }}</p>
        </div>

        <div class="rounded-xl border border-zinc-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold uppercase tracking-wider text-zinc-500">Kondisi Baik</span>
                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
            </div>
            <p class="mt-3 text-2xl font-bold tracking-tight text-zinc-900">{{ number_format($totalKondisiBaik, 0, ',', '.') }}</p>
        </div>
    </div>

    {{-- Filter Toolbar --}}
    <div class="rounded-xl border border-zinc-200 bg-white p-4 shadow-sm space-y-4">
        <form method="GET" action="{{ route('gedung-dan-bangunan.index') }}" class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-6">
            {{-- Search Input --}}
            <div class="lg:col-span-2">
                <label for="search" class="block text-xs font-medium text-zinc-600 mb-1">Cari Gedung / Bangunan</label>
                <div class="relative">
                    <input type="text" name="search" id="search" value="{{ request('search') }}"
                        placeholder="Nama gedung, kode, alamat, no. dokumen..."
                        class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2 pl-9 text-sm text-zinc-900 placeholder-zinc-400 focus:border-zinc-500 focus:outline-none focus:ring-1 focus:ring-zinc-500">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="h-4 w-4 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Filter Unit Kerja --}}
            <div>
                <label for="jurusan_id" class="block text-xs font-medium text-zinc-600 mb-1">Unit Kerja</label>
                <select name="jurusan_id" id="jurusan_id" onchange="this.form.submit()"
                    class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-900 focus:border-zinc-500 focus:outline-none focus:ring-1 focus:ring-zinc-500">
                    <option value="">Semua Unit Kerja</option>
                    @foreach($jurusans as $jurusan)
                        <option value="{{ $jurusan->id }}" {{ request('jurusan_id') == $jurusan->id ? 'selected' : '' }}>
                            {{ $jurusan->nama_jurusan }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Filter Ruangan --}}
            <div>
                <label for="ruangan_id" class="block text-xs font-medium text-zinc-600 mb-1">Ruangan / Lokasi</label>
                <select name="ruangan_id" id="ruangan_id" onchange="this.form.submit()"
                    class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-900 focus:border-zinc-500 focus:outline-none focus:ring-1 focus:ring-zinc-500">
                    <option value="">Semua Ruangan</option>
                    @foreach($ruangans as $ruangan)
                        <option value="{{ $ruangan->id }}" {{ request('ruangan_id') == $ruangan->id ? 'selected' : '' }}>
                            {{ $ruangan->nama_ruangan }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Filter Tahun Catat Aset --}}
            <div>
                <label for="tahun_pengadaan" class="block text-xs font-medium text-zinc-600 mb-1">Tahun Catat</label>
                <select name="tahun_pengadaan" id="tahun_pengadaan" onchange="this.form.submit()"
                    class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-900 focus:border-zinc-500 focus:outline-none focus:ring-1 focus:ring-zinc-500">
                    <option value="">Semua Tahun</option>
                    @foreach($tahunPengadaans as $thn)
                        <option value="{{ $thn }}" {{ request('tahun_pengadaan') == $thn ? 'selected' : '' }}>
                            {{ $thn }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Filter Kondisi --}}
            <div>
                <label for="kondisi" class="block text-xs font-medium text-zinc-600 mb-1">Kondisi</label>
                <select name="kondisi" id="kondisi" onchange="this.form.submit()"
                    class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-900 focus:border-zinc-500 focus:outline-none focus:ring-1 focus:ring-zinc-500">
                    <option value="">Semua Kondisi</option>
                    <option value="baik" {{ request('kondisi') == 'baik' ? 'selected' : '' }}>B : Baik</option>
                    <option value="rusak_ringan" {{ request('kondisi') == 'rusak_ringan' ? 'selected' : '' }}>RR : Rusak Ringan</option>
                    <option value="rusak_sedang" {{ request('kondisi') == 'rusak_sedang' ? 'selected' : '' }}>RS : Rusak Sedang</option>
                    <option value="rusak_berat" {{ request('kondisi') == 'rusak_berat' ? 'selected' : '' }}>RB : Rusak Berat</option>
                </select>
            </div>
        </form>
    </div>

    {{-- Main Data Table 17 Columns --}}
    <div class="overflow-hidden rounded-xl border border-zinc-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-zinc-700 border-collapse">
                <thead class="bg-zinc-50 uppercase font-bold text-zinc-700 border-b border-zinc-300 text-[10px] tracking-wider text-center">
                    <tr>
                        <th rowspan="2" class="px-2 py-2 border-r border-zinc-200 w-10">No Urut</th>
                        <th rowspan="2" class="px-3 py-2 border-r border-zinc-200 min-w-[130px]">Nama Barang / Jenis Barang</th>
                        <th colspan="2" class="px-2 py-1.5 border-b border-r border-zinc-200">Nomor</th>
                        <th rowspan="2" class="px-2 py-2 border-r border-zinc-200 min-w-[110px]">Kondisi bangunan (B, RR, RS, RB)</th>
                        <th colspan="2" class="px-2 py-1.5 border-b border-r border-zinc-200">Konstruksi</th>
                        <th rowspan="2" class="px-2 py-2 border-r border-zinc-200 w-16">Luas Lantai (M2)</th>
                        <th rowspan="2" class="px-3 py-2 border-r border-zinc-200 min-w-[120px]">Letak / Lokasi Alamat</th>
                        <th colspan="2" class="px-2 py-1.5 border-b border-r border-zinc-200">Dokumen</th>
                        <th rowspan="2" class="px-2 py-2 border-r border-zinc-200 w-16">Luas (M2)</th>
                        <th rowspan="2" class="px-2 py-2 border-r border-zinc-200 w-20">Status Tanah</th>
                        <th rowspan="2" class="px-2 py-2 border-r border-zinc-200 w-20">Nomor Kode Tanah</th>
                        <th rowspan="2" class="px-2 py-2 border-r border-zinc-200 w-16">Asal Usul</th>
                        <th rowspan="2" class="px-3 py-2 border-r border-zinc-200 w-24">Harga</th>
                        <th rowspan="2" class="px-3 py-2 border-r border-zinc-200">Ket</th>
                        <th rowspan="2" class="px-2 py-2 w-16">Aksi</th>
                    </tr>
                    <tr class="border-b border-zinc-200">
                        <th class="px-2 py-1 border-r border-zinc-200 font-semibold">Kode barang</th>
                        <th class="px-2 py-1 border-r border-zinc-200 font-semibold">Nomor register</th>
                        <th class="px-2 py-1 border-r border-zinc-200 font-semibold">Bertingkat (tidak)</th>
                        <th class="px-2 py-1 border-r border-zinc-200 font-semibold">Beton (tidak)</th>
                        <th class="px-2 py-1 border-r border-zinc-200 font-semibold">Tgl</th>
                        <th class="px-2 py-1 border-r border-zinc-200 font-semibold">Nomor</th>
                    </tr>
                    <tr class="bg-zinc-100/80 text-[9px] font-mono text-zinc-500 border-b border-zinc-300">
                        <td class="px-1 py-0.5 border-r border-zinc-200">1</td>
                        <td class="px-1 py-0.5 border-r border-zinc-200">2</td>
                        <td class="px-1 py-0.5 border-r border-zinc-200">3</td>
                        <td class="px-1 py-0.5 border-r border-zinc-200">4</td>
                        <td class="px-1 py-0.5 border-r border-zinc-200">5</td>
                        <td class="px-1 py-0.5 border-r border-zinc-200">6</td>
                        <td class="px-1 py-0.5 border-r border-zinc-200">7</td>
                        <td class="px-1 py-0.5 border-r border-zinc-200">8</td>
                        <td class="px-1 py-0.5 border-r border-zinc-200">9</td>
                        <td class="px-1 py-0.5 border-r border-zinc-200">10</td>
                        <td class="px-1 py-0.5 border-r border-zinc-200">11</td>
                        <td class="px-1 py-0.5 border-r border-zinc-200">12</td>
                        <td class="px-1 py-0.5 border-r border-zinc-200">13</td>
                        <td class="px-1 py-0.5 border-r border-zinc-200">14</td>
                        <td class="px-1 py-0.5 border-r border-zinc-200">15</td>
                        <td class="px-1 py-0.5 border-r border-zinc-200">16</td>
                        <td class="px-1 py-0.5 border-r border-zinc-200">17</td>
                        <td class="px-1 py-0.5">-</td>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200">
                    @forelse ($items as $index => $item)
                        @php($subtotal = $item->harga_satuan * $item->jumlah_total)
                        <tr class="hover:bg-zinc-50/80 transition-colors">
                            <td class="px-2 py-2.5 text-center text-zinc-400 font-mono border-r border-zinc-200">
                                {{ $items->firstItem() + $index }}
                            </td>
                            <td class="px-3 py-2.5 font-medium text-zinc-900 border-r border-zinc-200">
                                <div class="flex items-center justify-between gap-2">
                                    <span>{{ $item->nama_barang }}</span>
                                    @if($item->foto_url)
                                        <a href="{{ $item->foto_url }}" target="_blank" title="Lihat Foto di Google Drive"
                                            class="inline-flex items-center gap-1 rounded bg-blue-50 px-1.5 py-0.5 text-[10px] font-semibold text-blue-700 hover:bg-blue-100 ring-1 ring-inset ring-blue-700/10 shrink-0">
                                            <svg class="h-3 w-3 text-blue-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244" />
                                            </svg>
                                            Drive
                                        </a>
                                    @endif
                                </div>
                            </td>
                            <td class="px-2 py-2.5 font-mono text-[11px] text-zinc-900 border-r border-zinc-200 text-center">
                                {{ $item->kode_inventaris }}
                            </td>
                            <td class="px-2 py-2.5 text-center font-mono text-[11px] border-r border-zinc-200">
                                {{ str_pad($index + 1, 4, '0', STR_PAD_LEFT) }}
                            </td>
                            <td class="px-2 py-2.5 text-center font-semibold border-r border-zinc-200 whitespace-nowrap">
                                @if($item->kondisi === 'baik')
                                    <span class="text-emerald-700 font-bold">B</span> <span class="text-zinc-500 font-normal text-[11px]">(Baik)</span>
                                @elseif($item->kondisi === 'rusak_ringan')
                                    <span class="text-blue-700 font-bold">RR</span> <span class="text-zinc-500 font-normal text-[11px]">(Rusak Ringan)</span>
                                @elseif($item->kondisi === 'rusak_sedang')
                                    <span class="text-amber-700 font-bold">RS</span> <span class="text-zinc-500 font-normal text-[11px]">(Rusak Sedang)</span>
                                @elseif($item->kondisi === 'rusak_berat' || $item->kondisi === 'rusak')
                                    <span class="text-red-700 font-bold">RB</span> <span class="text-zinc-500 font-normal text-[11px]">(Rusak Berat)</span>
                                @else
                                    <span class="text-amber-700 font-bold">KB</span> <span class="text-zinc-500 font-normal text-[11px]">(Kurang Baik)</span>
                                @endif
                            </td>
                            <td class="px-2 py-2.5 text-center border-r border-zinc-200">
                                {{ $item->konstruksi_bertingkat ?: 'Tidak' }}
                            </td>
                            <td class="px-2 py-2.5 text-center border-r border-zinc-200">
                                {{ $item->konstruksi_beton ?: 'Beton' }}
                            </td>
                            <td class="px-2 py-2.5 text-right font-semibold border-r border-zinc-200">
                                {{ number_format($item->luas_lantai ?? 0, 0, ',', '.') }}
                            </td>
                            <td class="px-3 py-2.5 text-zinc-700 border-r border-zinc-200">
                                {{ $item->lokasi_alamat ?: ($item->ruangan?->nama_ruangan ?? '-') }}
                            </td>
                            <td class="px-2 py-2.5 text-center text-[10px] border-r border-zinc-200 whitespace-nowrap">
                                {{ optional($item->dokumen_tanggal ?? $item->tanggal_bast ?? $item->tanggal_catat_aset)->format('d/m/Y') ?? '-' }}
                            </td>
                            <td class="px-2 py-2.5 text-center border-r border-zinc-200 text-[10px]">
                                {{ $item->dokumen_nomor ?: ($item->nomor_surat_bast ?: '-') }}
                            </td>
                            <td class="px-2 py-2.5 text-right font-semibold border-r border-zinc-200">
                                {{ number_format($item->luas_tanah ?? 0, 0, ',', '.') }}
                            </td>
                            <td class="px-2 py-2.5 text-center border-r border-zinc-200">
                                {{ $item->status_tanah ?: 'Hak Pakai' }}
                            </td>
                            <td class="px-2 py-2.5 text-center font-mono text-[10px] border-r border-zinc-200">
                                {{ $item->nomor_kode_tanah ?: '-' }}
                            </td>
                            <td class="px-2 py-2.5 text-center border-r border-zinc-200">
                                {{ $item->sumber_dana ?: 'APBD' }}
                            </td>
                            <td class="px-3 py-2.5 text-right font-semibold text-zinc-900 border-r border-zinc-200 whitespace-nowrap">
                                Rp {{ number_format($subtotal, 0, ',', '.') }}
                            </td>
                            <td class="px-3 py-2.5 text-zinc-600 border-r border-zinc-200">
                                {{ $item->ruangan?->nama_ruangan ?? '-' }}
                            </td>
                            <td class="px-2 py-2.5 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center gap-1">
                                    @if($item->foto_url)
                                        <a href="{{ $item->foto_url }}" target="_blank"
                                            title="Buka Foto Google Drive"
                                            class="rounded p-1 text-blue-600 hover:bg-blue-50 hover:text-blue-800 transition-colors">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                            </svg>
                                        </a>
                                    @endif
                                    <a href="{{ route('gedung-dan-bangunan.show', $item->id) }}"
                                        title="Lihat Detail Gedung"
                                        class="rounded p-1 text-zinc-400 hover:bg-zinc-100 hover:text-zinc-700 transition-colors">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.573 16.49 16.638 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        </svg>
                                    </a>
                                    <a href="{{ route('gedung-dan-bangunan.edit', $item->id) }}"
                                        title="Edit Gedung"
                                        class="rounded p-1 text-zinc-400 hover:bg-zinc-100 hover:text-zinc-700 transition-colors">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('gedung-dan-bangunan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data Gedung/Bangunan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Hapus Gedung" class="rounded p-1 text-red-400 hover:bg-red-50 hover:text-red-600 transition-colors">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="18" class="px-4 py-12 text-center text-zinc-500">
                                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-zinc-100 text-zinc-400 mb-3">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12" />
                                    </svg>
                                </div>
                                <p class="font-medium text-zinc-900">Belum ada data Gedung dan Bangunan</p>
                                <p class="text-xs text-zinc-500 mt-1">Data aset gedung & bangunan (KIB C) yang ditambahkan akan muncul di sini.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot class="bg-zinc-50 font-bold text-zinc-900 border-t border-zinc-300">
                    <tr>
                        <td colspan="11" class="px-3 py-2 text-center border-r border-zinc-200">Jumlah Total</td>
                        <td class="px-2 py-2 text-right border-r border-zinc-200">{{ number_format($items->sum('luas_tanah'), 0, ',', '.') }}</td>
                        <td colspan="3" class="border-r border-zinc-200"></td>
                        <td class="px-3 py-2 text-right border-r border-zinc-200">Rp {{ number_format($items->sum(fn($i) => $i->harga_satuan * $i->jumlah_total), 0, ',', '.') }}</td>
                        <td colspan="2"></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        @if($items->hasPages())
            <div class="border-t border-zinc-200 px-4 py-3">
                {{ $items->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
