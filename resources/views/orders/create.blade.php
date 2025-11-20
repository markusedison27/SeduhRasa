@extends('layouts.frontend') {{-- atau layouts.public / app, sesuaikan --}}

@section('title', 'Data Pembeli')

@section('content')
<div class="container py-5">
    <div class="mb-3">
        <a href="{{ route('home') }}" class="text-decoration-none">&larr; Kembali ke Beranda</a>
    </div>

    <div class="p-4 rounded-4 bg-light">
        <h3 class="fw-semibold mb-2 text-center">Data Pembeli</h3>
        <p class="text-muted text-center mb-4">
            Lengkapi informasi di bawah ini untuk melanjutkan ke halaman pilih menu.
        </p>

        <form action="{{ route('orders.store') }}" method="POST">
            @csrf

            <div class="row g-3">
                {{-- Nama Lengkap --}}
                <div class="col-md-4">
                    <label for="nama_pelanggan" class="form-label fw-semibold">Nama Lengkap</label>
                    <input type="text" name="nama_pelanggan" id="nama_pelanggan"
                           class="form-control @error('nama_pelanggan') is-invalid @enderror"
                           placeholder="Masukkan nama lengkap" value="{{ old('nama_pelanggan') }}">
                    <small class="text-muted">Sesuai dengan identitas atau nama akunmu</small>
                    @error('nama_pelanggan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="col-md-4">
                    <label for="email" class="form-label fw-semibold">Email</label>
                    <input type="email" name="email" id="email"
                           class="form-control @error('email') is-invalid @enderror"
                           placeholder="nama@email.com" value="{{ old('email') }}">
                    <small class="text-muted">Digunakan untuk konfirmasi pesanan</small>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- No Telepon --}}
                <div class="col-md-4">
                    <label for="no_telepon" class="form-label fw-semibold">No. Telepon</label>
                    <input type="text" name="no_telepon" id="no_telepon"
                           class="form-control @error('no_telepon') is-invalid @enderror"
                           placeholder="08xxxxxxxxxx" value="{{ old('no_telepon') }}">
                    <small class="text-muted">Pastikan nomor aktif untuk kontak pengiriman</small>
                    @error('no_telepon')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- PILIH MEJA --}}
                <div class="col-md-4 mt-3">
                    <label for="no_meja" class="form-label fw-semibold">Pilih Meja</label>
                    <select name="no_meja" id="no_meja"
                            class="form-control @error('no_meja') is-invalid @enderror">
                        <option value="">Pilih Meja</option>
                        <option value="1" {{ old('no_meja') == '1' ? 'selected' : '' }}>Meja 1</option>
                        <option value="2" {{ old('no_meja') == '2' ? 'selected' : '' }}>Meja 2</option>
                        <option value="3" {{ old('no_meja') == '3' ? 'selected' : '' }}>Meja 3</option>
                        <option value="4" {{ old('no_meja') == '4' ? 'selected' : '' }}>Meja 4</option>
                        <option value="5" {{ old('no_meja') == '5' ? 'selected' : '' }}>Meja 5</option>
                        {{-- tambah lagi kalau meja-nya banyak --}}
                    </select>
                    <small class="text-muted">Pilih nomor meja kamu (kalau dine-in).</small>
                    @error('no_meja')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-warning px-5 py-2 fw-semibold">
                    Lanjut ke Pilih Menu
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
