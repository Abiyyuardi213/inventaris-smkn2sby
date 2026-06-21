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
