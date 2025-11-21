@extends('layouts.app')

@section('title', 'Detail Order #' . $order->id)

@section('content')
    <style>
        .order-detail-bg {
            background: radial-gradient(circle at top left, rgba(255, 193, 7, .05), transparent 55%);
        }

        /* animasi notif (dipakai di layar, ga kepake di print) */
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

            /* warna hitam putih + font kecil */
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

            #print-area .text-2xl,
            #print-area .text-xl {
                font-size: 12px !important;
            }

            #print-area .text-lg {
                font-size: 11px !important;
            }

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
                <div id="print-area" class="bg-white rounded-2xl shadow-xl overflow-hidden max-w-sm mx-auto">

                    {{-- HEADER TOKO + LOGO --}}
                    <div class="p-4 text-center flex flex-col items-center gap-1">
                        {{-- LOGO BULAT ALA-ALA STARBUCKS --}}
                        <svg viewBox="0 0 120 120" class="w-16 h-16 mb-1">
                            <!-- Outer circle -->
                            <circle cx="60" cy="60" r="58" fill="#14532d" />
                            <!-- Middle circle -->
                            <circle cx="60" cy="60" r="48" fill="#f9fafb" />
                            <!-- Inner circle background -->
                            <circle cx="60" cy="60" r="32" fill="#14532d" />

                            <!-- Coffee cup -->
                            <rect x="45" y="48" width="30" height="22" rx="4" ry="4" fill="#f9fafb" />
                            <!-- Cup handle -->
                            <path d="M76 51
                                     Q84 55 76 59
                                     Z" fill="#f9fafb" />
                            <!-- Coffee surface -->
                            <rect x="48" y="50" width="24" height="4" fill="#e5e7eb" />

                            <!-- Steam -->
                            <path d="M52 44
                                     C50 40, 54 38, 52 34"
                                  stroke="#f9fafb" stroke-width="2" fill="none" stroke-linecap="round" />
                            <path d="M60 44
                                     C58 40, 62 38, 60 34"
                                  stroke="#f9fafb" stroke-width="2" fill="none" stroke-linecap="round" />
                            <path d="M68 44
                                     C66 40, 70 38, 68 34"
                                  stroke="#f9fafb" stroke-width="2" fill="none" stroke-linecap="round" />

                            <!-- Small dots -->
                            <circle cx="35" cy="60" r="2" fill="#14532d" />
                            <circle cx="85" cy="60" r="2" fill="#14532d" />
                            <circle cx="60" cy="35" r="2" fill="#14532d" />
                            <circle cx="60" cy="85" r="2" fill="#14532d" />
                        </svg>

                        <div class="text-xs font-semibold tracking-[0.15em] uppercase">
                            SeduhRasa Coffee
                        </div>
                        <div class="text-[10px] leading-tight mt-1">
                            Jl. Mawar No. 15, Bengkalis<br>
                            Telp: (021) 1234-5678
                        </div>
                    </div>

                    <div class="border-t border-dashed border-gray-300 my-2"></div>

                    {{-- INFO WAKTU, NOMOR, DLL --}}
                    <div class="px-4 text-xs space-y-1">
                        <div class="flex justify-between">
                            <span>{{ $order->created_at->format('Y-m-d') }}</span>
                            <span>{{ $order->created_at->format('H:i:s') }} WIB</span>
                        </div>

                        {{-- contoh "No.0-003" --}}
                        <div>No. {{ '0-' . str_pad($order->id, 3, '0', STR_PAD_LEFT) }}</div>

                        <div>Pelanggan : {{ $order->nama_pelanggan ?: 'Umum' }}</div>

                        @if ($order->no_meja)
                            <div>Meja : {{ $order->no_meja }}</div>
                        @endif

                        <div>Metode : {{ $order->metode_pembayaran == 'cod' ? 'Cash' : 'Non Tunai' }}</div>

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

                        <div class="flex items-center justify-between pt-1">
                            <span>Status :</span>
                            <span id="status-badge"
                                  class="inline-flex items-center {{ $config['bg'] }} {{ $config['text'] }} px-3 py-1 rounded-full text-[10px] font-semibold">
                                <span id="status-dot" class="w-2 h-2 rounded-full {{ $config['dot'] }} mr-1"></span>
                                <span id="status-badge-text">{{ $config['label'] }}</span>
                            </span>
                        </div>
                    </div>

                    <div class="border-t border-dashed border-gray-300 my-2"></div>

                    {{-- LIST MENU --}}
                    <div class="px-4 text-xs space-y-1">
                        @foreach (explode(', ', $order->menu_dipesan) as $index => $item)
                            <div class="flex justify-between">
                                <span>{{ $index + 1 }}. {{ $item }}</span>
                                {{-- harga per item belum disimpan, jadi cuma nama + qty --}}
                            </div>
                        @endforeach

                        <div class="mt-2 flex justify-between">
                            <span>Total QTY :</span>
                            <span>{{ $order->jumlah }}</span>
                        </div>
                    </div>

                    <div class="border-t border-dashed border-gray-800 my-2"></div>

                    {{-- TOTAL PEMBAYARAN --}}
                    <div class="px-4 text-xs space-y-1">
                        <div class="flex justify-between">
                            <span>Sub Total</span>
                            <span>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                        </div>

                        <div class="flex justify-between font-bold">
                            <span>Total</span>
                            <span>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                        </div>

                        {{-- sementara: bayar = total, kembali = 0 --}}
                        <div class="flex justify-between">
                            <span>Bayar ({{ strtoupper($order->metode_pembayaran) }})</span>
                            <span>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                        </div>

                        <div class="flex justify-between">
                            <span>Kembali</span>
                            <span>Rp 0</span>
                        </div>
                    </div>

                    <div class="border-t border-dashed border-gray-300 my-3"></div>

                    {{-- FOOTER TERIMA KASIH DI STRUK --}}
                    <div class="px-4 pb-4 text-center text-[10px] leading-tight">
                        <div>Terimakasih Telah Berbelanja</div>
                        <div class="mt-1">
                            Struk ini dicetak oleh kasir sebagai bukti transaksi.
                        </div>
                        <div class="mt-1 tracking-wide uppercase text-[9px]">
                            Simpan struk ini dan tunjukkan bila diperlukan.
                        </div>
                    </div>

                    {{-- ====================== --}}
                    {{-- BAGIAN UNTUK LAYAR SAJA (NO PRINT) --}}
                    {{-- ====================== --}}

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
                                        Pesanan Anda sedang menunggu konfirmasi dari admin. Kami akan segera memproses
                                        pesanan Anda.
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

                    {{-- Tombol Aksi (no-print) --}}
                    <div class="flex flex-col sm:flex-row gap-4 no-print px-4 pb-6">
                        <a href="{{ url('/') }}"
                           class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold py-3 px-6 rounded-lg text-center transition-all duration-200 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Kembali ke Menu
                        </a>
                        <button onclick="window.print()"
                                class="flex-1 bg-gradient-to-r from-orange-500 to-yellow-500 hover:from-orange-600 hover:to-yellow-600 text-white font-semibold py-3 px-6 rounded-lg text-center transition-all duration-200 flex items-center justify-center gap-2 shadow-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                                </path>
                            </svg>
                            Cetak Struk
                        </button>
                    </div>

                    {{-- Footer Note (no-print) --}}
                    <div class="text-center mb-4 text-gray-600 text-sm no-print px-4">
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
                            'inline-flex items-center px-3 py-1 rounded-full text-[10px] font-semibold ' + bgClass + ' ' +
                            textClass;
                    }
                    if (statusBadgeText) {
                        statusBadgeText.textContent = labelText;
                    }
                    if (statusDot) {
                        statusDot.className = 'w-2 h-2 rounded-full mr-1 ' + dotClass;
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
