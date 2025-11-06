@extends('layouts.app') 

@section('title', 'Manajemen Order') 

@section('content')
    <div class="container-fluid" style="padding-top: 20px;">
        <h3>Daftar Order Masuk</h3>
        
        {{-- Order biasanya tidak dibuat melalui tombol create admin, melainkan dari form pelanggan --}}
        {{-- Namun, route create tetap ada jika diperlukan --}}
        <a href="{{ route('orders.create') }}" class="btn btn-primary mb-3">
            Buat Order Manual
        </a> 

        <div class="card">
            <div class="card-body">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID Order</th>
                            <th>Tanggal</th>
                            <th>Pelanggan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="5" class="text-center">
                                Data Order belum tersedia.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection