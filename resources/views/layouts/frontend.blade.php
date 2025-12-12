<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SeduhRasa Coffee')</title>

    {{-- FAVICON --}}
    <link rel="icon" type="image/png" href="{{ asset('LOGO2.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">

    <style>
        /* Animasi teks logo */
        .logo-text {
            display: inline-block;
            position: relative;
            white-space: nowrap;
        }

        .logo-seduh,
        .logo-rasa {
            display: inline-block;
            opacity: 0;
        }

        .logo-seduh {
            animation: slideInLeft 0.6s ease-out 0.2s forwards;
        }

        .logo-rasa {
            color: #c4905c;
            text-shadow: 0 0 18px rgba(196, 144, 92, 0.4);
            animation: slideInLeft 0.6s ease-out 0.5s forwards;
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Shine effect pada logo */
        .logo-shine {
            position: relative;
            overflow: hidden;
        }

        .logo-shine::after {
            content: '';
            position: absolute;
            top: 0;
            left: -120%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg,
                    transparent,
                    rgba(255, 255, 255, 0.35),
                    transparent);
            transition: left 0.6s ease;
        }

        .logo-shine:hover::after {
            left: 120%;
        }

        /* TITIK 3 (HAMBURGER) */
        .hamburger-dots {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 4px;
        }

        .hamburger-dots span {
            width: 4px;
            height: 4px;
            border-radius: 999px;
            background-color: #f5e6d3;
            box-shadow: 0 0 3px rgba(255, 255, 255, 0.4);
            transition: transform 0.2s ease, opacity 0.2s ease, width 0.2s ease;
        }

        .hamburger-dots.active span:nth-child(1) {
            transform: translateY(4px) rotate(45deg);
            width: 16px;
            height: 3px;
        }

        .hamburger-dots.active span:nth-child(2) {
            opacity: 0;
            transform: scale(0);
        }

        .hamburger-dots.active span:nth-child(3) {
            transform: translateY(-4px) rotate(-45deg);
            width: 16px;
            height: 3px;
        }

        /* MENU MOBILE DROPDOWN */
        #mobile-menu {
            background: linear-gradient(to bottom, #2a1810, #3d2817);
            border-top: 1px solid #5c3d2e;
        }

        .mobile-link {
            display: block;
            padding: 0.75rem 1rem;
            color: #f5e6d3;
            font-weight: 500;
            transition: color 0.2s ease, background-color 0.2s ease;
        }

        .mobile-link:hover {
            color: #c4905c;
            background-color: rgba(0, 0, 0, 0.2);
        }
    </style>

    @stack('styles')
</head>

<body class="bg-stone-50">

    {{-- NAVBAR --}}
    <nav class="fixed top-0 left-0 right-0 z-50 bg-gradient-to-r from-[#2a1810] to-[#3d2817] shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex items-center justify-between h-20">

                {{-- Logo: balik ke HOME (LOGO2.PNG) --}}
                <a href="{{ route('home') }}" class="flex items-center gap-3 group logo-shine">
                    <div
                        class="w-7 h-7 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <img src="{{ asset('LOGO2.png') }}" alt="Logo SeduhRasa" class="h-full w-auto object-contain">
                    </div>
                    <span
                        class="font-['Great_Vibes'] text-2xl text-[#f5e6d3] group-hover:text-[#c4905c] transition-colors duration-300 logo-text">
                        <span class="logo-seduh">Seduh</span><span class="logo-rasa">Rasa</span>
                    </span>
                </a>

                <div class="flex items-center gap-4">
                    {{-- MENU DESKTOP (hanya muncul ≥ md) --}}
                    <div class="hidden md:flex items-center gap-8 text-[#f5e6d3] font-medium">
                        <a href="{{ route('home') }}" class="hover:text-[#c4905c] transition-colors">
                            Home
                        </a>
                        <a href="https://ours.web.id" target="_blank" class="hover:text-[#c4905c] transition-colors">
                            Portal
                        </a>
                        <a href="{{ route('about') }}" class="hover:text-[#c4905c] transition-colors">
                            About Us
                        </a>
                        <a href="{{ route('services') }}" class="hover:text-[#c4905c] transition-colors">
                            Services
                        </a>
                        <a href="{{ route('contact') }}" class="hover:text-[#c4905c] transition-colors">
                            Contact
                        </a>
                    </div>

                    {{-- TITIK 3: MUNCUL HANYA DI MOBILE (< md) --}}
                    <button id="mobile-menu-button"
                        class="block md:hidden p-2 rounded-lg hover:bg-black/20 transition-colors">
                        <div class="hamburger-dots">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </button>
                </div>
            </div>
        </div>

        {{-- MENU MOBILE: hanya < md --}}
        <div id="mobile-menu" class="md:hidden hidden">
            <a href="{{ route('home') }}" class="mobile-link">
                Home
            </a>
            <a href="https://ours.web.id" target="_blank" class="mobile-link">
                Portal
            </a>
            <a href="{{ route('about') }}" class="mobile-link">
                About Us
            </a>
            <a href="{{ route('services') }}" class="mobile-link">
                Services
            </a>
            <a href="{{ route('contact') }}" class="mobile-link">
                Contact
            </a>
        </div>
    </nav>

    {{-- KONTEN HALAMAN --}}
    <main class="min-h-screen pt-20">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer
        class="bg-gradient-to-r from-[#2a1810] to-[#3d2817] text-[#e8d4b8] py-8 text-center border-t border-[#5c3d2e]">
        <p class="text-sm">© {{ date('Y') }} SeduhRasa Coffee. All rights reserved.</p>
    </footer>

    {{-- SCRIPT HAMBURGER / MOBILE MENU --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const btn = document.getElementById('mobile-menu-button');
            const menu = document.getElementById('mobile-menu');
            const dots = btn?.querySelector('.hamburger-dots');

            if (btn && menu && dots) {
                btn.addEventListener('click', () => {
                    menu.classList.toggle('hidden');
                    dots.classList.toggle('active');
                });
            }
        });
    </script>

    @stack('scripts')
</body>

</html>