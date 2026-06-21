@extends('layouts.app')

@section('title', 'Usulan Pengadaan - Inventaris SMKN 2 SBY')
@section('page_title', 'Usulan Pengadaan')

@section('content')
<div class="space-y-6">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-1.5 text-sm text-zinc-500">
        <a href="{{ route('dashboard') }}" class="hover:text-zinc-900 transition-colors">Dashboard</a>
        <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
        </svg>
        <span class="font-medium text-zinc-900">Usulan Pengadaan</span>
    </nav>

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-zinc-900">Daftar Usulan Pengadaan</h2>
            <p class="text-sm text-zinc-500">Kelola seluruh usulan pengadaan aset SMKN 2 Surabaya.</p>
        </div>
        <a href="{{ route('pengadaans.create') }}"
            class="inline-flex items-center justify-center gap-2 rounded-md bg-zinc-900 text-zinc-50 hover:bg-zinc-800 px-4 py-2 text-sm font-medium shadow-sm transition-all duration-150 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-950 cursor-pointer">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Buat Usulan
        </a>
    </div>

    {{-- Filter Status --}}
    <div class="flex items-center gap-2 flex-wrap">
        <span class="text-sm font-medium text-zinc-600 shrink-0">Filter Status:</span>
        @php
            $statusFilter = request('status', '');
            $filterOptions = [
                ''                 => 'Semua',
                'pending'          => 'Pending',
                'disetujui_admin'  => 'Menunggu Kepsek',
                'disetujui_kepsek' => 'Disetujui Final',
                'ditolak'          => 'Ditolak Admin',
                'ditolak_kepsek'   => 'Ditolak Kepsek',
            ];
            $filterColors = [
                ''                 => 'bg-zinc-100 text-zinc-700 border-zinc-200 hover:bg-zinc-200',
                'pending'          => 'bg-amber-50 text-amber-700 border-amber-200 hover:bg-amber-100',
                'disetujui_admin'  => 'bg-blue-50 text-blue-700 border-blue-200 hover:bg-blue-100',
                'disetujui_kepsek' => 'bg-emerald-50 text-emerald-700 border-emerald-200 hover:bg-emerald-100',
                'ditolak'          => 'bg-red-50 text-red-700 border-red-200 hover:bg-red-100',
                'ditolak_kepsek'   => 'bg-red-100 text-red-800 border-red-300 hover:bg-red-200',
            ];
        @endphp
        @foreach ($filterOptions as $value => $label)
            <a href="{{ route('pengadaans.index', $value ? ['status' => $value] : []) }}"
                class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium border transition-colors
                    {{ $statusFilter === $value ? 'bg-blue-600 text-white border-blue-600' : $filterColors[$value] }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    {{-- Table Card --}}
    <div class="rounded-lg border border-zinc-200 bg-white shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs uppercase bg-zinc-50 text-zinc-500 border-b border-zinc-200">
                    <tr>
                        <th scope="col" class="px-4 py-4 font-semibold w-10">No</th>
                        <th scope="col" class="px-4 py-4 font-semibold">Nama Barang</th>
                        <th scope="col" class="px-4 py-4 font-semibold">Jurusan</th>
                        <th scope="col" class="px-4 py-4 font-semibold">Kategori</th>
                        <th scope="col" class="px-4 py-4 font-semibold text-center">Jumlah</th>
                        <th scope="col" class="px-4 py-4 font-semibold">Perkiraan Harga</th>
                        <th scope="col" class="px-4 py-4 font-semibold">Pengusul</th>
                        <th scope="col" class="px-4 py-4 font-semibold text-center">Status</th>
                        <th scope="col" class="px-4 py-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    @forelse ($pengadaans as $pengadaan)
                        <tr class="hover:bg-zinc-50/60 transition-colors {{ $loop->even ? 'bg-zinc-50/30' : 'bg-white' }}">
                            <td class="px-4 py-3.5 text-zinc-400 font-mono text-xs">{{ $loop->iteration }}</td>
                            <td class="px-4 py-3.5">
                                <div class="font-medium text-zinc-900 max-w-[180px] truncate" title="{{ $pengadaan->nama_barang_usulan }}">
                                    {{ $pengadaan->nama_barang_usulan }}
                                </div>
                            </td>
                            <td class="px-4 py-3.5 text-zinc-600 text-xs">{{ $pengadaan->jurusan->nama_jurusan ?? '-' }}</td>
                            <td class="px-4 py-3.5">
                                <span class="inline-flex items-center rounded-md bg-teal-50 px-2 py-0.5 text-xs font-mono font-semibold text-teal-700 border border-teal-200/60">
                                    {{ $pengadaan->kategori->kode_kategori ?? '-' }}
                                </span>
                            </td>
                            <td class="px-4 py-3.5 text-center font-semibold text-zinc-800">{{ $pengadaan->jumlah }}</td>
                            <td class="px-4 py-3.5 text-zinc-700 text-xs whitespace-nowrap">
                                Rp {{ number_format($pengadaan->perkiraan_harga, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-3.5 text-zinc-600 text-xs">{{ $pengadaan->pengusul->nama ?? '-' }}</td>
                            <td class="px-4 py-3.5 text-center">
                                <x-status-pengadaan-badge :status="$pengadaan->status_usulan" />
                            </td>
                            <td class="px-4 py-3.5 text-right">
                                <div class="inline-flex items-center justify-end gap-1.5">
                                    {{-- Lihat (semua user) --}}
                                    <a href="{{ route('pengadaans.show', $pengadaan->id) }}"
                                        class="p-1.5 rounded-md border border-zinc-200 text-zinc-600 hover:text-zinc-950 bg-white hover:bg-zinc-50 transition-colors shadow-sm text-xs font-medium inline-flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        </svg>
                                        Lihat
                                    </a>

                                    {{-- Edit & Hapus — hanya jika pending --}}
                                    @if ($pengadaan->isPending())
                                        <a href="{{ route('pengadaans.edit', $pengadaan->id) }}"
                                            class="p-1.5 rounded-md border border-zinc-200 text-zinc-600 hover:text-zinc-950 bg-white hover:bg-zinc-50 transition-colors shadow-sm text-xs font-medium inline-flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.83 20.013a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                            </svg>
                                            Ubah
                                        </a>

                                        <form id="del-{{ $pengadaan->id }}"
                                            action="{{ route('pengadaans.destroy', $pengadaan->id) }}"
                                            method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                onclick="confirmDelete('{{ $pengadaan->id }}', '{{ addslashes($pengadaan->nama_barang_usulan) }}')"
                                                class="p-1.5 rounded-md border border-red-200 text-red-600 hover:text-white hover:bg-red-600 transition-colors shadow-sm text-xs font-medium inline-flex items-center gap-1 cursor-pointer">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                </svg>
                                                Hapus
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-16 text-center text-zinc-500">
                                <div class="flex flex-col items-center justify-center gap-3">
                                    <div class="w-14 h-14 rounded-full bg-zinc-100 flex items-center justify-center">
                                        <svg class="w-7 h-7 text-zinc-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-zinc-700">Belum ada usulan pengadaan</p>
                                        <p class="text-xs text-zinc-400 mt-0.5">
                                            @if(request('status'))
                                                Tidak ada usulan dengan status "{{ request('status') }}".
                                            @else
                                                Klik "Buat Usulan" untuk membuat usulan pertama.
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($pengadaans->isNotEmpty())
            <div class="px-6 py-3 border-t border-zinc-100 bg-zinc-50/50">
                <p class="text-xs text-zinc-400">
                    Menampilkan <span class="font-medium text-zinc-600">{{ $pengadaans->count() }}</span> usulan
                    @if(request('status')) &mdash; filter: <span class="font-medium">{{ request('status') }}</span> @endif
                </p>
            </div>
        @endif
    </div>
</div>

<script>
    function confirmDelete(id, nama) {
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
                document.getElementById('del-' + id).submit();
            }
        });
    }
</script>
@endsection
