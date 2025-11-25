@extends('layouts.app')

@section('title', 'Manajemen Karyawan')

@section('content')
<div class="main-content">
    <div class="page-header">
        <h1>👥 Daftar Karyawan</h1>
        {{-- tombol di pojok kanan atas --}}
        <a href="{{ route('owner.kasir.create') }}" class="btn btn-primary">
            ➕ Tambah Karyawan Baru
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            ✅ {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Jabatan</th>
                        <th>Email</th>
                        <th>Telepon</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($karyawan as $k)
                        <tr>
                            <td>{{ $k->id }}</td>
                            <td>{{ $k->nama }}</td>
                            <td>
                                <span class="badge badge-{{ $k->jabatan == 'Manajer' ? 'primary' : ($k->jabatan == 'Kasir' ? 'success' : 'info') }}">
                                    {{ $k->jabatan }}
                                </span>
                            </td>
                            <td>{{ $k->email }}</td>
                            <td>{{ $k->telepon ?? '-' }}</td>
                            <td class="action-buttons">
                                <a href="{{ route('admin.karyawan.edit', $k->id) }}" class="btn btn-sm btn-warning">
                                    ✏️ Edit
                                </a>
                                <form action="{{ route('admin.karyawan.destroy', $k->id) }}" method="POST" style="display:inline;" 
                                      onsubmit="return confirm('Yakin ingin menghapus karyawan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        🗑️ Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">
                                <div class="empty-state">
                                    <p>📋 Data Karyawan belum tersedia.</p>
                                    {{-- tombol di empty state --}}
                                    <a href="{{ route('owner.kasir.create') }}" class="btn btn-primary btn-sm">
                                        Tambah Karyawan Pertama
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
.main-content {
    padding: 30px;
}

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}

.page-header h1 {
    font-size: 28px;
    color: #2C2C2C;
    margin: 0;
}

.alert {
    padding: 15px 20px;
    border-radius: 8px;
    margin-bottom: 20px;
    animation: slideDown 0.3s ease;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.alert-success {
    background: #d4edda;
    border: 1px solid #c3e6cb;
    color: #155724;
}

.card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    overflow: hidden;
}

.card-body {
    padding: 0;
}

.table {
    width: 100%;
    margin: 0;
    border-collapse: collapse;
}

.table thead {
    background: linear-gradient(135deg, #FF6B35 0%, #F7931E 100%);
}

.table th {
    padding: 15px 20px;
    font-weight: 600;
    color: white;
    text-align: left;
    font-size: 14px;
}

.table td {
    padding: 15px 20px;
    border-bottom: 1px solid #dee2e6;
    vertical-align: middle;
}

.table tbody tr {
    transition: background 0.2s;
}

.table tbody tr:hover {
    background: #f8f9fa;
}

.table tbody tr:last-child td {
    border-bottom: none;
}

.badge {
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    display: inline-block;
}

.badge-primary { 
    background: #007bff; 
    color: white; 
}

.badge-success { 
    background: #28a745; 
    color: white; 
}

.badge-info { 
    background: #17a2b8; 
    color: white; 
}

.action-buttons {
    white-space: nowrap;
}

.btn {
    padding: 8px 16px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 600;
    font-size: 13px;
    text-decoration: none;
    display: inline-block;
    transition: all 0.3s;
    margin-right: 5px;
}

.btn-primary {
    background: linear-gradient(135deg, #FF6B35 0%, #F7931E 100%);
    color: white;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(255, 107, 53, 0.3);
}

.btn-sm {
    padding: 6px 12px;
    font-size: 12px;
}

.btn-warning {
    background: #ffc107;
    color: #333;
}

.btn-warning:hover {
    background: #e0a800;
    transform: translateY(-2px);
}

.btn-danger {
    background: #dc3545;
    color: white;
}

.btn-danger:hover {
    background: #c82333;
    transform: translateY(-2px);
}

.text-center {
    text-align: center;
}

.empty-state {
    padding: 40px 20px;
}

.empty-state p {
    font-size: 16px;
    color: #6c757d;
    margin-bottom: 15px;
}
</style>
@endsection
