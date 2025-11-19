{{-- resources/views/layouts/frontend.blade.php --}}
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'SeduhRasa Coffee')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Font cursive untuk judul --}}
    <link href="https://fonts.bunny.net/css?family=playfair-display:700|great-vibes:400" rel="stylesheet" />
</head>

<body class="bg-stone-50 text-stone-900">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Righteous&display=swap" rel="stylesheet">

    {{-- NAV --}}
    <header class="fixed inset-x-0 top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between text-sm bg-stone-900/90 backdrop-blur-sm">
            <div class="flex items-center gap-6">
                <div class="flex items-center gap-2 font-bold text-white">
                    <img src="https://cdn-icons-png.flaticon.com/512/2965/2965567.png" class="w-6 h-6" alt="logo">
                    <span>Seduh<span class="text-amber-500">Rasa</span></span>
                </div>
                <nav class="hidden md:flex items-center gap-5 text-white/90">
                    {{-- Navigasi menggunakan route name --}}
                    <a href="{{ route('home') }}" 
                       class="@if(request()->routeIs('home')) text-amber-400 font-semibold @else hover:text-amber-400 @endif">Home</a>
                    <a href="{{ route('about') }}" 
                       class="@if(request()->routeIs('about')) text-amber-400 font-semibold @else hover:text-amber-400 @endif">About Us</a>
                    <a href="{{ route('services') }}" 
                       class="@if(request()->routeIs('services')) text-amber-400 font-semibold @else hover:text-amber-400 @endif">Services</a>
                    <a href="{{ route('home') }}#product" class="hover:text-amber-400">Product</a>
                    <a href="{{ route('contact') }}" 
                       class="@if(request()->routeIs('contact')) text-amber-400 font-semibold @else hover:text-amber-400 @endif">Contact</a>
                </nav>
            </div>
            <div class="hidden md:flex items-center gap-2 text-white/90">
                <a href="{{ route('order') }}"
                    class="px-3 py-1.5 rounded bg-amber-500 hover:bg-amber-600 text-stone-900 font-medium">
                    Order
                </a>
            </div>
        </div>
    </header>

    {{-- MAIN CONTENT --}}
    <div class="flex-grow">
        @yield('content')
    </div>

    {{-- FOOTER --}}
  <footer class="w-full bg-[#ff8c00] text-white text-center py-4 text-sm">
    © {{ date('Y') }} SeduhRasa Coffee. All rights reserved.
</footer>

    @stack('scripts')
</body>

</html>