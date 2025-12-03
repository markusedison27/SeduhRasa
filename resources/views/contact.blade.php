@extends('layouts.frontend')

@section('title', 'Hubungi Kami | SeduhRasa Coffee')

@section('content')
{{-- CONTACT HEADER --}}
<section class="py-24 bg-gradient-to-br from-[#f5e6d3] via-[#f9ead5] to-[#fef3e2]">
  <div class="max-w-7xl mx-auto px-6">
    <div class="text-center mb-16">
      <span class="text-[#8b6f47] font-semibold tracking-[0.3em] text-sm uppercase">Get In Touch</span>
      <h2 class="font-['Great_Vibes'] text-6xl md:text-8xl text-[#3d2817] mt-4 mb-6">Hubungi Kami</h2>
      <div class="w-24 h-1 bg-[#a67c52] mx-auto mb-8"></div>
      <p class="text-[#5c3d2e] text-lg max-w-2xl mx-auto">
        Kami senang mendengar dari Anda. Silakan isi formulir di bawah ini atau hubungi kami melalui informasi kontak
        yang tersedia.
      </p>
    </div>

    {{-- GRID WRAPPER --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">

      {{-- FORM KONTAK --}}
      <div class="bg-white rounded-2xl shadow-xl p-8 border-2 border-[#e8d4b8]">
        <h3 class="text-2xl font-bold mb-6 text-[#3d2817]">Kirim Pesan</h3>
        <form action="#" method="POST" class="space-y-5">
          @csrf
          <div>
            <label for="name" class="block text-sm font-semibold text-[#3d2817] mb-2">Nama Lengkap</label>
            <input id="name" type="text" name="name" required
              class="w-full border-2 border-[#e8d4b8] rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#a67c52] focus:border-[#a67c52] focus:outline-none transition-all duration-300">
          </div>

          <div>
            <label for="email" class="block text-sm font-semibold text-[#3d2817] mb-2">Email</label>
            <input id="email" type="email" name="email" required
              class="w-full border-2 border-[#e8d4b8] rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#a67c52] focus:border-[#a67c52] focus:outline-none transition-all duration-300">
          </div>

          <div>
            <label for="message" class="block text-sm font-semibold text-[#3d2817] mb-2">Pesan</label>
            <textarea id="message" name="message" rows="5" required
              class="w-full border-2 border-[#e8d4b8] rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#a67c52] focus:border-[#a67c52] focus:outline-none transition-all duration-300"></textarea>
          </div>

          <button type="submit"
            class="w-full bg-[#a67c52] hover:bg-[#8b6f47] text-white font-semibold py-3 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-105">
            Kirim Pesan
          </button>
        </form>
      </div>

      {{-- INFO KONTAK --}}
      <div class="bg-white rounded-2xl shadow-xl p-8 border-2 border-[#e8d4b8] flex flex-col justify-between">
        <div>
          <h3 class="text-2xl font-bold mb-6 text-[#3d2817]">Informasi Kontak</h3>
          <ul class="space-y-5 text-[#5c3d2e]">
            <li class="flex items-start gap-3">
              <div
                class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-[#8b6f47] to-[#c4905c] rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
              </div>
              <div>
                <span class="font-semibold text-[#3d2817] block mb-1">Alamat</span>
                Jalan antara, Bengkalis
              </div>
            </li>
            <li class="flex items-start gap-3">
              <div
                class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-[#8b6f47] to-[#c4905c] rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
              </div>
              <div>
                <span class="font-semibold text-[#3d2817] block mb-1">Email</span>
                seduhrasa1@gmail.com
              </div>
            </li>
            <li class="flex items-start gap-3">
              <div
                class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-[#8b6f47] to-[#c4905c] rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                </svg>
              </div>
              <div>
                <span class="font-semibold text-[#3d2817] block mb-1">Telepon</span>
                +62 812-6823-2687
              </div>
            </li>
            <li class="flex items-start gap-3">
              <div
                class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-[#8b6f47] to-[#c4905c] rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
              <div>
                <span class="font-semibold text-[#3d2817] block mb-1">Jam Operasional</span>
                Setiap hari pukul 15.00 – 23.00 WIB
              </div>
            </li>
            {{-- GOOGLE MAPS --}}
            <div class="mt-8 rounded-xl overflow-hidden shadow-lg border-2 border-[#e8d4b8]">
              <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.285!2d102.103!3d1.482!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d0b8f36f3a2dfd%3A0xabc123!2sBengkalis!5e0!3m2!1sid!2sid!4v00000000000"
                width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
              </iframe>
            </div>
        </div>
      </div>
    </div>
</section>
@endsection