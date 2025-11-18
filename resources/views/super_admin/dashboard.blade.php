@extends('layouts.app')

@section('title', 'Dashboard Super Admin')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold mb-1">Dashboard Super Admin</h1>
            <p class="text-sm text-gray-500">
                Halo, {{ auth()->user()->name }} (role: {{ auth()->user()->role }}).
            </p>
        </div>
    </div>

    {{-- Ringkasan User --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div>
            <div class="bg-white border rounded-lg shadow-sm h-full">
                <div class="p-4">
                    <h6 class="text-xs font-semibold tracking-wide text-gray-500 uppercase mb-2">
                        Total Owner
                    </h6>
                    <div class="text-3xl font-semibold mb-1">
                        {{ $totalOwner ?? 0 }}
                    </div>
                    <p class="text-xs text-gray-400">
                        Jumlah seluruh pemilik coffee shop yang terdaftar.
                    </p>
                </div>
            </div>
        </div>

        <div>
            <div class="bg-white border rounded-lg shadow-sm h-full">
                <div class="p-4">
                    <h6 class="text-xs font-semibold tracking-wide text-gray-500 uppercase mb-2">
                        Total Staff
                    </h6>
                    <div class="text-3xl font-semibold mb-1">
                        {{ $totalStaff ?? 0 }}
                    </div>
                    <p class="text-xs text-gray-400">
                        Total seluruh staff yang terdaftar di sistem.
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Aksi Cepat: Hanya Kelola Pemilik --}}
    <div class="grid grid-cols-1 md:grid-cols-1 gap-4 mb-6">
        <div>
            <div class="bg-white border rounded-lg shadow-sm h-full flex flex-col">
                <div class="p-4 flex flex-col justify-between flex-1">
                    <div>
                        <h5 class="text-lg font-semibold mb-1">Kelola Pemilik Coffee Shop</h5>
                        <p class="text-sm text-gray-500">
                            Tambah, ubah, atau nonaktifkan akun pemilik coffee shop.
                        </p>
                    </div>
                    <a href="{{ route('super.owners.index') }}"
                       class="inline-flex items-center justify-center mt-3 px-4 py-2 text-sm font-medium rounded-md
                              bg-indigo-600 text-white hover:bg-indigo-700
                              focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Buka Manajemen Owner
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Profil Akun Super Admin --}}
    <div class="bg-white border rounded-lg shadow-sm">
        <div class="px-4 py-3 border-b">
            <h5 class="text-lg font-semibold mb-0">Profil Akun Super Admin</h5>
        </div>
        <div class="p-4">
            <dl class="divide-y divide-gray-100">
                <div class="py-2 grid grid-cols-3 gap-4 text-sm">
                    <dt class="font-medium text-gray-600">Nama</dt>
                    <dd class="col-span-2 text-gray-800">{{ auth()->user()->name }}</dd>
                </div>

                <div class="py-2 grid grid-cols-3 gap-4 text-sm">
                    <dt class="font-medium text-gray-600">Email</dt>
                    <dd class="col-span-2 text-gray-800">{{ auth()->user()->email }}</dd>
                </div>

                <div class="py-2 grid grid-cols-3 gap-4 text-sm">
                    <dt class="font-medium text-gray-600">Role</dt>
                    <dd class="col-span-2 text-gray-800">{{ auth()->user()->role }}</dd>
                </div>
            </dl>
        </div>
    </div>
@endsection
