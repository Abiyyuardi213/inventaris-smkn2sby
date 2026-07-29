<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KIB E - Aset Tetap Lainnya</title>
    <link rel="icon" type="image/png" href="{{ asset('image/icon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@100..900&family=Geist+Mono:wght@100..900&display=swap" rel="stylesheet">
    <style>
        @page {
            size: A4 landscape;
            margin: 10mm 10mm 12mm 10mm;
        }

        * {
            box-sizing: border-box;
            font-family: "Geist", ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }

        body {
            background-color: #f4f4f5;
            margin: 0;
            padding: 20px;
            color: #18181b;
            font-size: 11px;
        }

        .no-print-toolbar {
            max-width: 1200px;
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
            max-width: 1200px;
            margin: 0 auto;
            background: #ffffff;
            padding: 25px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            border-radius: 4px;
        }

        .header-title {
            text-align: center;
            margin-bottom: 20px;
        }

        .header-title h1 {
            font-size: 16px;
            font-weight: 800;
            margin: 0 0 4px 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .header-title h2 {
            font-size: 14px;
            font-weight: 800;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .location-info {
            font-size: 11px;
            font-weight: 600;
            margin-bottom: 12px;
        }

        table.kib-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
            table-layout: auto;
        }

        table.kib-table th,
        table.kib-table td {
            border: 1px solid #000000;
            padding: 5px 4px;
            text-align: center;
            vertical-align: middle;
            word-wrap: break-word;
        }

        table.kib-table th {
            font-weight: 700;
            background-color: #ffffff;
            text-transform: uppercase;
        }

        table.kib-table td.text-left {
            text-align: left;
        }

        table.kib-table td.text-right {
            text-align: right;
        }

        table.kib-table tr.col-numbers td {
            font-weight: 600;
            background-color: #fafafa;
            font-size: 9px;
            padding: 3px 2px;
        }

        .signatures-container {
            margin-top: 35px;
            display: flex;
            justify-content: space-between;
            page-break-inside: avoid;
            break-inside: avoid;
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
        }

        tfoot {
            display: table-row-group;
        }

        @media print {
            body {
                background-color: #ffffff;
                padding: 0;
                color: #000000;
            }

            .no-print-toolbar {
                display: none !important;
            }

            .paper-container {
                max-width: 100%;
                box-shadow: none;
                padding: 0;
                border-radius: 0;
            }

            tfoot {
                display: table-row-group !important;
            }

            table.kib-table {
                font-size: 9.5px;
            }

            table.kib-table th,
            table.kib-table td {
                padding: 4px 3px;
                border-color: #000000 !important;
            }

            tr {
                page-break-inside: avoid !important;
                break-inside: avoid !important;
            }
        }
    </style>
</head>
<body>

    <div class="no-print-toolbar">
        <a href="{{ route('inventaris.index') }}" class="btn btn-back">
            &larr; Kembali ke Inventaris
        </a>

        <form method="GET" action="{{ route('inventaris.print-kib-e') }}" style="display: flex; align-items: center; gap: 8px;">
            @if(request('search')) <input type="hidden" name="search" value="{{ request('search') }}"> @endif
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
            🖨️ Cetak KIB E
        </button>
    </div>

    <div class="paper-container">
        <div class="header-title">
            <h1>KARTU INVENTARIS BARANG (KIB)</h1>
            <h2>E. ASET TETAP LAINNYA</h2>
            @if($selectedTahun && $selectedTahun !== 'all')
                <p style="margin: 4px 0 0 0; font-weight: 700; font-size: 12px; color: #27272a; text-transform: uppercase;">TAHUN {{ $selectedTahun }}</p>
            @endif
        </div>

        <div class="location-info">
            Nomor Kode Lokasi : .............
        </div>

        <table class="kib-table">
            <thead>
                <tr>
                    <th rowspan="2" style="width: 32px;">No Urut</th>
                    <th rowspan="2" style="width: 140px;">Nama Barang/ Jenis Barang</th>
                    <th colspan="2">Nomor</th>
                    <th colspan="2">Buku / Perpustakaan</th>
                    <th colspan="2">Dokumen</th>
                    <th rowspan="2" style="width: 65px;">Bahan</th>
                    <th colspan="2">Hewan/Ternak dan tumbuhan</th>
                    <th rowspan="2" style="width: 50px;">Jumlah</th>
                    <th rowspan="2" style="width: 75px;">Asal usul cara perolehan</th>
                    <th rowspan="2" style="width: 80px;">Harga</th>
                    <th rowspan="2">Ket</th>
                </tr>
                <tr>
                    <th style="width: 85px;">Kode barang</th>
                    <th style="width: 55px;">Nomor register</th>
                    <th style="width: 100px;">Judul/pencipta</th>
                    <th style="width: 90px;">Spesifikasi</th>
                    <th style="width: 60px;">Tgl</th>
                    <th style="width: 75px;">Nomor</th>
                    <th style="width: 60px;">Jenis</th>
                    <th style="width: 60px;">Ukuran</th>
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
                </tr>
            </thead>
            <tbody>
                @php($totalHarga = 0)
                @php($totalJumlah = 0)
                @forelse ($items as $index => $item)
                    @php($subtotal = $item->harga_satuan * $item->jumlah_total)
                    @php($totalHarga += $subtotal)
                    @php($totalJumlah += $item->jumlah_total)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td class="text-left">{{ $item->nama_barang }}</td>
                        <td style="font-family: 'Geist Mono', monospace; font-size: 9.5px;">{{ $item->kode_inventaris }}</td>
                        <td>{{ str_pad($index + 1, 4, '0', STR_PAD_LEFT) }}</td>
                        <td class="text-left">{{ $item->merek ?: '-' }}</td>
                        <td class="text-left">{{ $item->spesifikasi ?: '-' }}</td>
                        <td>{{ optional($item->tanggal_bast ?? $item->tanggal_catat_aset)->format('d/m/Y') ?? '-' }}</td>
                        <td>{{ $item->nomor_surat_bast ?: '-' }}</td>
                        <td>{{ $item->bahan ?: '-' }}</td>
                        <td>-</td>
                        <td>-</td>
                        <td>{{ number_format($item->jumlah_total, 0, ',', '.') }}</td>
                        <td>{{ $item->sumber_dana ?: 'APBD' }}</td>
                        <td class="text-right">{{ number_format($subtotal, 0, ',', '.') }}</td>
                        <td class="text-left">{{ $item->ruangan->nama_ruangan ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="15" style="padding: 20px; text-align: center; color: #71717a;">
                            Belum ada data barang Aset Tetap Lainnya (KIB E).
                        </td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr style="font-weight: 700; background-color: #fafafa;">
                    <td colspan="11" style="text-align: center;">Jumlah</td>
                    <td>{{ number_format($totalJumlah, 0, ',', '.') }}</td>
                    <td></td>
                    <td class="text-right">{{ number_format($totalHarga, 0, ',', '.') }}</td>
                    <td></td>
                </tr>
            </tfoot>
        </table>

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
