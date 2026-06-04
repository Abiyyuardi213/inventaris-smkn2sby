@extends('layouts.app')

@section('title', 'Import Inventaris - Inventaris SMKN 2 SBY')
@section('page_title', 'Import Inventaris')

@section('content')
<div class="space-y-6">
    <nav class="flex items-center gap-1.5 text-sm text-zinc-500">
        <a href="{{ route('dashboard') }}" class="hover:text-zinc-900 transition-colors">Dashboard</a>
        <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
        </svg>
        <a href="{{ route('inventaris.index') }}" class="hover:text-zinc-900 transition-colors">Inventaris</a>
        <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
        </svg>
        <span class="font-medium text-zinc-900">Import</span>
    </nav>

    <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-zinc-900">Import Data Inventaris</h2>
            <p class="text-sm text-zinc-500">Unduh template, isi data, lalu upload untuk direview sebelum masuk ke inventaris.</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('inventaris.template', 'xlsx') }}" class="inline-flex items-center rounded-md bg-zinc-900 px-4 py-2 text-sm font-medium text-white hover:bg-zinc-800">Unduh Template XLSX</a>
            <a href="{{ route('inventaris.template', 'csv') }}" class="inline-flex items-center rounded-md border border-zinc-200 bg-white px-4 py-2 text-sm font-medium text-zinc-700 hover:bg-zinc-50">Unduh Template CSV</a>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <div class="xl:col-span-2 rounded-lg border border-zinc-200 bg-white p-6 shadow-sm">
            <form action="{{ route('inventaris.imports.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                <div class="rounded-md border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-800">
                    Kolom relasi wajib diisi memakai ID: <strong>kategori_id</strong>, <strong>jurusan_id</strong>, dan <strong>ruangan_id</strong>. Kolom <strong>kode_inventaris</strong> tidak perlu diisi karena akan dibuat otomatis dari nama barang saat import disetujui.
                </div>

                <div class="space-y-2">
                    <label for="file" class="text-sm font-medium text-zinc-900">File CSV/XLSX</label>
                    <input id="file" name="file" type="file" accept=".csv,.xlsx"
                        class="block w-full rounded-md border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-900 file:mr-4 file:rounded-md file:border-0 file:bg-zinc-900 file:px-3 file:py-1.5 file:text-sm file:font-medium file:text-white hover:file:bg-zinc-800"
                        required>
                    @error('file')
                        <p class="text-xs font-medium text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end gap-3 border-t border-zinc-100 pt-5">
                    <a href="{{ route('inventaris.index') }}" class="inline-flex h-10 items-center rounded-md border border-zinc-200 bg-white px-4 text-sm font-medium text-zinc-700 hover:bg-zinc-50">Batal</a>
                    <button type="submit" class="inline-flex h-10 items-center rounded-md bg-emerald-600 px-4 text-sm font-medium text-white hover:bg-emerald-700 cursor-pointer">
                        Upload & Review
                    </button>
                </div>
            </form>
        </div>

        <div class="rounded-lg border border-zinc-200 bg-white p-5 shadow-sm">
            <h3 class="text-sm font-semibold text-zinc-900">Kolom Template</h3>
            <div class="mt-3 flex flex-wrap gap-2">
                @foreach(\App\Services\InventarisSpreadsheetService::HEADERS as $header)
                    <span class="rounded-md bg-zinc-100 px-2.5 py-1 text-xs font-mono text-zinc-700">{{ $header }}</span>
                @endforeach
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        <div class="rounded-lg border border-zinc-200 bg-white shadow-sm overflow-hidden">
            <div class="border-b border-zinc-100 bg-zinc-50 px-4 py-3">
                <h3 class="text-sm font-semibold text-zinc-900">Referensi Kategori ID</h3>
            </div>
            <div class="max-h-72 overflow-auto">
                @foreach($kategoris as $kategori)
                    <div class="border-b border-zinc-100 px-4 py-3">
                        <p class="text-sm font-medium text-zinc-900">{{ $kategori->nama_kategori }}</p>
                        <p class="mt-1 text-xs font-mono text-zinc-500">{{ $kategori->id }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="rounded-lg border border-zinc-200 bg-white shadow-sm overflow-hidden">
            <div class="border-b border-zinc-100 bg-zinc-50 px-4 py-3">
                <h3 class="text-sm font-semibold text-zinc-900">Referensi Unit Kerja ID</h3>
            </div>
            <div class="max-h-72 overflow-auto">
                @foreach($jurusans as $jurusan)
                    <div class="border-b border-zinc-100 px-4 py-3">
                        <p class="text-sm font-medium text-zinc-900">{{ $jurusan->nama_jurusan }}</p>
                        <p class="mt-1 text-xs font-mono text-zinc-500">{{ $jurusan->id }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="rounded-lg border border-zinc-200 bg-white shadow-sm overflow-hidden">
            <div class="border-b border-zinc-100 bg-zinc-50 px-4 py-3">
                <h3 class="text-sm font-semibold text-zinc-900">Referensi Ruangan ID</h3>
            </div>
            <div class="max-h-72 overflow-auto">
                @foreach($ruangans as $ruangan)
                    <div class="border-b border-zinc-100 px-4 py-3">
                        <p class="text-sm font-medium text-zinc-900">{{ $ruangan->nama_ruangan }}</p>
                        <p class="text-xs text-zinc-400">{{ $ruangan->jurusan?->nama_jurusan ?? '-' }}</p>
                        <p class="mt-1 text-xs font-mono text-zinc-500">{{ $ruangan->id }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="rounded-lg border border-zinc-200 bg-white shadow-sm overflow-hidden">
        <div class="border-b border-zinc-100 bg-zinc-50 px-5 py-3">
            <h3 class="text-sm font-semibold text-zinc-900">Riwayat Import Terakhir</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-zinc-100 text-xs uppercase text-zinc-500">
                    <tr>
                        <th class="px-5 py-3">File</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3">Baris</th>
                        <th class="px-5 py-3">Pembuat</th>
                        <th class="px-5 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    @forelse($batches as $batch)
                        <tr>
                            <td class="px-5 py-3 font-medium text-zinc-900">{{ $batch->file_name }}</td>
                            <td class="px-5 py-3">{{ ucfirst($batch->status) }}</td>
                            <td class="px-5 py-3">{{ $batch->valid_rows }} valid / {{ $batch->invalid_rows }} salah</td>
                            <td class="px-5 py-3">{{ $batch->creator?->nama ?? '-' }}</td>
                            <td class="px-5 py-3 text-right">
                                <a href="{{ route('inventaris.imports.show', $batch->id) }}" class="text-sm font-medium text-zinc-900 hover:underline">Review</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-8 text-center text-zinc-500">Belum ada riwayat import.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
