<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tentang Kami - SeduhRasa Coffee</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-stone-50 text-stone-900">

  <header class="bg-stone-900 text-white py-4">
    <div class="max-w-6xl mx-auto px-4 flex justify-between items-center">
      <a href="{{ url('/') }}" class="font-bold text-lg">
        Seduh<span class="text-amber-400">Rasa</span>
      </a>
      <nav class="flex gap-4 text-sm">
        <a href="{{ url('/') }}" class="hover:text-amber-400">Home</a>
        <a href="{{ route('about') }}" class="text-amber-400 font-semibold">About Us</a>
      </nav>
    </div>
  </header>

  <main class="max-w-4xl mx-auto py-16 px-6 text-center">
    <h1 class="text-4xl font-bold mb-6 text-gray-800">Tentang Kami</h1>
    <p class="text-lg text-gray-600 mb-4">
      <strong>SeduhRasa Coffee</strong> Sistem informasi coffee shop berbasis website ini dibuat untuk membantu pemilik usaha dalam mengelola menu, promosi, pesanan, dan informasi operasional secara modern.
    </p>
    <p class="text-lg text-gray-600">
      Kami percaya setiap cangkir kopi punya cerita — dari petani hingga pelanggan.
      Nikmati pengalaman ngopi terbaik bersama kami ☕
    </p>
  </main>

  <footer class="py-8 text-center text-sm text-stone-500">
    © {{ date('Y') }} SeduhRasa Coffee. All rights reserved.
  </footer>

</body>
</html>
