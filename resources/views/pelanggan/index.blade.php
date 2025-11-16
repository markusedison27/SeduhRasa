@extends('layouts.app')

@section('title', 'Manajemen Pelanggan')

@section('content')
    <div class="container-fluid" style="padding-top: 20px;">
        <h3>Daftar Pelanggan</h3>
        
        {{-- pakai nama route yang benar: admin.pelanggan.create --}}
        <a href="{{ route('admin.pelanggan.create') }}" class="btn btn-primary mb-3">
            Tambah Pelanggan Baru
        </a>

        <div class="card">
            <div class="card-body">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Email/Telepon</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- nanti di-loop dari database, sementara placeholder dulu --}}
                        <tr>
                            <td colspan="5" class="text-center">
                                Data Pelanggan belum tersedia.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
