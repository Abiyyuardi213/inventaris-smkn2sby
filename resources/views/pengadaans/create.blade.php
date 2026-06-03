@extends('layouts.app')

@section('title', 'Buat Usulan Pengadaan - Inventaris SMKN 2 SBY')
@section('page_title', 'Buat Usulan Pengadaan')

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
        <span class="font-medium text-zinc-900">Buat Usulan</span>
    </nav>

    {{-- Page Heading --}}
    <div>
        <a href="{{ route('pengadaans.index') }}"
            class="inline-flex items-center gap-1.5 text-sm text-zinc-500 hover:text-zinc-950 transition-colors mb-2">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
            </svg>
            Kembali ke Daftar Usulan
        </a>
        <h2 class="text-2xl font-bold tracking-tight text-zinc-900">Buat Usulan Pengadaan Baru</h2>
        <p class="text-sm text-zinc-500">Isi detail barang yang ingin diusulkan untuk diadakan.</p>
    </div>

    {{-- Info box: status otomatis pending --}}
    <div class="rounded-md bg-amber-50 border border-amber-200/60 px-4 py-3 flex items-start gap-3">
        <svg class="w-4 h-4 text-amber-500 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
        </svg>
        <p class="text-xs text-amber-700">
            Usulan akan otomatis berstatus <span class="font-semibold">Pending</span> hingga disetujui oleh Administrator.
        </p>
    </div>

    {{-- Form Card --}}
    <div class="rounded-lg border border-zinc-200 bg-white p-6 shadow-sm">
        <form action="{{ route('pengadaans.store') }}" method="POST" class="space-y-5">
            @csrf

            {{-- Nama Barang Usulan --}}
            <div class="space-y-2">
                <label for="nama_barang_usulan" class="text-sm font-medium leading-none text-zinc-900">
                    Nama Barang Usulan <span class="text-red-500">*</span>
                </label>
                <input type="text" id="nama_barang_usulan" name="nama_barang_usulan"
                    value="{{ old('nama_barang_usulan') }}"
                    placeholder="Contoh: Laptop ASUS VivoBook, Kursi Ergonomis"
                    class="flex h-10 w-full rounded-md border {{ $errors->has('nama_barang_usulan') ? 'border-red-400 focus:ring-red-500' : 'border-zinc-200 focus:ring-zinc-950' }} bg-transparent px-3 py-2 text-sm placeholder:text-zinc-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 transition-colors"
                    required autofocus>
                @error('nama_barang_usulan')
                    <p class="text-xs font-medium text-red-500 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" /></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Kategori & Jurusan (2 kolom) --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                {{-- Kategori --}}
                <div class="space-y-2">
                    <label for="kategori_id" class="text-sm font-medium leading-none text-zinc-900">
                        Kategori <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select id="kategori_id" name="kategori_id"
                            class="flex h-10 w-full rounded-md border {{ $errors->has('kategori_id') ? 'border-red-400 focus:ring-red-500' : 'border-zinc-200 focus:ring-zinc-950' }} bg-white pl-3 pr-8 py-2 text-sm focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 transition-colors cursor-pointer appearance-none"
                            required>
                            <option value="" disabled {{ old('kategori_id') ? '' : 'selected' }}>-- Pilih Kategori --</option>
                            @foreach ($kategoris as $kat)
                                <option value="{{ $kat->id }}" {{ old('kategori_id') == $kat->id ? 'selected' : '' }}>
                                    {{ $kat->nama_kategori }} ({{ $kat->kode_kategori }})
                                </option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-2 flex items-center">
                            <svg class="w-4 h-4 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                            </svg>
                        </div>
                    </div>
                    @error('kategori_id')
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
                            class="flex h-10 w-full rounded-md border {{ $errors->has('jurusan_id') ? 'border-red-400 focus:ring-red-500' : 'border-zinc-200 focus:ring-zinc-950' }} bg-white pl-3 pr-8 py-2 text-sm focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 transition-colors cursor-pointer appearance-none"
                            required>
                            <option value="" disabled {{ old('jurusan_id') ? '' : 'selected' }}>-- Pilih Jurusan --</option>
                            @foreach ($jurusans as $jur)
                                <option value="{{ $jur->id }}" {{ old('jurusan_id') == $jur->id ? 'selected' : '' }}>
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

            {{-- Jumlah & Perkiraan Harga (2 kolom) --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                {{-- Jumlah --}}
                <div class="space-y-2">
                    <label for="jumlah" class="text-sm font-medium leading-none text-zinc-900">
                        Jumlah (unit) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" id="jumlah" name="jumlah"
                        value="{{ old('jumlah') }}" min="1" placeholder="Contoh: 5"
                        class="flex h-10 w-full rounded-md border {{ $errors->has('jumlah') ? 'border-red-400 focus:ring-red-500' : 'border-zinc-200 focus:ring-zinc-950' }} bg-transparent px-3 py-2 text-sm placeholder:text-zinc-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 transition-colors"
                        required>
                    @error('jumlah')
                        <p class="text-xs font-medium text-red-500 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" /></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Perkiraan Harga --}}
                <div class="space-y-2">
                    <label for="perkiraan_harga" class="text-sm font-medium leading-none text-zinc-900">
                        Perkiraan Harga (Rp) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" id="perkiraan_harga" name="perkiraan_harga"
                        value="{{ old('perkiraan_harga') }}" min="0" placeholder="Contoh: 8500000"
                        class="flex h-10 w-full rounded-md border {{ $errors->has('perkiraan_harga') ? 'border-red-400 focus:ring-red-500' : 'border-zinc-200 focus:ring-zinc-950' }} bg-transparent px-3 py-2 text-sm placeholder:text-zinc-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 transition-colors"
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
                    required>{{ old('alasan_pengadaan') }}</textarea>
                @error('alasan_pengadaan')
                    <p class="text-xs font-medium text-red-500 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" /></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Form Actions --}}
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-100">
                <a href="{{ route('pengadaans.index') }}"
                    class="inline-flex items-center justify-center rounded-md border border-zinc-200 text-zinc-700 hover:text-zinc-950 bg-white hover:bg-zinc-50 h-10 px-4 py-2 text-sm font-medium shadow-sm transition-all duration-150">
                    Batal
                </a>
                <button type="submit"
                    class="inline-flex items-center justify-center gap-2 rounded-md bg-zinc-900 text-zinc-50 hover:bg-zinc-800 h-10 px-4 py-2 text-sm font-medium shadow-sm transition-all duration-150 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-950 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                    </svg>
                    Kirim Usulan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
