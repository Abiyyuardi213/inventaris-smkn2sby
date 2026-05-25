@extends('layouts.app')

@section('title', 'Detail Mutasi - Inventaris SMKN 2 SBY')
@section('page_title', 'Detail Mutasi')

@section('content')
<style>
    @media print {
        /* Sembunyikan sidebar, navbar, footer, tombol, dan elemen non-cetak lainnya */
        aside, header, nav, footer, button, .print\:hidden, .print-hide-card {
            display: none !important;
        }

        /* Hilangkan overflow, margin, dan padding dari layout utama laravel */
        body, html, main, .space-y-6, .max-w-2xl {
            background: transparent !important;
            box-shadow: none !important;
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
        }

        /* Tampilkan dokumen khusus cetak */
        .print-document {
            display: block !important;
            visibility: visible !important;
        }
    }
</style>

<div class="space-y-6 max-w-2xl">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-1.5 text-sm text-zinc-500 print:hidden">
        <a href="{{ route('dashboard') }}" class="hover:text-zinc-900 transition-colors">Dashboard</a>
        <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
        </svg>
        <a href="{{ route('mutasis.index') }}" class="hover:text-zinc-900 transition-colors">Riwayat Mutasi</a>
        <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
        </svg>
        <span class="font-medium text-zinc-900">Detail Mutasi {{ $mutasi->nomor_mutasi }}</span>
    </nav>

    {{-- Header Section --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 print:hidden">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-zinc-900">Log Mutasi</h2>
            <p class="text-sm text-zinc-500">Detail data pemindahan aset secara internal.</p>
        </div>
        <div class="flex items-center gap-2">
            <button onclick="window.print()"
                class="inline-flex items-center justify-center gap-2 rounded-md bg-zinc-900 text-zinc-50 hover:bg-zinc-800 px-4 py-2 text-sm font-medium shadow-sm transition-all duration-150 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-950 cursor-pointer">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0a2.25 2.25 0 0 1-2.24 2.153H8.58a2.25 2.25 0 0 1-2.24-2.153m11.32 0-1-4.171m-9.32 0 1-4.171m0 0a3 3 0 0 1 2.25-2.785m0 0c.071-.018.143-.035.215-.051m.9-.161a3 3 0 0 1 5.723 0M10.5 11.25h.008v.008h-.008v-.008Zm3.75 0h.008v.008h-.008v-.008Z" />
                </svg>
                Cetak PDF Bukti
            </button>
            <a href="{{ route('mutasis.index') }}"
                class="inline-flex items-center justify-center gap-2 rounded-md border border-zinc-200 text-zinc-700 bg-white hover:bg-zinc-50 px-4 py-2 text-sm font-medium shadow-sm transition-all duration-150 cursor-pointer">
                Kembali
            </a>
        </div>
    </div>

    {{-- Detail Card --}}
    <div class="rounded-lg border border-zinc-200 bg-white shadow-sm overflow-hidden divide-y divide-zinc-100 print-hide-card">
        
        {{-- Card Header --}}
        <div class="p-6 bg-zinc-50/50 grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <span class="text-[10px] font-semibold text-zinc-400 uppercase tracking-widest">Nomor Mutasi</span>
                <p class="text-sm font-mono font-bold text-zinc-900 tracking-tight">{{ $mutasi->nomor_mutasi }}</p>
            </div>
            <div>
                <span class="text-[10px] font-semibold text-zinc-400 uppercase tracking-widest">ID Mutasi (UUID)</span>
                <p class="text-[10px] font-mono text-zinc-500 tracking-tight">{{ $mutasi->id }}</p>
            </div>
            <div class="sm:text-right">
                <span class="text-[10px] font-semibold text-zinc-400 uppercase tracking-widest">Tanggal Mutasi</span>
                <p class="text-sm font-semibold text-zinc-900">{{ $mutasi->tanggal_mutasi->format('d F Y') }}</p>
            </div>
        </div>

        {{-- Card Body --}}
        <div class="p-6 space-y-6">
            
            {{-- Bagian Barang --}}
            <div class="space-y-2">
                <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider">Aset Barang</span>
                <div class="flex items-start gap-4 p-4 rounded-lg border border-zinc-100 bg-zinc-50/30">
                    <div class="w-10 h-10 rounded-md bg-zinc-900 flex items-center justify-center text-white text-xs font-bold shrink-0">
                        {{ strtoupper(substr($mutasi->inventaris->nama_barang, 0, 2)) }}
                    </div>
                    <div class="min-w-0 flex-1">
                        <h4 class="font-bold text-zinc-900 truncate">{{ $mutasi->inventaris->nama_barang }}</h4>
                        <p class="text-xs text-zinc-500 font-mono mt-0.5">{{ $mutasi->inventaris->kode_inventaris }}</p>
                        <div class="flex flex-wrap items-center gap-2 mt-2">
                            <span class="inline-flex items-center text-[10px] font-medium text-zinc-500 bg-zinc-100 rounded px-1.5 py-0.5 border border-zinc-200">
                                Kategori: {{ $mutasi->inventaris->kategori->nama_kategori }}
                            </span>
                            <span class="inline-flex items-center text-[10px] font-medium text-zinc-500 bg-zinc-100 rounded px-1.5 py-0.5 border border-zinc-200">
                                Merek: {{ $mutasi->inventaris->merek }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Alur Perpindahan --}}
            <div class="space-y-2">
                <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider">Alur Perpindahan Ruangan</span>
                <div class="grid grid-cols-1 sm:grid-cols-7 gap-4 items-center">
                    
                    {{-- Ruangan Asal --}}
                    <div class="sm:col-span-3 p-4 rounded-lg border border-zinc-200 bg-white shadow-sm space-y-1">
                        <span class="text-[10px] font-semibold text-zinc-400 uppercase tracking-wider">Dari (Ruangan Asal)</span>
                        <h4 class="font-bold text-zinc-800">{{ $mutasi->ruanganAsal->nama_ruangan }}</h4>
                        <p class="text-xs text-zinc-500 leading-tight">{{ $mutasi->ruanganAsal->jurusan->nama_jurusan }}</p>
                    </div>

                    {{-- Arrow Indicator --}}
                    <div class="sm:col-span-1 flex items-center justify-center">
                        <div class="p-2 rounded-full bg-zinc-100 border border-zinc-200/50">
                            <svg class="w-5 h-5 text-zinc-600 rotate-90 sm:rotate-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                            </svg>
                        </div>
                    </div>

                    {{-- Ruangan Tujuan --}}
                    <div class="sm:col-span-3 p-4 rounded-lg border border-emerald-200 bg-emerald-50/30 shadow-sm space-y-1">
                        <span class="text-[10px] font-semibold text-emerald-600 uppercase tracking-wider">Ke (Ruangan Tujuan)</span>
                        <h4 class="font-bold text-emerald-800">{{ $mutasi->ruanganTujuan->nama_ruangan }}</h4>
                        <p class="text-xs text-emerald-600/80 leading-tight">{{ $mutasi->ruanganTujuan->jurusan->nama_jurusan }}</p>
                    </div>

                </div>
            </div>

            {{-- Kuantitas, Penanggung Jawab & Pelaksana --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 pt-2">
                <div>
                    <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider">Jumlah yang Dipindah</span>
                    <p class="text-2xl font-black text-zinc-900 mt-1">{{ $mutasi->jumlah_dipindah }} <span class="text-xs font-medium text-zinc-400">unit</span></p>
                </div>
                <div>
                    <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider">Penanggung Jawab</span>
                    <p class="text-base font-bold text-zinc-800 mt-1.5">{{ $mutasi->penanggung_jawab }}</p>
                </div>
                <div>
                    <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider">Aktor Pelaksana</span>
                    <p class="text-base font-bold text-zinc-800 mt-1.5">{{ $mutasi->user->nama }}</p>
                    <p class="text-xs text-zinc-500 font-mono">{{ $mutasi->user->email }}</p>
                </div>
            </div>

            {{-- Keterangan --}}
            <div class="space-y-1.5 pt-2">
                <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider">Keterangan / Alasan Pindah</span>
                <p class="text-sm text-zinc-700 bg-zinc-50 border border-zinc-200/60 rounded-md p-4 leading-relaxed italic">
                    "{{ $mutasi->keterangan_pindah }}"
                </p>
            </div>

        </div>

    </div>

    {{-- Dokumen Bukti Mutasi Khusus Cetak (Hidden by default, visible on print) --}}
    <div class="hidden print:block print-document bg-white text-zinc-950 p-8 font-serif leading-relaxed border border-zinc-300">
        <!-- Kop Surat (School Header) -->
        <table class="w-full border-b-4 border-double border-zinc-950 pb-2 mb-6">
            <tr>
                <td class="w-16 text-left align-middle" style="padding-bottom: 8px; width: 64px;">
                    <img src="{{ asset('image/smkn2sby.png') }}" alt="Logo SMKN 2 Surabaya" class="h-16 w-16 object-contain" style="display: block;">
                </td>
                <td class="text-center align-middle" style="padding-bottom: 8px; padding-right: 64px;">
                    <h3 class="text-xs font-bold uppercase tracking-wide leading-tight" style="margin: 0; padding: 0;">Pemerintah Provinsi Jawa Timur</h3>
                    <h3 class="text-xs font-bold uppercase tracking-wide leading-tight" style="margin: 2px 0 0 0; padding: 0;">Dinas Pendidikan</h3>
                    <h2 class="text-sm font-black uppercase tracking-widest" style="margin: 4px 0 0 0; padding: 0;">SMK Negeri 2 Surabaya</h2>
                    <p class="text-[9px] font-sans font-light" style="margin: 4px 0 0 0; padding: 0;">Jl. Landungsari No. 1, Surabaya | Telp: (031) 123456 | Email: smkn2sby@sch.id</p>
                </td>
            </tr>
        </table>

        <!-- Judul Dokumen -->
        <div class="text-center mb-6">
            <h2 class="text-base font-bold underline uppercase tracking-wider">Surat Bukti Mutasi Barang</h2>
            <p class="text-xs font-mono mt-1">Nomor: {{ $mutasi->nomor_mutasi }}</p>
        </div>

        <!-- Rincian -->
        <p class="text-xs mb-4">Pada hari ini, tanggal <strong>{{ $mutasi->tanggal_mutasi->format('d F Y') }}</strong>, telah dilakukan pemindahan (mutasi) aset barang inventaris sekolah dengan rincian sebagai berikut:</p>

        <table class="w-full text-xs border-collapse border border-zinc-950 mb-6">
            <tbody>
                <tr class="border border-zinc-950">
                    <td class="px-4 py-2 font-bold w-1/3 border-r border-zinc-950 bg-zinc-50">Nama Barang</td>
                    <td class="px-4 py-2 font-sans">{{ $mutasi->inventaris->nama_barang }}</td>
                </tr>
                <tr class="border border-zinc-950">
                    <td class="px-4 py-2 font-bold border-r border-zinc-950 bg-zinc-50">Kode Inventaris</td>
                    <td class="px-4 py-2 font-mono font-semibold">{{ $mutasi->inventaris->kode_inventaris }}</td>
                </tr>
                <tr class="border border-zinc-950">
                    <td class="px-4 py-2 font-bold border-r border-zinc-950 bg-zinc-50">Merek / Kategori</td>
                    <td class="px-4 py-2 font-sans">{{ $mutasi->inventaris->merek }} ({{ $mutasi->inventaris->kategori->nama_kategori }})</td>
                </tr>
                <tr class="border border-zinc-950">
                    <td class="px-4 py-2 font-bold border-r border-zinc-950 bg-zinc-50">Spesifikasi</td>
                    <td class="px-4 py-2 text-[10px] font-sans">{{ $mutasi->inventaris->spesifikasi }}</td>
                </tr>
                <tr class="border border-zinc-950">
                    <td class="px-4 py-2 font-bold border-r border-zinc-950 bg-zinc-50">Jumlah Terpindah</td>
                    <td class="px-4 py-2 font-sans font-bold">{{ $mutasi->jumlah_dipindah }} unit</td>
                </tr>
                <tr class="border border-zinc-950">
                    <td class="px-4 py-2 font-bold border-r border-zinc-950 bg-zinc-50">Ruangan Asal</td>
                    <td class="px-4 py-2 font-sans">{{ $mutasi->ruanganAsal->nama_ruangan }} ({{ $mutasi->ruanganAsal->jurusan->nama_jurusan }})</td>
                </tr>
                <tr class="border border-zinc-950">
                    <td class="px-4 py-2 font-bold border-r border-zinc-950 bg-zinc-50">Ruangan Tujuan</td>
                    <td class="px-4 py-2 font-sans font-bold">{{ $mutasi->ruanganTujuan->nama_ruangan }} ({{ $mutasi->ruanganTujuan->jurusan->nama_jurusan }})</td>
                </tr>
                <tr class="border border-zinc-950">
                    <td class="px-4 py-2 font-bold border-r border-zinc-950 bg-zinc-50">Penanggung Jawab</td>
                    <td class="px-4 py-2 font-sans font-bold">{{ $mutasi->penanggung_jawab }}</td>
                </tr>
                <tr class="border border-zinc-950">
                    <td class="px-4 py-2 font-bold border-r border-zinc-950 bg-zinc-50">Keterangan Mutasi</td>
                    <td class="px-4 py-2 font-sans italic">"{{ $mutasi->keterangan_pindah }}"</td>
                </tr>
            </tbody>
        </table>

        <p class="text-xs mb-8">Demikian surat bukti mutasi barang ini dibuat dengan sebenar-benarnya untuk dapat dipergunakan sebagaimana mestinya.</p>

        <!-- Tanda Tangan -->
        <div class="grid grid-cols-3 gap-4 text-xs text-center mt-8">
            <div>
                <p>Penanggung Jawab,</p>
                <div class="h-16"></div>
                <p class="font-bold underline font-sans">{{ $mutasi->penanggung_jawab }}</p>
                <p class="text-[10px] text-zinc-500 font-sans">Guru / Staf Penanggung Jawab</p>
            </div>
            <div>
                <p>Mengetahui,</p>
                <p class="text-[10px]">Kepala Sarana Prasarana</p>
                <div class="h-12"></div>
                <p class="font-bold underline font-sans">............................................</p>
                <p class="text-[10px] text-zinc-500 font-sans">NIP. ....................................</p>
            </div>
            <div>
                <p>Petugas Pelaksana,</p>
                <div class="h-16"></div>
                <p class="font-bold underline font-sans">{{ $mutasi->user->nama }}</p>
                <p class="text-[10px] text-zinc-500 font-sans">Petugas Sarpras</p>
            </div>
        </div>
    </div>

</div>
@endsection
