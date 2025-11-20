{{-- resources/views/dashboard.blade.php --}}
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Kedai Kopi • SeduhRasa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <p style="margin-top: 4px; font-size: 14px; color:#6b7280;">
        Pesanan yang belum diproses:
        <strong style="color:#b45309;">{{ $pendingCount }} order</strong>
    </p>

    {{-- kalau di layout lain kamu pakai Vite/Tailwind, boleh aktifkan ini --}}
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}

    <style>
        :root {
            --bg: #f5f3f0;
            --card: #ffffff;
            --accent: #fbbf24;
            --accent-soft: #fef3c7;
            --green: #16a34a;
            --red: #ef4444;
            --text: #111827;
            --muted: #6b7280;
            --border: #e5e7eb;
            --espresso: #3b2f2f;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0
        }

        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
        }

        .sidebar {
            width: 230px;
            background: #fff;
            border-right: 1px solid var(--border);
            padding: 1.5rem 1.25rem;
            display: flex;
            flex-direction: column;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: .6rem;
            margin-bottom: 1.75rem;
        }

        .brand-logo {
            width: 34px;
            height: 34px;
            border-radius: 999px;
            background: #f97316;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: .95rem;
        }

        .nav-title {
            font-size: .75rem;
            text-transform: uppercase;
            color: var(--muted);
            letter-spacing: .08em;
            margin: .9rem 0 .3rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: .6rem;
            padding: .55rem .75rem;
            border-radius: 999px;
            font-size: .9rem;
            color: var(--muted);
            text-decoration: none;
            margin-bottom: .1rem;
        }

        .nav-link.active {
            background: #fef3c7;
            color: var(--espresso);
            font-weight: 600;
        }

        .nav-link span.icon {
            width: 16px;
            height: 16px;
            border-radius: 4px;
            border: 1px solid #facc15;
        }

        .main {
            flex: 1;
            padding: 1.5rem 2rem 2.25rem;
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .main-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 1rem;
        }

        .card {
            background: var(--card);
            border-radius: 18px;
            padding: 1.2rem 1.4rem;
            box-shadow: 0 10px 25px rgba(15, 23, 42, .08);
            border: 1px solid rgba(0, 0, 0, .02);
        }

        .card-label {
            font-size: .78rem;
            font-weight: 600;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: .08em;
        }

        .card-value {
            font-size: 1.7rem;
            margin: .3rem 0;
        }

        .card-note {
            font-size: .78rem;
            color: var(--muted);
        }

        .card-value.red {
            color: var(--red);
        }

        .table-card {
            background: var(--card);
            border-radius: 18px;
            padding: 1.5rem 1.4rem;
            box-shadow: 0 10px 25px rgba(15, 23, 42, .06);
            border: 1px solid rgba(0, 0, 0, .02);
        }

        .table-head {
            display: flex;
            justify-content: space-between;
            margin-bottom: .8rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: .86rem;
        }

        th,
        td {
            padding: .55rem .4rem;
            text-align: left;
            border-bottom: 1px solid var(--border);
        }

        th {
            font-size: .75rem;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: var(--muted);
        }

        .badge-type {
            display: inline-flex;
            padding: .15rem .6rem;
            border-radius: 999px;
            font-size: .75rem;
        }

        .badge-penjualan {
            background: #dcfce7;
            color: #166534;
        }

        .badge-pengeluaran {
            background: #fee2e2;
            color: #b91c1c;
        }

        .amount-green {
            color: var(--green);
            font-weight: 600;
        }

        .amount-red {
            color: var(--red);
            font-weight: 600;
        }

        .status-pill {
            display: inline-flex;
            padding: .1rem .55rem;
            border-radius: 999px;
            font-size: .75rem;
        }

        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .status-selesai {
            background: #dcfce7;
            color: #166534;
        }

        .status-batal {
            background: #fee2e2;
            color: #b91c1c;
        }

        .logout-btn {
            margin-top: auto;
            padding: .5rem .75rem;
            border-radius: 999px;
            border: 1px solid #fecaca;
            color: #b91c1c;
            background: #fef2f2;
            text-align: center;
            font-size: .9rem;
            text-decoration: none;
        }

        @media(max-width:960px) {
            body {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                flex-direction: row;
                align-items: center;
                justify-content: space-between;
            }

            .main {
                padding: 1rem;
            }

            .cards {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    {{-- SIDEBAR --}}
    <aside class="sidebar">
        <div>
            <div class="brand">
                <div class="brand-logo">SR</div>
                <div>
                    <div style="font-weight:700;font-size:.95rem;">SeduhRasa</div>
                    <div style="font-size:.78rem;color:var(--muted);">Panel Kasir</div>
                </div>
            </div>

            <div>
                <div class="nav-title">Navigasi</div>
                <a href="{{ route('staff.dashboard') }}" class="nav-link active">
                    <span class="icon"></span>
                    <span>Dashboard</span>
                </a>
            </div>

            <div>
                <div class="nav-title">Manajemen Data</div>
                <a href="{{ route('admin.menus.index') }}" class="nav-link">
                    <span class="icon"></span>
                    <span>Menu</span>
                </a>
                <a href="{{ route('admin.transaksi.index') }}" class="nav-link">
                    <span class="icon"></span>
                    <span>Transaksi</span>
                </a>
                <a href="{{ route('admin.pelanggan.index') }}" class="nav-link">
                    <span class="icon"></span>
                    <span>Pelanggan</span>
                </a>
                <a href="{{ route('admin.karyawan.index') }}" class="nav-link">
                    <span class="icon"></span>
                    <span>Karyawan</span>
                </a>
                <a href="{{ route('admin.orders.index') }}" class="nav-link">
                    <span class="icon"></span>
                    <span>Order</span>
                </a>
            </div>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </aside>

    {{-- MAIN --}}
    <main class="main">
        <div class="main-header">
            <div>
                <h1 style="font-size:1.4rem;font-weight:600;">Dashboard Kedai Kopi</h1>
                <p style="font-size:.86rem;color:var(--muted);margin-top:.15rem;">
                    Ringkasan penjualan dan pesanan yang masuk hari ini.
                </p>
            </div>
            <div style="font-size:.85rem;color:var(--muted);">
                {{ now()->format('d M Y') }}
            </div>
        </div>

        {{-- KARTU RINGKASAN --}}
        <section class="cards">
            <div class="card">
                <div class="card-label">Total Penjualan Hari Ini</div>
                <div class="card-value">
                    Rp {{ number_format($totalPenjualanHariIni, 0, ',', '.') }}
                </div>
                <div class="card-note">Berdasarkan order yang tercatat hari ini.</div>
            </div>

            <div class="card">
                <div class="card-label">Total Pesanan Bulan Ini</div>
                <div class="card-value">
                    {{ $totalPesananBulanIni }}
                </div>
                <div class="card-note">Jumlah semua order yang masuk bulan ini.</div>
            </div>

            <div class="card">
                <div class="card-label">Pengeluaran Operasional</div>
                <div class="card-value red">
                    Rp {{ number_format($pengeluaranOperasional, 0, ',', '.') }}
                </div>
                <div class="card-note">Termasuk bahan baku & operasional (bisa dihubungkan ke tabel lain).</div>
            </div>
        </section>

        {{-- TABEL PESANAN TERBARU --}}
        <section class="table-card">
            <div class="table-head">
                <div>
                    <div style="font-weight:600;font-size:.95rem;">Pesanan Terbaru</div>
                    <div style="font-size:.8rem;color:var(--muted);">Order yang terakhir masuk dari halaman menu.</div>
                </div>
                <a href="{{ route('admin.orders.index') }}"
                    style="font-size:.8rem;color:#f97316;text-decoration:none;">
                    Lihat Semua
                </a>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Deskripsi</th>
                        <th>Meja</th> {{-- kolom meja --}}
                        <th>Status</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pesananTerbaru as $order)
                        <tr>
                            <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                            <td>{{ $order->menu_dipesan }}</td>

                            {{-- MEJA --}}
                            <td>
                                @if($order->no_meja)
                                    Meja {{ $order->no_meja }}
                                @else
                                    -
                                @endif
                            </td>

                            <td>
                                @php $status = strtolower($order->status); @endphp
                                @if ($status === 'selesai')
                                    <span class="status-pill status-selesai">Selesai</span>
                                @elseif($status === 'batal')
                                    <span class="status-pill status-batal">Batal</span>
                                @else
                                    <span class="status-pill status-pending">Pending</span>
                                @endif
                            </td>
                            <td class="amount-green">
                                Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align:center;color:var(--muted);padding:.8rem 0;">
                                Belum ada pesanan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </section>
    </main>
    <script>
        // refresh dashboard tiap 15 detik biar kasir nggak perlu klik reload
        setInterval(function() {
            window.location.reload();
        }, 15000); // 15000 ms = 15 detik
    </script>

</body>

</html>
