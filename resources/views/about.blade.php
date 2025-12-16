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
    // URL GAMBAR SUDAH DIUBAH KE asset('arifin1.jpg')
    ['name' => 'M. Arifin Ilham', 'img' => asset('arifin1.jpg'), 'ig' => 'https://www.instagram.com/m.arifin_ilham024', 'username' => 'm.arifin_ilham024', 'role' => 'Full-Stack Developer'],
    // URL GAMBAR SUDAH DIUBAH KE asset('mazira.jpg')
    ['name' => 'Mazira', 'img' => asset('mazira.jpg'), 'ig' => 'https://www.instagram.com/mazira__', 'username' => 'mazira__', 'role' => 'Database & Content Strategist'],
    // URL GAMBAR SUDAH DIUBAH KE asset('markus.jpg')
    ['name' => 'Markus Edison', 'img' => asset('markus.jpg'), 'ig' => 'https://www.instagram.com/markusedisonsilalahi', 'username' => 'markusedisonsilalahi', 'role' => 'Full-Stack Developer'],
    // URL GAMBAR SUDAH DIUBAH KE asset('elsa.jpg')
    ['name' => 'Elsa Syafitriani', 'img' => asset('elsa.jpg'), 'ig' => 'https://www.instagram.com/elsasyafitri24', 'username' => 'elsasyafitri24', 'role' => 'QA Tester'],
];
@endphp

            {{-- KONTEN TIM (GRID 2x2 / 4 kolom) --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach ($team as $t)
                    <a href="{{ $t['ig'] }}" target="_blank"
                        {{-- ANIMASI HOVER: mirip dengan team-card dari contoh --}}
                        class="team-card-coffee bg-white rounded-2xl shadow-lg transition-all duration-500 ease-out p-6 flex flex-col items-center 
                               hover:shadow-2xl hover:-translate-y-3 transform cursor-pointer group relative overflow-hidden">
                        
                        {{-- Shine effect overlay --}}
                        <div class="absolute inset-0 bg-gradient-to-br from-transparent via-white/0 to-transparent opacity-0 group-hover:opacity-20 transition-opacity duration-500 pointer-events-none"></div>
                        
                        {{-- Container Foto: Ukuran w-32 h-40 (Rasio 4:5) dengan frame effect --}}
                        <div class="relative w-32 h-40 mb-4 overflow-hidden rounded-lg shadow-inner transition-all duration-500 
                                    border-2 border-transparent group-hover:border-[#a67c52] group-hover:shadow-2xl">
                            {{-- Pattern overlay --}}
                            <div class="absolute inset-0 bg-gradient-to-br from-[#a67c52]/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 z-10"></div>
                            
                            <img src="{{ $t['img'] }}" 
                                 class="w-full h-full object-cover transition-all duration-700 group-hover:scale-110 group-hover:brightness-105" 
                                 alt="{{ $t['name'] }} Avatar">
                            
                            {{-- Shine effect on photo --}}
                            <div class="absolute inset-0 bg-gradient-to-tr from-transparent via-white/30 to-transparent opacity-0 group-hover:opacity-100 translate-x-[-100%] group-hover:translate-x-[100%] transition-all duration-1000 pointer-events-none"></div>
                        </div>
                        
                        <div class="font-semibold text-[#3d2817] text-lg transition-all duration-300 group-hover:text-[#a67c52] group-hover:scale-105 z-10">{{ $t['name'] }}</div>
                        <div class="text-[#8b6f47] text-xs mt-1 font-medium transition-all duration-300 group-hover:text-[#6b5537] z-10">{{ $t['role'] }}</div>
                        <div class="text-[#a67c52] text-sm mt-2 transition-all duration-300 group-hover:text-[#8b6f47] group-hover:font-semibold z-10 flex items-center gap-1">
                            <svg class="w-4 h-4 transition-transform duration-300 group-hover:scale-110" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                            {{ '@' . $t['username'] }}
                        </div>
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
                        Menyatukan kualitas rasa dan kemudahan layanan dari barista hingga pelanggan.
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

    {{-- JavaScript untuk animasi tambahan --}}
    <script>
        // Add scroll animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -100px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-in');
                }
            });
        }, observerOptions);

        document.querySelectorAll('.team-card-coffee').forEach(el => {
            observer.observe(el);
        });
    </script>

    {{-- CSS Animasi Tambahan --}}
    <style>
        .team-card-coffee {
            opacity: 0;
            transform: translateY(30px);
            animation: fadeInUp 0.6s ease-out forwards;
        }

        .team-card-coffee:nth-child(1) { animation-delay: 0.1s; }
        .team-card-coffee:nth-child(2) { animation-delay: 0.2s; }
        .team-card-coffee:nth-child(3) { animation-delay: 0.3s; }
        .team-card-coffee:nth-child(4) { animation-delay: 0.4s; }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .team-card-coffee.animate-in {
            animation: none;
            opacity: 1;
            transform: translateY(0);
        }
    </style>
@endsection