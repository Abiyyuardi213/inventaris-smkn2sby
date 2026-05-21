<aside class="w-64 border-r border-zinc-200 bg-white flex-shrink-0 hidden md:flex flex-col h-full">
    <!-- Sidebar Header -->
    <div class="h-16 flex items-center px-6 border-b border-zinc-200 gap-2.5">
        <div class="w-8 h-8 rounded-lg bg-zinc-900 flex items-center justify-center text-white font-bold text-lg">
            I
        </div>
        <span class="font-semibold text-zinc-900 tracking-tight">Inventaris SMKN 2</span>
    </div>

    <!-- Navigation Links -->
    <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
        <a href="/" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-md text-zinc-500 hover:text-zinc-950 hover:bg-zinc-100 transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
            </svg>
            Dashboard
        </a>

        <a href="{{ route('roles.index') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('roles.*') ? 'bg-zinc-100 text-zinc-900 font-semibold' : 'text-zinc-500 hover:text-zinc-950 hover:bg-zinc-100' }} transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
            </svg>
            Role / Peran
        </a>

        <a href="{{ route('users.index') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('users.*') ? 'bg-zinc-100 text-zinc-900 font-semibold' : 'text-zinc-500 hover:text-zinc-950 hover:bg-zinc-100' }} transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.109A11.386 11.386 0 0 1 10.089 20.5c-2.057 0-3.978-.543-5.64-1.5v-.11a11.386 11.386 0 0 1 5.017-1.334c1.218 0 2.383.186 3.484.53m1.484-3.078c-.783.518-1.503 1.155-2.125 1.886L10.089 16c-1.895 0-3.665.419-5.257 1.17l-.023-.008a6.002 6.002 0 0 1 10.04-3.967A6.012 6.012 0 0 1 15 16.052Zm-4.911-3.302a4.5 4.5 0 1 1-7.078-5.592 4.5 4.5 0 0 1 7.078 5.592Zm6.422-3.302a3 3 0 1 1-4.718-3.728 3 3 0 0 1 4.718 3.728Z" />
            </svg>
            Pengguna (Users)
        </a>

        <a href="#" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-md text-zinc-500 hover:text-zinc-950 hover:bg-zinc-100 transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
            </svg>
            Barang / Sarpras
        </a>

        <a href="#" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-md text-zinc-500 hover:text-zinc-950 hover:bg-zinc-100 transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 21 3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5" />
            </svg>
            Peminjaman
        </a>
    </nav>

    <!-- Sidebar Footer -->
    <div class="p-4 border-t border-zinc-200">
        <div class="flex items-center gap-3 p-2 rounded-lg bg-zinc-50">
            <div class="w-9 h-9 rounded-full bg-zinc-200 flex items-center justify-center font-semibold text-sm text-zinc-800">
                U
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-xs font-semibold text-zinc-900 truncate">User Default</p>
                <p class="text-[10px] text-zinc-500 truncate">user@example.com</p>
            </div>
        </div>
    </div>
</aside>
