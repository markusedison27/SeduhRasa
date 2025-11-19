@extends('layouts.app')

@section('title', 'Daftar Pemilik Coffee Shop')
@section('page-title', 'Dashboard')

@section('content')
    {{-- HEADER --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold mb-1">Daftar Pemilik Coffee Shop</h1>
            <p class="text-sm text-gray-500">
                Kelola akun pemilik yang terdaftar di sistem.
            </p>
        </div>

        {{-- TOMBOL BUKA MODAL --}}
        <button type="button" id="btn-open-owner-modal"
                class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-md
                       bg-indigo-600 text-white hover:bg-indigo-700
                       focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            + Tambah Pemilik Baru
        </button>
    </div>

    {{-- PESAN ERROR --}}
    @if ($errors->any())
        <div class="mb-4 rounded-md bg-red-50 border border-red-200 px-3 py-2 text-sm text-red-700">
            {{ $errors->first() }}
        </div>
    @endif

    {{-- CARD LIST PEMILIK --}}
    <div class="bg-white border rounded-lg shadow-sm">
        <div class="px-4 py-3 border-b">
            <h2 class="text-base font-semibold mb-0">List Pemilik</h2>
        </div>

        <div class="p-0">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50 text-xs uppercase text-gray-500">
                        <tr>
                            <th class="px-4 py-2 text-left">#</th>
                            <th class="px-4 py-2 text-left">Nama</th>
                            <th class="px-4 py-2 text-left">Email</th>
                            <th class="px-4 py-2 text-left">Status</th>
                            <th class="px-4 py-2 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($owners as $i => $owner)
                            <tr>
                                <td class="px-4 py-2 align-top">
                                    {{ $i + 1 }}
                                </td>
                                <td class="px-4 py-2 align-top">
                                    <div class="font-semibold text-gray-800">
                                        {{ $owner->name }}
                                    </div>
                                    <div class="text-xs text-gray-400">
                                        {{ $owner->role }}
                                    </div>
                                </td>
                                <td class="px-4 py-2 align-top">
                                    {{ $owner->email }}
                                </td>
                                <td class="px-4 py-2 align-top">
                                    @if ($owner->is_active ?? true)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs
                                                     bg-green-100 text-green-700">
                                            Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs
                                                     bg-red-100 text-red-700">
                                            Nonaktif
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 align-top text-right space-x-2">
                                    {{-- tombol Edit & Nonaktifkan contoh, sesuaikan route kalau sudah ada --}}
                                    <a href="#"
                                       class="inline-flex items-center px-3 py-1.5 text-xs rounded-md border
                                              border-gray-300 text-gray-700 hover:bg-gray-50">
                                        Edit
                                    </a>
                                    <form action="#" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                                class="inline-flex items-center px-3 py-1.5 text-xs rounded-md
                                                       border border-red-200 text-red-600 hover:bg-red-50">
                                            Nonaktifkan
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-4 text-center text-gray-400">
                                    Belum ada data pemilik.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ================================================================= --}}
    {{-- MODAL TAMBAH PEMILIK (POPUP DI HALAMAN YANG SAMA)                 --}}
    {{-- ================================================================= --}}
    <div id="owner-modal"
         class="fixed inset-0 z-50 hidden items-center justify-center">
        {{-- backdrop --}}
        <div class="absolute inset-0 bg-black/40" data-close-owner-modal></div>

        {{-- konten modal --}}
        <div class="relative bg-white rounded-xl shadow-lg w-full max-w-md mx-4">
            <div class="px-5 py-3 border-b flex items-center justify-between">
                <h2 class="text-base font-semibold">Tambah Pemilik Coffee Shop</h2>
                <button type="button" data-close-owner-modal
                        class="text-gray-400 hover:text-gray-600">
                    ✕
                </button>
            </div>

            <div class="p-5">
                <form action="{{ route('super.owners.store') }}" method="POST" class="space-y-4">
                    @csrf

                    {{-- Nama --}}
                    <div>
                        <label for="modal-name" class="block text-sm font-medium text-gray-700 mb-1">
                            Nama
                        </label>
                        <input type="text" name="name" id="modal-name"
                               value="{{ old('name') }}"
                               required
                               class="block w-full rounded-md border-gray-300 shadow-sm
                                      focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="modal-email" class="block text-sm font-medium text-gray-700 mb-1">
                            Email
                        </label>
                        <input type="email" name="email" id="modal-email"
                               value="{{ old('email') }}"
                               required
                               class="block w-full rounded-md border-gray-300 shadow-sm
                                      focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    </div>

                    {{-- Password --}}
                    <div>
                        <label for="modal-password" class="block text-sm font-medium text-gray-700 mb-1">
                            Password
                        </label>
                        <input type="password" name="password" id="modal-password"
                               required
                               class="block w-full rounded-md border-gray-300 shadow-sm
                                      focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        <p class="text-xs text-gray-400 mt-1">
                            Minimal 8 karakter.
                        </p>
                    </div>

                    {{-- status & role --}}
                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="is_active" id="modal-is_active"
                               value="1" checked
                               class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <label for="modal-is_active" class="text-sm text-gray-700">
                            Aktifkan akun pemilik ini
                        </label>
                    </div>

                    <input type="hidden" name="role" value="owner">

                    <div class="pt-2 flex justify-end gap-2">
                        <button type="button" data-close-owner-modal
                                class="inline-flex items-center px-4 py-2 text-sm rounded-md border border-gray-300
                                       bg-white text-gray-700 hover:bg-gray-50">
                            Batal
                        </button>
                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-md
                                       bg-indigo-600 text-white hover:bg-indigo-700
                                       focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const modal      = document.getElementById('owner-modal');
    const openBtn    = document.getElementById('btn-open-owner-modal');
    const closeBtns  = document.querySelectorAll('[data-close-owner-modal]');

    if (!modal || !openBtn) return;

    const openModal = () => {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    };

    const closeModal = () => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    };

    openBtn.addEventListener('click', openModal);
    closeBtns.forEach(btn => btn.addEventListener('click', closeModal));
});
</script>
@endpush
