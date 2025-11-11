{{-- resources/views/home.blade.php --}}
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SeduhRasa Coffee</title>
  @vite(['resources/css/app.css','resources/js/app.js'])

  {{-- Font cursive untuk judul --}}
  <link href="https://fonts.bunny.net/css?family=playfair-display:700|great-vibes:400" rel="stylesheet" />
</head>
<body class="bg-stone-50 text-stone-900">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Righteous&display=swap" rel="stylesheet">

  {{-- NAV (fixed + z tinggi) --}}
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
          <a href="/contact">Contact</a> {{-- diarahkan ke halaman /contact --}}
        </nav>
      </div>
      <div class="hidden md:flex items-center gap-2 text-white/90">
        <a href="{{ route('order') }}" class="px-3 py-1.5 rounded bg-amber-500 hover:bg-amber-600 text-stone-900 font-medium">
          Order
        </a>
      </div>
    </div>
  </header>

  {{-- HERO (AUTO SLIDESHOW) --}}
  <section class="relative h-[70vh] md:h-[80vh] w-full overflow-hidden pt-16">
    @php
      $hero = isset($site) && !empty($site?->hero_image)
        ? asset('storage/'.$site->hero_image)
        : 'https://images.unsplash.com/photo-1511920170033-f8396924c348?auto=format&fit=crop&w=1920&q=85';
    @endphp

    {{-- two-layer crossfade; dekoratif (tidak nangkep klik) + z rendah --}}
    <img id="heroA" src="{{ $hero }}"
         class="absolute inset-0 w-full h-full object-cover transition-opacity duration-700 opacity-100 -z-10 pointer-events-none"
         alt="Hero 1">
    <img id="heroB" src="{{ $hero }}"
         class="absolute inset-0 w-full h-full object-cover transition-opacity duration-700 opacity-0 -z-10 pointer-events-none"
         alt="Hero 2">
    <div class="absolute inset-0 bg-stone-900/55 -z-10 pointer-events-none"></div>

    {{-- konten hero --}}
    <div class="relative z-0 max-w-4xl mx-auto h-full px-4 flex flex-col items-center justify-center text-center text-white">
      <p class="tracking-[0.35em] uppercase text-amber-300 text-xs md:text-sm mb-3">Best Coffee Shop</p>
      <h1 class="font-['Great_Vibes'] text-4xl md:text-6xl leading-tight">
        Coffee from the Best Sunny<br/>Plantations
      </h1>
      <a href="{{ url('/') }}#product" class="mt-6 inline-block bg-amber-500 hover:bg-amber-600 text-stone-900 font-semibold rounded px-5 py-2">
        Shop Now
      </a>
    </div>

    {{-- arrows (dummy) --}}
    <button class="absolute left-4 top-1/2 -translate-y-1/2 w-10 h-10 grid place-items-center rounded-full bg-white/20 text-white hover:bg-white/30">‹</button>
    <button class="absolute right-4 top-1/2 -translate-y-1/2 w-10 h-10 grid place-items-center rounded-full bg-white/20 text-white hover:bg-white/30">›</button>
  </section>

  {{-- BEST SELLER --}}
  <section id="product" class="scroll-mt-20 py-12 md:py-16 bg-[#f6efe7]">
    <div class="max-w-7xl mx-auto px-4">
      <div class="text-center mb-8">
        <h2 class="font-['Great_Vibes'] text-3xl md:text-5xl">Best Seller Product This Week!</h2>
        <p class="text-stone-600 max-w-2xl mx-auto mt-2">
         Kadang hidup cuma butuh satu hal sederhana: secangkir kopi dan waktu untuk menikmatinya. Kami percaya setiap tegukan bisa jadi awal dari ide baru, obrolan hangat, atau sekadar pelarian kecil dari hiruk-pikuk dunia. Karena di balik setiap kopi, selalu ada ketenangan yang siap menemanimu. 
        </p>
      </div>

      @php
  $products = [
  ['name' => 'Caffè Latte', 'image' => 'https://images.unsplash.com/photo-1541167760496-1628856ab772?auto=format&fit=crop&w=800&q=80', 'rating' => 4],
  ['name' => 'Cappuccino',  'image' => 'https://cdn.kerbel.in/assets/product/product_IDVGUOCHLR_1664033686_1.webp', 'rating' => 5],
  ['name' => 'Americano',   'image' => 'https://res.cloudinary.com/dk0z4ums3/image/upload/v1747970767/attached_image/5-manfaat-americano-untuk-diet-yang-sayang-untuk-dilewatkan-0-alodokter.jpg', 'rating' => 4],
  ['name' => 'Matcha Latte',     'image' => 'https://assets.bonappetit.com/photos/57b4df9f3e1d654349a2fefb/1:1/w_1920,c_limit/iced-matcha-latte.jpg', 'rating' => 5],
];


      @endphp

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach ($products as $p)
          <div class="bg-white rounded-lg shadow border overflow-hidden hover:shadow-md transition">
            <div class="aspect-square bg-stone-100">
              <img src="{{ $p['image'] }}" class="w-full h-full object-cover" alt="{{ $p['name'] }}">
            </div>
            <div class="p-4 space-y-2">
              <div class="flex items-center gap-1 text-amber-500">
                @for ($i=1; $i<=5; $i++)
                  @if ($i <= $p['rating'])
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

  {{-- SLIDESHOW SCRIPT --}}
  <script>
    (function () {
      const slides = [
        "{{ $hero }}",
        "{{ asset('welcome(1).jpg') }}",
        "{{ asset('welcome(2).jpg') }}",
        "{{ asset('welcome4.jpg') }}"
      ];

      const unique = [...new Set(slides.filter(Boolean))];

      // preload
      unique.forEach(src => { const i = new Image(); i.src = src; });

      const a = document.getElementById('heroA');
      const b = document.getElementById('heroB');

      let i = 0, useA = true;
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
wwa