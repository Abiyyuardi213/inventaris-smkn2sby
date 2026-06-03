@extends('layouts.app')

@section('title', 'Edit Ruangan - Inventaris SMKN 2 SBY')
@section('page_title', 'Edit Ruangan')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-1.5 text-sm text-zinc-500">
        <a href="{{ route('dashboard') }}" class="hover:text-zinc-900 transition-colors">Dashboard</a>
        <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
        </svg>
        <a href="{{ route('ruangans.index') }}" class="hover:text-zinc-900 transition-colors">Ruangan</a>
        <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
        </svg>
        <span class="font-medium text-zinc-900">Edit Ruangan</span>
    </nav>

    {{-- Page Heading --}}
    <div>
        <a href="{{ route('ruangans.index') }}"
            class="inline-flex items-center gap-1.5 text-sm text-zinc-500 hover:text-zinc-950 transition-colors mb-2">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
            </svg>
            Kembali ke Daftar Ruangan
        </a>
        <h2 class="text-2xl font-bold tracking-tight text-zinc-900">Edit Ruangan</h2>
        <p class="text-sm text-zinc-500">Perbarui data ruangan yang sudah terdaftar.</p>
    </div>

    {{-- Form Card --}}
    <div class="rounded-lg border border-zinc-200 bg-white p-6 shadow-sm">
        <form action="{{ route('ruangans.update', $ruangan->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Jurusan Dropdown --}}
            <div class="space-y-2">
                <label for="jurusan_id" class="text-sm font-medium leading-none text-zinc-900">
                    Unit Kerja <span class="text-red-500">*</span>
                </label>
                <select
                    id="jurusan_id"
                    name="jurusan_id"
                    class="flex h-10 w-full rounded-md border {{ $errors->has('jurusan_id') ? 'border-red-400 focus:ring-red-500' : 'border-zinc-200 focus:ring-zinc-950' }} bg-white px-3 py-2 text-sm ring-offset-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 transition-colors cursor-pointer appearance-none"
                    style="background-image: url('data:image/svg+xml,%3Csvg xmlns%3D%22http%3A//www.w3.org/2000/svg%22 fill%3D%22none%22 viewBox%3D%220 0 20 20%22%3E%3Cpath stroke%3D%22%236b7280%22 stroke-linecap%3D%22round%22 stroke-linejoin%3D%22round%22 stroke-width%3D%221.5%22 d%3D%22M6 8l4 4 4-4%22/%3E%3C/svg%3E'); background-repeat: no-repeat; background-position: right 0.75rem center; background-size: 1.25em;"
                    required
                >
                    <option value="" disabled>-- Pilih Unit Kerja --</option>
                    @foreach ($jurusans as $jurusan)
                        <option value="{{ $jurusan->id }}"
                            {{ old('jurusan_id', $ruangan->jurusan_id) == $jurusan->id ? 'selected' : '' }}>
                            {{ $jurusan->nama_jurusan }} ({{ $jurusan->kode_jurusan }})
                        </option>
                    @endforeach
                </select>
                @error('jurusan_id')
                    <p class="text-xs font-medium text-red-500 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Nama Ruangan --}}
            <div class="space-y-2">
                <label for="nama_ruangan" class="text-sm font-medium leading-none text-zinc-900">
                    Nama Ruangan <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    id="nama_ruangan"
                    name="nama_ruangan"
                    value="{{ old('nama_ruangan', $ruangan->nama_ruangan) }}"
                    placeholder="Contoh: Lab Komputer 1, Ruang Kelas TKJ A"
                    class="flex h-10 w-full rounded-md border {{ $errors->has('nama_ruangan') ? 'border-red-400 focus:ring-red-500' : 'border-zinc-200 focus:ring-zinc-950' }} bg-transparent px-3 py-2 text-sm ring-offset-white placeholder:text-zinc-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 transition-colors"
                    required
                    autofocus
                >
                @error('nama_ruangan')
                    <p class="text-xs font-medium text-red-500 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Form Actions --}}
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-100">
                <a href="{{ route('ruangans.index') }}"
                    class="inline-flex items-center justify-center rounded-md border border-zinc-200 text-zinc-700 hover:text-zinc-950 bg-white hover:bg-zinc-50 h-10 px-4 py-2 text-sm font-medium shadow-sm transition-all duration-150 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-950">
                    Batal
                </a>
                <button type="submit"
                    class="inline-flex items-center justify-center gap-2 rounded-md bg-zinc-900 text-zinc-50 hover:bg-zinc-800 h-10 px-4 py-2 text-sm font-medium shadow-sm transition-all duration-150 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-950 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                    </svg>
                    Update Ruangan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
