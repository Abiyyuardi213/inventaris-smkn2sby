<?php

namespace App\Services;

use App\Models\Inventaris;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Response as ResponseFactory;
use Illuminate\Support\Str;
use ZipArchive;

class InventarisSpreadsheetService
{
    public const HEADERS = [
        'nama_barang',
        'merek',
        'spesifikasi',
        'kategori_id',
        'jurusan_id',
        'ruangan_id',
        'jumlah_total',
        'harga_satuan',
        'sumber_dana',
        'kondisi',
        'tanggal_pengadaan',
        'foto_url',
    ];

    public const EXPORT_HEADERS = [
        'kode_inventaris',
        'nama_barang',
        'merek',
        'spesifikasi',
        'kategori_id',
        'jurusan_id',
        'ruangan_id',
        'jumlah_total',
        'harga_satuan',
        'sumber_dana',
        'harga_total',
        'kondisi',
        'tanggal_pengadaan',
        'foto_url',
    ];

    public function parse(string $path, string $extension): array
    {
        return match (strtolower($extension)) {
            'csv' => $this->parseCsv($path),
            'xlsx' => $this->parseXlsx($path),
            default => throw new \InvalidArgumentException('Format file harus CSV atau XLSX.'),
        };
    }

    public function downloadTemplate(string $format): Response
    {
        $rows = [
            self::HEADERS,
            [
                'Laptop Praktikum',
                'Asus',
                'Intel Core i5, RAM 8GB, SSD 512GB',
                'isi-dengan-kategori_id',
                'isi-dengan-jurusan_id',
                'isi-dengan-ruangan_id',
                1,
                8500000,
                'BOS',
                'baik',
                now()->toDateString(),
                'https://drive.google.com/file/d/FILE_ID/view',
            ],
        ];

        return $format === 'csv'
            ? $this->downloadCsv('template_import_inventaris.csv', $rows)
            : $this->downloadXlsx('template_import_inventaris.xlsx', $rows);
    }

    public function downloadInventaris(string $format, Collection $inventaris): Response
    {
        $rows = [self::EXPORT_HEADERS];

        foreach ($inventaris as $item) {
            $rows[] = [
                $item->kode_inventaris,
                $item->nama_barang,
                $item->merek,
                $item->spesifikasi,
                $item->kategori_id,
                $item->jurusan_id,
                $item->ruangan_id,
                $item->jumlah_total,
                $item->harga_satuan ?? 0,
                $item->sumber_dana,
                $item->harga_total,
                $item->kondisi,
                optional($item->tanggal_pengadaan)->format('Y-m-d'),
                $item->foto_url,
            ];
        }

        return $format === 'csv'
            ? $this->downloadCsv('inventaris.csv', $rows)
            : $this->downloadXlsx('inventaris.xlsx', $rows);
    }

    private function parseCsv(string $path): array
    {
        $handle = fopen($path, 'r');
        if (!$handle) {
            throw new \RuntimeException('File CSV tidak dapat dibaca.');
        }

        $rows = [];
        while (($row = fgetcsv($handle)) !== false) {
            $rows[] = $row;
        }
        fclose($handle);

        return $this->normalizeRows($rows);
    }

    private function parseXlsx(string $path): array
    {
        $zip = new ZipArchive();
        if ($zip->open($path) !== true) {
            throw new \RuntimeException('File XLSX tidak dapat dibuka.');
        }

        $sharedStrings = $this->readSharedStrings($zip);
        $sheetXml = $zip->getFromName('xl/worksheets/sheet1.xml');
        $zip->close();

        if ($sheetXml === false) {
            throw new \RuntimeException('Sheet pertama tidak ditemukan di file XLSX.');
        }

        $xml = simplexml_load_string($sheetXml);
        if (!$xml) {
            throw new \RuntimeException('Sheet XLSX tidak dapat diproses.');
        }

        $rows = [];
        foreach ($xml->sheetData->row as $row) {
            $cells = [];
            foreach ($row->c as $cell) {
                $ref = (string) $cell['r'];
                $columnIndex = $this->columnIndex($ref);
                $type = (string) $cell['t'];
                $value = (string) ($cell->v ?? '');

                if ($type === 's') {
                    $value = $sharedStrings[(int) $value] ?? '';
                } elseif ($type === 'inlineStr') {
                    $value = (string) ($cell->is->t ?? '');
                }

                $cells[$columnIndex] = $value;
            }

            if ($cells !== []) {
                ksort($cells);
                $max = max(array_keys($cells));
                $rows[] = array_map(fn ($index) => $cells[$index] ?? '', range(0, $max));
            }
        }

        return $this->normalizeRows($rows);
    }

