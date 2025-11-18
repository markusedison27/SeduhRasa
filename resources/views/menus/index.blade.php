@extends('layouts.app')

@section('title','Tambah Menu')
@section('page-title','Tambah Menu')

@section('content')
<div class="max-w-xl">
    <form action="{{ route('admin.menus.store') }}" 
          method="POST"
          enctype="multipart/form-data" 
          class="space-y-4">

        @csrf

        {{-- Nama Menu --}}
        <div>
            <label class="block text-sm mb-1">Nama Menu</label>
            <input 
                name="nama_menu" 
                class="w-full border rounded px-3 py-2" 
                required
            >
        </div>

        {{-- Kategori --}}
        <div>
            <label class="block text-sm mb-1">Kategori</label>
            <select name="kategori" class="w-full border rounded px-3 py-2" required>
                <option value="">-- Pilih Kategori --</option>
                <option value="Mocktail & Tea">Mocktail & Tea</option>
                <option value="Coffee">Coffee</option>
                <option value="Desserts">Desserts</option>
                <option value="Kitchen Menu">Kitchen Menu</option>
                <option value="Cemilan">Cemilan</option>
                <option value="Dimsum">Dimsum</option>
                <option value="Mie">Mie</option>
            </select>
        </div>

        {{-- Harga --}}
        <div>
            <label class="block text-sm mb-1">Harga</label>
            <input 
                type="number" 
                name="harga" 
                class="w-full border rounded px-3 py-2" 
                required
            >
        </div>

        {{-- Suhu --}}
        <div>
            <label class="block text-sm mb-1">Suhu</label>
            <select name="suhu" class="w-full border rounded px-3 py-2">
                <option value="">Tidak Ada</option>
                <option value="Dingin">Dingin</option>
                <option value="Panas">Panas</option>
            </select>
        </div>

        {{-- Upload Gambar --}}
        <div>
            <label class="block text-sm mb-1">Gambar Menu</label>
            <input 
                type="file" 
                name="gambar" 
                class="w-full border rounded px-3 py-2"
            >
        </div>

        {{-- Tombol --}}
        <div class="flex items-center gap-2">
            <button class="px-4 py-2 rounded bg-amber-600 text-white">
                Simpan
            </button>

            <a href="{{ route('admin.menus.index') }}" 
               class="px-4 py-2 rounded border">
                Batal
            </a>
        </div>

    </form>
</div>
@endsection
