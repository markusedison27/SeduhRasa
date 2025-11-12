<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Layanan Kami - SeduhRasa Coffee</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-stone-50 text-stone-900">

  {{-- HEADER --}}
  <header class="bg-stone-900 text-white py-4">
    <div class="max-w-6xl mx-auto px-4 flex justify-between items-center">
      <a href="{{ url('/') }}" class="font-bold text-lg">
        Seduh<span class="text-amber-400">Rasa</span>
      </a>
      <nav class="flex gap-4 text-sm">
        <a href="{{ url('/') }}" class="hover:text-amber-400">Home</a>
        <a href="{{ route('about') }}" class="hover:text-amber-400">About Us</a>
        <a href="{{ route('services') }}" class="text-amber-400 font-semibold">Services</a>
      </nav>
    </div>
  </header>

  {{-- MAIN CONTENT --}}
  <main class="max-w-6xl mx-auto py-16 px-6 text-center">
    <h1 class="text-4xl font-bold mb-8 text-gray-800">Layanan Kami</h1>
    <p class="text-lg text-gray-600 mb-12">
      Kami menyediakan berbagai layanan untuk memberikan pengalaman kopi terbaik bagi pelanggan kami.
    </p>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
      {{-- Service 1 --}}
      <div class="bg-white shadow rounded-xl p-6">
        <img src="https://images.unsplash.com/photo-1510626176961-4b37d6afc6f4?q=80&w=800" 
             alt="Coffee Brewing" class="rounded-lg mb-4 w-full h-48 object-cover">
        <h3 class="text-xl font-semibold mb-2">Coffee Brewing Class</h3>
        <p class="text-gray-600 text-sm">
          Belajar menyeduh kopi dari barista profesional kami dengan berbagai metode manual brew.
        </p>
      </div>

      {{-- Service 2 --}}
      <div class="bg-white shadow rounded-xl p-6">
        <img src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?q=80&w=800"
             alt="Coffee Beans" class="rounded-lg mb-4 w-full h-48 object-cover">
        <h3 class="text-xl font-semibold mb-2">Coffee Bean Supply</h3>
        <p class="text-gray-600 text-sm">
          Menyediakan biji kopi premium untuk kafe, restoran, dan individu pecinta kopi.
        </p>
      </div>

      {{-- Service 3 --}}
      <div class="bg-white shadow rounded-xl p-6">
        <img src="https://images.unsplash.com/photo-1509042239860-f550ce710b93?q=80&w=800"
             alt="Coffee Catering" class="rounded-lg mb-4 w-full h-48 object-cover">
        <h3 class="text-xl font-semibold mb-2">Coffee Catering</h3>
        <p class="text-gray-600 text-sm">
          Layanan coffee bar untuk acara kantor, seminar, dan pesta spesial Anda.
        </p>
      </div>
    </div>
  </main>

  {{-- FOOTER --}}
   <footer class="py-8 text-center text-sm text-stone-500">
  © {{ date('Y') }} SeduhRasa Coffee. All rights reserved.
</footer>

</body>
</html>
