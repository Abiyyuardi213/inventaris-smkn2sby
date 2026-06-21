@extends('layouts.app')

@section('title', 'Scan Inventaris - Inventaris SMKN 2 SBY')
@section('page_title', 'Scan Inventaris')

@section('content')
<div class="space-y-6">
    <nav class="flex items-center gap-1.5 text-sm text-zinc-500">
        <a href="{{ route('dashboard') }}" class="hover:text-zinc-900 transition-colors">Dashboard</a>
        <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
        </svg>
        <a href="{{ route('inventaris.index') }}" class="hover:text-zinc-900 transition-colors">Inventaris</a>
        <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
        </svg>
        <span class="font-medium text-zinc-900">Scan Inventaris</span>
    </nav>

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-zinc-900">Scan Inventaris</h2>
            <p class="text-sm text-zinc-500">Pindai QR code label inventaris untuk membuka detail aset sekolah.</p>
        </div>
        <a href="{{ route('inventaris.index') }}"
            class="inline-flex h-10 items-center justify-center gap-2 rounded-md border border-zinc-200 bg-white px-4 text-sm font-medium text-zinc-700 shadow-sm hover:bg-zinc-50">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
            </svg>
            Daftar Inventaris
        </a>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-[minmax(320px,460px)_minmax(0,1fr)] gap-6 items-start">
        <section class="rounded-lg border border-zinc-200 bg-white shadow-sm overflow-hidden w-full max-w-[460px] mx-auto xl:mx-0">
            <div class="border-b border-zinc-100 px-5 py-4 flex items-center justify-between gap-3">
                <div>
                    <h3 class="text-sm font-semibold text-zinc-900">Kamera Scanner</h3>
                    <p id="scanner-status" class="mt-0.5 text-xs text-zinc-500">Kamera belum aktif.</p>
                </div>
                <span id="scanner-badge" class="rounded-full border border-zinc-200 bg-zinc-50 px-2.5 py-1 text-[11px] font-semibold text-zinc-500">Siap</span>
            </div>

            <div class="p-4 space-y-4">
                <div class="relative overflow-hidden rounded-lg border border-zinc-200 bg-zinc-950 aspect-[3/4] max-h-[560px] min-h-[360px]">
                    <div id="qr-reader" class="absolute inset-0 [&_video]:h-full [&_video]:w-full [&_video]:object-cover [&_div]:border-0"></div>
                    <video id="scanner-video" class="absolute inset-0 h-full w-full object-cover" playsinline muted></video>
                    <div class="pointer-events-none absolute inset-0 flex items-center justify-center">
                        <div class="h-52 w-52 sm:h-64 sm:w-64 max-w-[78%] rounded-2xl border-2 border-white/80 shadow-[0_0_0_999px_rgba(0,0,0,0.32)]"></div>
                    </div>
                    <div id="camera-placeholder" class="absolute inset-0 flex flex-col items-center justify-center bg-zinc-950 text-center text-white">
                        <svg class="h-12 w-12 text-zinc-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574v7.302A2.25 2.25 0 0 0 4.5 19.126h15a2.25 2.25 0 0 0 2.25-2.25V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316A2.25 2.25 0 0 0 14.444 3.75H9.556a2.25 2.25 0 0 0-1.908 1.059l-.821 1.316Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0Z" />
                        </svg>
                        <p class="mt-3 text-sm font-semibold">Aktifkan kamera untuk mulai scan</p>
                        <p class="mt-1 max-w-sm text-xs text-zinc-400">Arahkan QR code label ke area tengah kamera.</p>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-2">
                    <button type="button" id="start-scan"
                        class="inline-flex h-10 flex-1 items-center justify-center gap-2 rounded-md bg-zinc-900 px-4 text-sm font-semibold text-white shadow-sm hover:bg-zinc-800">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574v7.302A2.25 2.25 0 0 0 4.5 19.126h15a2.25 2.25 0 0 0 2.25-2.25V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316A2.25 2.25 0 0 0 14.444 3.75H9.556a2.25 2.25 0 0 0-1.908 1.059l-.821 1.316Z" />
                        </svg>
                        Mulai Scan
                    </button>
                    <button type="button" id="stop-scan"
                        class="inline-flex h-10 items-center justify-center gap-2 rounded-md border border-zinc-200 bg-white px-4 text-sm font-semibold text-zinc-700 shadow-sm hover:bg-zinc-50 disabled:cursor-not-allowed disabled:opacity-50"
                        disabled>
                        Berhenti
                    </button>
                </div>
            </div>
        </section>

        <aside class="space-y-4">
            <section class="rounded-lg border border-zinc-200 bg-white p-5 shadow-sm">
                <h3 class="text-sm font-semibold text-zinc-900">Input Manual</h3>
                <p class="mt-1 text-xs text-zinc-500">Gunakan jika kamera tidak tersedia. Masukkan kode inventaris atau tempel URL hasil QR.</p>
                <form id="manual-form" class="mt-4 space-y-3">
                    <input id="manual-value" type="text" autocomplete="off"
                        class="h-10 w-full rounded-md border border-zinc-200 bg-white px-3 text-sm text-zinc-900 placeholder:text-zinc-400 focus:outline-none focus:ring-2 focus:ring-zinc-950"
                        placeholder="Contoh: INV-PC-RPL-001">
                    <button type="submit"
                        class="inline-flex h-10 w-full items-center justify-center rounded-md bg-zinc-900 px-4 text-sm font-semibold text-white shadow-sm hover:bg-zinc-800">
                        Cari Inventaris
                    </button>
                </form>
            </section>

            <section id="result-card" class="hidden rounded-lg border border-zinc-200 bg-white p-5 shadow-sm">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-[11px] font-bold uppercase tracking-widest text-emerald-600">Inventaris Ditemukan</p>
                        <h3 id="result-name" class="mt-1 text-lg font-bold text-zinc-900"></h3>
                        <p id="result-code" class="mt-1 inline-flex rounded-md bg-zinc-100 px-2 py-1 font-mono text-xs font-semibold text-zinc-700"></p>
                    </div>
                    <span id="result-condition" class="rounded-full px-2.5 py-1 text-[11px] font-bold"></span>
                </div>

                <dl class="mt-5 grid grid-cols-2 gap-3 text-sm">
                    <div class="rounded-md border border-zinc-100 bg-zinc-50 p-3">
                        <dt class="text-[10px] font-bold uppercase tracking-wider text-zinc-400">Merek</dt>
                        <dd id="result-brand" class="mt-1 font-semibold text-zinc-800"></dd>
                    </div>
                    <div class="rounded-md border border-zinc-100 bg-zinc-50 p-3">
                        <dt class="text-[10px] font-bold uppercase tracking-wider text-zinc-400">Jumlah</dt>
                        <dd id="result-qty" class="mt-1 font-semibold text-zinc-800"></dd>
                    </div>
                    <div class="rounded-md border border-zinc-100 bg-zinc-50 p-3">
                        <dt class="text-[10px] font-bold uppercase tracking-wider text-zinc-400">Ruangan</dt>
                        <dd id="result-room" class="mt-1 font-semibold text-zinc-800"></dd>
                    </div>
                    <div class="rounded-md border border-zinc-100 bg-zinc-50 p-3">
                        <dt class="text-[10px] font-bold uppercase tracking-wider text-zinc-400">Unit Kerja</dt>
                        <dd id="result-unit" class="mt-1 font-semibold text-zinc-800"></dd>
                    </div>
                </dl>

                <a id="result-link" href="#"
                    class="mt-5 inline-flex h-10 w-full items-center justify-center rounded-md bg-zinc-900 px-4 text-sm font-semibold text-white shadow-sm hover:bg-zinc-800">
                    Buka Detail Inventaris
                </a>
            </section>

            <section id="message-card" class="rounded-lg border border-zinc-200 bg-zinc-50 p-5 text-sm text-zinc-600">
                Hasil scan akan tampil di sini.
            </section>
        </aside>
    </div>
