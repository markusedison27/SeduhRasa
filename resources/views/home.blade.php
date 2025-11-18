@extends('layouts.frontend')

@section('title', 'SeduhRasa Coffee - Kopi Terbaik')

@section('content')
    {{-- HERO --}}
    <section class="relative h-[70vh] md:h-[80vh] w-full overflow-hidden pt-16">
        {{-- Logika dan data Slideshow diletakkan di sini, sama seperti file aslinya --}}
        @php
            $hero = 'https://images.unsplash.com/photo-1511920170033-f8396924c348?auto=format&fit=crop&w=1920&q=85'; 
            $slides = [ $hero, asset('leccata1.jpg'), asset('leccata2.jpg'), asset('leccata3.jpg') ];
            $uniqueSlides = array_values(array_filter(array_unique($slides)));
        @endphp

        <img id="heroA" src="{{ $hero }}" class="absolute inset-0 w-full h-full object-cover transition-opacity duration-700 opacity-100 -z-10 pointer-events-none">
        <img id="heroB" src="{{ $hero }}" class="absolute inset-0 w-full h-full object-cover transition-opacity duration-700 opacity-0 -z-10 pointer-events-none">

        <div class="absolute inset-0 bg-gradient-to-b from-black/30 via-black/40 to-amber-900/30 -z-10 pointer-events-none"></div>

        <div class="relative z-0 max-w-4xl mx-auto h-full px-4 flex items-center justify-center">
            <div class="bg-[#fbf5ef]/95 text-stone-900 border border-amber-300/60 rounded-3xl px-6 py-6 md:px-12 md:py-9 text-center shadow-[0_18px_45px_rgba(0,0,0,0.35)]">
                <p class="hero-tagline tracking-[0.35em] uppercase text-amber-500 text-xs md:text-sm mb-3">Best Coffee Shop</p>
                <h1 class="hero-title font-['Great_Vibes'] text-4xl md:text-6xl leading-tight text-stone-900">
                    Coffee from the Best Sunny<br />Plantations
                </h1>
                <a href="#product" class="hero-button mt-6 inline-block bg-amber-400 hover:bg-amber-500 text-white font-semibold rounded-full px-7 py-2.5 shadow-md">
                    Shop Now
                </a>
            </div>
        </div>
    </section>

    {{-- HAPUS: ABOUT US SECTION --}}
    {{-- HAPUS: SERVICES SECTION --}}

    {{-- BEST SELLER (Tetap di home) --}}
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
                    ['name' => 'Caffè Latte', 'image' => 'https://images.unsplash.com/photo-1541167760496-1628856ab772?auto=format&fit=crop&w=800&q=80', 'rating' => 4],
                    ['name' => 'Cappuccino', 'image' => 'https://cdn.kerbel.in/assets/product/product_IDVGUOCHLR_1664033686_1.webp', 'rating' => 5],
                    ['name' => 'Americano', 'image' => 'https://res.cloudinary.com/dk0z4ums3/image/upload/v1747970767/attached_image/5-manfaat-americano-untuk-diet-yang-sayang-untuk-dilewatkan-0-alodokter.jpg', 'rating' => 4],
                    ['name' => 'Matcha Latte', 'image' => 'https://assets.bonappetit.com/photos/57b4df9f3e1d654349a2fefb/1:1/w_1920,c_limit/iced-matcha-latte.jpg', 'rating' => 5],
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
                                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M10 15.27l5.18 3.05-1.64-5.81 4.46-3.86-5.85-.5L10 2 7.85 8.15l-5.85.5 4.46 3.86-1.64 5.81z" /></svg>
                                    @else
                                        <svg class="w-4 h-4 text-stone-300" viewBox="0 0 20 20" fill="currentColor"><path d="M10 15.27l5.18 3.05-1.64-5.81 4.46-3.86-5.85-.5L10 2 7.85 8.15l-5.85.5 4.46 3.86-1.64 5.81z" /></svg>
                                    @endif
                                @endfor
                            </div>
                            <div class="font-semibold text-lg">{{ $p['name'] }}</div>
                            <div class="pt-2">
                                <button class="w-full py-2 text-sm rounded bg-stone-900 text-white hover:bg-stone-800">Add</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    {{-- SLIDESHOW JAVASCRIPT --}}
    <script>
        (function() {
            const slides = @json($uniqueSlides ?? []);
            
            if (slides.length <= 1) return;

            const a = document.getElementById('heroA');
            const b = document.getElementById('heroB');

            let i = 0,
                useA = true;

            function tick() {
                i = (i + 1) % slides.length;
                const nextSrc = slides[i];

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

            setInterval(tick, 6000);
        })();
    </script>
@endpush