@extends('layouts.app')

@section('title', 'Detail Peran - Inventaris SMKN 2 SBY')
@section('page_title', 'Detail Peran')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <!-- Back link and Title -->
    <div>
        <a href="{{ route('roles.index') }}" class="inline-flex items-center gap-1.5 text-sm text-zinc-500 hover:text-zinc-950 transition-colors mb-2">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
            </svg>
            Kembali ke Daftar Peran
        </a>
        <h2 class="text-2xl font-bold tracking-tight text-zinc-900">Detail Peran</h2>
        <p class="text-sm text-zinc-500">Informasi lengkap data peran dalam sistem.</p>
    </div>

    <!-- Details Card -->
    <div class="rounded-lg border border-zinc-200 bg-white p-6 shadow-sm space-y-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider block mb-1">Nama Peran</span>
                <span class="text-lg font-medium text-zinc-900">{{ $role->nama_role }}</span>
            </div>
            <div>
                <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider block mb-1">Slug Sistem</span>
                <span class="inline-flex items-center rounded-md bg-zinc-100 px-2.5 py-0.5 text-xs font-mono font-medium text-zinc-800 border border-zinc-200/50">
                    {{ $role->slug }}
                </span>
            </div>
            <div class="sm:col-span-2 border-t border-zinc-100 pt-6">
                <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider block mb-1">ID Peran (UUID)</span>
                <span class="text-sm font-mono text-zinc-500">{{ $role->id }}</span>
            </div>
            <div>
                <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider block mb-1">Tanggal Dibuat</span>
                <span class="text-sm text-zinc-700">{{ $role->created_at->format('d F Y, H:i') }}</span>
            </div>
            <div>
                <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider block mb-1">Terakhir Diperbarui</span>
                <span class="text-sm text-zinc-700">{{ $role->updated_at->format('d F Y, H:i') }}</span>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 pt-6 border-t border-zinc-100">
            <a href="{{ route('roles.index') }}" class="inline-flex items-center justify-center rounded-md border border-zinc-200 text-zinc-700 hover:text-zinc-950 bg-white hover:bg-zinc-50 h-10 px-4 py-2 text-sm font-medium shadow-sm transition-all duration-150">
                Kembali
            </a>
            <a href="{{ route('roles.edit', $role->id) }}" class="inline-flex items-center justify-center rounded-md bg-zinc-900 text-zinc-50 hover:bg-zinc-800 h-10 px-4 py-2 text-sm font-medium shadow-sm transition-all duration-150">
                Ubah Peran
            </a>
        </div>
    </div>
</div>
@endsection
