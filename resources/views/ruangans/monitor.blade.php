@extends('layouts.app')

@section('title', 'Monitor Ruang - Inventaris SMKN 2 SBY')
@section('page_title', 'Monitor Ruang')

@section('content')
<div class="space-y-6">
    <nav class="flex items-center gap-1.5 text-sm text-zinc-500">
        <a href="{{ route('dashboard') }}" class="hover:text-zinc-900 transition-colors">Dashboard</a>
        <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
        </svg>
        <span class="font-medium text-zinc-900">Monitor Ruang</span>
    </nav>

    <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-zinc-900">Monitor Ruang</h2>
            <p class="text-sm text-zinc-500">Pantau ruangan dan buka daftar aset yang berada di setiap ruang.</p>
        </div>

        <form method="GET" action="{{ route('ruangans.monitor') }}" class="flex items-center gap-2 w-full sm:w-auto">
            <label for="jurusan_id" class="text-sm font-medium text-zinc-600 shrink-0">Unit Kerja:</label>
            <select
                id="jurusan_id"
                name="jurusan_id"
                onchange="this.form.submit()"
                class="h-10 rounded-md border border-zinc-200 bg-white px-3 pr-8 text-sm text-zinc-700 focus:outline-none focus:ring-2 focus:ring-zinc-950 focus:ring-offset-1 transition-colors cursor-pointer"
            >
                <option value="">Semua Unit Kerja</option>
                @foreach ($jurusans as $jurusan)
                    <option value="{{ $jurusan->id }}" {{ request('jurusan_id') == $jurusan->id ? 'selected' : '' }}>
                        {{ $jurusan->nama_jurusan }}
                    </option>
                @endforeach
            </select>
            @if (request('jurusan_id'))
                <a href="{{ route('ruangans.monitor') }}" class="inline-flex h-10 items-center rounded-md border border-zinc-200 bg-white px-3 text-sm font-medium text-zinc-600 hover:bg-zinc-50 hover:text-zinc-900">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4">
        @forelse ($ruangans as $ruangan)
            <div class="group relative overflow-hidden rounded-xl bg-gradient-to-br from-emerald-800 via-emerald-600 to-green-500 p-3 text-white shadow-sm ring-1 ring-emerald-900/10 transition-all duration-200 hover:-translate-y-0.5 hover:shadow-lg hover:shadow-emerald-900/15">
                <div class="absolute inset-x-0 top-0 h-1 bg-lime-300/80"></div>
                <div class="absolute -top-10 right-3 h-20 w-20 rounded-full bg-white/10 blur-sm"></div>
                <div class="absolute -bottom-8 -left-8 h-20 w-20 rounded-full bg-emerald-950/20"></div>

                <div class="relative min-h-[218px] flex flex-col">
                    <div class="flex items-start justify-between gap-3">
                        <p class="text-[9px] font-extrabold uppercase tracking-widest text-emerald-50">Ruang Tersedia</p>
                        <span class="rounded-full border border-white/20 bg-white/15 px-2 py-0.5 text-[9px] font-bold text-white shadow-sm">
                            {{ $ruangan->inventaris_count }} aset
                        </span>
                    </div>

                    <div class="mt-4">
                        <h3 class="text-xl font-extrabold leading-tight tracking-tight">{{ $ruangan->nama_ruangan }}</h3>
                        <p class="mt-1 min-h-[34px] text-[11px] font-medium leading-snug text-emerald-50">
                            {{ $ruangan->jurusan->nama_jurusan ?? 'Tanpa Unit Kerja' }}
                        </p>
                    </div>

                    <div class="mt-3 flex items-center justify-between gap-2">
                        <span class="inline-flex min-w-0 items-center gap-1 rounded-full bg-emerald-950/35 px-2 py-1 text-[10px] font-bold text-white ring-1 ring-white/15">
                            <svg class="h-3 w-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m3-3H15m-1.5 3H15" />
                            </svg>
                            <span class="truncate">{{ $ruangan->jurusan->kode_jurusan ?? 'Unit Kerja' }}</span>
                        </span>
                        <span class="h-2 w-2 rounded-full bg-lime-300 shadow-[0_0_0_4px_rgba(190,242,100,0.18)]"></span>
                    </div>

                    <div class="my-3 border-t border-white/20"></div>

                    <dl class="grid grid-cols-2 gap-2 text-white">
                        <div class="rounded-lg bg-white/12 px-2 py-1.5 ring-1 ring-white/10">
                            <dt class="text-[9px] font-bold uppercase tracking-wide text-emerald-50/80">Jenis</dt>
                            <dd class="text-sm font-extrabold">{{ $ruangan->inventaris_count }}</dd>
                        </div>
                        <div class="rounded-lg bg-white/12 px-2 py-1.5 ring-1 ring-white/10">
                            <dt class="text-[9px] font-bold uppercase tracking-wide text-emerald-50/80">Unit</dt>
                            <dd class="text-sm font-extrabold">{{ $ruangan->total_unit ?? 0 }}</dd>
                        </div>
                        <div class="col-span-2 flex items-center justify-between rounded-lg bg-emerald-950/20 px-2 py-1.5 ring-1 ring-white/10">
                            <dt class="text-[10px] font-bold text-emerald-50">Status</dt>
                            <dd class="text-[10px] font-extrabold">Tersedia</dd>
                        </div>
                    </dl>

                    <div class="mt-auto pt-3">
                        <button type="button"
                            onclick="openAssetModal('{{ $ruangan->id }}')"
                            class="inline-flex h-8 w-full items-center justify-center gap-1.5 rounded-lg bg-slate-950 px-2 text-xs font-extrabold text-white shadow-sm transition-colors hover:bg-slate-900 cursor-pointer">
                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5H3.75m16.5 0-.625 10.632A2.25 2.25 0 0 1 17.378 20.25H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5m16.5 0V5.625A2.25 2.25 0 0 0 18 3.375H6a2.25 2.25 0 0 0-2.25 2.25V7.5m6.75 4.5h3" />
                            </svg>
                            Daftar Aset
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="sm:col-span-2 xl:col-span-4 2xl:col-span-5 rounded-lg border border-zinc-200 bg-white px-6 py-16 text-center shadow-sm">
                <p class="font-semibold text-zinc-700">Belum ada data ruangan</p>
                <p class="mt-1 text-sm text-zinc-500">Tambahkan data ruangan terlebih dahulu untuk menampilkan Monitor Ruang.</p>
            </div>
        @endforelse
    </div>

    <div id="asset-modal" class="fixed inset-0 z-50 hidden items-center justify-center px-4 py-6">
        <div class="absolute inset-0 bg-slate-950/60 backdrop-blur-sm" onclick="closeAssetModal()"></div>

        <div class="relative flex max-h-[88vh] w-full max-w-4xl flex-col overflow-hidden rounded-2xl bg-white shadow-2xl ring-1 ring-emerald-950/10">
            <div class="relative overflow-hidden bg-gradient-to-br from-emerald-800 via-emerald-600 to-green-500 px-6 py-5 text-white">
                <div class="absolute -right-8 -top-12 h-32 w-32 rounded-full bg-white/10"></div>
                <div class="absolute bottom-0 left-10 h-1.5 w-32 rounded-t-full bg-lime-300/80"></div>

                <div class="relative flex items-start justify-between gap-4">
                    <div>
                        <p class="text-[11px] font-extrabold uppercase tracking-widest text-emerald-50">Daftar Aset Ruangan</p>
                        <h3 id="asset-modal-title" class="mt-2 text-2xl font-extrabold tracking-tight">-</h3>
                        <p id="asset-modal-subtitle" class="mt-1 text-sm font-medium text-emerald-50">-</p>
                    </div>
                    <div class="flex shrink-0 items-center gap-2">
                        <a id="asset-modal-print-link" href="#" target="_blank" rel="noopener noreferrer"
                           class="inline-flex h-9 items-center justify-center gap-1.5 rounded-lg bg-white px-3 text-xs font-extrabold text-emerald-700 shadow-sm ring-1 ring-white/30 transition-colors hover:bg-emerald-50">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096a42.415 42.415 0 0 0-10.56 0m10.56 0L17.66 18m0 0a2.25 2.25 0 0 1-2.25 2.25H8.59A2.25 2.25 0 0 1 6.34 18m11.318-5.318a4.5 4.5 0 1 0-6.364-6.364 4.5 4.5 0 0 0 6.364 6.364Z" />
                            </svg>
                            Print
                        </a>
                        <button type="button" onclick="closeAssetModal()" class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-white/15 text-white ring-1 ring-white/20 transition-colors hover:bg-white/25 cursor-pointer">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div class="overflow-y-auto p-5">
                <div id="asset-modal-summary" class="mb-4 grid grid-cols-2 gap-3 sm:grid-cols-3"></div>
                <div id="asset-modal-content"></div>
            </div>
        </div>
    </div>
