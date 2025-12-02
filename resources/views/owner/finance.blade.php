@extends('layouts.app')

@section('title', 'Keuangan Pemilik')
@section('page-title', 'Keuangan Pemilik')

@section('content')
<div class="finance-modern-page">
    <div class="container-fluid py-4">

        {{-- Premium Header --}}
        <div class="premium-header mb-4">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="header-content">
                        <div class="header-badge">
                            <i class="bi bi-shield-check me-2"></i>
                            Panel Keuangan Owner
                        </div>
                        <h2 class="header-title mt-2 mb-2">
                            Selamat datang, {{ auth()->user()->name ?? 'Owner' }} ☕
                        </h2>
                        <p class="header-subtitle mb-0">
                            Pantau kesehatan finansial coffee shop Anda secara real-time dengan visualisasi yang jelas
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                    <div class="header-actions">
                        <a href="#pemasukan-section" class="btn btn-light-coffee me-2">
                            <i class="bi bi-arrow-down-circle me-2"></i>Pemasukan
                        </a>
                        <a href="#pengeluaran-section" class="btn btn-outline-light">
                            <i class="bi bi-arrow-up-circle me-2"></i>Pengeluaran
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Financial Summary Cards --}}
        <div class="row g-4 mb-4">
            {{-- Total Pemasukan --}}
            <div class="col-lg-4 col-md-6">
                <div class="financial-card income-card">
                    <div class="card-icon-wrapper">
                        <div class="card-icon income">
                            <i class="bi bi-arrow-down-circle"></i>
                        </div>
                        <div class="card-icon-bg">
                            <i class="bi bi-currency-dollar"></i>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-label">Total Pemasukan</div>
                        <div class="card-value income">
                            Rp {{ number_format($totalPemasukan, 0, ',', '.') }}
                        </div>
                        <div class="card-desc">
                            <i class="bi bi-graph-up me-1"></i>
                            Omzet seluruh transaksi penjualan
                        </div>
                    </div>
                    <div class="card-pattern"></div>
                </div>
            </div>

            {{-- Total Pengeluaran --}}
            <div class="col-lg-4 col-md-6">
                <div class="financial-card expense-card">
                    <div class="card-icon-wrapper">
                        <div class="card-icon expense">
                            <i class="bi bi-arrow-up-circle"></i>
                        </div>
                        <div class="card-icon-bg">
                            <i class="bi bi-cart"></i>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-label">Total Pengeluaran</div>
                        <div class="card-value expense">
                            Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}
                        </div>
                        <div class="card-desc">
                            <i class="bi bi-box me-1"></i>
                            Operasional, gaji, dan bahan baku
                        </div>
                    </div>
                    <div class="card-pattern"></div>
                </div>
            </div>

            {{-- Laba Bersih --}}
            <div class="col-lg-4 col-md-6">
                <div class="financial-card profit-card">
                    <div class="card-icon-wrapper">
                        <div class="card-icon profit">
                            <i class="bi bi-trophy"></i>
                        </div>
                        <div class="card-icon-bg">
                            <i class="bi bi-star"></i>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-label">Laba Bersih</div>
                        <div class="card-value profit">
                            Rp {{ number_format($labaBersih, 0, ',', '.') }}
                        </div>
                        <div class="card-desc">
                            <i class="bi bi-calculator me-1"></i>
                            Pemasukan - Pengeluaran
                        </div>
                    </div>
                    <div class="card-pattern"></div>
                </div>
            </div>
        </div>

        {{-- Chart Card --}}
        <div class="chart-card mb-4">
            <div class="chart-header">
                <div>
                    <h5 class="chart-title mb-1">
                        <i class="bi bi-bar-chart-fill me-2"></i>
                        Visualisasi Keuangan
                    </h5>
                    <p class="chart-subtitle mb-0">
                        Perbandingan pemasukan, pengeluaran, dan laba bersih secara visual
                    </p>
                </div>
            </div>
            <div class="chart-body">
                @php
                    $maxValue = max($totalPemasukan, $totalPengeluaran, max($labaBersih, 1));
                    $heightIncome = $totalPemasukan > 0 ? intval(($totalPemasukan / $maxValue) * 200) : 0;
                    $heightExpense = $totalPengeluaran > 0 ? intval(($totalPengeluaran / $maxValue) * 200) : 0;
                    $heightProfit = $labaBersih > 0 ? intval(($labaBersih / $maxValue) * 200) : 0;
                @endphp

                <div class="modern-chart">
                    <div class="chart-grid"></div>
                    <div class="chart-bars">
                        {{-- Pemasukan Bar --}}
                        <div class="chart-bar-item">
                            <div class="bar-value">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</div>
                            <div class="bar-container">
                                <div class="bar bar-income" style="height: {{ $heightIncome }}px">
                                    <div class="bar-glow"></div>
                                </div>
                            </div>
                            <div class="bar-label">
                                <i class="bi bi-arrow-down-circle me-1"></i>
                                Pemasukan
                            </div>
                        </div>

                        {{-- Pengeluaran Bar --}}
                        <div class="chart-bar-item">
                            <div class="bar-value">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</div>
                            <div class="bar-container">
                                <div class="bar bar-expense" style="height: {{ $heightExpense }}px">
                                    <div class="bar-glow"></div>
                                </div>
                            </div>
                            <div class="bar-label">
                                <i class="bi bi-arrow-up-circle me-1"></i>
                                Pengeluaran
                            </div>
                        </div>

                        {{-- Laba Bar --}}
                        <div class="chart-bar-item">
                            <div class="bar-value">Rp {{ number_format($labaBersih, 0, ',', '.') }}</div>
                            <div class="bar-container">
                                <div class="bar bar-profit" style="height: {{ $heightProfit }}px">
                                    <div class="bar-glow"></div>
                                </div>
                            </div>
                            <div class="bar-label">
                                <i class="bi bi-trophy me-1"></i>
                                Laba Bersih
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tables Section --}}
        <div class="row g-4">
            {{-- Pemasukan Table --}}
            <div class="col-lg-6" id="pemasukan-section">
                <div class="data-table-card income-theme">
                    <div class="table-card-header">
                        <div class="d-flex align-items-center gap-2">
                            <div class="table-icon income">
                                <i class="bi bi-receipt"></i>
                            </div>
                            <div>
                                <h5 class="table-title mb-0">Pemasukan Terbaru</h5>
                                <p class="table-subtitle mb-0">10 transaksi terakhir</p>
                            </div>
                        </div>
                    </div>
                    <div class="table-card-body">
                        <div class="table-responsive">
                            <table class="modern-table">
                                <thead>
                                    <tr>
                                        <th width="50">#</th>
                                        <th>Tanggal</th>
                                        <th>Kode Order</th>
                                        <th class="text-end">Nominal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($daftarPemasukan as $i => $trx)
                                        <tr>
                                            <td>
                                                <span class="row-number">{{ $i + 1 }}</span>
                                            </td>
                                            <td>
                                                <div class="date-badge">
                                                    <i class="bi bi-calendar3 me-1"></i>
                                                    {{ $trx->created_at?->format('d/m/Y') ?? '-' }}
                                                </div>
                                            </td>
                                            <td>
                                                <span class="order-code income">{{ $trx->kode_order ?? $trx->id }}</span>
                                            </td>
                                            <td class="text-end">
                                                <span class="amount income">
                                                    Rp {{ number_format($trx->subtotal, 0, ',', '.') }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-5">
                                                <div class="empty-state">
                                                    <i class="bi bi-inbox"></i>
                                                    <p class="mb-0">Belum ada data pemasukan</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        @if($daftarPemasukan->count() > 0)
                            <div class="table-footer">
                                <i class="bi bi-info-circle me-1"></i>
                                Menampilkan {{ $daftarPemasukan->count() }} transaksi terbaru
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Pengeluaran Table --}}
            <div class="col-lg-6" id="pengeluaran-section">
                <div class="data-table-card expense-theme">
                    <div class="table-card-header">
                        <div class="d-flex align-items-center gap-2">
                            <div class="table-icon expense">
                                <i class="bi bi-box-seam"></i>
                            </div>
                            <div>
                                <h5 class="table-title mb-0">Pengeluaran Terbaru</h5>
                                <p class="table-subtitle mb-0">10 pengeluaran terakhir</p>
                            </div>
                        </div>
                    </div>
                    <div class="table-card-body">
                        <div class="table-responsive">
                            <table class="modern-table">
                                <thead>
                                    <tr>
                                        <th width="50">#</th>
                                        <th>Tanggal</th>
                                        <th>Kategori</th>
                                        <th class="text-end">Nominal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($daftarPengeluaran as $i => $out)
                                        <tr>
                                            <td>
                                                <span class="row-number">{{ $i + 1 }}</span>
                                            </td>
                                            <td>
                                                <div class="date-badge">
                                                    <i class="bi bi-calendar3 me-1"></i>
                                                    {{ $out->tanggal?->format('d/m/Y') ?? '-' }}
                                                </div>
                                            </td>
                                            <td>
                                                <span class="category-badge">{{ $out->kategori ?? '-' }}</span>
                                            </td>
                                            <td class="text-end">
                                                <span class="amount expense">
                                                    Rp {{ number_format($out->nominal, 0, ',', '.') }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-5">
                                                <div class="empty-state">
                                                    <i class="bi bi-inbox"></i>
                                                    <p class="mb-0">Belum ada data pengeluaran</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        @if($daftarPengeluaran->count() > 0)
                            <div class="table-footer">
                                <i class="bi bi-info-circle me-1"></i>
                                Menampilkan {{ $daftarPengeluaran->count() }} pengeluaran terbaru
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@push('styles')
<style>
:root {
    --coffee-primary: #2B1810;
    --coffee-secondary: #4B2C20;
    --coffee-accent: #8B6F47;
    --coffee-light: #D4A574;
    --coffee-bg: #FAF7F4;
    --income-color: #10B981;
    --income-light: #D1FAE5;
    --expense-color: #EF4444;
    --expense-light: #FEE2E2;
    --profit-color: #8B6F47;
}

.finance-modern-page {
    background: linear-gradient(135deg, #FAF7F4 0%, #F5EFE6 100%);
    min-height: 100vh;
}

.premium-header {
    background: linear-gradient(135deg, var(--coffee-primary) 0%, var(--coffee-secondary) 100%);
    border-radius: 24px;
    padding: 2.5rem;
    box-shadow: 0 20px 40px rgba(43, 24, 16, 0.2);
    position: relative;
    overflow: hidden;
}

.premium-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 500px;
    height: 500px;
    background: radial-gradient(circle, rgba(212, 165, 116, 0.15) 0%, transparent 70%);
}

.header-content {
    position: relative;
    z-index: 2;
}

.header-badge {
    display: inline-flex;
    align-items: center;
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(10px);
    padding: 0.5rem 1rem;
    border-radius: 50px;
    color: white;
    font-size: 0.85rem;
    font-weight: 600;
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.header-title {
    color: white;
    font-weight: 700;
    font-size: 2.2rem;
}

.header-subtitle {
    color: rgba(255, 255, 255, 0.85);
    font-size: 1.05rem;
}

.header-actions {
    position: relative;
    z-index: 2;
}

.btn-light-coffee {
    background: white;
    color: var(--coffee-secondary);
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 12px;
    font-weight: 600;
    transition: all 0.3s;
}

.btn-light-coffee:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(255, 255, 255, 0.3);
}

.btn-outline-light {
    border: 2px solid rgba(255, 255, 255, 0.4);
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 12px;
    font-weight: 600;
}

.btn-outline-light:hover {
    background: white;
    color: var(--coffee-secondary);
}

.financial-card {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    position: relative;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    transition: all 0.3s;
}

.financial-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
}

