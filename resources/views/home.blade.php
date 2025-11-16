{{-- resources/views/home.blade.php --}}
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SeduhRasa Coffee</title>
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
        <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between text-sm">
            <div class="flex items-center gap-6">
                <div class="flex items-center gap-2 font-bold text-white">
                    <img src="https://cdn-icons-png.flaticon.com/512/2965/2965567.png" class="w-6 h-6" alt="logo">
                    <span>Seduh<span class="text-amber-500">Rasa</span></span>
                </div>
                <nav class="hidden md:flex items-center gap-5 text-white/90">
                    <a href="{{ route('home') }}">Home</a>
                    <a href="{{ url('/') }}#about">About Us</a>
                    <a href="{{ url('/') }}#services">Services</a>
                    <a href="{{ url('/') }}#product">Product</a>
                    <a href="/contact">Contact</a>
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

    {{-- HERO --}}
    <section class="relative h-[70vh] md:h-[80vh] w-full overflow-hidden pt-16">
        @php
            $hero = isset($site) && !empty($site?->hero_image)
                ? asset('storage/' . $site->hero_image)
                : 'https://images.unsplash.com/photo-1511920170033-f8396924c348?auto=format&fit=crop&w=1920&q=85';
        @endphp

        {{-- Gambar background + slideshow --}}
        <img id="heroA" src="{{ $hero }}"
            class="absolute inset-0 w-full h-full object-cover transition-opacity duration-700 opacity-100 -z-10 pointer-events-none">
        <img id="heroB" src="{{ $hero }}"
            class="absolute inset-0 w-full h-full object-cover transition-opacity duration-700 opacity-0 -z-10 pointer-events-none">

        {{-- Overlay hangat tipis --}}
        <div
            class="absolute inset-0 bg-gradient-to-b from-black/30 via-black/40 to-amber-900/30 -z-10 pointer-events-none">
        </div>

        {{-- Konten teks di tengah --}}
        <div class="relative z-0 max-w-4xl mx-auto h-full px-4 flex items-center justify-center">
            <div
                class="bg-[#fbf5ef]/95 text-stone-900
               border border-amber-300/60 rounded-3xl
               px-6 py-6 md:px-12 md:py-9 text-center
               shadow-[0_18px_45px_rgba(0,0,0,0.35)]">

                <p
                    class="hero-tagline tracking-[0.35em] uppercase text-amber-500 text-xs md:text-sm mb-3">
                    Best Coffee Shop
                </p>

                <h1
                    class="hero-title font-['Great_Vibes'] text-4xl md:text-6xl leading-tight text-stone-900">
                    Coffee from the Best Sunny<br />Plantations
                </h1>

                <a href="{{ url('/') }}#product"
                    class="hero-button mt-6 inline-block bg-amber-400 hover:bg-amber-500
                          text-white font-semibold rounded-full px-7 py-2.5 shadow-md">
                    Shop Now
                </a>
            </div>
        </div>
    </section>

    {{-- ========================= --}}
    {{-- 🔥 ABOUT US + TEAM LIST --}}
    {{-- ========================= --}}
    <section id="about" class="scroll-mt-20 py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h2 class="font-['Great_Vibes'] text-3xl md:text-5xl mb-6">About Us</h2>
            <p class="max-w-2xl mx-auto text-stone-600 mb-10">
                Kami adalah kelompok pengembang SeduhRasa Coffee yang berfokus menciptakan website modern,
                responsif, dan nyaman digunakan. Berikut adalah anggota tim kami:
            </p>

            @php
                $team = [
                    [
                        'name' => 'M. Arifin Ilham',
                        'img' => 'https://cdn-icons-png.flaticon.com/512/4140/4140048.png',
                        'ig' => 'https://instagram.com/arifinilham',
                    ],
                    [
                        'name' => 'Mazira',
                        'img' => 'https://cdn-icons-png.flaticon.com/512/4140/4140051.png',
                        'ig' => 'https://instagram.com/mazira',
                    ],
                    [
                        'name' => 'Markus Edison',
                        'img' => 'https://cdn-icons-png.flaticon.com/512/4140/4140037.png',
                        'ig' => 'https://instagram.com/markusedison',
                    ],
                    [
                        'name' => 'Elsa Syafitriani',
                        'img' => 'https://cdn-icons-png.flaticon.com/512/4140/4140051.png',
                        'ig' => 'https://instagram.com/elsasyafitriani',
                    ],
                ];
            @endphp

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mt-8">
                @foreach ($team as $t)
                    <a href="{{ $t['ig'] }}" target="_blank"
                        class="bg-stone-50 border rounded-lg shadow hover:shadow-md transition p-5 flex flex-col items-center">
                        <img src="{{ $t['img'] }}" class="w-20 h-20 mb-4" alt="{{ $t['name'] }}">
                        <div class="font-semibold text-stone-800">{{ $t['name'] }}</div>
                        <div class="text-amber-500 text-sm mt-1">@ Instagram</div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ================================================= --}}
    {{-- 🔥🔥 SERVICES SECTION (DITAMBAHKAN, TIDAK ADA YANG DIUBAH) --}}
    {{-- ================================================= --}}
    <section id="services" class="scroll-mt-20 py-16 bg-[#fbf5ef]">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h2 class="font-['Great_Vibes'] text-3xl md:text-5xl mb-6">Our Services</h2>
            <p class="max-w-2xl mx-auto text-stone-600 mb-10">
                Kami menyediakan berbagai layanan untuk memastikan pengalaman terbaik bagi pelanggan SeduhRasa Coffee.
            </p>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div class="p-6 bg-white rounded-lg shadow border hover:shadow-md transition">
                    <img src="https://cdn-icons-png.flaticon.com/512/3515/3515301.png"
                        class="w-16 h-16 mx-auto mb-4" />
                    <h3 class="font-semibold text-lg mb-2">Fresh Coffee</h3>
                    <p class="text-stone-600 text-sm">Biji kopi pilihan dengan kualitas terbaik.</p>
                </div>

                <div class="p-6 bg-white rounded-lg shadow border hover:shadow-md transition">
                    <img src="https://cdn-icons-png.flaticon.com/512/1046/1046784.png"
                        class="w-16 h-16 mx-auto mb-4" />
                    <h3 class="font-semibold text-lg mb-2">Fast Delivery</h3>
                    <p class="text-stone-600 text-sm">Pesanan diantar cepat & aman ke lokasi Anda.</p>
                </div>

                <div class="p-6 bg-white rounded-lg shadow border hover:shadow-md transition">
                    <img src="https://cdn-icons-png.flaticon.com/512/609/609361.png"
                        class="w-16 h-16 mx-auto mb-4" />
                    <h3 class="font-semibold text-lg mb-2">Premium Quality</h3>
                    <p class="text-stone-600 text-sm">Kami selalu menjaga kualitas dan rasa kopi.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- BEST SELLER --}}
    <section id="product" class="scroll-mt-20 py-12 md:py-16 bg-[#f6efe7]">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-8">
                <h2 class="font-['Great_Vibes'] text-3xl md:text-5xl">Best Seller Product This Week!</h2>
                <p class="text-stone-600 max-w-2xl mx-auto mt-2">
                    Kadang hidup cuma butuh satu hal sederhana: secangkir kopi dan waktu untuk menikmatinya...
                </p>
            </div>

            @php
                $products = [
                    [
                        'name' => 'Caffè Latte',
                        'image' =>
                            'https://images.unsplash.com/photo-1541167760496-1628856ab772?auto=format&fit=crop&w=800&q=80',
                        'rating' => 4,
                    ],
                    [
                        'name' => 'Cappuccino',
                        'image' => 'https://cdn.kerbel.in/assets/product/product_IDVGUOCHLR_1664033686_1.webp',
                        'rating' => 5,
                    ],
                    [
                        'name' => 'Americano',
                        'image' =>
                            'https://res.cloudinary.com/dk0z4ums3/image/upload/v1747970767/attached_image/5-manfaat-americano-untuk-diet-yang-sayang-untuk-dilewatkan-0-alodokter.jpg',
                        'rating' => 4,
                    ],
                    [
                        'name' => 'Matcha Latte',
                        'image' =>
                            'https://assets.bonappetit.com/photos/57b4df9f3e1d654349a2fefb/1:1/w_1920,c_limit/iced-matcha-latte.jpg',
                        'rating' => 5,
                    ],
                ];
            @endphp

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($products as $p)
                    <div class="bg-white rounded-lg shadow border overflow-hidden hover:shadow-md transition">
                        <div class="aspect-square bg-stone-100">
                            <img src="{{ $p['image'] }}" class="w-full h-full object-cover">
                        </div>
                        <div class="p-4 space-y-2">
                            <div class="flex items-center gap-1 text-amber-500">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $p['rating'])
                                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                            <path
                                                d="M10 15.27l5.18 3.05-1.64-5.81 4.46-3.86-5.85-.5L10 2 7.85 8.15l-5.85.5 4.46 3.86-1.64 5.81z" />
                                        </svg>
                                    @else
                                        <svg class="w-4 h-4 text-stone-300" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path
                                                d="M10 15.27l5.18 3.05-1.64-5.81 4.46-3.86-5.85-.5L10 2 7.85 8.15l-5.85.5 4.46 3.86-1.64 5.81z" />
                                        </svg>
                                    @endif
                                @endfor
                            </div>
                            <div class="font-semibold text-lg">{{ $p['name'] }}</div>
                            <div class="pt-2">
                                <button
                                    class="w-full py-2 text-sm rounded bg-stone-900 text-white hover:bg-stone-800">Add</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- FOOTER --}}
    <footer class="py-8 text-center text-sm text-stone-500">
        © {{ date('Y') }} SeduhRasa Coffee. All rights reserved.
    </footer>

    {{-- SLIDESHOW --}}
    <script>
        (function() {
            const slides = [
                "{{ $hero }}",
                "{{ asset('leccata1.jpg') }}",
                "{{ asset('leccata2.jpg') }}",
                "{{ asset('leccata3.jpg') }}"
            ];

            const unique = [...new Set(slides.filter(Boolean))];
            unique.forEach(src => {
                const i = new Image();
                i.src = src;
            });

            const a = document.getElementById('heroA');
            const b = document.getElementById('heroB');

            let i = 0,
                useA = true;

            function tick() {
                i = (i + 1) % unique.length;
                const nextSrc = unique[i];

                if (useA) {
                    b.src = nextSrc;
                    b.classList.remove('opacity-0');
                    b.classList.add('opacity-100');
                    a.classList.remove('opacity-100');
                    a.classList.add('opacity-0');
                } else {
                    a.src = nextSrc;
                    a.classList.remove('opacity-0');
                    a.classList.add('opacity-100');
                    b.classList.remove('opacity-100');
                    b.classList.add('opacity-0');
                }
                useA = !useA;
            }

            if (unique.length > 1) setInterval(tick, 6000);
        })();
    </script>

</body>

</html>
