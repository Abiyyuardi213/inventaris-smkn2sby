<!DOCTYPE html>
<html lang="id" class="h-full bg-white">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Masuk - Inventaris SMKN 2 SBY</title>
    
    <!-- Google Fonts: Geist & Geist Mono -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@100..900&family=Geist+Mono:wght@100..900&display=swap" rel="stylesheet">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="h-full antialiased font-sans bg-white text-zinc-950">

    <div class="min-h-screen flex flex-col md:flex-row">
        
        <!-- Left: Image Cover Column (Visible on md and up) -->
        <div class="hidden md:block md:w-1/2 relative overflow-hidden bg-zinc-950">
            <img src="{{ asset('login_bg_school.png') }}" alt="Inventaris SMKN 2" class="absolute inset-0 w-full h-full object-cover opacity-75">
            <!-- Gradient Overlay -->
            <div class="absolute inset-0 bg-gradient-to-t from-zinc-950/80 via-zinc-950/20 to-zinc-950/30"></div>
            
            <!-- Brand Logo Top-Left -->
            <div class="absolute top-10 left-10 flex items-center gap-3 text-white">
                <div class="w-10 h-10 rounded-xl bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center shadow-md overflow-hidden p-1.5">
                    <img src="{{ asset('image/smkn2sby.png') }}" alt="Logo SMKN 2 Surabaya" class="w-full h-full object-contain">
                </div>
                <span class="text-base font-semibold tracking-tight">Inventaris SMKN 2 SBY</span>
            </div>
            
            <!-- Bottom Text Overlay -->
            <div class="absolute bottom-16 left-16 right-16 text-white space-y-5">
                <div class="space-y-2">
                    <h2 class="text-3xl font-bold tracking-tight leading-tight">
                        Kelola & Pantau Aset Sekolah dengan Mudah
                    </h2>
                    <p class="text-zinc-200 text-sm max-w-md font-light leading-relaxed">
                        Sistem informasi inventarisasi sarana dan prasarana SMKN 2 Surabaya untuk efisiensi, akurasi, dan transparansi data.
                    </p>
                </div>
                <!-- Carousel Indicators -->
                <div class="flex items-center gap-2 pt-2">
                    <span class="w-8 h-1.5 rounded-full bg-white transition-all"></span>
                    <span class="w-1.5 h-1.5 rounded-full bg-white/40"></span>
                    <span class="w-1.5 h-1.5 rounded-full bg-white/40"></span>
                </div>
            </div>
        </div>

            <!-- Right: Login Form Column -->
            <div class="w-full md:w-1/2 flex flex-col justify-between p-6 sm:p-12 md:p-16 lg:p-20 bg-zinc-50/50">
                
                <!-- Header Actions -->
                <div class="flex justify-between items-center h-10">
                    <!-- Mobile brand logo (visible on small screens) -->
                    <div class="md:hidden flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-zinc-950 flex items-center justify-center text-white overflow-hidden p-1">
                            <img src="{{ asset('image/smkn2sby.png') }}" alt="Logo SMKN 2 Surabaya" class="w-full h-full object-contain">
                        </div>
                        <span class="font-bold text-sm text-zinc-950 tracking-tight">Inventaris SMKN 2 SBY</span>
                    </div>
                    <div></div>
                    <div>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="inline-flex items-center justify-center rounded-full bg-zinc-950 hover:bg-zinc-800 text-white px-5 py-2 text-xs font-semibold shadow-sm transition-all duration-150 cursor-pointer">
                                Daftar Akun
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Middle: Form Container -->
                <div class="max-w-md mx-auto w-full my-auto py-8">
                    
                    <!-- Logo SMKN 2 Surabaya & Heading -->
                    <div class="space-y-4 mb-6">
                        <img src="{{ asset('image/smkn2sby.png') }}" alt="Logo SMKN 2 Surabaya" class="h-16 w-auto object-contain">
                        <div class="space-y-1.5">
                            <h1 class="text-3xl font-bold tracking-tight text-zinc-900">Selamat Datang Kembali!</h1>
                            <p class="text-sm text-zinc-500">Masuk untuk melanjutkan ke sistem inventaris</p>
                        </div>
                    </div>

                    <!-- Card Container -->
                    <div class="bg-white border border-zinc-200/80 shadow-md rounded-2xl p-6 sm:p-8">
                        <form method="POST" action="{{ route('login') }}" class="space-y-5">
                            @csrf

                            <!-- Username -->
                            <div class="space-y-1.5">
                                <label for="username" class="text-sm font-medium text-zinc-900">
                                    Nama Pengguna (Username)
                                </label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-zinc-400">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                        </svg>
                                    </span>
                                    <input id="username" name="username" type="text" autocomplete="username" required
                                        value="{{ old('username') }}" placeholder="Masukkan username Anda"
                                        class="flex h-11 w-full rounded-lg border border-zinc-200 bg-white pl-10 pr-3 py-2 text-sm text-zinc-900 placeholder:text-zinc-400 shadow-sm transition-colors focus:border-zinc-400 focus:outline-none focus:ring-2 focus:ring-zinc-200 @error('username') border-red-300 focus:border-red-400 focus:ring-red-100 @enderror">
                                </div>
                                @error('username')
                                    <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="space-y-1.5">
                                <div class="flex items-center justify-between">
                                    <label for="password" class="text-sm font-medium text-zinc-900">
                                        Kata Sandi
                                    </label>
                                </div>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-zinc-400">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                                        </svg>
                                    </span>
                                    <input id="password" name="password" type="password" autocomplete="current-password"
                                        required placeholder="Masukkan password Anda"
                                        class="flex h-11 w-full rounded-lg border border-zinc-200 bg-white pl-10 pr-10 py-2 text-sm text-zinc-900 placeholder:text-zinc-400 shadow-sm transition-colors focus:border-zinc-400 focus:outline-none focus:ring-2 focus:ring-zinc-200 @error('password') border-red-300 focus:border-red-400 focus:ring-red-100 @enderror">
                                    
                                    <!-- Toggle Password Visibility -->
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
                                    <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Remember Me & Forgot Password -->
                            <div class="flex items-center justify-between pt-1">
                                <div class="flex items-center gap-2">
                                    <input id="remember" name="remember" type="checkbox"
                                        class="h-4 w-4 rounded border-zinc-300 text-zinc-950 shadow-sm focus:ring-zinc-200 cursor-pointer">
                                    <label for="remember" class="text-sm font-medium text-zinc-600 cursor-pointer select-none">
                                        Ingat saya
                                    </label>
                                </div>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="text-xs text-zinc-500 hover:text-zinc-950 transition-colors">
                                        Lupa kata sandi?
                                    </a>
                                @endif
                            </div>

                            <!-- Submit Button -->
                            <button type="submit"
                                class="w-full inline-flex items-center justify-center gap-2 rounded-lg bg-zinc-950 text-zinc-50 hover:bg-zinc-800 px-4 py-3 text-sm font-semibold shadow-sm transition-all duration-150 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-950 cursor-pointer mt-2">
                                Masuk
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l3 3m0 0-3 3m3-3H2.25" />
                                </svg>
                            </button>
                        </form>
                    </div>


            </div>

            <!-- Footer: Copyright -->
            <div class="text-center text-xs text-zinc-400 pt-6">
                &copy; {{ date('Y') }} SMKN 2 Surabaya. Sistem Inventaris.
            </div>
        </div>
    </div>

    <!-- Scripts -->
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
