@extends('layouts.app') 

@section('title', 'Manajemen Karyawan') 

@section('content')
    <div class="container-fluid" style="padding-top: 20px;">
        <h3>Daftar Karyawan</h3>
        
        <a href="{{ route('karyawan.create') }}" class="btn btn-primary mb-3">
            Tambah Karyawan Baru
        </a>

        <div class="card">
            <div class="card-body">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Jabatan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="5" class="text-center">
                                Data Karyawan belum tersedia.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection