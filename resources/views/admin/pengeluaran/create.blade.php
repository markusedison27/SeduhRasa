@extends('layouts.dashboard')

@section('title', 'Tambah Pengeluaran Bahan Baku')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex align-items-center">
                        <a href="{{ route('admin.pengeluaran.index') }}" class="btn btn-outline-secondary btn-sm me-3">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <h5 class="mb-0">Tambah Pengeluaran Bahan Baku</h5>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.pengeluaran.store') }}" method="POST">
                        @csrf

                        <!-- Tanggal -->
                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Tanggal <span class="text-danger">*</span></label>
                            <input type="date" 
                                   class="form-control @error('tanggal') is-invalid @enderror" 
                                   id="tanggal" 
                                   name="tanggal" 
                                   value="{{ old('tanggal', date('Y-m-d')) }}"
                                   required>
                            @error('tanggal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Kategori (Fixed) -->
                        <div class="mb-3">
                            <label for="kategori" class="form-label">Kategori</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="kategori" 
                                   value="Bahan Baku" 
                                   disabled>
                            <small class="text-muted">Kategori otomatis: Bahan Baku</small>
                        </div>

                        <!-- Nama Barang -->
                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Nama Barang <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('keterangan') is-invalid @enderror" 
                                   id="keterangan" 
                                   name="keterangan" 
                                   value="{{ old('keterangan') }}"
                                   placeholder="Contoh: Kopi Arabica 1kg"
                                   required>
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Harga -->
                        <div class="mb-3">
                            <label for="nominal" class="form-label">Harga (Rp) <span class="text-danger">*</span></label>
                            <input type="number" 
                                   class="form-control @error('nominal') is-invalid @enderror" 
                                   id="nominal" 
                                   name="nominal" 
                                   value="{{ old('nominal') }}"
                                   placeholder="Contoh: 150000"
                                   min="0"
                                   step="1"
                                   required>
                            @error('nominal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Masukkan harga dalam rupiah (tanpa titik/koma)</small>
                        </div>

                        <!-- Preview Harga -->
                        <div class="mb-3">
                            <div class="alert alert-light border">
                                <small class="text-muted">Preview Harga:</small>
                                <h6 class="mb-0 text-danger" id="previewHarga">Rp 0</h6>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.pengeluaran.index') }}" class="btn btn-secondary">
                                Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Format rupiah otomatis saat input
    const nominalInput = document.getElementById('nominal');
    const previewHarga = document.getElementById('previewHarga');

    nominalInput.addEventListener('input', function(e) {
        let value = this.value.replace(/[^0-9]/g, '');
        
        if (value === '') {
            previewHarga.textContent = 'Rp 0';
            return;
        }

        let formatted = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        }).format(value);

        previewHarga.textContent = formatted;
    });

    // Trigger saat halaman load (jika ada old value)
    if (nominalInput.value) {
        nominalInput.dispatchEvent(new Event('input'));
    }
</script>
@endpush
@endsection