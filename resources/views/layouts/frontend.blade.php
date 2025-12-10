{{-- resources/views/layouts/frontend.blade.php --}}
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'SeduhRasa Coffee')</title>

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('LOGO2(512x512).png') }}">
    <link rel="apple-touch-icon" href="{{ asset('LOGO2(512x512).png') }}">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Font cursive untuk judul --}}
    <link href="https://fonts.bunny.net/css?family=playfair-display:700|great-vibes:400" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Righteous&display=swap" rel="stylesheet">

    <style>
        /* Mobile menu slide */
        .mobile-menu {
            position: fixed;
            top: 0;
            right: -100%;
            width: 280px;
            height: 100vh;
            background: linear-gradient(135deg, #3D2817 0%, #2B1B12 100%);
            transition: right 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 60;
            overflow-y: auto;
        }
        .mobile-menu.active {
            right: 0;
            box-shadow: -10px 0 30px rgba(0,0,0,0.3);
        }

        /* Backdrop overlay */
        .menu-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            backdrop-filter: blur(2px);
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
            z-index: 50;
        }
        .menu-backdrop.active {
            opacity: 1;
            pointer-events: auto;
        }

        /* Hamburger 3 dots minimalis - lebih besar */
        .hamburger {
            width: 28px;
            height: 28px;
            position: relative;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            gap: 4px;
        }
        .hamburger span {
            display: block;
            width: 5px;
            height: 5px;
            background: white;
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 50%;
            box-shadow: 0 0 3px rgba(255,255,255,0.3);
        }
        
        .hamburger.active {
            gap: 0;
        }
        .hamburger.active span:nth-child(1) {
            transform: rotate(45deg) translate(5px, 5px);
            width: 22px;
            height: 2.5px;
            border-radius: 2px;
        }
        .hamburger.active span:nth-child(2) {
            opacity: 0;
            transform: scale(0);
        }
        .hamburger.active span:nth-child(3) {
            transform: rotate(-45deg) translate(5px, -5px);
            width: 22px;
            height: 2.5px;
            border-radius: 2px;
        }

        /* Nav link hover effect */
        .nav-link-mobile {
            position: relative;
            overflow: hidden;
        }
        .nav-link-mobile::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 0;
            height: 2px;
            background: #F59E0B;
            transition: width 0.3s ease;
        }
        .nav-link-mobile:hover::before,
        .nav-link-mobile.active::before {
            width: 30px;
        }
        .nav-link-mobile:hover,
        .nav-link-mobile.active {
            padding-left: 2.5rem;
        }

        /* Animasi Logo - Cuma tulisan masuk */
        .logo-text {
            display: inline-block;
            position: relative;
        }
        
        .logo-seduh, .logo-rasa {
            display: inline-block;
            opacity: 0;
        }

        /* Animasi fade slide in */
        .logo-seduh {
            animation: slideInLeft 0.6s ease-out 0.2s forwards;
        }

        .logo-rasa {
            color: #F59E0B;
            text-shadow: 0 0 20px rgba(245, 158, 11, 0.3);
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

        /* Shine effect on hover */
        .logo-shine {
            position: relative;
            overflow: hidden;
        }

        .logo-shine::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, 
                transparent, 
                rgba(255, 255, 255, 0.3), 
                transparent
            );
            transition: left 0.6s ease;
        }

        .logo-shine:hover::after {
            left: 100%;
        }
    </style>
</head>

