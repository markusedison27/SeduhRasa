@extends('layouts.app') 

@section('title', 'Manajemen Transaksi') 

@section('content')
    <div class="container-fluid" style="padding-top: 20px;">
        <h3>Daftar Transaksi</h3>
        
        <a href="{{ route('transaksi.create') }}" class="btn btn-primary mb-3">
            Tambah Transaksi Baru
        </a>

        <div class="card">
            <div class="card-body">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tanggal</th>
                            <th>Pelanggan</th>
                            <th>Total Bayar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="5" class="text-center">
                                Data Transaksi belum tersedia.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection