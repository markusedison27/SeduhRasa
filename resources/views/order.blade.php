<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Order - SeduhRasa Coffee</title>
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
        <a href="{{ route('home') }}" class="hover:text-amber-400">Home</a>
        <a href="{{ route('about') }}" class="hover:text-amber-400">About Us</a>
        <a href="{{ route('services') }}" class="hover:text-amber-400">Services</a>
        <a href="{{ route('order') }}" class="text-amber-400 font-semibold">Order</a>
      </nav>
    </div>
  </header>

  {{-- MAIN CONTENT --}}
  <main class="max-w-4xl mx-auto py-16 px-6 text-center">
    <h1 class="text-4xl font-bold mb-8 text-gray-800">Pesan Kopi Favoritmu Sekarang!</h1>
    <p class="text-gray-600 max-w-2xl mx-auto mb-12">
      Isi formulir di bawah untuk melakukan pemesanan kopi. Tim kami akan segera menyiapkan pesananmu dengan sepenuh hati ☕
    </p>

    <form class="bg-white shadow rounded-xl p-8 space-y-6 text-left">
      <div>
        <label class="block mb-1 font-semibold">Nama Lengkap</label>
        <input type="text" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-amber-400 outline-none" placeholder="Masukkan nama kamu">
      </div>

      <div>
        <label class="block mb-1 font-semibold">Jenis Kopi</label>
        <select class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-amber-400 outline-none">
          <option value="">Pilih kopi...</option>
          <option value="latte">Caffè Latte</option>
          <option value="cappuccino">Cappuccino</option>
          <option value="americano">Americano</option>
          <option value="espresso">Espresso</option>
        </select>
      </div>

      <div>
        <label class="block mb-1 font-semibold">Jumlah (Cup)</label>
        <input type="number" min="1" value="1" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-amber-400 outline-none">
      </div>

      <div>
        <label class="block mb-1 font-semibold">Catatan Tambahan</label>
        <textarea class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-amber-400 outline-none" rows="3" placeholder="Contoh: tanpa gula, extra milk..."></textarea>
      </div>

      <button type="submit" class="w-full bg-amber-500 hover:bg-amber-600 text-stone-900 font-semibold rounded-lg px-5 py-3 transition">
        Kirim Pesanan
      </button>
    </form>
  </main>

  {{-- FOOTER --}}
  <footer class="py-8 text-center text-sm text-stone-500">
    © {{ date('Y') }} SeduhRasa Coffee. All rights reserved.
  </footer>

</body>
</html>
