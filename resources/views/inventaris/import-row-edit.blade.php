@extends('layouts.app')

@section('title', 'Perbaiki Data Import - Inventaris SMKN 2 SBY')
@section('page_title', 'Perbaiki Data Import')

@section('content')
<div class="space-y-6">
    <nav class="flex items-center gap-1.5 text-sm text-zinc-500">
        <a href="{{ route('dashboard') }}" class="hover:text-zinc-900 transition-colors">Dashboard</a>
        <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" /></svg>
        <a href="{{ route('inventaris.imports.show', $batch->id) }}" class="hover:text-zinc-900 transition-colors">Review Import</a>
        <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" /></svg>
        <span class="font-medium text-zinc-900">Perbaiki Baris {{ $row->row_number }}</span>
    </nav>

    <div>
        <a href="{{ route('inventaris.imports.show', $batch->id) }}" class="inline-flex items-center gap-1.5 text-sm text-zinc-500 hover:text-zinc-950 transition-colors mb-2">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" /></svg>
            Kembali ke Review Import
        </a>
        <h2 class="text-2xl font-bold tracking-tight text-zinc-900">Perbaiki Data Import</h2>
        <p class="text-sm text-zinc-500">Edit data staging pada baris {{ $row->row_number }}. Setelah disimpan, data akan divalidasi ulang.</p>
    </div>

    @if($row->validation_errors)
        <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3">
            <p class="text-sm font-semibold text-red-800">Kesalahan saat ini:</p>
            <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-red-700">
                @foreach($row->validation_errors as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <div class="xl:col-span-2 rounded-lg border border-zinc-200 bg-white p-6 shadow-sm">
            <form action="{{ route('inventaris.imports.rows.update', [$batch->id, $row->id]) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                @php($payload = $row->payload)

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label for="nama_barang" class="text-sm font-medium text-zinc-900">Nama Barang</label>
                        <input id="nama_barang" name="nama_barang" value="{{ old('nama_barang', $payload['nama_barang'] ?? '') }}" class="h-10 w-full rounded-md border border-zinc-200 px-3 text-sm" required>
                        @error('nama_barang') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-2">
                        <label for="merek" class="text-sm font-medium text-zinc-900">Merek</label>
                        <input id="merek" name="merek" value="{{ old('merek', $payload['merek'] ?? '') }}" class="h-10 w-full rounded-md border border-zinc-200 px-3 text-sm" required>
                        @error('merek') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="space-y-2">
                    <label for="spesifikasi" class="text-sm font-medium text-zinc-900">Spesifikasi</label>
                    <textarea id="spesifikasi" name="spesifikasi" rows="3" class="w-full rounded-md border border-zinc-200 px-3 py-2 text-sm" required>{{ old('spesifikasi', $payload['spesifikasi'] ?? '') }}</textarea>
                    @error('spesifikasi') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-2">
                    <label for="foto_url" class="text-sm font-medium text-zinc-900">Link Foto Google Drive</label>
                    <input id="foto_url" name="foto_url" type="url" value="{{ old('foto_url', $payload['foto_url'] ?? '') }}" class="h-10 w-full rounded-md border border-zinc-200 px-3 text-sm" placeholder="https://drive.google.com/file/d/FILE_ID/view">
                    <p class="text-xs text-zinc-500">Opsional. Kosongkan jika belum ada foto.</p>
                    @error('foto_url') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label for="bahan" class="text-sm font-medium text-zinc-900">Bahan</label>
                        <input id="bahan" name="bahan" value="{{ old('bahan', $payload['bahan'] ?? '') }}" class="h-10 w-full rounded-md border border-zinc-200 px-3 text-sm" placeholder="Kayu, plastik, logam">
                        @error('bahan') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-2">
                        <label for="warna" class="text-sm font-medium text-zinc-900">Warna</label>
                        <input id="warna" name="warna" value="{{ old('warna', $payload['warna'] ?? '') }}" class="h-10 w-full rounded-md border border-zinc-200 px-3 text-sm" placeholder="Hitam">
                        @error('warna') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="space-y-2">
                        <label for="kategori_id" class="text-sm font-medium text-zinc-900">Kategori</label>
                        <select id="kategori_id" name="kategori_id" class="h-10 w-full rounded-md border border-zinc-200 bg-white px-3 text-sm" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id }}" @selected(old('kategori_id', $payload['kategori_id'] ?? '') === $kategori->id)>
                                    {{ $kategori->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                        @error('kategori_id') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-2">
                        <label for="jurusan_id" class="text-sm font-medium text-zinc-900">Unit Kerja</label>
                        <select id="jurusan_id" name="jurusan_id" class="h-10 w-full rounded-md border border-zinc-200 bg-white px-3 text-sm" required>
                            <option value="">Pilih Unit Kerja</option>
                            @foreach($jurusans as $jurusan)
                                <option value="{{ $jurusan->id }}" @selected(old('jurusan_id', $payload['jurusan_id'] ?? '') === $jurusan->id)>
                                    {{ $jurusan->nama_jurusan }}
                                </option>
                            @endforeach
                        </select>
                        @error('jurusan_id') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-2">
                        <label for="ruangan_id" class="text-sm font-medium text-zinc-900">Ruangan</label>
                        <select id="ruangan_id" name="ruangan_id" class="h-10 w-full rounded-md border border-zinc-200 bg-white px-3 text-sm" required>
                            <option value="">Pilih Ruangan</option>
                            @foreach($ruangans as $ruangan)
                                <option
                                    value="{{ $ruangan->id }}"
                                    data-jurusan-id="{{ $ruangan->jurusan_id }}"
                                    @selected(old('ruangan_id', $payload['ruangan_id'] ?? '') === $ruangan->id)
                                >
                                    {{ $ruangan->nama_ruangan }} - {{ $ruangan->jurusan?->nama_jurusan ?? 'Tanpa Unit Kerja' }}
                                </option>
                            @endforeach
                        </select>
                        @error('ruangan_id') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <div class="space-y-2">
                        <label for="jumlah_total" class="text-sm font-medium text-zinc-900">Jumlah Total</label>
                        <input id="jumlah_total" name="jumlah_total" type="number" min="0" value="{{ old('jumlah_total', $payload['jumlah_total'] ?? 0) }}" class="h-10 w-full rounded-md border border-zinc-200 px-3 text-sm" required>
                        @error('jumlah_total') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-2">
                        <label for="harga_satuan" class="text-sm font-medium text-zinc-900">Harga Barang</label>
                        <input id="harga_satuan" name="harga_satuan" type="number" min="0" value="{{ old('harga_satuan', $payload['harga_satuan'] ?? 0) }}" class="h-10 w-full rounded-md border border-zinc-200 px-3 text-sm" required>
                        @error('harga_satuan') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-2">
                        <label for="sumber_dana" class="text-sm font-medium text-zinc-900">Sumber Dana</label>
                        <input id="sumber_dana" name="sumber_dana" value="{{ old('sumber_dana', $payload['sumber_dana'] ?? '') }}" class="h-10 w-full rounded-md border border-zinc-200 px-3 text-sm" placeholder="BOS">
                        @error('sumber_dana') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-2">
                        <label for="nama_penyedia" class="text-sm font-medium text-zinc-900">Nama Penyedia</label>
                        <input id="nama_penyedia" name="nama_penyedia" value="{{ old('nama_penyedia', $payload['nama_penyedia'] ?? '') }}" class="h-10 w-full rounded-md border border-zinc-200 px-3 text-sm" placeholder="PT Contoh Penyedia">
                        @error('nama_penyedia') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-2">
                        <label for="nomor_surat_bast" class="text-sm font-medium text-zinc-900">Nomor Surat BAST</label>
                        <input id="nomor_surat_bast" name="nomor_surat_bast" value="{{ old('nomor_surat_bast', $payload['nomor_surat_bast'] ?? '') }}" class="h-10 w-full rounded-md border border-zinc-200 px-3 text-sm" placeholder="BAST/001/2026">
                        @error('nomor_surat_bast') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-2">
                        <label for="kondisi" class="text-sm font-medium text-zinc-900">Kondisi</label>
                        <select id="kondisi" name="kondisi" class="h-10 w-full rounded-md border border-zinc-200 px-3 text-sm" required>
                            @foreach(['baik' => 'Baik', 'layak' => 'Layak Pakai', 'rusak' => 'Rusak'] as $value => $label)
                                <option value="{{ $value }}" @selected(old('kondisi', $payload['kondisi'] ?? '') === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('kondisi') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-2">
                        <label for="tanggal_pengadaan" class="text-sm font-medium text-zinc-900">Tanggal Pengadaan</label>
                        <input id="tanggal_pengadaan" name="tanggal_pengadaan" type="date" value="{{ old('tanggal_pengadaan', $payload['tanggal_pengadaan'] ?? '') }}" class="h-10 w-full rounded-md border border-zinc-200 px-3 text-sm" required>
                        @error('tanggal_pengadaan') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="flex justify-end gap-3 border-t border-zinc-100 pt-5">
                    <a href="{{ route('inventaris.imports.show', $batch->id) }}" class="inline-flex h-10 items-center rounded-md border border-zinc-200 bg-white px-4 text-sm font-medium text-zinc-700 hover:bg-zinc-50">Batal</a>
                    <button type="submit" class="inline-flex h-10 items-center rounded-md bg-emerald-600 px-4 text-sm font-medium text-white hover:bg-emerald-700 cursor-pointer">
                        Simpan & Validasi Ulang
                    </button>
                </div>
            </form>
        </div>

        <div class="space-y-4">
            <div class="rounded-lg border border-zinc-200 bg-white p-5 shadow-sm">
                <h3 class="text-sm font-semibold text-zinc-900">Referensi Pengisian</h3>
                <p class="mt-1 text-xs text-zinc-500">Kategori, Unit Kerja, dan Ruangan sekarang bisa dipilih berdasarkan nama. Sistem tetap menyimpan ID relasi di belakang layar.</p>
                <p class="mt-2 text-xs text-zinc-500">Pilihan Ruangan otomatis disaring berdasarkan Unit Kerja yang dipilih.</p>
            </div>
        </div>
    </div>
</div>

<script>
    const jurusanSelect = document.getElementById('jurusan_id');
    const ruanganSelect = document.getElementById('ruangan_id');
    const ruanganOptions = Array.from(ruanganSelect.options).map((option) => ({
        value: option.value,
        text: option.text,
        jurusanId: option.dataset.jurusanId || '',
        selected: option.selected,
    }));

    function filterRuanganOptions() {
        const selectedJurusanId = jurusanSelect.value;
        const currentRuanganId = ruanganSelect.value;

        ruanganSelect.innerHTML = '';
        ruanganOptions.forEach((optionData) => {
            if (optionData.value && selectedJurusanId && optionData.jurusanId !== selectedJurusanId) {
                return;
            }

            const option = document.createElement('option');
            option.value = optionData.value;
            option.textContent = optionData.text;
            option.dataset.jurusanId = optionData.jurusanId;
            option.selected = optionData.value === currentRuanganId;
            ruanganSelect.appendChild(option);
        });

        if (!Array.from(ruanganSelect.options).some((option) => option.selected)) {
            ruanganSelect.value = '';
        }
    }

    jurusanSelect.addEventListener('change', () => {
        ruanganSelect.value = '';
        filterRuanganOptions();
    });

    filterRuanganOptions();
</script>
@endsection
