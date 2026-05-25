<header class="h-16 border-b border-zinc-200 bg-white flex items-center justify-between px-6 md:px-8 shrink-0">
    <!-- Left: Mobile Menu Trigger and Title -->
    <div class="flex items-center gap-4">
        <button class="md:hidden p-2 rounded-md text-zinc-500 hover:bg-zinc-100">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
        </button>
        <h1 class="text-lg font-semibold text-zinc-900">@yield('page_title', 'Dashboard')</h1>
    </div>

    <!-- Right: Actions -->
    <div class="flex items-center gap-3">
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

<script>
    function confirmLogout() {
        Swal.fire({
            title: 'Keluar dari sistem?',
            text: 'Sesi Anda akan diakhiri.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, keluar',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#18181b',
            cancelButtonColor: '#e4e4e7',
            customClass: {
                cancelButton: '!text-zinc-700',
            },
            reverseButtons: true,
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logout-form').submit();
            }
        });
    }
</script>
