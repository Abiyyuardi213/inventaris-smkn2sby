@extends('layouts.app')

@section('title', 'Detail Usulan Pengadaan - Inventaris SMKN 2 SBY')
@section('page_title', 'Detail Usulan Pengadaan')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-1.5 text-sm text-zinc-500">
        <a href="{{ route('dashboard') }}" class="hover:text-zinc-900 transition-colors font-sans">Dashboard</a>
        <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
        </svg>
        <a href="{{ route('pengadaans.index') }}" class="hover:text-zinc-900 transition-colors font-sans">Usulan Pengadaan</a>
        <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
        </svg>
        <span class="font-medium text-zinc-900 font-sans">Detail Usulan</span>
    </nav>

    {{-- Page Heading --}}
    <div>
        <a href="{{ route('pengadaans.index') }}"
            class="inline-flex items-center gap-1.5 text-sm text-zinc-500 hover:text-zinc-950 transition-colors mb-2 font-sans">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
            </svg>
            Kembali ke Daftar Usulan
        </a>
        <h2 class="text-2xl font-bold tracking-tight text-zinc-900 font-sans">Detail Usulan Pengadaan</h2>
        <p class="text-sm text-zinc-500 font-sans">Informasi lengkap rincian usulan pengadaan barang/aset.</p>
    </div>

    {{-- Audit Trail / Riwayat Keputusan --}}
    @if ($pengadaan->approved_by_admin_at || $pengadaan->approved_by_kepsek_at)
        <div class="rounded-lg border border-zinc-200 bg-white p-5 shadow-sm space-y-3">
            <h3 class="text-xs font-bold text-zinc-400 uppercase tracking-wider font-sans">Audit Trail / Riwayat Keputusan</h3>
            
            @if ($pengadaan->approved_by_admin_at)
                <div class="flex items-center gap-2 text-sm text-zinc-700 font-sans">
                    <svg class="w-4 h-4 text-green-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <span>
                        <strong>Disetujui Super Admin:</strong> {{ $pengadaan->approvedByAdmin->nama }} pada {{ $pengadaan->approved_by_admin_at->format('d M Y, H:i') }} WIB
                    </span>
                </div>
            @endif

            @if ($pengadaan->approved_by_kepsek_at)
                <div class="flex items-start gap-2 text-sm text-zinc-700 font-sans">
                    @if ($pengadaan->isDisetujuiKepsek())
                        <svg class="w-4.5 h-4.5 text-green-600 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        <span>
                            <strong>Disetujui Final oleh Kepala Sekolah:</strong> {{ $pengadaan->approvedByKepsek->nama }} pada {{ $pengadaan->approved_by_kepsek_at->format('d M Y, H:i') }} WIB
                        </span>
                    @else
                        <svg class="w-4.5 h-4.5 text-red-600 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        <span>
                            <strong>Ditolak oleh Kepala Sekolah:</strong> {{ $pengadaan->approvedByKepsek->nama }} pada {{ $pengadaan->approved_by_kepsek_at->format('d M Y, H:i') }} WIB
                        </span>
                    @endif
                </div>

                @if ($pengadaan->catatan_kepsek)
                    <div class="ml-6 mt-1 rounded-md bg-zinc-50 border border-zinc-150 p-3 text-xs text-zinc-600 font-mono whitespace-pre-line leading-relaxed">
                        <span class="font-bold block text-zinc-500 uppercase tracking-wide text-[9px] mb-1">Catatan Kepala Sekolah:</span>
                        {{ $pengadaan->catatan_kepsek }}
                    </div>
                @endif
            @endif
        </div>
    @endif

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
                    <p class="font-semibold text-zinc-900 text-sm font-sans">{{ $pengadaan->nama_barang_usulan }}</p>
                    <p class="text-xs text-zinc-500 font-sans">Diusulkan oleh {{ $pengadaan->pengusul->nama ?? '-' }}</p>
                </div>
            </div>
            {{-- Status Badge --}}
            <x-status-pengadaan-badge :status="$pengadaan->status_usulan" />
        </div>

        {{-- Info Grid --}}
        <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-5">
            <div>
                <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider block mb-1 font-sans">Nama Barang Usulan</span>
                <span class="text-sm font-semibold text-zinc-900 font-sans">{{ $pengadaan->nama_barang_usulan }}</span>
            </div>

            <div>
                <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider block mb-1 font-sans">Kategori</span>
                @if ($pengadaan->kategori)
                    <div class="flex items-center gap-2">
                        <span class="text-sm text-zinc-800 font-sans">{{ $pengadaan->kategori->nama_kategori }}</span>
                        <span class="inline-flex items-center rounded bg-teal-50 px-1.5 py-0.5 text-xs font-mono font-semibold text-teal-700 border border-teal-200/60">
                            {{ $pengadaan->kategori->kode_kategori }}
                        </span>
                    </div>
                @else
                    <span class="text-sm text-zinc-400 italic font-sans">Tidak ada</span>
                @endif
            </div>

            <div>
                <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider block mb-1 font-sans">Jurusan / Program Keahlian</span>
                <span class="text-sm text-zinc-800 font-sans">{{ $pengadaan->jurusan->nama_jurusan ?? '-' }}</span>
            </div>

            <div>
                <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider block mb-1 font-sans">Jumlah</span>
                <span class="text-sm font-semibold text-zinc-900 font-sans">{{ $pengadaan->jumlah }} <span class="font-normal text-zinc-500 text-xs">unit</span></span>
            </div>

            <div>
                <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider block mb-1 font-sans">Perkiraan Harga</span>
                <span class="text-sm font-semibold text-zinc-900 font-sans">Rp {{ number_format($pengadaan->perkiraan_harga, 0, ',', '.') }}</span>
            </div>

            <div>
                <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider block mb-1 font-sans">Diusulkan Oleh</span>
                <span class="text-sm text-zinc-800 font-sans">{{ $pengadaan->pengusul->nama ?? '-' }}</span>
            </div>

            <div>
                <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider block mb-1 font-sans">Tanggal Dibuat</span>
                <span class="text-sm text-zinc-700 font-sans">{{ $pengadaan->created_at->format('d F Y, H:i') }} WIB</span>
            </div>

            <div>
                <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider block mb-1 font-sans">Terakhir Diperbarui</span>
                <span class="text-sm text-zinc-700 font-sans">{{ $pengadaan->updated_at->format('d F Y, H:i') }} WIB</span>
            </div>

            {{-- Alasan Pengadaan — full width --}}
            <div class="sm:col-span-2">
                <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider block mb-1 font-sans">Alasan Pengadaan</span>
                <p class="text-sm text-zinc-800 leading-relaxed whitespace-pre-line bg-zinc-50 rounded-md p-3 border border-zinc-100 font-sans">{{ $pengadaan->alasan_pengadaan }}</p>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="flex flex-wrap items-center gap-3 px-6 py-4 border-t border-zinc-100 bg-zinc-50/40">
            <a href="{{ route('pengadaans.index') }}"
                class="inline-flex items-center justify-center rounded-md border border-zinc-200 text-zinc-700 hover:text-zinc-950 bg-white hover:bg-zinc-50 h-10 px-4 py-2 text-sm font-medium shadow-sm transition-all duration-150 font-sans">
                Kembali ke Daftar
            </a>

            @if ($pengadaan->isPending())
                <a href="{{ route('pengadaans.edit', $pengadaan->id) }}"
                    class="inline-flex items-center justify-center gap-2 rounded-md bg-zinc-900 text-zinc-50 hover:bg-zinc-800 h-10 px-4 py-2 text-sm font-medium shadow-sm transition-all duration-150 font-sans">
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
                        class="inline-flex items-center justify-center gap-2 rounded-md border border-red-200 text-red-600 hover:text-white hover:bg-red-600 h-10 px-4 py-2 text-sm font-medium shadow-sm transition-all duration-150 cursor-pointer font-sans">
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
                    <span class="text-xs text-zinc-400 hidden sm:block font-sans">Tindakan Admin:</span>

                    {{-- Setujui --}}
                    <form id="approve-{{ $pengadaan->id }}"
                        action="{{ route('approvals.approve', $pengadaan->id) }}"
                        method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="button"
                            onclick="confirmApprove('{{ $pengadaan->id }}')"
                            class="inline-flex items-center justify-center gap-2 rounded-md bg-green-600 text-white hover:bg-green-700 h-10 px-4 py-2 text-sm font-medium shadow-sm transition-all duration-150 cursor-pointer font-sans">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                            Setujui & Teruskan
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
                            class="inline-flex items-center justify-center gap-2 rounded-md bg-red-600 text-white hover:bg-red-700 h-10 px-4 py-2 text-sm font-medium shadow-sm transition-all duration-150 cursor-pointer font-sans">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                            Tolak
                        </button>
                    </form>
                </div>
            @endif

            {{-- Tombol Approve/Tolak — hanya Kepala Sekolah & status menunggu_kepsek (disetujui_admin) --}}
            @if (auth()->user()?->role?->slug === 'kepala-sekolah' && $pengadaan->isMenungguKepsek())
                <div class="flex items-center gap-2 ml-auto">
                    <span class="text-xs text-zinc-400 hidden sm:block font-sans">Tindakan Kepsek:</span>

                    {{-- Setujui Final --}}
                    <form id="approve-kepsek-{{ $pengadaan->id }}"
                        action="{{ route('approvals-kepsek.approve', $pengadaan->id) }}"
                        method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="catatan_kepsek" id="catatan-kepsek-approve-input-{{ $pengadaan->id }}" value="">
                        <button type="button"
                            onclick="confirmApproveKepsek('{{ $pengadaan->id }}', '{{ addslashes($pengadaan->nama_barang_usulan) }}')"
                            class="inline-flex items-center justify-center gap-2 rounded-md bg-green-600 text-white hover:bg-green-700 h-10 px-4 py-2 text-sm font-medium shadow-sm transition-all duration-150 cursor-pointer font-sans">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                            Setujui Final
                        </button>
                    </form>

                    {{-- Tolak Kepsek --}}
                    <form id="tolak-kepsek-form-{{ $pengadaan->id }}"
                        action="{{ route('approvals-kepsek.tolak', $pengadaan->id) }}"
                        method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="catatan_kepsek" id="catatan-kepsek-input-{{ $pengadaan->id }}" value="">
                        <button type="button"
                            onclick="confirmTolakKepsek('{{ $pengadaan->id }}', '{{ addslashes($pengadaan->nama_barang_usulan) }}')"
                            class="inline-flex items-center justify-center gap-2 rounded-md bg-red-600 text-white hover:bg-red-700 h-10 px-4 py-2 text-sm font-medium shadow-sm transition-all duration-150 cursor-pointer font-sans">
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
            html: `Usulan ini akan diteruskan ke Kepala Sekolah untuk persetujuan final. Lanjutkan?`,
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

    function confirmApproveKepsek(id, nama) {
        Swal.fire({
            title: 'Setujui Usulan Final?',
            html: `
                <div class="text-left font-sans text-sm space-y-3">
                    <p>Masukkan catatan persetujuan Kepala Sekolah untuk usulan: <strong>"${nama}"</strong></p>
                    <div class="space-y-2">
                        <label class="block text-xs font-semibold text-zinc-500 uppercase tracking-wider">Pilih Template Catatan:</label>
                        <select id="swal-template-select" class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 cursor-pointer">
                            <option value="">-- Catatan Kustom / Kosong --</option>
                            <option value="Disetujui, silakan koordinasikan dengan bendahara sarpras untuk realisasi pembelian.">Persetujuan Realisasi Pembelian</option>
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label class="block text-xs font-semibold text-zinc-500 uppercase tracking-wider">Isi Catatan / Instruksi:</label>
                        <textarea id="swal-catatan-textarea" rows="3" class="w-full rounded-md border border-zinc-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Tulis catatan persetujuan di sini..."></textarea>
                    </div>
                </div>
            `,
            showCancelButton: true,
            confirmButtonColor: '#16a34a',
            cancelButtonColor: '#6b7280',
            confirmButtonText: '✓ Ya, Setujui',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            focusCancel: true,
            didOpen: () => {
                const select = document.getElementById('swal-template-select');
                const textarea = document.getElementById('swal-catatan-textarea');
                select.addEventListener('change', (e) => {
                    textarea.value = e.target.value;
                });
            },
            preConfirm: () => {
                const textarea = document.getElementById('swal-catatan-textarea');
                const value = textarea.value.trim();
                if (value.length > 1000) {
                    Swal.showValidationMessage('Catatan persetujuan maksimal 1000 karakter!');
                    return false;
                }
                return value;
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById('approve-kepsek-' + id);
                const input = document.getElementById('catatan-kepsek-approve-input-' + id);
                input.value = result.value;
                form.submit();
            }
        });
    }

    function confirmTolakKepsek(id, nama) {
        Swal.fire({
            title: 'Tolak Usulan?',
            html: `
                <div class="text-left font-sans text-sm space-y-3">
                    <p>Masukkan catatan penolakan Kepala Sekolah untuk usulan: <strong>"${nama}"</strong></p>
                    <div class="space-y-2">
                        <label class="block text-xs font-semibold text-zinc-500 uppercase tracking-wider">Pilih Template Catatan:</label>
                        <select id="swal-template-select" class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 cursor-pointer">
                            <option value="">-- Catatan Kustom / Kosong --</option>
                            <option value="Ditolak sementara karena anggaran sarpras semester ini sudah terpakai sepenuhnya.">Penolakan Anggaran Terpakai</option>
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label class="block text-xs font-semibold text-zinc-500 uppercase tracking-wider">Isi Catatan / Alasan:</label>
                        <textarea id="swal-catatan-textarea" rows="3" class="w-full rounded-md border border-zinc-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Tulis alasan penolakan di sini..."></textarea>
                    </div>
                </div>
            `,
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: '✗ Ya, Tolak',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            focusCancel: true,
            didOpen: () => {
                const select = document.getElementById('swal-template-select');
                const textarea = document.getElementById('swal-catatan-textarea');
                select.addEventListener('change', (e) => {
                    textarea.value = e.target.value;
                });
            },
            preConfirm: () => {
                const textarea = document.getElementById('swal-catatan-textarea');
                const value = textarea.value.trim();
                if (value.length > 1000) {
                    Swal.showValidationMessage('Catatan penolakan maksimal 1000 karakter!');
                    return false;
                }
                return value;
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById('tolak-kepsek-form-' + id);
                const input = document.getElementById('catatan-kepsek-input-' + id);
                input.value = result.value;
                form.submit();
            }
        });
    }
</script>
@endsection
