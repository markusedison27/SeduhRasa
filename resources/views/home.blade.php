{{-- resources/views/home.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SeduhRasa Coffee</title>

  @vite(['resources/css/app.css','resources/js/app.js'])

  {{-- Font cursive untuk judul --}}
  <link href="https://fonts.bunny.net/css?family=playfair-display:700|great-vibes:400" rel="stylesheet" />
</head>
<body class="bg-stone-50 text-stone-900">

  {{-- TOP BAR / NAV --}}
  <header class="absolute inset-x-0 top-0 z-20">
    <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between text-sm">
      <div class="flex items-center gap-6">
        <div class="flex items-center gap-2 font-bold text-white">
          <img src="https://cdn-icons-png.flaticon.com/512/2965/2965567.png" class="w-6 h-6" alt="logo">
          <span>Seduh<span class="text-amber-500">Rasa</span></span>
        </div>
        <nav class="hidden md:flex items-center gap-5 text-white/90">
          <a href="#" class="hover:text-white">Home</a>
          <a href="{{ url('/about') }}" class="hover:text-white/100">About Us</a>
          <a href="{{ route('services') }}" class="hover:text-white/100">Services</a>
          <a href="#product" class="hover:text-white/100">Product</a>
          <a href="{{ route('contact') }}" class="hover:text-white/100">Contact</a>
        </nav>
      </div>

      <div class="hidden md:flex items-center gap-2 text-white/90">
        <a href="{{ route('order') }}" class="px-3 py-1.5 rounded bg-amber-500 hover:bg-amber-600 text-stone-900 font-medium">
          Order
        </a>
      </div>
    </div>
  </header>

  {{-- HERO SECTION (auto-slide) --}}
  <section class="relative h-[70vh] md:h-[80vh] w-full overflow-hidden">
    {{-- 3 layer gambar untuk fade cross-fade --}}
    <img class="hero-slide absolute inset-0 w-full h-full object-cover opacity-100 transition-opacity duration-700" src="{{ asset('welcome(1).jpeg') }}" alt="Hero 1">
    <img class="hero-slide absolute inset-0 w-full h-full object-cover opacity-0 transition-opacity duration-700"  src="{{ asset('welcome(2).jpeg') }}" alt="Hero 2">
    <img class="hero-slide absolute inset-0 w-full h-full object-cover opacity-0 transition-opacity duration-700"  src="{{ asset('welcome3.jpg') }}"   alt="Hero 3">

    {{-- overlay --}}
    <div class="absolute inset-0 bg-stone-900/60"></div>

    {{-- content --}}
    <div class="relative z-10 max-w-4xl mx-auto h-full px-4 flex flex-col items-center justify-center text-center text-white">
      <p class="tracking-[0.35em] uppercase text-amber-300 text-xs md:text-sm mb-3">Best Coffee Shop</p>
      <h1 class="font-['Great_Vibes'] text-4xl md:text-6xl leading-tight">
        Kopi dari Perkebunan Cerah<br/>Terbaik
      </h1>
      <a href="#product" class="mt-6 inline-block bg-amber-500 hover:bg-amber-600 text-stone-900 font-semibold rounded px-5 py-2">
        Belanja Sekarang
      </a>
    </div>

    {{-- Arrow kiri/kanan --}}
    <button id="heroPrev"
      class="absolute left-4 top-1/2 -translate-y-1/2 w-10 h-10 grid place-items-center rounded-full bg-white/20 text-white hover:bg-white/30 z-10">
      ‹
    </button>
    <button id="heroNext"
      class="absolute right-4 top-1/2 -translate-y-1/2 w-10 h-10 grid place-items-center rounded-full bg-white/20 text-white hover:bg-white/30 z-10">
      ›
    </button>
  </section>

  {{-- BEST SELLER SECTION --}}
  <section id="product" class="py-12 md:py-16 bg-[#f6efe7]">
    <div class="max-w-7xl mx-auto px-4">
      <div class="text-center mb-8">
        <h2 class="font-['Great_Vibes'] text-3xl md:text-5xl">Produk Terlaris Minggu Ini!</h2>
        <p class="text-stone-600 max-w-2xl mx-auto mt-2">
          Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
        </p>
      </div>

      @php
        $products = [
          ['name'=>'Caffè Latte', 'image'=>'https://images.unsplash.com/photo-1541167760496-1628856ab772?q=80&w=800&auto=format&fit=crop', 'rating'=>4],
          ['name'=>'Cappuccino', 'image'=>'https://images.unsplash.com/photo-1504754524776-8f4f37790ca0?q=80&w=800&auto=format&fit=crop', 'rating'=>5],
          ['name'=>'Americano', 'image'=>'https://images.unsplash.com/photo-1503602642458-232111445657?q=80&w=800&auto=format&fit=crop', 'rating'=>4],
          ['name'=>'Cortado', 'image'=>'https://images.unsplash.com/photo-1529070538774-1843cb3265df?q=80&w=800&auto=format&fit=crop', 'rating'=>5],
        ];
      @endphp

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($products as $p)
          <div class="bg-white rounded-lg shadow border overflow-hidden hover:shadow-md transition">
            <div class="aspect-square bg-stone-100">
              <img src="{{ $p['image'] }}" class="w-full h-full object-cover" alt="{{ $p['name'] }}">
            </div>
            <div class="p-4 space-y-2">
              <div class="flex items-center gap-1 text-amber-500">
                @for($i=1;$i<=5;$i++)
                  @if($i <= $p['rating'])
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M10 15.27l5.18 3.05-1.64-5.81 4.46-3.86-5.85-.5L10 2 7.85 8.15l-5.85.5 4.46 3.86-1.64 5.81z"/></svg>
                  @else
                    <svg class="w-4 h-4 text-stone-300" viewBox="0 0 20 20" fill="currentColor"><path d="M10 15.27l5.18 3.05-1.64-5.81 4.46-3.86-5.85-.5L10 2 7.85 8.15l-5.85.5 4.46 3.86-1.64 5.81z"/></svg>
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

  {{-- FOOTER --}}
  <footer class="py-8 text-center text-sm text-stone-500">
    © {{ date('Y') }} SeduhRasa Coffee. All rights reserved.
  </footer>

  {{-- === HERO SLIDER SCRIPT (vanilla JS) === --}}
  <script>
    (function () {
      // kalau kamu ganti/ganti nama file, ubah juga array ini:
      const slidesSrc = [
        "{{ asset('welcome(1).jpeg') }}",
        "{{ asset('welcome(2).jpeg') }}",
        "{{ asset('welcome3.jpg') }}"
      ];

      const slides = document.querySelectorAll('.hero-slide');
      let current = 0;
      let timer  = null;
      const INTERVAL = 5000; // 5 detik

      function show(index) {
        slides.forEach((el, i) => {
          el.classList.toggle('opacity-100', i === index);
          el.classList.toggle('opacity-0',   i !== index);
        });
        current = index;
      }

      function next() {
        show((current + 1) % slides.length);
      }

      function prev() {
        show((current - 1 + slides.length) % slides.length);
      }

      function start() {
        stop();
        timer = setInterval(next, INTERVAL);
      }

      function stop() {
        if (timer) clearInterval(timer);
        timer = null;
      }

      // pastikan src sesuai array (opsional, sebagai sinkronisasi)
      slides.forEach((img, i) => { if (slidesSrc[i]) img.src = slidesSrc[i]; });

      // init
      show(0);
      start();

      // tombol
      document.getElementById('heroNext').addEventListener('click', () => { next(); start(); });
      document.getElementById('heroPrev').addEventListener('click', () => { prev(); start(); });

      // pause saat hover (opsional)
      const hero = document.querySelector('section.relative');
      hero.addEventListener('mouseenter', stop);
      hero.addEventListener('mouseleave', start);
    })();
  </script>
</body>
</html>
