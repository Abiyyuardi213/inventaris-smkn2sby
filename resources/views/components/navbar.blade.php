<header class="h-16 border-b border-zinc-200 bg-white flex items-center justify-between px-6 md:px-8 shrink-0">
    <!-- Left: Mobile Menu Trigger and Title -->
    <div class="flex items-center gap-4">
        <button type="button" onclick="openMobileSidebar()" class="md:hidden p-2 rounded-md text-zinc-500 hover:bg-zinc-100" aria-label="Buka menu">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
        </button>
        <h1 class="text-lg font-semibold text-zinc-900">@yield('page_title', 'Dashboard')</h1>
    </div>

    <!-- Right: Actions -->
    <div class="flex items-center gap-3">
        <!-- Notifications Bell -->
        <div class="relative" id="notification-dropdown-container">
            <button type="button" id="notification-bell-btn"
                class="relative p-2.5 rounded-md border border-zinc-200 text-zinc-500 hover:text-zinc-800 bg-white transition-colors shadow-sm cursor-pointer focus:outline-none"
                title="Notifikasi Peminjaman">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                </svg>
                @if(isset($peminjamanAlerts) && $peminjamanAlerts['count'] > 0)
                    <span class="absolute top-0 right-0 -mr-1 -mt-1 flex h-4 w-4 items-center justify-center rounded-full bg-red-600 text-[9px] font-bold text-white ring-2 ring-white animate-pulse">
                        {{ $peminjamanAlerts['count'] }}
                    </span>
                @endif
            </button>

            <!-- Dropdown Menu -->
            <div id="notification-dropdown-menu"
                class="absolute right-0 mt-2 w-80 sm:w-96 rounded-lg border border-zinc-200 bg-white shadow-xl py-1 z-50 hidden divide-y divide-zinc-100 max-h-[480px] overflow-y-auto">
                <div class="px-4 py-3 bg-zinc-50/50 flex items-center justify-between">
                    <span class="text-xs font-bold text-zinc-800 uppercase tracking-wider">Notifikasi Peminjaman</span>
                    @if(isset($peminjamanAlerts) && $peminjamanAlerts['count'] > 0)
                        <span class="inline-flex items-center rounded-full bg-red-50 px-2 py-0.5 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/10">
                            {{ $peminjamanAlerts['count'] }} Aktif
                        </span>
                    @endif
                </div>

                <div class="divide-y divide-zinc-100 max-h-[360px] overflow-y-auto">
                    @if(isset($peminjamanAlerts) && $peminjamanAlerts['count'] > 0)
                        <!-- Overdue List -->
                        @foreach($peminjamanAlerts['overdue'] as $alert)
                            <a href="{{ route('peminjamans.show', $alert->id) }}" class="flex items-start gap-3 p-4 hover:bg-zinc-50 transition-colors">
                                <div class="flex-shrink-0 mt-0.5">
                                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-red-50 text-red-600">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                        </svg>
                                    </span>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-xs font-semibold text-red-700 uppercase tracking-wider">TERLAMBAT (+{{ $alert->hari_terlambat }} hari)</p>
                                    <p class="text-xs text-zinc-600 mt-0.5"><strong>{{ $alert->nama_peminjam }}</strong> belum mengembalikan <strong>{{ $alert->inventaris->nama_barang ?? 'Barang' }}</strong> ({{ $alert->jumlah_pinjam }} unit).</p>
                                    <p class="text-[10px] text-zinc-400 mt-1">Jatuh tempo: {{ $alert->tanggal_estimasi_kembali->format('d M Y') }}</p>
                                </div>
                            </a>
                        @endforeach

                        <!-- Approaching List -->
                        @foreach($peminjamanAlerts['approaching'] as $alert)
                            <a href="{{ route('peminjamans.show', $alert->id) }}" class="flex items-start gap-3 p-4 hover:bg-zinc-50 transition-colors">
                                <div class="flex-shrink-0 mt-0.5">
                                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-amber-50 text-amber-600">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                        </svg>
                                    </span>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-xs font-semibold text-amber-700 uppercase tracking-wider">
                                        @if($alert->sisa_hari === 0)
                                            JATUH TEMPO HARI INI
                                        @else
                                            JATUH TEMPO ({{ $alert->sisa_hari }} hari lagi)
                                        @endif
                                    </p>
                                    <p class="text-xs text-zinc-600 mt-0.5">Peminjaman oleh <strong>{{ $alert->nama_peminjam }}</strong> untuk <strong>{{ $alert->inventaris->nama_barang ?? 'Barang' }}</strong> ({{ $alert->jumlah_pinjam }} unit).</p>
                                    <p class="text-[10px] text-zinc-400 mt-1">Estimasi kembali: {{ $alert->tanggal_estimasi_kembali->format('d M Y') }}</p>
                                </div>
                            </a>
                        @endforeach
                    @else
                        <div class="px-4 py-8 text-center text-zinc-500">
                            <svg class="w-8 h-8 text-zinc-300 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                            </svg>
                            <p class="text-xs font-medium">Tidak ada notifikasi peminjaman</p>
                            <p class="text-[10px] text-zinc-400 mt-0.5">Semua peminjaman berjalan lancar.</p>
                        </div>
                    @endif
                </div>

                <div class="px-4 py-2.5 bg-zinc-50/50 text-center">
                    <a href="{{ route('peminjamans.index') }}" class="text-xs font-bold text-zinc-700 hover:text-zinc-950 transition-colors">Lihat Semua Riwayat</a>
                </div>
            </div>
        </div>

        <a href="{{ route('profile.show') }}"
            class="inline-flex items-center gap-2 rounded-md border border-zinc-200 bg-white px-3 py-2 text-sm font-medium text-zinc-600 shadow-sm transition-colors hover:bg-zinc-50 hover:text-zinc-950"
            title="Profil Saya">
            <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-zinc-900 text-[11px] font-bold text-white">
                {{ strtoupper(substr(Auth::user()?->nama ?? 'U', 0, 1)) }}
            </span>
            <span class="hidden sm:inline">Profil</span>
        </a>

        <!-- Logout -->
        <form action="{{ route('logout') }}" method="POST" id="logout-form">
            @csrf
            <button type="button" onclick="confirmLogout()"
                class="p-2.5 rounded-md border border-zinc-200 text-zinc-500 hover:text-red-600 hover:border-red-200 hover:bg-red-50 bg-white transition-colors shadow-sm cursor-pointer"
                title="Keluar">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15M12 9l3 3m0 0-3 3m3-3H2.25" />
                </svg>
            </button>
        </form>
    </div>
