@extends('layouts.app')

@section('title', 'dashboard')

@section('content')

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold mb-1">Dashboard Pemilik Coffee Shop</h1>
            <p class="text-sm text-gray-500">
                Selamat datang, {{ $owner->name }}. Berikut ringkasan singkat usahamu.
            </p>
        </div>
    </div>

    {{-- Ringkasan (dummy dulu, nanti bisa diisi data beneran dari database) --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div>
            <div class="bg-white border rounded-lg shadow-sm">
                <div class="p-4">
                    <h6 class="text-xs font-semibold tracking-wide text-gray-500 uppercase mb-2">
                        Total Transaksi Hari Ini
                    </h6>
                    <div class="text-2xl font-semibold mb-1">
                        {{-- TODO: ganti dengan data asli --}}
                        0
                    </div>
                    <small class="text-xs text-gray-400">
                        Belum terhubung ke data transaksi.
                    </small>
                </div>
            </div>
        </div>

        <div>
            <div class="bg-white border rounded-lg shadow-sm">
                <div class="p-4">
                    <h6 class="text-xs font-semibold tracking-wide text-gray-500 uppercase mb-2">
                        Perkiraan Pendapatan
                    </h6>
                    <div class="text-2xl font-semibold mb-1">
                        {{-- TODO: ganti dengan data asli --}}
                        Rp 0
                    </div>
                    <small class="text-xs text-gray-400">
                        Silakan integrasikan dengan laporan keuangan.
                    </small>
                </div>
            </div>
        </div>

        <div>
            <div class="bg-white border rounded-lg shadow-sm">
                <div class="p-4">
                    <h6 class="text-xs font-semibold tracking-wide text-gray-500 uppercase mb-2">
                        Jumlah Staff Aktif
                    </h6>
                    <div class="text-2xl font-semibold mb-1">
                        {{-- TODO: ganti dengan data asli --}}
                        0
                    </div>
                    <small class="text-xs text-gray-400">
                        Bisa diambil dari tabel karyawan.
                    </small>
                </div>
            </div>
        </div>
    </div>

    {{-- Aksi cepat --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div>
            <div class="bg-white border rounded-lg shadow-sm h-full flex flex-col">
                <div class="p-4 flex flex-col justify-between flex-1">
                    <div>
                        <h5 class="text-lg font-semibold mb-1">Laporan Keuangan</h5>
                        <p class="text-sm text-gray-500">
                            Lihat ringkasan pemasukan dan pengeluaran kedai kopi kamu.
                        </p>
                    </div>
                    <a href="{{ route('owner.finance') }}"
                       class="inline-flex items-center justify-center mt-3 px-4 py-2 text-sm font-medium rounded-md
                              bg-indigo-600 text-white hover:bg-indigo-700
                              focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Buka Halaman Keuangan
                    </a>
                </div>
            </div>
        </div>

        <div>
            <div class="bg-white border rounded-lg shadow-sm h-full flex flex-col">
                <div class="p-4 flex flex-col justify-between flex-1">
                    <div>
                        <h5 class="text-lg font-semibold mb-1">Daftar Pesanan</h5>
                        <p class="text-sm text-gray-500">
                            Lihat pesanan yang pernah dibuat pelanggan dari website.
                        </p>
                    </div>
                    <a href="{{ route('orders.index') }}"
                       class="inline-flex items-center justify-center mt-3 px-4 py-2 text-sm font-medium rounded-md
                              border border-gray-300 bg-white text-gray-700
                              hover:bg-gray-50 focus:outline-none focus:ring-2
                              focus:ring-indigo-500 focus:ring-offset-2">
                        Lihat Pesanan
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Info akun owner --}}
    <div class="bg-white border rounded-lg shadow-sm">
        <div class="px-4 py-3 border-b">
            <h5 class="text-lg font-semibold mb-0">Profil Akun Owner</h5>
        </div>
        <div class="p-4">
            <dl class="divide-y divide-gray-100">
                <div class="py-2 grid grid-cols-3 gap-4 text-sm">
                    <dt class="font-medium text-gray-600">Nama</dt>
                    <dd class="col-span-2 text-gray-800">{{ $owner->name }}</dd>
                </div>

                <div class="py-2 grid grid-cols-3 gap-4 text-sm">
                    <dt class="font-medium text-gray-600">Email</dt>
                    <dd class="col-span-2 text-gray-800">{{ $owner->email }}</dd>
                </div>

                <div class="py-2 grid grid-cols-3 gap-4 text-sm">
                    <dt class="font-medium text-gray-600">Role</dt>
                    <dd class="col-span-2 text-gray-800">{{ $owner->role }}</dd>
                </div>
            </dl>
        </div>
    </div>
@endsection
