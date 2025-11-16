{{-- resources/views/orders/show.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Pesanan • SeduhRasa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        :root{
            --cream:#f6efe9;
            --latte:#d7c0ae;
            --latte-ink:#8d6f5b;
            --espresso:#3b2f2f;
            --mocha:#4b3a32;
            --card:#ffffff;
        }
        *{box-sizing:border-box;margin:0;padding:0}
        body{
            font-family: system-ui,-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif;
            background:
                radial-gradient(70rem 70rem at -10% -20%, rgba(0,0,0,.06), transparent 60%),
                radial-gradient(70rem 70rem at 110% 10%, rgba(0,0,0,.05), transparent 55%),
                linear-gradient(180deg, var(--cream), #fff);
            min-height:100vh;
            color:#1f2933;
            display:flex;
            align-items:center;
            justify-content:center;
            padding:1.5rem;
        }
        .card{
            width:100%;
            max-width:720px;
            background:var(--card);
            border-radius:24px;
            box-shadow:0 18px 45px rgba(15,23,42,.15);
            border:1px solid rgba(0,0,0,.06);
            padding:2rem 2.25rem;
        }
        .badge{
            display:inline-flex;
            align-items:center;
            gap:.4rem;
            font-size:.75rem;
            padding:.25rem .75rem;
            border-radius:999px;
            font-weight:500;
        }
        .badge-pending{
            background:#FEF3C7;
            color:#92400E;
        }
        .badge-selesai{
            background:#DCFCE7;
            color:#166534;
        }
        .badge-batal{
            background:#FEE2E2;
            color:#B91C1C;
        }
        .title{
            font-family: "Playfair Display", ui-serif, Georgia, "Times New Roman", serif;
            font-size:1.9rem;
            letter-spacing:.04em;
        }
        .subtitle{
            font-size:.9rem;
            color:var(--latte-ink);
            margin-top:.35rem;
        }
        .divider{
            border:0;
            border-top:1px dashed rgba(148,163,184,.6);
            margin:1.5rem 0;
        }
        .row{
            display:flex;
            justify-content:space-between;
            gap:1rem;
            font-size:.92rem;
            margin-bottom:.4rem;
        }
        .label{color:#6b7280}
        .value{font-weight:500}
        .items{
            margin-top:.75rem;
            font-size:.92rem;
        }
        .items ul{
            margin-top:.35rem;
            padding-left:1.1rem;
        }
        .items li{
            margin-bottom:.15rem;
        }
        .total-row{
            display:flex;
            justify-content:space-between;
            margin-top:1rem;
            padding-top:.8rem;
            border-top:1px solid rgba(148,163,184,.4);
            font-weight:600;
        }
        .muted{
            font-size:.8rem;
            color:#9CA3AF;
            margin-top:1.25rem;
        }
        .actions{
            margin-top:1.75rem;
            display:flex;
            gap:.75rem;
            flex-wrap:wrap;
        }
        .btn{
            border-radius:999px;
            padding:.65rem 1.4rem;
            font-size:.9rem;
            font-weight:500;
            border:1px solid transparent;
            cursor:pointer;
            display:inline-flex;
            align-items:center;
            gap:.4rem;
            text-decoration:none;
        }
        .btn-primary{
            background:linear-gradient(135deg,var(--espresso),var(--mocha));
            color:#fff;
        }
        .btn-primary:hover{opacity:.96;}
        .btn-ghost{
            background:#F9FAFB;
            border-color:#E5E7EB;
            color:#374151;
        }
        .btn-ghost:hover{
            background:#E5E7EB;
        }
        @media (max-width:640px){
            .card{padding:1.5rem 1.3rem;border-radius:20px;}
            .title{font-size:1.5rem;}
        }
    </style>
</head>
<body>
@php
    // pecah menu_dipesan string "A x1, B x2" jadi list
    $items = array_filter(array_map('trim', explode(',', $order->menu_dipesan)));
    $status = strtolower($order->status ?? 'pending');
    $metode = strtolower($order->metode_pembayaran ?? 'cod');
@endphp

<div class="card">
    <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:1rem;">
        <div>
            <h1 class="title">Detail Pesanan</h1>
            <p class="subtitle">Terima kasih, pesananmu sudah kami terima di SeduhRasa.</p>
        </div>

        {{-- Badge status --}}
        <div>
            @if($status === 'selesai')
                <span class="badge badge-selesai">● Selesai</span>
            @elseif($status === 'batal')
                <span class="badge badge-batal">● Dibatalkan</span>
            @else
                <span class="badge badge-pending">● Menunggu diproses</span>
            @endif
        </div>
    </div>

    @if(session('success'))
        <p style="color:#15803D;font-size:.9rem;margin-top:.9rem;">
            {{ session('success') }}
        </p>
    @endif

    <hr class="divider">

    <div class="row">
        <span class="label">Nama Pelanggan</span>
        <span class="value">{{ $order->nama_pelanggan ?? 'Umum' }}</span>
    </div>

    <div class="row">
        <span class="label">Waktu Pesan</span>
        <span class="value">{{ $order->created_at?->format('d M Y • H:i') }}</span>
    </div>

    <div class="row">
        <span class="label">Total Item</span>
        <span class="value">{{ $order->jumlah }}</span>
    </div>

    {{-- METODE PEMBAYARAN --}}
    <div class="row">
        <span class="label">Metode Pembayaran</span>
        <span class="value">
            @if($metode === 'transfer')
                Transfer Bank / Virtual Account
            @else
                Bayar di Tempat (kasir)
            @endif
        </span>
    </div>

    <div class="items">
        <div class="label">Rincian Menu</div>
        <ul>
            @foreach($items as $it)
                <li>{{ $it }}</li>
            @endforeach
        </ul>
    </div>

    <div class="total-row">
        <span>Total Harga</span>
        <span>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
    </div>

    <p class="muted">
        Tunjukkan halaman ini ke kasir bila diperlukan.  
        Pesanan akan diproses setelah dikonfirmasi oleh kasir.
    </p>

    <div class="actions">
        <a href="{{ route('order') }}" class="btn btn-primary">
            ← Kembali ke Menu
        </a>

        @auth
            <a href="{{ route('admin.orders.index') }}" class="btn btn-ghost">
                Lihat Antrian Pesanan
            </a>
        @endauth
    </div>
</div>
</body>
</html>
