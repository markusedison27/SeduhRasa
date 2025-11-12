{{-- resources/views/contact.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact - SeduhRasa Coffee</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-stone-50 text-stone-900 antialiased">

  {{-- HEADER --}}
  <header class="bg-stone-900 text-white py-4 shadow">
    <div class="max-w-7xl mx-auto px-4 flex justify-between items-center">
      <h1 class="text-xl font-bold tracking-wide">
        Seduh<span class="text-amber-500">Rasa</span>
      </h1>
      <a href="{{ route('home') }}" class="text-amber-400 hover:text-amber-300 transition">← Kembali ke Beranda</a>
    </div>
  </header>

  {{-- MAIN SECTION --}}
  <main class="max-w-7xl mx-auto px-6 py-16">
    <div class="text-center mb-14">
      <h2 class="text-4xl font-bold text-stone-800 mb-3">Hubungi Kami</h2>
      <p class="text-stone-600 max-w-2xl mx-auto">
        Kami senang mendengar dari Anda. Silakan isi formulir di bawah ini atau hubungi kami melalui informasi kontak yang tersedia.
      </p>
    </div>

    {{-- GRID WRAPPER --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
      
      {{-- FORM KONTAK --}}
      <div class="bg-white rounded-2xl shadow-lg p-8 border border-stone-100">
        <h3 class="text-2xl font-semibold mb-6 text-amber-700">Kirim Pesan</h3>
        <form action="#" method="POST" class="space-y-5">
          @csrf
          <div>
            <label for="name" class="block text-sm font-medium text-stone-700 mb-1">Nama Lengkap</label>
            <input id="name" type="text" name="name" required 
              class="w-full border border-stone-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-amber-500 focus:outline-none">
          </div>

          <div>
            <label for="email" class="block text-sm font-medium text-stone-700 mb-1">Email</label>
            <input id="email" type="email" name="email" required 
              class="w-full border border-stone-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-amber-500 focus:outline-none">
          </div>

          <div>
            <label for="message" class="block text-sm font-medium text-stone-700 mb-1">Pesan</label>
            <textarea id="message" name="message" rows="5" required 
              class="w-full border border-stone-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-amber-500 focus:outline-none"></textarea>
          </div>

          <button type="submit" 
            class="w-full bg-amber-500 hover:bg-amber-600 text-stone-900 font-semibold py-2 rounded-lg transition shadow-sm hover:shadow-md">
            Kirim Pesan
          </button>
        </form>
      </div>

      {{-- INFO KONTAK --}}
      <div class="bg-white rounded-2xl shadow-lg p-8 border border-stone-100 flex flex-col justify-between">
        <div>
          <h3 class="text-2xl font-semibold mb-6 text-amber-700">Informasi Kontak</h3>
          <ul class="space-y-4 text-stone-700">
            <li>
              <span class="font-medium">📍 Alamat:</span><br>
              Jl. Mawar No. 15, Bengkalis
            </li>
            <li>
              <span class="font-medium">📧 Email:</span><br>
              info@seduhrasa.com
            </li>
            <li>
              <span class="font-medium">📞 Telepon:</span><br>
              (021) 1234-5678
            </li>
            <li>
              <span class="font-medium">🕒 Jam Operasional:</span><br>
              Setiap hari pukul 08.00 – 22.00 WIB
            </li>
          </ul>
        </div>

        {{-- GOOGLE MAPS --}}
        <div class="mt-8 rounded-xl overflow-hidden shadow-md">
          <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.285!2d102.103!3d1.482!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d0b8f36f3a2dfd%3A0xabc123!2sBengkalis!5e0!3m2!1sid!2sid!4v00000000000"
            width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy">
          </iframe>
        </div>
      </div>
    </div>
  </main>

  {{-- FOOTER --}}
 <footer class="py-8 text-center text-sm bg-amber-500 text-stone-900 font-medium">
  © {{ date('Y') }} SeduhRasa Coffee. All rights reserved.
</footer>

</body>
</html>  
