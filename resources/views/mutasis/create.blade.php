@extends('layouts.app')

@section('title', 'Mutasi Baru - Inventaris SMKN 2 SBY')
@section('page_title', 'Mutasi Barang')

@section('content')
<!-- Tom Select CSS & JS -->
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>

<style>
    /* Penyelarasan Tom Select agar sesuai dengan Tailwind UI / Shadcn */
    .ts-wrapper.single .ts-control {
        border-radius: 0.375rem !important; /* rounded-md */
        border-color: #e4e4e7 !important; /* border-zinc-200 */
        font-family: inherit !important;
        font-size: 0.875rem !important; /* text-sm */
        padding: 0.5rem 0.75rem !important; /* py-2 px-3 */
        height: 2.5rem !important; /* h-10 */
        display: flex !important;
        align-items: center !important;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important; /* shadow-sm */
        background-image: none !important;
    }
    .ts-wrapper.single.focus .ts-control {
        border-color: #a1a1aa !important; /* focus:border-zinc-400 */
        box-shadow: 0 0 0 2px #e4e4e7 !important; /* focus:ring-2 focus:ring-zinc-200 */
    }
    .ts-wrapper.is-invalid .ts-control {
        border-color: #f87171 !important; /* border-red-400 */
        box-shadow: 0 0 0 2px #fee2e2 !important; /* focus:ring-red-100 */
    }
    .ts-wrapper.single .ts-control::after {
        border-color: #71717a transparent transparent transparent !important;
        right: 12px !important;
    }
    .ts-wrapper.single.input-active .ts-control::after {
        border-color: transparent transparent #71717a transparent !important;
    }
    .ts-dropdown {
        border-radius: 0.375rem !important;
        border-color: #e4e4e7 !important;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05) !important; /* shadow-lg */
        font-family: inherit !important;
        font-size: 0.875rem !important;
        margin-top: 4px !important;
        z-index: 50 !important;
    }
    .ts-dropdown .option {
        padding: 0.5rem 0.75rem !important;
    }
    .ts-dropdown .active {
        background-color: #f4f4f5 !important; /* bg-zinc-100 */
        color: #09090b !important; /* text-zinc-950 */
    }
    .ts-wrapper .ts-control input {
        font-size: 0.875rem !important;
    }
</style>

