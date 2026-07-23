@extends('layouts.app')

@section('title', 'Riwayat Peminjaman - Inventaris SMKN 2 SBY')
@section('page_title', 'Peminjaman Barang')

@section('content')
<div class="space-y-6">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-1.5 text-sm text-zinc-500">
        <a href="{{ route('dashboard') }}" class="hover:text-zinc-900 transition-colors">Dashboard</a>
        <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
        </svg>
        <span class="font-medium text-zinc-900">Riwayat Peminjaman</span>
    </nav>

    {{-- Header Section --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-zinc-900">Riwayat Peminjaman Barang</h2>
            <p class="text-sm text-zinc-500">Log peminjaman eksternal dari inventaris.</p>
        </div>
        <div>
            <a href="{{ route('peminjamans.create') }}" class="inline-flex items-center justify-center gap-2 rounded-md bg-zinc-900 text-zinc-50 hover:bg-zinc-800 px-4 py-2 text-sm font-medium shadow-sm transition-all duration-150 cursor-pointer">Peminjaman Baru</a>
        </div>
    </div>

    {{-- Active Alerts --}}
    @if(isset($peminjamanAlerts) && $peminjamanAlerts['count'] > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            @if($peminjamanAlerts['overdue']->count() > 0)
                <div class="rounded-lg border border-red-200 bg-red-50 p-4 flex items-start gap-3 shadow-sm">
                    <div class="flex-shrink-0 mt-0.5">
                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-red-100 text-red-600">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </span>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-red-800">Keterlambatan Pengembalian</h3>
                        <p class="text-xs text-red-700 mt-1">Terdapat <strong>{{ $peminjamanAlerts['overdue']->count() }}</strong> peminjaman yang telah melewati batas estimasi kembali. Harap segera hubungi peminjam.</p>
                    </div>
                </div>
            @endif

            @if($peminjamanAlerts['approaching']->count() > 0)
                <div class="rounded-lg border border-amber-200 bg-amber-50 p-4 flex items-start gap-3 shadow-sm">
                    <div class="flex-shrink-0 mt-0.5">
                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-amber-100 text-amber-600">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </span>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-amber-800">Jatuh Tempo Menjelang Kembali</h3>
                        <p class="text-xs text-amber-700 mt-1">Terdapat <strong>{{ $peminjamanAlerts['approaching']->count() }}</strong> peminjaman yang mendekati batas waktu kembali (hari ini s/d 3 hari ke depan).</p>
                    </div>
                </div>
            @endif
        </div>
    @endif

    {{-- Tabs Filter --}}
    <div class="flex flex-wrap items-center gap-1 border-b border-zinc-200 pb-px">
        <button type="button" onclick="filterTab('all', this)" class="tab-btn px-4 py-2 text-xs sm:text-sm font-bold border-b-2 border-zinc-950 text-zinc-950 transition-all cursor-pointer">
            Semua
        </button>
        <button type="button" onclick="filterTab('Dipinjam', this)" class="tab-btn px-4 py-2 text-xs sm:text-sm font-bold border-b-2 border-transparent text-zinc-400 hover:text-zinc-700 transition-all cursor-pointer">
            Sedang Dipinjam
        </button>
        <button type="button" onclick="filterTab('Terlambat', this)" class="tab-btn px-4 py-2 text-xs sm:text-sm font-bold border-b-2 border-transparent text-zinc-400 hover:text-zinc-700 transition-all cursor-pointer">
            Terlambat
        </button>
        <button type="button" onclick="filterTab('Dikembalikan', this)" class="tab-btn px-4 py-2 text-xs sm:text-sm font-bold border-b-2 border-transparent text-zinc-400 hover:text-zinc-700 transition-all cursor-pointer">
            Dikembalikan
        </button>
        <button type="button" onclick="filterTab('approaching', this)" class="tab-btn px-4 py-2 text-xs sm:text-sm font-bold border-b-2 border-transparent text-zinc-400 hover:text-zinc-700 transition-all cursor-pointer">
            Mendekati Batas (≤ 3 Hari)
        </button>
    </div>

    {{-- Table Card --}}
    <div class="rounded-lg border border-zinc-200 bg-white shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs uppercase bg-zinc-50 text-zinc-500 border-b border-zinc-200">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-semibold w-12">No</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Tanggal Pinjam</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Nama Peminjam</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Instansi / Kontak</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Barang</th>
                        <th scope="col" class="px-6 py-4 font-semibold text-center">Qty</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Estimasi Kembali</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Status</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Petugas</th>
                        <th scope="col" class="px-6 py-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    @forelse ($peminjamans as $item)
                        @php
                            $isRowApproaching = false;
                            if (in_array($item->status, ['Dipinjam', 'Terlambat']) && $item->tanggal_estimasi_kembali) {
                                $diff = (int) now()->startOfDay()->diffInDays($item->tanggal_estimasi_kembali->startOfDay(), false);
                                $isRowApproaching = ($diff >= 0 && $diff <= 3);
                            }
                        @endphp
                        <tr class="peminjaman-row hover:bg-zinc-50/60 transition-colors {{ $loop->even ? 'bg-zinc-50/30' : 'bg-white' }}"
                            data-status="{{ $item->status }}"
                            data-approaching="{{ $isRowApproaching ? 'true' : 'false' }}">
                            <td class="px-6 py-4 text-zinc-400 font-mono text-xs">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 text-zinc-600 font-medium">{{ $item->tanggal_pinjam->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-zinc-900 font-medium">{{ $item->nama_peminjam }}</td>
                            <td class="px-6 py-4 text-zinc-600 text-xs">{{ $item->instansi }}<br>{{ $item->kontak }}</td>
                            <td class="px-6 py-4">
                                <div class="font-medium text-zinc-900">{{ $item->inventaris->nama_barang ?? '-' }}</div>
                                <div class="text-xs text-zinc-400 font-mono">{{ $item->inventaris->kode_inventaris ?? '' }}</div>
                            </td>
                            <td class="px-6 py-4 text-center font-semibold text-zinc-800">{{ $item->jumlah_pinjam }}</td>
                            <td class="px-6 py-4">{{ optional($item->tanggal_estimasi_kembali)->format('d M Y') ?? '-' }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-0.5 rounded {{ $item->status=='Dipinjam' ? 'bg-amber-50 text-amber-700 border border-amber-100' : ($item->status=='Dikembalikan' ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : 'bg-red-50 text-red-700 border border-red-100') }} text-xs font-semibold">{{ $item->status }}</span>
                            </td>
                            <td class="px-6 py-4 text-zinc-600 text-xs">{{ $item->user->nama ?? '-' }}</td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('peminjamans.show', $item->id) }}" class="p-1.5 rounded-md border border-zinc-200 text-zinc-600 hover:text-zinc-950 bg-white hover:bg-zinc-50 transition-colors shadow-sm text-xs font-medium inline-flex items-center gap-1">Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="px-6 py-16 text-center text-zinc-500">
                                <div class="flex flex-col items-center justify-center gap-3">
                                    <div class="w-14 h-14 rounded-full bg-zinc-100 flex items-center justify-center"></div>
                                    <div class="text-sm">Belum ada data peminjaman.</div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($peminjamans->isNotEmpty())
            <div class="px-6 py-3 border-t border-zinc-100 bg-zinc-50/50">
                <p class="text-xs text-zinc-400">Menampilkan <span class="font-medium text-zinc-600">{{ $peminjamans->count() }}</span> riwayat peminjaman</p>
            </div>
        @endif
    </div>
</div>

<script>
    function filterTab(status, btn) {
        // Toggle active styles on tabs
        document.querySelectorAll('.tab-btn').forEach(tab => {
            tab.classList.remove('border-zinc-950', 'text-zinc-950');
            tab.classList.add('border-transparent', 'text-zinc-400');
        });
        btn.classList.remove('border-transparent', 'text-zinc-400');
        btn.classList.add('border-zinc-950', 'text-zinc-950');

        // Show/hide rows
        const rows = document.querySelectorAll('.peminjaman-row');
        let visibleCount = 0;

        rows.forEach(row => {
            const rowStatus = row.dataset.status;
            const isApproaching = row.dataset.approaching === 'true';

            if (status === 'all') {
                row.classList.remove('hidden');
                visibleCount++;
            } else if (status === 'approaching') {
                if (isApproaching) {
                    row.classList.remove('hidden');
                    visibleCount++;
                } else {
                    row.classList.add('hidden');
                }
            } else {
                if (rowStatus === status) {
                    row.classList.remove('hidden');
                    visibleCount++;
                } else {
                    row.classList.add('hidden');
                }
            }
        });

        // Show empty message if no rows visible
        const emptyRow = document.getElementById('empty-row-message');
        if (visibleCount === 0) {
            if (!emptyRow) {
                const tbody = document.querySelector('tbody');
                const tr = document.createElement('tr');
                tr.id = 'empty-row-message';
                tr.innerHTML = `
                    <td colspan="10" class="px-6 py-16 text-center text-zinc-500">
                        <div class="flex flex-col items-center justify-center gap-3">
                            <div class="text-sm">Tidak ada data peminjaman dengan filter ini.</div>
                        </div>
                    </td>
                `;
                tbody.appendChild(tr);
            } else {
                emptyRow.classList.remove('hidden');
            }
        } else {
            if (emptyRow) {
                emptyRow.remove();
            }
        }
    }
</script>
@endsection
