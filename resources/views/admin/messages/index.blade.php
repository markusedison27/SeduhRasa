@extends('layouts.app') {{-- layout utama admin --}}

@section('title', 'Pesan Pengguna')

@section('content')
<div class="px-6 py-6">
    <h1 class="text-2xl font-semibold mb-2">Pesan Pengguna</h1>
    <p class="text-sm text-gray-500 mb-6">
        Daftar pesan yang dikirim melalui halaman Kontak.
    </p>

    <div class="bg-white rounded-2xl shadow p-4">
        <table class="min-w-full text-sm">
            <thead>
                <tr class="border-b">
                    <th class="py-2 px-3 text-left">#</th>
                    <th class="py-2 px-3 text-left">Nama</th>
                    <th class="py-2 px-3 text-left">Email</th>
                    <th class="py-2 px-3 text-left">Pesan</th>
                    <th class="py-2 px-3 text-left">Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($messages as $index => $msg)
                    <tr class="border-b last:border-b-0">
                        <td class="py-2 px-3 align-top">
                            {{ $messages->firstItem() + $index }}
                        </td>
                        <td class="py-2 px-3 align-top font-semibold">
                            {{ $msg->name }}
                        </td>
                        <td class="py-2 px-3 align-top text-gray-600">
                            {{ $msg->email }}
                        </td>
                        <td class="py-2 px-3 align-top">
                            {{ $msg->message }}
                        </td>
                        <td class="py-2 px-3 align-top text-gray-500 text-xs">
                            {{ $msg->created_at->format('d M Y H:i') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-4 text-center text-gray-500">
                            Belum ada pesan yang masuk.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $messages->links() }}
        </div>
    </div>
</div>
@endsection
