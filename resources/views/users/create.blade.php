@extends('layouts.app')

@section('title', 'Tambah Pengguna Baru - Inventaris SMKN 2 SBY')
@section('page_title', 'Tambah Pengguna')

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
        <h2 class="text-2xl font-bold tracking-tight text-zinc-900">Tambah Pengguna Baru</h2>
        <p class="text-sm text-zinc-500">Daftarkan akun pengguna baru dan tentukan perannya di dalam sistem.</p>
    </div>

    <!-- Form Card -->
    <div class="rounded-lg border border-zinc-200 bg-white p-6 shadow-sm">
        <form action="{{ route('users.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <!-- Nama -->
            <div class="space-y-2">
                <label for="nama" class="text-sm font-medium leading-none text-zinc-900">
                    Nama Lengkap <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="nama" 
                    name="nama" 
                    value="{{ old('nama') }}"
                    placeholder="Masukkan nama lengkap"
                    class="flex h-10 w-full rounded-md border {{ $errors->has('nama') ? 'border-red-500 focus:ring-red-500' : 'border-zinc-200 focus:ring-zinc-950' }} bg-transparent px-3 py-2 text-sm ring-offset-white file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-zinc-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                    required
                >
                @error('nama')
                    <p class="text-xs font-medium text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div class="space-y-2">
                <label for="email" class="text-sm font-medium leading-none text-zinc-900">
                    Alamat Email <span class="text-red-500">*</span>
                </label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    value="{{ old('email') }}"
                    placeholder="nama@contoh.com"
                    class="flex h-10 w-full rounded-md border {{ $errors->has('email') ? 'border-red-500 focus:ring-red-500' : 'border-zinc-200 focus:ring-zinc-950' }} bg-transparent px-3 py-2 text-sm ring-offset-white file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-zinc-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                    required
                >
                @error('email')
                    <p class="text-xs font-medium text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Peran / Role -->
            <div class="space-y-2">
                <label for="role_id" class="text-sm font-medium leading-none text-zinc-900">
                    Peran / Role <span class="text-red-500">*</span>
                </label>
                <select 
                    id="role_id" 
                    name="role_id" 
                    class="flex h-10 w-full rounded-md border {{ $errors->has('role_id') ? 'border-red-500 focus:ring-red-500' : 'border-zinc-200 focus:ring-zinc-950' }} bg-transparent px-3 py-2 text-sm ring-offset-white placeholder:text-zinc-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 text-zinc-900"
                    required
                >
                    <option value="" disabled {{ old('role_id') == '' ? 'selected' : '' }}>Pilih Peran...</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                            {{ $role->nama_role }}
                        </option>
                    @endforeach
                </select>
                @error('role_id')
                    <p class="text-xs font-medium text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password and Confirmation row -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Password -->
                <div class="space-y-2">
                    <label for="password" class="text-sm font-medium leading-none text-zinc-900">
                        Kata Sandi <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        placeholder="Minimal 8 karakter"
                        class="flex h-10 w-full rounded-md border {{ $errors->has('password') ? 'border-red-500 focus:ring-red-500' : 'border-zinc-200 focus:ring-zinc-950' }} bg-transparent px-3 py-2 text-sm ring-offset-white file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-zinc-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                        required
                    >
                    @error('password')
                        <p class="text-xs font-medium text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Confirmation -->
                <div class="space-y-2">
                    <label for="password_confirmation" class="text-sm font-medium leading-none text-zinc-900">
                        Konfirmasi Kata Sandi <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="password" 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        placeholder="Ulangi kata sandi"
                        class="flex h-10 w-full rounded-md border border-zinc-200 focus:ring-zinc-950 bg-transparent px-3 py-2 text-sm ring-offset-white file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-zinc-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                        required
                    >
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-100">
                <a href="{{ route('users.index') }}" class="inline-flex items-center justify-center rounded-md border border-zinc-200 text-zinc-700 hover:text-zinc-950 bg-white hover:bg-zinc-50 h-10 px-4 py-2 text-sm font-medium shadow-sm transition-all duration-150 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-950">
                    Batal
                </a>
                <button type="submit" class="inline-flex items-center justify-center rounded-md bg-zinc-900 text-zinc-50 hover:bg-zinc-800 h-10 px-4 py-2 text-sm font-medium shadow-sm transition-all duration-150 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-950 cursor-pointer">
                    Simpan Pengguna
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
