<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buku Induk Inventaris</title>
    <link rel="icon" type="image/png" href="{{ asset('image/icon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@100..900&family=Geist+Mono:wght@100..900&display=swap" rel="stylesheet">
    <style>
        @page {
            size: A4 landscape;
            margin: 8mm 8mm 10mm 8mm;
        }

        * {
            box-sizing: border-box;
            font-family: "Geist", ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }

        body {
            background-color: #f4f4f5;
            margin: 0;
            padding: 20px;
            color: #1e293b;
            font-size: 10px;
        }

        .no-print-toolbar {
            max-width: 1300px;
            margin: 0 auto 20px auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #ffffff;
            padding: 12px 20px;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            border: none;
            transition: background-color 0.15s ease;
        }

        .btn-back {
            background-color: #f4f4f5;
            color: #3f3f46;
        }

        .btn-back:hover {
            background-color: #e4e4e7;
        }

        .btn-print {
            background-color: #18181b;
            color: #ffffff;
        }

        .btn-print:hover {
            background-color: #27272a;
        }

        .paper-container {
            max-width: 1300px;
            margin: 0 auto;
            background: #ffffff;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            border-radius: 4px;
        }

        .header-title {
            text-align: center;
            margin-bottom: 18px;
        }

        .header-title h1 {
            font-size: 17px;
            font-weight: 800;
            margin: 0 0 4px 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            text-decoration: underline;
            text-underline-offset: 3px;
        }

        .header-subtitle {
            font-size: 11px;
            color: #475569;
            font-weight: 500;
            margin: 0;
        }

        .category-block {
            margin-bottom: 18px;
            page-break-inside: avoid;
        }

        .category-title-bar {
            background-color: #1e293b;
            color: #ffffff;
            font-weight: 800;
            font-size: 11px;
            padding: 6px 10px;
            letter-spacing: 0.5px;
            border-radius: 2px 2px 0 0;
            text-transform: uppercase;
        }

        table.buku-induk-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9.5px;
            table-layout: auto;
            border: 1px solid #cbd5e1;
        }

        table.buku-induk-table th {
            background-color: #f8fafc;
            color: #334155;
            font-weight: 700;
            text-align: center;
            vertical-align: middle;
            padding: 5px 4px;
            border: 1px solid #cbd5e1;
        }

        table.buku-induk-table td {
            padding: 4px 6px;
            border: 1px solid #cbd5e1;
            color: #334155;
            vertical-align: middle;
            text-align: center;
        }

        table.buku-induk-table td.text-left {
            text-align: left;
        }

        table.buku-induk-table td.text-right {
            text-align: right;
        }

        table.buku-induk-table tr.col-numbers td {
            background-color: #f1f5f9;
            font-family: 'Geist Mono', monospace;
            font-size: 8.5px;
            color: #64748b;
            font-weight: 600;
            padding: 2px;
        }

        .subtotal-row td {
            background-color: #f8fafc;
            font-weight: 700;
            color: #0f172a;
            border-top: 1px solid #94a3b8;
            border-bottom: 1px solid #cbd5e1;
        }

        .grand-total-bar {
            background-color: #eff6ff;
            border: 1.5px solid #bfdbfe;
            padding: 10px 14px;
            border-radius: 4px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
            margin-bottom: 24px;
            page-break-inside: avoid;
        }

        .signatures-container {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
            page-break-inside: avoid;
            font-size: 11px;
        }

        .sig-block {
            width: 250px;
            text-align: center;
        }

        .sig-title {
            font-weight: 600;
            margin-top: 2px;
        }

        .sig-space {
            height: 65px;
        }

        .sig-name {
            font-weight: 700;
            text-decoration: underline;
        }

        @media print {
            body {
                background-color: #ffffff;
                padding: 0;
            }

            .no-print-toolbar {
                display: none !important;
            }

            .paper-container {
                box-shadow: none;
                padding: 0;
                width: 100%;
                max-width: 100%;
            }

            table.buku-induk-table {
                page-break-inside: auto;
            }

            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }
        }
    </style>
