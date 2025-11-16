@extends('layouts.app')

@section('title', 'Detail Order #'.$order->id)

@section('content')
<style>
    .order-detail-bg{
        background: radial-gradient(circle at top left, rgba(255,193,7,.05), transparent 55%);
    }
    .card-soft{
        border-radius: 18px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 12px 35px rgba(15,23,42,.06);
    }
    .badge-status-pill{
        border-radius: 999px;
        font-size: .78rem;
        padding: .3rem .9rem;
    }
    .meta-label{
        font-size: .8rem;
        text-transform: uppercase;
        letter-spacing: .08em;
        color: #94a3b8;
    }
</style>

{{-- konten di-tengah dengan width lebih sempit --}}
<div class="order-detail-bg py-4">
    <div class="container py-3">

        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8 col-xl-7">

                <div class="card card-soft border-0">
                    <div class="card-body p-4 p-md-5">

                        {{-- header --}}
                        <div class="d-flex flex-wrap justify-content-between align-items-start mb-3">
                            <div class="mb-2">
                                <div class="meta-label mb-1">Detail Order</div>
                                <h4 class="mb-1 fw-semibold">Order #{{ $order->id }}</h4>
                                <div class="text-muted small">
                                    Dipesan pada {{ $order->created_at->format('d M Y H:i') }} WIB
                                </div>
                            </div>

                            @php
                                $status = strtolower($order->status);
                                $badgeClass = match ($status) {
                                    'pending'  => 'bg-warning-subtle text-warning-emphasis',
                                    'proses'   => 'bg-info-subtle text-info-emphasis',
                                    'selesai'  => 'bg-success-subtle text-success-emphasis',
                                    'batal'    => 'bg-danger-subtle text-danger-emphasis',
                                    default    => 'bg-secondary-subtle text-secondary-emphasis',
                                };
                            @endphp

                            <div class="mb-2 text-end">
                                <span class="badge badge-status-pill {{ $badgeClass }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                        </div>

                        @if (session('success'))
                            <div class="alert alert-success small">
                                {{ session('success') }}
                            </div>
                        @endif

                        {{-- info pelanggan + ringkasan --}}
                        <div class="mb-4">
                            <div class="meta-label mb-1">Informasi Pelanggan</div>
                            <h5 class="fw-semibold mb-3">{{ $order->nama_pelanggan }}</h5>

                            <div class="row g-3">
                                <div class="col-sm-4">
                                    <div class="meta-label mb-1">Jumlah Item</div>
                                    <div class="fw-semibold">{{ $order->jumlah }} item</div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="meta-label mb-1">Total</div>
                                    <div class="fw-semibold">
                                        Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="meta-label mb-1">Metode Bayar</div>
                                    <div class="fw-semibold">
                                        {{ $order->metode_pembayaran === 'transfer'
                                            ? 'Transfer / Virtual Account'
                                            : 'Bayar di Tempat (kasir)' }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        {{-- menu dipesan --}}
                        <div class="mt-3 mb-4">
                            <div class="meta-label mb-1">Menu Dipesan</div>
                            <p class="small mb-0 text-muted">
                                {{ $order->menu_dipesan }}
                            </p>
                        </div>

                        <hr>

                        {{-- status + form ubah status --}}
                        <div class="mt-3">
                            <div class="meta-label mb-2">Status Order</div>

                            <p class="small text-muted mb-3">
                                @if ($order->status === 'pending')
                                    Pesanan menunggu konfirmasi admin. Pilih <strong>Diproses</strong> bila pesanan mulai dibuat.
                                @elseif ($order->status === 'proses')
                                    Pesanan sedang disiapkan oleh barista / dapur. Tandai <strong>Selesai</strong> setelah siap.
                                @elseif ($order->status === 'selesai')
                                    Pesanan sudah selesai. Pelanggan bisa mengambil / melakukan pembayaran.
                                @elseif ($order->status === 'batal')
                                    Pesanan ini telah dibatalkan.
                                @endif
                            </p>

                            <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="mb-3">
                                @csrf
                                @method('PATCH')

                                <div class="mb-3">
                                    <label class="form-label small mb-1">Ubah Status</label>
                                    <select name="status" class="form-select form-select-sm" required>
                                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="proses"  {{ $order->status === 'proses'  ? 'selected' : '' }}>Diproses</option>
                                        <option value="selesai" {{ $order->status === 'selesai' ? 'selected' : '' }}>Selesai</option>
                                        <option value="batal"   {{ $order->status === 'batal'   ? 'selected' : '' }}>Batal</option>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary btn-sm">
                                    Simpan Status
                                </button>
                            </form>
                        </div>

                        <hr>

                        {{-- hapus order --}}
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('admin.orders.index') }}" class="btn btn-link btn-sm text-muted">
                                &larr; Kembali ke daftar order
                            </a>

                            <form action="{{ route('admin.orders.destroy', $order) }}"
                                  method="POST"
                                  onsubmit="return confirm('Hapus order ini?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-outline-danger btn-sm" type="submit">
                                    Hapus Order
                                </button>
                            </form>
                        </div>

                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection
