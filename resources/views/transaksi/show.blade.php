@extends('layouts.admin')

@section('content')
<div class="container-fluid p-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0">Detail Transaksi</h2>
            <p class="text-muted">{{ $transaction->kode_order }}</p>
        </div>
        <div>
            <a href="{{ route('admin.transactions.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
            <button onclick="window.print()" class="btn btn-primary">
                <i class="bi bi-printer"></i> Cetak
            </button>
        </div>
    </div>

    <div class="row">
        <!-- Detail Transaksi -->
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-receipt"></i> Informasi Transaksi</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6 class="text-muted mb-2">Kode Order</h6>
                            <h4><span class="badge bg-primary">{{ $transaction->kode_order }}</span></h4>
                        </div>
                        <div class="col-md-6 text-end">
                            <h6 class="text-muted mb-2">Tanggal Transaksi</h6>
                            <h5>{{ $transaction->transaction_date->format('d F Y') }}</h5>
                            <p class="text-muted mb-0">{{ $transaction->transaction_date->format('H:i') }} WIB</p>
                        </div>
                    </div>

                    <hr>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6 class="text-muted mb-2"><i class="bi bi-person"></i> Nama Customer</h6>
                            <h5 class="mb-0">{{ $transaction->customer_name }}</h5>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted mb-2"><i class="bi bi-table"></i> Nomor Meja</h6>
                            <h5 class="mb-0">{{ $transaction->no_meja ?? '-' }}</h5>
                        </div>
                    </div>

                    <hr>

                    <div class="mb-3">
                        <h6 class="text-muted mb-2"><i class="bi bi-cart"></i> Menu yang Dipesan</h6>
                        <div class="alert alert-light border">
                            {{ $transaction->keterangan }}
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-muted mb-2"><i class="bi bi-credit-card"></i> Metode Pembayaran</h6>
                            @if($transaction->metode_pembayaran == 'cod')
                                <span class="badge bg-warning text-dark fs-6">
                                    <i class="bi bi-cash"></i> Bayar di Tempat (Cash)
                                </span>
                            @else
                                <span class="badge bg-info fs-6">
                                    <i class="bi bi-credit-card"></i> Non-tunai / Transfer
                                </span>
                            @endif
                        </div>
                        <div class="col-md-6 text-end">
                            <h6 class="text-muted mb-2">Total Pembayaran</h6>
                            <h2 class="text-success fw-bold mb-0">
                                Rp {{ number_format($transaction->subtotal, 0, ',', '.') }}
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Info Tambahan -->
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="bi bi-info-circle"></i> Informasi Order</h5>
                </div>
                <div class="card-body">
                    @if($transaction->order)
                        <div class="mb-3">
                            <small class="text-muted">Order ID</small>
                            <h5>#{{ $transaction->order->id }}</h5>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">Status Order</small>
                            <br>
                            <span class="badge bg-success">Selesai</span>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">Dibuat pada</small>
                            <p class="mb-0">{{ $transaction->order->created_at->format('d M Y, H:i') }} WIB</p>
                        </div>
                        <hr>
                        <a href="{{ route('admin.orders.show', $transaction->order->id) }}" class="btn btn-sm btn-outline-primary w-100">
                            <i class="bi bi-box-arrow-up-right"></i> Lihat Order Asli
                        </a>
                    @else
                        <p class="text-muted mb-0">Order terkait tidak ditemukan</p>
                    @endif
                </div>
            </div>

            <!-- Aksi -->
            <div class="card shadow-sm">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0"><i class="bi bi-exclamation-triangle"></i> Aksi</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.transactions.destroy', $transaction->id) }}" 
                          method="POST" 
                          onsubmit="return confirm('⚠️ Yakin ingin menghapus transaksi ini? Tindakan ini tidak dapat dibatalkan!')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="bi bi-trash"></i> Hapus Transaksi
                        </button>
                    </form>
                    <small class="text-muted d-block mt-2">
                        * Menghapus transaksi tidak akan mempengaruhi order asli
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    @media print {
        .btn, .card-header, nav, aside {
            display: none !important;
        }
        .card {
            border: 1px solid #ddd !important;
            box-shadow: none !important;
        }
    }
</style>
@endpush
@endsection