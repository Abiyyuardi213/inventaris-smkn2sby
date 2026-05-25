@extends('layouts.app')

@section('title', 'Detail Pengguna - Inventaris SMKN 2 SBY')
@section('page_title', 'Detail Pengguna')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <!-- Back link and Title -->
    <div>
        <a href="{{ route('users.index') }}" class="inline-flex items-center gap-1.5 text-sm text-zinc-500 hover:text-zinc-950 transition-colors mb-2">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
            </svg>
            Kembali ke Daftar Pengguna
        </a>
        <h2 class="text-2xl font-bold tracking-tight text-zinc-900">Detail Pengguna</h2>
        <p class="text-sm text-zinc-500">Informasi lengkap data profil pengguna dalam sistem.</p>
    </div>

    <!-- Details Card -->
    <div class="rounded-lg border border-zinc-200 bg-white p-6 shadow-sm space-y-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider block mb-1">Nama Lengkap</span>
                <span class="text-lg font-medium text-zinc-900">{{ $user->nama }}</span>
            </div>
            <div>
                <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider block mb-1">Nama Pengguna (Username)</span>
                <span class="text-lg font-medium text-zinc-900">{{ '@' . $user->username }}</span>
            </div>
            <div>
                <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider block mb-1">Alamat Email</span>
                <span class="text-lg font-medium text-zinc-900">{{ $user->email }}</span>
            </div>
            <div>
                <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider block mb-1">Peran / Role</span>
                <div>
                    @if($user->role)
                        <span class="inline-flex items-center rounded-md bg-zinc-100 px-2.5 py-0.5 text-xs font-medium text-zinc-800 border border-zinc-200/50">
                            {{ $user->role->nama_role }}
                        </span>
                    @else
                        <span class="inline-flex items-center rounded-md bg-red-50 px-2.5 py-0.5 text-xs font-medium text-red-700 border border-red-200/50">
                            Tidak Ada Peran
                        </span>
                    @endif
                </div>
            </div>
            <div>
                <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider block mb-1">Status Verifikasi</span>
                <div>
                    @if($user->email_verified_at)
                        <span class="inline-flex items-center gap-1 text-xs text-emerald-600 font-medium">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            Terverifikasi pada {{ $user->email_verified_at->format('d M Y') }}
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 text-xs text-zinc-500 font-medium">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                            </svg>
                            Belum Terverifikasi
                        </span>
                    @endif
                </div>
            </div>
            <div class="sm:col-span-2 border-t border-zinc-100 pt-6">
                <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider block mb-1">ID Pengguna (UUID)</span>
                <span class="text-sm font-mono text-zinc-500">{{ $user->id }}</span>
            </div>
            <div>
                <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider block mb-1">Tanggal Terdaftar</span>
                <span class="text-sm text-zinc-700">{{ $user->created_at->format('d F Y, H:i') }}</span>
            </div>
            <div>
                <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider block mb-1">Terakhir Diperbarui</span>
                <span class="text-sm text-zinc-700">{{ $user->updated_at->format('d F Y, H:i') }}</span>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 pt-6 border-t border-zinc-100">
            <a href="{{ route('users.index') }}" class="inline-flex items-center justify-center rounded-md border border-zinc-200 text-zinc-700 hover:text-zinc-950 bg-white hover:bg-zinc-50 h-10 px-4 py-2 text-sm font-medium shadow-sm transition-all duration-150">
                Kembali
            </a>
            <a href="{{ route('users.edit', $user->id) }}" class="inline-flex items-center justify-center rounded-md bg-zinc-900 text-zinc-50 hover:bg-zinc-800 h-10 px-4 py-2 text-sm font-medium shadow-sm transition-all duration-150">
                Ubah Pengguna
            </a>
        </div>
    </div>
</div>
@endsection
