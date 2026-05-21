<!DOCTYPE html>
<html lang="en" class="h-full bg-zinc-50 text-zinc-900">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Inventaris SMKN 2 SBY')</title>

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

        <!-- Main Content Area -->
        <div class="flex flex-col flex-1 overflow-y-auto">
            <!-- Navbar Component -->
            @include('components.navbar')

            <!-- Page Content -->
            <main class="flex-1 p-6 md:p-8">
                @yield('content')
            </main>

            <!-- Footer Component -->
            @include('components.footer')
        </div>
    </div>

    <!-- SweetAlert2 Toast Notifications -->
    <script>
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
