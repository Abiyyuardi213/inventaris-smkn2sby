@extends('layouts.app')

@section('title', 'Riwayat Keputusan (Kepsek) - Inventaris SMKN 2 SBY')
@section('page_title', 'Riwayat Keputusan')

@section('content')
<div class="space-y-6">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-1.5 text-sm text-zinc-500">
        <a href="{{ route('dashboard') }}" class="hover:text-zinc-900 transition-colors">Dashboard</a>
        <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
        </svg>
        <a href="{{ route('approvals-kepsek.index') }}" class="hover:text-zinc-900 transition-colors">Approval Pengadaan (Kepsek)</a>
        <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
        </svg>
        <span class="font-medium text-zinc-900">Riwayat Keputusan</span>
    </nav>

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-zinc-900 font-sans">Riwayat Keputusan Pengadaan</h2>
            <p class="text-sm text-zinc-500 mt-0.5 font-sans">Rekam jejak persetujuan dan penolakan usulan oleh Kepala Sekolah.</p>
        </div>
    </div>

    {{-- Filter Card --}}
    <div class="rounded-lg border border-zinc-200 bg-white p-4 shadow-sm">
        <form method="GET" action="{{ route('approvals-kepsek.riwayat') }}" class="flex flex-wrap items-center gap-3">
            <div class="flex items-center gap-2">
                <label for="status" class="text-xs font-bold text-zinc-500 uppercase tracking-wider font-sans">Filter Status:</label>
                <select id="status" name="status" onchange="this.form.submit()"
                    class="rounded-md border border-zinc-200 bg-white px-3 py-1.5 text-xs text-zinc-700 font-semibold focus:outline-none shadow-sm cursor-pointer">
                    <option value="">Semua Keputusan</option>
                    <option value="disetujui_kepsek" {{ request('status') === 'disetujui_kepsek' ? 'selected' : '' }}>Disetujui Final</option>
                    <option value="ditolak_kepsek" {{ request('status') === 'ditolak_kepsek' ? 'selected' : '' }}>Ditolak Kepsek</option>
                </select>
            </div>
            
            @if (request('status'))
                <a href="{{ route('approvals-kepsek.riwayat') }}" class="text-xs font-medium text-zinc-500 hover:text-zinc-900 transition-colors font-sans">
                    Reset Filter
                </a>
            @endif
        </form>
    </div>

    {{-- Table Card --}}
    <div class="rounded-lg border border-zinc-200 bg-white shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs uppercase bg-zinc-50 text-zinc-500 border-b border-zinc-200">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-semibold w-12 text-center font-sans">No</th>
                        <th scope="col" class="px-6 py-4 font-semibold font-sans">Nama Barang</th>
                        <th scope="col" class="px-6 py-4 font-semibold font-sans">Jurusan</th>
                        <th scope="col" class="px-6 py-4 font-semibold text-center font-sans">Qty</th>
                        <th scope="col" class="px-6 py-4 font-semibold font-sans">Perkiraan Harga</th>
                        <th scope="col" class="px-6 py-4 font-semibold text-center font-sans">Status</th>
                        <th scope="col" class="px-6 py-4 font-semibold font-sans">Catatan Kepsek</th>
                        <th scope="col" class="px-6 py-4 font-semibold font-sans">Diproses Pada</th>
                        <th scope="col" class="px-6 py-4 font-semibold text-right font-sans">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    @forelse ($riwayatPengadaans as $r)
                        <tr class="hover:bg-zinc-50/60 transition-colors {{ $loop->even ? 'bg-zinc-50/30' : 'bg-white' }}">
                            <td class="px-6 py-4 text-center text-zinc-400 font-mono text-xs">
                                {{ $loop->iteration }}
                            </td>
                            <td class="px-6 py-4 font-medium text-zinc-900 font-sans">
                                {{ $r->nama_barang_usulan }}
                            </td>
                            <td class="px-6 py-4 text-zinc-600 font-sans">
                                {{ $r->jurusan->nama_jurusan ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-center text-zinc-800 font-semibold font-sans">
                                {{ $r->jumlah }}
                            </td>
                            <td class="px-6 py-4 text-zinc-900 font-semibold font-sans">
                                Rp {{ number_format($r->perkiraan_harga, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <x-status-pengadaan-badge :status="$r->status_usulan" />
                            </td>
                            <td class="px-6 py-4 text-zinc-500 text-xs italic font-sans max-w-xs truncate" title="{{ $r->catatan_kepsek }}">
                                {{ $r->catatan_kepsek ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-zinc-500 text-xs font-sans">
                                {{ $r->approved_by_kepsek_at ? $r->approved_by_kepsek_at->format('d M Y, H:i') : '-' }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('pengadaans.show', $r->id) }}"
                                    class="p-1.5 rounded-md border border-zinc-200 text-zinc-600 hover:text-zinc-950 bg-white hover:bg-zinc-50 transition-colors shadow-sm text-xs font-medium inline-flex items-center gap-1 font-sans">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-12 text-center text-zinc-500 font-sans">
                                Belum ada riwayat keputusan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
