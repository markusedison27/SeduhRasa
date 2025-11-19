@extends('layouts.app')

@section('title', 'Keuangan Pemilik')
@section('page-title', 'Keuangan Pemilik')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Keuangan Pemilik Coffee Shop</h1>
            <p class="text-muted mb-0">
                Ringkasan pemasukan dan pengeluaran kedai kopi kamu.
            </p>
        </div>
        <a href="{{ route('owner.dashboard') }}" class="btn btn-outline-secondary btn-sm">
            Kembali ke Dashboard
        </a>
    </div>

    {{-- Ringkasan angka --}}
    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h6 class="text-muted text-uppercase small mb-2">Total Pemasukan</h6>
                    <div class="h3 mb-1">
                        Rp {{ number_format($totalPemasukan, 0, ',', '.') }}
                    </div>
                    <p class="text-muted mb-0 small">
                        Total omzet dari transaksi penjualan yang tercatat di sistem.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h6 class="text-muted text-uppercase small mb-2">Total Pengeluaran</h6>
                    <div class="h3 mb-1">
                        Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}
                    </div>
                    <p class="text-muted mb-0 small">
                        Biaya bahan baku, gaji, dan pengeluaran operasional lainnya.
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel pemasukan & pengeluaran --}}
    <div class="row g-3">
        {{-- Pemasukan --}}
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Daftar Pemasukan Terbaru</h5>
                    {{-- nanti bisa tambahkan filter tanggal di sini --}}
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0 table-sm align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Tanggal</th>
                                    <th>Kode / Ref</th>
                                    <th class="text-end">Nominal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($daftarPemasukan as $i => $trx)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td>{{ $trx->created_at->format('d/m/Y') }}</td>
                                        <td>{{ $trx->kode ?? $trx->id }}</td>
                                        <td class="text-end">
                                            Rp {{ number_format($trx->total_harga, 0, ',', '.') }}
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
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Daftar Pengeluaran Terbaru</h5>
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
                                        <td>{{ $out->tanggal->format('d/m/Y') }}</td>
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
@endsection