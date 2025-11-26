@extends('layouts.app')

@section('content')
<div class="container-fluid py-4 transaksi-dashboard">

    {{-- ================= HERO COFFEE GRADIENT + STAT RINGKAS ================= --}}
    <div class="transaksi-hero mb-4 shadow-sm">
        <div class="row align-items-center gy-3">
            <div class="col-lg-8">
                <h4 class="text-white mb-1">Laporan Transaksi</h4>
                <p class="text-hero-subtitle mb-0">
                    Pantau performa penjualan dan aktivitas transaksi di SeduhRasa Panel Kasir.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="hero-balance">
                    <span class="hero-balance-label">Total Pendapatan</span>
                    <div class="hero-balance-value">
                        Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}
                    </div>
                </div>
            </div>
        </div>

        {{-- 4 KARTU STAT DI DALAM HERO --}}
        <div class="row g-3 mt-3">
            <div class="col-md-3 col-6">
                <div class="stat-pill stat-pill-light">
                    <div class="stat-pill-icon icon-brown">
                        <i class="bi bi-receipt"></i>
                    </div>
                    <div>
                        <div class="stat-pill-label">Total Transaksi</div>
                        <div class="stat-pill-value">
                            {{ number_format($stats['total_transactions']) }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-6">
                <div class="stat-pill stat-pill-amber">
                    <div class="stat-pill-icon icon-amber">
                        <i class="bi bi-cash-stack"></i>
                    </div>
                    <div>
                        <div class="stat-pill-label">Transaksi Cash</div>
                        <div class="stat-pill-value">
                            {{ number_format($stats['cash_count']) }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-6">
                <div class="stat-pill stat-pill-cream">
                    <div class="stat-pill-icon icon-cream">
                        <i class="bi bi-credit-card"></i>
                    </div>
                    <div>
                        <div class="stat-pill-label">Transaksi Transfer</div>
                        <div class="stat-pill-value">
                            {{ number_format($stats['transfer_count']) }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-6">
                <div class="stat-pill stat-pill-outline">
                    <div class="stat-pill-icon icon-outline">
                        <i class="bi bi-bag-check"></i>
                    </div>
                    <div>
                        <div class="stat-pill-label">Rata-rata / Transaksi</div>
                        <div class="stat-pill-value">
                            @php
                                $avg = $stats['total_transactions'] > 0
                                    ? floor($stats['total_revenue'] / $stats['total_transactions'])
                                    : 0;
                            @endphp
                            Rp {{ number_format($avg, 0, ',', '.') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ================= ALERT ================= --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('info'))
        <div class="alert alert-info alert-dismissible fade show mb-3" role="alert">
            {{ session('info') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">

        {{-- ================= FILTER CARD ================= --}}
        <div class="col-12">
            <div class="card shadow-sm border-0 filter-card mb-3">
                <div class="card-header bg-transparent border-0 pb-0 d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <h6 class="fw-semibold mb-1">
                            <i class="bi bi-funnel me-1"></i> Filter Laporan
                        </h6>
                        <p class="text-muted small mb-0">
                            Sesuaikan rentang tanggal, metode pembayaran, atau cari nama / kode order.
                        </p>
                    </div>
                    <div>
                        <a href="{{ route('admin.transaksi.export') }}" class="btn btn-amber">
                            <i class="bi bi-file-earmark-excel"></i>
                            <span class="ms-1">Export Excel</span>
                        </a>
                    </div>
                </div>
                <div class="card-body pt-3">
                    <form method="GET" action="{{ route('admin.transaksi.index') }}" class="row g-3 align-items-end">
                        <div class="col-md-3">
                            <label class="form-label filter-label">Tanggal Mulai</label>
                            <input
                                type="date"
                                name="start_date"
                                class="form-control"
                                value="{{ request('start_date') }}"
                            >
                        </div>
                        <div class="col-md-3">
                            <label class="form-label filter-label">Tanggal Akhir</label>
                            <input
                                type="date"
                                name="end_date"
                                class="form-control"
                                value="{{ request('end_date') }}"
                            >
                        </div>
                        <div class="col-md-3">
                            <label class="form-label filter-label">Metode Pembayaran</label>
                            <select name="metode_pembayaran" class="form-select">
                                <option value="">Semua Metode</option>
                                <option value="cod"  {{ request('metode_pembayaran') == 'cod'  ? 'selected' : '' }}>
                                    Bayar di Tempat (Cash)
                                </option>
                                <option value="dana" {{ request('metode_pembayaran') == 'dana' ? 'selected' : '' }}>
                                    Non-tunai / Transfer
                                </option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label filter-label">Cari Nama / Kode Order</label>
                            <input
                                type="text"
                                name="search"
                                class="form-control"
                                placeholder="Contoh: Markus / ORD-2025..."
                                value="{{ request('search') }}"
                            >
                        </div>

                        <div class="col-12 d-flex justify-content-end gap-2 mt-1">
                            <a href="{{ route('admin.transaksi.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-clockwise"></i>
                                <span class="ms-1">Reset</span>
                            </a>
                            <button type="submit" class="btn btn-brown">
                                <i class="bi bi-search"></i>
                                <span class="ms-1">Tampilkan</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- ================= TABLE CARD ================= --}}
        <div class="col-12">
            <div class="card shadow-sm border-0 table-card">
                <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <h6 class="fw-semibold mb-1">
                            <i class="bi bi-table me-1"></i> Daftar Transaksi
                        </h6>
                        @if($transactions->count() > 0)
                            <p class="text-muted small mb-0">
                                Menampilkan {{ $transactions->firstItem() }}–{{ $transactions->lastItem() }}
                                dari {{ $transactions->total() }} transaksi.
                            </p>
                        @else
                            <p class="text-muted small mb-0">
                                Belum ada transaksi untuk filter yang dipilih.
                            </p>
                        @endif
                    </div>
                </div>

                <div class="card-body pt-0">
                    @if($transactions->count() > 0)
                        <div class="table-responsive">
                            <table class="table align-middle table-hover mb-0 transaksi-table">
                                <thead>
                                    <tr class="text-nowrap">
                                        <th class="small">#</th>
                                        <th class="small">Kode Order</th>
                                        <th class="small">Tanggal & Waktu</th>
                                        <th class="small">Customer</th>
                                        <th class="small">Menu</th>
                                        <th class="small text-end">Total</th>
                                        <th class="small text-center">Pembayaran</th>
                                        <th class="small text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($transactions as $index => $transaction)
                                        <tr>
                                            <td class="text-muted small">
                                                {{ $transactions->firstItem() + $index }}
                                            </td>
                                            <td>
                                                <span class="badge kode-order-badge">
                                                    {{ $transaction->kode_order }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="small">
                                                    <div>{{ $transaction->created_at->format('d M Y') }}</div>
                                                    <div class="text-muted">
                                                        {{ $transaction->created_at->format('H:i') }} WIB
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <strong>{{ $transaction->customer_name }}</strong>
                                                @if($transaction->no_meja)
                                                    <div class="small text-muted">
                                                        Meja: {{ $transaction->no_meja }}
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    {{ Str::limit($transaction->keterangan, 60) }}
                                                </small>
                                            </td>
                                            <td class="text-end">
                                                <strong class="text-success">
                                                    Rp {{ number_format($transaction->subtotal, 0, ',', '.') }}
                                                </strong>
                                            </td>
                                            <td class="text-center">
                                                @if($transaction->metode_pembayaran == 'cod')
                                                    <span class="badge pembayaran-badge cash">
                                                        <i class="bi bi-cash me-1"></i> Cash
                                                    </span>
                                                @else
                                                    <span class="badge pembayaran-badge transfer">
                                                        <i class="bi bi-credit-card me-1"></i> Transfer
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <a
                                                    href="{{ route('admin.transaksi.show', $transaction->id) }}"
                                                    class="btn btn-sm btn-outline-brown me-1"
                                                    title="Detail"
                                                >
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <form
                                                    action="{{ route('admin.transaksi.destroy', $transaction->id) }}"
                                                    method="POST"
                                                    class="d-inline"
                                                    onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')"
                                                >
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="5" class="text-end fw-semibold">
                                            Total Halaman Ini:
                                        </td>
                                        <td colspan="3" class="fw-bold text-success">
                                            Rp {{ number_format($transactions->sum('subtotal'), 0, ',', '.') }}
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="mt-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <div class="small text-muted">
                                Menampilkan {{ $transactions->firstItem() }}–{{ $transactions->lastItem() }}
                                dari {{ $transactions->total() }} transaksi.
                            </div>
                            <div>
                                {{ $transactions->links() }}
                            </div>
                        </div>
                    @else
                        <div class="alert alert-info mb-0">
                            <i class="bi bi-info-circle me-1"></i>
                            Belum ada transaksi. Data akan muncul setelah ada order berstatus
                            <strong>"Selesai"</strong>.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    :root {
        --coffee-dark: #2b1b12;
        --coffee-brown: #4b2c20;
        --coffee-amber: #f59e0b;
        --coffee-cream: #fbf3e7;
        --coffee-soft: #fff7ec;
    }

    .transaksi-dashboard {
        background-color: #faf4ec;
    }

    .transaksi-hero {
        background: linear-gradient(135deg, var(--coffee-brown), var(--coffee-amber));
        border-radius: 1.5rem;
        padding: 1.5rem 1.75rem;
        color: #fff;
    }

    .text-hero-subtitle {
        font-size: 0.9rem;
        opacity: 0.85;
    }

    .hero-balance-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        opacity: 0.9;
    }

    .hero-balance-value {
        font-size: 1.4rem;
        font-weight: 700;
    }

    .stat-pill {
        background-color: rgba(255, 255, 255, 0.14);
        border-radius: 1rem;
        padding: 0.75rem 0.9rem;
        display: flex;
        align-items: center;
        gap: 0.6rem;
        color: #fff;
        backdrop-filter: blur(4px);
        border: 1px solid rgba(255, 255, 255, 0.18);
    }

    .stat-pill-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        opacity: 0.9;
    }

    .stat-pill-value {
        font-weight: 700;
        font-size: 1rem;
    }

    .stat-pill-icon {
        width: 34px;
        height: 34px;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.05rem;
        background-color: rgba(255, 255, 255, 0.16);
    }

    .stat-pill-light { background-color: rgba(255, 255, 255, 0.12); }
    .stat-pill-amber { background-color: rgba(245, 158, 11, 0.18); }
    .stat-pill-cream { background-color: rgba(251, 243, 231, 0.2); }
    .stat-pill-outline {
        background-color: transparent;
        border-color: rgba(255, 255, 255, 0.6);
    }

    .icon-brown { color: #fef3c7; }
    .icon-amber { color: #fff; }
    .icon-cream { color: #4b2c20; }
    .icon-outline { color: #fff; }

    .filter-card {
        background: var(--coffee-soft);
        border-radius: 1.25rem;
    }

    .filter-label {
        font-size: 0.78rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #6b4d34;
    }

    .btn-brown {
        background-color: var(--coffee-brown);
        border-color: var(--coffee-brown);
        color: #fff;
    }
    .btn-brown:hover {
        background-color: #3a2218;
        border-color: #3a2218;
    }

    .btn-amber {
        background-color: var(--coffee-amber);
        border-color: var(--coffee-amber);
        color: #1f130c;
    }
    .btn-amber:hover {
        background-color: #d97706;
        border-color: #d97706;
        color: #1f130c;
    }

    .table-card {
        border-radius: 1.25rem;
    }

    .transaksi-table thead tr {
        background-color: #f5eee4;
    }

    .transaksi-table thead th {
        border-bottom-width: 0;
        font-size: 0.78rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #6b4d34;
    }

    .transaksi-table tbody tr:nth-child(even) {
        background-color: #fdf8f1;
    }

    .kode-order-badge {
        background-color: #fef3c7;
        color: #92400e;
        border-radius: 999px;
        padding: 0.35rem 0.75rem;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .pembayaran-badge {
        border-radius: 999px;
        font-size: 0.75rem;
        padding: 0.3rem 0.7rem;
    }
    .pembayaran-badge.cash {
        background-color: #fef3c7;
        color: #92400e;
    }
    .pembayaran-badge.transfer {
        background-color: #dbeafe;
        color: #1d4ed8;
    }

    .btn-outline-brown {
        border-color: #6b4d34;
        color: #6b4d34;
    }
    .btn-outline-brown:hover {
        background-color: #6b4d34;
        color: #fff;
    }

    @media (max-width: 767.98px) {
        .transaksi-hero {
            border-radius: 1.1rem;
        }
        .stat-pill {
            padding: 0.65rem 0.75rem;
        }
    }
</style>
@endpush
