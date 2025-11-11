@extends('layouts.app')

@section('title','Tambah Menu')
@section('page-title','Tambah Menu')

@section('content')
<div class="max-w-xl">
  <form action="{{ route('admin.menus.store') }}" method="POST" class="space-y-4">
    @csrf
    <div>
      <label class="block text-sm mb-1">Nama Menu</label>
      <input name="name" class="w-full border rounded px-3 py-2" required>
    </div>
    <div>
      <label class="block text-sm mb-1">Harga</label>
      <input name="price" class="w-full border rounded px-3 py-2" required>
    </div>
    <div class="flex items-center gap-2">
      <button class="px-4 py-2 rounded bg-amber-600 text-white">Simpan</button>
      <a href="{{ route('admin.menus.index') }}" class="px-4 py-2 rounded border">Batal</a>
    </div>
  </form>
</div>
@endsection
