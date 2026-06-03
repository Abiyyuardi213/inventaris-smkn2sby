@extends('layouts.app')

@section('title', 'Daftar Unit Kerja - Inventaris SMKN 2 SBY')
@section('page_title', 'Manajemen Unit Kerja')

@section('content')
<div class="space-y-6">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-1.5 text-sm text-zinc-500">
        <a href="{{ route('dashboard') }}" class="hover:text-zinc-900 transition-colors">Dashboard</a>
        <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
        </svg>
        <span class="font-medium text-zinc-900">Unit Kerja</span>
    </nav>

    {{-- Header Section --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-zinc-900">Daftar Unit Kerja</h2>
            <p class="text-sm text-zinc-500">Kelola data unit kerja yang tersedia di SMKN 2 Surabaya.</p>
        </div>
        <div>
            <a href="{{ route('jurusans.create') }}"
                class="inline-flex items-center justify-center gap-2 rounded-md bg-zinc-900 text-zinc-50 hover:bg-zinc-800 px-4 py-2 text-sm font-medium shadow-sm transition-all duration-150 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-950 cursor-pointer">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Tambah Unit Kerja
            </a>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="rounded-lg border border-zinc-200 bg-white shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs uppercase bg-zinc-50 text-zinc-500 border-b border-zinc-200">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-semibold w-12">No</th>
                        <th scope="col" class="px-6 py-4 font-semibold w-24">ID</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Kode Unit Kerja</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Nama Unit Kerja</th>
                        <th scope="col" class="px-6 py-4 font-semibold text-center">Jumlah Ruangan</th>
                        <th scope="col" class="px-6 py-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    @forelse ($jurusans as $jurusan)
                        <tr class="hover:bg-zinc-50/60 transition-colors {{ $loop->even ? 'bg-zinc-50/30' : 'bg-white' }}">
                            <td class="px-6 py-4 text-zinc-400 font-mono text-xs">
                                {{ ($jurusans->currentPage() - 1) * $jurusans->perPage() + $loop->iteration }}
                            </td>
                            <td class="px-6 py-4">
                                <button onclick="copyToClipboard('{{ $jurusan->id }}', this)" 
                                    class="inline-flex items-center gap-1 px-2 py-0.5 rounded bg-zinc-50 hover:bg-zinc-100 border border-zinc-200 hover:border-zinc-300 text-[10px] font-semibold text-zinc-600 hover:text-zinc-900 transition-all shadow-sm cursor-pointer"
                                    title="Salin ID Unit Kerja">
                                    <svg class="w-3 h-3 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 01-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H5.25m11.9-3.675A2.25 2.25 0 0013.5 2.25h-3a2.25 2.25 0 00-2.25 2.25m9 0V18.75a2.25 2.25 0 01-2.25 2.25h-9a2.25 2.25 0 01-2.25-2.25V4.5m9 0H7.5" />
                                    </svg>
                                    <span>Salin ID</span>
                                </button>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center rounded-md bg-indigo-50 px-2.5 py-1 text-xs font-mono font-semibold text-indigo-700 border border-indigo-200/60 tracking-wide">
                                    {{ $jurusan->kode_jurusan }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-medium text-zinc-900">{{ $jurusan->nama_jurusan }}</div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full text-xs font-semibold
                                    {{ $jurusan->ruangans_count > 0 ? 'bg-emerald-100 text-emerald-700' : 'bg-zinc-100 text-zinc-400' }}">
                                    {{ $jurusan->ruangans_count }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="inline-flex items-center justify-end gap-2">
                                    {{-- Lihat --}}
                                    <a href="{{ route('jurusans.show', $jurusan->id) }}"
                                        class="p-1.5 rounded-md border border-zinc-200 text-zinc-600 hover:text-zinc-950 bg-white hover:bg-zinc-50 transition-colors shadow-sm text-xs font-medium inline-flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        </svg>
                                        Lihat
                                    </a>

                                    {{-- Edit --}}
                                    <a href="{{ route('jurusans.edit', $jurusan->id) }}"
                                        class="p-1.5 rounded-md border border-zinc-200 text-zinc-600 hover:text-zinc-950 bg-white hover:bg-zinc-50 transition-colors shadow-sm text-xs font-medium inline-flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.83 20.013a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                        </svg>
                                        Ubah
                                    </a>

                                    {{-- Hapus dengan SweetAlert2 --}}
                                    <form id="delete-form-{{ $jurusan->id }}"
                                        action="{{ route('jurusans.destroy', $jurusan->id) }}"
                                        method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                            onclick="confirmDelete('{{ $jurusan->id }}', '{{ addslashes($jurusan->nama_jurusan) }}')"
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
                            <td colspan="6" class="px-6 py-16 text-center text-zinc-500">
                                <div class="flex flex-col items-center justify-center gap-3">
                                    <div class="w-14 h-14 rounded-full bg-zinc-100 flex items-center justify-center">
                                        <svg class="w-7 h-7 text-zinc-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75Z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-zinc-700">Belum ada data unit kerja</p>
                                        <p class="text-xs text-zinc-400 mt-0.5">Klik tombol "Tambah Unit Kerja" untuk menambahkan data pertama.</p>
                                    </div>
                                    <a href="{{ route('jurusans.create') }}"
                                        class="mt-1 inline-flex items-center gap-1.5 rounded-md bg-zinc-900 text-zinc-50 hover:bg-zinc-800 px-3 py-1.5 text-xs font-medium transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                        </svg>
                                        Tambah Unit Kerja
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Table Footer: total count & pagination --}}
        @if ($jurusans->isNotEmpty())
            <div class="px-6 py-4 border-t border-zinc-100 bg-zinc-50/50 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <p class="text-xs text-zinc-400">
                    Menampilkan <span class="font-medium text-zinc-600">{{ $jurusans->firstItem() }}</span> sampai <span class="font-medium text-zinc-600">{{ $jurusans->lastItem() }}</span> dari <span class="font-medium text-zinc-600">{{ $jurusans->total() }}</span> unit kerja
                </p>
                <div class="shrink-0 pagination-sm">
                    {{ $jurusans->links() }}
                </div>
            </div>
        @endif
    </div>
</div>

<script>
    function confirmDelete(id, nama) {
        Swal.fire({
            title: 'Hapus Unit Kerja?',
            html: `Anda akan menghapus unit kerja <strong>"${nama}"</strong>.<br>
                   <span class="text-sm text-gray-500">Unit kerja yang masih memiliki ruangan tidak dapat dihapus.</span>`,
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

    function copyToClipboard(text, button) {
        navigator.clipboard.writeText(text).then(() => {
            // Ubah icon sementara menjadi checkmark dan text "Tersalin!"
            const originalHTML = button.innerHTML;
            button.innerHTML = `
                <svg class="w-3 h-3 text-emerald-600 animate-scale-up" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                </svg>
                <span class="text-emerald-700">Tersalin!</span>
            `;
            button.classList.add('bg-emerald-50', 'border-emerald-200');
            button.classList.remove('bg-zinc-50', 'border-zinc-200');
            
            // Tampilkan Toast SweetAlert2
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 1500,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            Toast.fire({
                icon: 'success',
                title: 'ID berhasil disalin!'
            });

            setTimeout(() => {
                button.innerHTML = originalHTML;
                button.classList.remove('bg-emerald-50', 'border-emerald-200');
                button.classList.add('bg-zinc-50', 'border-zinc-200');
            }, 1500);
        }).catch(err => {
            console.error('Gagal menyalin text: ', err);
        });
    }
</script>
@endsection
