@extends('layouts.app')

@section('title', 'Tambah Inventaris Baru - Inventaris SMKN 2 SBY')
@section('page_title', 'Tambah Inventaris')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <!-- Back link and Title -->
    <div>
        <a href="{{ route('inventaris.index') }}" class="inline-flex items-center gap-1.5 text-sm text-zinc-500 hover:text-zinc-950 transition-colors mb-2">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
            </svg>
            Kembali ke Daftar Inventaris
        </a>
        <h2 class="text-2xl font-bold tracking-tight text-zinc-900">Tambah Inventaris Baru</h2>
        <p class="text-sm text-zinc-500">Daftarkan data aset barang atau sarana prasarana baru ke dalam sistem.</p>
    </div>

    <!-- Form Card -->
    <div class="rounded-lg border border-zinc-200 bg-white p-6 shadow-sm">
        <form action="{{ route('inventaris.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Kode Inventaris -->
                <div class="space-y-2">
                    <label for="kode_inventaris" class="text-sm font-medium leading-none text-zinc-900">
                        Kode Inventaris <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="kode_inventaris" 
                        name="kode_inventaris" 
                        value="{{ old('kode_inventaris') }}"
                        placeholder="Contoh: INV-PC-RPL-001"
                        class="flex h-10 w-full rounded-md border {{ $errors->has('kode_inventaris') ? 'border-red-500 focus:ring-red-500' : 'border-zinc-200 focus:ring-zinc-950' }} bg-transparent px-3 py-2 text-sm ring-offset-white file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-zinc-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                        required
                    >
                    @error('kode_inventaris')
                        <p class="text-xs font-medium text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nama Barang -->
                <div class="space-y-2">
                    <label for="nama_barang" class="text-sm font-medium leading-none text-zinc-900">
                        Nama Barang <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="nama_barang" 
                        name="nama_barang" 
                        value="{{ old('nama_barang') }}"
                        placeholder="Masukkan nama barang"
                        class="flex h-10 w-full rounded-md border {{ $errors->has('nama_barang') ? 'border-red-500 focus:ring-red-500' : 'border-zinc-200 focus:ring-zinc-950' }} bg-transparent px-3 py-2 text-sm ring-offset-white placeholder:text-zinc-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                        required
                    >
                    @error('nama_barang')
                        <p class="text-xs font-medium text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Merek -->
                <div class="space-y-2">
                    <label for="merek" class="text-sm font-medium leading-none text-zinc-900">
                        Merek <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="merek" 
                        name="merek" 
                        value="{{ old('merek') }}"
                        placeholder="Contoh: Asus, Logitech, Sharp"
                        class="flex h-10 w-full rounded-md border {{ $errors->has('merek') ? 'border-red-500 focus:ring-red-500' : 'border-zinc-200 focus:ring-zinc-950' }} bg-transparent px-3 py-2 text-sm ring-offset-white placeholder:text-zinc-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                        required
                    >
                    @error('merek')
                        <p class="text-xs font-medium text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tipe -->
                <div class="space-y-2">
                    <label for="type" class="text-sm font-medium leading-none text-zinc-900">
                        Tipe Barang
                    </label>
                    <input 
                        type="text" 
                        id="type" 
                        name="type" 
                        value="{{ old('type') }}"
                        placeholder="Contoh: Zephyrus GL 532 GD"
                        class="flex h-10 w-full rounded-md border {{ $errors->has('type') ? 'border-red-500 focus:ring-red-500' : 'border-zinc-200 focus:ring-zinc-950' }} bg-transparent px-3 py-2 text-sm ring-offset-white placeholder:text-zinc-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                    >
                    @error('type')
                        <p class="text-xs font-medium text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Jenis Modal -->
                <div class="space-y-2">
                    <label for="jenis_modal_id" class="text-sm font-medium leading-none text-zinc-900">
                        Jenis Modal <span class="text-red-500">*</span>
                    </label>
                    <select 
                        id="jenis_modal_id" 
                        name="jenis_modal_id" 
                        class="flex h-10 w-full rounded-md border {{ $errors->has('jenis_modal_id') ? 'border-red-500 focus:ring-red-500' : 'border-zinc-200 focus:ring-zinc-950' }} bg-transparent px-3 py-2 text-sm ring-offset-white placeholder:text-zinc-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 text-zinc-900"
                        required
                    >
                        <option value="" disabled {{ old('jenis_modal_id') == '' ? 'selected' : '' }}>Pilih Jenis Modal...</option>
                        @foreach ($jenisModals as $jenisModal)
                            <option value="{{ $jenisModal->id }}" {{ old('jenis_modal_id') == $jenisModal->id ? 'selected' : '' }}>
                                {{ $jenisModal->nama_jenis_modal }}
                            </option>
                        @endforeach
                    </select>
                    @error('jenis_modal_id')
                        <p class="text-xs font-medium text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Spesifikasi -->
            <div class="space-y-2">
                <label for="spesifikasi" class="text-sm font-medium leading-none text-zinc-900">
                    Spesifikasi <span class="text-red-500">*</span>
                </label>
                <textarea 
                    id="spesifikasi" 
                    name="spesifikasi" 
                    placeholder="Masukkan spesifikasi rinci barang (contoh: RAM 8GB, SSD 512GB, Intel i5)"
                    rows="3"
                    class="flex min-h-[80px] w-full rounded-md border {{ $errors->has('spesifikasi') ? 'border-red-500 focus:ring-red-500' : 'border-zinc-200 focus:ring-zinc-950' }} bg-transparent px-3 py-2 text-sm ring-offset-white placeholder:text-zinc-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 text-zinc-900"
                    required
                >{{ old('spesifikasi') }}</textarea>
                @error('spesifikasi')
                    <p class="text-xs font-medium text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Link Foto Google Drive -->
            <div class="space-y-2">
                <label for="foto_url" class="text-sm font-medium leading-none text-zinc-900">
                    Link Foto Google Drive
                </label>
                <input
                    type="url"
                    id="foto_url"
                    name="foto_url"
                    value="{{ old('foto_url') }}"
                    placeholder="Contoh: https://drive.google.com/file/d/FILE_ID/view"
                    class="flex h-10 w-full rounded-md border {{ $errors->has('foto_url') ? 'border-red-500 focus:ring-red-500' : 'border-zinc-200 focus:ring-zinc-950' }} bg-transparent px-3 py-2 text-sm ring-offset-white placeholder:text-zinc-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 text-zinc-900"
                >
                <p class="text-xs text-zinc-500">Gunakan link foto dari Google Drive agar gambar tidak tersimpan di server.</p>
                @error('foto_url')
                    <p class="text-xs font-medium text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Bahan -->
                <div class="space-y-2">
                    <label for="bahan" class="text-sm font-medium leading-none text-zinc-900">
                        Bahan
                    </label>
                    <input
                        type="text"
                        id="bahan"
                        name="bahan"
                        value="{{ old('bahan') }}"
                        placeholder="Contoh: Kayu, plastik, logam"
                        class="flex h-10 w-full rounded-md border {{ $errors->has('bahan') ? 'border-red-500 focus:ring-red-500' : 'border-zinc-200 focus:ring-zinc-950' }} bg-transparent px-3 py-2 text-sm ring-offset-white placeholder:text-zinc-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 text-zinc-900"
                    >
                    @error('bahan')
                        <p class="text-xs font-medium text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Warna -->
                <div class="space-y-2">
                    <label for="warna" class="text-sm font-medium leading-none text-zinc-900">
                        Warna
                    </label>
                    <input
                        type="text"
                        id="warna"
                        name="warna"
                        value="{{ old('warna') }}"
                        placeholder="Contoh: Hitam"
                        class="flex h-10 w-full rounded-md border {{ $errors->has('warna') ? 'border-red-500 focus:ring-red-500' : 'border-zinc-200 focus:ring-zinc-950' }} bg-transparent px-3 py-2 text-sm ring-offset-white placeholder:text-zinc-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 text-zinc-900"
                    >
                    @error('warna')
                        <p class="text-xs font-medium text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 border-t border-zinc-100 pt-4">
                <!-- Unit Kerja -->
                <div class="space-y-2">
                    <label for="jurusan_id" class="text-sm font-medium leading-none text-zinc-900">
                        Unit Kerja <span class="text-red-500">*</span>
                    </label>
                    <select 
                        id="jurusan_id" 
                        name="jurusan_id" 
                        class="flex h-10 w-full rounded-md border {{ $errors->has('jurusan_id') ? 'border-red-500 focus:ring-red-500' : 'border-zinc-200 focus:ring-zinc-950' }} bg-transparent px-3 py-2 text-sm ring-offset-white placeholder:text-zinc-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 text-zinc-900"
                        required
                        onchange="filterRuangan()"
                    >
                        <option value="" disabled {{ old('jurusan_id') == '' ? 'selected' : '' }}>Pilih Unit Kerja...</option>
                        @foreach ($jurusans as $jurusan)
                            <option value="{{ $jurusan->id }}" {{ old('jurusan_id') == $jurusan->id ? 'selected' : '' }}>
                                {{ $jurusan->nama_jurusan }}
                            </option>
                        @endforeach
                    </select>
                    @error('jurusan_id')
                        <p class="text-xs font-medium text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Ruangan -->
                <div class="space-y-2">
                    <label for="ruangan_id" class="text-sm font-medium leading-none text-zinc-900">
                        Ruangan <span class="text-red-500">*</span>
                    </label>
                    <select 
                        id="ruangan_id" 
                        name="ruangan_id" 
                        class="flex h-10 w-full rounded-md border {{ $errors->has('ruangan_id') ? 'border-red-500 focus:ring-red-500' : 'border-zinc-200 focus:ring-zinc-950' }} bg-transparent px-3 py-2 text-sm ring-offset-white placeholder:text-zinc-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 text-zinc-900"
                        required
                    >
                        <option value="" disabled data-jurusan-id="" {{ old('ruangan_id') == '' ? 'selected' : '' }}>Pilih Ruangan...</option>
                        @foreach ($ruangans as $ruangan)
                            <option value="{{ $ruangan->id }}" data-jurusan-id="{{ $ruangan->jurusan_id }}" {{ old('ruangan_id') == $ruangan->id ? 'selected' : '' }} class="ruangan-option">
                                {{ $ruangan->nama_ruangan }}
                            </option>
                        @endforeach
                    </select>
                    @error('ruangan_id')
                        <p class="text-xs font-medium text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-5 gap-4 border-t border-zinc-100 pt-4">
                <!-- Jumlah Total -->
                <div class="space-y-2">
                    <label for="jumlah_total" class="text-sm font-medium leading-none text-zinc-900">
                        Jumlah Total <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="number" 
                        id="jumlah_total" 
                        name="jumlah_total" 
                        value="{{ old('jumlah_total', 1) }}"
                        min="0"
                        placeholder="Jumlah"
                        class="flex h-10 w-full rounded-md border {{ $errors->has('jumlah_total') ? 'border-red-500 focus:ring-red-500' : 'border-zinc-200 focus:ring-zinc-950' }} bg-transparent px-3 py-2 text-sm ring-offset-white placeholder:text-zinc-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 text-zinc-900"
                        required
                    >
                    @error('jumlah_total')
                        <p class="text-xs font-medium text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Harga Satuan -->
                <div class="space-y-2">
                    <label for="harga_satuan" class="text-sm font-medium leading-none text-zinc-900">
                        Harga Barang <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="number"
                        id="harga_satuan"
                        name="harga_satuan"
                        value="{{ old('harga_satuan', 0) }}"
                        min="0"
                        placeholder="Harga satuan"
                        class="flex h-10 w-full rounded-md border {{ $errors->has('harga_satuan') ? 'border-red-500 focus:ring-red-500' : 'border-zinc-200 focus:ring-zinc-950' }} bg-transparent px-3 py-2 text-sm ring-offset-white placeholder:text-zinc-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 text-zinc-900"
                        required
                    >
                    @error('harga_satuan')
                        <p class="text-xs font-medium text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Sumber Dana -->
                <div class="space-y-2">
                    <label for="sumber_dana" class="text-sm font-medium leading-none text-zinc-900">
                        Sumber Dana
                    </label>
                    <input
                        type="text"
                        id="sumber_dana"
                        name="sumber_dana"
                        value="{{ old('sumber_dana') }}"
                        placeholder="Contoh: BOS"
                        class="flex h-10 w-full rounded-md border {{ $errors->has('sumber_dana') ? 'border-red-500 focus:ring-red-500' : 'border-zinc-200 focus:ring-zinc-950' }} bg-transparent px-3 py-2 text-sm ring-offset-white placeholder:text-zinc-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 text-zinc-900"
                    >
                    @error('sumber_dana')
                        <p class="text-xs font-medium text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nama Penyedia -->
                <div class="space-y-2">
                    <label for="nama_penyedia" class="text-sm font-medium leading-none text-zinc-900">
                        Nama Penyedia
                    </label>
                    <input
                        type="text"
                        id="nama_penyedia"
                        name="nama_penyedia"
                        value="{{ old('nama_penyedia') }}"
                        placeholder="Contoh: PT Contoh Penyedia"
                        class="flex h-10 w-full rounded-md border {{ $errors->has('nama_penyedia') ? 'border-red-500 focus:ring-red-500' : 'border-zinc-200 focus:ring-zinc-950' }} bg-transparent px-3 py-2 text-sm ring-offset-white placeholder:text-zinc-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 text-zinc-900"
                    >
                    @error('nama_penyedia')
                        <p class="text-xs font-medium text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nomor Surat BAST -->
                <div class="space-y-2">
                    <label for="nomor_surat_bast" class="text-sm font-medium leading-none text-zinc-900">
                        Nomor Surat BAST
                    </label>
                    <input
                        type="text"
                        id="nomor_surat_bast"
                        name="nomor_surat_bast"
                        value="{{ old('nomor_surat_bast') }}"
                        placeholder="Contoh: BAST/001/2026"
                        class="flex h-10 w-full rounded-md border {{ $errors->has('nomor_surat_bast') ? 'border-red-500 focus:ring-red-500' : 'border-zinc-200 focus:ring-zinc-950' }} bg-transparent px-3 py-2 text-sm ring-offset-white placeholder:text-zinc-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 text-zinc-900"
                    >
                    @error('nomor_surat_bast')
                        <p class="text-xs font-medium text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kondisi -->
                <div class="space-y-2">
                    <label for="kondisi" class="text-sm font-medium leading-none text-zinc-900">
                        Kondisi <span class="text-red-500">*</span>
                    </label>
                    <select 
                        id="kondisi" 
                        name="kondisi" 
                        class="flex h-10 w-full rounded-md border {{ $errors->has('kondisi') ? 'border-red-500 focus:ring-red-500' : 'border-zinc-200 focus:ring-zinc-950' }} bg-transparent px-3 py-2 text-sm ring-offset-white placeholder:text-zinc-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 text-zinc-900"
                        required
                    >
                        <option value="baik" {{ old('kondisi', 'baik') == 'baik' ? 'selected' : '' }}>Baik</option>
                        <option value="layak" {{ old('kondisi') == 'layak' ? 'selected' : '' }}>Layak Pakai</option>
                        <option value="rusak" {{ old('kondisi') == 'rusak' ? 'selected' : '' }}>Rusak</option>
                    </select>
                    @error('kondisi')
                        <p class="text-xs font-medium text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tanggal Pengadaan -->
                <div class="space-y-2">
                    <label for="tanggal_pengadaan" class="text-sm font-medium leading-none text-zinc-900">
                        Tanggal Pengadaan <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="date" 
                        id="tanggal_pengadaan" 
                        name="tanggal_pengadaan" 
                        value="{{ old('tanggal_pengadaan', date('Y-m-d')) }}"
                        class="flex h-10 w-full rounded-md border {{ $errors->has('tanggal_pengadaan') ? 'border-red-500 focus:ring-red-500' : 'border-zinc-200 focus:ring-zinc-950' }} bg-transparent px-3 py-2 text-sm ring-offset-white placeholder:text-zinc-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 text-zinc-900"
                        required
                    >
                    @error('tanggal_pengadaan')
                        <p class="text-xs font-medium text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-100">
                <a href="{{ route('inventaris.index') }}" class="inline-flex items-center justify-center rounded-md border border-zinc-200 text-zinc-700 hover:text-zinc-950 bg-white hover:bg-zinc-50 h-10 px-4 py-2 text-sm font-medium shadow-sm transition-all duration-150 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-950">
                    Batal
                </a>
                <button type="submit" class="inline-flex items-center justify-center rounded-md bg-zinc-900 text-zinc-50 hover:bg-zinc-800 h-10 px-4 py-2 text-sm font-medium shadow-sm transition-all duration-150 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-950 cursor-pointer">
                    Simpan Inventaris
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function filterRuangan() {
    const jurusanId = document.getElementById('jurusan_id').value;
    const ruanganSelect = document.getElementById('ruangan_id');
    const options = ruanganSelect.querySelectorAll('.ruangan-option');
    
    options.forEach(opt => {
        if (opt.getAttribute('data-jurusan-id') === jurusanId) {
            opt.style.display = 'block';
            opt.disabled = false;
        } else {
            opt.style.display = 'none';
            opt.disabled = true;
            if (ruanganSelect.value === opt.value) {
                ruanganSelect.value = '';
            }
        }
    });

    // Check if the current value is not allowed
    const selectedOption = ruanganSelect.options[ruanganSelect.selectedIndex];
    if (selectedOption && selectedOption.getAttribute('data-jurusan-id') !== '' && selectedOption.getAttribute('data-jurusan-id') !== jurusanId) {
        ruanganSelect.value = '';
    }
}

// Run on load in case old values are present
document.addEventListener('DOMContentLoaded', function() {
    if (document.getElementById('jurusan_id').value !== '') {
        filterRuangan();
    }
});
</script>
@endsection
