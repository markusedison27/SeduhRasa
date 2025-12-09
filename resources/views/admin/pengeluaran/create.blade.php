@extends('layouts.app')

@section('title', 'Tambah Pengeluaran Bahan Baku')

@section('content')
<style>
    .form-panel {
        background: #ffffff;
        border: 1px solid #e0e0e0;
        border-radius: 4px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.04);
        padding: 18px 22px;
        font-size: 14px;
    }
    .form-panel h5 {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 16px;
    }
    .form-label {
        font-weight: 500;
    }
</style>

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-7 col-md-8">

            <div class="form-panel">

                <h5>Tambah Pengeluaran Bahan Baku</h5>

                <form action="{{ route('admin.pengeluaran.store') }}" method="POST">
                    @csrf

                    {{-- TANGGAL --}}
                    <div class="mb-3">
                        <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                        <input type="date"
                               name="tanggal"
                               class="form-control @error('tanggal') is-invalid @enderror"
                               value="{{ old('tanggal', date('Y-m-d')) }}"
                               required>
                        @error('tanggal')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- KATEGORI (READONLY) --}}
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <input type="text"
                               class="form-control"
                               value="Bahan Baku"
                               disabled>
                        <small class="text-muted">Kategori dikunci sebagai Bahan Baku.</small>
                    </div>

                    {{-- NAMA BARANG --}}
                    <div class="mb-3">
                        <label class="form-label">Nama Barang <span class="text-danger">*</span></label>
                        <input type="text"
                               name="keterangan"
                               class="form-control @error('keterangan') is-invalid @enderror"
                               placeholder="Contoh: Kopi Arabica 1kg"
                               value="{{ old('keterangan') }}"
                               required>
                        @error('keterangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- HARGA --}}
                    <div class="mb-3">
                        <label class="form-label">Harga (Rp) <span class="text-danger">*</span></label>
                        <input type="number"
                               name="nominal"
                               class="form-control @error('nominal') is-invalid @enderror"
                               placeholder="Contoh: 12000"
                               min="0"
                               step="1"
                               value="{{ old('nominal') }}"
                               required>
                        @error('nominal')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Masukkan angka tanpa titik/koma.</small>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-3">
                        <a href="{{ route('admin.pengeluaran.index') }}" class="btn btn-secondary">
                            Batal
                        </a>
                        {{-- pakai btn-primary biar nyatu sama tema --}}
                        <button type="submit" class="btn btn-primary">
                            Simpan
                        </button>
                    </div>

                </form>

            </div>

        </div>
    </div>
</div>
@endsection
