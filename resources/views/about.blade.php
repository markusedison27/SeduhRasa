@extends('layouts.frontend')

@section('title', 'Tentang Kami | SeduhRasa Coffee')

@section('content')
    {{-- ABOUT US SECTION --}}
    <section class="py-24 bg-gradient-to-br from-[#f5e6d3] via-[#f9ead5] to-[#fef3e2]">
        <div class="max-w-7xl mx-auto px-6 text-center">
            
            {{-- JUDUL DAN DESKRIPSI --}}
            <span class="text-[#8b6f47] font-semibold tracking-[0.3em] text-sm uppercase">Our Team</span>
            <h2 class="font-['Great_Vibes'] text-6xl md:text-8xl text-[#3d2817] mt-4 mb-6">About Us</h2>
            <div class="w-24 h-1 bg-[#a67c52] mx-auto mb-8"></div>
            <p class="max-w-2xl mx-auto text-[#5c3d2e] text-lg mb-16">
                Kami adalah kelompok pengembang SeduhRasa Coffee yang berfokus menciptakan website modern,
                responsif, dan nyaman digunakan. Berikut adalah anggota tim kami:
            </p>

            @php
                // Data tim pengembang
                $team = [
                    ['name' => 'M. Arifin Ilham', 'img' => 'https://cdn-icons-png.flaticon.com/512/4140/4140048.png', 'ig' => 'https://instagram.com/arifinilham'],
                    ['name' => 'Mazira', 'img' => 'https://cdn-icons-png.flaticon.com/512/4140/4140051.png', 'ig' => 'https://instagram.com/mazira'],
                    ['name' => 'Markus Edison', 'img' => 'https://cdn-icons-png.flaticon.com/512/4140/4140037.png', 'ig' => 'https://instagram.com/markusedison'],
                    ['name' => 'Elsa Syafitriani', 'img' => 'https://cdn-icons-png.flaticon.com/512/4140/4140051.png', 'ig' => 'https://instagram.com/elsasyafitriani'],
                ];
            @endphp

            {{-- KONTEN TIM --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach ($team as $t)
                    <a href="{{ $t['ig'] }}" target="_blank"
                        class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 p-8 flex flex-col items-center border border-[#e8d4b8] hover:scale-105">
                        <img src="{{ $t['img'] }}" class="w-24 h-24 mb-4" alt="{{ $t['name'] }} Avatar">
                        <div class="font-semibold text-[#3d2817] text-lg">{{ $t['name'] }}</div>
                        <div class="text-[#a67c52] text-sm mt-2">@ Instagram</div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- FILOSOFI KAMI --}}
    <section class="py-24 bg-[#3d2817]">
        <div class="max-w-4xl mx-auto px-6">
            <div class="text-center mb-16">
                <span class="text-amber-300 font-semibold tracking-[0.3em] text-sm uppercase">Our Values</span>
                <h2 class="font-['Great_Vibes'] text-6xl md:text-7xl text-[#f5e6d3] mt-4">Filosofi Kami</h2>
                <div class="w-24 h-1 bg-[#c4905c] mx-auto mt-6"></div>
            </div>

            <div class="grid gap-6 sm:grid-cols-3">
                {{-- Misi --}}
                <div class="rounded-2xl border-2 border-[#c4905c]/30 bg-gradient-to-br from-[#f5e6d3]/10 to-[#e8d4b8]/10 backdrop-blur-sm p-6 shadow-xl hover:shadow-2xl transition-all duration-300">
                    <div class="text-xs uppercase tracking-wide text-[#c4905c] font-bold mb-3">Misi</div>
                    <p class="text-[#f5e6d3] text-sm leading-relaxed">
                        Menyatukan kualitas rasa dan kemudahan layanan—dari barista hingga pelanggan.
                    </p>
                </div>
                {{-- Nilai --}}
                <div class="rounded-2xl border-2 border-[#c4905c]/30 bg-gradient-to-br from-[#f5e6d3]/10 to-[#e8d4b8]/10 backdrop-blur-sm p-6 shadow-xl hover:shadow-2xl transition-all duration-300">
                    <div class="text-xs uppercase tracking-wide text-[#c4905c] font-bold mb-3">Nilai</div>
                    <p class="text-[#f5e6d3] text-sm leading-relaxed">
                        Sederhana, cepat, ramah. Tanpa ribet, fokus pada pengalaman.
                    </p>
                </div>
                {{-- Kontak --}}
                <div class="rounded-2xl border-2 border-[#c4905c]/30 bg-gradient-to-br from-[#f5e6d3]/10 to-[#e8d4b8]/10 backdrop-blur-sm p-6 shadow-xl hover:shadow-2xl transition-all duration-300">
                    <div class="text-xs uppercase tracking-wide text-[#c4905c] font-bold mb-3">Kontak</div>
                    <p class="text-[#f5e6d3] text-sm leading-relaxed">
                        Butuh bantuan? <a href="{{ route('contact') }}" class="underline text-[#c4905c] hover:text-[#d4a373]">Hubungi kami</a>.
                    </p>
                </div>
            </div>
            
            {{-- CTA --}}
            <div class="mt-12 flex justify-center">
                <a href="{{ route('services') }}"
                    class="bg-[#a67c52] text-white px-8 py-3 rounded-full font-semibold hover:bg-[#8b6f47] transition-all duration-300 shadow-xl hover:scale-105">
                    Lihat Layanan Kami
                </a>
            </div>
        </div>
    </section>
@endsection