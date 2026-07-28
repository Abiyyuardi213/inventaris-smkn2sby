<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Label Massal - {{ count($items) }} Barang</title>
    <link rel="icon" type="image/png" href="{{ asset('image/icon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@100..900&family=Geist+Mono:wght@100..900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
    <style>
        /* CSS for Screen Preview */
        body {
            background-color: #f4f4f5;
            font-family: "Geist", ui-sans-serif, system-ui, sans-serif;
        }
        .label-card {
            width: 8.8cm;
            height: 3.1cm;
            background-color: white;
            border: 1.5px solid #111827;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
            padding: 0;
            display: grid;
            grid-template-columns: 1.55cm 1fr 2.25cm;
            align-items: center;
            text-align: center;
            overflow: hidden;
        }
        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(8.8cm, 1fr));
            gap: 0.8rem;
            width: 100%;
            max-width: 1200px;
            justify-content: center;
        }
        .label-logo,
        .label-info,
        .label-qr {
            height: 100%;
        }
        .label-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            border-right: 1.5px solid #111827;
            padding: 0.04cm;
        }
        .label-logo img {
            width: 1.42cm;
            height: 2.78cm;
            object-fit: contain;
        }
        .label-info {
            display: grid;
            grid-template-rows: 0.9cm 0.9cm 1fr;
            min-width: 0;
        }
        .label-row {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 0;
            border-bottom: 1.5px solid #111827;
            padding: 0 0.14cm;
        }
        .label-row:last-child {
            border-bottom: 0;
        }
        .text-header {
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 0;
            text-transform: uppercase;
            width: 100%;
            line-height: 1.1;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .qr-image {
            width: 1.72cm;
            height: 1.72cm;
            object-fit: contain;
        }
        .label-qr {
            display: flex;
            align-items: center;
            justify-content: center;
            border-left: 1.5px solid #111827;
            padding: 0.12cm;
        }
        .text-code {
            font-size: 10px;
            font-family: "Geist Mono", ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
            font-weight: 700;
            background-color: transparent;
            padding: 0;
            border-radius: 0;
            line-height: 1.1;
            width: 100%;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .text-name {
            font-size: 9px;
            font-weight: 700;
            color: #18181b;
            line-height: 1.25;
            width: 100%;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            margin-bottom: 1px;
        }
        .text-room {
            font-size: 8px;
            font-weight: 500;
            color: #71717a;
            line-height: 1.2;
            width: 100%;
            white-space: normal;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* CSS for Printing (Each card avoids breaking across pages) */
        @media print {
            @page {
                size: A4 landscape;
                margin: 8mm 6mm;
            }
            .no-print {
                display: none !important;
            }
            html, body {
                background-color: white !important;
                color: black !important;
                font-family: "Geist", Arial, Helvetica, sans-serif !important;
                margin: 0 !important;
                padding: 0 !important;
                width: 100% !important;
                height: auto !important;
                overflow: visible !important;
            }
            .grid-container {
                display: grid !important;
                grid-template-columns: repeat(3, 8.8cm) !important;
                gap: 3.5mm 4mm !important;
                align-items: start !important;
                justify-content: start !important;
                max-width: none !important;
                width: 100% !important;
                height: auto !important;
                overflow: visible !important;
            }
            .label-card {
                box-shadow: none !important;
                border: 1.5px solid #111827 !important;
                page-break-inside: avoid !important;
                break-inside: avoid !important;
                page-break-after: auto !important;
                break-after: auto !important;
                width: 8.8cm !important;
                height: 3.1cm !important;
                padding: 0 !important;
                display: grid !important;
                grid-template-columns: 1.55cm 1fr 2.25cm !important;
                box-sizing: border-box !important;
                overflow: hidden !important;
            }
            .text-header {
                font-size: 10px !important;
            }
            .qr-image {
                width: 1.72cm !important;
                height: 1.72cm !important;
                max-width: none !important;
                max-height: none !important;
                margin: 0 !important;
            }
            .text-code {
                font-size: 10px !important;
                padding: 0 !important;
            }
            .text-name {
                font-size: 9px !important;
            }
            .text-room {
                font-size: 8px !important;
            }
        }
    </style>
</head>
<body class="p-6 antialiased font-sans flex flex-col items-center">

    <!-- Control Panel (Hidden when printed) -->
    <div class="no-print w-full max-w-4xl bg-white border border-zinc-200 rounded-xl p-5 mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 shadow-sm">
        <div>
            <h1 class="text-lg font-bold text-zinc-900">Cetak Label Massal</h1>
            <p class="text-xs text-zinc-500 mt-0.5">Siap mencetak <span class="font-bold text-zinc-800">{{ count($items) }}</span> label barang inventaris (Setiap label akan dicetak pada halaman terpisah).</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('inventaris.index') }}" class="inline-flex items-center gap-1.5 rounded-md border border-zinc-200 bg-white px-4 py-2 text-xs font-semibold text-zinc-700 hover:bg-zinc-50 transition-colors shadow-sm">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
                Kembali
            </a>
            <button onclick="window.print()" class="inline-flex items-center gap-1.5 rounded-md bg-zinc-900 px-5 py-2.5 text-xs font-extrabold text-white hover:bg-zinc-800 transition-colors shadow-md cursor-pointer">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096a42.415 42.415 0 0 0-10.56 0m10.56 0L17.66 18m0 0a2.25 2.25 0 0 1-2.25 2.25H8.59A2.25 2.25 0 0 1 6.34 18m11.318-5.318a4.5 4.5 0 1 0-6.364-6.364 4.5 4.5 0 0 0 6.364 6.364Z" />
                </svg>
                Mulai Cetak
            </button>
        </div>
    </div>

    <!-- Grid Container -->
    <div class="grid-container">
        @foreach ($items as $item)
            <!-- Label Card -->
            <div class="label-card">
                <div class="label-logo">
                    <img src="{{ asset('image/smkn2sby.png') }}" alt="Logo SMKN 2 Surabaya">
                </div>

                <div class="label-info">
                    <div class="label-row">
                        <div class="text-header">SMK NEGERI 2 SURABAYA</div>
                    </div>
                    <div class="label-row">
                        <div class="text-code">{{ $item->kode_inventaris }}</div>
                    </div>
                    <div class="label-row">
                        <div class="w-full">
                            <div class="text-name">{{ $item->nama_barang }}</div>
                            <div class="text-room">{{ $item->ruangan->nama_ruangan ?? '-' }}</div>
                        </div>
                    </div>
                </div>

                <div class="label-qr">
                    @if ($item->qr_code_path && Storage::disk('public')->exists($item->qr_code_path))
                        <img src="{{ asset('storage/' . $item->qr_code_path) }}" alt="QR Code" class="qr-image">
                    @else
                        <div class="qr-image bg-zinc-100 flex items-center justify-center text-xs text-zinc-400">QR Code Error</div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

</body>
</html>
