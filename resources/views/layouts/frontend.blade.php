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

    @stack('styles')
</head>

<body class="bg-stone-50">
    
    {{-- NAVBAR --}}
    <nav class="fixed top-0 left-0 right-0 z-50 bg-gradient-to-r from-[#2a1810] to-[#3d2817] shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex items-center justify-between h-20">

                {{-- Logo: balik ke HOME (SUDAH DIUBAH MENJADI LOGO2.PNG) --}}
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    {{-- AREA IKON LAMA DIGANTI IMG --}}
                    <div class="w-12 h-12 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <img src="{{ asset('LOGO2.png') }}" alt="Logo SeduhRasa" class="h-full w-auto object-contain">
                    </div>
                    <span class="font-['Great_Vibes'] text-3xl text-[#f5e6d3] group-hover:text-[#c4905c] transition-colors duration-300">
                        SeduhRasa
                    </span>
                </a>

                {{-- MENU --}}
                <div class="hidden md:flex items-center gap-8 text-[#f5e6d3] font-medium">
                    <a href="{{ route('home') }}"
                       class="hover:text-[#c4905c] transition-colors">
                        Home
                    </a>
                    <a href="{{ route('about') }}"
                       class="hover:text-[#c4905c] transition-colors">
                        About Us
                    </a>
                    <a href="{{ route('services') }}"
                       class="hover:text-[#c4905c] transition-colors">
                        Services
                    </a>
                    <a href="{{ route('contact') }}"
                       class="hover:text-[#c4905c] transition-colors">
                        Contact
                    </a>
                </div>
            </div>
        </div>
    </nav>

    {{-- KONTEN HALAMAN --}}
    <main class="min-h-screen pt-20">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer class="bg-gradient-to-r from-[#2a1810] to-[#3d2817] text-[#e8d4b8] py-8 text-center border-t border-[#5c3d2e]">
        <p class="text-sm">© {{ date('Y') }} SeduhRasa Coffee. All rights reserved.</p>
    </footer>

    @stack('scripts')
</body>
</html>