@extends('layouts.app')

@section('title', 'Riwayat Order')

@section('content')
    <div class="container py-4">
        <h4 class="mb-3 fw-semibold">Riwayat Order Kamu</h4>

        @if ($orders->count())
            <div class="table-responsive">
                <table class="table table-sm align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tanggal</th>
                            <th>Nama</th>
                            <th>Status</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $o)
                            <tr>
                                <td>#{{ $o->id }}</td>
                                <td>{{ $o->created_at->format('d M Y H:i') }}</td>
                                <td>{{ $o->nama_pelanggan }}</td>
                                <td>{{ ucfirst($o->status) }}</td>
                                <td>Rp {{ number_format($o->total_harga, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($orders->hasPages())
                <div class="mt-3">
                    {{ $orders->links() }}
                </div>
            @endif
        @else
            <p class="text-muted">Belum ada order.</p>
        @endif
    </div>
@endsection
