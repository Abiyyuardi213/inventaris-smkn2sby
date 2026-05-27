@extends('layouts.app')

@section('title', 'Peminjaman Baru - Inventaris SMKN 2 SBY')
@section('page_title', 'Peminjaman Barang')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>

<div class="space-y-6 max-w-2xl">
    <nav class="flex items-center gap-1.5 text-sm text-zinc-500">
        <a href="{{ route('dashboard') }}" class="hover:text-zinc-900 transition-colors">Dashboard</a>
        <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
        </svg>
        <a href="{{ route('peminjamans.index') }}" class="hover:text-zinc-900 transition-colors">Peminjaman</a>
        <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
        </svg>
        <span class="font-medium text-zinc-900">Peminjaman Baru</span>
    </nav>

    <div>
        <h2 class="text-2xl font-bold tracking-tight text-zinc-900">Form Peminjaman Barang</h2>
        <p class="text-sm text-zinc-500">Catat peminjaman eksternal secara singkat.</p>
    </div>

    <div class="rounded-lg border border-zinc-200 bg-white p-6 shadow-sm">
        <form method="POST" action="{{ route('peminjamans.store') }}" class="space-y-5" id="peminjaman-form">
            @csrf

            <div>
                <label class="text-sm font-semibold">Nama Peminjam</label>
                <input name="nama_peminjam" value="{{ old('nama_peminjam') }}" required
                    class="flex h-10 w-full rounded-md border border-zinc-200 bg-white px-3 py-2 text-sm" />
                @error('nama_peminjam')<p class="text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="text-sm font-semibold">Instansi / Kelas</label>
                <input name="instansi" value="{{ old('instansi') }}"
                    class="flex h-10 w-full rounded-md border border-zinc-200 bg-white px-3 py-2 text-sm" />
                @error('instansi')<p class="text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="text-sm font-semibold">Kontak</label>
                <input name="kontak" value="{{ old('kontak') }}"
                    class="flex h-10 w-full rounded-md border border-zinc-200 bg-white px-3 py-2 text-sm" />
                @error('kontak')<p class="text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="text-sm font-semibold">Pilih Barang</label>
                <select id="inventaris_id" name="inventaris_id" required class="w-full">
                    <option value="">-- Pilih Barang --</option>
                    @foreach($inventarisList as $inv)
                        <option value="{{ $inv->id }}" data-nama="{{ $inv->nama_barang }}" data-kode="{{ $inv->kode_inventaris }}">{{ $inv->kode_inventaris }} — {{ $inv->nama_barang }} ({{ $inv->jumlah_total }})</option>
                    @endforeach
                </select>
                @error('inventaris_id')<p class="text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="text-sm font-semibold">Jumlah Dipinjam</label>
                    <input name="jumlah_pinjam" type="number" min="1" value="{{ old('jumlah_pinjam', 1) }}" required
                        class="flex h-10 w-full rounded-md border border-zinc-200 bg-white px-3 py-2 text-sm" />
                    @error('jumlah_pinjam')<p class="text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="text-sm font-semibold">Tanggal Pinjam</label>
                    <input name="tanggal_pinjam" type="date" value="{{ old('tanggal_pinjam', now()->toDateString()) }}" required
                        class="flex h-10 w-full rounded-md border border-zinc-200 bg-white px-3 py-2 text-sm" />
                    @error('tanggal_pinjam')<p class="text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="text-sm font-semibold">Estimasi Kembali</label>
                    <input name="tanggal_estimasi_kembali" type="date" value="{{ old('tanggal_estimasi_kembali') }}"
                        class="flex h-10 w-full rounded-md border border-zinc-200 bg-white px-3 py-2 text-sm" />
                    @error('tanggal_estimasi_kembali')<p class="text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="text-sm font-semibold">Status</label>
                    <select name="status" class="flex h-10 w-full rounded-md border border-zinc-200 bg-white px-3 py-2 text-sm">
                        <option value="Dipinjam" {{ old('status')=='Dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                        <option value="Dikembalikan" {{ old('status')=='Dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                        <option value="Terlambat" {{ old('status')=='Terlambat' ? 'selected' : '' }}>Terlambat</option>
                    </select>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-3 border-t border-zinc-100">
                <a href="{{ route('peminjamans.index') }}" class="px-4 py-2 border rounded">Batal</a>
                <button id="submit-btn" type="submit" class="px-4 py-2 bg-zinc-900 text-white rounded">Simpan Peminjaman</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        new TomSelect('#inventaris_id', { create: false, placeholder: '-- Pilih Barang --' });
        const form = document.getElementById('peminjaman-form');
        const submitBtn = document.getElementById('submit-btn');
        if (form && submitBtn) {
            form.addEventListener('submit', function (e) {
                // Prevent double submission
                if (form.dataset.submitted === 'true') {
                    e.preventDefault();
                    return false;
                }
                form.dataset.submitted = 'true';
                submitBtn.disabled = true;
                submitBtn.textContent = 'Menyimpan...';
            });
            // Also guard against double-click on the button itself
            submitBtn.addEventListener('click', function () {
                if (form.dataset.submitted === 'true') {
                    return false;
                }
            });
        }
    });
</script>
@endsection
