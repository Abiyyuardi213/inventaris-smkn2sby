@php
    $currentUser = auth()->user();
@endphp

<aside class="w-72 border-r border-zinc-200 bg-white flex-shrink-0 hidden md:flex flex-col h-full">
    <!-- Sidebar Header -->
    <div class="h-16 flex items-center px-6 border-b border-zinc-200 gap-2.5">
        <div class="w-8 h-8 rounded-lg bg-zinc-900 flex items-center justify-center text-white overflow-hidden p-1">
            <img src="{{ asset('image/smkn2sby.png') }}" alt="Logo SMKN 2 Surabaya" class="w-full h-full object-contain">
        </div>
        <span class="font-semibold text-zinc-900 tracking-tight">Inventaris SMKN 2 SBY</span>
    </div>

    <!-- Navigation Links -->
    <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
        @if($currentUser?->canAccess('dashboard.view'))
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('dashboard') || request()->is('admin/dashboard') ? 'bg-zinc-100 text-zinc-900 font-semibold' : 'text-zinc-500 hover:text-zinc-950 hover:bg-zinc-100' }} transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
            </svg>
            Dashboard
            </a>
        @endif

        @if($currentUser?->canAccess('roles.manage'))
            <a href="{{ route('roles.index') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('roles.*') ? 'bg-zinc-100 text-zinc-900 font-semibold' : 'text-zinc-500 hover:text-zinc-950 hover:bg-zinc-100' }} transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
            </svg>
            Role / Peran
            </a>
        @endif

        @if($currentUser?->canAccess('users.manage'))
            <a href="{{ route('users.index') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('users.*') ? 'bg-zinc-100 text-zinc-900 font-semibold' : 'text-zinc-500 hover:text-zinc-950 hover:bg-zinc-100' }} transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.109A11.386 11.386 0 0 1 10.089 20.5c-2.057 0-3.978-.543-5.64-1.5v-.11a11.386 11.386 0 0 1 5.017-1.334c1.218 0 2.383.186 3.484.53m1.484-3.078c-.783.518-1.503 1.155-2.125 1.886L10.089 16c-1.895 0-3.665.419-5.257 1.17l-.023-.008a6.002 6.002 0 0 1 10.04-3.967A6.012 6.012 0 0 1 15 16.052Zm-4.911-3.302a4.5 4.5 0 1 1-7.078-5.592 4.5 4.5 0 0 1 7.078 5.592Zm6.422-3.302a3 3 0 1 1-4.718-3.728 3 3 0 0 1 4.718 3.728Z" />
            </svg>
            Pengguna (Users)
            </a>
        @endif

        {{-- ── Master Data ────────────────────────────── --}}
        @if($currentUser?->canAccessAny(['jurusans.manage', 'monitor-ruang.view', 'ruangans.manage', 'kategoris.manage']))
            <p class="mt-4 mb-1 px-3 text-[10px] font-semibold uppercase tracking-widest text-zinc-400">
                Master Data
            </p>
        @endif

        @if($currentUser?->canAccess('jurusans.manage'))
            <a href="{{ route('jurusans.index') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('jurusans.*') ? 'bg-zinc-100 text-zinc-900 font-semibold' : 'text-zinc-500 hover:text-zinc-950 hover:bg-zinc-100' }} transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75Z" />
            </svg>
            Unit Kerja
            </a>
        @endif

        @if($currentUser?->canAccess('monitor-ruang.view'))
            <a href="{{ route('ruangans.monitor') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('ruangans.monitor') ? 'bg-zinc-100 text-zinc-900 font-semibold' : 'text-zinc-500 hover:text-zinc-950 hover:bg-zinc-100' }} transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 0 1 4.5 9.75h15A2.25 2.25 0 0 1 21.75 12v.75m-19.5 0v5.25A2.25 2.25 0 0 0 4.5 20.25h15a2.25 2.25 0 0 0 2.25-2.25v-5.25m-19.5 0h19.5M4.5 9.75V6A2.25 2.25 0 0 1 6.75 3.75h10.5A2.25 2.25 0 0 1 19.5 6v3.75M8.25 15h.008v.008H8.25V15Zm3.75 0h.008v.008H12V15Zm3.75 0h.008v.008h-.008V15Z" />
            </svg>
            Monitor Ruang
            </a>
        @endif

        @if($currentUser?->canAccess('ruangans.manage'))
            <a href="{{ route('ruangans.index') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('ruangans.index', 'ruangans.create', 'ruangans.show', 'ruangans.edit') ? 'bg-zinc-100 text-zinc-900 font-semibold' : 'text-zinc-500 hover:text-zinc-950 hover:bg-zinc-100' }} transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
            </svg>
            Ruangan
            </a>
        @endif

        @if($currentUser?->canAccess('kategoris.manage'))
            <a href="{{ route('kategoris.index') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('kategoris.*') ? 'bg-zinc-100 text-zinc-900 font-semibold' : 'text-zinc-500 hover:text-zinc-950 hover:bg-zinc-100' }} transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" />
            </svg>
            Kategori
            </a>
        @endif

        {{-- ── Inventaris ──────────────────────────────── --}}
        @if($currentUser?->canAccessAny(['inventaris.manage', 'mutasis.manage', 'peminjamans.manage']))
            <p class="mt-4 mb-1 px-3 text-[10px] font-semibold uppercase tracking-widest text-zinc-400">
                Inventaris
            </p>
        @endif

        @if($currentUser?->canAccess('inventaris.manage'))
            <a href="{{ route('inventaris.index') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('inventaris.*') ? 'bg-zinc-100 text-zinc-900 font-semibold' : 'text-zinc-500 hover:text-zinc-950 hover:bg-zinc-100' }} transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
            </svg>
            Barang / Sarpras
            </a>
        @endif

        @if($currentUser?->canAccess('mutasis.manage'))
            <a href="{{ route('mutasis.index') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('mutasis.*') ? 'bg-zinc-100 text-zinc-900 font-semibold' : 'text-zinc-500 hover:text-zinc-950 hover:bg-zinc-100' }} transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 21 3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5" />
            </svg>
            Mutasi Barang
            </a>
        @endif

        @if($currentUser?->canAccess('peminjamans.manage'))
            <a href="{{ route('peminjamans.index') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('peminjamans.*') ? 'bg-zinc-100 text-zinc-900 font-semibold' : 'text-zinc-500 hover:text-zinc-950 hover:bg-zinc-100' }} transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
            </svg>
            Peminjaman
            </a>
        @endif

        {{-- ── Transaksi ────────────────────────────────── --}}
        @if($currentUser?->canAccess('pengadaans.manage'))
            <p class="mt-4 mb-1 px-3 text-[10px] font-semibold uppercase tracking-widest text-zinc-400">
                Transaksi
            </p>
        @endif

        @if($currentUser?->canAccess('pengadaans.manage'))
            <a href="{{ route('pengadaans.index') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('pengadaans.*') ? 'bg-zinc-100 text-zinc-900 font-semibold' : 'text-zinc-500 hover:text-zinc-950 hover:bg-zinc-100' }} transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
            </svg>
            Usulan Pengadaan
            </a>
        @endif

        {{-- ── Approval ── --}}
        @if($currentUser?->canAccess('approvals.manage'))
            <p class="mt-4 mb-1 px-3 text-[10px] font-semibold uppercase tracking-widest text-zinc-400">
                Approval
            </p>

            <a href="{{ route('approvals.index') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('approvals.*') ? 'bg-zinc-100 text-zinc-900 font-semibold' : 'text-zinc-500 hover:text-zinc-950 hover:bg-zinc-100' }} transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                Approval Pengadaan
            </a>
        @endif
    </nav>

    <!-- Sidebar Footer -->
    <div class="p-4 border-t border-zinc-200">
        <a href="{{ route('profile.show') }}" class="flex items-center gap-3 p-2 rounded-lg bg-zinc-50 hover:bg-zinc-100 transition-colors">
            <div class="w-9 h-9 rounded-full bg-zinc-900 text-white flex items-center justify-center font-semibold text-sm">
                {{ strtoupper(substr(Auth::user()?->nama ?? 'U', 0, 1)) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-xs font-semibold text-zinc-900 truncate">{{ Auth::user()?->nama ?? 'User Default' }}</p>
                <p class="text-[10px] text-zinc-500 truncate">{{ Auth::user()?->email ?? 'user@example.com' }}</p>
            </div>
        </a>
    </div>
</aside>
