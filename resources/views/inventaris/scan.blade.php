@extends('layouts.app')

@section('title', 'Cek Inventaris - Inventaris SMKN 2 SBY')
@section('page_title', 'Cek Inventaris')

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
        <span class="font-medium text-zinc-900">Cek Inventaris</span>
    </nav>

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-zinc-900">Cek Inventaris</h2>
            <p class="text-sm text-zinc-500">Pindai QR code label inventaris untuk memeriksa dan melihat detail lengkap aset sekolah.</p>
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

            <section id="result-card" class="hidden rounded-lg border border-zinc-200 bg-white p-6 shadow-sm space-y-6">
                <!-- Main Header (Nama Barang & Tempat) -->
                <div class="border-b border-zinc-100 pb-4">
                    <p class="text-[11px] font-bold uppercase tracking-widest text-emerald-600">Inventaris Ditemukan</p>
                    <h3 id="result-name" class="mt-1.5 text-xl font-extrabold text-zinc-900 leading-tight"></h3>
                    
                    <div class="mt-2 flex items-center gap-2 text-sm text-zinc-600">
                        <svg class="w-4 h-4 text-zinc-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25s-7.5-4.108-7.5-11.25a7.5 7.5 0 1 1 15 0Z" />
                        </svg>
                        <span id="result-main-location" class="font-semibold text-zinc-800"></span>
                    </div>

                    <div class="mt-3.5 flex flex-wrap gap-2 items-center">
                        <span id="result-code" class="inline-flex items-center rounded-md bg-zinc-100 px-2.5 py-1 text-xs font-mono font-semibold text-zinc-800 border border-zinc-200"></span>
                        <span id="result-condition" class="rounded-full px-2.5 py-1 text-[11px] font-bold"></span>
                    </div>
                </div>

                <!-- Detail Grid -->
                <div class="space-y-4">
                    <h4 class="text-xs font-bold text-zinc-400 uppercase tracking-wider">Rincian Informasi Aset</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                        <div class="rounded-md border border-zinc-100 bg-zinc-50/50 p-3">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-zinc-400 block">Kategori</span>
                            <span id="result-kategori" class="mt-1 font-semibold text-zinc-800 block"></span>
                        </div>
                        <div class="rounded-md border border-zinc-100 bg-zinc-50/50 p-3">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-zinc-400 block">Merek</span>
                            <span id="result-brand" class="mt-1 font-semibold text-zinc-800 block"></span>
                        </div>
                        <div class="rounded-md border border-zinc-100 bg-zinc-50/50 p-3">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-zinc-400 block">Bahan</span>
                            <span id="result-bahan" class="mt-1 font-semibold text-zinc-800 block"></span>
                        </div>
                        <div class="rounded-md border border-zinc-100 bg-zinc-50/50 p-3">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-zinc-400 block">Warna</span>
                            <span id="result-warna" class="mt-1 font-semibold text-zinc-800 block"></span>
                        </div>
                        <div class="rounded-md border border-zinc-100 bg-zinc-50/50 p-3">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-zinc-400 block">Jumlah Unit</span>
                            <span id="result-qty" class="mt-1 font-semibold text-zinc-800 block"></span>
                        </div>
                        <div class="rounded-md border border-zinc-100 bg-zinc-50/50 p-3">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-zinc-400 block">Tanggal Pengadaan</span>
                            <span id="result-tanggal" class="mt-1 font-semibold text-zinc-800 block"></span>
                        </div>
                        <div class="rounded-md border border-zinc-100 bg-zinc-50/50 p-3">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-zinc-400 block">Harga Satuan</span>
                            <span id="result-harga-satuan" class="mt-1 font-semibold text-zinc-800 block"></span>
                        </div>
                        <div class="rounded-md border border-zinc-100 bg-zinc-50/50 p-3">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-zinc-400 block">Harga Total</span>
                            <span id="result-harga-total" class="mt-1 font-semibold text-zinc-800 block"></span>
                        </div>
                        <div class="rounded-md border border-zinc-100 bg-zinc-50/50 p-3">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-zinc-400 block">Sumber Dana</span>
                            <span id="result-sumber-dana" class="mt-1 font-semibold text-zinc-800 block"></span>
                        </div>
                        <div class="rounded-md border border-zinc-100 bg-zinc-50/50 p-3">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-zinc-400 block">Nama Penyedia</span>
                            <span id="result-nama-penyedia" class="mt-1 font-semibold text-zinc-800 block"></span>
                        </div>
                        <div class="rounded-md border border-zinc-100 bg-zinc-50/50 p-3 sm:col-span-2">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-zinc-400 block">Nomor Surat BAST</span>
                            <span id="result-nomor-bast" class="mt-1 font-semibold text-zinc-800 block"></span>
                        </div>
                        <div class="rounded-md border border-zinc-100 bg-zinc-50/50 p-3 sm:col-span-2">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-zinc-400 block">Spesifikasi Detail</span>
                            <span id="result-spec" class="mt-1 font-medium text-zinc-700 block whitespace-pre-line leading-relaxed"></span>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-zinc-100">
                    <a id="result-link" href="#"
                        class="inline-flex h-10 w-full items-center justify-center rounded-md bg-zinc-900 px-4 text-sm font-semibold text-white shadow-sm hover:bg-zinc-800">
                        Buka Detail Aset (Edit/Ubah)
                    </a>
                </div>
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

    async function preferredCameraId() {
        const cameras = await Html5Qrcode.getCameras();

        if (!cameras.length) {
            throw new Error('Tidak ada kamera yang terdeteksi pada perangkat ini.');
        }

        const rearCamera = cameras.find((camera) => {
            const label = (camera.label || '').toLowerCase();

            return label.includes('back') ||
                label.includes('rear') ||
                label.includes('environment') ||
                label.includes('belakang');
        });

        return (rearCamera ?? cameras[0]).id;
    }

    function stopScanner(resetState = true) {
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

        if (resetState) {
            setScannerState('Kamera belum aktif.', 'Siap');
        }
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
            
            // Set main location
            const roomName = item.ruangan ?? '-';
            const unitName = item.jurusan ?? '';
            document.getElementById('result-main-location').textContent = roomName + (unitName ? ` - ${unitName}` : '');

            document.getElementById('result-code').textContent = item.kode_inventaris ?? '-';
            document.getElementById('result-kategori').textContent = item.kategori ?? '-';
            document.getElementById('result-brand').textContent = item.merek ?? '-';
            document.getElementById('result-bahan').textContent = item.bahan ?? '-';
            document.getElementById('result-warna').textContent = item.warna ?? '-';
            document.getElementById('result-qty').textContent = `${item.jumlah_total ?? 0} Unit`;
            document.getElementById('result-tanggal').textContent = item.tanggal_pengadaan ?? '-';
            document.getElementById('result-harga-satuan').textContent = item.harga_satuan ?? '-';
            document.getElementById('result-harga-total').textContent = item.harga_total ?? '-';
            document.getElementById('result-sumber-dana').textContent = item.sumber_dana ?? '-';
            document.getElementById('result-nama-penyedia').textContent = item.nama_penyedia ?? '-';
            document.getElementById('result-nomor-bast').textContent = item.nomor_surat_bast ?? '-';
            document.getElementById('result-spec').textContent = item.spesifikasi ?? '-';
            document.getElementById('result-link').href = payload.redirect_url;

            const condition = document.getElementById('result-condition');
            const conditionLabel = item.kondisi ?? '-';
            condition.textContent = conditionLabel;
            condition.className = 'rounded-full px-2.5 py-1 text-[11px] font-bold uppercase tracking-wider ' + (
                conditionLabel === 'baik'
                    ? 'bg-emerald-50 text-emerald-700 border border-emerald-200'
                    : conditionLabel === 'rusak'
                        ? 'bg-red-50 text-red-700 border border-red-200'
                        : 'bg-amber-50 text-amber-700 border border-amber-200'
            );

            resultCard.classList.remove('hidden');
            showMessage('Data inventaris berhasil ditemukan. Berikut rincian data lengkap aset.', 'success');
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
                const cameraId = await preferredCameraId();

                await html5QrCode.start(
                    cameraId,
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
            showMessage(`Kamera tidak dapat diakses. Pastikan izin kamera diizinkan di browser. Detail: ${error?.message ?? error}`, 'error');
            setScannerState('Kamera tidak dapat diakses.', 'Ditolak', 'border-red-200 bg-red-50 text-red-700');
            stopScanner(false);
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
