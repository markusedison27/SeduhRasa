@extends('layouts.app')

@section('title','Tambah Menu')
@section('page-title','Tambah Menu')

@section('content')
<div class="max-w-4xl mx-auto">
  {{-- HEADER HALAMAN --}}
  <div class="mb-6 flex items-center justify-between gap-4">
    <div>
      <h2 class="text-xl font-semibold text-neutral-800">Tambah Menu Baru</h2>
      <p class="text-sm text-neutral-500 mt-1">
        Lengkapi detail menu untuk menambahkannya ke daftar menu kedai kopi kamu.
      </p>
    </div>

    <a href="{{ route('admin.menus.index') }}"
       class="hidden sm:inline-flex items-center rounded-full border border-neutral-300 px-4 py-2 text-sm font-medium text-neutral-700 hover:bg-neutral-50">
      Kembali ke daftar
    </a>
  </div>

  {{-- CARD FORM --}}
  <section class="bg-white rounded-2xl shadow-soft border border-neutral-200">
    <div class="px-6 py-4 border-b border-neutral-100">
      <h3 class="text-base font-semibold text-neutral-800">Form Menu</h3>
      <p class="text-xs sm:text-sm text-neutral-500 mt-1">
        Pastikan informasi yang diisi sudah benar sebelum disimpan.
      </p>
    </div>

    <form class="p-6 space-y-6" action="{{ route('admin.menus.store') }}" method="POST" enctype="multipart/form-data">
      @csrf

      {{-- GRID 2 KOLOM DI DESKTOP --}}
      <div class="grid md:grid-cols-2 md:gap-6 gap-5">
        {{-- Nama Menu --}}
        <div class="md:col-span-2">
          <label class="block text-sm font-medium text-neutral-700 mb-2">
            Nama Menu <span class="text-red-500">*</span>
          </label>
          <input
            type="text"
            name="nama_menu"
            value="{{ old('nama_menu') }}"
            placeholder="Contoh: Es Kopi Susu Gula Aren"
            class="w-full rounded-xl border border-neutral-300 focus:border-amber-500 focus:ring-amber-500 placeholder:text-neutral-400 text-sm px-3 py-2.5"
          />
          @error('nama_menu')
            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
          @enderror
        </div>

        {{-- Harga --}}
        <div>
          <label class="block text-sm font-medium text-neutral-700 mb-2">
            Harga <span class="text-red-500">*</span>
          </label>
          <div class="relative">
            <span class="absolute inset-y-0 left-0 grid place-items-center pl-3 pr-1 text-neutral-500 text-sm">Rp</span>
            <input
              type="number"
              name="harga"
              min="0"
              step="1000"
              value="{{ old('harga') }}"
              placeholder="15000"
              class="w-full rounded-xl border border-neutral-300 focus:border-amber-500 focus:ring-amber-500 pl-10 placeholder:text-neutral-400 text-sm px-3 py-2.5"
            />
          </div>
          @error('harga')
            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
          @enderror
        </div>

        {{-- ✅ STOK (BARU) --}}
        <div>
          <label class="block text-sm font-medium text-neutral-700 mb-2">
            Stok <span class="text-red-500">*</span>
          </label>
          <input
            type="number"
            name="stok"
            min="0"
            value="{{ old('stok', 0) }}"
            placeholder="100"
            class="w-full rounded-xl border border-neutral-300 focus:border-amber-500 focus:ring-amber-500 placeholder:text-neutral-400 text-sm px-3 py-2.5"
          />
          <p class="mt-1 text-xs text-neutral-500">Jumlah stok yang tersedia</p>
          @error('stok')
            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
          @enderror
        </div>

        {{-- Kategori --}}
        <div>
          <label class="block text-sm font-medium text-neutral-700 mb-2">
            Kategori
          </label>
          <select
            name="kategori"
            class="w-full rounded-xl border border-neutral-300 focus:border-amber-500 focus:ring-amber-500 text-sm px-3 py-2.5"
          >
            <option value="">-- Pilih Kategori --</option>
            <option value="Cemilan" {{ old('kategori') == 'Cemilan' ? 'selected' : '' }}>Cemilan</option>
            <option value="Mocktail & Tea" {{ old('kategori') == 'Mocktail & Tea' ? 'selected' : '' }}>Mocktail & Tea</option>
            <option value="Coffee" {{ old('kategori') == 'Coffee' ? 'selected' : '' }}>Coffee</option>
            <option value="Desserts" {{ old('kategori') == 'Desserts' ? 'selected' : '' }}>Desserts</option>
            <option value="Kitchen Menu" {{ old('kategori') == 'Kitchen Menu' ? 'selected' : '' }}>Kitchen Menu</option>
            <option value="Dimsum" {{ old('kategori') == 'Dimsum' ? 'selected' : '' }}>Dimsum</option>
            <option value="Mie" {{ old('kategori') == 'Mie' ? 'selected' : '' }}>Mie</option>
          </select>
          @error('kategori')
            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
          @enderror
        </div>

        {{-- Suhu --}}
        <div>
          <label class="block text-sm font-medium text-neutral-700 mb-2">
            Suhu
          </label>
          <input
            type="text"
            name="suhu"
            value="{{ old('suhu') }}"
            placeholder="Hot / Ice"
            class="w-full rounded-xl border border-neutral-300 focus:border-amber-500 focus:ring-amber-500 placeholder:text-neutral-400 text-sm px-3 py-2.5"
          />
          @error('suhu')
            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
          @enderror
        </div>
      </div>

      {{-- Gambar --}}
      <div>
        <label class="block text-sm font-medium text-neutral-700 mb-2">
          Gambar Menu
        </label>
        <div class="flex items-center gap-3">
          <label class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl border border-neutral-300 text-sm font-medium text-neutral-700 bg-neutral-50 hover:bg-neutral-100 cursor-pointer">
            Pilih File
            <input type="file" name="gambar" class="hidden" />
          </label>
          <span class="text-xs text-neutral-400">
            Format: JPG/PNG, sebaiknya rasio 1:1
          </span>
        </div>
        @error('gambar')
          <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
        @enderror
      </div>

      {{-- TOMBOL --}}
      <div class="pt-2 flex flex-wrap gap-3">
        <button type="submit"
          class="inline-flex items-center justify-center rounded-xl bg-amber-600 hover:bg-amber-700 text-white px-5 py-2.5 text-sm font-medium shadow-sm transition">
          Simpan
        </button>
        <a href="{{ route('admin.menus.index') }}"
          class="inline-flex items-center justify-center rounded-xl border border-neutral-300 hover:bg-neutral-50 px-5 py-2.5 text-sm font-medium text-neutral-700">
          Batal
        </a>
      </div>
    </form>
  </section>
</div>
@endsection