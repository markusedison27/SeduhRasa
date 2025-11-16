@extends('layouts.public') {{-- ✅ INI PERBAIKANNYA: Menggunakan Layout Publik --}}

@section('title', 'Layanan Kami | SeduhRasa Coffee')

@section('content')
    {{-- Tambahkan padding atas yang cukup karena header bersifat fixed di layouts/public.blade.php --}}
    <section class="py-16 bg-[#fbf5ef] pt-32 md:pt-40"> 
        <div class="max-w-7xl mx-auto px-4 text-center">
            
            {{-- Konten Services --}}
            <h2 class="font-['Great_Vibes'] text-3xl md:text-5xl mb-6">Our Services</h2>
            <p class="max-w-2xl mx-auto text-stone-600 mb-10">
                Kami menyediakan berbagai layanan untuk memastikan pengalaman terbaik bagi pelanggan SeduhRasa Coffee.
            </p>

            {{-- KONTEN SERVICES CARDS --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div class="p-6 bg-white rounded-lg shadow border hover:shadow-md transition">
                    <img src="https://cdn-icons-png.flaticon.com/512/3515/3515301.png"
                        class="w-16 h-16 mx-auto mb-4" alt="Fresh Coffee Icon"/>
                    <h3 class="font-semibold text-lg mb-2">Fresh Coffee</h3>
                    <p class="text-stone-600 text-sm">Biji kopi pilihan dengan kualitas terbaik.</p>
                </div>

                <div class="p-6 bg-white rounded-lg shadow border hover:shadow-md transition">
                    <img src="https://cdn-icons-png.flaticon.com/512/1046/1046784.png"
                        class="w-16 h-16 mx-auto mb-4" alt="Fast Delivery Icon"/>
                    <h3 class="font-semibold text-lg mb-2">Fast Delivery</h3>
                    <p class="text-stone-600 text-sm">Pesanan diantar cepat & aman ke lokasi Anda.</p>
                </div>

                <div class="p-6 bg-white rounded-lg shadow border hover:shadow-md transition">
                    <img src="https://cdn-icons-png.flaticon.com/512/609/609361.png"
                        class="w-16 h-16 mx-auto mb-4" alt="Premium Quality Icon"/>
                    <h3 class="font-semibold text-lg mb-2">Premium Quality</h3>
                    <p class="text-stone-600 text-sm">Kami selalu menjaga kualitas dan rasa kopi.</p>
                </div>
            </div>
        </div>
    </section>
@endsection