</div>

<script>
    const roomAssets = @json($roomAssets);

    const conditionClass = {
        baik: 'bg-emerald-50 text-emerald-700 border-emerald-200',
        layak: 'bg-amber-50 text-amber-700 border-amber-200',
        rusak: 'bg-red-50 text-red-700 border-red-200',
    };

    const conditionLabel = {
        baik: 'Baik',
        layak: 'Layak',
        rusak: 'Rusak',
    };

    function openAssetModal(roomId) {
        const room = roomAssets[roomId];
        if (!room) return;

        document.getElementById('asset-modal-title').textContent = room.nama;
        document.getElementById('asset-modal-subtitle').textContent = `${room.unitKerja} - ${room.kodeUnit}`;
        document.getElementById('asset-modal-print-link').href = room.printUrl;
        document.getElementById('asset-modal-summary').innerHTML = `
            <div class="rounded-xl border border-emerald-100 bg-emerald-50 px-4 py-3">
                <p class="text-[11px] font-bold uppercase tracking-wide text-emerald-700">Jenis Aset</p>
                <p class="mt-1 text-xl font-extrabold text-emerald-950">${room.totalJenis}</p>
            </div>
            <div class="rounded-xl border border-emerald-100 bg-emerald-50 px-4 py-3">
                <p class="text-[11px] font-bold uppercase tracking-wide text-emerald-700">Total Unit</p>
                <p class="mt-1 text-xl font-extrabold text-emerald-950">${room.totalUnit}</p>
            </div>
            <div class="col-span-2 rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 sm:col-span-1">
                <p class="text-[11px] font-bold uppercase tracking-wide text-slate-500">Status Ruang</p>
                <p class="mt-1 text-xl font-extrabold text-slate-950">Tersedia</p>
            </div>
        `;

        document.getElementById('asset-modal-content').innerHTML = room.assets.length
            ? renderAssetTable(room.assets)
            : renderEmptyAssets();

        const modal = document.getElementById('asset-modal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.classList.add('overflow-hidden');
    }

    function closeAssetModal() {
        const modal = document.getElementById('asset-modal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.classList.remove('overflow-hidden');
    }

    function renderAssetTable(assets) {
        const rows = assets.map((asset, index) => {
            const badgeClass = conditionClass[asset.kondisi] || 'bg-zinc-50 text-zinc-700 border-zinc-200';
            const badgeLabel = conditionLabel[asset.kondisi] || asset.kondisi || '-';

            return `
                <tr class="${index % 2 === 0 ? 'bg-white' : 'bg-zinc-50/60'}">
                    <td class="px-4 py-3 text-xs font-mono text-zinc-400">${index + 1}</td>
                    <td class="px-4 py-3">
                        <span class="inline-flex rounded-md bg-zinc-100 px-2 py-1 text-[11px] font-bold text-zinc-700">${escapeHtml(asset.kode)}</span>
                    </td>
                    <td class="px-4 py-3">
                        <p class="text-sm font-semibold text-zinc-900">${escapeHtml(asset.nama)}</p>
                        <p class="text-xs text-zinc-500">${escapeHtml(asset.merek || '-')} ${asset.type ? `&middot; ${escapeHtml(asset.type)}` : ''}</p>
                    </td>
                    <td class="px-4 py-3 text-sm text-zinc-600">${escapeHtml(asset.jenis_modal)}</td>
                    <td class="px-4 py-3 text-center text-sm font-extrabold text-zinc-900">${escapeHtml(asset.jumlah)}</td>
                    <td class="px-4 py-3 text-right">
                        <span class="inline-flex rounded-md border px-2 py-1 text-xs font-bold ${badgeClass}">${escapeHtml(badgeLabel)}</span>
                    </td>
                </tr>
            `;
        }).join('');

        return `
            <div class="overflow-hidden rounded-xl border border-zinc-200">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="border-b border-zinc-200 bg-zinc-50 text-[11px] uppercase tracking-wide text-zinc-500">
                            <tr>
                                <th class="px-4 py-3 font-bold">No</th>
                                <th class="px-4 py-3 font-bold">Kode</th>
                                <th class="px-4 py-3 font-bold">Barang</th>
                                <th class="px-4 py-3 font-bold">Jenis Modal</th>
                                <th class="px-4 py-3 text-center font-bold">Qty</th>
                                <th class="px-4 py-3 text-right font-bold">Kondisi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-100">${rows}</tbody>
                    </table>
                </div>
            </div>
        `;
    }

    function escapeHtml(value) {
        return String(value ?? '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function renderEmptyAssets() {
        return `
            <div class="rounded-xl border border-dashed border-zinc-300 bg-zinc-50 px-6 py-12 text-center">
                <p class="font-semibold text-zinc-700">Belum ada aset di ruangan ini</p>
                <p class="mt-1 text-sm text-zinc-500">Data inventaris yang ditempatkan di ruangan ini akan tampil di sini.</p>
            </div>
        `;
    }

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            closeAssetModal();
        }
    });
</script>
@endsection
