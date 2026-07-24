@extends('layouts.app')

@section('title', 'Edit Usulan Pengadaan - Inventaris SMKN 2 SBY')
@section('page_title', 'Edit Usulan Pengadaan')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-1.5 text-sm text-zinc-500">
        <a href="{{ route('dashboard') }}" class="hover:text-zinc-900 transition-colors">Dashboard</a>
        <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
        </svg>
        <a href="{{ route('pengadaans.index') }}" class="hover:text-zinc-900 transition-colors">Usulan Pengadaan</a>
        <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
        </svg>
        <span class="font-medium text-zinc-900">Edit Usulan</span>
    </nav>

    {{-- Page Heading --}}
    <div>
        <a href="{{ route('pengadaans.show', $pengadaan->id) }}"
            class="inline-flex items-center gap-1.5 text-sm text-zinc-500 hover:text-zinc-950 transition-colors mb-2">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
            </svg>
            Kembali ke Detail Usulan
        </a>
        <h2 class="text-2xl font-bold tracking-tight text-zinc-900">Edit Usulan Pengadaan</h2>
        <p class="text-sm text-zinc-500">Perbarui detail usulan yang masih berstatus Pending.</p>
    </div>

    {{-- Alert: hanya bisa edit jika pending --}}
    <div class="rounded-md bg-amber-50 border border-amber-200/60 px-4 py-3 flex items-start gap-3">
        <svg class="w-4 h-4 text-amber-500 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
        </svg>
        <p class="text-xs text-amber-700">
            Anda hanya dapat mengedit usulan selama statusnya masih
            <span class="font-semibold bg-amber-100 px-1.5 py-0.5 rounded">Pending</span>.
            Setelah diproses oleh Administrator, usulan tidak dapat diubah.
        </p>
    </div>

    {{-- Form Card --}}
    <div class="rounded-lg border border-zinc-200 bg-white p-6 shadow-sm">
        <form action="{{ route('pengadaans.update', $pengadaan->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            {{-- Nama Barang Usulan --}}
            <div class="space-y-2">
                <label for="nama_barang_usulan" class="text-sm font-medium leading-none text-zinc-900">
                    Nama Barang Usulan <span class="text-red-500">*</span>
                </label>
                <input type="text" id="nama_barang_usulan" name="nama_barang_usulan"
                    value="{{ old('nama_barang_usulan', $pengadaan->nama_barang_usulan) }}"
                    placeholder="Contoh: Laptop ASUS VivoBook"
                    class="flex h-10 w-full rounded-md border {{ $errors->has('nama_barang_usulan') ? 'border-red-400 focus:ring-red-500' : 'border-zinc-200 focus:ring-zinc-950' }} bg-transparent px-3 py-2 text-sm placeholder:text-zinc-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 transition-colors"
                    required autofocus>
                @error('nama_barang_usulan')
                    <p class="text-xs font-medium text-red-500 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" /></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Jenis Modal & Jurusan (2 kolom) --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                {{-- Jenis Modal --}}
                <div class="space-y-2">
                    <label for="jenis_modal_id" class="text-sm font-medium leading-none text-zinc-900">
                        Jenis Modal <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select id="jenis_modal_id" name="jenis_modal_id"
                            class="flex h-10 w-full rounded-md border {{ $errors->has('jenis_modal_id') ? 'border-red-400' : 'border-zinc-200 focus:ring-zinc-950' }} bg-white pl-3 pr-8 py-2 text-sm focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 transition-colors cursor-pointer appearance-none"
                            required>
                            <option value="" disabled>-- Pilih Jenis Modal --</option>
                            @foreach ($jenisModals as $kat)
                                <option value="{{ $kat->id }}" {{ old('jenis_modal_id', $pengadaan->jenis_modal_id) == $kat->id ? 'selected' : '' }}>
                                    {{ $kat->nama_jenis_modal }} ({{ $kat->kode_jenis_modal }})
                                </option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-2 flex items-center">
                            <svg class="w-4 h-4 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                            </svg>
                        </div>
                    </div>
                    @error('jenis_modal_id')
                        <p class="text-xs font-medium text-red-500 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" /></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Jurusan --}}
                <div class="space-y-2">
                    <label for="jurusan_id" class="text-sm font-medium leading-none text-zinc-900">
                        Jurusan / Program Keahlian <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select id="jurusan_id" name="jurusan_id"
                            class="flex h-10 w-full rounded-md border {{ $errors->has('jurusan_id') ? 'border-red-400' : 'border-zinc-200 focus:ring-zinc-950' }} bg-white pl-3 pr-8 py-2 text-sm focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 transition-colors cursor-pointer appearance-none"
                            required>
                            <option value="" disabled>-- Pilih Jurusan --</option>
                            @foreach ($jurusans as $jur)
                                <option value="{{ $jur->id }}" {{ old('jurusan_id', $pengadaan->jurusan_id) == $jur->id ? 'selected' : '' }}>
                                    {{ $jur->nama_jurusan }}
                                </option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-2 flex items-center">
                            <svg class="w-4 h-4 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                            </svg>
                        </div>
                    </div>
                    @error('jurusan_id')
                        <p class="text-xs font-medium text-red-500 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" /></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            {{-- Jumlah & Perkiraan Harga --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div class="space-y-2">
                    <label for="jumlah" class="text-sm font-medium leading-none text-zinc-900">
                        Jumlah (unit) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" id="jumlah" name="jumlah"
                        value="{{ old('jumlah', $pengadaan->jumlah) }}" min="1"
                        class="flex h-10 w-full rounded-md border {{ $errors->has('jumlah') ? 'border-red-400 focus:ring-red-500' : 'border-zinc-200 focus:ring-zinc-950' }} bg-transparent px-3 py-2 text-sm focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 transition-colors"
                        required>
                    @error('jumlah')
                        <p class="text-xs font-medium text-red-500 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" /></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                <div class="space-y-2">
                    <label for="perkiraan_harga" class="text-sm font-medium leading-none text-zinc-900">
                        Perkiraan Harga (Rp) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" id="perkiraan_harga" name="perkiraan_harga"
                        value="{{ old('perkiraan_harga', $pengadaan->perkiraan_harga) }}" min="0"
                        class="flex h-10 w-full rounded-md border {{ $errors->has('perkiraan_harga') ? 'border-red-400 focus:ring-red-500' : 'border-zinc-200 focus:ring-zinc-950' }} bg-transparent px-3 py-2 text-sm focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 transition-colors"
                        required>
                    @error('perkiraan_harga')
                        <p class="text-xs font-medium text-red-500 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" /></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            {{-- Alasan Pengadaan --}}
            <div class="space-y-2">
                <label for="alasan_pengadaan" class="text-sm font-medium leading-none text-zinc-900">
                    Alasan Pengadaan <span class="text-red-500">*</span>
                </label>
                <textarea id="alasan_pengadaan" name="alasan_pengadaan" rows="4"
                    placeholder="Jelaskan mengapa barang ini dibutuhkan..."
                    class="flex w-full rounded-md border {{ $errors->has('alasan_pengadaan') ? 'border-red-400 focus:ring-red-500' : 'border-zinc-200 focus:ring-zinc-950' }} bg-transparent px-3 py-2 text-sm placeholder:text-zinc-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 transition-colors resize-none"
                    required>{{ old('alasan_pengadaan', $pengadaan->alasan_pengadaan) }}</textarea>
                @error('alasan_pengadaan')
                    <p class="text-xs font-medium text-red-500 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" /></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Form Actions --}}
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-100">
                <a href="{{ route('pengadaans.show', $pengadaan->id) }}"
                    class="inline-flex items-center justify-center rounded-md border border-zinc-200 text-zinc-700 hover:text-zinc-950 bg-white hover:bg-zinc-50 h-10 px-4 py-2 text-sm font-medium shadow-sm transition-all duration-150">
                    Batal
                </a>
                <button type="submit"
                    class="inline-flex items-center justify-center gap-2 rounded-md bg-zinc-900 text-zinc-50 hover:bg-zinc-800 h-10 px-4 py-2 text-sm font-medium shadow-sm transition-all duration-150 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                    </svg>
                    Perbarui Usulan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
