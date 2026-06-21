<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Label Massal - {{ count($items) }} Barang</title>
    @vite(['resources/css/app.css'])
    <style>
        /* CSS for Screen Preview */
        body {
            background-color: #f4f4f5;
        }
        .label-card {
            width: 8cm;
            height: 8cm;
            background-color: white;
            border: 1px solid #e4e4e7;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
            padding: 0.4cm;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
            text-align: center;
        }
        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(8cm, 1fr));
            gap: 1.5rem;
            width: 100%;
            max-width: 1200px;
            justify-content: center;
        }
        .text-header {
            font-size: 14px;
            font-weight: 800;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            border-bottom: 1px solid #e4e4e7;
            width: 100%;
            padding-bottom: 4px;
            line-height: 1;
        }
        .qr-image {
            width: 4.5cm;
            height: 4.5cm;
            object-fit: contain;
        }
        .text-code {
            font-size: 14px;
            font-family: monospace;
            font-weight: 700;
            background-color: #f4f4f5;
            padding: 4px 8px;
            border-radius: 4px;
            line-height: 1;
            width: 100%;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .text-name {
            font-size: 13px;
            font-weight: 700;
            color: #27272a;
            line-height: 1.25;
            width: 100%;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .text-location {
            font-size: 10px;
            font-weight: 500;
            color: #71717a;
            text-transform: uppercase;
            width: 100%;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* CSS for Printing (Each card automatically occupies its own page) */
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                background-color: white !important;
                color: black !important;
                margin: 0 !important;
                padding: 0 !important;
            }
            .grid-container {
                display: block !important; /* Disable grid during print */
            }
            .label-card {
                box-shadow: none !important;
                border: none !important;
                page-break-after: always !important;
                break-after: page !important;
                
                width: 100vw !important;
                height: 100vh !important;
                padding: 2cm !important;
                box-sizing: border-box !important;
                
                display: flex !important;
                flex-direction: column !important;
                align-items: center !important;
                justify-content: space-between !important;
            }
            .text-header {
                font-size: 3.5vw !important;
                border-bottom-width: 3px !important;
                padding-bottom: 15px !important;
                width: 100% !important;
            }
            .qr-image {
                width: 42vh !important;
                height: 42vh !important;
                max-width: 55vw !important;
                max-height: 55vw !important;
                margin: 1.5cm 0 !important;
            }
            .text-code {
                font-size: 3.5vw !important;
                padding: 15px 30px !important;
                border-radius: 8px !important;
                width: 100% !important;
            }
            .text-name {
                font-size: 3.2vw !important;
                margin-top: 10px !important;
                width: 100% !important;
            }
            .text-location {
                font-size: 2.5vw !important;
                margin-top: 5px !important;
                width: 100% !important;
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
                <!-- Header: School Name / App Name -->
                <div class="text-header">
                    SMKN 2 SURABAYA
                </div>
                
                <!-- QR Code Image -->
                <div class="flex items-center justify-center my-0.5">
                    @if ($item->qr_code_path && Storage::disk('public')->exists($item->qr_code_path))
                        <img src="{{ asset('storage/' . $item->qr_code_path) }}" alt="QR Code" class="qr-image">
                    @else
                        <div class="qr-image bg-zinc-100 flex items-center justify-center text-xs text-zinc-400">QR Code Error</div>
                    @endif
                </div>

                <!-- Details -->
                <div class="w-full flex flex-col items-center gap-1">
                    <!-- Kode Inventaris -->
                    <div class="text-code">
                        {{ $item->kode_inventaris }}
                    </div>
                    <!-- Nama Barang -->
                    <div class="text-name">
                        {{ $item->nama_barang }}
                    </div>
                    <!-- Lokasi: Ruangan & Jurusan -->
                    <div class="text-location">
                        {{ $item->ruangan->nama_ruangan ?? '-' }} &bull; {{ $item->jurusan->nama_jurusan ?? '-' }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>

</body>
</html>
