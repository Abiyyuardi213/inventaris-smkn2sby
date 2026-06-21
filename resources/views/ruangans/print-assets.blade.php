<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Daftar Aset - {{ $ruangan->nama_ruangan }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@100..900&family=Geist+Mono:wght@100..900&display=swap" rel="stylesheet">
    <style>
        @page {
            size: A4 landscape;
            margin: 12mm 14mm;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background:
                radial-gradient(circle at top left, rgba(16, 185, 129, 0.08), transparent 34%),
                linear-gradient(180deg, #f8fafc 0%, #e5e7eb 100%);
            color: #111827;
            font-family: "Geist", Arial, Helvetica, sans-serif;
            font-size: 11px;
        }

        .toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            max-width: 1180px;
            margin: 18px auto 14px;
            padding: 12px;
            border: 1px solid #e4e4e7;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.86);
            box-shadow: 0 10px 28px rgba(15, 23, 42, 0.08);
            backdrop-filter: blur(10px);
        }

        .toolbar-title {
            min-width: 0;
        }

        .toolbar-title strong {
            display: block;
            font-size: 14px;
            line-height: 1.2;
        }

        .toolbar-title span {
            display: block;
            margin-top: 2px;
            color: #71717a;
            font-size: 12px;
            font-weight: 500;
        }

        .toolbar-actions {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .toolbar a,
        .toolbar button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            height: 36px;
            border-radius: 8px;
            border: 1px solid #d4d4d8;
            background: #ffffff;
            color: #27272a;
            padding: 0 13px;
            font: 700 12px "Geist", Arial, Helvetica, sans-serif;
            text-decoration: none;
            cursor: pointer;
            box-shadow: 0 1px 2px rgba(15, 23, 42, 0.04);
            transition: background 150ms ease, border-color 150ms ease, transform 150ms ease;
        }

        .toolbar a:hover,
        .toolbar button:hover {
            transform: translateY(-1px);
        }

        .toolbar button {
            border-color: #18181b;
            background: #18181b;
            color: #ffffff;
        }

        .sheet {
            position: relative;
            max-width: 1180px;
            min-height: 760px;
            margin: 0 auto 28px;
            background: #ffffff;
            padding: 24px 28px 28px;
            border: 1px solid #e4e4e7;
            box-shadow: 0 24px 65px rgba(15, 23, 42, 0.14);
        }

        .sheet::before {
            content: "";
            position: absolute;
            inset: 0 0 auto 0;
            height: 6px;
            background: linear-gradient(90deg, #047857, #22c55e, #bef264);
        }

        .letterhead {
            display: grid;
            grid-template-columns: 92px 1fr 92px;
            align-items: center;
            min-height: 108px;
            border-bottom: 2px solid #111827;
            padding: 4px 0 12px;
            text-align: center;
        }

        .logo {
            width: 78px;
            height: 78px;
            object-fit: contain;
            justify-self: center;
        }

        .letterhead .kicker {
            margin: 0 0 2px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.2px;
        }

        .letterhead .title {
            margin: 0;
            font-size: 15px;
            font-weight: 800;
            letter-spacing: 0.4px;
        }

        .letterhead .school {
            margin: 2px 0;
            font-size: 15px;
            font-weight: 800;
            letter-spacing: 0.4px;
        }

        .letterhead .address,
        .letterhead .contact {
            margin: 1px 0;
            font-size: 9px;
            line-height: 1.35;
        }

        .document-title {
            margin: 14px 0 12px;
            text-align: center;
        }

        .document-title h1 {
            margin: 0;
            font-size: 14px;
            font-weight: 800;
            text-decoration: underline;
            text-transform: uppercase;
        }

        .document-title p {
            margin: 3px 0 0;
            font-size: 11px;
            font-weight: 700;
        }

        .meta {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 8px;
            width: 100%;
            margin: 0 0 12px;
            font-size: 10px;
            line-height: 1.35;
        }

        .meta-item {
            border: 1px solid #d4d4d8;
            border-radius: 6px;
            background: #fafafa;
            padding: 7px 9px;
        }

        .meta-item strong {
            display: block;
            margin-bottom: 2px;
            color: #52525b;
            font-size: 8px;
            font-weight: 800;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .meta-item span {
            display: block;
            color: #111827;
            font-size: 10px;
            font-weight: 700;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            font-size: 9px;
            border: 1.5px solid #111827;
        }

        th,
        td {
            border: 1px solid #111827;
            padding: 4px 5px;
            vertical-align: middle;
            line-height: 1.25;
        }

        th {
            background: #dbeafe;
            text-align: center;
            font-weight: 800;
            text-transform: uppercase;
        }

        tbody tr:nth-child(even) td {
            background: #f8fafc;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .nowrap {
            white-space: nowrap;
        }

        .footer {
            display: grid;
            grid-template-columns: 1fr 220px;
            gap: 24px;
            margin-top: 16px;
            font-size: 10px;
        }

        .signature {
            text-align: center;
        }

        .signature .space {
            height: 54px;
        }

        .summary {
            font-weight: 700;
            line-height: 1.7;
        }

        .summary-box {
            display: inline-block;
            min-width: 210px;
            border: 1px solid #d4d4d8;
            border-radius: 6px;
            background: #fafafa;
            padding: 8px 10px;
        }

        @media print {
            body {
                background: #ffffff;
                font-family: Arial, Helvetica, sans-serif;
            }

            .toolbar {
                display: none;
            }

            .sheet {
                max-width: none;
                min-height: auto;
                margin: 0;
                padding: 0;
                border: 0;
                box-shadow: none;
            }

            .sheet::before {
                display: none;
            }

            .meta-item {
                border-radius: 0;
                background: #ffffff;
            }
        }
    </style>
</head>
<body>
    <div class="toolbar">
        <div class="toolbar-title">
            <strong>Preview Cetak Aset Ruangan</strong>
            <span>{{ $ruangan->nama_ruangan }} - {{ $ruangan->jurusan?->nama_jurusan ?? 'Tanpa Unit Kerja' }}</span>
        </div>
        <div class="toolbar-actions">
            <a href="{{ route('ruangans.monitor') }}">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
                Kembali
            </a>
            <button type="button" onclick="window.print()">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096a42.415 42.415 0 0 0-10.56 0m10.56 0L17.66 18" />
                </svg>
                Print Daftar Aset
            </button>
        </div>
    </div>

    <main class="sheet">
        <header class="letterhead">
            <img src="{{ asset('image/smkn2sby.png') }}" alt="Logo SMK Negeri 2 Surabaya" class="logo">
            <div>
                <p class="kicker">PEMERINTAH PROVINSI JAWA TIMUR</p>
                <p class="kicker">DINAS PENDIDIKAN</p>
                <h2 class="title">SMK NEGERI 2 SURABAYA</h2>
                <h3 class="school">BIDANG KEAHLIAN TEKNOLOGI DAN REKAYASA</h3>
                <p class="address">Jalan Tentara Genie Pelajar No. 26, Sawahan, Surabaya, Jawa Timur</p>
                <p class="contact">Telepon (031) 5343208 | Email: smkn2surabaya@gmail.com</p>
            </div>
            <img src="{{ asset('image/jatim.png') }}" alt="Logo Jawa Timur" class="logo">
        </header>

        <section class="document-title">
            <h1>Pencatatan Aset Sekolah</h1>
            <p>Tahun {{ now()->format('Y') }}</p>
        </section>

        <section class="meta">
            <div class="meta-item">
                <strong>Ruang</strong>
                <span>{{ $ruangan->nama_ruangan }}</span>
            </div>
            <div class="meta-item">
                <strong>Unit Kerja</strong>
                <span>{{ $ruangan->jurusan?->nama_jurusan ?? '-' }}</span>
            </div>
            <div class="meta-item">
                <strong>Kode Unit</strong>
                <span>{{ $ruangan->jurusan?->kode_jurusan ?? '-' }}</span>
            </div>
            <div class="meta-item">
                <strong>Tanggal Cetak</strong>
                <span>{{ now()->format('d F Y') }}</span>
            </div>
        </section>

        <table>
            <thead>
                <tr>
                    <th style="width: 34px;">No.</th>
                    <th style="width: 90px;">Tgl. Catat Aset</th>
                    <th style="width: 132px;">Kode Barang<br>(Lap. Inventaris)</th>
                    <th style="width: 150px;">Kode Aset Sekolah</th>
                    <th>Nama Barang</th>
                    <th style="width: 98px;">Merek</th>
                    <th style="width: 50px;">Jumlah</th>
                    <th style="width: 90px;">Hrg. Barang</th>
                    <th style="width: 96px;">Harga Total</th>
                    <th style="width: 78px;">Kondisi</th>
                    <th style="width: 120px;">Kategori</th>
                    <th style="width: 120px;">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($ruangan->inventaris as $item)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-center nowrap">{{ $item->created_at?->format('d F Y') ?? '-' }}</td>
                        <td class="text-center">{{ $item->kode_inventaris }}</td>
                        <td class="text-center">{{ $item->kode_inventaris }}</td>
                        <td>
                            <strong>{{ $item->nama_barang }}</strong>
                            @if ($item->spesifikasi)
                                <br>{{ $item->spesifikasi }}
                            @endif
                        </td>
                        <td class="text-center">{{ $item->merek ?: '-' }}</td>
                        <td class="text-center">{{ $item->jumlah_total }}</td>
                        <td class="text-center">Rp {{ number_format($item->harga_satuan ?? 0, 0, ',', '.') }}</td>
                        <td class="text-center">Rp {{ number_format($item->harga_total, 0, ',', '.') }}</td>
                        <td class="text-center">{{ ucfirst($item->kondisi) }}</td>
                        <td>{{ $item->kategori?->nama_kategori ?? '-' }}</td>
                        <td>{{ $item->ruangan?->nama_ruangan ?? $ruangan->nama_ruangan }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="12" class="text-center">Belum ada aset di ruangan ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <footer class="footer">
            <div class="summary">
                <div class="summary-box">
                    <div>Jumlah jenis aset: {{ $ruangan->inventaris->count() }}</div>
                    <div>Total unit aset: {{ $totalUnit }}</div>
                </div>
            </div>
            <div class="signature">
                <div>Surabaya, {{ now()->format('d F Y') }}</div>
                <div>Petugas Inventaris</div>
                <div class="space"></div>
                <div>( ____________________ )</div>
            </div>
        </footer>
    </main>

    <script>
        window.addEventListener('load', () => {
            window.print();
        });
    </script>
</body>
</html>
