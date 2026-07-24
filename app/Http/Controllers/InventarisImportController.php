<?php

namespace App\Http\Controllers;

use App\Models\Inventaris;
use App\Models\InventarisImportBatch;
use App\Models\InventarisImportRow;
use App\Models\JenisModal;
use App\Models\Jurusan;
use App\Models\Ruangan;
use App\Services\InventarisCodeGenerator;
use App\Services\InventarisSpreadsheetService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class InventarisImportController extends Controller
{
    public function create(): View
    {
        $batches = InventarisImportBatch::with('creator')
            ->latest()
            ->limit(10)
            ->get();
        $jenisModals = JenisModal::orderBy('nama_jenis_modal')->get();
        $jurusans = Jurusan::orderBy('nama_jurusan')->get();
        $ruangans = Ruangan::with('jurusan')->orderBy('nama_ruangan')->get();

        return view('inventaris.import', compact('batches', 'jenisModals', 'jurusans', 'ruangans'));
    }

    public function store(Request $request, InventarisSpreadsheetService $spreadsheet): RedirectResponse
    {
        $validated = $request->validate([
            'file' => 'required|file|extensions:csv,xlsx|max:5120',
        ]);

        $file = $validated['file'];
        $extension = strtolower($file->getClientOriginalExtension());

        try {
            $rows = $spreadsheet->parse($file->getRealPath(), $extension);
        } catch (\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }

        if ($rows === []) {
            return back()->with('error', 'File import kosong atau tidak memiliki baris data.');
        }

        $batch = DB::transaction(function () use ($file, $rows) {
            $batch = InventarisImportBatch::create([
                'file_name' => $file->getClientOriginalName(),
                'status' => 'pending',
                'total_rows' => count($rows),
                'created_by' => auth()->id(),
            ]);

            $validRows = 0;
            $invalidRows = 0;

            foreach ($rows as $row) {
                $errors = $this->validatePayload($row['payload']);
                $validRows += $errors === [] ? 1 : 0;
                $invalidRows += $errors === [] ? 0 : 1;

                $batch->rows()->create([
                    'row_number' => $row['row_number'],
                    'payload' => $row['payload'],
                    'validation_errors' => $errors === [] ? null : $errors,
                    'status' => 'pending',
                ]);
            }

            $batch->update([
                'valid_rows' => $validRows,
                'invalid_rows' => $invalidRows,
            ]);

            return $batch;
        });

        return redirect()
            ->route('inventaris.imports.show', $batch->id)
            ->with('success', 'Data import berhasil dibaca. Silakan review sebelum disetujui.');
    }

    public function show(InventarisImportBatch $batch): View
    {
        $batch->load(['creator', 'reviewer', 'rows' => fn ($query) => $query->orderBy('row_number')]);
        $jenisModals = JenisModal::pluck('nama_jenis_modal', 'id');
        $jurusans = Jurusan::pluck('nama_jurusan', 'id');
        $ruangans = Ruangan::pluck('nama_ruangan', 'id');

        return view('inventaris.import-approval', compact('batch', 'jenisModals', 'jurusans', 'ruangans'));
    }

    public function editRow(InventarisImportBatch $batch, InventarisImportRow $row): View
    {
        $this->ensureRowBelongsToBatch($batch, $row);

        if ($batch->status !== 'pending') {
            abort(403, 'Batch import sudah diproses dan tidak dapat diedit.');
        }

        $jenisModals = JenisModal::orderBy('nama_jenis_modal')->get();
        $jurusans = Jurusan::orderBy('nama_jurusan')->get();
        $ruangans = Ruangan::with('jurusan')->orderBy('nama_ruangan')->get();

        return view('inventaris.import-row-edit', compact('batch', 'row', 'jenisModals', 'jurusans', 'ruangans'));
    }

    public function updateRow(Request $request, InventarisImportBatch $batch, InventarisImportRow $row): RedirectResponse
    {
        $this->ensureRowBelongsToBatch($batch, $row);

        if ($batch->status !== 'pending') {
            return redirect()
                ->route('inventaris.imports.show', $batch->id)
                ->with('error', 'Batch import sudah diproses dan tidak dapat diedit.');
        }

        $payload = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'merek' => 'required|string|max:100',
            'type' => 'nullable|string|max:255',
            'spesifikasi' => 'required|string',
            'bahan' => 'nullable|string|max:255',
            'warna' => 'nullable|string|max:255',
            'jenis_modal_id' => 'required|string',
            'jurusan_id' => 'required|string',
            'ruangan_id' => 'required|string',
            'jumlah_total' => 'required|integer|min:0',
            'harga_satuan' => 'required|integer|min:0',
            'sumber_dana' => 'nullable|string|max:255',
            'nama_penyedia' => 'nullable|string|max:255',
            'nomor_surat_bast' => 'nullable|string|max:255',
            'kondisi' => 'required|in:baik,layak,rusak',
            'tanggal_pengadaan' => 'required|date',
            'foto_url' => 'nullable|url|max:2048',
        ]);

        $errors = $this->validatePayload($payload);

        DB::transaction(function () use ($batch, $row, $payload, $errors) {
            $row->update([
                'payload' => $payload,
                'validation_errors' => $errors === [] ? null : $errors,
            ]);

            $this->refreshBatchCounts($batch);
        });

        return redirect()
            ->route('inventaris.imports.show', $batch->id)
            ->with($errors === [] ? 'success' : 'warning', $errors === []
                ? 'Data baris import berhasil diperbaiki dan sekarang valid.'
                : 'Data baris import tersimpan, tetapi masih ada kesalahan validasi.');
    }

    public function approve(InventarisImportBatch $batch): RedirectResponse
    {
        $batch->load('rows');

        if ($batch->status !== 'pending') {
            return back()->with('error', 'Batch import ini sudah diproses.');
        }

        if ($batch->invalid_rows > 0) {
            return back()->with('error', 'Batch import masih memiliki data tidak valid. Tolak batch ini lalu perbaiki file import.');
        }

        DB::transaction(function () use ($batch) {
            $reservedCodes = [];

            foreach ($batch->rows as $row) {
                $payload = $row->payload;
                $kodeInventaris = InventarisCodeGenerator::generate($payload['nama_barang'], $reservedCodes);
                $reservedCodes[] = $kodeInventaris;

                $inventaris = Inventaris::create([
                    'kode_inventaris' => $kodeInventaris,
                    'nama_barang' => $payload['nama_barang'],
                    'merek' => $payload['merek'],
                    'type' => $payload['type'] ?? null,
                    'spesifikasi' => $payload['spesifikasi'],
                    'bahan' => $payload['bahan'] ?? null,
                    'warna' => $payload['warna'] ?? null,
                    'jenis_modal_id' => $payload['jenis_modal_id'],
                    'jurusan_id' => $payload['jurusan_id'],
                    'ruangan_id' => $payload['ruangan_id'],
                    'jumlah_total' => (int) $payload['jumlah_total'],
                    'harga_satuan' => (int) $payload['harga_satuan'],
                    'sumber_dana' => $payload['sumber_dana'] ?? null,
                    'nama_penyedia' => $payload['nama_penyedia'] ?? null,
                    'nomor_surat_bast' => $payload['nomor_surat_bast'] ?? null,
                    'kondisi' => $payload['kondisi'],
                    'tanggal_pengadaan' => $payload['tanggal_pengadaan'],
                    'foto_url' => $payload['foto_url'] ?? null,
                ]);

                $row->update([
                    'status' => 'approved',
                    'inventaris_id' => $inventaris->id,
                ]);
            }

            $batch->update([
                'status' => 'approved',
                'reviewed_by' => auth()->id(),
                'reviewed_at' => now(),
                'review_note' => 'Disetujui dan dimasukkan ke data inventaris.',
            ]);
        });

        return redirect()
            ->route('inventaris.index')
            ->with('success', 'Import inventaris disetujui dan data berhasil ditambahkan.');
    }

    public function reject(Request $request, InventarisImportBatch $batch): RedirectResponse
    {
        $validated = $request->validate([
            'review_note' => 'nullable|string|max:1000',
        ]);

        if ($batch->status !== 'pending') {
            return back()->with('error', 'Batch import ini sudah diproses.');
        }

        DB::transaction(function () use ($batch, $validated) {
            $batch->rows()->update(['status' => 'rejected']);
            $batch->update([
                'status' => 'rejected',
                'reviewed_by' => auth()->id(),
                'reviewed_at' => now(),
                'review_note' => $validated['review_note'] ?? 'Ditolak.',
            ]);
        });

        return redirect()
            ->route('inventaris.imports.create')
            ->with('success', 'Batch import inventaris ditolak.');
    }

    public function template(string $format, InventarisSpreadsheetService $spreadsheet)
    {
        return $spreadsheet->downloadTemplate($format);
    }

    public function export(string $format, InventarisSpreadsheetService $spreadsheet)
    {
        $inventaris = Inventaris::with(['jenisModal', 'jurusan', 'ruangan'])
            ->orderBy('nama_barang')
            ->get();

        return $spreadsheet->downloadInventaris($format, $inventaris);
    }

    private function validatePayload(array $payload): array
    {
        $errors = [];
        $required = array_values(array_diff(InventarisSpreadsheetService::HEADERS, [
            'foto_url',
            'bahan',
            'warna',
            'sumber_dana',
            'nama_penyedia',
            'nomor_surat_bast',
            'type',
        ]));

        foreach ($required as $field) {
            if (!isset($payload[$field]) || trim((string) $payload[$field]) === '') {
                $errors[] = $field . ' wajib diisi.';
            }
        }

        if ($errors !== []) {
            return $errors;
        }

        if (!JenisModal::whereKey($payload['jenis_modal_id'])->exists()) {
            $errors[] = 'jenis_modal_id tidak ditemukan.';
        }

        if (!Jurusan::whereKey($payload['jurusan_id'])->exists()) {
            $errors[] = 'jurusan_id tidak ditemukan.';
        }

        $ruangan = Ruangan::whereKey($payload['ruangan_id'])->first();
        if (!$ruangan) {
            $errors[] = 'ruangan_id tidak ditemukan.';
        } elseif ($ruangan->jurusan_id !== $payload['jurusan_id']) {
            $errors[] = 'ruangan_id tidak sesuai dengan jurusan_id.';
        }

        if (filter_var($payload['jumlah_total'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 0]]) === false) {
            $errors[] = 'jumlah_total harus berupa angka minimal 0.';
        }

        if (filter_var($payload['harga_satuan'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 0]]) === false) {
            $errors[] = 'harga_satuan harus berupa angka minimal 0.';
        }

        if (!in_array($payload['kondisi'], ['baik', 'layak', 'rusak'], true)) {
            $errors[] = 'kondisi harus salah satu dari: baik, layak, rusak.';
        }

        if (!strtotime($payload['tanggal_pengadaan'])) {
            $errors[] = 'tanggal_pengadaan harus berupa tanggal valid, contoh: 2026-06-04.';
        }

        if (($payload['foto_url'] ?? '') !== '' && filter_var($payload['foto_url'], FILTER_VALIDATE_URL) === false) {
            $errors[] = 'foto_url harus berupa URL valid.';
        }

        return $errors;
    }

    private function refreshBatchCounts(InventarisImportBatch $batch): void
    {
        $validRows = $batch->rows()->whereNull('validation_errors')->count();
        $invalidRows = $batch->rows()->whereNotNull('validation_errors')->count();

        $batch->update([
            'valid_rows' => $validRows,
            'invalid_rows' => $invalidRows,
            'total_rows' => $validRows + $invalidRows,
        ]);
    }

    private function ensureRowBelongsToBatch(InventarisImportBatch $batch, InventarisImportRow $row): void
    {
        if ($row->batch_id !== $batch->id) {
            abort(404);
        }
    }
}
