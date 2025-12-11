{{-- resources/views/admin/orders/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Detail Order #' . $order->id)

@section('content')
    <div class="min-h-screen bg-neutral-100 py-8 px-4">
        <div class="max-w-sm mx-auto">

            {{-- Receipt Card - Exact Seduhrasa Coffee Style --}}
            <div class="bg-white rounded-none shadow-md">

                {{-- Header - Logo & Info Toko --}}
                <div class="bg-white p-8 text-center">
                    {{-- Logo - Double Circle Green --}}
                    {{-- Logo - Menggunakan file LOGO2.png dari folder public --}}
                    <div class="w-24 h-24 mx-auto mb-4 flex items-center justify-center">
                        <img src="{{ asset('LOGO2.png') }}" alt="Logo SeduhRasa" class="w-full h-full object-contain">
                    </div>

                    <h2 class="text-base font-bold text-neutral-600 tracking-widest mb-2">SEDUHRASA COFFEE</h2>
                    <p class="text-xs text-neutral-500">Jl Mawar No. 15, Bungkuto</p>
                    <p class="text-xs text-neutral-500">Telp: (021) 1234 5678</p>
                </div>

                {{-- Dotted Line --}}
                <div class="border-t border-dashed border-neutral-300"></div>

                {{-- Info Order --}}
                <div class="p-6 space-y-2 text-xs">
                    <div class="flex justify-between text-neutral-600">
                        <span>{{ $order->created_at->format('Y-m-d') }}</span>
                        <span>{{ $order->created_at->format('H:i:s') }} WIB</span>
                    </div>
                    <div class="text-neutral-600">
                        <span>No: {{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</span>
                    </div>
                    <div class="text-neutral-600">
                        <span>Pelanggan: {{ $order->nama_pelanggan ?? $order->customer_name ?? 'Mazira' }}</span>
                    </div>
                    <div class="text-neutral-600">
                        <span>Metode: {{ ucfirst($order->metode_pembayaran ?? 'Cash') }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-neutral-600">Status:</span>
                        <span
                            class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-green-100 text-green-700">
                            ● Selesai
                        </span>
                    </div>
                </div>

                {{-- Dotted Line --}}
                <div class="border-t border-dashed border-neutral-300"></div>

                {{-- Items --}}
                <div class="p-6 text-xs">
                    @if($order->items && $order->items->count())
                        @foreach($order->items as $item)
                            <div class="mb-1 text-neutral-700">
                                {{ $loop->iteration }}. {{ $item->name }} x{{ $item->qty }}
                            </div>
                        @endforeach
                    @else
                        <div class="mb-1 text-neutral-700">
                            1. Pudding Caramel x1
                        </div>
                    @endif
                    <p class="text-neutral-600 mt-3">Total QTY:</p>
                </div>

                {{-- Dotted Line --}}
                <div class="border-t border-dashed border-neutral-300"></div>

                {{-- Total --}}
                <div class="p-6 space-y-1 text-xs">
                    <div class="flex justify-between text-neutral-600">
                        <span>Sub Total</span>
                        <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-neutral-800 font-semibold">
                        <span>Total</span>
                        <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-neutral-600">
                        <span>Bayar ({{ strtoupper($order->metode_pembayaran ?? 'COD') }})</span>
                        <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-neutral-600">
                        <span>Kembali</span>
                        <span>Rp 0</span>
                    </div>
                </div>

                {{-- Footer Note --}}
                <div class="px-6 pb-6">
                    <p class="text-center text-[10px] text-neutral-500 leading-relaxed">
                        Terima kasih Telah Berbelanja<br>
                        Struk ini dicetak oleh kasir sebagai bukti transaksi.<br>
                        <span class="uppercase">SIMPAN STRUK INI DAN TUNJUKKAN BILA DIPERLUKAN</span>
                    </p>
                </div>

                {{-- Dotted Line --}}
                <div class="border-t border-dashed border-neutral-300"></div>

                {{-- Status Pesanan Box --}}
                <div class="p-6">
                    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-md">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-blue-500 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" />
                            </svg>
                            <div>
                                <p class="text-sm font-semibold text-blue-800">Status Pesanan</p>
                                <p class="text-xs text-blue-700 mt-1">Pesanan Anda telah selesai! Terima kasih telah
                                    memesan.</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="p-6 pt-0">
                    <div class="grid grid-cols-2 gap-3">
                        <button onclick="window.history.back()"
                            class="flex items-center justify-center px-4 py-3 bg-neutral-100 hover:bg-neutral-200 text-neutral-700 font-medium rounded-lg transition-colors text-sm">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Kembali ke<br>Menu
                        </button>

                        <button onclick="window.print()"
                            class="flex items-center justify-center px-4 py-3 bg-[#7B3F00] hover:bg-[#8B4513] text-white font-bold rounded-lg shadow transition-colors text-sm">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z" />
                            </svg>
                            Cetak Struk
                        </button>
                    </div>
                </div>

                {{-- Bottom Note --}}
                <div class="px-6 pb-6 text-center text-[10px] text-neutral-400 leading-relaxed">
                    <p>Simpan nomor pesanan Anda untuk referensi</p>
                    <p>Jika ada pertanyaan, hubungi staff kami</p>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            @media print {
                body * {
                    visibility: hidden;
                }

                .bg-white {
                    visibility: visible;
                    position: absolute;
                    left: 0;
                    top: 0;
                    width: 100%;
                }

                .bg-white * {
                    visibility: visible;
                }

                button {
                    display: none !important;
                }

                .border-dashed {
                    border-style: dashed !important;
                }

                @page {
                    margin: 0;
                    size: 80mm auto;
                }
            }
        </style>
    @endpush
@endsection