</head>
<body>

    {{-- Toolbar Top --}}
    <div class="no-print-toolbar">
        <a href="{{ route('inventaris.index') }}" class="btn btn-back">
            &larr; Kembali ke Inventaris
        </a>

        <form method="GET" action="{{ route('inventaris.print-buku-induk') }}" style="display: flex; align-items: center; gap: 8px;">
            @if(request('search')) <input type="hidden" name="search" value="{{ request('search') }}"> @endif
            @if(request('jenis_modal_id')) <input type="hidden" name="jenis_modal_id" value="{{ request('jenis_modal_id') }}"> @endif
            @if(request('kategori_id')) <input type="hidden" name="kategori_id" value="{{ request('kategori_id') }}"> @endif
            @if(request('jurusan_id')) <input type="hidden" name="jurusan_id" value="{{ request('jurusan_id') }}"> @endif
            @if(request('ruangan_id')) <input type="hidden" name="ruangan_id" value="{{ request('ruangan_id') }}"> @endif

            <label for="filter-tahun" style="font-weight: 600; color: #3f3f46; font-size: 13px;">Filter Tahun:</label>
            <select id="filter-tahun" name="tahun" onchange="this.form.submit()" style="padding: 6px 12px; border-radius: 6px; border: 1px solid #d4d4d8; font-size: 13px; font-weight: 500; background-color: #ffffff; color: #18181b; cursor: pointer;">
                <option value="all" {{ ($selectedTahun === 'all' || empty($selectedTahun)) ? 'selected' : '' }}>Semua Tahun (Cetak Semua Data)</option>
                @foreach($availableYears as $yr)
                    <option value="{{ $yr }}" {{ (string) $selectedTahun === (string) $yr ? 'selected' : '' }}>
                        Tahun {{ $yr }}
                    </option>
                @endforeach
            </select>
        </form>

        <button onclick="window.print()" class="btn btn-print">
            🖨️ Cetak Buku Induk
        </button>
    </div>

    {{-- Main Document Container --}}
    <div class="paper-container">
        <div class="header-title">
            <h1>BUKU INDUK INVENTARIS</h1>
            <p class="header-subtitle">
                Tahun: {{ ($selectedTahun && $selectedTahun !== 'all') ? $selectedTahun : 'Semua Tahun' }}
                &nbsp;|&nbsp;
                Dicetak: {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('d M Y') }}
            </p>
        </div>

        @php
            // Standard 6 KIB Categories
            $categories = [
                'A' => [
                    'title' => 'A. TANAH',
                    'items' => collect(),
                    'keywords' => ['tanah']
                ],
                'B' => [
                    'title' => 'B. PERALATAN DAN MESIN',
                    'items' => collect(),
                    'keywords' => ['peralatan', 'mesin']
                ],
                'C' => [
                    'title' => 'C. GEDUNG DAN BANGUNAN',
                    'items' => collect(),
                    'keywords' => ['gedung', 'bangunan']
                ],
                'D' => [
                    'title' => 'D. JALAN, IRIGASI DAN JARINGAN',
                    'items' => collect(),
                    'keywords' => ['jalan', 'irigasi', 'jaringan']
                ],
                'E' => [
                    'title' => 'E. ASET TETAP LAINNYA',
                    'items' => collect(),
                    'keywords' => ['lainnya', 'buku', 'kesenian', 'hewan']
                ],
                'F' => [
                    'title' => 'F. KONSTRUKSI DALAM PENGERJAAN',
                    'items' => collect(),
                    'keywords' => ['konstruksi', 'pengerjaan']
                ],
            ];

            foreach ($items as $item) {
                $namaModal = strtolower($item->jenisModal->nama_jenis_modal ?? '');
                $assigned = false;

                foreach ($categories as $key => &$cat) {
                    foreach ($cat['keywords'] as $kw) {
                        if ($kw !== '' && str_contains($namaModal, $kw)) {
                            $cat['items']->push($item);
                            $assigned = true;
                            break 2;
                        }
                    }
                }
                unset($cat);

                if (!$assigned) {
                    $categories['B']['items']->push($item);
                }
            }

            $grandTotalHarga = 0;
        @endphp

        {{-- Loop categories A to F --}}
        @foreach($categories as $catKey => $catData)
            @php
                $catSubtotal = 0;
                $catVolume = 0;
            @endphp

            <div class="category-block">
                <div class="category-title-bar">
                    {{ $catData['title'] }}
                </div>

                <table class="buku-induk-table">
                    <thead>
                        <tr>
                            <th rowspan="2" style="width: 26px;">No.</th>
                            <th rowspan="2" style="width: 80px;">Kode Barang</th>
                            <th rowspan="2" style="width: 100px;">Jenis Modal</th>
                            <th rowspan="2" style="width: 85px;">Kategori</th>
                            <th rowspan="2" style="width: 80px;">Tanggal Catat Aset</th>
                            <th colspan="5">Spesifikasi Barang</th>
                            <th colspan="4">Rincian Harga</th>
                            <th colspan="2">Dokumen</th>
                            <th rowspan="2" style="width: 50px;">Kondisi</th>
                        </tr>
                        <tr>
                            <th style="width: 100px;">Nama Barang</th>
                            <th style="width: 60px;">Merk</th>
                            <th style="width: 60px;">Type</th>
                            <th style="width: 55px;">Bahan</th>
                            <th style="width: 55px;">Warna</th>
                            <th style="width: 40px;">Volume</th>
                            <th style="width: 45px;">Satuan</th>
                            <th style="width: 70px;">Harga Satuan</th>
                            <th style="width: 75px;">Jumlah</th>
                            <th style="width: 90px;">Nomor BAST</th>
                            <th style="width: 80px;">Tanggal BAST</th>
                        </tr>
                        <tr class="col-numbers">
                            <td>1</td>
                            <td>2</td>
                            <td>3</td>
                            <td>4</td>
                            <td>5</td>
                            <td>6</td>
                            <td>7</td>
                            <td>8</td>
                            <td>9</td>
                            <td>10</td>
                            <td>11</td>
                            <td>12</td>
                            <td>13</td>
                            <td>14</td>
                            <td>15</td>
                            <td>16</td>
                            <td>17</td>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($catData['items'] as $index => $item)
                            @php
                                $subtotalItem = $item->harga_satuan * $item->jumlah_total;
                                $catSubtotal += $subtotalItem;
                                $catVolume += $item->jumlah_total;
                                $grandTotalHarga += $subtotalItem;
                            @endphp
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td style="font-family: 'Geist Mono', monospace; font-size: 9px;">{{ $item->kode_inventaris }}</td>
                                <td class="text-left">{{ $item->jenisModal->nama_jenis_modal ?? '-' }}</td>
                                <td class="text-left">{{ $item->kategori->nama_kategori ?? '-' }}</td>
                                <td style="white-space: nowrap;">{{ $item->tanggal_catat_aset ? $item->tanggal_catat_aset->translatedFormat('d F Y') : '-' }}</td>
                                <td class="text-left"><strong>{{ $item->nama_barang }}</strong></td>
                                <td class="text-left">{{ $item->merek ?: '-' }}</td>
                                <td class="text-left">{{ $item->type ?: '-' }}</td>
                                <td>{{ $item->bahan ?: '-' }}</td>
                                <td>{{ $item->warna ?: '-' }}</td>
                                <td>{{ number_format($item->jumlah_total, 0, ',', '.') }}</td>
                                <td>unit</td>
                                <td class="text-right">{{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                                <td class="text-right">{{ number_format($subtotalItem, 0, ',', '.') }}</td>
                                <td>{{ $item->nomor_surat_bast ?: '-' }}</td>
                                <td style="white-space: nowrap;">{{ $item->tanggal_bast ? $item->tanggal_bast->translatedFormat('d F Y') : '-' }}</td>
                                <td>
                                    @if($item->kondisi === 'baik')
                                        Baik
                                    @elseif($item->kondisi === 'layak')
                                        Layak Pakai
                                    @elseif($item->kondisi === 'rusak_ringan')
                                        Rusak Ringan
                                    @elseif($item->kondisi === 'rusak_sedang')
                                        Rusak Sedang
                                    @elseif($item->kondisi === 'rusak_berat' || $item->kondisi === 'rusak')
                                        Rusak
                                    @else
                                        {{ ucfirst($item->kondisi ?? '-') }}
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="17" style="text-align: center; color: #64748b; font-style: italic; padding: 10px;">
                                    Tidak ada data
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr class="subtotal-row">
                            <td colspan="10" style="text-align: center; font-weight: 700;">SUB TOTAL</td>
                            <td style="font-weight: 700;">{{ number_format($catVolume, 0, ',', '.') }}</td>
                            <td></td>
                            <td></td>
                            <td class="text-right" style="font-weight: 700;">Rp {{ number_format($catSubtotal, 0, ',', '.') }}</td>
                            <td colspan="3"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        @endforeach

        {{-- Grand Total Keseluruhan --}}
        <div class="grand-total-bar">
            <div style="font-weight: 800; font-size: 11.5px; color: #1e3a8a;">
                TOTAL KESELURUHAN NILAI ASET (A + B + C + D + E + F)
            </div>
            <div style="font-weight: 800; font-size: 13.5px; color: #1e3a8a;">
                Rp {{ number_format($grandTotalHarga, 0, ',', '.') }}
            </div>
        </div>

        {{-- Signature Block --}}
        <div class="signatures-container">
            <div class="sig-block">
                <p style="margin:0;">Mengetahui</p>
                <p class="sig-title" style="margin:2px 0 0 0;">Kepala Sekolah</p>
                <div class="sig-space"></div>
                <p class="sig-name" style="margin:0;">....................................</p>
                <p style="margin:2px 0 0 0;">NIP. ....................</p>
            </div>
            <div class="sig-block">
                <p style="margin:0;">Surabaya, {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y') }}</p>
                <p class="sig-title" style="margin:2px 0 0 0;">Pengurus Barang</p>
                <div class="sig-space"></div>
                <p class="sig-name" style="margin:0;">....................................</p>
                <p style="margin:2px 0 0 0;">NIP. ....................</p>
            </div>
        </div>
    </div>

</body>
</html>
