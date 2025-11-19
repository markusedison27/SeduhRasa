@extends('layouts.app')

@section('title','Tambah Menu')
@section('page-title','Tambah Menu')

@section('content')
<div class="max-w-3xl">
  <section class="bg-white rounded-2xl shadow-soft border border-neutral-200">
    <div class="p-6 border-b border-neutral-100">
      <h2 class="text-lg font-semibold">Form Menu</h2>
      <p class="text-sm text-neutral-500 mt-1">Lengkapi detail menu baru untuk menambah ke daftar.</p>
    </div>

    <form class="p-6 space-y-5" action="{{ route('admin.menus.store') }}" method="POST" enctype="multipart/form-data">
      @csrf

      {{-- Nama Menu --}}
      <div>
        <label class="block text-sm font-medium text-neutral-700 mb-2">Nama Menu</label>
        <input type="text" name="nama_menu" placeholder="Contoh: Es Kopi Susu"
               class="w-full rounded-xl border-neutral-300 focus:border-brand-500 focus:ring-brand-500 placeholder:text-neutral-400"/>
      </div>

      {{-- Harga --}}
      <div>
        <label class="block text-sm font-medium text-neutral-700 mb-2">Harga</label>
        <div class="relative">
          <span class="absolute inset-y-0 left-0 grid place-items-center pl-4 pr-2 text-neutral-500">Rp</span>
          <input type="number" name="harga" min="0" step="1000" placeholder="25000"
                 class="w-full rounded-xl border-neutral-300 focus:border-brand-500 focus:ring-brand-500 pl-12 placeholder:text-neutral-400"/>
        </div>
      </div>

      {{-- Kategori --}}
      <div>
        <label class="block text-sm font-medium text-neutral-700 mb-2">Kategori</label>
        <input type="text" name="kategori" placeholder="Coffee / Non Coffee / Snack"
               class="w-full rounded-xl border-neutral-300 focus:border-brand-500 focus:ring-brand-500 placeholder:text-neutral-400"/>
      </div>

      {{-- Suhu --}}
      <div>
        <label class="block text-sm font-medium text-neutral-700 mb-2">Suhu</label>
        <input type="text" name="suhu" placeholder="Hot / Ice"
               class="w-full rounded-xl border-neutral-300 focus:border-brand-500 focus:ring-brand-500 placeholder:text-neutral-400"/>
      </div>

      {{-- Upload Gambar --}}
      <div>
        <label class="block text-sm font-medium text-neutral-700 mb-2">Gambar</label>
        <input type="file" name="gambar" class="w-full"/>
      </div>

      <div class="pt-2 flex flex-wrap gap-3">
        <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-brand-600 hover:bg-brand-700 text-white px-5 py-2.5 font-medium">Simpan</button>
        <a href="{{ route('admin.menus.index') }}" class="inline-flex items-center justify-center rounded-xl border border-neutral-300 hover:bg-neutral-50 px-5 py-2.5 font-medium">Batal</a>
      </div>
    </form>
  </section>
</div>
@endsection