.card-icon {
    width: 70px;
    height: 70px;
    border-radius: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    margin-bottom: 1.5rem;
}

.card-icon.income {
    background: linear-gradient(135deg, var(--income-color), #059669);
    color: white;
}

.card-icon.expense {
    background: linear-gradient(135deg, var(--expense-color), #DC2626);
    color: white;
}

.card-icon.profit {
    background: linear-gradient(135deg, var(--coffee-accent), var(--coffee-secondary));
    color: white;
}

.card-icon-bg {
    position: absolute;
    top: -40px;
    right: -20px;
    font-size: 150px;
    opacity: 0.03;
}

.card-label {
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #9CA3AF;
    font-weight: 600;
    margin-bottom: 0.75rem;
}

.card-value {
    font-size: 2rem;
    font-weight: 800;
    margin-bottom: 0.75rem;
}

.card-value.income { color: var(--income-color); }
.card-value.expense { color: var(--expense-color); }
.card-value.profit { color: var(--profit-color); }

.card-desc {
    font-size: 0.9rem;
    color: #6B7280;
}

.chart-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    overflow: hidden;
}

.chart-header {
    background: linear-gradient(135deg, #F9FAFB, #F3F4F6);
    padding: 2rem;
    border-bottom: 2px solid #E5E7EB;
}

.chart-title {
    color: var(--coffee-secondary);
    font-weight: 700;
    font-size: 1.3rem;
}

.chart-subtitle {
    color: #6B7280;
    font-size: 0.95rem;
}

.chart-body {
    padding: 3rem 2rem;
}

.modern-chart {
    position: relative;
    min-height: 350px;
}

.chart-grid {
    position: absolute;
    inset: 20px 40px 80px 40px;
    background-image: repeating-linear-gradient(to top, transparent, transparent 39px, rgba(0,0,0,0.03) 40px);
}

.chart-bars {
    position: relative;
    display: flex;
    justify-content: center;
    align-items: flex-end;
    gap: 4rem;
    min-height: 300px;
    padding-bottom: 60px;
}

.chart-bar-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 1rem;
}

.bar-value {
    font-size: 0.9rem;
    font-weight: 700;
    color: var(--coffee-secondary);
}

.bar-container {
    width: 70px;
    height: 240px;
    background: rgba(0, 0, 0, 0.02);
    border-radius: 20px;
    display: flex;
    align-items: flex-end;
    padding: 4px;
}

.bar {
    width: 100%;
    border-radius: 16px;
    transition: height 0.8s cubic-bezier(0.34, 1.56, 0.64, 1);
    position: relative;
}

.bar-income {
    background: linear-gradient(180deg, var(--income-color), #059669);
}

.bar-expense {
    background: linear-gradient(180deg, var(--expense-color), #DC2626);
}

.bar-profit {
    background: linear-gradient(180deg, var(--coffee-accent), var(--coffee-secondary));
}

.bar-glow {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 50%;
    background: linear-gradient(180deg, rgba(255,255,255,0.4), transparent);
    border-radius: 16px 16px 0 0;
}

.bar-label {
    font-size: 0.9rem;
    font-weight: 600;
    color: #6B7280;
}

.data-table-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    overflow: hidden;
}

.table-card-header {
    padding: 1.75rem;
    border-bottom: 2px solid #F3F4F6;
}

.income-theme .table-card-header {
    background: linear-gradient(135deg, var(--income-light), #ECFDF5);
}

.expense-theme .table-card-header {
    background: linear-gradient(135deg, var(--expense-light), #FEF2F2);
}

.table-icon {
    width: 50px;
    height: 50px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
}

.table-icon.income {
    background: var(--income-color);
    color: white;
}

.table-icon.expense {
    background: var(--expense-color);
    color: white;
}

.table-title {
    color: var(--coffee-secondary);
    font-weight: 700;
    font-size: 1.15rem;
}

.table-subtitle {
    color: #6B7280;
    font-size: 0.85rem;
}

.modern-table {
    width: 100%;
    margin: 0;
}

.modern-table thead th {
    padding: 1.25rem 1.5rem;
    background: #F9FAFB;
    border-bottom: 2px solid #E5E7EB;
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #6B7280;
    font-weight: 700;
}

.modern-table tbody td {
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid #F3F4F6;
}

.modern-table tbody tr:hover {
    background: #FAFAFA;
}

.row-number {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 28px;
    height: 28px;
    background: #F3F4F6;
    border-radius: 8px;
    font-size: 0.85rem;
    font-weight: 600;
    color: #6B7280;
}

.date-badge {
    font-size: 0.9rem;
    color: #4B5563;
}

.order-code {
    display: inline-block;
    padding: 0.4rem 0.8rem;
    border-radius: 8px;
    font-size: 0.8rem;
    font-weight: 700;
    font-family: 'Courier New', monospace;
}

.order-code.income {
    background: var(--income-light);
    color: #065F46;
}

.category-badge {
    padding: 0.4rem 0.8rem;
    background: #FEF3C7;
    color: #92400E;
    border-radius: 8px;
    font-size: 0.85rem;
    font-weight: 600;
}

.amount {
    font-weight: 700;
    font-size: 1rem;
}

.amount.income { color: var(--income-color); }
.amount.expense { color: var(--expense-color); }

.table-footer {
    padding: 1rem 1.5rem;
    background: #F9FAFB;
    border-top: 1px solid #E5E7EB;
    font-size: 0.85rem;
    color: #6B7280;
}

.empty-state {
    padding: 2rem;
    text-align: center;
}

.empty-state i {
    font-size: 4rem;
    color: #D1D5DB;
    margin-bottom: 1rem;
}

.empty-state p {
    color: #9CA3AF;
}

@media (max-width: 992px) {
    .premium-header { padding: 2rem; }
    .header-title { font-size: 1.75rem; }
    .chart-bars { gap: 2rem; }
    .bar-container { width: 50px; }
}

@media (max-width: 768px) {
    .financial-card { padding: 1.5rem; }
    .card-value { font-size: 1.5rem; }
}
</style>
@endpush
@endsection