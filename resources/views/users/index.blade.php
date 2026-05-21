@extends('layouts.app')

@section('title', 'Daftar Pengguna - Inventaris SMKN 2 SBY')
@section('page_title', 'Manajemen Pengguna')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-zinc-900">Daftar Pengguna</h2>
            <p class="text-sm text-zinc-500">Kelola pengguna sistem dan pasangkan peran hak akses untuk menentukan kewenangan mereka.</p>
        </div>
        <div>
            <a href="{{ route('users.create') }}" class="inline-flex items-center justify-center gap-2 rounded-md bg-zinc-900 text-zinc-50 hover:bg-zinc-800 px-4 py-2 text-sm font-medium shadow-sm transition-all duration-150 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-950 cursor-pointer">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Tambah Pengguna Baru
            </a>
        </div>
    </div>

    <!-- Table Card Container -->
    <div class="rounded-lg border border-zinc-200 bg-white shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs uppercase bg-zinc-50 text-zinc-500 border-b border-zinc-200">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-semibold w-20">ID</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Nama</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Email</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Peran</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Tanggal Dibuat</th>
                        <th scope="col" class="px-6 py-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200">
                    @forelse ($users as $user)
                        <tr class="hover:bg-zinc-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <button 
                                    onclick="copyToClipboard('{{ $user->id }}', this)" 
                                    class="inline-flex items-center justify-center p-2 rounded-md border border-zinc-200 text-zinc-500 hover:text-zinc-900 hover:bg-zinc-50 bg-white transition-all duration-150 shadow-sm cursor-pointer"
                                    title="Salin ID"
                                >
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect width="14" height="14" x="8" y="8" rx="2" ry="2"/>
                                        <path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"/>
                                    </svg>
                                </button>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-medium text-zinc-900">{{ $user->nama }}</div>
                            </td>
                            <td class="px-6 py-4 text-zinc-600">
                                {{ $user->email }}
                            </td>
                            <td class="px-6 py-4">
                                @if($user->role)
                                    <span class="inline-flex items-center rounded-md bg-zinc-100 px-2.5 py-0.5 text-xs font-medium text-zinc-800 border border-zinc-200/50">
                                        {{ $user->role->nama_role }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center rounded-md bg-red-50 px-2.5 py-0.5 text-xs font-medium text-red-700 border border-red-200/50">
                                        Tidak Ada Peran
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-zinc-500">
                                {{ $user->created_at->format('d M Y, H:i') }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="inline-flex items-center justify-end gap-2">
                                    <a href="{{ route('users.show', $user->id) }}" class="p-1.5 rounded-md border border-zinc-200 text-zinc-700 hover:text-zinc-950 bg-white hover:bg-zinc-50 transition-colors shadow-sm text-xs font-medium inline-flex items-center gap-1">
                                        Detail
                                    </a>

                                    <a href="{{ route('users.edit', $user->id) }}" class="p-1.5 rounded-md border border-zinc-200 text-zinc-700 hover:text-zinc-950 bg-white hover:bg-zinc-50 transition-colors shadow-sm text-xs font-medium inline-flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.83 20.013a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                        </svg>
                                        Ubah
                                    </a>

                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-md border border-red-200 text-red-600 hover:text-white hover:bg-red-600 transition-colors shadow-sm text-xs font-medium inline-flex items-center gap-1 cursor-pointer">
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
                            <td colspan="6" class="px-6 py-12 text-center text-zinc-500">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <svg class="w-8 h-8 text-zinc-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                    </svg>
                                    <span class="font-medium">Belum ada data pengguna</span>
                                    <span class="text-xs">Klik tombol di atas untuk menambahkan pengguna baru.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function copyToClipboard(text, button) {
    const copyIcon = `
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect width="14" height="14" x="8" y="8" rx="2" ry="2"/>
            <path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"/>
        </svg>
    `;
    const checkIcon = `
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M20 6 9 17l-5-5"/>
        </svg>
    `;
    
    navigator.clipboard.writeText(text).then(() => {
        // Show success state
        button.innerHTML = checkIcon;
        button.classList.remove('border-zinc-200', 'text-zinc-500', 'hover:bg-zinc-50', 'bg-white');
        button.classList.add('border-emerald-200', 'bg-emerald-50', 'text-emerald-600');
        button.title = "Tersalin!";
        
        // Reset to original state after 1.5 seconds
        setTimeout(() => {
            button.innerHTML = copyIcon;
            button.classList.remove('border-emerald-200', 'bg-emerald-50', 'text-emerald-600');
            button.classList.add('border-zinc-200', 'text-zinc-500', 'hover:bg-zinc-50', 'bg-white');
            button.title = "Salin ID";
        }, 1500);
    }).catch(err => {
        console.error('Gagal menyalin teks: ', err);
    });
}
</script>
@endsection
