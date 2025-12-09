@extends('layouts.app')

@section('title', 'Edit Pengeluaran')

@section('content')
<div class="container py-4">
    <div class="col-lg-8 mx-auto">

        <div class="card shadow">
            <div class="card-header bg-gradient-warning text-white">
                <h5 class="mb-0">Edit Pengeluaran</h5>
            </div>

            <div class="card-body">
                <form action="{{ route('admin.pengeluaran.update', $pengeluaran->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Tanggal</label>
                        <input type="date" name="tanggal" class="form-control"
                               value="{{ $pengeluaran->tanggal->format('Y-m-d') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <input type="text" class="form-control" value="Bahan Baku" disabled>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama Barang</label>
                        <input type="text" name="keterangan" class="form-control"
                               value="{{ $pengeluaran->keterangan }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Harga (Rp)</label>
                        <input type="number" name="nominal" class="form-control"
                               value="{{ $pengeluaran->nominal }}" required>
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('admin.pengeluaran.index') }}" class="btn btn-secondary me-2">Batal</a>
                        <button class="btn btn-warning text-white">Update</button>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>
@endsection
