{{-- resources/views/order.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Pembeli • SeduhRasa</title>
  
  {{-- Favicon --}}
  <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
  
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="bg-stone-50 text-stone-800 font-sans">

  <header class="bg-stone-900 text-white py-4 shadow-md">
    <div class="max-w-4xl mx-auto px-4 flex justify-between items-center">
      {{-- Logo --}}
      <a href="{{ route('home') }}" class="flex items-center gap-2 hover:opacity-90 transition">
        <img src="{{ asset('LOGO2.png') }}" class="h-10 w-auto" alt="SeduhRasa Coffee Logo">
      </a>
      
      <a href="{{ route('home') }}" class="text-amber-400 hover:text-amber-300 transition">
        ← Kembali ke Beranda
      </a>
    </div>
  </header>

  <main class="max-w-4xl mx-auto px-4 py-12">
    <section class="bg-gradient-to-br from-amber-50 to-stone-100 rounded-3xl shadow-inner p-10 border border-stone-200">
      <div class="text-center mb-10">
        <h2 class="text-3xl font-bold text-stone-800 mb-2">🧑‍♂️ Data Pembeli</h2>
        <p class="text-stone-500 max-w-lg mx-auto">
          Lengkapi informasi di bawah ini untuk melanjutkan ke halaman pilih menu.
        </p>
      </div>

      <div class="bg-white rounded-2xl shadow-md p-8 border border-stone-100">
        {{-- FORM --}}
        <form action="{{ route('order.storeInfo') }}" method="POST" class="space-y-8">
          @csrf

          <div class="grid md:grid-cols-3 gap-8">
            {{-- NAMA --}}
            <div class="space-y-2">
              <label class="block text-sm font-semibold text-stone-700" for="nama_pelanggan">
                Nama Lengkap
              </label>
              <input
                type="text"
                id="nama_pelanggan"
                name="name"
                value="{{ old('name', $customer['name'] ?? '') }}"
                placeholder="Masukkan nama lengkapmu"
                class="w-full bg-stone-50 border border-stone-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-amber-400 transition duration-200"
                required>
              @error('name')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
              @else
                <small class="text-xs text-stone-400">Sesuai dengan identitas atau nama akunmu</small>
              @enderror
            </div>

            {{-- EMAIL --}}
            <div class="space-y-2">
              <label class="block text-sm font-semibold text-stone-700" for="email">
                Email
              </label>
              <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email', $customer['email'] ?? '') }}"
                placeholder="nama@email.com"
                class="w-full bg-stone-50 border border-stone-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-amber-400 transition duration-200">
              @error('email')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
              @else
                <small class="text-xs text-stone-400">Digunakan untuk konfirmasi pesanan (opsional)</small>
              @enderror
            </div>

            {{-- TELEPON --}}
            <div class="space-y-2">
              <label class="block text-sm font-semibold text-stone-700" for="telepon">
                No. Telepon
              </label>
              <input
                type="tel"
                id="telepon"
                name="phone"
                value="{{ old('phone', $customer['phone'] ?? '') }}"
                placeholder="08xxxxxxxxxx"
                class="w-full bg-stone-50 border border-stone-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-amber-400 transition duration-200"
                required>
              @error('phone')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
              @else
                <small class="text-xs text-stone-400">Pastikan nomor aktif untuk kontak pengiriman</small>
              @enderror
            </div>
          </div>

          <div class="text-center">
            <button
              type="submit"
              class="bg-amber-500 hover:bg-amber-600 text-stone-900 font-semibold px-8 py-3 rounded-xl shadow transition">
              Lanjut ke Pilih Menu
            </button>
          </div>
        </form>
      </div>
    </section>
  </main>

  {{-- FOOTER --}}
  <footer class="w-full bg-[#ff8c00] text-white text-center py-4 text-sm">
    © {{ date('Y') }} SeduhRasa Coffee. All rights reserved.
  </footer>

</body>
</html>