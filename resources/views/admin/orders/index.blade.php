@extends('layouts.app')

@section('title', 'Manajemen Order')

@section('content')
    <style>
        .orders-wrapper-bg{
            background: radial-gradient(circle at top left, rgba(255,193,7,.06), transparent 55%);
        }
        .order-card{
            border-radius: 16px;
            border: 1px solid #f1f5f9;
            box-shadow: 0 10px 30px rgba(15,23,42,.05);
            transition: transform .12s ease, box-shadow .12s ease, border-color .12s ease;
        }
        .order-card:hover{
            transform: translateY(-2px);
            border-color: #e5e7eb;
            box-shadow: 0 14px 40px rgba(15,23,42,.08);
        }
        .order-id-pill{
            border-radius: 999px;
            padding: .20rem .7rem;
            background: #eef2ff;
            color: #4f46e5;
            font-size: .75rem;
            font-weight: 600;
        }
        .badge-status{
            border-radius: 999px;
            font-size: .7rem;
            padding: .25rem .7rem;
        }
        .pill-method{
            border-radius: 999px;
            font-size: .7rem;
            padding: .18rem .65rem;
            background: #f3f4f6;
            color: #6b7280;
        }
        .order-meta{
            font-size: .78rem;
        }
        /* tambahan untuk tampilan nomor meja */
        .meja-pill{
            border-radius: 999px;
            padding: .15rem .6rem;
            font-size: .72rem;
            font-weight: 600;
            background: #fff7ed;
            color: #ea580c;
            border: 1px solid #fed7aa;
        }
        .meja-pill-empty{
            background: #f3f4f6;
            color: #6b7280;
            border-color: #e5e7eb;
        }
    </style>

    <div class="container-fluid py-4 orders-wrapper-bg">
        <div class="d-flex flex-wrap justify-content-between align-items-start mb-4">
            <div class="mb-2">
                <h4 class="mb-1 fw-semibold">Daftar Order Masuk</h4>
                <p class="text-muted small mb-0">
                    Pantau semua pesanan pelanggan SeduhRasa dalam bentuk kartu.
                </p>
            </div>
            <div class="text-end small text-muted">
                Total order: <span class="fw-semibold">{{ $orders->total() }}</span>
            </div>
        </div>

        @if ($orders->count())
            <div class="row g-3 g-md-4">
                @foreach ($orders as $order)
                    @php
                        $status = strtolower($order->status);
                        $statusClass = match ($status) {
                            'pending'        => 'bg-warning-subtle text-warning-emphasis',
                            'proses'         => 'bg-info-subtle text-info-emphasis',
                            'selesai','paid' => 'bg-success-subtle text-success-emphasis',
                            'batal','cancel' => 'bg-danger-subtle text-danger-emphasis',
                            default          => 'bg-secondary-subtle text-secondary-emphasis',
                        };

                        $metode = strtolower($order->metode_pembayaran ?? 'cod');
                        $metodeLabel = $metode === 'transfer' ? 'Transfer / VA' : 'Bayar di Tempat';
                    @endphp

                    <div class="col-12 col-md-6 col-xl-4">
                        <div class="order-card h-100 p-3 p-md-3">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div class="d-flex flex-column gap-1">
                                    <span class="order-id-pill">#{{ $order->id }}</span>
                                    <span class="order-meta text-muted">
                                        {{ $order->created_at->format('d M Y') }} •
                                        {{ $order->created_at->format('H:i') }} WIB
                                    </span>
                                </div>
                                <span class="badge badge-status {{ $statusClass }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>

                            <div class="mb-2">
                                <div class="fw-semibold">
                                    {{ $order->nama_pelanggan }}
                                </div>
                                <div class="d-flex flex-wrap align-items-center gap-2">
                                    <div class="order-meta text-muted">
                                        {{ Str::limit($order->menu_dipesan, 60) }}
                                    </div>
                                    {{-- TAMPILKAN NOMOR MEJA --}}
                                    @if($order->no_meja)
                                        <span class="meja-pill">Meja {{ $order->no_meja }}</span>
                                    @else
                                        <span class="meja-pill meja-pill-empty">Belum pilih meja</span>
                                    @endif
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="order-meta text-muted">
                                    {{ $order->jumlah }} item<br>
                                    <span class="fw-semibold text-dark">
                                        Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                                    </span>
                                </div>
                                <div class="text-end">
                                    <div class="pill-method mb-1">
                                        {{ $metodeLabel }}
                                    </div>
                                    <div class="order-meta text-muted">
                                        @if(in_array($status, ['paid','selesai']))
                                            Lunas
                                        @else
                                            Menunggu pembayaran
                                        @endif
                                    </div>
                                </div>
                            </div>

                            {{-- FORM UBAH NOMOR MEJA UNTUK KASIR --}}
                            <div class="mb-3">
                                <form action="{{ route('admin.orders.updateStatus', $order) }}"
                                      method="POST"
                                      class="d-flex flex-wrap align-items-center gap-2">
                                    @csrf
                                    @method('PATCH')

                                    {{-- pakai status yang sekarang supaya cuma ganti meja --}}
                                    <input type="hidden" name="status" value="{{ $order->status }}">

                                    <label class="small text-muted mb-0 me-1">Meja:</label>
                                    <select name="no_meja" class="form-select form-select-sm w-auto">
                                        <option value="">- pilih -</option>
                                        @for ($i = 1; $i <= 10; $i++)
                                            <option value="{{ $i }}" {{ $order->no_meja == $i ? 'selected' : '' }}>
                                                Meja {{ $i }}
                                            </option>
                                        @endfor
                                    </select>

                                    <button type="submit" class="btn btn-sm btn-outline-primary">
                                        Simpan
                                    </button>
                                </form>
                            </div>

                            {{-- TOMBOL UBAH STATUS --}}
                            <div class="mb-3">
                                @if ($status === 'pending')
                                    <form action="{{ route('admin.orders.updateStatus', $order) }}"
                                          method="POST"
                                          class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="proses">
                                        {{-- kirim juga meja yang sudah terpilih supaya tidak hilang --}}
                                        <input type="hidden" name="no_meja" value="{{ $order->no_meja }}">
                                        <button type="submit"
                                                class="btn btn-sm btn-warning">
                                            Terima / Proses
                                        </button>
                                    </form>
                                @elseif ($status === 'proses')
                                    <form action="{{ route('admin.orders.updateStatus', $order) }}"
                                          method="POST"
                                          class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="selesai">
                                        <input type="hidden" name="no_meja" value="{{ $order->no_meja }}">
                                        <button type="submit"
                                                class="btn btn-sm btn-success">
                                            Tandai Selesai
                                        </button>
                                    </form>
                                @endif
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('admin.orders.show', $order) }}"
                                   class="btn btn-sm btn-outline-secondary">
                                    Detail
                                </a>

                                <form action="{{ route('admin.orders.destroy', $order) }}"
                                      method="POST"
                                      onsubmit="return confirm('Hapus order #{{ $order->id }} ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-sm btn-outline-danger">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if ($orders->hasPages())
                <div class="mt-4 d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <div class="small text-muted">
                        Menampilkan {{ $orders->firstItem() }}–{{ $orders->lastItem() }}
                        dari {{ $orders->total() }} order
                    </div>
                    <div>
                        {{ $orders->links() }}
                    </div>
                </div>
            @endif
        @else
            <div class="text-center py-5">
                <h6 class="fw-semibold mb-1">Belum ada order masuk</h6>
                <p class="text-muted small mb-2">
                    Pesanan yang dibuat pelanggan akan muncul di sini dalam bentuk kartu.
                </p>
            </div>
        @endif
    </div>
@endsection
