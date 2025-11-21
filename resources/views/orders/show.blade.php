@extends('layouts.app')

@section('title', 'Detail Order #' . $order->id)

@section('content')
    <style>
        .order-detail-bg {
            background: radial-gradient(circle at top left, rgba(255, 193, 7, .05), transparent 55%);
        }

        .card-soft {
            border-radius: 18px;
            border: 1px solid #f1f5f9;
            box-shadow: 0 12px 35px rgba(15, 23, 42, .06);
        }

        .badge-status-pill {
            border-radius: 999px;
            font-size: .78rem;
            padding: .3rem .9rem;
        }

        .meta-label {
            font-size: .8rem;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: #94a3b8;
        }

        .success-icon-animate {
            animation: successPop 0.6s ease-out;
        }

        @keyframes successPop {
            0% {
                transform: scale(0);
                opacity: 0;
            }

            50% {
                transform: scale(1.1);
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .slide-in-alert {
            animation: slideIn 0.4s ease-out;
        }

        @keyframes slideIn {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes slideInNotify {
            from {
                transform: translateY(10px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .animate-slideIn {
            animation: slideInNotify 0.3s ease-out;
        }

        /* ukuran kertas thermal kira2 58mm */
        @page {
            size: 58mm auto;
            margin: 4mm;
        }

        /* ========== MODE CETAK STRUK (NOTA CAFE) ========== */
        @media print {
            body {
                margin: 0;
                background: #ffffff;
            }

            /* sembunyikan semuanya dulu */
            body * {
                visibility: hidden;
            }

            /* cuma area ini yang dicetak */
            #print-area,
            #print-area * {
                visibility: visible;
            }

            /* layout struk */
            #print-area {
                position: static;
                width: 100%;
                max-width: 100%;
                padding: 4px 4px 6px;
                border-radius: 0;
                box-shadow: none;
                font-size: 10px;
            }

            .order-detail-bg {
                background: #ffffff !important;
                padding: 0 !important;
            }

            .container {
                padding: 0 !important;
                margin: 0 !important;
            }

            /* header gradient jadi putih & tipis */
            #print-area .print-header {
                background: #ffffff !important;
                color: #000000 !important;
                padding-top: 4px !important;
                padding-bottom: 4px !important;
                border-bottom: 1px dashed #000000;
            }

            /* sembunyikan ikon bulat besar */
            .print-hide-on-paper {
                display: none !important;
            }

            /* kecilin font */
            #print-area h1 {
                font-size: 14px !important;
                margin-bottom: 2px;
            }

            #print-area h2 {
                font-size: 11px !important;
            }

            #print-area p,
            #print-area span,
            #print-area div {
                font-size: 10px;
            }

            /* total pembayaran sedikit lebih besar */
            #print-area .text-2xl,
            #print-area .text-xl {
                font-size: 12px !important;
            }

            #print-area .text-lg {
                font-size: 11px !important;
            }

            /* hemat padding */
            #print-area .px-8 {
                padding-left: 6px;
                padding-right: 6px;
            }

            #print-area .py-6 {
                padding-top: 6px;
                padding-bottom: 6px;
            }

            /* warna hitam putih */
            #print-area * {
                background: transparent !important;
                color: #000000 !important;
                box-shadow: none !important;
            }

            #print-area .border-gray-200,
            #print-area .border-gray-300,
            #print-area .border-blue-500,
            #print-area .border-dashed {
                border-color: #000000 !important;
            }

            /* tombol, popup, dll jangan ikut tercetak */
            .no-print {
                display: none !important;
            }
        }
    </style>

    <div class="order-detail-bg py-4" id="order-wrapper" data-order-id="{{ $order->id }}" data-status="{{ $order->status }}">

        <div class="container mx-auto px-4 py-8">
            <div class="max-w-2xl mx-auto">

                {{-- Success Notification --}}
                @if (session('success'))
                    <div id="successAlert"
                        class="mb-6 bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg flex items-start gap-4 animate-slideIn no-print">
                        <svg class="w-6 h-6 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="flex-1">
                            <p class="font-semibold">{{ session('success') }}</p>
                        </div>
                        <button onclick="document.getElementById('successAlert').remove()"
                            class="text-white hover:text-gray-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                @endif

                {{-- Main Card (INI YANG DI-CETAK) --}}
                <div id="print-area" class="bg-white rounded-2xl shadow-xl overflow-hidden">

                    {{-- Header --}}
                    <div class="bg-gradient-to-r from-orange-500 to-yellow-500 text-white px-8 py-6 print-header">
                        <div class="flex items-center justify-center mb-4 print-hide-on-paper">
                            <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center shadow-lg">
                                <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                        </div>
                        <h1 class="text-3xl font-bold text-center">Pesanan Berhasil!</h1>
                        <p class="text-center text-orange-100 mt-2">Terima kasih telah memesan</p>
                    </div>

                    {{-- Order Info --}}
                    <div class="px-8 py-6">

                        {{-- Order Number & Status --}}
                        <div class="flex items-center justify-between mb-6 pb-6 border-b border-gray-200">
                            <div>
                                <p class="text-sm text-gray-600">Nomor Pesanan</p>
                                <p class="text-2xl font-bold text-gray-800">#{{ $order->id }}</p>
                            </div>
                            <div>
                                @php
                                    $statusConfig = [
                                        'pending' => [
                                            'bg' => 'bg-yellow-100',
                                            'text' => 'text-yellow-800',
                                            'label' => 'Pending',
                                            'dot' => 'bg-yellow-500',
                                        ],
                                        'proses' => [
                                            'bg' => 'bg-blue-100',
                                            'text' => 'text-blue-800',
                                            'label' => 'Diproses',
                                            'dot' => 'bg-blue-500',
                                        ],
                                        'selesai' => [
                                            'bg' => 'bg-green-100',
                                            'text' => 'text-green-800',
                                            'label' => 'Selesai',
                                            'dot' => 'bg-green-500',
                                        ],
                                        'batal' => [
                                            'bg' => 'bg-red-100',
                                            'text' => 'text-red-800',
                                            'label' => 'Dibatalkan',
                                            'dot' => 'bg-red-500',
                                        ],
                                    ];
                                    $config = $statusConfig[$order->status] ?? $statusConfig['pending'];
                                @endphp
                                <span id="status-badge"
                                    class="inline-flex items-center {{ $config['bg'] }} {{ $config['text'] }} px-4 py-2 rounded-full text-sm font-semibold">
                                    <span id="status-dot" class="w-2 h-2 rounded-full {{ $config['dot'] }} mr-2"></span>
                                    <span id="status-badge-text">{{ $config['label'] }}</span>
                                </span>
                            </div>
                        </div>

                        {{-- Customer Info --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="flex items-center gap-3 mb-2">
                                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    <p class="text-sm font-medium text-gray-600">Nama Pelanggan</p>
                                </div>
                                <p class="text-lg font-semibold text-gray-800">{{ $order->nama_pelanggan }}</p>
                            </div>

                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="flex items-center gap-3 mb-2">
                                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <p class="text-sm font-medium text-gray-600">Waktu Pemesanan</p>
                                </div>
                                <p class="text-lg font-semibold text-gray-800">
                                    {{ $order->created_at->format('d M Y, H:i') }} WIB</p>
                            </div>

                            @if ($order->no_meja)
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="flex items-center gap-3 mb-2">
                                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                            </path>
                                        </svg>
                                        <p class="text-sm font-medium text-gray-600">Nomor Meja</p>
                                    </div>
                                    <p class="text-lg font-semibold text-gray-800">{{ $order->no_meja }}</p>
                                </div>
                            @endif

                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="flex items-center gap-3 mb-2">
                                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                                        </path>
                                    </svg>
                                    <p class="text-sm font-medium text-gray-600">Metode Pembayaran</p>
                                </div>
                                <p class="text-lg font-semibold text-gray-800">
                                    {{ $order->metode_pembayaran == 'cod' ? 'Bayar di Tempat (Cash)' : 'Transfer / Dana' }}
                                </p>
                            </div>
                        </div>

                        {{-- Order Items --}}
                        <div class="mb-6">
                            <h2 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                    </path>
                                </svg>
                                Detail Pesanan
                            </h2>
                            <div class="bg-gray-50 rounded-lg p-6">
                                <div class="space-y-3">
                                    @foreach (explode(', ', $order->menu_dipesan) as $item)
                                        <div
                                            class="flex items-center justify-between py-2 border-b border-gray-200 last:border-0">
                                            <div class="flex items-center gap-3">
                                                <div class="w-2 h-2 rounded-full bg-orange-500"></div>
                                                <span class="text-gray-800 font-medium">{{ $item }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                {{-- Total --}}
                                <div class="mt-6 pt-4 border-t-2 border-gray-300">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-600">Total Item:</span>
                                        <span class="font-semibold text-gray-800">{{ $order->jumlah }} item</span>
                                    </div>
                                    <div class="flex items-center justify-between mt-3">
                                        <span class="text-lg font-bold text-gray-800">Total Pembayaran:</span>
                                        <span class="text-2xl font-bold text-orange-600">
                                            Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                                        </span>
                                    </div>
                                </div>

                                {{-- Pesan terima kasih (ikut ke struk) --}}
                                <div class="mt-6 pt-4 border-t border-dashed border-gray-300 text-center">
                                    <p class="text-sm font-semibold text-gray-800">
                                        Terima kasih, pesanan Anda telah kami proses di
                                        <span class="text-orange-500">SeduhRasa Coffee</span>.
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1">
                                        Struk ini dicetak oleh kasir sebagai bukti transaksi.
                                    </p>
                                    <p class="text-[10px] text-gray-400 mt-1 tracking-wide uppercase">
                                        Simpan struk ini dan tunjukkan bila diperlukan.
                                    </p>
                                </div>

                            </div>

                            {{-- Status Info Box (tidak ikut cetak) --}}
                            <div class="bg-blue-50 border-l-4 border-blue-500 rounded-lg p-5 mb-6 no-print">
                                <div class="flex gap-3">
                                    <svg class="w-6 h-6 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <div>
                                        <p class="font-semibold text-blue-900 mb-1">Status Pesanan</p>
                                        <p id="status-info-message" class="text-sm text-blue-800">
                                            @if ($order->status == 'pending')
                                                Pesanan Anda sedang menunggu konfirmasi dari admin. Kami akan segera
                                                memproses pesanan Anda.
                                            @elseif($order->status == 'proses')
                                                Pesanan Anda sedang diproses. Mohon tunggu sebentar.
                                            @elseif($order->status == 'selesai')
                                                Pesanan Anda telah selesai! Terima kasih telah memesan.
                                            @else
                                                Pesanan Anda telah dibatalkan.
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>

                            {{-- Action Buttons (no-print) --}}
                            <div class="flex flex-col sm:flex-row gap-4 no-print">
                                <a href="{{ url('/') }}"
                                    class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold py-4 px-6 rounded-lg text-center transition-all duration-200 flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                    </svg>
                                    Kembali ke Menu
                                </a>
                                <button onclick="window.print()"
                                    class="flex-1 bg-gradient-to-r from-orange-500 to-yellow-500 hover:from-orange-600 hover:to-yellow-600 text-white font-semibold py-4 px-6 rounded-lg text-center transition-all duration-200 flex items-center justify-center gap-2 shadow-lg">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                                        </path>
                                    </svg>
                                    Cetak Struk
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Footer Note (no-print) --}}
                    <div class="text-center mt-8 text-gray-600 text-sm no-print">
                        <p>Simpan nomor pesanan Anda untuk referensi</p>
                        <p class="mt-1">Jika ada pertanyaan, hubungi staff kami</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- POPUP NOTIF STATUS DIUBAH (no-print) --}}
        <div id="status-popup" class="fixed inset-0 bg-black/40 flex items-center justify-center z-50 hidden no-print">
            <div class="bg-white rounded-2xl shadow-2xl max-w-sm w-full mx-4 p-6 text-center animate-slideIn">
                <div class="w-14 h-14 mx-auto mb-3 rounded-full bg-amber-100 flex items-center justify-center text-2xl">
                    🔔
                </div>
                <h2 class="text-lg font-semibold mb-1" id="status-popup-title">
                    Pesanan Diperbarui
                </h2>
                <p class="text-sm text-stone-500 mb-4" id="status-popup-message">
                    Pesanan kamu sedang diproses.
                </p>
                <button id="status-popup-ok"
                    class="bg-gradient-to-r from-orange-500 to-yellow-500 hover:from-orange-600 hover:to-yellow-600 text-white font-semibold px-4 py-2 rounded-xl w-full">
                    Oke, mengerti
                </button>
            </div>
        </div>

        <script>
            // Auto-hide success alert after 5 seconds
            setTimeout(function() {
                const alert = document.getElementById('successAlert');
                if (alert) {
                    alert.style.transition = 'all 0.5s ease-out';
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-20px)';
                    setTimeout(() => alert.remove(), 500);
                }
            }, 5000);

            // Polling status order + popup notif
            document.addEventListener('DOMContentLoaded', () => {
                const wrapper = document.getElementById('order-wrapper');
                if (!wrapper) return;

                let currentStatus = wrapper.dataset.status;

                const statusBadge = document.getElementById('status-badge');
                const statusBadgeText = document.getElementById('status-badge-text');
                const statusDot = document.getElementById('status-dot');
                const statusInfoMsg = document.getElementById('status-info-message');

                const popup = document.getElementById('status-popup');
                const popupTitle = document.getElementById('status-popup-title');
                const popupMessage = document.getElementById('status-popup-message');
                const popupOk = document.getElementById('status-popup-ok');

                function applyStatusUI(newStatus) {
                    let bgClass = 'bg-yellow-100';
                    let textClass = 'text-yellow-800';
                    let dotClass = 'bg-yellow-500';
                    let labelText = 'Pending';
                    let infoText =
                        'Pesanan Anda sedang menunggu konfirmasi dari admin. Kami akan segera memproses pesanan Anda.';

                    if (newStatus === 'proses') {
                        bgClass = 'bg-blue-100';
                        textClass = 'text-blue-800';
                        dotClass = 'bg-blue-500';
                        labelText = 'Proses';
                        infoText = 'Pesanan Anda sedang diproses. Mohon tunggu sebentar.';
                    } else if (newStatus === 'selesai') {
                        bgClass = 'bg-green-100';
                        textClass = 'text-green-800';
                        dotClass = 'bg-green-500';
                        labelText = 'Selesai';
                        infoText = 'Pesanan Anda telah selesai! Terima kasih telah memesan.';
                    } else if (newStatus === 'batal') {
                        bgClass = 'bg-red-100';
                        textClass = 'text-red-800';
                        dotClass = 'bg-red-500';
                        labelText = 'Batal';
                        infoText = 'Pesanan Anda telah dibatalkan.';
                    }

                    if (statusBadge) {
                        statusBadge.className =
                            'inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold ' + bgClass + ' ' +
                            textClass;
                    }
                    if (statusBadgeText) {
                        statusBadgeText.textContent = labelText;
                    }
                    if (statusDot) {
                        statusDot.className = 'w-2 h-2 rounded-full mr-2 ' + dotClass;
                    }
                    if (statusInfoMsg) {
                        statusInfoMsg.textContent = infoText;
                    }
                }

                function showPopupForStatus(newStatus) {
                    let title = 'Pesanan Diperbarui';
                    let message = '';

                    if (newStatus === 'proses') {
                        title = 'Pesanan Sedang Diproses';
                        message = 'Pesanan kamu sedang disiapkan oleh barista. Mohon ditunggu ya ☕';
                    } else if (newStatus === 'selesai') {
                        title = 'Pesanan Siap Diambil';
                        message = 'Pesanan kamu sudah selesai. Silakan ambil di kasir / area pick-up.';
                    } else if (newStatus === 'batal') {
                        title = 'Pesanan Dibatalkan';
                        message = 'Pesanan kamu dibatalkan. Silakan hubungi kasir jika butuh bantuan.';
                    } else {
                        return; // pending tidak perlu popup
                    }

                    popupTitle.textContent = title;
                    popupMessage.textContent = message;
                    popup.classList.remove('hidden');
                }

                function closePopup() {
                    popup.classList.add('hidden');
                }

                popupOk?.addEventListener('click', closePopup);
                popup?.addEventListener('click', (e) => {
                    if (e.target === popup) closePopup();
                });

                // polling tiap 5 detik
                setInterval(() => {
                    fetch("{{ route('orders.statusJson', $order->id) }}")
                        .then(res => res.json())
                        .then(data => {
                            const newStatus = data.status;
                            if (!newStatus || newStatus === currentStatus) return;

                            currentStatus = newStatus;
                            applyStatusUI(newStatus);
                            showPopupForStatus(newStatus);
                        })
                        .catch(err => {
                            console.error('Gagal cek status order:', err);
                        });
                }, 5000);
            });
        </script>
    @endsection