<div class="max-w-2xl mx-auto space-y-6">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-1.5 text-sm text-zinc-500">
        <a href="{{ route('dashboard') }}" class="hover:text-zinc-900 transition-colors">Dashboard</a>
        <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
        </svg>
        <a href="{{ route('mutasis.index') }}" class="hover:text-zinc-900 transition-colors">Riwayat Mutasi</a>
        <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
        </svg>
        <span class="font-medium text-zinc-900">Mutasi Baru</span>
    </nav>

    {{-- Header Section --}}
    <div>
        <h2 class="text-2xl font-bold tracking-tight text-zinc-900">Form Mutasi Barang</h2>
        <p class="text-sm text-zinc-500">Pindahkan stok aset dari lokasi lama (ruangan asal) ke lokasi baru (ruangan tujuan).</p>
    </div>

    {{-- Form Card --}}
    <div class="rounded-lg border border-zinc-200 bg-white p-6 shadow-sm">
        <form method="POST" action="{{ route('mutasis.store') }}" class="space-y-5">
            @csrf

            {{-- Nomor Mutasi --}}
            <div class="space-y-1.5">
                <label for="nomor_mutasi" class="text-sm font-semibold text-zinc-700">Nomor Mutasi</label>
                <input id="nomor_mutasi" name="nomor_mutasi" type="text" required
                    value="{{ old('nomor_mutasi', $defaultNomor) }}" placeholder="Contoh: MUT-20260525-001"
                    class="flex h-10 w-full rounded-md border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-900 focus:border-zinc-400 focus:outline-none focus:ring-2 focus:ring-zinc-200 @error('nomor_mutasi') border-red-300 focus:border-red-400 @enderror">
                @error('nomor_mutasi')
                    <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

            {{-- Pilihan Barang --}}
            <div class="space-y-1.5">
                <label for="inventaris_id" class="text-sm font-semibold text-zinc-700">Pilih Barang yang akan Dipindah</label>
                <select id="inventaris_id" name="inventaris_id" required
                    class="w-full @error('inventaris_id') is-invalid @enderror">
                    <option value="">-- Pilih Barang --</option>
                    @foreach($inventarisList as $item)
                        <option value="{{ $item->id }}" 
                            data-kode="{{ $item->kode_inventaris }}"
                            data-ruangan="{{ $item->ruangan->nama_ruangan }}"
                            data-jurusan="{{ $item->jurusan->nama_jurusan }}"
                            data-qty="{{ $item->jumlah_total }}"
                            {{ old('inventaris_id') == $item->id ? 'selected' : '' }}>
                            {{ $item->kode_inventaris }} - {{ $item->nama_barang }} ({{ $item->merek }}, {{ $item->ruangan->nama_ruangan }})
                        </option>
                    @endforeach
                </select>
                @error('inventaris_id')
                    <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

            {{-- Detail Barang Terpilih (Dynamic Card) --}}
            <div id="detail-info" class="hidden rounded-lg border border-zinc-150 bg-zinc-50/50 p-4 space-y-2 text-xs">
                <p class="font-bold text-zinc-700 uppercase tracking-wider text-[10px]">Informasi Barang Terpilih:</p>
                <div class="grid grid-cols-2 gap-y-1.5 gap-x-4">
                    <div>
                        <span class="text-zinc-400">Kode Inventaris:</span>
                        <p id="detail-kode" class="font-semibold text-zinc-800"></p>
                    </div>
                    <div>
                        <span class="text-zinc-400">Lokasi Asal:</span>
                        <p id="detail-ruangan" class="font-semibold text-zinc-800"></p>
                    </div>
                    <div>
                        <span class="text-zinc-400">Stok Tersedia:</span>
                        <p id="detail-stok" class="font-bold text-zinc-900"></p>
                    </div>
                </div>
            </div>

            {{-- Ruangan Tujuan --}}
            <div class="space-y-1.5">
                <label for="ruangan_tujuan_id" class="text-sm font-semibold text-zinc-700">Ruangan Tujuan</label>
                <select id="ruangan_tujuan_id" name="ruangan_tujuan_id" required
                    class="w-full @error('ruangan_tujuan_id') is-invalid @enderror">
                    <option value="">-- Pilih Ruangan Tujuan --</option>
                    @foreach($ruangans as $ruangan)
                        <option value="{{ $ruangan->id }}" {{ old('ruangan_tujuan_id') == $ruangan->id ? 'selected' : '' }}>
                            {{ $ruangan->nama_ruangan }} ({{ $ruangan->jurusan->nama_jurusan }})
                        </option>
                    @endforeach
                </select>
                @error('ruangan_tujuan_id')
                    <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

            {{-- Jumlah Dipindah --}}
            <div class="space-y-1.5">
                <label for="jumlah_dipindah" class="text-sm font-semibold text-zinc-700">Jumlah yang Dipindah</label>
                <input id="jumlah_dipindah" name="jumlah_dipindah" type="number" min="1" required
                    value="{{ old('jumlah_dipindah') }}" placeholder="Masukkan kuantitas barang"
                    class="flex h-10 w-full rounded-md border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-900 focus:border-zinc-400 focus:outline-none focus:ring-2 focus:ring-zinc-200 @error('jumlah_dipindah') border-red-300 focus:border-red-400 @enderror">
                <p id="jumlah_dipindah_help" class="text-xs text-zinc-400 font-light"></p>
                @error('jumlah_dipindah')
                    <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tanggal Mutasi --}}
            <div class="space-y-1.5">
                <label for="tanggal_mutasi" class="text-sm font-semibold text-zinc-700">Tanggal Mutasi</label>
                <input id="tanggal_mutasi" name="tanggal_mutasi" type="date" required
                    value="{{ old('tanggal_mutasi', date('Y-m-d')) }}"
                    class="flex h-10 w-full rounded-md border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-900 focus:border-zinc-400 focus:outline-none focus:ring-2 focus:ring-zinc-200 @error('tanggal_mutasi') border-red-300 focus:border-red-400 @enderror">
                @error('tanggal_mutasi')
                    <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

            {{-- Penanggung Jawab --}}
            <div class="space-y-1.5">
                <label for="penanggung_jawab" class="text-sm font-semibold text-zinc-700">Penanggung Jawab Mutasi</label>
                <input id="penanggung_jawab" name="penanggung_jawab" type="text" required
                    value="{{ old('penanggung_jawab') }}" placeholder="Contoh: Budi Santoso, S.Pd."
                    class="flex h-10 w-full rounded-md border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-900 focus:border-zinc-400 focus:outline-none focus:ring-2 focus:ring-zinc-200 @error('penanggung_jawab') border-red-300 focus:border-red-400 @enderror">
                @error('penanggung_jawab')
                    <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

            {{-- Keterangan --}}
            <div class="space-y-1.5">
                <label for="keterangan_pindah" class="text-sm font-semibold text-zinc-700">Keterangan / Alasan Mutasi</label>
                <textarea id="keterangan_pindah" name="keterangan_pindah" rows="3" required
                    placeholder="Contoh: Pemindahan unit laptop cadangan ke ruangan lab RPL 1."
                    class="flex w-full rounded-md border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-900 focus:border-zinc-400 focus:outline-none focus:ring-2 focus:ring-zinc-200 @error('keterangan_pindah') border-red-300 focus:border-red-400 @enderror">{{ old('keterangan_pindah') }}</textarea>
                @error('keterangan_pindah')
                    <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-end gap-3 pt-3 border-t border-zinc-100">
                <a href="{{ route('mutasis.index') }}"
                    class="inline-flex items-center justify-center rounded-md border border-zinc-200 text-xs font-semibold text-zinc-700 bg-white hover:bg-zinc-50 transition-colors shadow-sm px-4 py-2 cursor-pointer">
                    Batal
                </a>
                <button type="submit"
                    class="inline-flex items-center justify-center gap-1.5 rounded-md bg-zinc-900 text-zinc-50 hover:bg-zinc-800 px-4 py-2 text-xs font-semibold shadow-sm transition-all duration-150 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-950 cursor-pointer">
                    Simpan Mutasi
                </button>
            </div>

        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inisialisasi Tom Select untuk pencarian dropdown
        const tsBarang = new TomSelect('#inventaris_id', {
            create: false,
            placeholder: '-- Pilih Barang --',
            controlInput: '<input>',
            render: {
                option: function(data, escape) {
                    return '<div class="py-1"><div>' + escape(data.text) + '</div></div>';
                }
            }
        });

        const tsRuangan = new TomSelect('#ruangan_tujuan_id', {
            create: false,
            placeholder: '-- Pilih Ruangan Tujuan --',
            controlInput: '<input>',
            render: {
                option: function(data, escape) {
                    return '<div class="py-1"><div>' + escape(data.text) + '</div></div>';
                }
            }
        });

        const selectBarang = document.getElementById('inventaris_id');

        function updateDetail() {
            const selectedValue = selectBarang.value;
            const detailContainer = document.getElementById('detail-info');

            if (selectedValue) {
                const selectedOption = selectBarang.querySelector('option[value="' + selectedValue + '"]');
                if (selectedOption) {
                    const ruangan = selectedOption.getAttribute('data-ruangan');
                    const jurusan = selectedOption.getAttribute('data-jurusan');
                    const qty = selectedOption.getAttribute('data-qty');
                    const kode = selectedOption.getAttribute('data-kode');

                    detailContainer.classList.remove('hidden');
                    document.getElementById('detail-kode').textContent = kode;
                    document.getElementById('detail-ruangan').textContent = ruangan + ' (' + jurusan + ')';
                    document.getElementById('detail-stok').textContent = qty + ' unit';

                    const inputQty = document.getElementById('jumlah_dipindah');
                    inputQty.max = qty;
                    document.getElementById('jumlah_dipindah_help').textContent = 'Maksimal ' + qty + ' unit.';
                }
            } else {
                detailContainer.classList.add('hidden');
                document.getElementById('jumlah_dipindah_help').textContent = '';
            }
        }

        selectBarang.addEventListener('change', updateDetail);
        
        // Panggil jika ada data old validation
        if (selectBarang.value) {
            updateDetail();
        }
    });
</script>
@endsection
