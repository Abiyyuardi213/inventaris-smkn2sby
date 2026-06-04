@extends('layouts.app')

@section('title', 'Approval Import Inventaris - Inventaris SMKN 2 SBY')
@section('page_title', 'Approval Import Inventaris')

@section('content')
<div class="space-y-6">
    <nav class="flex items-center gap-1.5 text-sm text-zinc-500">
        <a href="{{ route('dashboard') }}" class="hover:text-zinc-900 transition-colors">Dashboard</a>
        <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" /></svg>
        <a href="{{ route('inventaris.imports.create') }}" class="hover:text-zinc-900 transition-colors">Import Inventaris</a>
        <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" /></svg>
        <span class="font-medium text-zinc-900">Review</span>
    </nav>

    <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-zinc-900">Review Import Inventaris</h2>
            <p class="text-sm text-zinc-500">{{ $batch->file_name }} &middot; {{ $batch->total_rows }} baris data</p>
        </div>
        <span class="w-fit rounded-md px-3 py-1 text-sm font-semibold {{ $batch->status === 'pending' ? 'bg-amber-50 text-amber-700 border border-amber-200' : ($batch->status === 'approved' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-red-50 text-red-700 border border-red-200') }}">
            {{ ucfirst($batch->status) }}
        </span>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="rounded-lg border border-zinc-200 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-zinc-500">Total Baris</p>
            <p class="mt-2 text-2xl font-bold text-zinc-900">{{ $batch->total_rows }}</p>
        </div>
        <div class="rounded-lg border border-emerald-200 bg-emerald-50 p-5 shadow-sm">
            <p class="text-sm font-medium text-emerald-700">Valid</p>
            <p class="mt-2 text-2xl font-bold text-emerald-800">{{ $batch->valid_rows }}</p>
        </div>
        <div class="rounded-lg border border-red-200 bg-red-50 p-5 shadow-sm">
            <p class="text-sm font-medium text-red-700">Salah Data</p>
            <p class="mt-2 text-2xl font-bold text-red-800">{{ $batch->invalid_rows }}</p>
        </div>
    </div>

    <div class="rounded-lg border border-zinc-200 bg-white shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-zinc-200 bg-zinc-50 text-xs uppercase text-zinc-500">
                    <tr>
                        <th class="px-4 py-3">No</th>
                        <th class="px-4 py-3">Nama Barang</th>
                        <th class="px-4 py-3">Relasi</th>
                        <th class="px-4 py-3">Qty</th>
                        <th class="px-4 py-3">Kondisi</th>
                        <th class="px-4 py-3">Tanggal</th>
                        <th class="px-4 py-3">Validasi</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    @foreach($batch->rows as $row)
                        @php($payload = $row->payload)
                        <tr class="{{ $row->validation_errors ? 'bg-red-50/50' : 'bg-white' }}">
                            <td class="px-4 py-3">
                                <span class="text-sm font-semibold text-zinc-700">{{ $loop->iteration }}</span>
                                <span class="block text-[10px] text-zinc-400">Row file: {{ $row->row_number }}</span>
                            </td>
                            <td class="px-4 py-3">
                                <p class="font-medium text-zinc-900">{{ $payload['nama_barang'] ?? '-' }}</p>
                                <p class="text-xs text-zinc-500">{{ $payload['merek'] ?? '-' }}</p>
                            </td>
                            <td class="px-4 py-3 text-xs font-mono text-zinc-500">
                                <div class="font-sans text-xs text-zinc-700">Kategori: {{ $kategoris[$payload['kategori_id'] ?? ''] ?? 'Tidak ditemukan' }}</div>
                                <div class="font-sans text-xs text-zinc-700">Unit Kerja: {{ $jurusans[$payload['jurusan_id'] ?? ''] ?? 'Tidak ditemukan' }}</div>
                                <div class="font-sans text-xs text-zinc-700">Ruangan: {{ $ruangans[$payload['ruangan_id'] ?? ''] ?? 'Tidak ditemukan' }}</div>
                            </td>
                            <td class="px-4 py-3 font-semibold text-zinc-900">{{ $payload['jumlah_total'] ?? '-' }}</td>
                            <td class="px-4 py-3">{{ $payload['kondisi'] ?? '-' }}</td>
                            <td class="px-4 py-3">{{ $payload['tanggal_pengadaan'] ?? '-' }}</td>
                            <td class="px-4 py-3">
                                @if($row->validation_errors)
                                    <ul class="space-y-1 text-xs text-red-600">
                                        @foreach($row->validation_errors as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <span class="rounded-md bg-emerald-50 px-2 py-1 text-xs font-semibold text-emerald-700">Valid</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right">
                                @if($batch->status === 'pending')
                                    <a href="{{ route('inventaris.imports.rows.edit', [$batch->id, $row->id]) }}"
                                        class="inline-flex items-center rounded-md border {{ $row->validation_errors ? 'border-red-200 bg-red-50 text-red-700 hover:bg-red-100' : 'border-zinc-200 bg-white text-zinc-700 hover:bg-zinc-50' }} px-2.5 py-1.5 text-xs font-medium transition-colors">
                                        Edit
                                    </a>
                                @else
                                    <span class="text-xs text-zinc-400">-</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @if($batch->status === 'pending')
        <div class="rounded-lg border border-zinc-200 bg-white p-5 shadow-sm">
            <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-4">
                <div>
                    <h3 class="text-sm font-semibold text-zinc-900">Keputusan Import</h3>
                    <p class="text-xs text-zinc-500">Setujui untuk memasukkan semua baris valid ke inventaris, atau tolak jika data perlu diperbaiki.</p>
                </div>
                <div class="flex flex-wrap justify-end gap-3">
                    <form action="{{ route('inventaris.imports.reject', $batch->id) }}" method="POST" class="flex flex-col sm:flex-row gap-2">
                        @csrf
                        @method('PATCH')
                        <input type="text" name="review_note" placeholder="Catatan penolakan (opsional)" class="h-10 rounded-md border border-zinc-200 px-3 text-sm">
                        <button type="submit" class="h-10 rounded-md border border-red-200 bg-red-50 px-4 text-sm font-medium text-red-700 hover:bg-red-100 cursor-pointer">Tolak</button>
                    </form>
                    <form id="approve-import-form" action="{{ route('inventaris.imports.approve', $batch->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="button" onclick="openApproveModal()" class="h-10 rounded-md bg-emerald-600 px-4 text-sm font-medium text-white hover:bg-emerald-700 disabled:opacity-50 cursor-pointer" @disabled($batch->invalid_rows > 0)>
                            Setujui & Tambahkan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @else
        <div class="rounded-lg border border-zinc-200 bg-white p-5 text-sm text-zinc-600 shadow-sm">
            Diproses oleh {{ $batch->reviewer?->nama ?? '-' }} pada {{ $batch->reviewed_at?->format('d M Y, H:i') ?? '-' }}.
            @if($batch->review_note)
                <span class="block mt-1">Catatan: {{ $batch->review_note }}</span>
            @endif
        </div>
    @endif
</div>

@if($batch->status === 'pending')
    <div id="approve-modal" class="fixed inset-0 z-50 hidden items-center justify-center px-4 py-6">
        <div class="absolute inset-0 bg-slate-950/60 backdrop-blur-sm" onclick="closeApproveModal()"></div>

        <div class="relative w-full max-w-lg overflow-hidden rounded-2xl bg-white shadow-2xl ring-1 ring-emerald-950/10">
            <div class="relative overflow-hidden bg-gradient-to-br from-emerald-800 via-emerald-600 to-green-500 px-6 py-5 text-white">
                <div class="absolute -right-8 -top-12 h-32 w-32 rounded-full bg-white/10"></div>
                <div class="absolute bottom-0 left-8 h-1.5 w-28 rounded-t-full bg-lime-300/80"></div>

                <div class="relative flex items-start justify-between gap-4">
                    <div>
                        <p class="text-[11px] font-extrabold uppercase tracking-widest text-emerald-50">Konfirmasi Import</p>
                        <h3 class="mt-2 text-xl font-extrabold tracking-tight">Setujui & Tambahkan Data?</h3>
                        <p class="mt-1 text-sm font-medium text-emerald-50">{{ $batch->file_name }}</p>
                    </div>
                    <button type="button" onclick="closeApproveModal()" class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-white/15 text-white ring-1 ring-white/20 transition-colors hover:bg-white/25 cursor-pointer">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="space-y-5 p-6">
                <div class="grid grid-cols-3 gap-3">
                    <div class="rounded-xl border border-zinc-200 bg-zinc-50 px-3 py-3 text-center">
                        <p class="text-[11px] font-bold uppercase tracking-wide text-zinc-500">Total</p>
                        <p class="mt-1 text-xl font-extrabold text-zinc-900">{{ $batch->total_rows }}</p>
                    </div>
                    <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-3 py-3 text-center">
                        <p class="text-[11px] font-bold uppercase tracking-wide text-emerald-700">Valid</p>
                        <p class="mt-1 text-xl font-extrabold text-emerald-800">{{ $batch->valid_rows }}</p>
                    </div>
                    <div class="rounded-xl border border-red-200 bg-red-50 px-3 py-3 text-center">
                        <p class="text-[11px] font-bold uppercase tracking-wide text-red-700">Salah</p>
                        <p class="mt-1 text-xl font-extrabold text-red-800">{{ $batch->invalid_rows }}</p>
                    </div>
                </div>

                <div class="rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-800">
                    Setelah disetujui, seluruh baris valid akan dibuat menjadi data inventaris baru dan kode inventaris akan digenerate otomatis.
                </div>

                <div class="flex justify-end gap-3 border-t border-zinc-100 pt-5">
                    <button type="button" onclick="closeApproveModal()" class="h-10 rounded-md border border-zinc-200 bg-white px-4 text-sm font-medium text-zinc-700 hover:bg-zinc-50 cursor-pointer">
                        Batal
                    </button>
                    <button type="button" onclick="submitApproveImport()" class="h-10 rounded-md bg-emerald-600 px-4 text-sm font-medium text-white hover:bg-emerald-700 cursor-pointer">
                        Ya, Setujui Import
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openApproveModal() {
            const modal = document.getElementById('approve-modal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.classList.add('overflow-hidden');
        }

        function closeApproveModal() {
            const modal = document.getElementById('approve-modal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.classList.remove('overflow-hidden');
        }

        function submitApproveImport() {
            document.getElementById('approve-import-form').submit();
        }

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                closeApproveModal();
            }
        });
    </script>
@endif
@endsection
