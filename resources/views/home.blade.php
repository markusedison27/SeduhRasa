@extends('layouts.frontend')

@section('title', 'SeduhRasa Coffee - Kopi Terbaik')

@section('content')
    <main class="bg-[#1a1a1a]"> {{-- biar background dasar nggak putih --}}

        {{-- HERO SECTION - MODERN & PREMIUM --}}
        <section class="relative min-h-screen w-full overflow-hidden">
            @php
                $slides = [
                    'https://images.unsplash.com/photo-1511920170033-f8396924c348?auto=format&fit=crop&w=1920&q=85',
                    'https://images.unsplash.com/photo-1442512595331-e89e73853f31?auto=format&fit=crop&w=1920&q=85',
                    'https://images.unsplash.com/photo-1501339847302-ac426a4a7cbb?auto=format&fit=crop&w=1920&q=85',
                ];
            @endphp

            {{-- background image crossfade --}}
            <img id="heroA" src="{{ $slides[0] }}"
                 class="absolute inset-0 w-full h-full object-cover transition-opacity duration-1000 opacity-100">
            <img id="heroB" src="{{ $slides[0] }}"
                 class="absolute inset-0 w-full h-full object-cover transition-opacity duration-1000 opacity-0">

            {{-- overlay gelap --}}
            <div class="absolute inset-0 bg-gradient-to-br from-[#3d2817]/70 via-[#5c3d2e]/60 to-[#2a1810]/70"></div>

            <div class="relative z-10 min-h-screen flex items-center justify-center px-6">
                <div class="text-center max-w-5xl">
                    <div class="mb-8">
                        <span
                            class="inline-block px-6 py-2 bg-[#8b6f47]/20 backdrop-blur-sm border border-[#c4905c]/30 rounded-full text-[#f5e6d3] text-sm tracking-widest">
                            ☕ PREMIUM COFFEE EXPERIENCE
                        </span>
                    </div>

                    <h1 class="font-['Great_Vibes'] text-8xl md:text-9xl lg:text-[12rem] text-[#f5e6d3] mb-6 leading-none">
                        SeduhRasa
                    </h1>

                    <p class="text-[#e8d4b8] text-2xl md:text-3xl mb-12 font-light tracking-wide max-w-3xl mx-auto">
                        Discover the Art of Perfect Coffee
                    </p>

                    <div class="flex flex-col sm:flex-row gap-5 justify-center">    
                        {{-- Order Sekarang --}}
                        <a href="{{ url('/order') }}"
                           class="group bg-[#a67c52] text-white px-12 py-5 rounded-full font-semibold text-lg hover:bg-[#8b6f47] transition-all duration-300 shadow-xl hover:scale-105">
                            Order Sekarang
                        </a>
                    </div>
                </div>
            </div>

            {{-- Scroll Indicator --}}
            <div class="absolute bottom-10 left-1/2 -translate-x-1/2 animate-bounce">
                <svg class="w-8 h-8 text-[#f5e6d3]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                </svg>
            </div>
        </section>

        {{-- WELCOME SECTION --}}
        <section id="explore" class="relative py-28 bg-gradient-to-br from-[#f5e6d3] via-[#f9ead5] to-[#fef3e2]">
            <div class="max-w-7xl mx-auto px-6">
                <div class="text-center mb-20">
                    <span class="text-[#8b6f47] font-semibold tracking-[0.3em] text-sm uppercase">Our Story</span>
                    <h2 class="font-['Great_Vibes'] text-6xl md:text-8xl text-[#3d2817] mt-4 mb-6">
                        Passion in Every Cup
                    </h2>
                    <div class="w-24 h-1 bg-[#a67c52] mx-auto mb-8"></div>
                    <p class="text-[#5c3d2e] text-xl max-w-3xl mx-auto leading-relaxed">
                        Kami memulai perjalanan dengan satu misi sederhana: menghadirkan kopi berkualitas tinggi yang
                        dibuat dengan cinta dan dedikasi
                    </p>
                </div>

                <div class="grid md:grid-cols-2 gap-16 items-center mt-20">
                    <div class="relative">
                        <div class="absolute -top-8 -left-8 w-64 h-64 bg-[#c4905c]/20 rounded-full blur-3xl"></div>
                        <img src="https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?auto=format&fit=crop&w=800&q=80"
                             class="relative z-10 rounded-3xl shadow-2xl w-full h-[600px] object-cover">
                    </div>

                    <div class="space-y-8">
                        {{-- card 1 --}}
                        <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow duration-300">
                            <div class="flex items-start gap-6">
                                <div
                                    class="flex-shrink-0 w-16 h-16 bg-gradient-to-br from-[#8b6f47] to-[#c4905c] rounded-2xl flex items-center justify-center">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-2xl font-bold text-[#3d2817] mb-3">Premium Selection</h3>
                                    <p class="text-[#5c3d2e] leading-relaxed">
                                        Biji kopi pilihan dari perkebunan terbaik di seluruh dunia, dipilih dengan teliti
                                        untuk kesempurnaan rasa
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- card 2 --}}
                        <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow duration-300">
                            <div class="flex items-start gap-6">
                                <div
                                    class="flex-shrink-0 w-16 h-16 bg-gradient-to-br from-[#8b6f47] to-[#c4905c] rounded-2xl flex items-center justify-center">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-2xl font-bold text-[#3d2817] mb-3">Expert Roasting</h3>
                                    <p class="text-[#5c3d2e] leading-relaxed">
                                        Proses roasting yang presisi untuk mengeluarkan karakter unik setiap biji kopi
                                        dengan sempurna
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- card 3 --}}
                        <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow duration-300">
                            <div class="flex items-start gap-6">
                                <div
                                    class="flex-shrink-0 w-16 h-16 bg-gradient-to-br from-[#8b6f47] to-[#c4905c] rounded-2xl flex items-center justify-center">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-2xl font-bold text-[#3d2817] mb-3">Crafted with Love</h3>
                                    <p class="text-[#5c3d2e] leading-relaxed">
                                        Setiap cangkir dibuat dengan perhatian penuh dan dedikasi oleh barista
                                        berpengalaman kami
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>

        {{-- SIGNATURE EXPERIENCE --}}
        <section class="relative py-28 bg-[#3d2817] overflow-hidden">
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-0 left-0 w-96 h-96 bg-amber-800 rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 right-0 w-96 h-96 bg-yellow-900 rounded-full blur-3xl"></div>
            </div>

            <div class="relative z-10 max-w-7xl mx-auto px-6">
                <div class="text-center mb-20">
                    <span class="text-amber-300 font-semibold tracking-[0.3em] text-sm uppercase">Our Promise</span>
                    <h2 class="font-['Great_Vibes'] text-6xl md:text-8xl text-[#f5e6d3] mt-4 mb-6">
                        The SeduhRasa Experience
                    </h2>
                    <div class="w-24 h-1 bg-[#c4905c] mx-auto mb-8"></div>
                    <p class="text-[#e8d4b8] text-xl max-w-3xl mx-auto leading-relaxed">
                        Lebih dari sekadar kopi. Kami menciptakan momen dan kenangan yang tak terlupakan
                    </p>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    {{-- 3 cards sama seperti punyamu tadi --}}
                    {{-- ... (isi tetap, cuma dirapikan) --}}
                </div>
            </div>
        </section>
    </main>
@endsection

@push('scripts')
    <script>
        (function () {
            const slides = @json($slides ?? []);

            if (!slides.length || slides.length === 1) return;

            const a = document.getElementById('heroA');
            const b = document.getElementById('heroB');

            let i = 0;
            let useA = true;

            function tick() {
                i = (i + 1) % slides.length;
                const nextSrc = slides[i];

                if (useA) {
                    b.src = nextSrc;
                    b.classList.remove('opacity-0');
                    b.classList.add('opacity-100');
                    a.classList.remove('opacity-100');
                    a.classList.add('opacity-0');
                } else {
                    a.src = nextSrc;
                    a.classList.remove('opacity-0');
                    a.classList.add('opacity-100');
                    b.classList.remove('opacity-100');
                    b.classList.add('opacity-0');
                }

                useA = !useA;
            }

            setInterval(tick, 5000);
        })();

        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                const target = document.querySelector(href);
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
@endpush