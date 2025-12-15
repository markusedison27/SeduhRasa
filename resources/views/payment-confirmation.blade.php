@extends('layouts.customer')

@section('title', 'Konfirmasi Pembayaran')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-amber-50 to-stone-100 py-12 px-4">
    <div class="max-w-2xl mx-auto">
        
        {{-- Header Success --}}
        <div class="text-center mb-8 animate-fade-in">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 rounded-full mb-4">
                <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-stone-800 mb-2">Pesanan Berhasil Dibuat!</h1>
            <p class="text-stone-600">Nomor Pesanan: <span class="font-semibold text-amber-700">#{{ $order->id }}</span></p>
        </div>

        {{-- Card Informasi Pesanan --}}
        <div class="bg-white rounded-2xl shadow-xl border border-stone-200 overflow-hidden mb-6">
            
            {{-- Header Card --}}
            <div class="bg-gradient-to-r from-amber-600 to-amber-700 px-6 py-4">
                <h2 class="text-xl font-semibold text-white">📋 Detail Pesanan</h2>
            </div>

            {{-- Body Card --}}
            <div class="p-6 space-y-4">
                
                {{-- Info Pelanggan --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-stone-500 mb-1">Nama Pelanggan</p>
                        <p class="font-semibold text-stone-800">{{ $order->nama_pelanggan }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-stone-500 mb-1">Nomor Meja</p>
                        <p class="font-semibold text-stone-800">Meja #{{ $order->nomor_meja }}</p>
                    </div>
                </div>

                {{-- Divider --}}
                <hr class="border-stone-200">

                {{-- List Menu --}}
                <div>
                    <p class="text-sm text-stone-500 mb-3 font-medium">Item Pesanan:</p>
                    <div class="space-y-2">
                        @foreach($order->items as $item)
                        <div class="flex justify-between items-center bg-stone-50 rounded-lg p-3">
                            <div class="flex-1">
                                <p class="font-medium text-stone-800">{{ $item->menu->nama }}</p>
                                <p class="text-sm text-stone-500">{{ $item->jumlah }}x @ Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                            </div>
                            <p class="font-semibold text-amber-700">
                                Rp {{ number_format($item->jumlah * $item->harga, 0, ',', '.') }}
                            </p>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Divider --}}
                <hr class="border-stone-200">

                {{-- Total Pembayaran --}}
                <div class="flex justify-between items-center bg-amber-50 rounded-lg p-4 border-2 border-amber-200">
                    <p class="text-lg font-bold text-stone-800">Total Pembayaran</p>
                    <p class="text-2xl font-bold text-amber-700">
                        Rp {{ number_format($order->subtotal, 0, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Card QR Code Pembayaran --}}
        <div class="bg-white rounded-2xl shadow-xl border border-stone-200 overflow-hidden">
            
            {{-- Header Card --}}
            <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4">
                <h2 class="text-xl font-semibold text-white">💳 Selesaikan Pembayaran</h2>
            </div>

            {{-- Body Card --}}
            <div class="p-6 text-center">
                
                <p class="text-stone-600 mb-6">
                    Segera selesaikan pembayaran digital kamu agar pesanan bisa kami proses
                </p>

                {{-- QR Code Display --}}
                @php
                    // Ambil QR Code aktif dari database
                    $activeQrCode = \App\Models\QrCode::where('is_active', true)->first();
                @endphp

                @if($activeQrCode)
                    <div class="inline-block bg-white p-6 rounded-2xl shadow-lg border-2 border-stone-200 mb-6">
                        <img src="{{ asset('storage/' . $activeQrCode->file_path) }}" 
                             alt="QR Code Pembayaran {{ ucfirst($activeQrCode->payment_method) }}" 
                             class="w-64 h-64 object-contain mx-auto">
                        
                        {{-- Badge Payment Method --}}
                        <div class="mt-4">
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"></path>
                                    <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"></path>
                                </svg>
                                Pembayaran via {{ ucfirst($activeQrCode->payment_method) }}
                            </span>
                        </div>
                    </div>

                    {{-- Instruksi Pembayaran --}}
                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 text-left">
                        <h3 class="font-semibold text-blue-900 mb-2 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                            Langkah Pembayaran:
                        </h3>
                        <ol class="list-decimal list-inside space-y-2 text-sm text-blue-800">
                            <li>Buka aplikasi Dana / e-wallet yang kamu gunakan</li>
                            <li>Scan QR atau transfer ke nomor Dana kasir</li>
                            <li>Masukkan nominal sesuai Total Pembayaran</li>
                            <li>Simpan bukti transfer dan tunjukkan ke kasir untuk konfirmasi</li>
                        </ol>
                    </div>

                @else
                    {{-- Fallback jika QR Code belum diupload --}}
                    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6">
                        <svg class="w-16 h-16 text-yellow-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        <h3 class="text-lg font-semibold text-yellow-800 mb-2">QR Code Belum Tersedia</h3>
                        <p class="text-yellow-700 mb-4">
                            Silakan lakukan pembayaran langsung ke kasir atau hubungi staff kami untuk informasi pembayaran.
                        </p>
                    </div>
                @endif

                {{-- Note --}}
                <p class="text-sm text-stone-500 mt-6">
                    Setelah transfer, pesananmu akan diproses oleh kasir untuk konfirmasi
                </p>
            </div>
        </div>

        {{-- Button Actions --}}
        <div class="mt-8 flex flex-col sm:flex-row gap-4">
            <a href="{{ route('home') }}" 
               class="flex-1 inline-flex items-center justify-center px-6 py-3 border-2 border-stone-300 text-base font-medium rounded-xl text-stone-700 bg-white hover:bg-stone-50 transition-all shadow-sm">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Kembali ke Beranda
            </a>
            <a href="{{ route('menu') }}" 
               class="flex-1 inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-xl text-white bg-amber-600 hover:bg-amber-700 transition-all shadow-lg">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Pesan Lagi
            </a>
        </div>

    </div>
</div>

@push('styles')
<style>
    @keyframes fade-in {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .animate-fade-in {
        animation: fade-in 0.6s ease-out;
    }
</style>
@endpush
@endsection