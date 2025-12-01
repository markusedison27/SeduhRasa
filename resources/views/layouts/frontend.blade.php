{{-- resources/views/layouts/frontend.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SeduhRasa Coffee')</title>
    
    {{-- Favicon --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Font cursive untuk judul --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">

    @stack('styles')
</head>

<body class="bg-stone-50">

    {{-- NAV --}}
    <nav class="fixed top-0 left-0 right-0 z-50 bg-gradient-to-r from-[#2a1810] to-[#3d2817] shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex items-center justify-between h-20">

                {{-- Logo --}}
                <a href="/" class="flex items-center gap-3 group">
                    <div class="w-12 h-12 bg-gradient-to-br from-[#8b6f47] to-[#c4905c] rounded-full flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/>
                        </svg>
                    </div>
                    <span class="font-['Great_Vibes'] text-3xl text-[#f5e6d3] group-hover:text-[#c4905c] transition-colors duration-300">
                        SeduhRasa
                    </span>
                </a>
                
                {{-- Navigation Menu --}}
                <div class="hidden md:flex items-center gap-8">
                    <a href="/" class="text-[#e8d4b8] hover:text-[#c4905c] font-medium transition-colors duration-300">
                        Home
                    </a>
                    <a href="#about" class="text-[#e8d4b8] hover:text-[#c4905c] font-medium transition-colors duration-300">
                        About Us
                    </a>
                    <a href="#services" class="text-[#e8d4b8] hover:text-[#c4905c] font-medium transition-colors duration-300">
                        Services
                    </a>
                    <a href="#product" class="text-[#e8d4b8] hover:text-[#c4905c] font-medium transition-colors duration-300">
                        Product
                    </a>
                    <a href="#contact" class="text-[#e8d4b8] hover:text-[#c4905c] font-medium transition-colors duration-300">
                        Contact
                    </a>
                </div>
            </div>
        </div>
    </nav>

    {{-- MAIN CONTENT --}}
    <main class="min-h-screen">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer class="bg-gradient-to-r from-[#2a1810] to-[#3d2817] text-[#e8d4b8] py-8 text-center border-t border-[#5c3d2e]">
        <p class="text-sm">© {{ date('Y') }} SeduhRasa Coffee. All rights reserved.</p>
    </footer>

    @stack('scripts')
</body>
</html>