    private function readSharedStrings(ZipArchive $zip): array
    {
        $xmlString = $zip->getFromName('xl/sharedStrings.xml');
        if ($xmlString === false) {
            return [];
        }

        $xml = simplexml_load_string($xmlString);
        if (!$xml) {
            return [];
        }

        $strings = [];
        foreach ($xml->si as $item) {
            if (isset($item->t)) {
                $strings[] = (string) $item->t;
                continue;
            }

            $text = '';
            foreach ($item->r as $run) {
                $text .= (string) $run->t;
            }
            $strings[] = $text;
        }

        return $strings;
    }

    private function normalizeRows(array $rows): array
    {
        $rows = array_values(array_filter($rows, fn ($row) => count(array_filter($row, fn ($value) => trim((string) $value) !== '')) > 0));
        if ($rows === []) {
            return [];
        }

        $headers = array_map(fn ($header) => Str::snake(trim((string) $header)), array_shift($rows));
        $normalized = [];

        foreach ($rows as $index => $row) {
            $payload = [];
            foreach ($headers as $columnIndex => $header) {
                if ($header !== '') {
                    $payload[$header] = $this->normalizeCellValue($header, $row[$columnIndex] ?? '');
                }
            }

            $normalized[] = [
                'row_number' => $index + 2,
                'payload' => collect(self::HEADERS)
                    ->mapWithKeys(fn (string $header) => [$header => $payload[$header] ?? ''])
                    ->all(),
            ];
        }

        return $normalized;
    }

    private function normalizeCellValue(string $header, mixed $value): string
    {
        $value = trim((string) $value);

        if ($header === 'tanggal_pengadaan' && is_numeric($value)) {
            return \Carbon\Carbon::create(1899, 12, 30)
                ->addDays((int) $value)
                ->toDateString();
        }

        return $value;
    }

    private function downloadCsv(string $fileName, array $rows): Response
    {
        $handle = fopen('php://temp', 'r+');
        foreach ($rows as $row) {
            fputcsv($handle, $row);
        }
        rewind($handle);
        $content = stream_get_contents($handle);
        fclose($handle);

        return ResponseFactory::make($content, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ]);
    }

    private function downloadXlsx(string $fileName, array $rows): Response
    {
        $path = tempnam(sys_get_temp_dir(), 'xlsx_');
        $zip = new ZipArchive();
        $zip->open($path, ZipArchive::OVERWRITE);

        $zip->addFromString('[Content_Types].xml', $this->contentTypesXml());
        $zip->addFromString('_rels/.rels', $this->relsXml());
        $zip->addFromString('xl/workbook.xml', $this->workbookXml());
        $zip->addFromString('xl/_rels/workbook.xml.rels', $this->workbookRelsXml());
        $zip->addFromString('xl/worksheets/sheet1.xml', $this->sheetXml($rows));
        $zip->close();

        $content = file_get_contents($path);
        @unlink($path);

        return ResponseFactory::make($content, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ]);
    }

    private function sheetXml(array $rows): string
    {
        $xmlRows = '';
        foreach ($rows as $rowIndex => $row) {
            $xmlRows .= '<row r="' . ($rowIndex + 1) . '">';
            foreach (array_values($row) as $columnIndex => $value) {
                $cell = $this->columnName($columnIndex) . ($rowIndex + 1);
                $xmlRows .= '<c r="' . $cell . '" t="inlineStr"><is><t>' . e((string) $value) . '</t></is></c>';
            }
            $xmlRows .= '</row>';
        }

        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">'
            . '<sheetData>' . $xmlRows . '</sheetData>'
            . '</worksheet>';
    }

    private function contentTypesXml(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">'
            . '<Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>'
            . '<Default Extension="xml" ContentType="application/xml"/>'
            . '<Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/>'
            . '<Override PartName="/xl/worksheets/sheet1.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/>'
            . '</Types>';
    }

    private function relsXml(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'
            . '<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/>'
            . '</Relationships>';
    }

    private function workbookXml(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">'
            . '<sheets><sheet name="Inventaris" sheetId="1" r:id="rId1"/></sheets>'
            . '</workbook>';
    }

    private function workbookRelsXml(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'
            . '<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet1.xml"/>'
            . '</Relationships>';
    }

    private function columnIndex(string $cellRef): int
    {
        preg_match('/([A-Z]+)/', $cellRef, $matches);
        $letters = $matches[1] ?? 'A';
        $index = 0;
        foreach (str_split($letters) as $letter) {
            $index = ($index * 26) + (ord($letter) - 64);
        }

        return $index - 1;
    }

    private function columnName(int $index): string
    {
        $name = '';
        $index++;
        while ($index > 0) {
            $mod = ($index - 1) % 26;
            $name = chr(65 + $mod) . $name;
            $index = intdiv($index - $mod, 26);
        }

        return $name;
    }
}
