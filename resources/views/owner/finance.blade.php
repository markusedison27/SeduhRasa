@extends('layouts.app')

@section('title', 'Keuangan Pemilik')

@section('content')
<div class="finance-wrapper">
    <div class="container-fluid py-4">

        {{-- HEADER --}}
        <div class="row mb-4">
            <div class="col-12">
                <div class="finance-header">
                    <div>
                        <div class="finance-pill">Panel Keuangan Owner</div>
                        <h2 class="finance-title">Ringkasan Keuangan SeduhRasa</h2>
                        <p class="finance-subtitle">
                            Pantau pemasukan dan pengeluaran coffee shop Anda dengan visual yang rapi dan nyaman.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- 8 KARTU RINGKASAN --}}
        <div class="row g-3 mb-4">

            {{-- Pemasukan Hari Ini --}}
            <div class="col-xl-3 col-md-6">
                <div class="finance-stat-card income-today">
                    <div class="icon-wrap">
                        <i class="bi bi-sun"></i>
                    </div>
                    <div class="content">
                        <span class="label">Pemasukan Hari Ini</span>
                        <span class="value">
                            Rp {{ number_format($stats['income_today'] ?? 0, 0, ',', '.') }}
                        </span>
                        <span class="hint">Total transaksi yang masuk hari ini</span>
                    </div>
                </div>
            </div>

            {{-- Pemasukan Bulan Ini --}}
            <div class="col-xl-3 col-md-6">
                <div class="finance-stat-card income-month">
                    <div class="icon-wrap">
                        <i class="bi bi-calendar-week"></i>
                    </div>
                    <div class="content">
                        <span class="label">Pemasukan Bulan Ini</span>
                        <span class="value">
                            Rp {{ number_format($stats['income_month'] ?? 0, 0, ',', '.') }}
                        </span>
                        <span class="hint">Akumulasi omset bulan berjalan</span>
                    </div>
                </div>
            </div>

            {{-- Pemasukan Tahun Ini --}}
            <div class="col-xl-3 col-md-6">
                <div class="finance-stat-card income-year">
                    <div class="icon-wrap">
                        <i class="bi bi-calendar3"></i>
                    </div>
                    <div class="content">
                        <span class="label">Pemasukan Tahun Ini</span>
                        <span class="value">
                            Rp {{ number_format($stats['income_year'] ?? 0, 0, ',', '.') }}
                        </span>
                        <span class="hint">Performa keuangan sepanjang tahun</span>
                    </div>
                </div>
            </div>

            {{-- Total Pemasukan --}}
            <div class="col-xl-3 col-md-6">
                <div class="finance-stat-card income-total">
                    <div class="icon-wrap">
                        <i class="bi bi-cash-stack"></i>
                    </div>
                    <div class="content">
                        <span class="label">Total Pemasukan</span>
                        <span class="value">
                            Rp {{ number_format($stats['income_total'] ?? 0, 0, ',', '.') }}
                        </span>
                        <span class="hint">Omzet total sejak awal pencatatan</span>
                    </div>
                </div>
            </div>

            {{-- Pengeluaran Hari Ini --}}
            <div class="col-xl-3 col-md-6">
                <div class="finance-stat-card expense-today">
                    <div class="icon-wrap">
                        <i class="bi bi-arrow-down-circle"></i>
                    </div>
                    <div class="content">
                        <span class="label">Pengeluaran Hari Ini</span>
                        <span class="value">
                            Rp {{ number_format($stats['expense_today'] ?? 0, 0, ',', '.') }}
                        </span>
                        <span class="hint">Biaya bahan baku, operasional, dll</span>
                    </div>
                </div>
            </div>

            {{-- Pengeluaran Bulan Ini --}}
            <div class="col-xl-3 col-md-6">
                <div class="finance-stat-card expense-month">
                    <div class="icon-wrap">
                        <i class="bi bi-arrow-down-up"></i>
                    </div>
                    <div class="content">
                        <span class="label">Pengeluaran Bulan Ini</span>
                        <span class="value">
                            Rp {{ number_format($stats['expense_month'] ?? 0, 0, ',', '.') }}
                        </span>
                        <span class="hint">Total biaya bulan berjalan</span>
                    </div>
                </div>
            </div>

            {{-- Pengeluaran Tahun Ini --}}
            <div class="col-xl-3 col-md-6">
                <div class="finance-stat-card expense-year">
                    <div class="icon-wrap">
                        <i class="bi bi-arrow-down-right-circle"></i>
                    </div>
                    <div class="content">
                        <span class="label">Pengeluaran Tahun Ini</span>
                        <span class="value">
                            Rp {{ number_format($stats['expense_year'] ?? 0, 0, ',', '.') }}
                        </span>
                        <span class="hint">Akumulasi biaya selama tahun ini</span>
                    </div>
                </div>
            </div>

            {{-- Total Pengeluaran --}}
            <div class="col-xl-3 col-md-6">
                <div class="finance-stat-card expense-total">
                    <div class="icon-wrap">
                        <i class="bi bi-wallet2"></i>
                    </div>
                    <div class="content">
                        <span class="label">Total Pengeluaran</span>
                        <span class="value">
                            Rp {{ number_format($stats['expense_total'] ?? 0, 0, ',', '.') }}
                        </span>
                        <span class="hint">Total biaya sejak awal pencatatan</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- GRAFIK + KALENDER --}}
        <div class="row g-3">

            {{-- GRAFIK --}}
            <div class="col-lg-8">
                <div class="finance-card">
                    <div class="finance-card-header">
                        <div>
                            <h6 class="title">Grafik Pemasukan & Pengeluaran</h6>
                            <span class="subtitle">Per bulan ({{ now()->year }})</span>
                        </div>
                    </div>
                    <div class="finance-card-body">
                        <canvas id="financeChart" height="150"></canvas>
                    </div>
                </div>
            </div>

            {{-- KALENDER --}}
            <div class="col-lg-4">
                <div class="finance-card">
                    <div class="finance-card-header">
                        <h6 class="title mb-0">
                            <i class="bi bi-calendar3 me-1"></i> Kalender
                        </h6>
                        <span class="subtitle">Ringkasan tanggal aktivitas</span>
                    </div>
                    <div class="finance-card-body">
                        <div class="calendar">
                            <div class="cal-header">
                                {{ now()->translatedFormat('F Y') }}
                            </div>
                            <div class="cal-grid">
                                <div>Su</div><div>Mo</div><div>Tu</div><div>We</div><div>Th</div><div>Fr</div><div>Sa</div>
                                @for($i = 1; $i <= 35; $i++)
                                    <span class="{{ $i == now()->day ? 'today' : '' }}">{{ $i <= 31 ? $i : '' }}</span>
                                @endfor
                            </div>
                        </div>
                        <small class="text-muted d-block mt-2">
                            *Kalender dekoratif. Bisa di-upgrade jadi kalender interaktif jika dibutuhkan.
                        </small>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection

