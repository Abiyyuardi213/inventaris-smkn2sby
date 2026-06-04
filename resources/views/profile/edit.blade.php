@extends('layouts.app')

@section('title', 'Edit Profil - Inventaris SMKN 2 SBY')
@section('page_title', 'Edit Profil')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <nav class="flex items-center gap-1.5 text-sm text-zinc-500">
        <a href="{{ route('dashboard') }}" class="hover:text-zinc-900 transition-colors">Dashboard</a>
        <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
        </svg>
        <a href="{{ route('profile.show') }}" class="hover:text-zinc-900 transition-colors">Profil Saya</a>
        <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
        </svg>
        <span class="font-medium text-zinc-900">Edit</span>
    </nav>

    <div>
        <a href="{{ route('profile.show') }}" class="inline-flex items-center gap-1.5 text-sm text-zinc-500 hover:text-zinc-950 transition-colors mb-2">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
            </svg>
            Kembali ke Profil
        </a>
        <h2 class="text-2xl font-bold tracking-tight text-zinc-900">Edit Profil</h2>
        <p class="text-sm text-zinc-500">Perbarui data diri dan kata sandi akun Anda.</p>
    </div>

    <div class="rounded-lg border border-zinc-200 bg-white p-6 shadow-sm">
        <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-2 md:col-span-2">
                    <label for="nama" class="text-sm font-medium text-zinc-900">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input id="nama" name="nama" value="{{ old('nama', $user->nama) }}" class="h-10 w-full rounded-md border {{ $errors->has('nama') ? 'border-red-500' : 'border-zinc-200' }} px-3 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-950" required>
                    @error('nama') <p class="text-xs font-medium text-red-500">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-2">
                    <label for="username" class="text-sm font-medium text-zinc-900">Username <span class="text-red-500">*</span></label>
                    <input id="username" name="username" value="{{ old('username', $user->username) }}" class="h-10 w-full rounded-md border {{ $errors->has('username') ? 'border-red-500' : 'border-zinc-200' }} px-3 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-950" required>
                    @error('username') <p class="text-xs font-medium text-red-500">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-2">
                    <label for="email" class="text-sm font-medium text-zinc-900">Email <span class="text-red-500">*</span></label>
                    <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" class="h-10 w-full rounded-md border {{ $errors->has('email') ? 'border-red-500' : 'border-zinc-200' }} px-3 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-950" required>
                    @error('email') <p class="text-xs font-medium text-red-500">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="space-y-4 border-t border-zinc-100 pt-5">
                <div>
                    <h3 class="text-sm font-semibold text-zinc-900">Ubah Kata Sandi</h3>
                    <p class="text-xs text-zinc-500">Kosongkan bagian ini jika tidak ingin mengubah kata sandi.</p>
                </div>

                <div class="space-y-2">
                    <label for="current_password" class="text-sm font-medium text-zinc-900">Kata Sandi Saat Ini</label>
                    <input id="current_password" type="password" name="current_password" class="h-10 w-full rounded-md border {{ $errors->has('current_password') ? 'border-red-500' : 'border-zinc-200' }} px-3 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-950" placeholder="Wajib diisi jika mengganti kata sandi">
                    @error('current_password') <p class="text-xs font-medium text-red-500">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label for="password" class="text-sm font-medium text-zinc-900">Kata Sandi Baru</label>
                        <input id="password" type="password" name="password" class="h-10 w-full rounded-md border {{ $errors->has('password') ? 'border-red-500' : 'border-zinc-200' }} px-3 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-950" placeholder="Minimal 8 karakter">
                        @error('password') <p class="text-xs font-medium text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="password_confirmation" class="text-sm font-medium text-zinc-900">Konfirmasi Kata Sandi Baru</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" class="h-10 w-full rounded-md border border-zinc-200 px-3 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-950" placeholder="Ulangi kata sandi baru">
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3 border-t border-zinc-100 pt-5">
                <a href="{{ route('profile.show') }}" class="inline-flex h-10 items-center rounded-md border border-zinc-200 bg-white px-4 text-sm font-medium text-zinc-700 hover:bg-zinc-50">
                    Batal
                </a>
                <button type="submit" class="inline-flex h-10 items-center rounded-md bg-zinc-900 px-4 text-sm font-medium text-white hover:bg-zinc-800 cursor-pointer">
                    Simpan Profil
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
