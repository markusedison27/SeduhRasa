{{-- resources/views/contact.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact - SeduhRasa Coffee</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-stone-50 text-stone-900">
  <header class="bg-stone-900 text-white py-4">
    <div class="max-w-7xl mx-auto px-4 flex justify-between items-center">
      <h1 class="text-lg font-bold">Seduh<span class="text-amber-500">Rasa</span></h1>
      <a href="{{ route('home') }}" class="text-amber-400 hover:text-amber-300">← Back to Home</a>
    </div>
  </header>

  <section class="max-w-3xl mx-auto px-4 py-12">
    <h2 class="text-3xl font-bold mb-6 text-center">Hubungi Kami</h2>
    <p class="text-center text-stone-600 mb-10">
      Kami senang mendengar dari Anda! Silakan isi formulir di bawah ini atau hubungi langsung melalui kontak yang tersedia.
    </p>

    <form action="#" method="POST" class="space-y-4 bg-white p-6 rounded-lg shadow">
      @csrf
      <div>
        <label for="name" class="block text-sm font-medium text-stone-700">Nama Lengkap</label>
        <input id="name" type="text" name="name" required class="mt-1 w-full border rounded px-3 py-2">
      </div>

      <div>
        <label for="email" class="block text-sm font-medium text-stone-700">Email</label>
        <input id="email" type="email" name="email" required class="mt-1 w-full border rounded px-3 py-2">
      </div>

      <div>
        <label for="message" class="block text-sm font-medium text-stone-700">Pesan</label>
        <textarea id="message" name="message" rows="5" required class="mt-1 w-full border rounded px-3 py-2"></textarea>
      </div>

      <button type="submit" class="w-full bg-amber-500 hover:bg-amber-600 text-stone-900 font-semibold py-2 rounded">
        Kirim Pesan
      </button>
    </form>

    <div class="mt-10 text-center text-sm text-stone-500">
      <p>Alamat: Bengkalis</p>
      <p>Email: info@seduhrasa.com | Telp: (021) 1234-5678</p>
    </div>
  </section>

  <footer class="py-8 text-center text-sm text-stone-500">
    © {{ date('Y') }} SeduhRasa Coffee. All rights reserved.
  </footer>
</body>
</html>
