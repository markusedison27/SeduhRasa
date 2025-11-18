@extends('layouts.app')

@section('title', 'Daftar Pemilik Coffee Shop')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold mb-1">Daftar Pemilik Coffee Shop</h1>
            <p class="text-sm text-gray-500">
                Kelola akun pemilik yang terdaftar di sistem.
            </p>
        </div>

        <a href="{{ route('super.owners.create') }}"
           class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-md
                  bg-indigo-600 text-white hover:bg-indigo-700
                  focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            + Tambah Pemilik Baru
        </a>
    </div>

    <div class="bg-white border rounded-lg shadow-sm">
        <div class="px-4 py-3 border-b">
            <h2 class="text-sm font-semibold text-gray-700 mb-0">
                List Pemilik
            </h2>
        </div>

        <div class="p-4">
            @if ($owners->isEmpty())
                <p class="text-sm text-gray-500">
                    Belum ada pemilik yang terdaftar.
                </p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="border-b bg-gray-50">
                                <th class="text-left px-4 py-2 font-semibold text-gray-600">#</th>
                                <th class="text-left px-4 py-2 font-semibold text-gray-600">Nama</th>
                                <th class="text-left px-4 py-2 font-semibold text-gray-600">Email</th>
                                <th class="text-left px-4 py-2 font-semibold text-gray-600">Status</th>
                                <th class="text-right px-4 py-2 font-semibold text-gray-600">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($owners as $index => $owner)
                                <tr class="border-b last:border-0 hover:bg-gray-50">
                                    <td class="px-4 py-2 align-top">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="px-4 py-2 align-top">
                                        <div class="font-medium text-gray-800">
                                            {{ $owner->name }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            {{ $owner->role ?? 'owner' }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-2 align-top">
                                        <span class="text-gray-700">{{ $owner->email }}</span>
                                    </td>
                                    <td class="px-4 py-2 align-top">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs
                                                     {{ $owner->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                            {{ $owner->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2 align-top text-right space-x-2">
                                        {{-- contoh tombol edit & nonaktifkan, sesuaikan dengan route kamu --}}
                                        <a href="#"
                                           class="inline-flex items-center px-2 py-1 text-xs font-medium rounded
                                                  border border-gray-300 text-gray-700 hover:bg-gray-100">
                                            Edit
                                        </a>

                                        <form action="#"
                                              method="POST"
                                              class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                    class="inline-flex items-center px-2 py-1 text-xs font-medium rounded
                                                           border border-red-200 text-red-600 hover:bg-red-50">
                                                Nonaktifkan
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection
