@extends('layouts.app')

@section('title', 'Detail Peminjaman - Inventaris SMKN 2 SBY')
@section('page_title', 'Detail Peminjaman')

@php
    $isOverdue = in_array($peminjaman->status, ['Dipinjam', 'Terlambat']) && 
                 $peminjaman->tanggal_estimasi_kembali && 
                 $peminjaman->tanggal_estimasi_kembali->startOfDay()->isPast();
                 
    $daysOverdue = $isOverdue ? (int) $peminjaman->tanggal_estimasi_kembali->startOfDay()->diffInDays(now()->startOfDay()) : 0;

    $isApproaching = in_array($peminjaman->status, ['Dipinjam', 'Terlambat']) && 
                     $peminjaman->tanggal_estimasi_kembali && 
                     !$isOverdue &&
                     now()->startOfDay()->diffInDays($peminjaman->tanggal_estimasi_kembali->startOfDay(), false) <= 3;
                     
    $daysLeft = $isApproaching ? (int) now()->startOfDay()->diffInDays($peminjaman->tanggal_estimasi_kembali->startOfDay(), false) : null;
@endphp

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <nav class="flex items-center gap-1.5 text-sm text-zinc-500 print:hidden">
        <a href="{{ route('dashboard') }}" class="hover:text-zinc-900 transition-colors">Dashboard</a>
        <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
        </svg>
        <a href="{{ route('peminjamans.index') }}" class="hover:text-zinc-900 transition-colors">Peminjaman</a>
        <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
        </svg>
        <span class="font-medium text-zinc-900">Detail Peminjaman</span>
    </nav>

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 print:hidden">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-zinc-900">Peminjaman Barang</h2>
            <p class="text-sm text-zinc-500">Detail peminjaman eksternal.</p>
        </div>
        <div class="flex items-center gap-2">
            @if(in_array($peminjaman->status, ['Dipinjam', 'Terlambat']))
                <form action="{{ route('peminjamans.kembalikan', $peminjaman->id) }}" method="POST" id="form-kembalikan">
                    @csrf
                    <button type="button" onclick="confirmKembalikan()" class="inline-flex items-center gap-2 rounded-md bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 text-sm font-semibold transition-colors cursor-pointer">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        Kembalikan Barang
                    </button>
                </form>
            @endif
            <button onclick="window.print()" class="inline-flex items-center gap-2 rounded-md bg-zinc-900 text-zinc-50 px-4 py-2 text-sm font-medium hover:bg-zinc-800 transition-colors">Cetak Bukti</button>
            <a href="{{ route('peminjamans.index') }}" class="inline-flex items-center gap-2 rounded-md border border-zinc-200 px-4 py-2 text-sm font-medium hover:bg-zinc-50 transition-colors">Kembali</a>
        </div>
    </div>

    @if($isOverdue)
        <div class="rounded-lg border border-red-200 bg-red-50 p-4 flex items-start gap-3 shadow-sm print:hidden">
            <div class="flex-shrink-0 mt-0.5">
                <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-red-100 text-red-600">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </span>
            </div>
            <div>
                <h3 class="text-sm font-bold text-red-800">Peminjaman Melebihi Batas Waktu (Overdue)</h3>
                <p class="text-xs text-red-700 mt-1">Barang ini terlambat dikembalikan selama <strong>{{ $daysOverdue }} hari</strong>. Batas waktu pengembalian adalah {{ $peminjaman->tanggal_estimasi_kembali->format('d F Y') }}.</p>
            </div>
        </div>
    @elseif($isApproaching)
        <div class="rounded-lg border border-amber-200 bg-amber-50 p-4 flex items-start gap-3 shadow-sm print:hidden">
            <div class="flex-shrink-0 mt-0.5">
                <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-amber-100 text-amber-600">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </span>
            </div>
            <div>
                <h3 class="text-sm font-bold text-amber-800">Mendekati Batas Pengembalian</h3>
                <p class="text-xs text-amber-700 mt-1">
                    @if($daysLeft === 0)
                        Peminjaman jatuh tempo <strong>hari ini</strong>!
                    @else
                        Peminjaman akan jatuh tempo dalam <strong>{{ $daysLeft }} hari lagi</strong> ({{ $peminjaman->tanggal_estimasi_kembali->format('d F Y') }}).
                    @endif
                </p>
            </div>
        </div>
    @endif

    <!-- Informasi Kontak Darurat / Kendala Peminjaman -->
    <div class="rounded-lg border border-zinc-200 bg-white shadow-sm p-6 space-y-4 print:hidden animate-fade-in">
        <div class="flex items-start gap-4">
            <div class="flex-shrink-0">
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-zinc-100 text-zinc-900">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a.75.75 0 0 1-1.074-.765 7.99 7.99 0 0 0 1.257-3.807C3.136 14.887 2.1 12.653 2.1 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z" />
                    </svg>
                </span>
            </div>
            <div>
                <h3 class="text-sm font-bold text-zinc-950">Kontak Peminjam (Hubungi Jika Terjadi Kendala)</h3>
                <p class="text-xs text-zinc-500 mt-0.5">Gunakan informasi di bawah ini untuk menghubungi peminjam secara langsung jika terdapat kendala pengembalian, keterlambatan, atau kerusakan barang.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
            <div class="p-4 rounded-lg bg-zinc-50 border border-zinc-150">
                <span class="text-[10px] font-bold text-zinc-400 uppercase tracking-wider block">Peminjam / Instansi</span>
                <span class="text-base font-bold text-zinc-900 block mt-1">{{ $peminjaman->nama_peminjam }}</span>
                @if($peminjaman->instansi)
                    <span class="text-xs text-zinc-500 block mt-0.5">{{ $peminjaman->instansi }}</span>
                @else
                    <span class="text-xs text-zinc-400 italic block mt-0.5">Umum / Tanpa Instansi</span>
                @endif
            </div>

            <div class="p-4 rounded-lg bg-zinc-50 border border-zinc-150 flex flex-col justify-between gap-3">
                <div>
                    <span class="text-[10px] font-bold text-zinc-400 uppercase tracking-wider block">Informasi Kontak</span>
                    @if($peminjaman->kontak)
                        <span class="text-base font-bold text-zinc-900 font-mono block mt-1">{{ $peminjaman->kontak }}</span>
                    @else
                        <span class="text-sm text-zinc-400 italic block mt-1">Tidak ada nomor kontak</span>
                    @endif
                </div>

                @if($peminjaman->kontak)
                    @php
                        $cleanPhone = preg_replace('/[^0-9]/', '', $peminjaman->kontak);
                        if (str_starts_with($cleanPhone, '0')) {
                            $cleanPhone = '62' . substr($cleanPhone, 1);
                        }
                        $isPhone = !empty($cleanPhone) && strlen($cleanPhone) >= 9;
                        $isEmail = filter_var($peminjaman->kontak, FILTER_VALIDATE_EMAIL);
                    @endphp

                    <div class="flex flex-wrap gap-2">
                        @if($isPhone)
                            <a href="https://wa.me/{{ $cleanPhone }}?text=Halo%20{{ urlencode($peminjaman->nama_peminjam) }},%20kami%20dari%20pihak%20Inventaris%20SMKN%202%20Surabaya%20ingin%20menanyakan%20perihal%20peminjaman%20barang%20{{ urlencode($peminjaman->inventaris->nama_barang ?? 'inventaris') }}..." 
                               target="_blank" 
                               rel="noopener noreferrer" 
                               class="inline-flex items-center gap-1.5 rounded bg-emerald-600 hover:bg-emerald-700 text-white px-3 py-1.5 text-xs font-semibold transition-colors cursor-pointer shadow-sm">
                                <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24">
                                    <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.724-1.455L0 24zm6.59-4.846c1.6.95 3.188 1.449 4.625 1.451 5.403.002 9.799-4.392 9.802-9.796.002-2.618-1.01-5.078-2.855-6.927C16.378 2.036 13.924.99 11.997.99 6.602.99 2.208 5.383 2.206 10.785c-.002 1.543.407 3.05 1.186 4.385L2.345 20.8l5.808-1.52c-.687.359-.728.324.494-.126z"/>
                                </svg>
                                Hubungi via WhatsApp
                            </a>
                            <a href="tel:{{ $peminjaman->kontak }}" 
                               class="inline-flex items-center gap-1.5 rounded border border-zinc-200 bg-white hover:bg-zinc-50 text-zinc-700 px-3 py-1.5 text-xs font-semibold transition-colors cursor-pointer shadow-sm">
                                <svg class="w-3.5 h-3.5 text-zinc-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-2.824-1.806-5.194-4.176-8-7l1.293-.97c.362-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                                </svg>
                                Telepon Langsung
                            </a>
                        @elseif($isEmail)
                            <a href="mailto:{{ $peminjaman->kontak }}?subject=Peminjaman%20Barang%20SMKN%202%20Surabaya" 
                               class="inline-flex items-center gap-1.5 rounded border border-zinc-200 bg-white hover:bg-zinc-50 text-zinc-700 px-3 py-1.5 text-xs font-semibold transition-colors cursor-pointer shadow-sm">
                                <svg class="w-3.5 h-3.5 text-zinc-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                                </svg>
                                Kirim Email
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="rounded-lg border border-zinc-200 bg-white shadow-sm overflow-hidden divide-y divide-zinc-100">
        <div class="p-6 bg-zinc-50/50 grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <span class="text-[10px] font-semibold text-zinc-400 uppercase tracking-widest">Nama Peminjam</span>
                <p class="text-sm font-bold text-zinc-900 tracking-tight">{{ $peminjaman->nama_peminjam }}</p>
            </div>
            <div>
                <span class="text-[10px] font-semibold text-zinc-400 uppercase tracking-widest">Instansi / Kontak</span>
                <p class="text-[10px] text-zinc-500 tracking-tight">{{ $peminjaman->instansi }} — {{ $peminjaman->kontak }}</p>
            </div>
            <div class="sm:text-right">
                <span class="text-[10px] font-semibold text-zinc-400 uppercase tracking-widest">Status</span>
                <p class="text-sm font-semibold text-zinc-900">{{ $peminjaman->status }}</p>
            </div>
        </div>

        <div class="p-6 space-y-6">
            <div class="space-y-2">
                <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider">Barang yang Dipinjam</span>
                <div class="flex items-start gap-4 p-4 rounded-lg border border-zinc-100 bg-zinc-50/30">
                    <div>
                        <div class="font-medium text-zinc-900">{{ $peminjaman->inventaris->nama_barang ?? '-' }}</div>
                        <div class="text-xs text-zinc-400 font-mono">{{ $peminjaman->inventaris->kode_inventaris ?? '' }}</div>
                        <div class="text-xs text-zinc-600 mt-1">Jumlah dipinjam: <strong>{{ $peminjaman->jumlah_pinjam }}</strong></div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 pt-2">
                <div>
                    <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider">Tanggal Pinjam</span>
                    <div class="text-sm text-zinc-900">{{ $peminjaman->tanggal_pinjam->format('d F Y') }}</div>
                </div>
                <div>
                    <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider">Estimasi Kembali</span>
                    <div class="text-sm text-zinc-900">{{ optional($peminjaman->tanggal_estimasi_kembali)->format('d F Y') ?? '-' }}</div>
                </div>
                <div>
                    <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider">Diproses Oleh</span>
                    <div class="text-sm text-zinc-900">{{ $peminjaman->user->nama ?? '-' }}</div>
                </div>
            </div>

            <div class="space-y-1.5 pt-2">
                <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider">Keterangan</span>
                <div class="text-sm text-zinc-700">-</div>
            </div>
        </div>
    </div>

    <div class="hidden print:block print-document bg-white text-zinc-950 p-8 font-serif leading-relaxed border border-zinc-300">
        <div class="text-center mb-6">
            <h2 class="text-base font-bold uppercase">Surat Bukti Peminjaman Barang</h2>
            <p class="text-xs font-mono mt-1">{{ $peminjaman->created_at->format('d F Y') }}</p>
        </div>

        <p class="text-xs mb-4">Yang bertanda tangan di bawah ini, mencatat peminjaman barang sebagai berikut:</p>

        <table class="w-full text-xs border-collapse border border-zinc-950 mb-6">
            <tbody>
                <tr>
                    <td class="p-2 font-semibold">Nama Peminjam</td>
                    <td class="p-2">: {{ $peminjaman->nama_peminjam }}</td>
                </tr>
                <tr>
                    <td class="p-2 font-semibold">Instansi / Kontak</td>
                    <td class="p-2">: {{ $peminjaman->instansi }} / {{ $peminjaman->kontak }}</td>
                </tr>
                <tr>
                    <td class="p-2 font-semibold">Barang</td>
                    <td class="p-2">: {{ $peminjaman->inventaris->nama_barang ?? '-' }} ({{ $peminjaman->inventaris->kode_inventaris ?? '' }})</td>
                </tr>
                <tr>
                    <td class="p-2 font-semibold">Jumlah</td>
                    <td class="p-2">: {{ $peminjaman->jumlah_pinjam }}</td>
                </tr>
                <tr>
                    <td class="p-2 font-semibold">Tanggal Pinjam</td>
                    <td class="p-2">: {{ $peminjaman->tanggal_pinjam->format('d F Y') }}</td>
                </tr>
                <tr>
                    <td class="p-2 font-semibold">Estimasi Kembali</td>
                    <td class="p-2">: {{ optional($peminjaman->tanggal_estimasi_kembali)->format('d F Y') ?? '-' }}</td>
                </tr>
            </tbody>
        </table>

        <div class="grid grid-cols-3 gap-4 text-xs text-center mt-8">
            <div>
                <div class="font-semibold">Peminjam</div>
                <div class="mt-8">(....................................)</div>
            </div>
            <div>
                <div class="font-semibold">Petugas</div>
                <div class="mt-8">{{ $peminjaman->user->nama ?? '-' }}</div>
            </div>
            <div>
                <div class="font-semibold">Penanggung Jawab</div>
                <div class="mt-8">(....................................)</div>
            </div>
        </div>
    </div>
</div>

@if(in_array($peminjaman->status, ['Dipinjam', 'Terlambat']))
<script>
    function confirmKembalikan() {
        Swal.fire({
            title: 'Konfirmasi Pengembalian',
            text: 'Apakah Anda yakin ingin menandai barang peminjaman ini sebagai dikembalikan? Stok barang di inventaris akan ditambahkan kembali.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#10b981',
            cancelButtonColor: '#71717a',
            confirmButtonText: 'Ya, Kembalikan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-kembalikan').submit();
            }
        });
    }
</script>
@endif
@endsection