@push('styles')
<style>
    .finance-wrapper{
        background: #F7F3EE;
        min-height: 100vh;
    }

    .finance-header{
        background: linear-gradient(135deg, #3a2418, #5b3320);
        border-radius: 22px;
        padding: 1.8rem 2rem;
        color: #FDFBF7;
        box-shadow: 0 16px 40px rgba(0,0,0,0.35);
    }

    .finance-pill{
        display:inline-flex;
        padding: .25rem .9rem;
        border-radius:999px;
        border:1px solid rgba(252, 211, 77, .8);
        font-size:.75rem;
        letter-spacing:.08em;
        text-transform:uppercase;
        color:#FDE68A;
        margin-bottom:.5rem;
    }

    .finance-title{
        font-weight:700;
        font-size:1.7rem;
        margin-bottom:.35rem;
    }

    .finance-subtitle{
        margin:0;
        font-size:.9rem;
        color:#F9E7D5;
        max-width:480px;
    }

    .finance-stat-card{
        background:#FFFFFF;
        border-radius:18px;
        padding:1rem 1.1rem;
        display:flex;
        gap:.9rem;
        align-items:flex-start;
        box-shadow:0 8px 20px rgba(0,0,0,0.06);
        border:1px solid rgba(148, 124, 96, 0.18);
    }
    .finance-stat-card .icon-wrap{
        width:40px;
        height:40px;
        border-radius:14px;
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:1.25rem;
    }
    .finance-stat-card .content .label{
        display:block;
        font-size:.8rem;
        text-transform:uppercase;
        letter-spacing:.08em;
        color:#6B5B4B;
        font-weight:600;
        margin-bottom:.1rem;
    }
    .finance-stat-card .content .value{
        display:block;
        font-weight:700;
        font-size:1.15rem;
        color:#1F2933;
    }
    .finance-stat-card .content .hint{
        display:block;
        font-size:.78rem;
        color:#9CA3AF;
        margin-top:.1rem;
    }

    .income-today   .icon-wrap{ background:#DCFCE7; color:#15803D; }
    .income-month   .icon-wrap{ background:#DBEAFE; color:#1D4ED8; }
    .income-year    .icon-wrap{ background:#FEF3C7; color:#B45309; }
    .income-total   .icon-wrap{ background:#E5E7EB; color:#111827; }
    .expense-today  .icon-wrap{ background:#FEE2E2; color:#B91C1C; }
    .expense-month  .icon-wrap{ background:#FFE4E6; color:#BE123C; }
    .expense-year   .icon-wrap{ background:#FEF2F2; color:#B91C1C; }
    .expense-total  .icon-wrap{ background:#F3E8FF; color:#6D28D9; }

    .finance-card{
        background:#FFFFFF;
        border-radius:20px;
        box-shadow:0 10px 24px rgba(15,23,42,0.08);
        border:1px solid rgba(148, 124, 96, 0.15);
        overflow:hidden;
    }
    .finance-card-header{
        padding:.9rem 1.3rem;
        border-bottom:1px solid rgba(229, 231, 235, 0.9);
        display:flex;
        align-items:flex-start;
        justify-content:space-between;
        gap:.5rem;
    }
    .finance-card-header .title{
        font-weight:600;
        font-size:.95rem;
        margin-bottom:.1rem;
    }
    .finance-card-header .subtitle{
        font-size:.78rem;
        color:#9CA3AF;
    }
    .finance-card-body{
        padding:1.1rem 1.3rem 1.3rem;
    }

    /* CALENDAR */
    .calendar{
        border-radius:14px;
        border:1px solid #E5E7EB;
        overflow:hidden;
    }
    .cal-header{
        background:#166534;
        color:#F9FAFB;
        padding:.6rem 0;
        text-align:center;
        font-weight:600;
        font-size:.85rem;
    }
    .cal-grid{
        display:grid;
        grid-template-columns:repeat(7,1fr);
        text-align:center;
        font-size:.78rem;
        padding:.35rem;
        gap:2px;
    }
    .cal-grid div{
        font-weight:600;
        color:#6B7280;
        padding:.2rem 0;
    }
    .cal-grid span{
        padding:.3rem 0;
        border-radius:6px;
        color:#374151;
    }
    .cal-grid span.today{
        background:#16A34A;
        color:#F9FAFB;
        font-weight:700;
    }

    /* CHART */
    #financeChart{
        width:100%;
    }

    @media (max-width: 768px) {
        .finance-header{
            padding:1.4rem 1.3rem;
        }
        .finance-title{
            font-size:1.35rem;
        }
    }
</style>
@endpush

@push('scripts')
{{-- Chart.js via CDN --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('financeChart').getContext('2d');

        const labels  = @json($monthLabels);
        const income  = @json($incomeByMonth);
        const expense = @json($expenseByMonth);

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Pemasukan',
                        data: income,
                        backgroundColor: 'rgba(34, 197, 94, 0.7)'
                    },
                    {
                        label: 'Pengeluaran',
                        data: expense,
                        backgroundColor: 'rgba(248, 113, 113, 0.8)'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        ticks: {
                            callback: function(value){
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endpush
