@extends('layouts.app')

@section('title', 'Detail Usulan Pengadaan - Inventaris SMKN 2 SBY')
@section('page_title', 'Detail Usulan Pengadaan')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

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
        <span class="font-medium text-zinc-900">Detail Usulan</span>
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
        <h2 class="text-2xl font-bold tracking-tight text-zinc-900">Detail Usulan Pengadaan</h2>
        <p class="text-sm text-zinc-500">Informasi lengkap usulan pengadaan barang/aset.</p>
    </div>

    {{-- Detail Card --}}
    <div class="rounded-lg border border-zinc-200 bg-white shadow-sm overflow-hidden">

        {{-- Card Header --}}
        <div class="px-6 py-4 border-b border-zinc-100 bg-zinc-50/60 flex items-center justify-between gap-3">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-indigo-100 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25Z" />
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-zinc-900 text-sm">{{ $pengadaan->nama_barang_usulan }}</p>
                    <p class="text-xs text-zinc-500">Diusulkan oleh {{ $pengadaan->pengusul->nama ?? '-' }}</p>
                </div>
            </div>
            {{-- Status Badge --}}
            @if ($pengadaan->isPending())
                <span class="inline-flex items-center rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700 border border-amber-200/60 shrink-0">
                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm.75-13a.75.75 0 0 0-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 0 0 0-1.5h-3.25V5Z" clip-rule="evenodd" /></svg>
                    Pending
                </span>
            @elseif ($pengadaan->isDisetujui())
                <span class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700 border border-green-200/60 shrink-0">
                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd" /></svg>
                    Disetujui
                </span>
            @else
                <span class="inline-flex items-center rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700 border border-red-200/60 shrink-0">
                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16ZM8.28 7.22a.75.75 0 0 0-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 1 0 1.06 1.06L10 11.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L11.06 10l1.72-1.72a.75.75 0 0 0-1.06-1.06L10 8.94 8.28 7.22Z" clip-rule="evenodd" /></svg>
                    Ditolak
                </span>
            @endif
        </div>

        {{-- Info Grid --}}
        <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-5">
            <div>
                <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider block mb-1">Nama Barang Usulan</span>
                <span class="text-sm font-semibold text-zinc-900">{{ $pengadaan->nama_barang_usulan }}</span>
            </div>

            <div>
                <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider block mb-1">Kategori</span>
                @if ($pengadaan->kategori)
                    <div class="flex items-center gap-2">
                        <span class="text-sm text-zinc-800">{{ $pengadaan->kategori->nama_kategori }}</span>
                        <span class="inline-flex items-center rounded bg-teal-50 px-1.5 py-0.5 text-xs font-mono font-semibold text-teal-700 border border-teal-200/60">
                            {{ $pengadaan->kategori->kode_kategori }}
                        </span>
                    </div>
                @else
                    <span class="text-sm text-zinc-400 italic">Tidak ada</span>
                @endif
            </div>

            <div>
                <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider block mb-1">Jurusan / Program Keahlian</span>
                <span class="text-sm text-zinc-800">{{ $pengadaan->jurusan->nama_jurusan ?? '-' }}</span>
            </div>

            <div>
                <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider block mb-1">Jumlah</span>
                <span class="text-sm font-semibold text-zinc-900">{{ $pengadaan->jumlah }} <span class="font-normal text-zinc-500">unit</span></span>
            </div>

            <div>
                <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider block mb-1">Perkiraan Harga</span>
                <span class="text-sm font-semibold text-zinc-900">Rp {{ number_format($pengadaan->perkiraan_harga, 0, ',', '.') }}</span>
            </div>

            <div>
                <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider block mb-1">Diusulkan Oleh</span>
                <span class="text-sm text-zinc-800">{{ $pengadaan->pengusul->nama ?? '-' }}</span>
            </div>

            <div>
                <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider block mb-1">Tanggal Dibuat</span>
                <span class="text-sm text-zinc-700">{{ $pengadaan->created_at->format('d F Y, H:i') }} WIB</span>
            </div>

            <div>
                <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider block mb-1">Terakhir Diperbarui</span>
                <span class="text-sm text-zinc-700">{{ $pengadaan->updated_at->format('d F Y, H:i') }} WIB</span>
            </div>

            {{-- Alasan Pengadaan — full width --}}
            <div class="sm:col-span-2">
                <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider block mb-1">Alasan Pengadaan</span>
                <p class="text-sm text-zinc-800 leading-relaxed whitespace-pre-line bg-zinc-50 rounded-md p-3 border border-zinc-100">{{ $pengadaan->alasan_pengadaan }}</p>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="flex flex-wrap items-center gap-3 px-6 py-4 border-t border-zinc-100 bg-zinc-50/40">
            <a href="{{ route('pengadaans.index') }}"
                class="inline-flex items-center justify-center rounded-md border border-zinc-200 text-zinc-700 hover:text-zinc-950 bg-white hover:bg-zinc-50 h-10 px-4 py-2 text-sm font-medium shadow-sm transition-all duration-150">
                Kembali ke Daftar
            </a>

            @if ($pengadaan->isPending())
                <a href="{{ route('pengadaans.edit', $pengadaan->id) }}"
                    class="inline-flex items-center justify-center gap-2 rounded-md bg-zinc-900 text-zinc-50 hover:bg-zinc-800 h-10 px-4 py-2 text-sm font-medium shadow-sm transition-all duration-150">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.83 20.013a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                    </svg>
                    Edit Usulan
                </a>

                <form id="del-show-{{ $pengadaan->id }}"
                    action="{{ route('pengadaans.destroy', $pengadaan->id) }}"
                    method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="button"
                        onclick="confirmDeleteShow('{{ $pengadaan->id }}', '{{ addslashes($pengadaan->nama_barang_usulan) }}')"
                        class="inline-flex items-center justify-center gap-2 rounded-md border border-red-200 text-red-600 hover:text-white hover:bg-red-600 h-10 px-4 py-2 text-sm font-medium shadow-sm transition-all duration-150 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                        </svg>
                        Hapus Usulan
                    </button>
                </form>
            @endif

            {{-- Tombol Approve/Tolak — hanya Super Admin & status pending --}}
            @if (auth()->user()?->role?->slug === 'super-admin' && $pengadaan->isPending())
                <div class="flex items-center gap-2 ml-auto">
                    <span class="text-xs text-zinc-400 hidden sm:block">Tindakan Admin:</span>

                    {{-- Setujui --}}
                    <form id="approve-{{ $pengadaan->id }}"
                        action="{{ route('approvals.approve', $pengadaan->id) }}"
                        method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="button"
                            onclick="confirmApprove('{{ $pengadaan->id }}')"
                            class="inline-flex items-center justify-center gap-2 rounded-md bg-green-600 text-white hover:bg-green-700 h-10 px-4 py-2 text-sm font-medium shadow-sm transition-all duration-150 cursor-pointer">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                            Setujui
                        </button>
                    </form>

                    {{-- Tolak --}}
                    <form id="tolak-{{ $pengadaan->id }}"
                        action="{{ route('approvals.tolak', $pengadaan->id) }}"
                        method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="button"
                            onclick="confirmTolak('{{ $pengadaan->id }}')"
                            class="inline-flex items-center justify-center gap-2 rounded-md bg-red-600 text-white hover:bg-red-700 h-10 px-4 py-2 text-sm font-medium shadow-sm transition-all duration-150 cursor-pointer">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                            Tolak
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    function confirmDeleteShow(id, nama) {
        Swal.fire({
            title: 'Hapus Usulan?',
            html: `Anda akan menghapus usulan <strong>"${nama}"</strong>.<br>
                   <span class="text-sm text-gray-500">Tindakan ini tidak dapat dibatalkan.</span>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            focusCancel: true,
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('del-show-' + id).submit();
            }
        });
    }

    function confirmApprove(id) {
        Swal.fire({
            title: 'Setujui Usulan?',
            html: `Yakin ingin <strong>menyetujui</strong> usulan ini?<br>
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
                document.getElementById('approve-' + id).submit();
            }
        });
    }

    function confirmTolak(id) {
        Swal.fire({
            title: 'Tolak Usulan?',
            html: `Yakin ingin <strong>menolak</strong> usulan ini?<br>
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
                document.getElementById('tolak-' + id).submit();
            }
        });
    }
</script>
@endsection
