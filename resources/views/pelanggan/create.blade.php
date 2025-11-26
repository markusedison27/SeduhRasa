@extends('layouts.app')

@section('title', 'Tambah Pelanggan')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12 col-xl-6 mx-auto">
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-header bg-white border-0 pt-3 pb-2 px-4">
                        <h5 class="mb-0">Tambah Pelanggan</h5>
                        <small class="text-muted">Isi data pelanggan baru dengan lengkap.</small>
                    </div>

                    <div class="card-body px-4 pb-4">
                        <form action="{{ route('admin.pelanggan.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Nama</label>
                                <input type="text"
                                       name="nama"
                                       class="form-control"
                                       value="{{ old('nama') }}"
                                       placeholder="Masukkan nama pelanggan"
                                       required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email"
                                       name="email"
                                       class="form-control"
                                       value="{{ old('email') }}"
                                       placeholder="Opsional">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Telepon</label>
                                <input type="text"
                                       name="telepon"
                                       class="form-control"
                                       value="{{ old('telepon') }}"
                                       placeholder="Opsional">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Alamat</label>
                                <textarea name="alamat"
                                          class="form-control"
                                          rows="3"
                                          placeholder="Opsional">{{ old('alamat') }}</textarea>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('admin.pelanggan.index') }}" class="btn btn-outline-secondary">
                                    Batal
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
