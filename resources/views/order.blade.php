@extends('layouts.app')

@section('page-title', 'Order')

@section('content')
<div class="p-6">
    <h2 class="text-2xl font-bold mb-4">Pesan Kopi Sekarang</h2>
    <p>Silakan isi form di bawah untuk memesan kopi terbaik kami.</p>

    <form action="#" method="POST" class="space-y-3 mt-4">
        @csrf
        <div>
            <label class="block">Nama</label>
            <input type="text" name="nama" class="border rounded p-2 w-full" required>
        </div>
        <div>
            <label class="block">Jenis Kopi</label>
            <input type="text" name="jenis" class="border rounded p-2 w-full" required>
        </div>
        <div>
            <label class="block">Jumlah</label>
            <input type="number" name="jumlah" class="border rounded p-2 w-full" required>
        </div>
        <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded">Kirim Pesanan</button>
    </form>
</div>
@endsection
