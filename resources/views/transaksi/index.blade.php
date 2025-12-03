<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selesaikan Pembayaran</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            max-width: 450px;
            width: 100%;
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #FF6B35 0%, #F7B801 100%);
            padding: 30px;
            text-align: center;
            color: white;
        }

        .header h1 {
            font-size: 24px;
            margin-bottom: 8px;
        }

        .header p {
            font-size: 14px;
            opacity: 0.95;
        }

        .content {
            padding: 30px;
        }

        .info-section {
            margin-bottom: 25px;
        }

        .label {
            font-size: 11px;
            text-transform: uppercase;
            color: #999;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
        }

        .value {
            font-size: 16px;
            color: #333;
            font-weight: 600;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 25px;
        }

        .divider {
            border-top: 1px solid #eee;
            margin: 25px 0;
        }

        .order-details {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .order-item {
            font-size: 14px;
            color: #555;
            margin-bottom: 5px;
        }

        .total-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 18px;
            font-weight: 700;
            margin: 20px 0;
        }

        .total-amount {
            color: #FF6B35;
        }

        .payment-instructions {
            background: #FFF9E6;
            border: 2px solid #F7B801;
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
        }

        .instructions-title {
            font-weight: 700;
            color: #FF6B35;
            margin-bottom: 12px;
            font-size: 14px;
        }

        .instructions-list {
            list-style: none;
            padding: 0;
        }

        .instructions-list li {
            font-size: 13px;
            color: #555;
            margin-bottom: 8px;
            padding-left: 20px;
            position: relative;
            line-height: 1.5;
        }

        .instructions-list li:before {
            content: counter(item) ".";
            counter-increment: item;
            position: absolute;
            left: 0;
            font-weight: 600;
            color: #FF6B35;
        }

        .instructions-list {
            counter-reset: item;
        }

        .note {
            font-size: 12px;
            color: #777;
            font-style: italic;
            margin-top: 10px;
        }

        .footer-note {
            text-align: center;
            font-size: 12px;
            color: #999;
            margin: 20px 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-back {
            background: linear-gradient(135deg, #FF6B35 0%, #F7B801 100%);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 25px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .btn-back:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(255, 107, 53, 0.3);
        }

        .qr-code-section {
            text-align: center;
            margin: 25px 0;
            padding: 20px;
            background: white;
            border: 2px dashed #FF6B35;
            border-radius: 10px;
        }

        .qr-placeholder {
            width: 200px;
            height: 200px;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            margin: 0 auto 15px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            color: #999;
            border: 2px solid #dee2e6;
        }

        .qr-text {
            font-size: 13px;
            color: #666;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Selesaikan Pembayaran</h1>
            <p>Segera selesaikan pembayaran digital kamu agar pesanan bisa kami proses</p>
        </div>

        <div class="content">
            <div class="info-section">
                <div class="label">Nomor Pesanan</div>
                <div class="value">#7</div>
            </div>

            <div class="info-grid">
                <div class="info-section">
                    <div class="label">Nama Pelanggan</div>
                    <div class="value">Mazira</div>
                </div>
                <div class="info-section">
                    <div class="label">Waktu</div>
                    <div class="value">03 Dec 2025, 14:32 WIB</div>
                </div>
            </div>

            <div class="info-grid">
                <div class="info-section">
                    <div class="label">Nomor Meja</div>
                    <div class="value">4</div>
                </div>
                <div class="info-section">
                    <div class="label">Pembayaran</div>
                    <div class="value">QRIS</div>
                </div>
            </div>
            <div class="qr-code-container">
    {{-- Ganti SVG dengan foto QR code real --}}
    <img src="{{ asset('images/qr-code-sederhana-coffee.png') }}" 
         alt="QR Code QRIS" 
         class="img-fluid"
         style="max-width: 220px; height: auto;">
    
    <p class="qr-instruction mt-3">
        <strong>Scan kode QR</strong><br>
        dengan aplikasi e-wallet atau mobile banking
    </p>
</div>
            <div class="divider"></div>

            <div class="info-section">
                <div class="label">Detail Pesanan</div>
                <div class="order-details">
                    <div class="order-item">• Mie Carbonara x1</div>
                </div>
            </div>

            <div class="total-section">
                <span>Total Pembayaran</span>
                <span class="total-amount">Rp 19.000</span>
            </div>

            <div class="qr-code-section">
                <div class="qr-placeholder">
                    <div>
                        <svg width="150" height="150" viewBox="0 0 150 150" fill="none">
                            <rect x="10" y="10" width="30" height="30" fill="#333"/>
                            <rect x="50" y="10" width="10" height="10" fill="#333"/>
                            <rect x="70" y="10" width="10" height="10" fill="#333"/>
                            <rect x="90" y="10" width="10" height="10" fill="#333"/>
                            <rect x="110" y="10" width="30" height="30" fill="#333"/>
                            <rect x="18" y="18" width="14" height="14" fill="#fff"/>
                            <rect x="118" y="18" width="14" height="14" fill="#fff"/>
                            <rect x="10" y="50" width="10" height="10" fill="#333"/>
                            <rect x="30" y="50" width="10" height="10" fill="#333"/>
                            <rect x="50" y="50" width="10" height="10" fill="#333"/>
                            <rect x="70" y="50" width="30" height="30" fill="#333"/>
                            <rect x="110" y="50" width="10" height="10" fill="#333"/>
                            <rect x="130" y="50" width="10" height="10" fill="#333"/>
                            <rect x="78" y="58" width="14" height="14" fill="#fff"/>
                            <rect x="10" y="70" width="10" height="10" fill="#333"/>
                            <rect x="30" y="70" width="10" height="10" fill="#333"/>
                            <rect x="110" y="70" width="10" height="10" fill="#333"/>
                            <rect x="130" y="70" width="10" height="10" fill="#333"/>
                            <rect x="10" y="90" width="10" height="10" fill="#333"/>
                            <rect x="50" y="90" width="10" height="10" fill="#333"/>
                            <rect x="90" y="90" width="10" height="10" fill="#333"/>
                            <rect x="130" y="90" width="10" height="10" fill="#333"/>
                            <rect x="10" y="110" width="30" height="30" fill="#333"/>
                            <rect x="50" y="110" width="10" height="10" fill="#333"/>
                            <rect x="70" y="110" width="10" height="10" fill="#333"/>
                            <rect x="90" y="110" width="10" height="10" fill="#333"/>
                            <rect x="110" y="110" width="10" height="10" fill="#333"/>
                            <rect x="130" y="110" width="10" height="10" fill="#333"/>
                            <rect x="18" y="118" width="14" height="14" fill="#fff"/>
                            <rect x="50" y="130" width="10" height="10" fill="#333"/>
                            <rect x="90" y="130" width="10" height="10" fill="#333"/>
                        </svg>
                    </div>
                </div>
                <div class="qr-text">
                    <strong>Scan kode QR di atas</strong><br>
                    dengan aplikasi e-wallet atau mobile banking Anda
                </div>
            </div>

            <div class="payment-instructions">
                <div class="instructions-title">Langkah Pembayaran</div>
                <ol class="instructions-list">
                    <li>Buka aplikasi e-wallet atau mobile banking kamu (Dana, GoPay, OVO, ShopeePay, dll)</li>
                    <li>Pilih menu "Scan QR" atau "QRIS"</li>
                    <li>Arahkan kamera ke kode QR di atas</li>
                    <li>Periksa detail pembayaran dan nominal</li>
                    <li>Konfirmasi pembayaran dengan PIN atau sidik jari</li>
                    <li>Simpan bukti transaksi sebagai konfirmasi</li>
                </ol>
                <div class="note">Setelah pembayaran berhasil, pesananmu akan diproses oleh kasir.</div>
            </div>

            <div class="footer-note">
                Terima kasih sudah berbelanja di Sederhana Coffee
            </div>

            <button class="btn-back" onclick="window.history.back()">Kembali ke Menu</button>
        </div>
    </div>
</body>
</html>