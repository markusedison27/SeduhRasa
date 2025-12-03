@extends('layouts.frontend')

@section('title', 'Layanan Kami | SeduhRasa Coffee')

@section('content')
    {{-- SERVICES SECTION --}}
    <section class="py-24 bg-gradient-to-br from-[#f5e6d3] via-[#f9ead5] to-[#fef3e2]">
        <div class="max-w-7xl mx-auto px-6 text-center">
            
            {{-- Header --}}
            <span class="text-[#8b6f47] font-semibold tracking-[0.3em] text-sm uppercase">What We Offer</span>
            <h2 class="font-['Great_Vibes'] text-6xl md:text-8xl text-[#3d2817] mt-4 mb-6">Our Services</h2>
            <div class="w-24 h-1 bg-[#a67c52] mx-auto mb-8"></div>
            <p class="max-w-2xl mx-auto text-[#5c3d2e] text-lg mb-16">
                Kami menyediakan berbagai layanan untuk memastikan pengalaman terbaik bagi pelanggan SeduhRasa Coffee.
            </p>

            {{-- SERVICES CARDS --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                {{-- Card 1: Fresh Coffee --}}
                <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 p-8 border border-[#e8d4b8] hover:scale-105">
                    <div class="w-20 h-20 mx-auto mb-6 bg-gradient-to-br from-[#8b6f47] to-[#c4905c] rounded-2xl flex items-center justify-center">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-2xl text-[#3d2817] mb-3">Fresh Coffee</h3>
                    <p class="text-[#5c3d2e] leading-relaxed">
                        Biji kopi pilihan dengan kualitas terbaik dari perkebunan pilihan di seluruh dunia.
                    </p>
                </div>

                {{-- Card 2: Fast Delivery --}}
                <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 p-8 border border-[#e8d4b8] hover:scale-105">
                    <div class="w-20 h-20 mx-auto mb-6 bg-gradient-to-br from-[#8b6f47] to-[#c4905c] rounded-2xl flex items-center justify-center">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-2xl text-[#3d2817] mb-3">Fast Delivery</h3>
                    <p class="text-[#5c3d2e] leading-relaxed">
                        Pesanan diantar cepat & aman ke lokasi Anda dengan layanan terbaik kami.
                    </p>
                </div>

                {{-- Card 3: Premium Quality --}}
                <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 p-8 border border-[#e8d4b8] hover:scale-105">
                    <div class="w-20 h-20 mx-auto mb-6 bg-gradient-to-br from-[#8b6f47] to-[#c4905c] rounded-2xl flex items-center justify-center">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-2xl text-[#3d2817] mb-3">Premium Quality</h3>
                    <p class="text-[#5c3d2e] leading-relaxed">
                        Kami selalu menjaga kualitas dan rasa kopi dengan standar premium tertinggi.
                    </p>
                </div>
            </div>

            {{-- CTA --}}
            <div class="mt-16">
                <a href="{{ url('/order') }}"
                    class="inline-block bg-[#a67c52] text-white px-10 py-4 rounded-full font-semibold text-lg hover:bg-[#8b6f47] transition-all duration-300 shadow-xl hover:scale-105">
                    Pesan Sekarang
                </a>
            </div>
        </div>
    </section>
@endsection