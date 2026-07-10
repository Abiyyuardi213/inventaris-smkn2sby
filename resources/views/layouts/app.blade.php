<!DOCTYPE html>
<html lang="en" class="h-full bg-zinc-50 text-zinc-900">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Inventaris SMKN 2 SBY')</title>
    <link rel="icon" type="image/png" href="{{ asset('image/icon.png') }}">

    <!-- Google Fonts: Geist & Geist Mono -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Geist:wght@100..900&family=Geist+Mono:wght@100..900&display=swap"
        rel="stylesheet">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Vite CSS and JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="h-full antialiased font-sans flex flex-col">
    <div class="flex h-full min-h-screen overflow-hidden">
        <!-- Sidebar Component -->
        @include('components.sidebar')

        <div id="mobile-sidebar" class="fixed inset-0 z-50 hidden md:hidden">
            <div id="mobile-sidebar-backdrop" class="absolute inset-0 bg-zinc-950/50 opacity-0 transition-opacity duration-200" onclick="closeMobileSidebar()"></div>
            <div id="mobile-sidebar-panel" class="relative h-full -translate-x-full transition-transform duration-200 ease-out">
                @include('components.sidebar', ['sidebarMode' => 'mobile'])
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="flex flex-col flex-1 overflow-hidden">
            <!-- Navbar Component -->
            @include('components.navbar')

            <!-- Page Content -->
            <div class="flex-1 overflow-y-auto flex flex-col">
                <main class="flex-1 p-6 md:p-8">
                    @yield('content')
                </main>

                <!-- Footer Component -->
                @include('components.footer')
            </div>
        </div>
    </div>

    <!-- SweetAlert2 Toast Notifications -->
    <script>
        function openMobileSidebar() {
            const sidebar = document.getElementById('mobile-sidebar');
            const backdrop = document.getElementById('mobile-sidebar-backdrop');
            const panel = document.getElementById('mobile-sidebar-panel');

            if (!sidebar || !backdrop || !panel) return;

            sidebar.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');

            requestAnimationFrame(() => {
                backdrop.classList.remove('opacity-0');
                backdrop.classList.add('opacity-100');
                panel.classList.remove('-translate-x-full');
                panel.classList.add('translate-x-0');
            });
        }

        function closeMobileSidebar() {
            const sidebar = document.getElementById('mobile-sidebar');
            const backdrop = document.getElementById('mobile-sidebar-backdrop');
            const panel = document.getElementById('mobile-sidebar-panel');

            if (!sidebar || !backdrop || !panel) return;

            backdrop.classList.add('opacity-0');
            backdrop.classList.remove('opacity-100');
            panel.classList.add('-translate-x-full');
            panel.classList.remove('translate-x-0');
            document.body.classList.remove('overflow-hidden');

            window.setTimeout(() => {
                sidebar.classList.add('hidden');
            }, 200);
        }

        document.addEventListener('click', (event) => {
            const link = event.target.closest('#mobile-sidebar a');

            if (link) {
                closeMobileSidebar();
            }
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                closeMobileSidebar();
            }
        });

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });

        @if (session('success'))
            Toast.fire({
                icon: 'success',
                title: @json(session('success')),
            });
        @endif

        @if (session('error'))
            Toast.fire({
                icon: 'error',
                title: @json(session('error')),
            });
        @endif

        @if (session('warning'))
            Toast.fire({
                icon: 'warning',
                title: @json(session('warning')),
            });
        @endif

        @if (session('info'))
            Toast.fire({
                icon: 'info',
                title: @json(session('info')),
            });
        @endif
    </script>
</body>

</html>
