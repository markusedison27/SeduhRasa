@extends('layouts.app')

@section('title', 'Manajemen Pelanggan')

@section('content')
    <div class="container-fluid py-4 pelanggan-page">
        <div class="row">
            <div class="col-12 col-xl-10 mx-auto">

                {{-- Alert sukses --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                    </div>
                @endif

                {{-- HEADER + SEARCH + BUTTON --}}
                <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-3">
                    <div>
                        <h4 class="fw-semibold mb-1 text-coffee-dark">Manajemen Pelanggan</h4>
                        <p class="text-muted mb-0 small">
                            Kelola data pelanggan yang terdaftar di SeduhRasa.
                        </p>
                    </div>

                    <div class="d-flex flex-column flex-sm-row gap-2 align-items-stretch">
                        {{-- Form search --}}
                        <form action="{{ route('admin.pelanggan.index') }}" method="GET" class="w-100 w-sm-auto">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-coffee-soft border-0">
                                    🔍
                                </span>
                                <input type="text"
                                       name="q"
                                       value="{{ request('q') }}"
                                       class="form-control border-0 bg-coffee-soft"
                                       placeholder="Cari nama / email / telepon">
                                <button class="btn btn-coffee" type="submit">
                                    Cari
                                </button>
                            </div>
                        </form>

                        {{-- Tombol tambah --}}
                        <a href="{{ route('admin.pelanggan.create') }}"
                           class="btn btn-coffee-dark btn-sm d-flex align-items-center justify-content-center px-3">
                            + Tambah Pelanggan
                        </a>
                    </div>
                </div>

                {{-- KARTU STATISTIK SINGKAT --}}
                <div class="row g-3 mb-4">
                    <div class="col-sm-4">
                        <div class="stat-card shadow-sm">
                            <div class="stat-icon">
                                👥
                            </div>
                            <div class="stat-body">
                                <div class="stat-label">Total Pelanggan</div>
                                <div class="stat-value">
                                    {{ \App\Models\Pelanggan::count() }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="stat-card shadow-sm">
                            <div class="stat-icon">
                                ☕
                            </div>
                            <div class="stat-body">
                                <div class="stat-label">Pelanggan Terdaftar</div>
                                <div class="stat-value small">
                                    Data pelanggan yang pernah melakukan pemesanan.
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="stat-card shadow-sm">
                            <div class="stat-icon">
                                📅
                            </div>
                            <div class="stat-body">
                                <div class="stat-label">Terakhir Ditambahkan</div>
                                <div class="stat-value">
                                    @php
                                        $last = \App\Models\Pelanggan::latest()->first();
                                    @endphp
                                    {{ $last?->created_at?->format('d M Y') ?? '-' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- CARD TABEL PELANGGAN --}}
                <div class="card pelanggan-card shadow-sm border-0 rounded-3 overflow-hidden">
                    <div class="card-header border-0 py-3 px-4 bg-coffee-gradient text-white">
                        <span class="fw-semibold">Daftar Pelanggan</span>
                    </div>

                    @if ($pelanggans->count())
                        <div class="card-body px-0 pb-0 pt-0">
                            <div class="table-responsive">
                                <table class="table align-middle mb-0 pelanggan-table table-hover">
                                    <thead>
                                        <tr>
                                            <th class="small text-uppercase">ID</th>
                                            <th class="small text-uppercase">Nama</th>
                                            <th class="small text-uppercase">Kontak</th>
                                            <th class="small text-uppercase">Alamat</th>
                                            <th class="small text-uppercase text-end">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pelanggans as $pelanggan)
                                            <tr>
                                                <td class="fw-semibold text-muted">
                                                    #{{ str_pad($pelanggan->id, 4, '0', STR_PAD_LEFT) }}
                                                </td>
                                                <td>
                                                    <div class="fw-semibold text-coffee-dark">
                                                        {{ $pelanggan->nama }}
                                                    </div>
                                                    @if ($pelanggan->created_at)
                                                        <small class="text-muted d-block mt-1">
                                                            Bergabung: {{ $pelanggan->created_at->format('d M Y') }}
                                                        </small>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($pelanggan->email)
                                                        <div class="small">
                                                            {{ $pelanggan->email }}
                                                        </div>
                                                    @endif

                                                    @if ($pelanggan->telepon)
                                                        <div class="small text-muted">
                                                            {{ $pelanggan->telepon }}
                                                        </div>
                                                    @endif

                                                    @unless ($pelanggan->email || $pelanggan->telepon)
                                                        <span class="badge bg-light text-muted border small">
                                                            Belum ada kontak
                                                        </span>
                                                    @endunless
                                                </td>
                                                <td>
                                                    @if ($pelanggan->alamat)
                                                        <div class="small">{{ $pelanggan->alamat }}</div>
                                                    @else
                                                        <span class="badge bg-coffee-soft text-coffee-dark small">
                                                            Belum diisi
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="text-end">
                                                    <div class="btn-group btn-group-sm aksi-group" role="group">
                                                        <a href="{{ route('admin.pelanggan.edit', $pelanggan) }}"
                                                           class="btn btn-outline-coffee btn-sm">
                                                            Edit
                                                        </a>

                                                        <form action="{{ route('admin.pelanggan.destroy', $pelanggan) }}"
                                                              method="POST"
                                                              onsubmit="return confirm('Yakin ingin menghapus pelanggan ini?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                                                Hapus
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card-footer bg-white border-0 px-4 py-3 d-flex flex-wrap justify-content-between align-items-center gap-2">
                            <small class="text-muted">
                                Menampilkan {{ $pelanggans->firstItem() }}–{{ $pelanggans->lastItem() }}
                                dari {{ $pelanggans->total() }} pelanggan
                            </small>

                            <div>
                                {{ $pelanggans->links() }}
                            </div>
                        </div>
                    @else
                        <div class="card-body px-4 py-5 bg-coffee-soft text-center">
                            <div class="empty-state-icon mb-3">
                                👥
                            </div>
                            <h5 class="mb-2 fw-semibold text-coffee-dark">Belum ada pelanggan</h5>
                            <p class="text-muted mb-4">
                                Tambahkan pelanggan baru untuk mulai mencatat histori transaksi pelanggan di SeduhRasa.
                            </p>
                            <a href="{{ route('admin.pelanggan.create') }}" class="btn btn-coffee-dark">
                                + Tambah Pelanggan Pertama
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- STYLE KHUSUS HALAMAN PELANGGAN --}}
    <style>
        .text-coffee-dark {
            color: #4b2c22;
        }

        .bg-coffee-soft {
            background-color: #f6efe7;
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

        .btn-coffee-dark {
            background-color: #5b3724;
            border-color: #5b3724;
            color: #fff;
        }

        .btn-coffee-dark:hover {
            background-color: #4a2b1b;
            border-color: #4a2b1b;
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

        .bg-coffee-gradient {
            background: linear-gradient(90deg, #5b3724, #c38b5f);
        }

        /* --- TABEL PELANGGAN RAPI --- */
        .pelanggan-card .table {
            border-collapse: separate;
            border-spacing: 0;
            margin-bottom: 0;
        }

        .pelanggan-card thead th {
            border-bottom: 1px solid #e7d7c4;
            font-size: .75rem;
            letter-spacing: .08em;
            color: #7b7b7b;
            background-color: #f9f2ea;
            padding: .75rem 1.25rem;
        }

        .pelanggan-card tbody td {
            font-size: .88rem;
            border-top: 1px solid #f1e4d7;
            padding: .70rem 1.25rem;
        }

        .pelanggan-card tbody tr:first-child td {
            border-top: none;
        }

        .pelanggan-card .table-hover tbody tr:hover {
            background-color: #fdf7f0;
        }

        /* lebar kolom ID & Aksi */
        .pelanggan-card table th:nth-child(1),
        .pelanggan-card table td:nth-child(1) {
            width: 90px;
            white-space: nowrap;
        }

        .pelanggan-card table th:nth-child(5),
        .pelanggan-card table td:nth-child(5) {
            width: 150px;
            white-space: nowrap;
        }

        .aksi-group .btn {
            padding-inline: .55rem;
            font-size: .78rem;
        }

        .empty-state-icon {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: #fff;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            margin: 0 auto;
        }

        .stat-card {
            background-color: #fdf7f0;
            border-radius: 14px;
            padding: 12px 14px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .stat-icon {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: #5b3724;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .stat-body {
            flex: 1;
        }

        .stat-label {
            font-size: .78rem;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: #7b7b7b;
        }

        .stat-value {
            font-size: 1rem;
            font-weight: 600;
            color: #4b2c22;
        }
    </style>
@endsection
