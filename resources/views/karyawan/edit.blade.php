@extends('layouts.app')

@section('title', 'Edit Karyawan')

@section('content')
<div class="main-content">
    <div class="page-header">
        <h1>✏️ Edit Karyawan</h1>
    </div>

    <div class="form-container">
        <form action="{{ route('admin.karyawan.update', $karyawan->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="nama">Nama Lengkap *</label>
                <input type="text" name="nama" id="nama" class="form-control" 
                       value="{{ old('nama', $karyawan->nama) }}" required>
                @error('nama')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="jabatan">Jabatan *</label>
                <select name="jabatan" id="jabatan" class="form-control" required>
                    <option value="">-- Pilih Jabatan --</option>
                    <option value="Manajer" {{ old('jabatan', $karyawan->jabatan) == 'Manajer' ? 'selected' : '' }}>
                        Manajer
                    </option>
                    <option value="Kasir" {{ old('jabatan', $karyawan->jabatan) == 'Kasir' ? 'selected' : '' }}>
                        Kasir
                    </option>
                    <option value="Barista" {{ old('jabatan', $karyawan->jabatan) == 'Barista' ? 'selected' : '' }}>
                        Barista
                    </option>
                </select>
                @error('jabatan')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email *</label>
                <input type="email" name="email" id="email" class="form-control" 
                       value="{{ old('email', $karyawan->email) }}" required>
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="telepon">No. Telepon</label>
                <input type="text" name="telepon" id="telepon" class="form-control" 
                       value="{{ old('telepon', $karyawan->telepon) }}">
                @error('telepon')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="alamat">Alamat</label>
                <textarea name="alamat" id="alamat" class="form-control" rows="3">{{ old('alamat', $karyawan->alamat) }}</textarea>
                @error('alamat')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    💾 Update Karyawan
                </button>
                <a href="{{ route('admin.karyawan.index') }}" class="btn btn-secondary">
                    ❌ Batal
                </a>
            </div>
        </form>
    </div>
</div>

<style>
.main-content {
    padding: 30px;
}

.page-header {
    margin-bottom: 30px;
}

.page-header h1 {
    font-size: 28px;
    color: #2C2C2C;
}

.form-container {
    max-width: 700px;
    background: white;
    padding: 40px;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.form-group {
    margin-bottom: 25px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: #333;
    font-size: 14px;
}

.form-control {
    width: 100%;
    padding: 12px 15px;
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    font-size: 14px;
    transition: all 0.3s;
}

.form-control:focus {
    outline: none;
    border-color: #FF6B35;
    box-shadow: 0 0 0 4px rgba(255, 107, 53, 0.1);
}

.text-danger {
    color: #dc3545;
    font-size: 13px;
    display: block;
    margin-top: 5px;
}

.form-actions {
    display: flex;
    gap: 15px;
    margin-top: 35px;
}

.btn {
    padding: 14px 28px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
    font-size: 15px;
    text-decoration: none;
    display: inline-block;
    transition: all 0.3s;
}

.btn-primary {
    background: linear-gradient(135deg, #FF6B35 0%, #F7931E 100%);
    color: white;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(255, 107, 53, 0.3);
}

.btn-secondary {
    background: #6c757d;
    color: white;
}

.btn-secondary:hover {
    background: #5a6268;
}
</style>
@endsection