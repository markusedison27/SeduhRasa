@extends('layouts.app')

@section('content')
<div class="transaksi-page">
    <div class="container-fluid py-4">

        {{-- Header dengan Gradient Coffee --}}
        <div class="page-header mb-4">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h2 class="header-title mb-2">
                        <i class="bi bi-receipt-cutoff me-2"></i>
                        Laporan Transaksi
                    </h2>
                    <p class="header-subtitle mb-0">
                        Pantau dan kelola seluruh transaksi penjualan coffee shop Anda
                    </p>
                </div>
                <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                    <a href="{{ route('admin.transaksi.export') }}" class="btn btn-export">
                        <i class="bi bi-file-earmark-excel me-2"></i>
                        Export Excel
                    </a>
                </div>
            </div>
        </div>

        {{-- Stats Cards dengan Coffee Theme --}}
        <div class="row g-3 mb-4">
            <div class="col-lg-3 col-md-6">
                <div class="stats-card revenue-card">
                    <div class="stats-icon">
                        <i class="bi bi-wallet2"></i>
                    </div>
                    <div class="stats-content">
                        <div class="stats-label">Total Pendapatan</div>
                        <div class="stats-value">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</div>
                    </div>
                    <div class="stats-bg-icon">
                        <i class="bi bi-currency-dollar"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="stats-card transaction-card">
                    <div class="stats-icon">
                        <i class="bi bi-receipt"></i>
                    </div>
                    <div class="stats-content">
                        <div class="stats-label">Total Transaksi</div>
                        <div class="stats-value">{{ number_format($stats['total_transactions']) }}</div>
                        <div class="stats-desc">Pesanan selesai</div>
                    </div>
                    <div class="stats-bg-icon">
                        <i class="bi bi-receipt"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="stats-card cash-card">
                    <div class="stats-icon">
                        <i class="bi bi-cash-stack"></i>
                    </div>
                    <div class="stats-content">
                        <div class="stats-label">Pembayaran Cash</div>
                        <div class="stats-value">{{ number_format($stats['cash_count']) }}</div>
                        <div class="stats-desc">Transaksi tunai</div>
                    </div>
                    <div class="stats-bg-icon">
                        <i class="bi bi-cash"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="stats-card transfer-card">
                    <div class="stats-icon">
                        <i class="bi bi-credit-card"></i>
                    </div>
                    <div class="stats-content">
                        <div class="stats-label">Pembayaran Transfer</div>
                        <div class="stats-value">{{ number_format($stats['transfer_count']) }}</div>
                        <div class="stats-desc">Non-tunai</div>
                    </div>
                    <div class="stats-bg-icon">
                        <i class="bi bi-credit-card-2-front"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Alert Messages --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show alert-custom" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show alert-custom" role="alert">
                <i class="bi bi-exclamation-circle-fill me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Filter Card --}}
        <div class="card filter-card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-funnel me-2"></i>Filter & Pencarian
                </h5>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('admin.transaksi.index') }}">
                    <div class="row g-3">
                        <div class="col-lg-3 col-md-6">
                            <label class="form-label">
                                <i class="bi bi-calendar-event me-1"></i>Tanggal Mulai
                            </label>
                            <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <label class="form-label">
                                <i class="bi bi-calendar-check me-1"></i>Tanggal Akhir
                            </label>
                            <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <label class="form-label">
                                <i class="bi bi-wallet2 me-1"></i>Metode Pembayaran
                            </label>
                            <select name="metode_pembayaran" class="form-select">
                                <option value="">Semua Metode</option>
                                <option value="cod" {{ request('metode_pembayaran') == 'cod' ? 'selected' : '' }}>Cash</option>
                                <option value="dana" {{ request('metode_pembayaran') == 'dana' ? 'selected' : '' }}>Transfer</option>
                            </select>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <label class="form-label">
                                <i class="bi bi-search me-1"></i>Cari Transaksi
                            </label>
                            <input type="text" name="search" class="form-control" placeholder="Nama / Kode Order" value="{{ request('search') }}">
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-coffee me-2">
                                <i class="bi bi-search me-2"></i>Cari Data
                            </button>
                            <a href="{{ route('admin.transaksi.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-clockwise me-2"></i>Reset Filter
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Table Card --}}
        <div class="card table-card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-table me-2"></i>Daftar Transaksi
                    </h5>
                    @if($transactions->count() > 0)
                        <span class="badge bg-coffee">
                            Menampilkan {{ $transactions->firstItem() }}–{{ $transactions->lastItem() }} dari {{ $transactions->total() }}
                        </span>
                    @endif
                </div>
            </div>
            <div class="card-body p-0">
                @if($transactions->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th width="50">#</th>
                                    <th>Kode Order</th>
                                    <th>Tanggal & Waktu</th>
                                    <th>Customer</th>
                                    <th>Menu</th>
                                    <th class="text-end">Total</th>
                                    <th class="text-center">Pembayaran</th>
                                    <th class="text-center" width="120">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transactions as $index => $transaction)
                                    <tr>
                                        <td class="text-muted">{{ $transactions->firstItem() + $index }}</td>
                                        <td>
                                            <span class="order-code">{{ $transaction->kode_order }}</span>
                                        </td>
                                        <td>
                                            <div class="date-time">
                                                <div class="date">{{ $transaction->created_at->format('d M Y') }}</div>
                                                <div class="time">{{ $transaction->created_at->format('H:i') }} WIB</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="customer-info">
                                                <div class="customer-name">{{ $transaction->customer_name }}</div>
                                                @if($transaction->no_meja)
                                                    <div class="customer-table">
                                                        <i class="bi bi-geo-alt-fill me-1"></i>Meja {{ $transaction->no_meja }}
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <span class="menu-text">{{ Str::limit($transaction->keterangan, 45) }}</span>
                                        </td>
                                        <td class="text-end">
                                            <span class="price-tag">Rp {{ number_format($transaction->subtotal, 0, ',', '.') }}</span>
                                        </td>
                                        <td class="text-center">
                                            @if($transaction->metode_pembayaran == 'cod')
                                                <span class="payment-badge cash">
                                                    <i class="bi bi-cash me-1"></i>Cash
                                                </span>
                                            @else
                                                <span class="payment-badge transfer">
                                                    <i class="bi bi-credit-card me-1"></i>Transfer
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.transaksi.show', $transaction->id) }}" 
                                                   class="btn btn-sm btn-action btn-view" 
                                                   title="Detail">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <form action="{{ route('admin.transaksi.destroy', $transaction->id) }}" 
                                                      method="POST" 
                                                      class="d-inline"
                                                      onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-action btn-delete" title="Hapus">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="table-footer">
                                    <td colspan="5" class="text-end fw-bold">Total Halaman Ini:</td>
                                    <td colspan="3" class="text-start fw-bold text-success">
                                        Rp {{ number_format($transactions->sum('subtotal'), 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <div class="pagination-info">
                                Menampilkan {{ $transactions->firstItem() }}–{{ $transactions->lastItem() }} dari {{ $transactions->total() }} transaksi
                            </div>
                            <div>
                                {{ $transactions->links() }}
                            </div>
                        </div>
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="bi bi-inbox"></i>
                        </div>
                        <h5>Belum Ada Transaksi</h5>
                        <p class="text-muted">Data transaksi akan muncul setelah ada order yang selesai</p>
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection

@push('styles')
<style>
    /* Color Variables - Coffee Theme */
    :root {
        --coffee-dark: #2B1810;
        --coffee-brown: #4B2C20;
        --coffee-medium: #6F4E37;
        --coffee-light: #8B7355;
        --coffee-cream: #D4A574;
        --coffee-bg: #FAF7F4;
        --coffee-card: #FFFFFF;
    }

    .transaksi-page {
        background: linear-gradient(135deg, #FAF7F4 0%, #F5EFE6 100%);
        min-height: 100vh;
    }

    /* Page Header */
    .page-header {
        background: linear-gradient(135deg, var(--coffee-dark) 0%, var(--coffee-brown) 100%);
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 10px 30px rgba(43, 24, 16, 0.2);
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(212, 165, 116, 0.15) 0%, transparent 70%);
        border-radius: 50%;
    }

    .header-title {
        color: #FFFFFF;
        font-weight: 700;
        font-size: 2rem;
        margin: 0;
        position: relative;
        z-index: 1;
    }

    .header-subtitle {
        color: rgba(255, 255, 255, 0.85);
        font-size: 1rem;
        position: relative;
        z-index: 1;
    }

    .btn-export {
        background: linear-gradient(135deg, #10B981 0%, #059669 100%);
        border: none;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
    }

    .btn-export:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
        color: white;
    }

    /* Stats Cards */
    .stats-card {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .stats-icon {
        width: 60px;
        height: 60px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
        flex-shrink: 0;
        position: relative;
        z-index: 2;
    }

    .stats-content {
        flex: 1;
        position: relative;
        z-index: 2;
    }

    .stats-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #6B7280;
        font-weight: 600;
        margin-bottom: 0.25rem;
    }

    .stats-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: #111827;
        line-height: 1.2;
    }

    .stats-desc {
        font-size: 0.8rem;
        color: #9CA3AF;
        margin-top: 0.25rem;
    }

    .stats-bg-icon {
        position: absolute;
        right: -20px;
        bottom: -20px;
        font-size: 8rem;
        opacity: 0.05;
        z-index: 1;
    }

    /* Stats Card Variants */
    .revenue-card .stats-icon {
        background: linear-gradient(135deg, #667EEA 0%, #764BA2 100%);
        color: white;
    }

    .transaction-card .stats-icon {
        background: linear-gradient(135deg, #F093FB 0%, #F5576C 100%);
        color: white;
    }

    .cash-card .stats-icon {
        background: linear-gradient(135deg, #4FACFE 0%, #00F2FE 100%);
        color: white;
    }

    .transfer-card .stats-icon {
        background: linear-gradient(135deg, #43E97B 0%, #38F9D7 100%);
        color: white;
    }

    /* Cards */
    .card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }

    .card-header {
        background: linear-gradient(135deg, var(--coffee-brown) 0%, var(--coffee-medium) 100%);
        border: none;
        padding: 1.25rem 1.5rem;
    }

    .card-title {
        color: white;
        font-weight: 600;
        font-size: 1.1rem;
        margin: 0;
    }

    .card-body {
        padding: 1.5rem;
    }

    .card-footer {
        background: #F9FAFB;
        border-top: 1px solid #E5E7EB;
        padding: 1rem 1.5rem;
    }

    /* Form Elements */
    .form-label {
        font-weight: 600;
        color: var(--coffee-brown);
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }

    .form-control, .form-select {
        border: 2px solid #E5E7EB;
        border-radius: 10px;
        padding: 0.65rem 1rem;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--coffee-medium);
        box-shadow: 0 0 0 3px rgba(111, 78, 55, 0.1);
    }

    /* Buttons */
    .btn-coffee {
        background: linear-gradient(135deg, var(--coffee-brown) 0%, var(--coffee-medium) 100%);
        border: none;
        color: white;
        padding: 0.65rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-coffee:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(75, 44, 32, 0.3);
        color: white;
    }

    /* Table */
    .table {
        margin: 0;
    }

    .table thead {
        background: linear-gradient(to right, #F9FAFB, #F3F4F6);
    }

    .table thead th {
        border: none;
        padding: 1rem 1.25rem;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        color: var(--coffee-brown);
    }

    .table tbody td {
        padding: 1.25rem;
        vertical-align: middle;
        border-bottom: 1px solid #F3F4F6;
    }

    .table tbody tr {
        transition: all 0.2s ease;
    }

    .table tbody tr:hover {
        background: #FFFBF5;
        transform: scale(1.01);
    }

    .table-footer {
        background: linear-gradient(to right, #FEF3C7, #FDE68A);
        font-weight: 700;
    }

    .table-footer td {
        padding: 1rem 1.25rem;
    }

    /* Table Elements */
    .order-code {
        display: inline-block;
        background: linear-gradient(135deg, #FEF3C7 0%, #FDE68A 100%);
        color: #92400E;
        padding: 0.4rem 0.9rem;
        border-radius: 8px;
        font-weight: 700;
        font-size: 0.8rem;
        font-family: 'Courier New', monospace;
        letter-spacing: 0.5px;
    }

    .date-time {
        display: flex;
        flex-direction: column;
        gap: 0.15rem;
    }

    .date-time .date {
        font-weight: 600;
        color: #374151;
        font-size: 0.9rem;
    }

    .date-time .time {
        color: #9CA3AF;
        font-size: 0.8rem;
    }

    .customer-info {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .customer-name {
        font-weight: 600;
        color: #111827;
    }

    .customer-table {
        font-size: 0.8rem;
        color: #6B7280;
    }

    .menu-text {
        color: #6B7280;
        font-size: 0.9rem;
        display: block;
        line-height: 1.4;
    }

    .price-tag {
        font-weight: 700;
        color: #059669;
        font-size: 1.05rem;
    }

    .payment-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.4rem 0.8rem;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .payment-badge.cash {
        background: linear-gradient(135deg, #FEF3C7 0%, #FDE68A 100%);
        color: #92400E;
    }

    .payment-badge.transfer {
        background: linear-gradient(135deg, #DBEAFE 0%, #BFDBFE 100%);
        color: #1E40AF;
    }

    /* Action Buttons */
    .btn-action {
        border: 2px solid;
        background: white;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        padding: 0;
    }

    .btn-view {
        border-color: #3B82F6;
        color: #3B82F6;
    }

    .btn-view:hover {
        background: #3B82F6;
        color: white;
        transform: scale(1.1);
    }

    .btn-delete {
        border-color: #EF4444;
        color: #EF4444;
    }

    .btn-delete:hover {
        background: #EF4444;
        color: white;
        transform: scale(1.1);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
    }

    .empty-icon {
        font-size: 5rem;
        color: #D1D5DB;
        margin-bottom: 1.5rem;
    }

    .empty-state h5 {
        color: #374151;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    /* Badges */
    .bg-coffee {
        background: linear-gradient(135deg, var(--coffee-brown) 0%, var(--coffee-medium) 100%);
    }

    /* Alert Custom */
    .alert-custom {
        border-radius: 12px;
        border: none;
        padding: 1rem 1.25rem;
    }

    /* Pagination */
    .pagination-info {
        color: #6B7280;
        font-size: 0.9rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .header-title {
            font-size: 1.5rem;
        }
        
        .stats-card {
            padding: 1.25rem;
        }
        
        .stats-value {
            font-size: 1.25rem;
        }
        
        .table {
            font-size: 0.85rem;
        }
        
        .page-header {
            padding: 1.5rem;
        }
    }
</style>
@endpush