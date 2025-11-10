{{-- resources/views/about.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tentang Kami | SeduhRasa Coffee</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
  <link href="https://fonts.bunny.net/css?family=great-vibes:400|poppins:400,600" rel="stylesheet">
</head>
<body class="bg-[#f6efe7] text-stone-800">

  {{-- NAVBAR --}}
  <header class="bg-stone-900 text-white shadow">
    <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
      <a href="{{ url('/') }}" class="font-bold text-lg">☕ Seduh<span class="text-amber-500">Rasa</span></a>
      <nav class="flex gap-6 text-sm">
        <a href="{{ url('/') }}" class="hover:text-amber-400">Home</a>
        <a href="{{ url('/product') }}" class="hover:text-amber-400">Product</a>
        <a href="{{ url('/about') }}" class="text-amber-400 font-semibold">Tentang Kami</a>
        <a href="{{ url('/contact') }}" class="hover:text-amber-400">Contact</a>
      </nav>
    </div>
  </header>

  {{-- HERO --}}
  <section class="relative h-[50vh] md:h-[60vh] overflow-hidden">
    <img src="https://images.unsplash.com/photo-1511920170033-f8396924c348?q=80&w=1600&auto=format&fit=crop"
         class="absolute inset-0 w-full h-full object-cover" alt="Background Coffee">
    <div class="absolute inset-0 bg-stone-900/70"></div>
    <div class="relative z-10 flex flex-col items-center justify-center h-full text-center text-white">
      <h1 class="font-['Great_Vibes'] text-5xl md:text-6xl mb-2 text-amber-400">Tentang Kami</h1>
      <p class="max-w-xl text-sm md:text-base text-stone-200">
        Empat sahabat yang percaya bahwa kopi bukan sekadar minuman, melainkan seni yang menyatukan rasa dan cerita.
      </p>
    </div>
  </section>

  {{-- TEAM SECTION --}}
  <section class="max-w-7xl mx-auto px-6 py-16">
    <div class="text-center mb-12">
      <h2 class="font-['Great_Vibes'] text-4xl md:text-5xl text-amber-700">Tim Kami</h2>
      <p class="text-stone-600 mt-3">Berkenalan dengan kami, para pencinta kopi di balik SeduhRasa ☕</p>
    </div>

    @php
      $team = [
        ['name'=>'M. Arifin Ilham', 'img'=>'https://cdn-icons-png.flaticon.com/512/4140/4140048.png', 'ig'=>'https://instagram.com/'],
        ['name'=>'Markus Edison Silalahi', 'img'=>'https://cdn-icons-png.flaticon.com/512/4140/4140037.png', 'ig'=>'https://instagram.com/'],
        ['name'=>'Mazira', 'img'=>'https://cdn-icons-png.flaticon.com/512/4140/4140061.png', 'ig'=>'https://instagram.com/'],
        ['name'=>'Elsa Syafitriani', 'img'=>'https://cdn-icons-png.flaticon.com/512/4140/4140087.png', 'ig'=>'https://instagram.com/'],
      ];
    @endphp

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
      @foreach ($team as $person)
        <div class="group bg-white rounded-2xl shadow-lg overflow-hidden hover:-translate-y-2 transition-all duration-300">
          <div class="bg-gradient-to-b from-stone-100 to-amber-50 p-6 flex flex-col items-center">
            <img src="{{ $person['img'] }}" alt="{{ $person['name'] }}" class="w-28 h-28 rounded-full shadow mb-4 border-4 border-amber-200 group-hover:border-amber-500 transition">
            <h3 class="font-semibold text-lg text-stone-800">{{ $person['name'] }}</h3>
            <a href="{{ $person['ig'] }}" target="_blank"
               class="mt-3 inline-block text-sm text-amber-600 font-medium hover:underline hover:text-amber-700">
              📸 Instagram
            </a>
          </div>
        </div>
      @endforeach
    </div>
  </section>

  {{-- QUOTE SECTION --}}
  <section class="bg-amber-100 py-12 text-center">
    <p class="font-['Great_Vibes'] text-3xl md:text-4xl text-amber-700 mb-2">"Kopi adalah kisah yang diseduh dengan cinta."</p>
    <p class="text-stone-600">— Tim SeduhRasa Coffee</p>
  </section>

  {{-- FOOTER --}}
  <footer class="bg-orange-500 text-stone-900 text-center py-4 font-medium">
    © 2025 SeduhRasa Coffee. All rights reserved.
  </footer>

</body>
</html>
