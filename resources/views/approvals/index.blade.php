@extends('layouts.app')

@section('title', 'Approval Pengadaan - Inventaris SMKN 2 SBY')
@section('page_title', 'Approval Pengadaan')

@section('content')
<div class="space-y-6">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-1.5 text-sm text-zinc-500">
        <a href="{{ route('dashboard') }}" class="hover:text-zinc-900 transition-colors">Dashboard</a>
        <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
        </svg>
        <span class="font-medium text-zinc-900">Approval Pengadaan</span>
    </nav>

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-2">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-zinc-900">Approval Usulan Pengadaan</h2>
            <p class="text-sm text-zinc-500 mt-0.5">
                @if ($pendingPengadaans->isEmpty())
                    Semua usulan telah diproses.
                @else
                    <span class="inline-flex items-center gap-1 font-semibold text-amber-600">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                        </svg>
                        {{ $pendingPengadaans->count() }} usulan menunggu persetujuan
                    </span>
                @endif
            </p>
        </div>
        <a href="{{ route('pengadaans.index') }}"
            class="inline-flex items-center gap-1.5 text-sm text-zinc-500 hover:text-zinc-950 transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0ZM3.75 12h.007v.008H3.75V12Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm-.375 5.25h.007v.008H3.75v-.008Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
            </svg>
            Lihat Semua Usulan
        </a>
    </div>

    {{-- Empty State --}}
    @if ($pendingPengadaans->isEmpty())
        <div class="rounded-lg border border-zinc-200 bg-white shadow-sm px-6 py-20 text-center">
            <div class="flex flex-col items-center justify-center gap-4">
                <div class="w-16 h-16 rounded-full bg-green-50 flex items-center justify-center">
                    <svg class="w-8 h-8 text-green-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
                <div>
                    <p class="text-base font-semibold text-zinc-800">Semua usulan sudah diproses</p>
                    <p class="text-sm text-zinc-400 mt-1 max-w-sm mx-auto">
                        Tidak ada usulan yang menunggu persetujuan saat ini. Cek kembali nanti.
                    </p>
                </div>
                <a href="{{ route('pengadaans.index') }}"
                    class="mt-1 inline-flex items-center gap-1.5 rounded-md border border-zinc-200 bg-white text-zinc-700 hover:bg-zinc-50 px-4 py-2 text-sm font-medium transition-colors shadow-sm">
                    Lihat Semua Usulan
                </a>
            </div>
        </div>
    @else
        {{-- Card Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
            @foreach ($pendingPengadaans as $p)
                <div class="rounded-xl border border-zinc-200 bg-white shadow-sm hover:shadow-md transition-shadow duration-200 flex flex-col overflow-hidden">

                    {{-- Card Header --}}
                    <div class="px-5 py-4 border-b border-zinc-100 bg-amber-50/40">
                        <div class="flex items-start justify-between gap-2">
                            <h3 class="font-semibold text-zinc-900 text-sm leading-snug line-clamp-2 flex-1">
                                {{ $p->nama_barang_usulan }}
                            </h3>
                            <span class="inline-flex items-center rounded-full bg-amber-100 px-2.5 py-0.5 text-xs font-semibold text-amber-700 border border-amber-200/60 shrink-0 mt-0.5">
                                Pending
                            </span>
                        </div>
                    </div>

                    {{-- Card Body --}}
                    <div class="px-5 py-4 flex-1 space-y-3">
                        {{-- Jurusan & Kategori --}}
                        <div class="space-y-1.5">
                            <div class="flex items-center gap-2 text-xs text-zinc-600">
                                <svg class="w-3.5 h-3.5 text-zinc-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75Z" />
                                </svg>
                                <span class="font-medium text-zinc-700">{{ $p->jurusan->nama_jurusan ?? '-' }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-xs text-zinc-600">
                                <svg class="w-3.5 h-3.5 text-zinc-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" />
                                </svg>
                                <span>{{ $p->kategori->nama_kategori ?? '-' }}</span>
                                @if ($p->kategori)
                                    <span class="inline-flex rounded bg-teal-50 px-1.5 py-0.5 text-xs font-mono font-semibold text-teal-600 border border-teal-200/60">
                                        {{ $p->kategori->kode_kategori }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- Jumlah & Harga --}}
                        <div class="grid grid-cols-2 gap-3 pt-1">
                            <div class="rounded-md bg-zinc-50 border border-zinc-100 p-2.5">
                                <p class="text-[10px] font-semibold text-zinc-400 uppercase tracking-wide mb-0.5">Jumlah</p>
                                <p class="text-sm font-bold text-zinc-900">{{ $p->jumlah }} <span class="font-normal text-zinc-500 text-xs">unit</span></p>
                            </div>
                            <div class="rounded-md bg-zinc-50 border border-zinc-100 p-2.5">
                                <p class="text-[10px] font-semibold text-zinc-400 uppercase tracking-wide mb-0.5">Perkiraan Harga</p>
                                <p class="text-sm font-bold text-zinc-900 truncate">Rp {{ number_format($p->perkiraan_harga, 0, ',', '.') }}</p>
                            </div>
                        </div>

                        {{-- Alasan (truncate 2 baris) --}}
                        <div>
                            <p class="text-[10px] font-semibold text-zinc-400 uppercase tracking-wide mb-1">Alasan</p>
                            <p class="text-xs text-zinc-600 leading-relaxed line-clamp-2" title="{{ $p->alasan_pengadaan }}">
                                {{ $p->alasan_pengadaan }}
                            </p>
                        </div>

                        {{-- Pengusul & Tanggal --}}
                        <div class="flex items-center gap-2 pt-1 border-t border-zinc-100">
                            <div class="w-6 h-6 rounded-full bg-zinc-200 flex items-center justify-center text-xs font-bold text-zinc-600 shrink-0">
                                {{ strtoupper(substr($p->pengusul->nama ?? 'U', 0, 1)) }}
                            </div>
                            <div class="min-w-0">
                                <p class="text-xs font-medium text-zinc-700 truncate">{{ $p->pengusul->nama ?? '-' }}</p>
                                <p class="text-[10px] text-zinc-400">{{ $p->created_at->format('d M Y') }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Card Footer: Actions --}}
                    <div class="px-5 py-3 border-t border-zinc-100 bg-zinc-50/50 space-y-2">
                        {{-- Link detail --}}
                        <a href="{{ route('pengadaans.show', $p->id) }}"
                            class="flex items-center justify-center gap-1.5 text-xs text-zinc-700 hover:text-zinc-900 transition-colors py-1">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                            Lihat Detail Lengkap
                        </a>

                        {{-- Approve & Tolak --}}
                        <div class="grid grid-cols-2 gap-2">
                            <form id="app-{{ $p->id }}" action="{{ route('approvals.approve', $p->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="button"
                                    onclick="confirmApproveCard('{{ $p->id }}', '{{ addslashes($p->nama_barang_usulan) }}')"
                                    class="w-full inline-flex items-center justify-center gap-1.5 rounded-md bg-green-600 text-zinc-700 hover:bg-green-700 h-9 px-3 text-xs font-semibold shadow-sm transition-all duration-150 cursor-pointer">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                    </svg>
                                    Setujui
                                </button>
                            </form>

                            <form id="tlk-{{ $p->id }}" action="{{ route('approvals.tolak', $p->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="button"
                                    onclick="confirmTolakCard('{{ $p->id }}', '{{ addslashes($p->nama_barang_usulan) }}')"
                                    class="w-full inline-flex items-center justify-center gap-1.5 rounded-md bg-red-600 text-zinc-700 hover:bg-red-700 h-9 px-3 text-xs font-semibold shadow-sm transition-all duration-150 cursor-pointer">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                    </svg>
                                    Tolak
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<script>
    function confirmApproveCard(id, nama) {
        Swal.fire({
            title: 'Setujui Usulan?',
            html: `Yakin ingin <strong>menyetujui</strong> usulan:<br>
                   <strong>"${nama}"</strong>?<br>
                   <span class="text-sm text-gray-500">Status akan berubah menjadi <strong>Disetujui</strong>.</span>`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#16a34a',
            cancelButtonColor: '#6b7280',
            confirmButtonText: '✓ Ya, Setujui',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            focusCancel: true,
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('app-' + id).submit();
            }
        });
    }

    function confirmTolakCard(id, nama) {
        Swal.fire({
            title: 'Tolak Usulan?',
            html: `Yakin ingin <strong>menolak</strong> usulan:<br>
                   <strong>"${nama}"</strong>?<br>
                   <span class="text-sm text-gray-500">Status akan berubah menjadi <strong>Ditolak</strong>.</span>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: '✗ Ya, Tolak',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            focusCancel: true,
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('tlk-' + id).submit();
            }
        });
    }
</script>
@endsection