</div>

<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script>
    const qrReader = document.getElementById('qr-reader');
    const video = document.getElementById('scanner-video');
    const placeholder = document.getElementById('camera-placeholder');
    const startButton = document.getElementById('start-scan');
    const stopButton = document.getElementById('stop-scan');
    const statusText = document.getElementById('scanner-status');
    const badge = document.getElementById('scanner-badge');
    const resultCard = document.getElementById('result-card');
    const messageCard = document.getElementById('message-card');
    const manualForm = document.getElementById('manual-form');
    const manualValue = document.getElementById('manual-value');

    let stream = null;
    let detector = null;
    let scanLoop = null;
    let html5QrCode = null;
    let html5ScannerActive = false;
    let resolving = false;
    let lastValue = '';
    let lastScanAt = 0;

    function setScannerState(text, badgeText, badgeClass = 'border-zinc-200 bg-zinc-50 text-zinc-500') {
        statusText.textContent = text;
        badge.textContent = badgeText;
        badge.className = `rounded-full border px-2.5 py-1 text-[11px] font-semibold ${badgeClass}`;
    }

    function showMessage(text, type = 'info') {
        const classes = {
            info: 'rounded-lg border border-zinc-200 bg-zinc-50 p-5 text-sm text-zinc-600',
            error: 'rounded-lg border border-red-200 bg-red-50 p-5 text-sm font-medium text-red-700',
            success: 'rounded-lg border border-emerald-200 bg-emerald-50 p-5 text-sm font-medium text-emerald-700',
        };

        messageCard.className = classes[type] ?? classes.info;
        messageCard.textContent = text;
        messageCard.classList.remove('hidden');
    }

    function qrboxSize(viewfinderWidth, viewfinderHeight) {
        const minEdge = Math.min(viewfinderWidth, viewfinderHeight);
        const size = Math.max(220, Math.min(340, Math.floor(minEdge * 0.78)));

        return { width: size, height: size };
    }

    function scannerConfig() {
        const config = {
            fps: 24,
            qrbox: qrboxSize,
            aspectRatio: 0.75,
            disableFlip: false,
            rememberLastUsedCamera: true,
        };

        if ('Html5QrcodeSupportedFormats' in window) {
            config.formatsToSupport = [Html5QrcodeSupportedFormats.QR_CODE];
        }

        return config;
    }

    function stopScanner() {
        if (html5QrCode && html5ScannerActive) {
            html5QrCode.stop()
                .then(() => html5QrCode.clear())
                .catch(() => {})
                .finally(() => {
                    html5ScannerActive = false;
                });
        }

        if (scanLoop) {
            cancelAnimationFrame(scanLoop);
            scanLoop = null;
        }

        if (stream) {
            stream.getTracks().forEach((track) => track.stop());
            stream = null;
        }

        video.srcObject = null;
        video.classList.remove('hidden');
        placeholder.classList.remove('hidden');
        startButton.disabled = false;
        stopButton.disabled = true;
        setScannerState('Kamera belum aktif.', 'Siap');
    }

    async function resolveInventaris(value) {
        if (!value || resolving) return;

        const now = Date.now();
        if (value === lastValue && now - lastScanAt < 1200) return;

        resolving = true;
        lastValue = value;
        lastScanAt = now;
        setScannerState('QR terbaca, mencocokkan data inventaris...', 'Mencari', 'border-sky-200 bg-sky-50 text-sky-700');

        try {
            const response = await fetch(`{{ route('inventaris.scan.resolve') }}?value=${encodeURIComponent(value)}`, {
                headers: { 'Accept': 'application/json' },
            });

            const payload = await response.json();

            if (!response.ok || !payload.found) {
                resultCard.classList.add('hidden');
                showMessage(payload.message ?? 'Data inventaris tidak ditemukan.', 'error');
                setScannerState('Scan selesai, data tidak ditemukan.', 'Tidak ditemukan', 'border-red-200 bg-red-50 text-red-700');
                return;
            }

            const item = payload.item;
            document.getElementById('result-name').textContent = item.nama_barang ?? '-';
            document.getElementById('result-code').textContent = item.kode_inventaris ?? '-';
            document.getElementById('result-brand').textContent = item.merek ?? '-';
            document.getElementById('result-qty').textContent = `${item.jumlah_total ?? 0} unit`;
            document.getElementById('result-room').textContent = item.ruangan ?? '-';
            document.getElementById('result-unit').textContent = item.jurusan ?? '-';
            document.getElementById('result-link').href = payload.redirect_url;

            const condition = document.getElementById('result-condition');
            const conditionLabel = item.kondisi ?? '-';
            condition.textContent = conditionLabel;
            condition.className = 'rounded-full px-2.5 py-1 text-[11px] font-bold ' + (
                conditionLabel === 'baik'
                    ? 'bg-emerald-50 text-emerald-700 border border-emerald-200'
                    : conditionLabel === 'rusak'
                        ? 'bg-red-50 text-red-700 border border-red-200'
                        : 'bg-amber-50 text-amber-700 border border-amber-200'
            );

            resultCard.classList.remove('hidden');
            showMessage('Data inventaris berhasil ditemukan. Silakan buka detail untuk melihat informasi lengkap.', 'success');
            setScannerState('Data inventaris ditemukan.', 'Berhasil', 'border-emerald-200 bg-emerald-50 text-emerald-700');

            if (html5QrCode && html5ScannerActive) {
                try {
                    html5QrCode.pause(true);
                } catch (error) {}
            }
        } catch (error) {
            showMessage('Terjadi kesalahan saat membaca hasil scan.', 'error');
            setScannerState('Gagal memproses hasil scan.', 'Error', 'border-red-200 bg-red-50 text-red-700');
        } finally {
            resolving = false;
        }
    }

    async function tick() {
        if (!detector || !video.srcObject || video.readyState < 2) {
            scanLoop = requestAnimationFrame(tick);
            return;
        }

        try {
            const barcodes = await detector.detect(video);
            const qr = barcodes.find((barcode) => barcode.rawValue);

            if (qr?.rawValue) {
                await resolveInventaris(qr.rawValue);
            }
        } catch (error) {
            showMessage('Scanner gagal membaca frame kamera. Coba ulangi atau gunakan input manual.', 'error');
        }

        scanLoop = requestAnimationFrame(tick);
    }

    async function startScanner() {
        try {
            if ('Html5Qrcode' in window) {
                html5QrCode = html5QrCode ?? new Html5Qrcode('qr-reader');
                placeholder.classList.add('hidden');
                video.classList.add('hidden');
                startButton.disabled = true;
                stopButton.disabled = false;
                lastValue = '';
                setScannerState('Kamera aktif. Arahkan QR code ke kotak tengah.', 'Scanning', 'border-emerald-200 bg-emerald-50 text-emerald-700');
                showMessage('Scanner aktif. QR yang berhasil dibaca akan dicocokkan otomatis.', 'info');

                await html5QrCode.start(
                    {
                        facingMode: { ideal: 'environment' },
                        width: { ideal: 1280 },
                        height: { ideal: 720 },
                    },
                    scannerConfig(),
                    (decodedText) => resolveInventaris(decodedText),
                    () => {}
                );

                html5ScannerActive = true;
                return;
            }

            if (!('BarcodeDetector' in window)) {
                showMessage('Scanner kamera tidak dapat dimuat. Pastikan koneksi internet tersedia untuk memuat library scanner, atau gunakan input manual.', 'error');
                setScannerState('Scanner kamera tidak tersedia.', 'Manual', 'border-amber-200 bg-amber-50 text-amber-700');
                return;
            }

            detector = new BarcodeDetector({ formats: ['qr_code'] });
            stream = await navigator.mediaDevices.getUserMedia({
                video: {
                    facingMode: { ideal: 'environment' },
                    width: { ideal: 1280 },
                    height: { ideal: 720 },
                },
                audio: false,
            });

            video.srcObject = stream;
            await video.play();

            placeholder.classList.add('hidden');
            startButton.disabled = true;
            stopButton.disabled = false;
            lastValue = '';
            setScannerState('Kamera aktif. Arahkan QR code ke kotak tengah.', 'Scanning', 'border-emerald-200 bg-emerald-50 text-emerald-700');
            showMessage('Scanner aktif. QR yang berhasil dibaca akan dicocokkan otomatis.', 'info');
            scanLoop = requestAnimationFrame(tick);
        } catch (error) {
            showMessage('Kamera tidak dapat diakses. Pastikan izin kamera diberikan dan halaman berjalan di HTTPS atau localhost.', 'error');
            setScannerState('Kamera tidak dapat diakses.', 'Ditolak', 'border-red-200 bg-red-50 text-red-700');
            stopScanner();
        }
    }

    startButton.addEventListener('click', startScanner);
    stopButton.addEventListener('click', stopScanner);

    manualForm.addEventListener('submit', async (event) => {
        event.preventDefault();
        lastValue = '';
        await resolveInventaris(manualValue.value.trim());
    });

    window.addEventListener('beforeunload', stopScanner);
</script>
@endsection
