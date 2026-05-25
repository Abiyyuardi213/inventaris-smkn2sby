@extends('layouts.app')

@section('title', 'Riwayat Mutasi - Inventaris SMKN 2 SBY')
@section('page_title', 'Mutasi Barang')

@section('content')
<div class="space-y-6">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-1.5 text-sm text-zinc-500">
        <a href="{{ route('dashboard') }}" class="hover:text-zinc-900 transition-colors">Dashboard</a>
        <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
        </svg>
        <span class="font-medium text-zinc-900">Riwayat Mutasi</span>
    </nav>

    {{-- Header Section --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-zinc-900">Riwayat Mutasi Barang</h2>
            <p class="text-sm text-zinc-500">Log perpindahan internal barang antar ruangan di sekolah.</p>
        </div>
        <div>
            <a href="{{ route('mutasis.create') }}"
                class="inline-flex items-center justify-center gap-2 rounded-md bg-zinc-900 text-zinc-50 hover:bg-zinc-800 px-4 py-2 text-sm font-medium shadow-sm transition-all duration-150 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-950 cursor-pointer">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 21 3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5" />
                </svg>
                Mutasi Baru
            </a>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="rounded-lg border border-zinc-200 bg-white shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs uppercase bg-zinc-50 text-zinc-500 border-b border-zinc-200">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-semibold w-12">No</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Tanggal</th>
                        <th scope="col" class="px-6 py-4 font-semibold">No. Mutasi</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Kode & Nama Barang</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Ruangan Asal</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Ruangan Tujuan</th>
                        <th scope="col" class="px-6 py-4 font-semibold text-center">Qty</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Penanggung Jawab</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Petugas</th>
                        <th scope="col" class="px-6 py-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    @forelse ($mutasis as $item)
                        <tr class="hover:bg-zinc-50/60 transition-colors {{ $loop->even ? 'bg-zinc-50/30' : 'bg-white' }}">
                            <td class="px-6 py-4 text-zinc-400 font-mono text-xs">
                                {{ $loop->iteration }}
                            </td>
                            <td class="px-6 py-4 text-zinc-600 font-medium">
                                {{ $item->tanggal_mutasi->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 text-zinc-900 font-mono text-xs font-semibold">
                                {{ $item->nomor_mutasi }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-medium text-zinc-900">{{ $item->inventaris->nama_barang }}</div>
                                <div class="text-xs text-zinc-400 font-mono">{{ $item->inventaris->kode_inventaris }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-medium text-xs text-zinc-700">{{ $item->ruanganAsal->nama_ruangan }}</div>
                                <div class="text-[10px] text-zinc-400">{{ $item->ruanganAsal->jurusan->nama_jurusan }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-medium text-xs text-zinc-700 text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded border border-emerald-100 inline-block">
                                    {{ $item->ruanganTujuan->nama_ruangan }}
                                </div>
                                <div class="text-[10px] text-zinc-400 mt-0.5">{{ $item->ruanganTujuan->jurusan->nama_jurusan }}</div>
                            </td>
                            <td class="px-6 py-4 text-center font-semibold text-zinc-800">
                                {{ $item->jumlah_dipindah }}
                            </td>
                            <td class="px-6 py-4 text-zinc-700 text-xs font-semibold">
                                {{ $item->penanggung_jawab }}
                            </td>
                            <td class="px-6 py-4 text-zinc-600 text-xs font-medium">
                                {{ $item->user->nama }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('mutasis.show', $item->id) }}"
                                    class="p-1.5 rounded-md border border-zinc-200 text-zinc-600 hover:text-zinc-950 bg-white hover:bg-zinc-50 transition-colors shadow-sm text-xs font-medium inline-flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="px-6 py-16 text-center text-zinc-500">
                                <div class="flex flex-col items-center justify-center gap-3">
                                    <div class="w-14 h-14 rounded-full bg-zinc-100 flex items-center justify-center">
                                        <svg class="w-7 h-7 text-zinc-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 21 3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-zinc-700">Belum ada riwayat mutasi</p>
                                        <p class="text-xs text-zinc-400 mt-0.5">Klik tombol "Mutasi Baru" untuk melakukan perpindahan barang pertamamu.</p>
                                    </div>
                                    <a href="{{ route('mutasis.create') }}"
                                        class="mt-1 inline-flex items-center gap-1.5 rounded-md bg-zinc-900 text-zinc-50 hover:bg-zinc-800 px-3 py-1.5 text-xs font-medium transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                        </svg>
                                        Mutasi Baru
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($mutasis->isNotEmpty())
            <div class="px-6 py-3 border-t border-zinc-100 bg-zinc-50/50">
                <p class="text-xs text-zinc-400">
                    Menampilkan <span class="font-medium text-zinc-600">{{ $mutasis->count() }}</span> riwayat perpindahan barang
                </p>
            </div>
        @endif
    </div>
</div>
@endsection
