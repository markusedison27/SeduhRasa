@extends('layouts.app')

@section('title', 'Daftar Menu')
@section('page-title', 'Daftar Menu')

@section('content')
<div class="max-w-6xl mx-auto">
  {{-- HEADER HALAMAN --}}
  <div class="mb-6 flex items-center justify-between gap-4">
    <div>
      <h2 class="text-xl font-semibold text-neutral-800">Daftar Menu</h2>
      <p class="text-sm text-neutral-500 mt-1">
        Kelola semua menu yang tersedia di kedai kopi kamu.
      </p>
    </div>

    <a href="{{ route('admin.menus.create') }}"
       class="inline-flex items-center rounded-xl bg-amber-600 hover:bg-amber-700 text-white px-4 py-2.5 text-sm font-medium shadow-sm transition">
      + Tambah Menu
    </a>
  </div>

  {{-- ALERT SUCCESS --}}
  @if(session('success'))
    <div class="mb-6 bg-green-50 border border-green-200 rounded-xl px-4 py-3 flex items-start gap-3">
      <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
      </svg>
      <p class="text-sm text-green-800">{{ session('success') }}</p>
    </div>
  @endif

  {{-- TABEL MENU --}}
  <section class="bg-white rounded-2xl shadow-soft border border-neutral-200 overflow-hidden">
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-neutral-200">
        <thead class="bg-neutral-50">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">No</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Gambar</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Nama Menu</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Kategori</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Harga</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Suhu</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Aksi</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-neutral-200">
          @forelse($menus as $index => $menu)
            <tr class="hover:bg-neutral-50 transition">
              <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-700">
                {{ $index + 1 }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                @if($menu->gambar)
                  <img src="{{ asset('storage/' . $menu->gambar) }}" 
                       alt="{{ $menu->nama_menu }}"
                       class="h-16 w-16 object-cover rounded-lg border border-neutral-200">
                @else
                  <div class="h-16 w-16 bg-neutral-100 rounded-lg flex items-center justify-center">
                    <svg class="w-8 h-8 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                  </div>
                @endif
              </td>
              <td class="px-6 py-4 text-sm font-medium text-neutral-800">
                {{ $menu->nama_menu }}
              </td>
              <td class="px-6 py-4 text-sm">
                @if($menu->kategori)
                  <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    {{ $menu->kategori }}
                  </span>
                @else
                  <span class="text-neutral-400">-</span>
                @endif
              </td>
              <td class="px-6 py-4 text-sm text-neutral-700">
                Rp {{ number_format($menu->harga, 0, ',', '.') }}
              </td>
              <td class="px-6 py-4 text-sm">
                @if($menu->suhu)
                  <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-neutral-100 text-neutral-700">
                    {{ $menu->suhu }}
                  </span>
                @else
                  <span class="text-neutral-400">-</span>
                @endif
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm">
                <div class="flex items-center gap-2">
                  {{-- Tombol Edit --}}
                  <a href="{{ route('admin.menus.edit', $menu->id) }}" 
                     class="inline-flex items-center px-3 py-1.5 rounded-lg bg-yellow-500 hover:bg-yellow-600 text-white text-xs font-medium transition">
                    Edit
                  </a>

                  {{-- Tombol Hapus --}}
                  <form action="{{ route('admin.menus.destroy', $menu->id) }}" 
                        method="POST" 
                        class="inline"
                        onsubmit="return confirm('Yakin ingin menghapus menu {{ $menu->nama_menu }}?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="inline-flex items-center px-3 py-1.5 rounded-lg bg-red-500 hover:bg-red-600 text-white text-xs font-medium transition">
                      Hapus
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="px-6 py-12 text-center">
                <svg class="mx-auto h-12 w-12 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                </svg>
                <p class="mt-4 text-sm text-neutral-500">Belum ada menu tersedia</p>
                <a href="{{ route('admin.menus.create') }}" 
                   class="mt-4 inline-flex items-center rounded-xl bg-amber-600 hover:bg-amber-700 text-white px-4 py-2.5 text-sm font-medium shadow-sm transition">
                  + Tambah Menu Pertama
                </a>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </section>
</div>
@endsection