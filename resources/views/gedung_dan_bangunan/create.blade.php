@extends('layouts.app')

@section('title', 'Tambah Gedung & Bangunan (KIB C)')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <a href="{{ route('gedung-dan-bangunan.index') }}" class="text-xs font-semibold text-zinc-500 hover:text-zinc-900 transition-colors inline-flex items-center gap-1 mb-1">
                &larr; Kembali ke Data Gedung & Bangunan
            </a>
            <h1 class="text-2xl font-bold text-zinc-900 tracking-tight">Tambah Gedung & Bangunan (KIB C)</h1>
            <p class="text-sm text-zinc-500 mt-0.5">Isi formulir lengkap untuk mencatat data aset gedung atau bangunan baru.</p>
        </div>
    </div>

    {{-- Form Container --}}
    <form action="{{ route('gedung-dan-bangunan.store') }}" method="POST" class="space-y-6">
        @csrf

        {{-- Section 1: Informasi Utama Gedung --}}
        <div class="bg-white rounded-xl border border-zinc-200 p-6 shadow-sm space-y-4">
            <h2 class="text-base font-bold text-zinc-900 border-b border-zinc-100 pb-3">1. Informasi Utama Gedung & Bangunan</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Kode Inventaris --}}
                <div>
                    <label for="kode_inventaris" class="block text-xs font-semibold text-zinc-700 mb-1">Kode Barang <span class="text-red-500">*</span></label>
                    <input type="text" name="kode_inventaris" id="kode_inventaris" value="{{ old('kode_inventaris', $autoKode) }}" required
                        class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-900 focus:border-zinc-500 focus:outline-none focus:ring-1 focus:ring-zinc-500 font-mono">
                    @error('kode_inventaris') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Nama Gedung / Bangunan --}}
                <div>
                    <label for="nama_barang" class="block text-xs font-semibold text-zinc-700 mb-1">Nama Gedung / Bangunan <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_barang" id="nama_barang" value="{{ old('nama_barang') }}" placeholder="Contoh: Gedung Sekolah Utama A" required
                        class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-900 focus:border-zinc-500 focus:outline-none focus:ring-1 focus:ring-zinc-500">
                    @error('nama_barang') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Jenis Modal --}}
                <div>
                    <label for="jenis_modal_id" class="block text-xs font-semibold text-zinc-700 mb-1">Jenis Modal</label>
                    <select name="jenis_modal_id" id="jenis_modal_id"
                        class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-900 focus:border-zinc-500 focus:outline-none focus:ring-1 focus:ring-zinc-500">
                        <option value="">Tidak Ada</option>
                        @foreach($jenisModals as $jm)
                            <option value="{{ $jm->id }}" {{ (old('jenis_modal_id', $jenisModalGedung?->id) == $jm->id) ? 'selected' : '' }}>
                                {{ $jm->nama_jenis_modal }}
                            </option>
                        @endforeach
                    </select>
                    @error('jenis_modal_id') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Kategori --}}
                <div>
                    <label for="kategori_id" class="block text-xs font-semibold text-zinc-700 mb-1">Kategori Barang</label>
                    <select name="kategori_id" id="kategori_id"
                        class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-900 focus:border-zinc-500 focus:outline-none focus:ring-1 focus:ring-zinc-500">
                        <option value="">Tidak Ada</option>
                        @foreach($kategoris as $kat)
                            <option value="{{ $kat->id }}" {{ old('kategori_id') == $kat->id ? 'selected' : '' }}>
                                {{ $kat->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Unit Kerja (Jurusan) --}}
                <div>
                    <label for="jurusan_id" class="block text-xs font-semibold text-zinc-700 mb-1">Unit Kerja / Jurusan</label>
                    <select name="jurusan_id" id="jurusan_id" onchange="filterRuangan()"
                        class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-900 focus:border-zinc-500 focus:outline-none focus:ring-1 focus:ring-zinc-500">
                        <option value="">Tidak Ada</option>
                        @foreach($jurusans as $jur)
                            <option value="{{ $jur->id }}" {{ old('jurusan_id') == $jur->id ? 'selected' : '' }}>
                                {{ $jur->nama_jurusan }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Ruangan --}}
                <div>
                    <label for="ruangan_id" class="block text-xs font-semibold text-zinc-700 mb-1">Ruangan / Lokasi</label>
                    <select name="ruangan_id" id="ruangan_id"
                        class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-900 focus:border-zinc-500 focus:outline-none focus:ring-1 focus:ring-zinc-500">
                        <option value="" data-jurusan-id="">Tidak Ada</option>
                        @foreach($ruangans as $ruang)
                            <option value="{{ $ruang->id }}"
                                    data-jurusan-id="{{ $ruang->jurusan_id }}"
                                    {{ old('ruangan_id') == $ruang->id ? 'selected' : '' }}>
                                {{ $ruang->nama_ruangan }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        {{-- Section 2: Spesifikasi & Konstruksi Gedung --}}
        <div class="bg-white rounded-xl border border-zinc-200 p-6 shadow-sm space-y-4">
            <h2 class="text-base font-bold text-zinc-900 border-b border-zinc-100 pb-3">2. Spesifikasi KIB C & Konstruksi</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                {{-- Kondisi Bangunan --}}
                <div>
                    <label for="kondisi" class="block text-xs font-semibold text-zinc-700 mb-1">Kondisi Bangunan <span class="text-red-500">*</span></label>
                    <select name="kondisi" id="kondisi" required
                        class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-900 focus:border-zinc-500 focus:outline-none focus:ring-1 focus:ring-zinc-500">
                        <option value="baik" {{ old('kondisi') == 'baik' ? 'selected' : '' }}>B : Baik</option>
                        <option value="rusak_ringan" {{ old('kondisi') == 'rusak_ringan' ? 'selected' : '' }}>RR : Rusak Ringan</option>
                        <option value="rusak_sedang" {{ old('kondisi') == 'rusak_sedang' ? 'selected' : '' }}>RS : Rusak Sedang</option>
                        <option value="rusak_berat" {{ old('kondisi') == 'rusak_berat' ? 'selected' : '' }}>RB : Rusak Berat</option>
                    </select>
                </div>

                {{-- Konstruksi Bertingkat --}}
                <div>
                    <label for="konstruksi_bertingkat" class="block text-xs font-semibold text-zinc-700 mb-1">Konstruksi: Bertingkat? <span class="text-red-500">*</span></label>
                    <select name="konstruksi_bertingkat" id="konstruksi_bertingkat" required
                        class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-900 focus:border-zinc-500 focus:outline-none focus:ring-1 focus:ring-zinc-500">
                        <option value="Tidak" {{ old('konstruksi_bertingkat') == 'Tidak' ? 'selected' : '' }}>Tidak (Bukan Bertingkat)</option>
                        <option value="Bertingkat" {{ old('konstruksi_bertingkat') == 'Bertingkat' ? 'selected' : '' }}>Bertingkat (Tingkat)</option>
                    </select>
                </div>

                {{-- Konstruksi Beton --}}
                <div>
                    <label for="konstruksi_beton" class="block text-xs font-semibold text-zinc-700 mb-1">Konstruksi: Beton? <span class="text-red-500">*</span></label>
                    <select name="konstruksi_beton" id="konstruksi_beton" required
                        class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-900 focus:border-zinc-500 focus:outline-none focus:ring-1 focus:ring-zinc-500">
                        <option value="Beton" {{ old('konstruksi_beton', 'Beton') == 'Beton' ? 'selected' : '' }}>Beton (BTN)</option>
                        <option value="Tidak" {{ old('konstruksi_beton') == 'Tidak' ? 'selected' : '' }}>Tidak (Bukan Beton)</option>
                    </select>
                </div>

                {{-- Luas Lantai (M2) --}}
                <div>
                    <label for="luas_lantai" class="block text-xs font-semibold text-zinc-700 mb-1">Luas Lantai (m²)</label>
                    <input type="number" step="0.01" name="luas_lantai" id="luas_lantai" value="{{ old('luas_lantai') }}" placeholder="Contoh: 450"
                        class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-900 focus:border-zinc-500 focus:outline-none focus:ring-1 focus:ring-zinc-500">
                </div>

                {{-- Luas Tanah (M2) --}}
                <div>
                    <label for="luas_tanah" class="block text-xs font-semibold text-zinc-700 mb-1">Luas Tanah (m²)</label>
                    <input type="number" step="0.01" name="luas_tanah" id="luas_tanah" value="{{ old('luas_tanah') }}" placeholder="Contoh: 1000"
                        class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-900 focus:border-zinc-500 focus:outline-none focus:ring-1 focus:ring-zinc-500">
                </div>

                {{-- Status Tanah --}}
                <div>
                    <label for="status_tanah" class="block text-xs font-semibold text-zinc-700 mb-1">Status Tanah</label>
                    <input type="text" name="status_tanah" id="status_tanah" value="{{ old('status_tanah', 'Hak Pakai') }}" placeholder="Contoh: Hak Pakai / Hak Milik"
                        class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-900 focus:border-zinc-500 focus:outline-none focus:ring-1 focus:ring-zinc-500">
                </div>

                {{-- Nomor Kode Tanah --}}
                <div>
                    <label for="nomor_kode_tanah" class="block text-xs font-semibold text-zinc-700 mb-1">Nomor Kode Tanah</label>
                    <input type="text" name="nomor_kode_tanah" id="nomor_kode_tanah" value="{{ old('nomor_kode_tanah') }}" placeholder="Contoh: 12.11.00.01"
                        class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-900 focus:border-zinc-500 focus:outline-none focus:ring-1 focus:ring-zinc-500 font-mono">
                </div>

                {{-- Nomor Dokumen --}}
                <div>
                    <label for="dokumen_nomor" class="block text-xs font-semibold text-zinc-700 mb-1">Nomor Dokumen Bangunan</label>
                    <input type="text" name="dokumen_nomor" id="dokumen_nomor" value="{{ old('dokumen_nomor') }}" placeholder="Contoh: 500/01/2020"
                        class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-900 focus:border-zinc-500 focus:outline-none focus:ring-1 focus:ring-zinc-500">
                </div>

                {{-- Tanggal Dokumen --}}
                <div>
                    <label for="dokumen_tanggal" class="block text-xs font-semibold text-zinc-700 mb-1">Tanggal Dokumen</label>
                    <input type="date" name="dokumen_tanggal" id="dokumen_tanggal" value="{{ old('dokumen_tanggal') }}"
                        class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-900 focus:border-zinc-500 focus:outline-none focus:ring-1 focus:ring-zinc-500">
                </div>

                {{-- Alamat / Letak Lokasi --}}
                <div class="md:col-span-3">
                    <label for="lokasi_alamat" class="block text-xs font-semibold text-zinc-700 mb-1">Letak / Lokasi Alamat Gedung</label>
                    <textarea name="lokasi_alamat" id="lokasi_alamat" rows="2" placeholder="Contoh: Jl. Tentara Genie Pelajar No. 26, Sawahan, Surabaya"
                        class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-900 focus:border-zinc-500 focus:outline-none focus:ring-1 focus:ring-zinc-500">{{ old('lokasi_alamat') }}</textarea>
                </div>
            </div>
        </div>

        {{-- Section 3: Keuangan & Nilai Aset --}}
        <div class="bg-white rounded-xl border border-zinc-200 p-6 shadow-sm space-y-4">
            <h2 class="text-base font-bold text-zinc-900 border-b border-zinc-100 pb-3">3. Keuangan & Nilai Aset</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                {{-- Harga Satuan / Nilai Aset --}}
                <div>
                    <label for="harga_satuan" class="block text-xs font-semibold text-zinc-700 mb-1">Harga / Nilai Bangunan (Rp) <span class="text-red-500">*</span></label>
                    <input type="number" name="harga_satuan" id="harga_satuan" value="{{ old('harga_satuan', 0) }}" required
                        class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-900 focus:border-zinc-500 focus:outline-none focus:ring-1 focus:ring-zinc-500 font-mono">
                </div>

                {{-- Jumlah Total Unit --}}
                <div>
                    <label for="jumlah_total" class="block text-xs font-semibold text-zinc-700 mb-1">Jumlah Unit <span class="text-red-500">*</span></label>
                    <input type="number" name="jumlah_total" id="jumlah_total" value="{{ old('jumlah_total', 1) }}" min="1" required
                        class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-900 focus:border-zinc-500 focus:outline-none focus:ring-1 focus:ring-zinc-500">
                </div>

                {{-- Asal Usul / Sumber Dana --}}
                <div>
                    <label for="sumber_dana" class="block text-xs font-semibold text-zinc-700 mb-1">Asal Usul Perolehan</label>
                    <input type="text" name="sumber_dana" id="sumber_dana" value="{{ old('sumber_dana', 'APBD') }}" placeholder="APBD / APBN / Hibah"
                        class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-900 focus:border-zinc-500 focus:outline-none focus:ring-1 focus:ring-zinc-500">
                </div>

                {{-- Tanggal Catat Aset --}}
                <div>
                    <label for="tanggal_catat_aset" class="block text-xs font-semibold text-zinc-700 mb-1">Tanggal Catat Aset <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal_catat_aset" id="tanggal_catat_aset" value="{{ old('tanggal_catat_aset', now()->format('Y-m-d')) }}" required
                        class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-900 focus:border-zinc-500 focus:outline-none focus:ring-1 focus:ring-zinc-500">
                </div>
            </div>
        </div>

        {{-- Section 4: Dokumentasi Foto Bangunan (Google Drive) --}}
        <div class="bg-white rounded-xl border border-zinc-200 p-6 shadow-sm space-y-4">
            <h2 class="text-base font-bold text-zinc-900 border-b border-zinc-100 pb-3 flex items-center justify-between">
                <span>4. Dokumentasi Foto Bangunan</span>
                <span class="text-xs font-normal text-zinc-500">Tautan Google Drive</span>
            </h2>

            <div>
                <label for="foto_url" class="block text-xs font-semibold text-zinc-700 mb-1">Link Google Drive Foto Bangunan</label>
                <div class="relative">
                    <input type="url" name="foto_url" id="foto_url" value="{{ old('foto_url') }}" placeholder="https://drive.google.com/file/d/... atau https://drive.google.com/drive/folders/..."
                        class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-900 placeholder-zinc-400 focus:border-zinc-500 focus:outline-none focus:ring-1 focus:ring-zinc-500">
                </div>
                <p class="text-[11px] text-zinc-500 mt-1">Masukkan tautan/link Google Drive tempat menyimpan foto atau berkas dokumentasi fisik gedung/bangunan ini.</p>
                @error('foto_url') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Form Actions --}}
        <div class="flex items-center justify-end gap-3 pt-2">
            <a href="{{ route('gedung-dan-bangunan.index') }}" class="px-4 py-2 text-sm font-semibold text-zinc-600 hover:text-zinc-900 bg-zinc-100 hover:bg-zinc-200 rounded-md transition-colors">
                Batal
            </a>
            <button type="submit" class="px-5 py-2 text-sm font-semibold text-white bg-zinc-900 hover:bg-zinc-800 rounded-md transition-colors shadow-sm">
                Simpan Gedung & Bangunan
            </button>
        </div>
    </form>
</div>

<script>
function filterRuangan() {
    const jurusanSelect = document.getElementById('jurusan_id');
    const ruanganSelect = document.getElementById('ruangan_id');
    if (!jurusanSelect || !ruanganSelect) return;

    const jurusanId = jurusanSelect.value;
    const options = ruanganSelect.querySelectorAll('option');

    let currentValStillValid = false;

    options.forEach(opt => {
        if (opt.value === '') {
            opt.hidden = false;
            opt.disabled = false;
            return;
        }

        const optJurusan = opt.getAttribute('data-jurusan-id');
        if (!jurusanId || !optJurusan || optJurusan === jurusanId) {
            opt.hidden = false;
            opt.disabled = false;
            if (ruanganSelect.value === opt.value) {
                currentValStillValid = true;
            }
        } else {
            opt.hidden = true;
            opt.disabled = true;
        }
    });

    if (!currentValStillValid && ruanganSelect.value !== '') {
        ruanganSelect.value = '';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    filterRuangan();
});
</script>
@endsection
