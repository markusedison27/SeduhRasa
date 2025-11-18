{{-- resources/views/order.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Pembeli • SeduhRasa</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="bg-stone-50 text-stone-800 font-sans">

  <header class="bg-stone-900 text-white py-4 shadow-md">
    <div class="max-w-4xl mx-auto px-4 flex justify-between items-center">
      <h1 class="text-xl font-bold tracking-wide">
        Seduh<span class="text-amber-500">Rasa</span>
      </h1>
      <a href="{{ route('home') }}" class="text-amber-400 hover:text-amber-300 transition">
        ← Kembali ke Beranda
      </a>
    </div>
  </header>

  <main class="max-w-4xl mx-auto px-4 py-12">
    <section class="bg-gradient-to-br from-amber-50 to-stone-100 rounded-3xl shadow-inner p-10 border border-stone-200">
      <div class="text-center mb-10">
        <h2 class="text-3xl font-bold text-stone-800 mb-2">🧍‍♂️ Data Pembeli</h2>
        <p class="text-stone-500 max-w-lg mx-auto">
          Lengkapi informasi di bawah ini untuk melanjutkan ke halaman pilih menu.
        </p>
      </div>

      <div class="bg-white rounded-2xl shadow-md p-8 border border-stone-100">
        <div class="grid md:grid-cols-3 gap-8">
          <div class="space-y-2">
            <label class="block text-sm font-semibold text-stone-700">Nama Lengkap</label>
            <input
              type="text"
              id="nama_pelanggan"
              placeholder="Masukkan nama lengkapmu"
              class="w-full bg-stone-50 border border-stone-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-amber-400 transition duration-200">
            <small class="text-xs text-stone-400">Sesuai dengan identitas atau nama akunmu</small>
          </div>

          <div class="space-y-2">
            <label class="block text-sm font-semibold text-stone-700">Email</label>
            <input
              type="email"
              id="email"
              placeholder="nama@email.com"
              class="w-full bg-stone-50 border border-stone-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-amber-400 transition duration-200">
            <small class="text-xs text-stone-400">Digunakan untuk konfirmasi pesanan</small>
          </div>

          <div class="space-y-2">
            <label class="block text-sm font-semibold text-stone-700">No. Telepon</label>
            <input
              type="tel"
              id="telepon"
              placeholder="08xxxxxxxxxx"
              class="w-full bg-stone-50 border border-stone-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-amber-400 transition duration-200">
            <small class="text-xs text-stone-400">Pastikan nomor aktif untuk kontak pengiriman</small>
          </div>
        </div>

        <div class="text-center mt-10">
          <button
            id="btn-lanjut-menu"
            class="bg-amber-500 hover:bg-amber-600 text-stone-900 font-semibold px-8 py-3 rounded-xl shadow transition">
            Lanjut ke Pilih Menu
          </button>
        </div>
      </div>
    </section>
  </main>

   {{-- FOOTER --}}
  <footer class="w-full bg-[#ff8c00] text-white text-center py-4 text-sm">
    © {{ date('Y') }} SeduhRasa Coffee. All rights reserved.
</footer>

  <script>
    // saat tombol diklik, simpan data pembeli di localStorage lalu pindah ke /menu
    document.getElementById('btn-lanjut-menu').addEventListener('click', function () {
      const nama    = document.getElementById('nama_pelanggan').value.trim();
      const email   = document.getElementById('email').value.trim();
      const telepon = document.getElementById('telepon').value.trim();

      if (!nama || !email || !telepon) {
        alert('Nama, email, dan no. telepon wajib diisi dulu ya 😊');
        return;
      }

      const buyer = { nama_pelanggan: nama, email: email, telepon: telepon };
      localStorage.setItem('sr_buyer', JSON.stringify(buyer));

      // pindah ke halaman pilih menu
      window.location.href = "{{ route('menu') }}";
    });
  </script>

</body>
</html>
