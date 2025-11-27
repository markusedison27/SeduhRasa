@extends('layouts.app')

@section('title', 'Keuangan Pemilik')
@section('page-title', 'Keuangan Pemilik')

@section('content')
    <div class="container-fluid py-3 finance-page">

        {{-- HERO / WELCOME CARD --}}
        <div class="card border-0 shadow-sm mb-4 hero-card">
            <div class="card-body d-flex flex-column flex-lg-row align-items-center justify-content-between gap-3">
                <div>
                    <h5 class="fw-semibold mb-1 text-coffee-dark">
                        Selamat datang kembali, {{ auth()->user()->name ?? 'Owner' }} 👋
                    </h5>
                    <p class="text-muted mb-2 small">
                        Pantau pemasukan dan pengeluaran kas SeduhRasa dalam satu tampilan.
                    </p>

                    <div class="d-flex flex-wrap gap-2">
                        <a href="#pemasukan-section" class="btn btn-coffee btn-sm">
                            Pemasukan
                        </a>
                        <a href="#pengeluaran-section" class="btn btn-outline-coffee btn-sm">
                            Pengeluaran
                        </a>
                    </div>
                </div>

                <div class="d-none d-lg-block">
                    <div class="hero-illustration">
                        <div class="hero-avatar">☕</div>
                        <div class="hero-text">
                            <span class="small text-muted">SeduhRasa</span>
                            <strong class="d-block">Panel Keuangan</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- SUMMARY CARDS (SEJARIS SAMPING) --}}
        <div class="summary-row mb-4">
            <div class="summary-card-wrapper">
                <div class="card border-0 shadow-sm summary-card h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="summary-icon income">
                            💰
                        </div>
                        <div>
                            <div class="summary-label">Total Pemasukan</div>
                            <div class="summary-value text-success">
                                Rp {{ number_format($totalPemasukan, 0, ',', '.') }}
                            </div>
                            <div class="summary-desc">
                                Omzet seluruh transaksi penjualan.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="summary-card-wrapper">
                <div class="card border-0 shadow-sm summary-card h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="summary-icon expense">
                            📦
                        </div>
                        <div>
                            <div class="summary-label">Total Pengeluaran</div>
                            <div class="summary-value text-danger">
                                Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}
                            </div>
                            <div class="summary-desc">
                                Bahan baku, gaji, dan operasional lainnya.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="summary-card-wrapper">
                <div class="card border-0 shadow-sm summary-card h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="summary-icon balance">
                            📊
                        </div>
                        <div>
                            <div class="summary-label">Saldo / Laba Bersih</div>
                            <div class="summary-value text-coffee-dark">
                                Rp {{ number_format($labaBersih, 0, ',', '.') }}
                            </div>
                            <div class="summary-desc">
                                Pemasukan dikurangi pengeluaran.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- GRAFIK RINGKAS --}}
        @php
            $maxValue      = max($totalPemasukan, $totalPengeluaran, max($labaBersih, 1));
            $heightIncome  = intval($totalPemasukan    / $maxValue * 160);
            $heightExpense = intval($totalPengeluaran  / $maxValue * 160);
            $heightBalance = intval(max($labaBersih,0) / $maxValue * 160);
        @endphp

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-0 pb-0">
                <h6 class="mb-1 text-coffee-dark">Grafik Ringkas Pemasukan & Pengeluaran</h6>
                <p class="text-muted small mb-0">
                    Perbandingan sederhana antara total pemasukan, pengeluaran, dan saldo.
                </p>
            </div>
            <div class="card-body">
                <div class="finance-chart">
                    <div class="finance-chart-bars">

                        {{-- Pemasukan --}}
                        <div class="finance-chart-col">
                            <div class="finance-chart-value">
                                Rp {{ number_format($totalPemasukan, 0, ',', '.') }}
                            </div>
                            <div class="finance-chart-bar-wrapper">
                                <div class="finance-chart-bar income" style="height: {{ $heightIncome }}px"></div>
                            </div>
                            <div class="finance-chart-label">Pemasukan</div>
                        </div>

                        {{-- Pengeluaran --}}
                        <div class="finance-chart-col">
                            <div class="finance-chart-value">
                                Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}
                            </div>
                            <div class="finance-chart-bar-wrapper">
                                <div class="finance-chart-bar expense" style="height: {{ $heightExpense }}px"></div>
                            </div>
                            <div class="finance-chart-label">Pengeluaran</div>
                        </div>

                        {{-- Saldo --}}
                        <div class="finance-chart-col">
                            <div class="finance-chart-value">
                                Rp {{ number_format($labaBersih, 0, ',', '.') }}
                            </div>
                            <div class="finance-chart-bar-wrapper">
                                <div class="finance-chart-bar balance" style="height: {{ $heightBalance }}px"></div>
                            </div>
                            <div class="finance-chart-label">Saldo</div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        {{-- DETAIL TABEL PEMASUKAN & PENGELUARAN --}}
        <div class="row g-3">
            {{-- Pemasukan --}}
            <div class="col-md-6" id="pemasukan-section">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-coffee-dark">Daftar Pemasukan Terbaru</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table mb-0 table-sm align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Tanggal</th>
                                        <th>Kode Order</th>
                                        <th class="text-end">Nominal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($daftarPemasukan as $i => $trx)
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <td>{{ $trx->created_at?->format('d/m/Y') ?? '-' }}</td>
                                            <td>{{ $trx->kode_order ?? $trx->id }}</td>
                                            <td class="text-end">
                                                Rp {{ number_format($trx->subtotal, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted py-3">
                                                Belum ada data pemasukan.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="px-3 py-2 text-muted small">
                            Menampilkan {{ $daftarPemasukan->count() }} pemasukan terbaru.
                        </div>
                    </div>
                </div>
            </div>

            {{-- Pengeluaran --}}
            <div class="col-md-6" id="pengeluaran-section">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-coffee-dark">Daftar Pengeluaran Terbaru</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table mb-0 table-sm align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Tanggal</th>
                                        <th>Kategori</th>
                                        <th class="text-end">Nominal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($daftarPengeluaran as $i => $out)
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <td>{{ $out->tanggal?->format('d/m/Y') ?? '-' }}</td>
                                            <td>{{ $out->kategori ?? '-' }}</td>
                                            <td class="text-end">
                                                Rp {{ number_format($out->nominal, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted py-3">
                                                Belum ada data pengeluaran.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="px-3 py-2 text-muted small">
                            Menampilkan {{ $daftarPengeluaran->count() }} pengeluaran terbaru.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- STYLE KHUSUS FINANCE OWNER --}}
    <style>
        .finance-page {
            background-color: #fffaf4;
        }

        .text-coffee-dark {
            color: #4b2c22;
        }

        .btn-coffee {
            background-color: #c38b5f;
            border-color: #c38b5f;
            color: #fff;
        }

        .btn-coffee:hover {
            background-color: #b27b52;
            border-color: #b27b52;
            color: #fff;
        }

        .btn-outline-coffee {
            border-color: #c38b5f;
            color: #c38b5f;
        }

        .btn-outline-coffee:hover {
            background-color: #c38b5f;
            color: #fff;
        }

        .hero-card {
            background: linear-gradient(90deg, #fffaf4, #fde9d2);
            border-radius: 18px;
        }

        .hero-illustration {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }

        .hero-avatar {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: #ffefdd;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
        }

        .hero-text strong {
            font-size: .9rem;
        }

        /* --- SUMMARY ROW FLEX --- */
        .summary-row {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .summary-card-wrapper {
            flex: 1 1 260px;
        }

        .summary-card {
            border-radius: 16px;
            background-color: #fdf7f0;
        }

        .summary-icon {
            width: 44px;
            height: 44px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            color: #fff;
        }

        .summary-icon.income {
            background: #1abc9c;
        }

        .summary-icon.expense {
            background: #e67e22;
        }

        .summary-icon.balance {
            background: #5b3724;
        }

        .summary-label {
            font-size: .78rem;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: #7b7b7b;
        }

        .summary-value {
            font-size: 1.3rem;
            font-weight: 700;
        }

        .summary-desc {
            font-size: .82rem;
            color: #8a7b6a;
        }

        /* --- GRAFIK FINANCE --- */
        .finance-chart {
            position: relative;
            border-radius: 18px;
            padding: 18px 18px 10px;
            background: #fff;
            overflow: hidden;
        }

        .finance-chart::before {
            content: "";
            position: absolute;
            inset: 10px 12px 32px 12px;
            border-radius: 14px;
            background-image: linear-gradient(
                to top,
                rgba(0,0,0,0.03) 1px,
                transparent 1px
            );
            background-size: 100% 32px;
            opacity: .8;
        }

        .finance-chart-bars {
            position: relative;
            z-index: 1;
            display: flex;
            justify-content: center;
            align-items: flex-end;
            gap: 48px;
            min-height: 190px;
        }

        .finance-chart-col {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
        }

        .finance-chart-value {
            font-size: .78rem;
            font-weight: 600;
            color: #4b2c22;
        }

        .finance-chart-bar-wrapper {
            width: 44px;
            height: 160px;
            border-radius: 16px;
            background: rgba(0,0,0,0.02);
            display: flex;
            align-items: flex-end;
            justify-content: center;
            overflow: hidden;
            box-shadow: inset 0 0 0 1px rgba(255,255,255,0.7);
        }

        .finance-chart-bar {
            width: 28px;
            border-radius: 12px 12px 4px 4px;
        }

        .finance-chart-bar.income {
            background: linear-gradient(180deg, #1abc9c, #16a085);
        }

        .finance-chart-bar.expense {
            background: linear-gradient(180deg, #f39c12, #e67e22);
        }

        .finance-chart-bar.balance {
            background: linear-gradient(180deg, #5b3724, #3b2217);
        }

        .finance-chart-label {
            font-size: .8rem;
            color: #7b7b7b;
            margin-top: 2px;
        }
    </style>
@endsection
