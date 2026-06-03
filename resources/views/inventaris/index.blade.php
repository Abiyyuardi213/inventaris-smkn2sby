@extends('layouts.app')

@section('title', 'Daftar Inventaris - Inventaris SMKN 2 SBY')
@section('page_title', 'Inventaris Barang')

@section('content')
<div class="space-y-6">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-1.5 text-sm text-zinc-500">
        <a href="{{ route('dashboard') }}" class="hover:text-zinc-900 transition-colors">Dashboard</a>
        <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
        </svg>
        <span class="font-medium text-zinc-900">Inventaris Barang</span>
    </nav>

    {{-- Header Section --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-zinc-900">Daftar Inventaris</h2>
            <p class="text-sm text-zinc-500">Kelola dan pantau seluruh aset sarana prasarana sekolah.</p>
        </div>
        <div>
            <a href="{{ route('inventaris.create') }}"
                class="inline-flex items-center justify-center gap-2 rounded-md bg-zinc-900 text-zinc-50 hover:bg-zinc-800 px-4 py-2 text-sm font-medium shadow-sm transition-all duration-150 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-950 cursor-pointer">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Tambah Inventaris
            </a>
        </div>
    </div>

    {{-- Filters Card --}}
    <div class="rounded-lg border border-zinc-200 bg-white p-5 shadow-sm">
        <form method="GET" action="{{ route('inventaris.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
            {{-- Kategori --}}
            <div class="space-y-1.5">
                <label for="kategori_id" class="text-xs font-semibold text-zinc-500 uppercase tracking-wider">Kategori</label>
                <select id="kategori_id" name="kategori_id" class="flex h-9 w-full rounded-md border border-zinc-200 bg-transparent px-3 py-1 text-xs text-zinc-900 focus:outline-none focus:ring-1 focus:ring-zinc-950" onchange="this.form.submit()">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->id }}" {{ request('kategori_id') == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Unit Kerja --}}
            <div class="space-y-1.5">
                <label for="jurusan_id" class="text-xs font-semibold text-zinc-500 uppercase tracking-wider">Unit Kerja</label>
                <select id="jurusan_id" name="jurusan_id" class="flex h-9 w-full rounded-md border border-zinc-200 bg-transparent px-3 py-1 text-xs text-zinc-900 focus:outline-none focus:ring-1 focus:ring-zinc-950" onchange="this.form.submit()">
                    <option value="">Semua Unit Kerja</option>
                    @foreach($jurusans as $jurusan)
                        <option value="{{ $jurusan->id }}" {{ request('jurusan_id') == $jurusan->id ? 'selected' : '' }}>
                            {{ $jurusan->nama_jurusan }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Ruangan --}}
            <div class="space-y-1.5">
                <label for="ruangan_id" class="text-xs font-semibold text-zinc-500 uppercase tracking-wider">Ruangan</label>
                <select id="ruangan_id" name="ruangan_id" class="flex h-9 w-full rounded-md border border-zinc-200 bg-transparent px-3 py-1 text-xs text-zinc-900 focus:outline-none focus:ring-1 focus:ring-zinc-950" onchange="this.form.submit()">
                    <option value="">Semua Ruangan</option>
                    @foreach($ruangans as $ruangan)
                        <option value="{{ $ruangan->id }}" {{ request('ruangan_id') == $ruangan->id ? 'selected' : '' }}>
                            {{ $ruangan->nama_ruangan }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Kondisi --}}
            <div class="space-y-1.5">
                <label for="kondisi" class="text-xs font-semibold text-zinc-500 uppercase tracking-wider">Kondisi</label>
                <select id="kondisi" name="kondisi" class="flex h-9 w-full rounded-md border border-zinc-200 bg-transparent px-3 py-1 text-xs text-zinc-900 focus:outline-none focus:ring-1 focus:ring-zinc-950" onchange="this.form.submit()">
                    <option value="">Semua Kondisi</option>
                    <option value="baik" {{ request('kondisi') == 'baik' ? 'selected' : '' }}>Baik</option>
                    <option value="layak" {{ request('kondisi') == 'layak' ? 'selected' : '' }}>Layak Pakai</option>
                    <option value="rusak" {{ request('kondisi') == 'rusak' ? 'selected' : '' }}>Rusak</option>
                </select>
            </div>

            {{-- Reset Filters --}}
            <div class="flex items-end">
                <a href="{{ route('inventaris.index') }}" class="flex h-9 items-center justify-center w-full rounded-md border border-zinc-200 text-xs font-medium text-zinc-700 bg-white hover:bg-zinc-50 transition-colors shadow-sm gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                    </svg>
                    Reset Filter
                </a>
            </div>
        </form>
    </div>

    {{-- Table Card --}}
    <div class="rounded-lg border border-zinc-200 bg-white shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs uppercase bg-zinc-50 text-zinc-500 border-b border-zinc-200">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-semibold w-12">No</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Kode</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Nama Barang</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Kategori</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Lokasi</th>
                        <th scope="col" class="px-6 py-4 font-semibold text-center">Qty</th>
                        <th scope="col" class="px-6 py-4 font-semibold text-center">Kondisi</th>
                        <th scope="col" class="px-6 py-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    @forelse ($inventaris as $item)
                        <tr class="hover:bg-zinc-50/60 transition-colors {{ $loop->even ? 'bg-zinc-50/30' : 'bg-white' }}">
                            <td class="px-6 py-4 text-zinc-400 font-mono text-xs">
                                {{ $loop->iteration }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center rounded-md bg-zinc-100 px-2.5 py-1 text-xs font-mono font-semibold text-zinc-700 border border-zinc-200/60 tracking-wide">
                                    {{ $item->kode_inventaris }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-medium text-zinc-900">{{ $item->nama_barang }}</div>
                                <div class="text-xs text-zinc-400">{{ $item->merek }}</div>
                            </td>
                            <td class="px-6 py-4 text-zinc-600">
                                {{ $item->kategori->nama_kategori }}
                            </td>
                            <td class="px-6 py-4 text-zinc-600">
                                <div class="font-medium text-xs text-zinc-700">{{ $item->ruangan->nama_ruangan }}</div>
                                <div class="text-[10px] text-zinc-400">{{ $item->jurusan->nama_jurusan }}</div>
                            </td>
                            <td class="px-6 py-4 text-center font-semibold text-zinc-800">
                                {{ $item->jumlah_total }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($item->kondisi === 'baik')
                                    <span class="inline-flex items-center rounded-md bg-emerald-50 px-2 py-1 text-xs font-medium text-emerald-700 border border-emerald-200/50">
                                        Baik
                                    </span>
                                @elseif($item->kondisi === 'layak')
                                    <span class="inline-flex items-center rounded-md bg-amber-50 px-2 py-1 text-xs font-medium text-amber-700 border border-amber-200/50">
                                        Layak
                                    </span>
                                @else
                                    <span class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 border border-red-200/50">
                                        Rusak
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="inline-flex items-center justify-end gap-2">
                                    {{-- Lihat --}}
                                    <a href="{{ route('inventaris.show', $item->id) }}"
                                        class="p-1.5 rounded-md border border-zinc-200 text-zinc-600 hover:text-zinc-950 bg-white hover:bg-zinc-50 transition-colors shadow-sm text-xs font-medium inline-flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        </svg>
                                        Lihat
                                    </a>

                                    {{-- Edit --}}
                                    <a href="{{ route('inventaris.edit', $item->id) }}"
                                        class="p-1.5 rounded-md border border-zinc-200 text-zinc-600 hover:text-zinc-950 bg-white hover:bg-zinc-50 transition-colors shadow-sm text-xs font-medium inline-flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.83 20.013a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                        </svg>
                                        Ubah
                                    </a>

                                    {{-- Hapus dengan SweetAlert2 --}}
                                    <form id="delete-form-{{ $item->id }}"
                                        action="{{ route('inventaris.destroy', $item->id) }}"
                                        method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                            onclick="confirmDelete('{{ $item->id }}', '{{ addslashes($item->nama_barang) }}')"
                                            class="p-1.5 rounded-md border border-red-200 text-red-600 hover:text-white hover:bg-red-600 transition-colors shadow-sm text-xs font-medium inline-flex items-center gap-1 cursor-pointer">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                            </svg>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-16 text-center text-zinc-500">
                                <div class="flex flex-col items-center justify-center gap-3">
                                    <div class="w-14 h-14 rounded-full bg-zinc-100 flex items-center justify-center">
                                        <svg class="w-7 h-7 text-zinc-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-zinc-700">Belum ada data inventaris</p>
                                        <p class="text-xs text-zinc-400 mt-0.5">Klik tombol "Tambah Inventaris" untuk menambahkan aset pertama.</p>
                                    </div>
                                    <a href="{{ route('inventaris.create') }}"
                                        class="mt-1 inline-flex items-center gap-1.5 rounded-md bg-zinc-900 text-zinc-50 hover:bg-zinc-800 px-3 py-1.5 text-xs font-medium transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                        </svg>
                                        Tambah Inventaris
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Table Footer: total count --}}
        @if ($inventaris->isNotEmpty())
            <div class="px-6 py-3 border-t border-zinc-100 bg-zinc-50/50">
                <p class="text-xs text-zinc-400">
                    Menampilkan <span class="font-medium text-zinc-600">{{ $inventaris->count() }}</span> barang terdaftar
                </p>
            </div>
        @endif
    </div>
</div>

<script>
    function confirmDelete(id, nama) {
        Swal.fire({
            title: 'Hapus Barang?',
            html: `Anda akan menghapus data inventaris <strong>"${nama}"</strong>.<br>
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
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>
@endsection