</header>

<div id="logout-modal" class="fixed inset-0 z-50 hidden items-center justify-center px-4 py-6">
    <div class="absolute inset-0 bg-zinc-950/50" onclick="closeLogoutModal()"></div>
    <div class="relative w-full max-w-sm rounded-xl border border-zinc-200 bg-white p-5 shadow-xl">
        <div class="flex items-start gap-3">
            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-red-50 text-red-600">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15M12 9l3 3m0 0-3 3m3-3H2.25" />
                </svg>
            </div>
            <div class="min-w-0">
                <h2 class="text-base font-semibold text-zinc-900">Keluar dari sistem?</h2>
                <p class="mt-1 text-sm text-zinc-500">Sesi Anda akan diakhiri.</p>
            </div>
        </div>

        <div class="mt-5 flex justify-end gap-2">
            <button type="button" onclick="closeLogoutModal()" class="h-9 rounded-md border border-zinc-200 bg-white px-3 text-sm font-medium text-zinc-700 hover:bg-zinc-50 cursor-pointer">
                Batal
            </button>
            <button type="button" onclick="submitLogout()" class="h-9 rounded-md bg-zinc-900 px-3 text-sm font-medium text-white hover:bg-zinc-800 cursor-pointer">
                Ya, keluar
            </button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const bellBtn = document.getElementById('notification-bell-btn');
        const dropdownMenu = document.getElementById('notification-dropdown-menu');

        if (bellBtn && dropdownMenu) {
            bellBtn.addEventListener('click', (event) => {
                event.stopPropagation();
                dropdownMenu.classList.toggle('hidden');
            });

            document.addEventListener('click', (event) => {
                if (!dropdownMenu.contains(event.target) && event.target !== bellBtn) {
                    dropdownMenu.classList.add('hidden');
                }
            });
        }
    });

    function confirmLogout() {
        const modal = document.getElementById('logout-modal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.classList.add('overflow-hidden');
    }

    function closeLogoutModal() {
        const modal = document.getElementById('logout-modal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.classList.remove('overflow-hidden');
    }

    function submitLogout() {
        document.getElementById('logout-form').submit();
    }

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            closeLogoutModal();
        }
    });
</script>
