<header class="h-16 border-b border-zinc-200 bg-white flex items-center justify-between px-6 md:px-8">
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
        <!-- Notification Trigger -->
        <button class="p-2.5 rounded-md border border-zinc-200 text-zinc-500 hover:text-zinc-900 bg-white hover:bg-zinc-50 transition-colors shadow-sm cursor-pointer">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
            </svg>
        </button>
    </div>
</header>