<body class="bg-stone-50 text-stone-900">

    {{-- NAV --}}
    <header class="fixed inset-x-0 top-0 z-50 bg-gradient-to-r from-stone-900/98 via-stone-800/98 to-stone-900/98 backdrop-blur-md shadow-lg">
        <div class="w-full px-4 sm:px-6 lg:px-8">
            <div class="flex items-center h-16">
                
                {{-- Left side: Logo + Desktop Navigation --}}
                <div class="flex items-center gap-8 flex-1">
                    {{-- Logo --}}
                    <a href="{{ route('home') }}" class="flex items-center gap-2 font-bold text-white hover:opacity-90 transition-opacity group logo-shine">
                        <img src="{{ asset('LOGO2.png') }}" class="h-7 w-auto transition-transform" alt="SeduhRasa Coffee Logo">
                        <span class="text-lg logo-text whitespace-nowrap">
                            <span class="logo-seduh">Seduh</span><span class="logo-rasa">Rasa</span>
                        </span>
                    </a>

                    {{-- Desktop Navigation --}}
                    <nav class="hidden md:flex items-center gap-6 ml-auto">
                        <a href="{{ route('home') }}" 
                           class="text-sm font-medium transition-colors relative group whitespace-nowrap @if(request()->routeIs('home')) text-amber-400 @else text-white/80 hover:text-white @endif">
                            Home
                            <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-amber-400 transition-all group-hover:w-full @if(request()->routeIs('home')) w-full @endif"></span>
                        </a>
                        <a href="{{ route('about') }}" 
                           class="text-sm font-medium transition-colors relative group whitespace-nowrap @if(request()->routeIs('about')) text-amber-400 @else text-white/80 hover:text-white @endif">
                            About Us
                            <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-amber-400 transition-all group-hover:w-full @if(request()->routeIs('about')) w-full @endif"></span>
                        </a>
                        <a href="{{ route('services') }}" 
                           class="text-sm font-medium transition-colors relative group whitespace-nowrap @if(request()->routeIs('services')) text-amber-400 @else text-white/80 hover:text-white @endif">
                            Services
                            <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-amber-400 transition-all group-hover:w-full @if(request()->routeIs('services')) w-full @endif"></span>
                        </a>
                        <a href="{{ route('home') }}#product" 
                           class="text-sm font-medium text-white/80 hover:text-white transition-colors relative group whitespace-nowrap">
                            Product
                            <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-amber-400 transition-all group-hover:w-full"></span>
                        </a>
                        <a href="{{ route('contact') }}" 
                           class="text-sm font-medium transition-colors relative group whitespace-nowrap @if(request()->routeIs('contact')) text-amber-400 @else text-white/80 hover:text-white @endif">
                            Contact
                            <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-amber-400 transition-all group-hover:w-full @if(request()->routeIs('contact')) w-full @endif"></span>
                        </a>
                    </nav>
                </div>

                {{-- Right side: Hamburger Button (Mobile only) --}}
                <div class="md:hidden">
                    <button id="mobile-menu-button" class="hamburger p-2 hover:bg-white/10 rounded-lg transition-colors" aria-label="Toggle menu">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                </div>
            </div>
        </div>
    </header>

    {{-- Backdrop Overlay --}}
    <div id="menu-backdrop" class="menu-backdrop"></div>

    {{-- Mobile Sidebar Menu --}}
    <nav id="mobile-menu" class="mobile-menu">
        {{-- Header Mobile Menu --}}
        <div class="flex items-center justify-between p-6 border-b border-white/10">
            <div class="flex items-center gap-2">
                <img src="{{ asset('LOGO2.png') }}" class="h-8 w-auto" alt="Logo">
                <span class="text-white font-bold text-lg">Seduh<span class="text-amber-400">Rasa</span></span>
            </div>
            <button id="mobile-close-button" class="text-white/70 hover:text-white p-2 hover:bg-white/10 rounded-lg transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Menu Links --}}
        <div class="flex flex-col gap-1 p-6">
            <a href="{{ route('home') }}" 
               class="nav-link-mobile py-3 px-4 text-white/90 hover:text-white transition-all rounded-lg @if(request()->routeIs('home')) active text-amber-400 font-semibold @endif">
                Home
            </a>
            <a href="{{ route('about') }}" 
               class="nav-link-mobile py-3 px-4 text-white/90 hover:text-white transition-all rounded-lg @if(request()->routeIs('about')) active text-amber-400 font-semibold @endif">
                About Us
            </a>
            <a href="{{ route('services') }}" 
               class="nav-link-mobile py-3 px-4 text-white/90 hover:text-white transition-all rounded-lg @if(request()->routeIs('services')) active text-amber-400 font-semibold @endif">
                Services
            </a>
            <a href="{{ route('home') }}#product" 
               class="nav-link-mobile py-3 px-4 text-white/90 hover:text-white transition-all rounded-lg">
                Product
            </a>
            <a href="{{ route('contact') }}" 
               class="nav-link-mobile py-3 px-4 text-white/90 hover:text-white transition-all rounded-lg @if(request()->routeIs('contact')) active text-amber-400 font-semibold @endif">
                Contact
            </a>
        </div>

        {{-- Order Button Mobile --}}
        <div class="p-6 border-t border-white/10">
            <a href="{{ route('order') }}"
                class="flex items-center justify-center gap-2 w-full px-6 py-3 rounded-xl bg-[#a67c52] hover:bg-[#8b6f47] text-white font-semibold transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
                Order Sekarang
            </a>
        </div>
    </nav>

    {{-- MAIN CONTENT --}}
    <div class="flex-grow">
        @yield('content')
    </div>

    {{-- FOOTER --}}
    <footer style="background: linear-gradient(135deg, #4a2f1a 0%, #654321 50%, #8b5a2b 100%); color: #f5f5f5; text-align: center; padding: 1.5rem; margin-top: 4rem; box-shadow: 0 -4px 30px rgba(0, 0, 0, 0.4), inset 0 1px 0 rgba(255, 255, 255, 0.1); border-top: 2px solid rgba(212, 163, 115, 0.3); font-weight: 500; letter-spacing: 0.3px;">
        © {{ date('Y') }} SeduhRasa Coffee. All rights reserved.
    </footer>

    {{-- Mobile Menu Toggle Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuButton = document.getElementById('mobile-menu-button');
            const closeButton = document.getElementById('mobile-close-button');
            const mobileMenu = document.getElementById('mobile-menu');
            const backdrop = document.getElementById('menu-backdrop');
            
            function openMenu() {
                menuButton.classList.add('active');
                mobileMenu.classList.add('active');
                backdrop.classList.add('active');
                document.body.style.overflow = 'hidden';
            }
            
            function closeMenu() {
                menuButton.classList.remove('active');
                mobileMenu.classList.remove('active');
                backdrop.classList.remove('active');
                document.body.style.overflow = '';
            }
            
            if (menuButton) {
                menuButton.addEventListener('click', openMenu);
            }
            
            if (closeButton) {
                closeButton.addEventListener('click', closeMenu);
            }
            
            if (backdrop) {
                backdrop.addEventListener('click', closeMenu);
            }

            // Close menu when clicking on a link
            const mobileLinks = mobileMenu?.querySelectorAll('a');
            mobileLinks?.forEach(link => {
                link.addEventListener('click', closeMenu);
            });

            // Close on ESC key
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    closeMenu();
                }
            });
        });
    </script>

    @stack('scripts')
</body>

</html>
