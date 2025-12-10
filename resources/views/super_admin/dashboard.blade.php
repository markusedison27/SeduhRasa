{{-- resources/views/frontend/order-success.blade.php (FINAL FIX) --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pesanan • SeduhRasa Coffee</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
        use Carbon\Carbon;
        
        // Variabel $order dan $qrCodePath HARUS dikirim dari Controller (yang mengurus order pelanggan)
        
        $isDigital = isset($order->metode_pembayaran) && $order->metode_pembayaran !== 'cod';
        
        // QR Code URL: Menggunakan jalur dari database/storage (Sesuai dengan cara upload di OwnerController)
        // Jika $qrCodePath ada, gunakan asset('storage/...')
        $qrCodeUrl = ($qrCodePath) 
            ? asset('storage/' . $qrCodePath) 
            : null; // Jika null, gambar tidak akan ditampilkan
        
    @endphp

    <style>
        /* ... (CSS ASLI ANDA SAMA) ... */
        /* ... (Saya menghapus CSS duplikat di sini untuk kemudahan membaca) ... */

        .pay-box{
            margin-top:20px; 
            padding:16px 12px; 
            border-radius:10px;
            background:#fffbeb;
            border:1px solid #facc15;
            font-size:12px;
            color:#92400e;
            display: flex;
            gap: 20px; 
            align-items: flex-start;
        }
        /* ... (CSS ASLI ANDA SAMA) ... */
    </style>
</head>
<body>
    <div class="page">
        <div class="card">
            <div class="card-header">
                {{-- ... (KODE ASLI) ... --}}
                @if($isDigital)
                    <h1>Selesaikan Pembayaran</h1>
                    <p>Segera selesaikan pembayaran digital kamu agar pesanan bisa kami proses</p>
                @else
                    <h1>Pesanan Berhasil!</h1>
                    <p>Terima kasih telah memesan di SeduhRasa Coffee</p>
                @endif
            </div>

            <div class="card-body">
                {{-- ... (KODE ASLI INFORMASI ORDER) ... --}}
                <div class="items">
                    <div class="items-title">Detail Pesanan</div>
                    <div class="items-list">
                        @foreach(explode(', ', $order->menu_dipesan) as $item)
                            <p>• {{ trim($item) }}</p>
                        @endforeach
                    </div>
                    <div class="total-row">
                        <span>Total Pembayaran</span>
                        <span>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                    </div>
                </div>

                {{-- Instruksi pembayaran digital --}}
                @if($isDigital && $qrCodeUrl) {{-- TAMBAH PENGECUALIAN JIKA QR CODE TIDAK ADA --}}
                    <div class="pay-box">
                        <div class="pay-box-instruction">
                            <div class="pay-box-title">Langkah Pembayaran</div>
                            <ol style="margin:0; padding-left:18px;">
                                <li>Buka aplikasi Dana / e-wallet yang kamu gunakan.</li>
                                <li>Scan QR atau transfer ke nomor Dana kasir.</li>
                                <li>Masukkan nominal sesuai Total Pembayaran.</li>
                                <li>Simpan bukti transfer dan tunjukkan ke kasir.</li>
                            </ol>
                            <small>Setelah transfer, pesananmu akan diproses oleh kasir.</small>
                        </div>
                        {{-- MENGGUNAKAN QR CODE DARI PATH DATABASE --}}
                        <img src="{{ $qrCodeUrl }}" alt="QR Code Pembayaran">
                    </div>
                @elseif($isDigital && !$qrCodeUrl)
                    <div class="pay-box" style="background: #fefcbf; border-color: #fbd38d; color: #827e02;">
                        <div class="pay-box-instruction">
                            <div class="pay-box-title">Langkah Pembayaran</div>
                            <p style="margin: 0;">QR Code pembayaran belum tersedia. Silakan hubungi kasir untuk mendapatkan informasi transfer.</p>
                        </div>
                    </div>
                @endif

                {{-- Footer --}}
                <div class="footer-text">
                    {{-- ... (KODE ASLI FOOTER) ... --}}
                    @if($isDigital)
                        <p>Setelah transfer, tunjukkan halaman ini dan bukti pembayaran kepada kasir untuk konfirmasi.</p>
                    @else
                        <p>Silakan tunjukkan halaman ini kepada kasir saat melakukan pembayaran.</p>
                    @endif
                    <small>Terima kasih sudah berbelanja di SeduhRasa Coffee</small>
                </div>

                {{-- Tombol --}}
                <div class="btn-wrap">
                    <a href="{{ route('menu') }}" class="btn">Kembali ke Menu</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>