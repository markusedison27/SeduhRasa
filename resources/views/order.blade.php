{{-- resources/views/order.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Order - SeduhRasa Coffee</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="bg-stone-50 text-stone-800 font-sans">

  {{-- HEADER --}}
  <header class="bg-stone-900 text-white py-4 shadow-md">
    <div class="max-w-6xl mx-auto px-4 flex justify-between items-center">
      <h1 class="text-xl font-bold tracking-wide">
        Seduh<span class="text-amber-500">Rasa</span>
      </h1>
      <a href="{{ route('home') }}" class="text-amber-400 hover:text-amber-300 transition">
        ← Kembali ke Beranda
      </a>
    </div>
  </header>

  {{-- MAIN CONTENT --}}
  <main class="max-w-6xl mx-auto px-4 py-12 space-y-20">

    {{-- 1️⃣ DATA PEMBELI --}}
    <section id="pembeli" class="bg-gradient-to-br from-amber-50 to-stone-100 rounded-3xl shadow-inner p-10 border border-stone-200">
      <div class="text-center mb-10">
        <h2 class="text-3xl font-bold text-stone-800 mb-2">🧍‍♂️ Data Pembeli</h2>
        <p class="text-stone-500 max-w-lg mx-auto">
          Lengkapi informasi di bawah ini untuk melanjutkan pesananmu.
        </p>
      </div>

      <div class="bg-white rounded-2xl shadow-md p-8 border border-stone-100">
        <form class="grid md:grid-cols-3 gap-8">
          <div class="space-y-2">
            <label class="block text-sm font-semibold text-stone-700">Nama Lengkap</label>
            <input type="text" placeholder="Masukkan nama lengkapmu"
              class="w-full bg-stone-50 border border-stone-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-amber-400 transition duration-200">
            <small class="text-xs text-stone-400">Sesuai dengan identitas atau nama akunmu</small>
          </div>

          <div class="space-y-2">
            <label class="block text-sm font-semibold text-stone-700">Email</label>
            <input type="email" placeholder="nama@email.com"
              class="w-full bg-stone-50 border border-stone-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-amber-400 transition duration-200">
            <small class="text-xs text-stone-400">Digunakan untuk konfirmasi pesanan</small>
          </div>

          <div class="space-y-2">
            <label class="block text-sm font-semibold text-stone-700">No. Telepon</label>
            <input type="tel" placeholder="08xxxxxxxxxx"
              class="w-full bg-stone-50 border border-stone-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-amber-400 transition duration-200">
            <small class="text-xs text-stone-400">Pastikan nomor aktif untuk kontak pengiriman</small>
          </div>
        </form>

        <div class="text-center mt-10">
          <button class="bg-amber-500 hover:bg-amber-600 text-stone-900 font-semibold px-8 py-3 rounded-xl shadow transition">
            Simpan Data Pembeli
          </button>
        </div>
      </div>
    </section>

    {{-- 2️⃣ MENU ORDER --}}
    <section id="menu">
      <header class="text-center mb-12">
        <h2 class="font-['Great_Vibes'] text-5xl text-amber-700 mb-3">Order Menu</h2>
        <p class="text-stone-600 max-w-2xl mx-auto leading-relaxed">
          Pilih menu favoritmu — klik tombol <strong>“Add to Cart”</strong> untuk menambah ke keranjang.
        </p>
      </header>

      @php
        $menus = [
          [
            'category' => 'Coffee',
            'items' => [
              ['name'=>'Espresso', 'price'=>18, 'image'=>'https://images.unsplash.com/photo-1510626176961-4b37d6af3c4a?q=80&w=800&auto=format&fit=crop'],
              ['name'=>'Cappuccino', 'price'=>23, 'image'=>'https://images.unsplash.com/photo-1509042239860-f550ce710b93?q=80&w=800&auto=format&fit=crop'],
              ['name'=>'Latte', 'price'=>24, 'image'=>'https://images.unsplash.com/photo-1521302080371-6c5f60b67f36?q=80&w=800&auto=format&fit=crop'],
              ['name'=>'Americano', 'price'=>20, 'image'=>'https://images.unsplash.com/photo-1521302080371-6c5f60b67f36?q=80&w=800&auto=format&fit=crop'],
            ]
          ],
          [
            'category' => 'Snack',
            'items' => [
              ['name'=>'Croissant', 'price'=>15, 'image'=>'https://images.unsplash.com/photo-1606755962773-d324e0a13058?q=80&w=800&auto=format&fit=crop'],
              ['name'=>'Muffin', 'price'=>14, 'image'=>'https://images.unsplash.com/photo-1605478371319-4c5d9a5e9a1b?q=80&w=800&auto=format&fit=crop'],
              ['name'=>'Donut', 'price'=>13, 'image'=>'https://images.unsplash.com/photo-1606312619070-2049f3a6f3ee?q=80&w=800&auto=format&fit=crop'],
              ['name'=>'Cheese Cake', 'price'=>18, 'image'=>'https://images.unsplash.com/photo-1605478371319-4c5d9a5e9a1b?q=80&w=800&auto=format&fit=crop'],
            ]
          ]
        ];
      @endphp

      <div class="space-y-16">
        @foreach ($menus as $menu)
          <div>
            <h3 class="text-2xl font-bold mb-6 border-l-4 border-amber-500 pl-3 text-stone-700">
              {{ $menu['category'] }}
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
              @foreach ($menu['items'] as $item)
                <article class="bg-white rounded-xl border border-stone-100 shadow-sm hover:shadow-lg transition hover:-translate-y-1 overflow-hidden">
                  <div class="aspect-square relative">
                    <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-stone-900/70 to-transparent"></div>
                    <p class="absolute bottom-2 left-2 text-white text-xs font-semibold bg-amber-600/90 px-2 py-1 rounded">
                      Rp {{ number_format($item['price'] * 1000, 0, ',', '.') }}
                    </p>
                  </div>
                  <div class="p-4 text-center space-y-2">
                    <h4 class="font-semibold text-lg text-stone-700">{{ $item['name'] }}</h4>
                    <button class="w-full bg-amber-500 hover:bg-amber-600 text-stone-900 font-semibold py-2 rounded-lg transition">
                      Add to Cart
                    </button>
                  </div>
                </article>
              @endforeach
            </div>
          </div>
        @endforeach
      </div>
    </section>

    {{-- 3️⃣ KERANJANG PESANAN --}}
    <section id="cart" class="bg-white p-8 rounded-2xl shadow border border-stone-100">
      <header class="text-center mb-8">
        <h2 class="text-3xl font-semibold text-stone-800">🛒 Keranjang Pesanan</h2>
        <p class="text-stone-500 text-sm mt-2">Periksa kembali pesananmu sebelum checkout.</p>
      </header>

      <div class="overflow-x-auto">
        <table class="w-full text-sm border-collapse">
          <thead class="bg-stone-100 text-stone-700">
            <tr>
              <th class="p-3 text-left">Nama Item</th>
              <th class="p-3 text-center">Jumlah</th>
              <th class="p-3 text-center">Harga</th>
              <th class="p-3 text-center">Total</th>
            </tr>
          </thead>
          <tbody>
            <tr class="border-t hover:bg-stone-50">
              <td class="p-3">Cappuccino</td>
              <td class="p-3 text-center">2</td>
              <td class="p-3 text-center">Rp 23.000</td>
              <td class="p-3 text-center">Rp 46.000</td>
            </tr>
            <tr class="border-t hover:bg-stone-50">
              <td class="p-3">Croissant</td>
              <td class="p-3 text-center">1</td>
              <td class="p-3 text-center">Rp 15.000</td>
              <td class="p-3 text-center">Rp 15.000</td>
            </tr>
          </tbody>
          <tfoot class="bg-stone-100 font-medium">
            <tr>
              <td colspan="3" class="p-3 text-right">Total Bayar:</td>
              <td class="p-3 text-center text-amber-600 font-bold">Rp 61.000</td>
            </tr>
          </tfoot>
        </table>
      </div>

      <div class="mt-8 text-center">
        <button class="bg-amber-500 hover:bg-amber-600 text-stone-900 font-semibold px-8 py-3 rounded-xl shadow-md transition">
          Pesan Sekarang
        </button>
      </div>
    </section>
  </main>

  {{-- FOOTER --}}
  <footer class="py-10 text-center text-sm text-stone-500 border-t">
    © {{ date('Y') }} <span class="font-semibold text-stone-700">SeduhRasa Coffee</span>. All rights reserved.
  </footer>

</body>
</html>
