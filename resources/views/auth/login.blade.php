<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Masuk - Inventaris SMKN 2 SBY</title>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-zinc-50 flex items-center justify-center px-4 py-12">

    <div class="w-full max-w-sm">

        {{-- Logo / Brand --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-zinc-900 shadow-sm mb-4">
                <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-.375c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v.375c0 .621.504 1.125 1.125 1.125z" />
                </svg>
            </div>
            <h1 class="text-2xl font-bold tracking-tight text-zinc-900">Inventaris SMKN 2 SBY</h1>
            <p class="text-sm text-zinc-500 mt-1">Masuk untuk melanjutkan ke sistem</p>
        </div>

        {{-- Card --}}
        <div class="rounded-lg border border-zinc-200 bg-white shadow-sm overflow-hidden">
            <div class="px-6 py-6">

                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf

                    {{-- Nama --}}
                    <div class="space-y-1.5">
                        <label for="nama" class="block text-sm font-medium text-zinc-700">
                            Nama Pengguna
                        </label>
                        <input id="nama" name="nama" type="text" autocomplete="username" required
                            value="{{ old('nama') }}" placeholder="Masukkan nama pengguna"
                            class="w-full rounded-md border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-900 placeholder:text-zinc-400 shadow-sm transition-colors focus:border-zinc-400 focus:outline-none focus:ring-2 focus:ring-zinc-200 @error('nama') border-red-300 focus:border-red-400 focus:ring-red-100 @enderror">
                        @error('nama')
                            <p class="text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="space-y-1.5">
                        <div class="flex items-center justify-between">
                            <label for="password" class="block text-sm font-medium text-zinc-700">
                                Kata Sandi
                            </label>
                        </div>
                        <div class="relative">
                            <input id="password" name="password" type="password" autocomplete="current-password"
                                required placeholder="••••••••"
                                class="w-full rounded-md border border-zinc-200 bg-white px-3 py-2 pr-10 text-sm text-zinc-900 placeholder:text-zinc-400 shadow-sm transition-colors focus:border-zinc-400 focus:outline-none focus:ring-2 focus:ring-zinc-200 @error('password') border-red-300 focus:border-red-400 focus:ring-red-100 @enderror">
                            {{-- Toggle Password Visibility --}}
                            <button type="button" onclick="togglePassword('password', this)"
                                class="absolute inset-y-0 right-0 flex items-center px-3 text-zinc-400 hover:text-zinc-600 transition-colors cursor-pointer"
                                tabindex="-1" aria-label="Tampilkan kata sandi">
                                <svg id="eye-icon-password" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Remember Me --}}
                    <div class="flex items-center gap-2">
                        <input id="remember" name="remember" type="checkbox"
                            class="h-4 w-4 rounded border-zinc-300 text-zinc-900 shadow-sm focus:ring-zinc-200 cursor-pointer">
                        <label for="remember" class="text-sm text-zinc-600 cursor-pointer select-none">
                            Ingat saya
                        </label>
                    </div>

                    {{-- Submit --}}
                    <button type="submit"
                        class="w-full inline-flex items-center justify-center gap-2 rounded-md bg-zinc-900 text-zinc-50 hover:bg-zinc-800 px-4 py-2.5 text-sm font-medium shadow-sm transition-all duration-150 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-950 cursor-pointer mt-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                        </svg>
                        Masuk
                    </button>
                </form>
            </div>

            {{-- Footer link --}}
            @if (Route::has('register'))
                <div class="border-t border-zinc-100 bg-zinc-50 px-6 py-4 text-center">
                    <p class="text-sm text-zinc-500">
                        Belum punya akun?
                        <a href="{{ route('register') }}"
                            class="font-medium text-zinc-900 hover:underline underline-offset-4 transition-all">
                            Daftar sekarang
                        </a>
                    </p>
                </div>
            @endif
        </div>

        {{-- Copyright --}}
        <p class="mt-6 text-center text-xs text-zinc-400">
            &copy; {{ date('Y') }} SMKN 2 Surabaya. Sistem Inventaris.
        </p>
    </div>

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

        @if (session('info'))
            Toast.fire({
                icon: 'info',
                title: @json(session('info'))
            });
        @endif

        @if (session('success'))
            Toast.fire({
                icon: 'success',
                title: @json(session('success'))
            });
        @endif

        @if (session('error'))
            Toast.fire({
                icon: 'error',
                title: @json(session('error'))
            });
        @endif

        @if ($errors->any())
            Toast.fire({
                icon: 'error',
                title: @json($errors->first())
            });
        @endif

        function togglePassword(fieldId, button) {
            const input = document.getElementById(fieldId);
            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';

            const eyeOpen = `
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            `;
            const eyeSlash = `
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
            `;

            const svg = button.querySelector('svg');
            svg.innerHTML = isPassword ? eyeSlash : eyeOpen;
            button.setAttribute('aria-label', isPassword ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi');
        }
    </script>
</body>

</html>
