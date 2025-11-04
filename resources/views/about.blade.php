{{-- resources/views/about.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Tentang Kami — SeduhRasa</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
  {{-- Palet: 
       Espresso  #3F2F28
       Mocha     #6B4E3D
       Caramel   #B07A5A
       Cream     #F7F1E8
       Foam      #EDE3D9
  --}}
</head>
<body class="bg-[#F7F1E8] text-[#3F2F28] antialiased">

  {{-- NAV (minimal, cream + outline mocha) --}}
  <header class="sticky top-0 z-10 border-b border-[#E6D9CC] bg-[#F7F1E8]/90 backdrop-blur">
    <div class="max-w-6xl mx-auto px-4 h-14 flex items-center justify-between">
      <a href="{{ route('home') }}" class="font-semibold tracking-tight">
        <span>Seduh</span><span class="text-[#B07A5A]">Rasa</span>
      </a>
      <nav class="flex items-center gap-5 text-sm">
        <a href="{{ route('home') }}" class="text-[#6B4E3D]/70 hover:text-[#6B4E3D] transition-colors">Home</a>
        <a href="{{ route('about') }}" class="text-[#3F2F28] font-medium">About Us</a>
      </nav>
    </div>
  </header>

  {{-- CONTENT --}}
  <main class="max-w-3xl mx-auto px-4 py-16">
    <div class="text-center">
      <h1 class="text-3xl md:text-4xl font-semibold tracking-tight">Tentang Kami</h1>
      <p class="mt-4 text-[#6B4E3D]/80">
        SeduhRasa adalah sistem informasi coffee shop yang ringan untuk mengelola menu, promosi, dan pesanan—
        dibuat agar operasional senyaman menyeruput kopi hangat.
      </p>
    </div>

    <div class="mt-10 grid gap-4 sm:grid-cols-3">
      <div class="rounded-lg border border-[#E6D9CC] bg-[#FFFFFF] p-4">
        <div class="text-[10px] uppercase tracking-wide text-[#B07A5A]">Misi</div>
        <p class="mt-2 text-sm text-[#3F2F28]/80">
          Menyatukan kualitas rasa dan kemudahan layanan—dari barista hingga pelanggan.
        </p>
      </div>
      <div class="rounded-lg border border-[#E6D9CC] bg-[#FFFFFF] p-4">
        <div class="text-[10px] uppercase tracking-wide text-[#B07A5A]">Nilai</div>
        <p class="mt-2 text-sm text-[#3F2F28]/80">
          Sederhana, cepat, ramah. Tanpa ribet, fokus pada pengalaman.
        </p>
      </div>
      <div class="rounded-lg border border-[#E6D9CC] bg-[#FFFFFF] p-4">
        <div class="text-[10px] uppercase tracking-wide text-[#B07A5A]">Kontak</div>
        <p class="mt-2 text-sm text-[#3F2F28]/80">
          Butuh bantuan? <a href="{{ url('/contact') }}" class="underline decoration-[#B07A5A]/50 underline-offset-4 hover:text-[#6B4E3D]">Hubungi kami</a>.
        </p>
      </div>
    </div>

    {{-- CTA opsional --}}
    <div class="mt-10 flex justify-center">
      <a
        href="{{ route('services') }}"
        class="inline-flex items-center gap-2 rounded-md bg-[#B07A5A] px-5 py-2 text-white hover:bg-[#9C6C50] active:bg-[#8B6048] transition-colors text-sm font-medium"
      >
        Lihat Layanan
      </a>
    </div>
  </main>

  {{-- FOOTER (foam) --}}
  <footer class="border-t border-[#E6D9CC] bg-[#EDE3D9]/60">
    <div class="max-w-6xl mx-auto px-4 py-6 text-xs text-[#6B4E3D]/80">
      © {{ date('Y') }} SeduhRasa. All rights reserved.
    </div>
  </footer>

</body>
</html>
