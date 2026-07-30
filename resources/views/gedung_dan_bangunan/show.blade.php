@extends('layouts.app')

@section('title', 'Detail Gedung & Bangunan - ' . $gedungDanBangunan->nama_barang)

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    {{-- Top Back & Actions Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <a href="{{ route('gedung-dan-bangunan.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-zinc-500 hover:text-zinc-900 transition-colors mb-1">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
                Kembali ke Data Gedung & Bangunan
            </a>
            <div class="flex items-center gap-3">
                <h1 class="text-2xl font-bold text-zinc-900 tracking-tight">{{ $gedungDanBangunan->nama_barang }}</h1>
                @if($gedungDanBangunan->kondisi === 'baik')
                    <span class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-medium text-emerald-700 ring-1 ring-inset ring-emerald-600/20">B : Baik</span>
                @elseif($gedungDanBangunan->kondisi === 'rusak_ringan')
                    <span class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-0.5 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-600/20">RR : Rusak Ringan</span>
                @elseif($gedungDanBangunan->kondisi === 'rusak_sedang')
                    <span class="inline-flex items-center rounded-full bg-amber-50 px-2.5 py-0.5 text-xs font-medium text-amber-700 ring-1 ring-inset ring-amber-600/20">RS : Rusak Sedang</span>
                @elseif($gedungDanBangunan->kondisi === 'rusak_berat' || $gedungDanBangunan->kondisi === 'rusak')
                    <span class="inline-flex items-center rounded-full bg-red-50 px-2.5 py-0.5 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/20">RB : Rusak Berat</span>
                @else
                    <span class="inline-flex items-center rounded-full bg-zinc-50 px-2.5 py-0.5 text-xs font-medium text-zinc-700 ring-1 ring-inset ring-zinc-600/20">{{ strtoupper($gedungDanBangunan->kondisi) }}</span>
                @endif
            </div>
            <p class="text-xs font-mono text-zinc-500 mt-1">Kode Barang: {{ $gedungDanBangunan->kode_inventaris }}</p>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            @if($gedungDanBangunan->foto_url)
                <a href="{{ $gedungDanBangunan->foto_url }}" target="_blank"
                    class="inline-flex items-center gap-2 rounded-md border border-blue-200 bg-blue-50 text-blue-800 hover:bg-blue-100 px-3.5 py-2 text-sm font-medium shadow-sm transition-all duration-150">
                    <svg class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244" />
                    </svg>
                    Buka Foto Google Drive
                </a>
            @endif

            <a href="{{ route('gedung-dan-bangunan.print-kib-c') }}" target="_blank"
                class="inline-flex items-center gap-2 rounded-md border border-emerald-200 bg-emerald-50 text-emerald-800 hover:bg-emerald-100 px-3.5 py-2 text-sm font-medium shadow-sm transition-all duration-150">
                <svg class="w-4 h-4 text-emerald-700" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096a42.415 42.415 0 0 0-10.56 0m10.56 0L17.66 18" />
                </svg>
                Cetak KIB C
            </a>

            <a href="{{ route('gedung-dan-bangunan.edit', $gedungDanBangunan->id) }}"
                class="inline-flex items-center gap-2 rounded-md bg-zinc-900 text-zinc-50 hover:bg-zinc-800 px-4 py-2 text-sm font-medium shadow-sm transition-all duration-150">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                </svg>
                Edit Gedung
            </a>
        </div>
    </div>

    {{-- Detail Cards Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Card 1: Informasi Utama & Lokasi --}}
        <div class="rounded-xl border border-zinc-200 bg-white p-6 shadow-sm space-y-4">
            <h3 class="text-sm font-bold uppercase tracking-wider text-zinc-500 border-b border-zinc-100 pb-3 flex items-center gap-2">
                <svg class="w-4 h-4 text-zinc-700" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12" />
                </svg>
                1. Informasi Utama & Lokasi
            </h3>

            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                <div>
                    <dt class="font-semibold text-zinc-500 uppercase tracking-wider text-[10px]">Nama Gedung / Bangunan</dt>
                    <dd class="mt-1 font-bold text-zinc-900 text-sm">{{ $gedungDanBangunan->nama_barang }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-zinc-500 uppercase tracking-wider text-[10px]">Kode Barang</dt>
                    <dd class="mt-1 font-mono font-bold text-zinc-800 text-sm">{{ $gedungDanBangunan->kode_inventaris }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-zinc-500 uppercase tracking-wider text-[10px]">Jenis Modal</dt>
                    <dd class="mt-1 font-semibold text-zinc-800">{{ $gedungDanBangunan->jenisModal->nama_jenis_modal ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-zinc-500 uppercase tracking-wider text-[10px]">Kategori Barang</dt>
                    <dd class="mt-1 font-semibold text-zinc-800">{{ $gedungDanBangunan->kategori->nama_kategori ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-zinc-500 uppercase tracking-wider text-[10px]">Unit Kerja / Jurusan</dt>
                    <dd class="mt-1 text-zinc-800 font-medium">{{ $gedungDanBangunan->jurusan->nama_jurusan ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-zinc-500 uppercase tracking-wider text-[10px]">Ruangan / Lokasi</dt>
                    <dd class="mt-1 text-zinc-800 font-medium">{{ $gedungDanBangunan->ruangan->nama_ruangan ?? '-' }}</dd>
                </div>
                <div class="sm:col-span-2">
                    <dt class="font-semibold text-zinc-500 uppercase tracking-wider text-[10px]">Letak / Lokasi Alamat Gedung</dt>
                    <dd class="mt-1 text-zinc-800 font-medium bg-zinc-50 p-2.5 rounded-md border border-zinc-200">
                        {{ $gedungDanBangunan->lokasi_alamat ?: ($gedungDanBangunan->ruangan?->nama_ruangan ?? 'Jalan Tentara Genie Pelajar No. 26, Sawahan, Surabaya') }}
                    </dd>
                </div>
            </dl>
        </div>

        {{-- Card 2: Spesifikasi KIB C & Konstruksi --}}
        <div class="rounded-xl border border-zinc-200 bg-white p-6 shadow-sm space-y-4">
            <h3 class="text-sm font-bold uppercase tracking-wider text-zinc-500 border-b border-zinc-100 pb-3 flex items-center gap-2">
                <svg class="w-4 h-4 text-zinc-700" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17 17.25 21A2.652 2.652 0 0 0 21 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 1 1-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 0 0 4.486-4.486c.048-.58-.024-1.193-.188-1.743" />
                </svg>
                2. Spesifikasi KIB C & Konstruksi
            </h3>

            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                <div>
                    <dt class="font-semibold text-zinc-500 uppercase tracking-wider text-[10px]">Konstruksi Bertingkat?</dt>
                    <dd class="mt-1 font-semibold text-zinc-900">{{ $gedungDanBangunan->konstruksi_bertingkat ?: 'Tidak' }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-zinc-500 uppercase tracking-wider text-[10px]">Konstruksi Beton?</dt>
                    <dd class="mt-1 font-semibold text-zinc-900">{{ $gedungDanBangunan->konstruksi_beton ?: 'Beton (BTN)' }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-zinc-500 uppercase tracking-wider text-[10px]">Luas Lantai (m²)</dt>
                    <dd class="mt-1 font-bold text-zinc-900 text-sm">{{ number_format($gedungDanBangunan->luas_lantai ?? 0, 0, ',', '.') }} m²</dd>
                </div>
                <div>
                    <dt class="font-semibold text-zinc-500 uppercase tracking-wider text-[10px]">Luas Tanah (m²)</dt>
                    <dd class="mt-1 font-bold text-zinc-900 text-sm">{{ number_format($gedungDanBangunan->luas_tanah ?? 0, 0, ',', '.') }} m²</dd>
                </div>
                <div>
                    <dt class="font-semibold text-zinc-500 uppercase tracking-wider text-[10px]">Status Tanah</dt>
                    <dd class="mt-1 text-zinc-800 font-medium">{{ $gedungDanBangunan->status_tanah ?: 'Hak Pakai' }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-zinc-500 uppercase tracking-wider text-[10px]">Nomor Kode Tanah</dt>
                    <dd class="mt-1 font-mono text-zinc-800 font-medium">{{ $gedungDanBangunan->nomor_kode_tanah ?: '-' }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-zinc-500 uppercase tracking-wider text-[10px]">Nomor Dokumen Bangunan</dt>
                    <dd class="mt-1 font-mono text-zinc-800 font-medium">{{ $gedungDanBangunan->dokumen_nomor ?: ($gedungDanBangunan->nomor_surat_bast ?: '-') }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-zinc-500 uppercase tracking-wider text-[10px]">Tanggal Dokumen Bangunan</dt>
                    <dd class="mt-1 text-zinc-800 font-medium">
                        {{ optional($gedungDanBangunan->dokumen_tanggal ?? $gedungDanBangunan->tanggal_bast ?? $gedungDanBangunan->tanggal_catat_aset)->translatedFormat('d F Y') ?? '-' }}
                    </dd>
                </div>
            </dl>
        </div>

        {{-- Card 3: Keuangan & Nilai Aset --}}
        <div class="rounded-xl border border-zinc-200 bg-white p-6 shadow-sm space-y-4">
            <h3 class="text-sm font-bold uppercase tracking-wider text-zinc-500 border-b border-zinc-100 pb-3 flex items-center gap-2">
                <svg class="w-4 h-4 text-zinc-700" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-6h6m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                3. Keuangan, Nilai & Perolehan
            </h3>

            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                <div>
                    <dt class="font-semibold text-zinc-500 uppercase tracking-wider text-[10px]">Nilai / Harga Bangunan</dt>
                    <dd class="mt-1 font-bold text-emerald-700 text-sm">Rp {{ number_format($gedungDanBangunan->harga_satuan, 0, ',', '.') }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-zinc-500 uppercase tracking-wider text-[10px]">Jumlah Unit</dt>
                    <dd class="mt-1 font-bold text-zinc-900 text-sm">{{ number_format($gedungDanBangunan->jumlah_total, 0, ',', '.') }} Unit</dd>
                </div>
                <div>
                    <dt class="font-semibold text-zinc-500 uppercase tracking-wider text-[10px]">Total Nilai Aset</dt>
                    <dd class="mt-1 font-bold text-emerald-700 text-base">
                        Rp {{ number_format($gedungDanBangunan->harga_satuan * $gedungDanBangunan->jumlah_total, 0, ',', '.') }}
                    </dd>
                </div>
                <div>
                    <dt class="font-semibold text-zinc-500 uppercase tracking-wider text-[10px]">Asal Usul / Sumber Dana</dt>
                    <dd class="mt-1 text-zinc-800 font-semibold">{{ $gedungDanBangunan->sumber_dana ?: 'APBD' }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-zinc-500 uppercase tracking-wider text-[10px]">Tanggal BAST</dt>
                    <dd class="mt-1 text-zinc-800 font-medium">
                        {{ $gedungDanBangunan->tanggal_bast ? $gedungDanBangunan->tanggal_bast->translatedFormat('d F Y') : '-' }}
                    </dd>
                </div>
                <div>
                    <dt class="font-semibold text-zinc-500 uppercase tracking-wider text-[10px]">Tanggal Catat Aset</dt>
                    <dd class="mt-1 text-zinc-800 font-medium">
                        {{ $gedungDanBangunan->tanggal_catat_aset ? $gedungDanBangunan->tanggal_catat_aset->translatedFormat('d F Y') : '-' }}
                    </dd>
                </div>
            </dl>
        </div>

        {{-- Card 4: Dokumentasi Foto Google Drive --}}
        <div class="rounded-xl border border-zinc-200 bg-white p-6 shadow-sm space-y-4">
            <h3 class="text-sm font-bold uppercase tracking-wider text-zinc-500 border-b border-zinc-100 pb-3 flex items-center gap-2">
                <svg class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                </svg>
                4. Dokumentasi Foto Bangunan
            </h3>

            @if($gedungDanBangunan->foto_url)
                <div class="rounded-lg bg-blue-50/70 border border-blue-200 p-4 space-y-3">
                    <div class="flex items-center gap-2.5">
                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-blue-600 text-white shrink-0">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-blue-900">Google Drive Berkas/Foto Gedung Tersedia</h4>
                            <p class="text-[11px] text-blue-700 truncate max-w-xs sm:max-w-md">{{ $gedungDanBangunan->foto_url }}</p>
                        </div>
                    </div>
                    <a href="{{ $gedungDanBangunan->foto_url }}" target="_blank"
                        class="inline-flex items-center gap-2 rounded-md bg-blue-600 hover:bg-blue-700 text-white px-3.5 py-2 text-xs font-semibold shadow-sm transition-colors w-full justify-center">
                        Buka Foto Bangunan di Tab Baru &rarr;
                    </a>
                </div>
            @else
                <div class="rounded-lg border border-dashed border-zinc-200 bg-zinc-50 p-6 text-center text-xs text-zinc-500">
                    <p class="font-medium text-zinc-700">Belum ada link Google Drive foto bangunan</p>
                    <p class="text-[11px] text-zinc-400 mt-1">Anda dapat menambahkan link Google Drive melalui menu Edit Gedung.</p>
                </div>
            @endif
        </div>

    </div>

</div>
@endsection
