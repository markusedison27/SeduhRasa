@extends('layouts.app') 

@section('title', 'Manajemen Menu') 
@section('content')

    <div class="container-fluid" style="padding-top: 20px;">
        <h3>Manajemen Daftar Menu</h3>
        
        {{-- Menggunakan route('menus.create') dari Route::resource --}}
        <a href="{{ route('menus.create') }}" class="btn btn-primary mb-3">
            Tambah Menu Baru
        </a>

        <div class="card">
            <div class="card-body">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Menu</th>
                            <th>Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="4" class="text-center">
                                Data Menu belum tersedia.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection