@extends('layouts.app')

@section('title', 'Detail Kategori Barang - Inventaris SMKN 2 SBY')
@section('page_title', 'Detail Kategori Barang')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-1.5 text-sm text-zinc-500">
        <a href="{{ route('dashboard') }}" class="hover:text-zinc-900 transition-colors">Dashboard</a>
        <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
        </svg>
        <a href="{{ route('kategoris.index') }}" class="hover:text-zinc-900 transition-colors">Kategori Barang</a>
        <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
        </svg>
        <span class="font-medium text-zinc-900">Detail Kategori</span>
    </nav>

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <a href="{{ route('kategoris.index') }}"
                class="inline-flex items-center gap-1.5 text-sm text-zinc-500 hover:text-zinc-950 transition-colors mb-2">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
                Kembali ke Daftar Kategori Barang
            </a>
            <h2 class="text-2xl font-bold tracking-tight text-zinc-900">{{ $kategori->nama_kategori }}</h2>
            <p class="text-sm text-zinc-500 font-mono mt-0.5">{{ $kategori->kode_kategori }}</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('kategoris.edit', $kategori->id) }}"
                class="inline-flex items-center gap-1.5 rounded-md border border-zinc-200 bg-white text-zinc-700 hover:bg-zinc-50 px-3.5 py-2 text-sm font-medium shadow-sm transition-all duration-150">
                <svg class="w-4 h-4 text-zinc-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.83 20.013a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                </svg>
                Ubah
            </a>
        </div>
    </div>

    {{-- Detail Card --}}
    <div class="rounded-lg border border-zinc-200 bg-white p-6 shadow-sm space-y-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <dt class="text-xs font-semibold uppercase tracking-wider text-zinc-400">Kode Kategori</dt>
                <dd class="mt-1 text-sm font-mono font-bold text-indigo-700 bg-indigo-50 border border-indigo-200/60 inline-block px-3 py-1 rounded-md">
                    {{ $kategori->kode_kategori }}
                </dd>
            </div>
            <div>
                <dt class="text-xs font-semibold uppercase tracking-wider text-zinc-400">Nama Kategori Barang</dt>
                <dd class="mt-1 text-base font-semibold text-zinc-900">{{ $kategori->nama_kategori }}</dd>
            </div>
            <div>
                <dt class="text-xs font-semibold uppercase tracking-wider text-zinc-400">Dibuat Pada</dt>
                <dd class="mt-1 text-sm text-zinc-700">{{ $kategori->created_at?->translatedFormat('d F Y H:i') ?? '-' }}</dd>
            </div>
            <div>
                <dt class="text-xs font-semibold uppercase tracking-wider text-zinc-400">Terakhir Diubah</dt>
                <dd class="mt-1 text-sm text-zinc-700">{{ $kategori->updated_at?->translatedFormat('d F Y H:i') ?? '-' }}</dd>
            </div>
        </div>

        {{-- Linked Inventaris Items --}}
        <div class="pt-6 border-t border-zinc-100">
            <h3 class="text-sm font-bold text-zinc-900 mb-3">Daftar Barang Inventaris Terkait ({{ $kategori->inventaris->count() }})</h3>
            @if($kategori->inventaris->isNotEmpty())
                <div class="overflow-x-auto rounded-lg border border-zinc-200">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs uppercase bg-zinc-50 text-zinc-500 border-b border-zinc-200">
                            <tr>
                                <th scope="col" class="px-4 py-3">Kode Inventaris</th>
                                <th scope="col" class="px-4 py-3">Nama Barang</th>
                                <th scope="col" class="px-4 py-3">Ruangan</th>
                                <th scope="col" class="px-4 py-3 text-center">Kondisi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-100">
                            @foreach($kategori->inventaris as $item)
                                <tr class="hover:bg-zinc-50">
                                    <td class="px-4 py-3 font-mono text-xs font-semibold text-teal-700">
                                        <a href="{{ route('inventaris.show', $item->id) }}" class="hover:underline">
                                            {{ $item->kode_inventaris }}
                                        </a>
                                    </td>
                                    <td class="px-4 py-3 font-medium text-zinc-900">{{ $item->nama_barang }}</td>
                                    <td class="px-4 py-3 text-zinc-600">{{ $item->ruangan->nama_ruangan ?? '-' }}</td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium capitalize
                                            {{ $item->kondisi === 'baik' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : '' }}
                                            {{ $item->kondisi === 'layak' ? 'bg-amber-50 text-amber-700 border border-amber-200' : '' }}
                                            {{ $item->kondisi === 'rusak' ? 'bg-rose-50 text-rose-700 border border-rose-200' : '' }}">
                                            {{ $item->kondisi }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-xs text-zinc-400 italic">Belum ada barang inventaris yang menggunakan kategori ini.</p>
            @endif
        </div>
    </div>
</div>
@endsection
