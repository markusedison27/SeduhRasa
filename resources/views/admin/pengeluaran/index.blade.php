@extends('layouts.app')

@section('title', 'Data Pengeluaran Bahan Baku')

@section('content')
<style>
    .panel-box {
        background: #ffffff;
        border: 1px solid #e0e0e0;
        border-radius: 4px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.04);
        padding: 16px 18px;
        font-size: 13px;
    }
    .panel-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }
    .panel-header h5 {
        margin: 0;
        font-size: 15px;
        font-weight: 600;
    }
    .btn-tambah {
        border-radius: 20px;
        padding: 6px 16px;
        font-size: 13px;
    }
    .dt-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin: 6px 0 8px;
    }
    .dt-toolbar select,
    .dt-toolbar input {
        font-size: 12px;
        height: 28px;
        padding: 2px 6px;
    }
    .dt-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }
    .dt-table th,
    .dt-table td {
        border: 1px solid #e0e0e0;
        padding: 6px 8px;
        vertical-align: middle;
    }
    .dt-table th {
        background: #f8f9fa;
        font-weight: 600;
    }
</style>

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-11">

            <div class="panel-box">

                <div class="panel-header">
                    <h5>Transaksi Pengeluaran</h5>

                    {{-- pakai btn-primary biar warnanya ikut tema web --}}
                    <a href="{{ route('admin.pengeluaran.create') }}" class="btn btn-primary btn-tambah">
                        Tambah Data
                    </a>
                </div>

                <div class="mb-2">
                    <strong>Total Pengeluaran :</strong>
                    Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}
                </div>

                <div class="dt-toolbar">
                    <div>
                        Show
                        <select>
                            <option>10</option>
                            <option>25</option>
                            <option>50</option>
                        </select>
                        entries
                    </div>

                    <div>
                        Search:
                        <input type="text" />
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="dt-table">
                        <thead>
                            <tr>
                                <th style="width: 45px;">No</th>
                                <th style="width: 120px;">Tanggal</th>
                                <th style="width: 140px;">Kategori</th>
                                <th>Nama Barang</th>
                                <th style="width: 140px;">Pengeluaran</th>
                                <th style="width: 110px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pengeluarans as $index => $p)
                                <tr>
                                    <td>{{ $pengeluarans->firstItem() + $index }}</td>
                                    <td>{{ $p->tanggal->format('Y-m-d') }}</td>
                                    <td>{{ $p->kategori }}</td>
                                    <td>{{ $p->keterangan }}</td>
                                    <td>Rp {{ number_format($p->nominal, 0, ',', '.') }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.pengeluaran.edit', $p->id) }}" 
                                           style="font-size:12px;" 
                                           class="btn btn-warning btn-sm text-white">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.pengeluaran.destroy', $p->id) }}"
                                              method="POST"
                                              style="display:inline"
                                              onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-danger btn-sm"
                                                    style="font-size:12px;">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-3">
                                        Belum ada data pengeluaran
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-2" style="font-size: 12px;">
                    <div>
                        @if($pengeluarans->total() > 0)
                            Menampilkan {{ $pengeluarans->firstItem() }}
                            sampai {{ $pengeluarans->lastItem() }}
                            dari {{ $pengeluarans->total() }} entri
                        @else
                            Tidak ada data untuk ditampilkan
                        @endif
                    </div>
                    <div>
                        {{ $pengeluarans->links() }}
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
@endsection
