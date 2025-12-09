@extends('layouts.dashboard')

@section('title', 'Data Pengeluaran Bahan Baku')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Data Pengeluaran Bahan Baku</h5>
                    <a href="{{ route('admin.pengeluaran.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Tambah Pengeluaran
                    </a>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mx-4 mt-3" role="alert">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Total Pengeluaran -->
                <div class="card-body pt-0">
                    <div class="alert alert-info">
                        <h6 class="mb-0">
                            <i class="fas fa-calculator"></i> Total Pengeluaran Bahan Baku: 
                            <strong>Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</strong>
                        </h6>
                    </div>
                </div>

                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kategori</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama Barang</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Harga</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pengeluarans as $index => $pengeluaran)
                                    <tr>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0 ms-3">
                                                {{ $pengeluarans->firstItem() + $index }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $pengeluaran->tanggal->format('d/m/Y') }}
                                            </p>
                                        </td>
                                        <td>
                                            <span class="badge badge-sm bg-gradient-info">
                                                {{ $pengeluaran->kategori }}
                                            </span>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $pengeluaran->keterangan }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0 text-danger">
                                                Rp {{ number_format($pengeluaran->nominal, 0, ',', '.') }}
                                            </p>
                                        </td>
                                        <td class="align-middle text-center">
                                            <a href="{{ route('admin.pengeluaran.edit', $pengeluaran->id) }}" 
                                               class="btn btn-link text-warning px-3 mb-0">
                                                <i class="fas fa-pencil-alt text-warning me-2"></i>Edit
                                            </a>
                                            <form action="{{ route('admin.pengeluaran.destroy', $pengeluaran->id) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Yakin ingin menghapus pengeluaran ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link text-danger px-3 mb-0">
                                                    <i class="far fa-trash-alt me-2"></i>Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            <i class="fas fa-inbox fa-3x text-secondary mb-3"></i>
                                            <p class="text-secondary mb-0">Belum ada data pengeluaran</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination -->
                @if($pengeluarans->hasPages())
                    <div class="card-footer">
                        {{ $pengeluarans->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection