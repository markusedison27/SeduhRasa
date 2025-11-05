{{-- resources/views/order.blade.php --}}
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
  <header class="bg-stone-900 text-white py-4 shadow">
    <div class="max-w-7xl mx-auto px-4 flex justify-between items-center">
      <h1 class="text-lg font-bold">Seduh<span class="text-amber-500">Rasa</span></h1>
      <a href="{{ route('home') }}" class="text-amber-400 hover:text-amber-300">← Back to Home</a>
    </div>
  </header>

  <main class="max-w-7xl mx-auto px-4 py-10 space-y-16">

    {{-- ✨ FORM PEMBELI --}}
    <section class="bg-white p-6 rounded-2xl shadow">
      <h2 class="text-2xl font-semibold mb-4 text-center">🧍‍♂️ Data Pembeli</h2>
      <form class="grid md:grid-cols-3 gap-6">
        <div>
          <label class="block text-sm font-medium text-stone-600 mb-1">Nama Lengkap</label>
          <input type="text" placeholder="Nama kamu" class="w-full border rounded px-3 py-2">
        </div>
        <div>
          <label class="block text-sm font-medium text-stone-600 mb-1">Email</label>
          <input type="email" placeholder="nama@email.com" class="w-full border rounded px-3 py-2">
        </div>
        <div>
          <label class="block text-sm font-medium text-stone-600 mb-1">No. Telepon</label>
          <input type="tel" placeholder="08xxxxxxxxxx" class="w-full border rounded px-3 py-2">
        </div>
      </form>
    </section>

    {{-- ☕ MENU SECTION --}}
    <section>
      <div class="text-center mb-10">
        <h2 class="font-['Great_Vibes'] text-4xl md:text-6xl mb-3">Order Menu</h2>
        <p class="text-stone-600 max-w-2xl mx-auto">
          Pilih menu favoritmu — klik tombol “Add to Cart” untuk menambah ke keranjang.
        </p>
      </div>

      @php
        $menus = [
          [
            'category' => 'Coffee',
            'items' => [
              ['name'=>'Espresso', 'price'=>18, 'image'=>'https://images.unsplash.com/photo-1510626176961-4b37d6af3c4a?q=80&w=800&auto=format&fit=crop'],
              ['name'=>'Cappuccino', 'price'=>23, 'image'=>'https://images.unsplash.com/photo-1509042239860-f550ce710b93?q=80&w=800&auto=format&fit=crop'],
              ['name'=>'Latte', 'price'=>24, 'image'=>'https://images.unsplash.com/photo-1509042239860-f550ce710b93?q=80&w=800&auto=format&fit=crop'],
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

      {{-- LOOP MENU --}}
      @foreach ($menus as $menu)
        <div class="mb-12">
          <h3 class="text-2xl font-semibold mb-6 border-l-4 border-amber-500 pl-3">{{ $menu['category'] }}</h3>
          <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($menu['items'] as $item)
              <div class="bg-white rounded-xl shadow hover:shadow-lg transition overflow-hidden border">
                <div class="aspect-square relative">
                  <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover">
                  <div class="absolute inset-0 bg-gradient-to-t from-stone-900/60 to-transparent"></div>
                  <p class="absolute bottom-2 left-2 text-white text-sm font-semibold bg-amber-500/80 px-2 py-1 rounded">
                    Rp {{ number_format($item['price'] * 1000, 0, ',', '.') }}
                  </p>
                </div>
                <div class="p-4 text-center">
                  <h4 class="font-semibold text-lg mb-2">{{ $item['name'] }}</h4>
                  <button class="w-full bg-amber-500 hover:bg-amber-600 text-stone-900 font-semibold py-2 rounded transition">
                    Add to Cart
                  </button>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      @endforeach
    </section>

    {{-- 🛒 CART SECTION --}}
    <section class="bg-white p-6 rounded-2xl shadow">
      <h2 class="text-2xl font-semibold mb-4 text-center">🛒 Keranjang Pesanan</h2>
      <table class="w-full text-sm border-collapse">
        <thead class="bg-stone-100">
          <tr>
            <th class="p-2 text-left">Nama Item</th>
            <th class="p-2">Jumlah</th>
            <th class="p-2">Harga</th>
            <th class="p-2">Total</th>
          </tr>
        </thead>
        <tbody>
          <tr class="border-t">
            <td class="p-2">Cappuccino</td>
            <td class="p-2 text-center">2</td>
            <td class="p-2 text-center">Rp 23.000</td>
            <td class="p-2 text-center">Rp 46.000</td>
          </tr>
          <tr class="border-t">
            <td class="p-2">Croissant</td>
            <td class="p-2 text-center">1</td>
            <td class="p-2 text-center">Rp 15.000</td>
            <td class="p-2 text-center">Rp 15.000</td>
          </tr>
        </tbody>
        <tfoot class="bg-stone-100">
          <tr>
            <td colspan="3" class="p-2 font-semibold text-right">Total Bayar:</td>
            <td class="p-2 font-bold text-center text-amber-600">Rp 61.000</td>
          </tr>
        </tfoot>
      </table>

      <div class="mt-6 text-center">
        <button class="bg-amber-500 hover:bg-amber-600 text-stone-900 font-semibold px-6 py-2 rounded-lg shadow transition">
          Pesan Sekarang
        </button>
      </div>
    </section>

  </main>

  {{-- FOOTER --}}
  <footer class="py-8 text-center text-sm text-stone-500">
    © {{ date('Y') }} SeduhRasa Coffee. All rights reserved.
  </footer>

</body>
</html>
