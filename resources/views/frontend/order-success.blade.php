{{-- resources/views/frontend/order-success.blade.php (DIPERBAIKI) --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pesanan • SeduhRasa Coffee</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
        use Carbon\Carbon;
        
        // Variabel $order dan $qrCodePath HARUS dikirim dari Controller
        // JANGAN buat query atau data dummy di sini!
        
        $isDigital = isset($order->metode_pembayaran) && $order->metode_pembayaran !== 'cod';
        
        // QR Code URL - gunakan default jika tidak ada
        $qrCodeUrl = isset($qrCodePath) && $qrCodePath 
            ? asset('storage/' . $qrCodePath) 
            : asset('default-qr.png');
    @endphp

    <style>
        body{
            margin:0;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background:#f5f3f0;
            color:#1f2933;
        }
        .page{
            min-height:100vh;
            display:flex;
            align-items:center;
            justify-content:center;
            padding:16px;
        }
        .card{
            width:100%;
            max-width:480px;
            background:#fff;
            border-radius:18px;
            box-shadow:0 20px 40px rgba(15,23,42,.12);
            overflow:hidden;
            border:1px solid #f3e8d5;
        }
        .card-header{
            background:linear-gradient(135deg,#f97316,#facc15);
            color:#fff;
            padding:18px 22px;
            text-align:center;
        }
        .card-header h1{
            margin:0;
            font-size:22px;
        }
        .card-header p{
            margin:4px 0 0;
            font-size:13px;
            opacity:.9;
        }
        .card-body{
            padding:18px 22px 20px;
        }
        .label{
            font-size:11px;
            text-transform:uppercase;
            letter-spacing:.08em;
            color:#9ca3af;
        }
        .order-id{
            font-size:20px;
            font-weight:700;
            margin-top:3px;
            margin-bottom: 14px;
        }
        
        .info-box p{
            margin:0;
        }
        .info-box .value{
            font-size:13px;
            font-weight:600;
            color:#111827;
            margin-top:2px;
        }

        .detail-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px; 
            margin-bottom: 16px; 
        }

        .items{
            margin-top:0;
            padding: 0; 
        }
        .items-title{
            font-size:11px;
            text-transform:uppercase;
            letter-spacing:.08em;
            color:#9ca3af;
            margin-bottom:4px;
        }
        .items-list p{
            margin:2px 0;
            font-size:13px;
        }
        .total-row{
            display:flex;
            justify-content:space-between;
            align-items:center;
            padding-top: 10px;
            margin-top: 10px; 
            border-top: 1px dashed #e5e7eb;
            font-size:16px; 
        }
        .total-row span:first-child {
            font-weight: 500;
        }
        .total-row span:last-child{
            font-weight:700;
            color:#1f2933; 
        }
        .footer-text{
            margin-top:12px;
            text-align:center;
            font-size:11px;
            color:#6b7280;
        }
        .footer-text small{
            display:block;
            margin-top:3px;
            font-size:10px;
            letter-spacing:.08em;
            text-transform:uppercase;
            color:#9ca3af;
        }
        .btn-wrap{
            margin-top:25px; 
            text-align:center;
        }
        .btn{
            display:inline-block;
            padding:12px 24px; 
            border-radius:999px;
            background:#f59e0b;
            color:#fff;
            font-size:16px; 
            font-weight:600;
            text-decoration:none;
            border: none;
            cursor: pointer;
            width: 80%; 
            max-width: 300px;
            transition: background 0.2s;
        }
        .btn:hover{
            background:#ea580c;
        }

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
        .pay-box-instruction {
            flex: 1;
        }
        .pay-box-title{
            font-weight:600;
            margin-bottom:4px;
        }
        .pay-box small{
            display:block;
            margin-top:8px; 
            font-size:11px;
            color:#b45309;
        }
        .pay-box img {
            width: 100px; 
            height: auto;
            display: block;
            border-radius: 4px;
        }

        @media(max-width:480px){
            .card{border-radius:14px;}
            .card-header{padding:14px 16px;}
            .card-body{padding:14px 16px 16px;}
            .pay-box {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }
            .pay-box img {
                width: 120px;
                margin-top: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="page">
        <div class="card">
            <div class="card-header">
                @if($isDigital)
                    <h1>Selesaikan Pembayaran</h1>
                    <p>Segera selesaikan pembayaran digital kamu agar pesanan bisa kami proses</p>
                @else
                    <h1>Pesanan Berhasil!</h1>
                    <p>Terima kasih telah memesan di SeduhRasa Coffee</p>
                @endif
            </div>

            <div class="card-body">
                {{-- Nomor pesanan --}}
                <div>
                    <div class="label">Nomor Pesanan</div>
                    <div class="order-id">#{{ $order->id }}</div>
                </div>

                {{-- Info utama --}}
                <div class="detail-grid">
                    <div class="info-box">
                        <p class="label">Nama Pelanggan</p>
                        <p class="value">{{ $order->nama_pelanggan ?? 'Pelanggan' }}</p>
                    </div>
                    <div class="info-box">
                        <p class="label">Waktu</p>
                        <p class="value">{{ Carbon::parse($order->created_at)->format('d M Y, H:i') }} WIB</p>
                    </div>
                    @if($order->no_meja)
                        <div class="info-box">
                            <p class="label">Nomor Meja</p>
                            <p class="value">{{ $order->no_meja }}</p>
                        </div>
                    @endif
                    <div class="info-box">
                        <p class="label">Pembayaran</p>
                        <p class="value">
                            @if($order->metode_pembayaran === 'cod')
                                Bayar di Tempat (Cash)
                            @else
                                Transfer / Dana
                            @endif
                        </p>
                    </div>
                </div>

                {{-- Detail pesanan --}}
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
                @if($isDigital)
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
                        <img src="{{ $qrCodeUrl }}" alt="QR Code Pembayaran">
                    </div>
                @endif

                {{-- Footer --}}
                <div class="footer-text">
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