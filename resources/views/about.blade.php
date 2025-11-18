@extends('layouts.public')

@section('title', 'Tentang Kami | SeduhRasa Coffee')

@section('content')
    {{-- SECTION: ABOUT US & TEAM --}}
    {{-- Tambahkan padding atas yang cukup karena header bersifat fixed di layouts/public --}}
    <section class="py-16 bg-white pt-32 md:pt-40"> 
        <div class="max-w-7xl mx-auto px-4 text-center">
            
            {{-- JUDUL DAN DESKRIPSI --}}
            <h2 class="font-['Great_Vibes'] text-3xl md:text-5xl mb-6">About Us</h2>
            <p class="max-w-2xl mx-auto text-stone-600 mb-10">
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
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mt-8">
                @foreach ($team as $t)
                    <a href="{{ $t['ig'] }}" target="_blank"
                        class="bg-stone-50 border rounded-lg shadow hover:shadow-md transition p-5 flex flex-col items-center">
                        <img src="{{ $t['img'] }}" class="w-20 h-20 mb-4" alt="{{ $t['name'] }} Avatar">
                        <div class="font-semibold text-stone-800">{{ $t['name'] }}</div>
                        <div class="text-amber-500 text-sm mt-1">@ Instagram</div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- SECTION: NILAI DAN MISI (Menggunakan gaya yang Anda kirimkan sebelumnya) --}}
    <section class="py-16 bg-[#fbf5ef]">
        <div class="max-w-3xl mx-auto px-4">
            <h2 class="text-2xl font-semibold text-center mb-10">Filosofi Kami</h2>
            <div class="grid gap-4 sm:grid-cols-3">
                {{-- Misi --}}
                <div class="rounded-lg border border-stone-200 bg-white p-4 shadow-sm">
                    <div class="text-[10px] uppercase tracking-wide text-amber-600 font-bold">Misi</div>
                    <p class="mt-2 text-sm text-stone-700/90">
                        Menyatukan kualitas rasa dan kemudahan layanan—dari barista hingga pelanggan.
                    </p>
                </div>
                {{-- Nilai --}}
                <div class="rounded-lg border border-stone-200 bg-white p-4 shadow-sm">
                    <div class="text-[10px] uppercase tracking-wide text-amber-600 font-bold">Nilai</div>
                    <p class="mt-2 text-sm text-stone-700/90">
                        Sederhana, cepat, ramah. Tanpa ribet, fokus pada pengalaman.
                    </p>
                </div>
                {{-- Kontak --}}
                <div class="rounded-lg border border-stone-200 bg-white p-4 shadow-sm">
                    <div class="text-[10px] uppercase tracking-wide text-amber-600 font-bold">Kontak</div>
                    <p class="mt-2 text-sm text-stone-700/90">
                        Butuh bantuan? <a href="{{ route('contact') }}" class="underline text-amber-700 hover:text-amber-600">Hubungi kami</a>.
                    </p>
                </div>
            </div>
            
            {{-- CTA opsional --}}
            <div class="mt-10 flex justify-center">
                <a
                    href="{{ route('services') }}"
                    class="inline-flex items-center gap-2 rounded-md bg-amber-600 px-5 py-2 text-white hover:bg-amber-700 transition-colors text-sm font-medium"
                >
                    Lihat Layanan
                </a>
            </div>
        </div>
    </section>
@endsection