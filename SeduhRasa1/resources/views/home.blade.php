{{-- resources/views/home.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SeduhRasa Coffee</title>
  @vite(['resources/css/app.css','resources/js/app.js'])

  {{-- Font cursive untuk judul hero (mirip di contoh) --}}
  <link href="https://fonts.bunny.net/css?family=playfair-display:700|great-vibes:400" rel="stylesheet"/>
</head>
<body class="bg-stone-50 text-stone-900">

  {{-- TOP BAR / NAV --}}
  <header class="absolute inset-x-0 top-0 z-20">
    <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between text-sm">
      <div class="flex items-center gap-6">
        <div class="flex items-center gap-2 font-bold">
          <img src="https://cdn-icons-png.flaticon.com/512/2965/2965567.png" class="w-6 h-6" alt="logo">
          <span>Seduh<span class="text-amber-500">Rasa</span></span>
        </div>
        <div class="hidden md:flex items-center gap-5 text-white/90">
          <a href="#" class="hover:text-white">Home</a>
          <a href="#about" class="hover:text-white/100">About Us</a>
          <a href="#services" class="hover:text-white/100">Services</a>
          <a href="#product" class="hover:text-white/100">Product</a>
          <a href="#contact" class="hover:text-white/100">Contact</a>
        </div>
      </div>
      <div class="hidden md:flex items-center gap-2 text-white/90">
        <button class="px-3 py-1.5 rounded bg-amber-500 hover:bg-amber-600 text-stone-900 font-medium">Order</button>
      </div>
    </div>
  </header>

  {{-- HERO SECTION --}}
  <section class="relative h-[70vh] md:h-[80vh] w-full overflow-hidden">
    {{-- Pakai gambar upload kalau ada (storage:link), kalau tidak pakai fallback Unsplash --}}
    @php
      $hero = isset($site) && !empty($site?->hero_image)
        ? asset('storage/'.$site->hero_image)
        : 'https://images.unsplash.com/photo-1511920170033-f8396924c348?q=80&w=1600&auto=format&fit=crop';
    @endphp

    <img src="{{ $hero }}" class="absolute inset-0 w-full h-full object-cover" alt="Hero">
    <div class="absolute inset-0 bg-stone-900/60"></div>

    <div class="relative z-10 max-w-4xl mx-auto h-full px-4 flex flex-col items-center justify-center text-center text-white">
      <p class="tracking-[0.35em] uppercase text-amber-300 text-xs md:text-sm mb-3">Best Coffee Shop</p>

      <h1 class="font-['Great_Vibes'] text-4xl md:text-6xl leading-tight">
        Coffee from the Best Sunny<br/>Plantations
      </h1>

      <a href="#product" class="mt-6 inline-block bg-amber-500 hover:bg-amber-600 text-stone-900 font-semibold rounded px-5 py-2">
        Shop Now
      </a>
    </div>

    {{-- “arrow” kiri/kanan (dummy) --}}
    <button class="absolute left-4 top-1/2 -translate-y-1/2 w-10 h-10 grid place-items-center rounded-full bg-white/20 text-white hover:bg-white/30">
      ‹
    </button>
    <button class="absolute right-4 top-1/2 -translate-y-1/2 w-10 h-10 grid place-items-center rounded-full bg-white/20 text-white hover:bg-white/30">
      ›
    </button>
  </section>

  {{-- BEST SELLER SECTION --}}
  <section id="product" class="py-12 md:py-16 bg-[#f6efe7]">
    <div class="max-w-7xl mx-auto px-4">
      <div class="text-center mb-8">
        <h2 class="font-['Great_Vibes'] text-3xl md:text-5xl">Best Seller Product This Week!</h2>
        <p class="text-stone-600 max-w-2xl mx-auto mt-2">
          Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
        </p>
      </div>

      {{-- Data produk (mock). Nanti bisa ganti ambil dari DB --}}
      @php
        $products = [
          ['name'=>'Caffè Latte', 'price'=>23, 'image'=>'https://images.unsplash.com/photo-1541167760496-1628856ab772?q=80&w=800&auto=format&fit=crop', 'rating'=>4],
          ['name'=>'Cappuccino', 'price'=>23, 'image'=>'https://images.unsplash.com/photo-1504754524776-8f4f37790ca0?q=80&w=800&auto=format&fit=crop', 'rating'=>5],
          ['name'=>'Americano', 'price'=>23, 'image'=>'https://images.unsplash.com/photo-1503602642458-232111445657?q=80&w=800&auto=format&fit=crop', 'rating'=>4],
          ['name'=>'Cortado', 'price'=>23, 'image'=>'https://images.unsplash.com/photo-1529070538774-1843cb3265df?q=80&w=800&auto=format&fit=crop', 'rating'=>5],
        ];
      @endphp

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($products as $p)
        <div class="bg-white rounded-lg shadow border overflow-hidden">
          <div class="aspect-square bg-stone-100">
            <img src="{{ $p['image'] }}" class="w-full h-full object-cover" alt="{{ $p['name'] }}">
          </div>
          <div class="p-4 space-y-2">
            {{-- rating bintang --}}
            <div class="flex items-center gap-1 text-amber-500">
              @for($i=1;$i<=5;$i++)
                @if($i <= $p['rating'])
                  <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M10 15.27l5.18 3.05-1.64-5.81 4.46-3.86-5.85-.5L10 2 7.85 8.15l-5.85.5 4.46 3.86-1.64 5.81z"/></svg>
                @else
                  <svg class="w-4 h-4 text-stone-300" viewBox="0 0 20 20" fill="currentColor"><path d="M10 15.27l5.18 3.05-1.64-5.81 4.46-3.86-5.85-.5L10 2 7.85 8.15l-5.85.5 4.46 3.86-1.64 5.81z"/></svg>
                @endif
              @endfor
            </div>

            <div class="font-semibold">{{ $p['name'] }}</div>
            <div class="text-stone-500 text-sm">Coffee Moka</div>

            <div class="flex items-center justify-between pt-2">
              <div class="font-extrabold">\$ {{ $p['price'] }}</div>
              <button class="px-3 py-1.5 text-sm rounded bg-stone-900 text-white hover:bg-stone-800">Add</button>
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
</body>
</html>
