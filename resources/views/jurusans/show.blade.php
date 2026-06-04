@extends('layouts.app')

@section('title', 'Detail Unit Kerja - Inventaris SMKN 2 SBY')
@section('page_title', 'Detail Unit Kerja')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-1.5 text-sm text-zinc-500">
        <a href="{{ route('dashboard') }}" class="hover:text-zinc-900 transition-colors">Dashboard</a>
        <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
        </svg>
        <a href="{{ route('jurusans.index') }}" class="hover:text-zinc-900 transition-colors">Unit Kerja</a>
        <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
        </svg>
        <span class="font-medium text-zinc-900">Detail Unit Kerja</span>
    </nav>

    {{-- Page Heading --}}
    <div>
        <a href="{{ route('jurusans.index') }}"
            class="inline-flex items-center gap-1.5 text-sm text-zinc-500 hover:text-zinc-950 transition-colors mb-2">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
            </svg>
            Kembali ke Daftar Unit Kerja
        </a>
        <h2 class="text-2xl font-bold tracking-tight text-zinc-900">Detail Unit Kerja</h2>
        <p class="text-sm text-zinc-500">Informasi lengkap unit kerja dan ruangan yang terdaftar.</p>
    </div>

    {{-- Info Card --}}
    <div class="rounded-lg border border-zinc-200 bg-white shadow-sm overflow-hidden">
        {{-- Card Header --}}
        <div class="px-6 py-4 border-b border-zinc-100 bg-zinc-50/60 flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-indigo-100 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75Z" />
                </svg>
            </div>
            <div>
                <p class="font-semibold text-zinc-900 text-sm">{{ $jurusan->nama_jurusan }}</p>
                <span class="inline-flex items-center rounded-md bg-indigo-50 px-2 py-0.5 text-xs font-mono font-semibold text-indigo-700 border border-indigo-200/60 tracking-wide">
                    {{ $jurusan->kode_jurusan }}
                </span>
            </div>
        </div>

        {{-- Card Body: Info Grid --}}
        <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider block mb-1">Nama Unit Kerja</span>
                <span class="text-base font-semibold text-zinc-900">{{ $jurusan->nama_jurusan }}</span>
            </div>
            <div>
                <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider block mb-1">Kode Unit Kerja</span>
                <span class="inline-flex items-center rounded-md bg-indigo-50 px-2.5 py-1 text-sm font-mono font-bold text-indigo-700 border border-indigo-200/60 tracking-widest">
                    {{ $jurusan->kode_jurusan }}
                </span>
            </div>
            <div>
                <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider block mb-1">Tanggal Dibuat</span>
                <span class="text-sm text-zinc-700">{{ $jurusan->created_at->format('d F Y, H:i') }} WIB</span>
            </div>
            <div>
                <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider block mb-1">Terakhir Diperbarui</span>
                <span class="text-sm text-zinc-700">{{ $jurusan->updated_at->format('d F Y, H:i') }} WIB</span>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="flex items-center justify-end gap-3 px-6 py-4 border-t border-zinc-100 bg-zinc-50/40">
            <a href="{{ route('jurusans.index') }}"
                class="inline-flex items-center justify-center rounded-md border border-zinc-200 text-zinc-700 hover:text-zinc-950 bg-white hover:bg-zinc-50 h-10 px-4 py-2 text-sm font-medium shadow-sm transition-all duration-150">
                Kembali ke Daftar
            </a>
            <a href="{{ route('jurusans.edit', $jurusan->id) }}"
                class="inline-flex items-center justify-center gap-2 rounded-md bg-zinc-900 text-zinc-50 hover:bg-zinc-800 h-10 px-4 py-2 text-sm font-medium shadow-sm transition-all duration-150">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.83 20.013a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                </svg>
                Edit Unit Kerja
            </a>
        </div>
    </div>

    {{-- Daftar Ruangan --}}
    <div class="rounded-lg border border-zinc-200 bg-white shadow-sm overflow-hidden">
        {{-- Section Header --}}
        <div class="px-6 py-4 border-b border-zinc-100 flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                <svg class="w-4 h-4 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                </svg>
                <h3 class="text-sm font-semibold text-zinc-900">Daftar Ruangan</h3>
            </div>
            <span class="inline-flex items-center justify-center rounded-full bg-zinc-100 px-2.5 py-0.5 text-xs font-semibold text-zinc-600">
                {{ $jurusan->ruangans->count() }} ruangan
            </span>
        </div>

        {{-- Ruangan Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs uppercase bg-zinc-50 text-zinc-500 border-b border-zinc-100">
                    <tr>
                        <th scope="col" class="px-6 py-3 font-semibold w-12">No</th>
                        <th scope="col" class="px-6 py-3 font-semibold w-24">ID</th>
                        <th scope="col" class="px-6 py-3 font-semibold">Nama Ruangan</th>
                        <th scope="col" class="px-6 py-3 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    @forelse ($jurusan->ruangans as $ruangan)
                        <tr class="hover:bg-zinc-50/60 transition-colors {{ $loop->even ? 'bg-zinc-50/30' : 'bg-white' }}">
                            <td class="px-6 py-3.5 text-zinc-400 font-mono text-xs">
                                {{ $loop->iteration }}
                            </td>
                            <td class="px-6 py-3.5">
                                <button onclick="copyToClipboard('{{ $ruangan->id }}', this)"
                                    class="inline-flex items-center gap-1 px-2 py-0.5 rounded bg-zinc-50 hover:bg-zinc-100 border border-zinc-200 hover:border-zinc-300 text-[10px] font-semibold text-zinc-600 hover:text-zinc-900 transition-all shadow-sm cursor-pointer"
                                    title="Salin ID Ruangan">
                                    <svg class="w-3 h-3 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 01-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H5.25m11.9-3.675A2.25 2.25 0 0013.5 2.25h-3a2.25 2.25 0 00-2.25 2.25m9 0V18.75a2.25 2.25 0 01-2.25 2.25h-9a2.25 2.25 0 01-2.25-2.25V4.5m9 0H7.5" />
                                    </svg>
                                    <span>Salin ID</span>
                                </button>
                            </td>
                            <td class="px-6 py-3.5">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-1.5 h-1.5 rounded-full bg-emerald-400 shrink-0"></div>
                                    <span class="font-medium text-zinc-800">{{ $ruangan->nama_ruangan }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-3.5 text-right">
                                <a href="{{ route('ruangans.show', $ruangan->id) }}"
                                    class="p-1.5 rounded-md border border-zinc-200 text-zinc-600 hover:text-zinc-950 bg-white hover:bg-zinc-50 transition-colors shadow-sm text-xs font-medium inline-flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                    Lihat
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-zinc-500">
                                <div class="flex flex-col items-center justify-center gap-3">
                                    <div class="w-12 h-12 rounded-full bg-zinc-100 flex items-center justify-center">
                                        <svg class="w-6 h-6 text-zinc-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-zinc-600 text-sm">Belum ada ruangan</p>
                                        <p class="text-xs text-zinc-400 mt-0.5">Unit kerja ini belum memiliki ruangan terdaftar.</p>
                                    </div>
                                    <a href="{{ route('ruangans.create') }}"
                                        class="inline-flex items-center gap-1.5 rounded-md bg-zinc-900 text-zinc-50 hover:bg-zinc-800 px-3 py-1.5 text-xs font-medium transition-colors">
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
    </div>

</div>

<script>
    function copyToClipboard(text, button) {
        const originalHTML = button.innerHTML;
        const showToast = (icon, title) => {
            if (typeof Toast !== 'undefined') {
                Toast.fire({ icon, title });
                return;
            }

            Swal.fire({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 1500,
                timerProgressBar: true,
                icon,
                title,
            });
        };

        const showSuccessState = () => {
            button.innerHTML = `
                <svg class="w-3 h-3 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                </svg>
                <span class="text-emerald-700">Tersalin!</span>
            `;
            button.classList.add('bg-emerald-50', 'border-emerald-200');
            button.classList.remove('bg-zinc-50', 'border-zinc-200');
            showToast('success', 'ID ruangan berhasil disalin!');

            setTimeout(() => {
                button.innerHTML = originalHTML;
                button.classList.remove('bg-emerald-50', 'border-emerald-200');
                button.classList.add('bg-zinc-50', 'border-zinc-200');
            }, 1500);
        };

        const showErrorState = (error) => {
            console.error('Gagal menyalin text: ', error);
            showToast('error', 'ID ruangan gagal disalin.');
        };

        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(text).then(showSuccessState).catch(showErrorState);
            return;
        }

        try {
            const textarea = document.createElement('textarea');
            textarea.value = text;
            textarea.setAttribute('readonly', '');
            textarea.style.position = 'fixed';
            textarea.style.opacity = '0';
            document.body.appendChild(textarea);
            textarea.select();
            document.execCommand('copy');
            document.body.removeChild(textarea);
            showSuccessState();
        } catch (error) {
            showErrorState(error);
        }
    }
</script>
@endsection
