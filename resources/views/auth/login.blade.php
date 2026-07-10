<!DOCTYPE html>
<html lang="id" class="h-full bg-zinc-950">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Masuk - Inventaris SMKN 2 SBY</title>

    <!-- Google Fonts: Geist & Geist Mono -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@100..900&family=Geist+Mono:wght@100..900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-full antialiased font-sans bg-zinc-950 text-zinc-950">
    <div class="relative min-h-screen overflow-hidden">
        <img src="{{ asset('image/back1.png') }}" alt="Inventaris SMKN 2" class="absolute inset-0 h-full w-full object-cover">
        <div class="absolute inset-0 bg-zinc-950/45"></div>

        <main class="relative z-10 flex min-h-screen items-center justify-center px-4 py-8 sm:px-6 lg:px-10">
            <section class="relative w-full max-w-7xl overflow-hidden rounded-[2rem] border border-white/15 bg-white/8 shadow-2xl shadow-zinc-950/35">
                <div class="absolute inset-0 bg-gradient-to-r from-zinc-950/78 via-zinc-950/40 to-zinc-950/10"></div>

                <div class="relative grid min-h-[720px] grid-cols-1 lg:grid-cols-[1.18fr_0.82fr]">
                    <div class="flex min-h-[320px] flex-col justify-between p-8 text-white sm:p-12 lg:p-16">
                        <div class="flex items-center gap-3">
                            <div class="flex h-11 w-11 items-center justify-center overflow-hidden rounded-xl border border-white/25 bg-white/15 p-1.5 shadow-md">
                                <img src="{{ asset('image/smkn2sby.png') }}" alt="Logo SMKN 2 Surabaya" class="h-full w-full object-contain">
                            </div>
                            <span class="text-base font-semibold tracking-tight">Inventaris SMKN 2 SBY</span>
                        </div>

                        <div class="max-w-xl space-y-6 pt-24 lg:pt-0">
                            <div class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-3 py-1 text-xs font-semibold text-white shadow-sm">
                                <span class="h-1.5 w-1.5 rounded-full bg-amber-300"></span>
                                Sistem Manajemen Inventaris
                            </div>
                            <div class="space-y-3">
                                <h2 class="max-w-lg text-4xl font-extrabold leading-tight tracking-tight sm:text-5xl">
                                    Kelola & Pantau Aset Sekolah dengan Mudah
                                </h2>
                                <p class="max-w-md text-sm font-medium leading-relaxed text-zinc-100 sm:text-base">
                                    Sistem informasi inventarisasi sarana dan prasarana SMKN 2 Surabaya untuk efisiensi, akurasi, dan transparansi data.
                                </p>
                            </div>
                            <div class="flex items-center gap-2 pt-2">
                                <span class="h-1.5 w-9 rounded-full bg-amber-400"></span>
                                <span class="h-1.5 w-1.5 rounded-full bg-white/60"></span>
                                <span class="h-1.5 w-1.5 rounded-full bg-white/60"></span>
                            </div>
                        </div>

                        <div class="hidden items-center gap-2 text-sm font-medium text-zinc-100 sm:flex">
                            <svg class="h-4 w-4 text-amber-300" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m3-3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                            </svg>
                            SMK Negeri 2 Surabaya
                        </div>
                    </div>

                    <div class="flex items-center justify-center px-5 pb-8 pt-0 sm:px-8 lg:px-14 lg:py-12">
                        <div class="w-full max-w-md rounded-3xl border border-white/60 bg-white/90 p-6 shadow-2xl shadow-zinc-950/20 sm:p-8">
                            <div class="mb-7 space-y-4">
                                <img src="{{ asset('image/smkn2sby.png') }}" alt="Logo SMKN 2 Surabaya" class="h-14 w-auto object-contain">
                                <div class="space-y-1.5">
                                    <h1 class="text-3xl font-bold tracking-tight text-zinc-950">Selamat Datang Kembali!</h1>
                                    <p class="text-sm text-zinc-600">Masuk untuk melanjutkan ke sistem inventaris</p>
                                </div>
                            </div>

                            <form method="POST" action="{{ route('login.authenticate') }}" class="space-y-5">
                                @csrf

                                <!-- Username -->
                                <div class="space-y-1.5">
                                    <label for="username" class="text-sm font-semibold text-zinc-900">
                                        Nama Pengguna (Username)
                                    </label>
                                    <div class="relative">
                                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-zinc-400">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                            </svg>
                                        </span>
                                        <input id="username" name="username" type="text" autocomplete="username" required
                                            value="{{ old('username') }}" placeholder="Masukkan username Anda"
                                            class="flex h-12 w-full rounded-xl border border-white/60 bg-white/80 py-2 pl-10 pr-3 text-sm text-zinc-900 shadow-sm transition-colors placeholder:text-zinc-400 focus:border-amber-300 focus:outline-none focus:ring-2 focus:ring-amber-200 @error('username') border-red-300 focus:border-red-400 focus:ring-red-100 @enderror">
                                    </div>
                                    @error('username')
                                        <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Password -->
                                <div class="space-y-1.5">
                                    <label for="password" class="text-sm font-semibold text-zinc-900">
                                        Kata Sandi
                                    </label>
                                    <div class="relative">
                                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-zinc-400">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                                            </svg>
                                        </span>
                                        <input id="password" name="password" type="password" autocomplete="current-password"
                                            required placeholder="Masukkan password Anda"
                                            class="flex h-12 w-full rounded-xl border border-white/60 bg-white/80 py-2 pl-10 pr-10 text-sm text-zinc-900 shadow-sm transition-colors placeholder:text-zinc-400 focus:border-amber-300 focus:outline-none focus:ring-2 focus:ring-amber-200 @error('password') border-red-300 focus:border-red-400 focus:ring-red-100 @enderror">

                                        <!-- Toggle Password Visibility -->
                                        <button type="button" onclick="togglePassword('password', this)"
                                            class="absolute inset-y-0 right-0 flex items-center px-3 text-zinc-400 transition-colors hover:text-zinc-600 cursor-pointer"
                                            tabindex="-1" aria-label="Tampilkan kata sandi">
                                            <svg id="eye-icon-password" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </button>
                                    </div>
                                    @error('password')
                                        <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Remember Me & Forgot Password -->
                                <div class="flex items-center justify-between pt-1">
                                    <div class="flex items-center gap-2">
                                        <input id="remember" name="remember" type="checkbox" value="1"
                                            {{ old('remember') ? 'checked' : '' }}
                                            class="h-4 w-4 rounded border-zinc-300 text-amber-500 shadow-sm focus:ring-amber-200 cursor-pointer">
                                        <label for="remember" class="select-none text-sm font-medium text-zinc-700 cursor-pointer">
                                            Ingat saya
                                        </label>
                                    </div>
                                    @if (Route::has('password.request'))
                                        <a href="{{ route('password.request') }}" class="text-xs font-medium text-zinc-500 transition-colors hover:text-zinc-950">
                                            Lupa kata sandi?
                                        </a>
                                    @endif
                                </div>

                                <!-- Submit Button -->
                                <button type="submit"
                                    class="mt-2 inline-flex w-full items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-amber-500 to-orange-500 px-4 py-3 text-sm font-extrabold uppercase tracking-wide text-white shadow-lg shadow-orange-500/25 transition-all duration-150 hover:from-amber-400 hover:to-orange-500 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-amber-300 cursor-pointer">
                                    Masuk
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l3 3m0 0-3 3m3-3H2.25" />
                                    </svg>
                                </button>
                            </form>

                            <div class="mt-7 text-center text-xs text-zinc-500">
                                &copy; {{ date('Y') }} Teknik Informatika ITATS. Sistem Inventaris.
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <div id="login-toast-root" class="fixed right-4 top-4 z-50 space-y-2"></div>

    <!-- Scripts -->
    <script>
        function showLoginToast(type, message) {
            const root = document.getElementById('login-toast-root');
            const colors = {
                info: 'border-sky-200 bg-sky-50 text-sky-800',
                success: 'border-emerald-200 bg-emerald-50 text-emerald-800',
                error: 'border-red-200 bg-red-50 text-red-800',
            };
            const toast = document.createElement('div');
            toast.className = `max-w-sm rounded-lg border px-4 py-3 text-sm font-medium shadow-lg transition-all duration-200 ${colors[type] || colors.info}`;
            toast.textContent = message;
            root.appendChild(toast);

            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transform = 'translateY(-6px)';
                setTimeout(() => toast.remove(), 220);
            }, 2600);
        }

        @if (session('info'))
            showLoginToast('info', @json(session('info')));
        @endif

        @if (session('success'))
            showLoginToast('success', @json(session('success')));
        @endif

        @if (session('error'))
            showLoginToast('error', @json(session('error')));
        @endif

        @if ($errors->any())
            showLoginToast('error', @json($errors->first()));
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
