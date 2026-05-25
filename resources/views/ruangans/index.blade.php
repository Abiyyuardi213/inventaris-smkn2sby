@extends('layouts.app')

@section('title', 'Daftar Ruangan - Inventaris SMKN 2 SBY')
@section('page_title', 'Manajemen Ruangan')

@section('content')
<div class="space-y-6">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-1.5 text-sm text-zinc-500">
        <a href="{{ route('dashboard') }}" class="hover:text-zinc-900 transition-colors">Dashboard</a>
        <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
        </svg>
        <span class="font-medium text-zinc-900">Ruangan</span>
    </nav>

    {{-- Header Section --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-zinc-900">Daftar Ruangan</h2>
            <p class="text-sm text-zinc-500">Kelola data ruangan yang tersedia di SMKN 2 Surabaya.</p>
        </div>
        <div>
            <a href="{{ route('ruangans.create') }}"
                class="inline-flex items-center justify-center gap-2 rounded-md bg-zinc-900 text-zinc-50 hover:bg-zinc-800 px-4 py-2 text-sm font-medium shadow-sm transition-all duration-150 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-950 cursor-pointer">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Tambah Ruangan
            </a>
        </div>
    </div>

    {{-- Filter by Jurusan --}}
    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3">
        <form method="GET" action="{{ route('ruangans.index') }}" class="flex items-center gap-2 w-full sm:w-auto">
            <label for="filter_jurusan" class="text-sm font-medium text-zinc-600 shrink-0">Filter Jurusan:</label>
            <select
                id="filter_jurusan"
                name="jurusan_id"
                onchange="this.form.submit()"
                class="h-9 rounded-md border border-zinc-200 bg-white px-3 pr-8 text-sm text-zinc-700 focus:outline-none focus:ring-2 focus:ring-zinc-950 focus:ring-offset-1 transition-colors cursor-pointer appearance-none"
                style="background-image: url('data:image/svg+xml,%3Csvg xmlns%3D%22http%3A//www.w3.org/2000/svg%22 fill%3D%22none%22 viewBox%3D%220 0 20 20%22%3E%3Cpath stroke%3D%22%236b7280%22 stroke-linecap%3D%22round%22 stroke-linejoin%3D%22round%22 stroke-width%3D%221.5%22 d%3D%22M6 8l4 4 4-4%22/%3E%3C/svg%3E'); background-repeat: no-repeat; background-position: right 0.5rem center; background-size: 1.25em;"
            >
                <option value="">-- Semua Jurusan --</option>
                @foreach ($jurusans as $jurusan)
                    <option value="{{ $jurusan->id }}" {{ request('jurusan_id') == $jurusan->id ? 'selected' : '' }}>
                        {{ $jurusan->nama_jurusan }}
                    </option>
                @endforeach
            </select>
            @if (request('jurusan_id'))
                <a href="{{ route('ruangans.index') }}"
                    class="inline-flex items-center gap-1 text-xs text-zinc-500 hover:text-zinc-900 transition-colors px-2 py-1 rounded-md border border-zinc-200 bg-white hover:bg-zinc-50">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                    Reset
                </a>
            @endif
        </form>
        @if (request('jurusan_id'))
            <span class="text-xs text-emerald-700 bg-emerald-50 border border-emerald-200/60 px-2.5 py-1 rounded-full font-medium">
                Difilter: {{ $jurusans->find(request('jurusan_id'))?->nama_jurusan ?? '-' }}
            </span>
        @endif
    </div>

    {{-- Table Card --}}
    <div class="rounded-lg border border-zinc-200 bg-white shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs uppercase bg-zinc-50 text-zinc-500 border-b border-zinc-200">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-semibold w-12">No</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Nama Ruangan</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Jurusan</th>
                        <th scope="col" class="px-6 py-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    @forelse ($ruangans as $ruangan)
                        <tr class="hover:bg-zinc-50/60 transition-colors {{ $loop->even ? 'bg-zinc-50/30' : 'bg-white' }}">
                            <td class="px-6 py-4 text-zinc-400 font-mono text-xs">
                                {{ $loop->iteration }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-medium text-zinc-900">{{ $ruangan->nama_ruangan }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center rounded-md bg-violet-50 px-2.5 py-1 text-xs font-semibold text-violet-700 border border-violet-200/60">
                                    {{ $ruangan->jurusan->nama_jurusan ?? '-' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="inline-flex items-center justify-end gap-2">
                                    {{-- Lihat --}}
                                    <a href="{{ route('ruangans.show', $ruangan->id) }}"
                                        class="p-1.5 rounded-md border border-zinc-200 text-zinc-600 hover:text-zinc-950 bg-white hover:bg-zinc-50 transition-colors shadow-sm text-xs font-medium inline-flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        </svg>
                                        Lihat
                                    </a>

                                    {{-- Edit --}}
                                    <a href="{{ route('ruangans.edit', $ruangan->id) }}"
                                        class="p-1.5 rounded-md border border-zinc-200 text-zinc-600 hover:text-zinc-950 bg-white hover:bg-zinc-50 transition-colors shadow-sm text-xs font-medium inline-flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.83 20.013a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                        </svg>
                                        Ubah
                                    </a>

                                    {{-- Hapus --}}
                                    <form id="delete-form-{{ $ruangan->id }}"
                                        action="{{ route('ruangans.destroy', $ruangan->id) }}"
                                        method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                            onclick="confirmDelete('{{ $ruangan->id }}', '{{ addslashes($ruangan->nama_ruangan) }}')"
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
                            <td colspan="4" class="px-6 py-16 text-center text-zinc-500">
                                <div class="flex flex-col items-center justify-center gap-3">
                                    <div class="w-14 h-14 rounded-full bg-zinc-100 flex items-center justify-center">
                                        <svg class="w-7 h-7 text-zinc-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-zinc-700">Belum ada data ruangan</p>
                                        <p class="text-xs text-zinc-400 mt-0.5">
                                            @if (request('jurusan_id'))
                                                Tidak ada ruangan untuk jurusan yang dipilih.
                                            @else
                                                Klik tombol "Tambah Ruangan" untuk menambahkan data pertama.
                                            @endif
                                        </p>
                                    </div>
                                    <a href="{{ route('ruangans.create') }}"
                                        class="mt-1 inline-flex items-center gap-1.5 rounded-md bg-zinc-900 text-zinc-50 hover:bg-zinc-800 px-3 py-1.5 text-xs font-medium transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                        </svg>
                                        Tambah Ruangan
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Table Footer --}}
        @if ($ruangans->isNotEmpty())
            <div class="px-6 py-3 border-t border-zinc-100 bg-zinc-50/50">
                <p class="text-xs text-zinc-400">
                    Menampilkan <span class="font-medium text-zinc-600">{{ $ruangans->count() }}</span> ruangan
                    @if (request('jurusan_id'))
                        &mdash; difilter berdasarkan jurusan
                    @endif
                </p>
            </div>
        @endif
    </div>
</div>

<script>
    function confirmDelete(id, nama) {
        Swal.fire({
            title: 'Hapus Ruangan?',
            html: `Anda akan menghapus ruangan <strong>"${nama}"</strong>.<br>
                   <span class="text-sm text-gray-500">Ruangan yang masih memiliki data inventaris tidak dapat dihapus.</span>`,
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
