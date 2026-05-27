@extends('layouts.app')

@section('title', 'Detail Peminjaman - Inventaris SMKN 2 SBY')
@section('page_title', 'Detail Peminjaman')

@section('content')
<div class="space-y-6 max-w-2xl">
    <nav class="flex items-center gap-1.5 text-sm text-zinc-500 print:hidden">
        <a href="{{ route('dashboard') }}" class="hover:text-zinc-900 transition-colors">Dashboard</a>
        <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
        </svg>
        <a href="{{ route('peminjamans.index') }}" class="hover:text-zinc-900 transition-colors">Peminjaman</a>
        <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
        </svg>
        <span class="font-medium text-zinc-900">Detail Peminjaman</span>
    </nav>

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 print:hidden">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-zinc-900">Peminjaman Barang</h2>
            <p class="text-sm text-zinc-500">Detail peminjaman eksternal.</p>
        </div>
        <div class="flex items-center gap-2">
            <button onclick="window.print()" class="inline-flex items-center gap-2 rounded-md bg-zinc-900 text-zinc-50 px-4 py-2 text-sm font-medium">Cetak Bukti</button>
            <a href="{{ route('peminjamans.index') }}" class="inline-flex items-center gap-2 rounded-md border border-zinc-200 px-4 py-2 text-sm">Kembali</a>
        </div>
    </div>

    <div class="rounded-lg border border-zinc-200 bg-white shadow-sm overflow-hidden divide-y divide-zinc-100">
        <div class="p-6 bg-zinc-50/50 grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <span class="text-[10px] font-semibold text-zinc-400 uppercase tracking-widest">Nama Peminjam</span>
                <p class="text-sm font-bold text-zinc-900 tracking-tight">{{ $peminjaman->nama_peminjam }}</p>
            </div>
            <div>
                <span class="text-[10px] font-semibold text-zinc-400 uppercase tracking-widest">Instansi / Kontak</span>
                <p class="text-[10px] text-zinc-500 tracking-tight">{{ $peminjaman->instansi }} — {{ $peminjaman->kontak }}</p>
            </div>
            <div class="sm:text-right">
                <span class="text-[10px] font-semibold text-zinc-400 uppercase tracking-widest">Status</span>
                <p class="text-sm font-semibold text-zinc-900">{{ $peminjaman->status }}</p>
            </div>
        </div>

        <div class="p-6 space-y-6">
            <div class="space-y-2">
                <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider">Barang yang Dipinjam</span>
                <div class="flex items-start gap-4 p-4 rounded-lg border border-zinc-100 bg-zinc-50/30">
                    <div>
                        <div class="font-medium text-zinc-900">{{ $peminjaman->inventaris->nama_barang ?? '-' }}</div>
                        <div class="text-xs text-zinc-400 font-mono">{{ $peminjaman->inventaris->kode_inventaris ?? '' }}</div>
                        <div class="text-xs text-zinc-600 mt-1">Jumlah dipinjam: <strong>{{ $peminjaman->jumlah_pinjam }}</strong></div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 pt-2">
                <div>
                    <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider">Tanggal Pinjam</span>
                    <div class="text-sm text-zinc-900">{{ $peminjaman->tanggal_pinjam->format('d F Y') }}</div>
                </div>
                <div>
                    <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider">Estimasi Kembali</span>
                    <div class="text-sm text-zinc-900">{{ optional($peminjaman->tanggal_estimasi_kembali)->format('d F Y') ?? '-' }}</div>
                </div>
                <div>
                    <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider">Diproses Oleh</span>
                    <div class="text-sm text-zinc-900">{{ $peminjaman->user->nama ?? '-' }}</div>
                </div>
            </div>

            <div class="space-y-1.5 pt-2">
                <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider">Keterangan</span>
                <div class="text-sm text-zinc-700">-</div>
            </div>
        </div>
    </div>

    <div class="hidden print:block print-document bg-white text-zinc-950 p-8 font-serif leading-relaxed border border-zinc-300">
        <div class="text-center mb-6">
            <h2 class="text-base font-bold uppercase">Surat Bukti Peminjaman Barang</h2>
            <p class="text-xs font-mono mt-1">{{ $peminjaman->created_at->format('d F Y') }}</p>
        </div>

        <p class="text-xs mb-4">Yang bertanda tangan di bawah ini, mencatat peminjaman barang sebagai berikut:</p>

        <table class="w-full text-xs border-collapse border border-zinc-950 mb-6">
            <tbody>
                <tr>
                    <td class="p-2 font-semibold">Nama Peminjam</td>
                    <td class="p-2">: {{ $peminjaman->nama_peminjam }}</td>
                </tr>
                <tr>
                    <td class="p-2 font-semibold">Instansi / Kontak</td>
                    <td class="p-2">: {{ $peminjaman->instansi }} / {{ $peminjaman->kontak }}</td>
                </tr>
                <tr>
                    <td class="p-2 font-semibold">Barang</td>
                    <td class="p-2">: {{ $peminjaman->inventaris->nama_barang ?? '-' }} ({{ $peminjaman->inventaris->kode_inventaris ?? '' }})</td>
                </tr>
                <tr>
                    <td class="p-2 font-semibold">Jumlah</td>
                    <td class="p-2">: {{ $peminjaman->jumlah_pinjam }}</td>
                </tr>
                <tr>
                    <td class="p-2 font-semibold">Tanggal Pinjam</td>
                    <td class="p-2">: {{ $peminjaman->tanggal_pinjam->format('d F Y') }}</td>
                </tr>
                <tr>
                    <td class="p-2 font-semibold">Estimasi Kembali</td>
                    <td class="p-2">: {{ optional($peminjaman->tanggal_estimasi_kembali)->format('d F Y') ?? '-' }}</td>
                </tr>
            </tbody>
        </table>

        <div class="grid grid-cols-3 gap-4 text-xs text-center mt-8">
            <div>
                <div class="font-semibold">Peminjam</div>
                <div class="mt-8">(....................................)</div>
            </div>
            <div>
                <div class="font-semibold">Petugas</div>
                <div class="mt-8">{{ $peminjaman->user->nama ?? '-' }}</div>
            </div>
            <div>
                <div class="font-semibold">Penanggung Jawab</div>
                <div class="mt-8">(....................................)</div>
            </div>
        </div>
    </div>
</div>
@endsection
