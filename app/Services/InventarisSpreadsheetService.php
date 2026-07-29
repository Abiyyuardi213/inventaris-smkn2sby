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
        'type',
        'spesifikasi',
        'bahan',
        'warna',
        'jenis_modal_id',
        'kategori_id',
        'jurusan_id',
        'ruangan_id',
        'jumlah_total',
        'harga_satuan',
        'sumber_dana',
        'nama_penyedia',
        'nomor_surat_bast',
        'tanggal_bast',
        'kondisi',
        'tanggal_catat_aset',
        'foto_url',
    ];

    public const EXPORT_HEADERS = [
        'No.',
        'Jenis Barang Modal',
        'Kode Barang',
        'Jenis Modal',
        'Kategori Barang',
        'Nama Barang',
        'Merk',
        'Type',
        'Spesifikasi',
        'Bahan',
        'Warna',
        'Volume',
        'Satuan',
        'Harga Satuan',
        'Jumlah',
        'Lokasi Barang',
        'Nama Penyedia',
        'Tanggal BAST',
        'Nomor Surat BAST',
        'Tanggal Catat Aset',
        'Link Drive Dokumen',
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
                'Zhepirus GL 532 GD',
                'Intel Core i5, RAM 8GB, SSD 512GB',
                'Plastik dan logam',
                'Hitam',
                'isi-dengan-jenis_modal_id',
                'isi-dengan-kategori_id',
                'isi-dengan-jurusan_id',
                'isi-dengan-ruangan_id',
                1,
                8500000,
                'BOS',
                'PT Contoh Penyedia',
                'BAST/001/2026',
                now()->toDateString(),
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

        foreach ($inventaris as $index => $item) {
            $rows[] = [
                $index + 1,
                'Modal Peralatan dan Mesin',
                $item->kode_inventaris,
                $item->jenisModal?->nama_jenis_modal ?? '',
                $item->kategori?->nama_kategori ?? '',
                $item->nama_barang,
                $item->merek,
                $item->type,
                $item->spesifikasi,
                $item->bahan,
                $item->warna,
                $item->jumlah_total,
                'Unit',
                $item->harga_satuan ?? 0,
                $item->harga_total,
                trim(($item->ruangan?->nama_ruangan ?? '') . (($item->jurusan?->nama_jurusan ?? '') !== '' ? ' - ' . $item->jurusan->nama_jurusan : '')),
                $item->nama_penyedia,
                optional($item->tanggal_bast)->format('Y-m-d'),
                $item->nomor_surat_bast,
                optional($item->tanggal_catat_aset)->format('Y-m-d'),
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

        if (in_array($header, ['tanggal_catat_aset', 'tanggal_bast'], true) && is_numeric($value)) {
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
        $zip->addFromString('xl/styles.xml', $this->stylesXml());
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
            $rowNumber = $rowIndex + 1;
            $style = $rowIndex === 0 ? '1' : '2';
            $xmlRows .= '<row r="' . $rowNumber . '">';
            foreach (array_values($row) as $columnIndex => $value) {
                $cell = $this->columnName($columnIndex) . $rowNumber;
                $xmlRows .= '<c r="' . $cell . '" s="' . $style . '" t="inlineStr"><is><t>' . e((string) $value) . '</t></is></c>';
            }
            $xmlRows .= '</row>';
        }

        $lastColumn = $this->columnName(count($rows[0] ?? []) - 1);
        $lastRow = max(count($rows), 1);
        $columns = $this->exportColumnWidthsXml();

        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">'
            . '<dimension ref="A1:' . $lastColumn . $lastRow . '"/>'
            . '<sheetViews><sheetView workbookViewId="0"><pane ySplit="1" topLeftCell="A2" activePane="bottomLeft" state="frozen"/></sheetView></sheetViews>'
            . $columns
            . '<sheetData>' . $xmlRows . '</sheetData>'
            . '</worksheet>';
    }

    private function exportColumnWidthsXml(): string
    {
        $widths = [
            4,
            24,
            14,
            18,
            22,
            12,
            18,
            26,
            12,
            10,
            10,
            10,
            15,
            15,
            24,
            18,
            20,
            28,
            16,
            28,
        ];

        $cols = '<cols>';
        foreach ($widths as $index => $width) {
            $column = $index + 1;
            $cols .= '<col min="' . $column . '" max="' . $column . '" width="' . $width . '" customWidth="1"/>';
        }

        return $cols . '</cols>';
    }

    private function contentTypesXml(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">'
            . '<Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>'
            . '<Default Extension="xml" ContentType="application/xml"/>'
            . '<Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/>'
            . '<Override PartName="/xl/worksheets/sheet1.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/>'
            . '<Override PartName="/xl/styles.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.styles+xml"/>'
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
            . '<Relationship Id="rId2" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles" Target="styles.xml"/>'
            . '</Relationships>';
    }

    private function stylesXml(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<styleSheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">'
            . '<fonts count="2">'
            . '<font><sz val="11"/><name val="Calibri"/></font>'
            . '<font><b/><sz val="11"/><name val="Calibri"/><color rgb="FF000000"/></font>'
            . '</fonts>'
            . '<fills count="3">'
            . '<fill><patternFill patternType="none"/></fill>'
            . '<fill><patternFill patternType="gray125"/></fill>'
            . '<fill><patternFill patternType="solid"><fgColor rgb="FFD9EAF7"/><bgColor indexed="64"/></patternFill></fill>'
            . '</fills>'
            . '<borders count="2">'
            . '<border><left/><right/><top/><bottom/><diagonal/></border>'
            . '<border><left style="thin"><color rgb="FF000000"/></left><right style="thin"><color rgb="FF000000"/></right><top style="thin"><color rgb="FF000000"/></top><bottom style="thin"><color rgb="FF000000"/></bottom><diagonal/></border>'
            . '</borders>'
            . '<cellStyleXfs count="1"><xf numFmtId="0" fontId="0" fillId="0" borderId="0"/></cellStyleXfs>'
            . '<cellXfs count="3">'
            . '<xf numFmtId="0" fontId="0" fillId="0" borderId="0" xfId="0"/>'
            . '<xf numFmtId="0" fontId="1" fillId="2" borderId="1" xfId="0" applyFont="1" applyFill="1" applyBorder="1" applyAlignment="1"><alignment horizontal="center" vertical="center" wrapText="1"/></xf>'
            . '<xf numFmtId="0" fontId="0" fillId="0" borderId="1" xfId="0" applyBorder="1" applyAlignment="1"><alignment vertical="center" wrapText="1"/></xf>'
            . '</cellXfs>'
            . '<cellStyles count="1"><cellStyle name="Normal" xfId="0" builtinId="0"/></cellStyles>'
            . '</styleSheet>';
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
