{{-- resources/views/frontend/order-success.blade.php (FINAL - STATUS REALTIME, TANPA QR) --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pesanan • SeduhRasa Coffee</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
        use Carbon\Carbon;

        // Status order: pending / proses / selesai (fallback aman)
        $status = $order->status ?? 'pending';

        // Tema warna
        $color_primary   = '#4B2C20';
        $color_accent    = '#8B6F47';
        $color_light_bg  = '#F5EFE6';
        $color_btn_bg    = '#7B3F00';
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
            max-width:520px;
            background:#fff;
            border-radius:18px;
            box-shadow:0 20px 40px rgba(15,23,42,.12);
            overflow:hidden;
            border:1px solid {{ $color_light_bg }};
        }
        .card-header{
            background:linear-gradient(135deg, {{ $color_btn_bg }}, {{ $color_accent }});
            color:#fff;
            padding:18px 22px;
            text-align:center;
        }
        .card-header h1{
            margin:0;
            font-size:22px;
        }
        .card-header p{
            margin:6px 0 0;
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
            margin-bottom: 10px;
        }

        .status-row{
            display:flex;
            gap:10px;
            align-items:center;
            justify-content:space-between;
            background:#faf7f2;
            border:1px solid rgba(139,111,71,.25);
            border-radius:12px;
            padding:10px 12px;
            margin: 10px 0 16px;
        }
        .status-left{
            display:flex;
            flex-direction:column;
            gap:3px;
        }
        .badge{
            display:inline-flex;
            align-items:center;
            gap:8px;
            padding:8px 12px;
            border-radius:999px;
            font-weight:700;
            font-size:12px;
            letter-spacing:.02em;
            border:1px solid transparent;
            white-space:nowrap;
        }
        .dot{
            width:8px; height:8px; border-radius:999px; background:#999;
        }
        .badge.pending{ background:#fff7ed; color:#9a3412; border-color:#fed7aa; }
        .badge.proses{  background:#eff6ff; color:#1d4ed8; border-color:#bfdbfe; }
        .badge.selesai{ background:#ecfdf5; color:#047857; border-color:#a7f3d0; }

        .hint{
            font-size:12px;
            color:#6b7280;
            margin:0;
        }

        .detail-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin-bottom: 16px;
        }
        .info-box p{ margin:0; }
        .info-box .value{
            font-size:13px;
            font-weight:600;
            color:#111827;
            margin-top:2px;
        }

        .items-title{
            font-size:11px;
            text-transform:uppercase;
            letter-spacing:.08em;
            color:#9ca3af;
            margin-bottom:6px;
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
        .total-row span:last-child{
            font-weight:800;
            color:{{ $color_primary }};
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
            margin-top:22px;
            text-align:center;
        }
        .btn{
            display:inline-block;
            padding:12px 24px;
            border-radius:999px;
            background:{{ $color_btn_bg }};
            color:#fff;
            font-size:16px;
            font-weight:700;
            text-decoration:none;
            width: 80%;
            max-width: 320px;
            transition: background 0.2s;
        }
        .btn:hover{
            background:{{ $color_accent }};
        }

        @media(max-width:480px){
            .card{border-radius:14px;}
            .card-header{padding:14px 16px;}
            .card-body{padding:14px 16px 16px;}
            .detail-grid{ grid-template-columns: 1fr; }
            .status-row{ flex-direction:column; align-items:flex-start; }
            .badge{ width:100%; justify-content:center; }
        }
    </style>
</head>
<body>
    <div class="page">
        <div class="card">

            <div class="card-header">
                <h1>Pesanan Berhasil!</h1>
                <p>Terima kasih telah memesan di SeduhRasa Coffee</p>
            </div>

            <div class="card-body">

                {{-- Nomor pesanan --}}
                <div>
                    <div class="label">Nomor Pesanan</div>
                    <div class="order-id">#{{ $order->id }}</div>
                </div>

                {{-- STATUS (REALTIME) --}}
                <div class="status-row">
                    <div class="status-left">
                        <div class="label">Status Pesanan</div>
                        <p id="statusText" class="hint">Sedang memuat status...</p>
                    </div>

                    <div id="statusBadge" class="badge pending">
                        <span class="dot" id="statusDot"></span>
                        <span id="statusBadgeText">PENDING</span>
                    </div>
                </div>

                {{-- Info utama --}}
                <div class="detail-grid">
                    <div class="info-box">
                        <p class="label">Nama Pelanggan</p>
                        <p class="value">{{ $order->customer_name ?? 'Pelanggan' }}</p>
                    </div>
                    <div class="info-box">
                        <p class="label">Waktu</p>
                        <p class="value">{{ Carbon::parse($order->created_at)->format('d M Y, H:i') }} WIB</p>
                    </div>

                    @if(!empty($order->no_meja))
                        <div class="info-box">
                            <p class="label">Nomor Meja</p>
                            <p class="value">{{ $order->no_meja }}</p>
                        </div>
                    @endif

                    <div class="info-box">
                        <p class="label">Pembayaran</p>
                        <p class="value">
                            @if(($order->metode_pembayaran ?? 'cod') === 'cod')
                                Bayar di Tempat (Cash)
                            @else
                                Non-Tunai
                            @endif
                        </p>
                    </div>
                </div>

                {{-- Detail pesanan --}}
                <div class="items">
                    <div class="items-title">Detail Pesanan</div>

                    <div class="items-list">
                        @php
                            $detail = $order->keterangan ?? '';
                            $items = $detail ? explode(', ', $detail) : [];
                        @endphp

                        @if(count($items) > 0)
                            @foreach($items as $item)
                                @if(trim($item) !== '')
                                    <p>• {{ trim($item) }}</p>
                                @endif
                            @endforeach
                        @else
                            <p style="color:#6b7280;">(Detail pesanan tidak tersedia)</p>
                        @endif
                    </div>

                    <div class="total-row">
                        <span>Total Pembayaran</span>
                        <span>Rp {{ number_format((int)($order->subtotal ?? 0), 0, ',', '.') }}</span>
                    </div>
                </div>

                {{-- Footer --}}
                <div class="footer-text">
                    <p>
                        Halaman ini akan otomatis berubah kalau status pesanan sudah
                        <b>Diproses</b> atau <b>Selesai</b>.
                    </p>
                    <small>Terima kasih sudah berbelanja di SeduhRasa Coffee</small>
                </div>

                {{-- Tombol --}}
                <div class="btn-wrap">
                    <a href="{{ route('menu') }}" class="btn">Kembali ke Menu</a>
                </div>

            </div>
        </div>
    </div>

<script>
(function(){
    const badge      = document.getElementById('statusBadge');
    const badgeText  = document.getElementById('statusBadgeText');
    const statusText = document.getElementById('statusText');
    const dot        = document.getElementById('statusDot');

    const url = "{{ route('customer.orders.status', $order->id) }}";

    function renderStatus(statusRaw){
        const s = (statusRaw || 'pending').toString().toLowerCase();

        // reset class
        badge.classList.remove('pending','proses','selesai');

        if (s === 'selesai') {
            badge.classList.add('selesai');
            badgeText.textContent = 'SELESAI';
            dot.style.background = '#10b981';
            statusText.textContent = 'Pesanan kamu sudah selesai ✅';
            return;
        }

        if (s === 'proses' || s === 'diproses' || s === 'process') {
            badge.classList.add('proses');
            badgeText.textContent = 'DIPROSES';
            dot.style.background = '#3b82f6';
            statusText.textContent = 'Pesanan kamu sedang diproses ☕ Tunggu sebentar ya.';
            return;
        }

        // default pending
        badge.classList.add('pending');
        badgeText.textContent = 'PENDING';
        dot.style.background = '#f97316';
        statusText.textContent = 'Pesanan kamu sudah masuk. Menunggu kasir mengonfirmasi.';
    }

    async function fetchStatus(){
        try{
            const res = await fetch(url, { headers: { 'Accept': 'application/json' } });
            if(!res.ok) throw new Error('HTTP ' + res.status);
            const data = await res.json();
            renderStatus(data.status);
        }catch(e){
            // kalau gagal, jangan bikin blank
            statusText.textContent = 'Gagal memuat status (cek koneksi). Akan coba lagi...';
        }
    }

    // pertama kali
    fetchStatus();

    // polling tiap 3 detik
    setInterval(fetchStatus, 3000);
})();
</script>

</body>
</html>
