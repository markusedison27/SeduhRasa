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

    {{-- Ringkasan --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div>
            <div class="bg-white border rounded-lg shadow-sm">
                <div class="p-4">
                    <h6 class="text-xs font-semibold tracking-wide text-gray-500 uppercase mb-2">
                        Total Transaksi Hari Ini
                    </h6>
                    <div class="text-2xl font-semibold mb-1">
                        {{ $totalTransaksiHariIni }}
                    </div>
                    <small class="text-xs text-gray-400">
                        Total pesanan selesai hari ini.
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
                        Rp {{ number_format($perkiraanPendapatan, 0, ',', '.') }}
                    </div>
                    <small class="text-xs text-gray-400">
                        Total omzet dari transaksi selesai.
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
                        {{ $jumlahStaffAktif }}
                    </div>
                    <small class="text-xs text-gray-400">
                        Perlu integrasi tabel karyawan.
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

    {{-- FITUR BARU: Pengaturan QR Code Pembayaran --}}
    <div class="bg-white border rounded-lg shadow-sm mb-6">
        <div class="px-4 py-3 border-b">
            <h5 class="text-lg font-semibold mb-0">📸 Pengaturan QR Code Pembayaran</h5>
        </div>
        <div class="p-4">
            <p class="text-sm text-gray-500 mb-4">
                Unggah gambar QR Code (misalnya QRIS/Dana) yang akan ditampilkan di halaman konfirmasi pesanan pelanggan.
            </p>
            
            <form action="{{ route('owner.qrcode.upload') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                
                {{-- Tampilkan QR Code yang sudah terupload (Jika ada) --}}
                @if(isset($qrCodePath) && $qrCodePath)
                    <div class="mb-4">
                        <p class="font-medium text-gray-600 mb-2">QR Code Aktif Saat Ini:</p>
                        {{-- Gunakan asset('storage/') untuk mengakses file yang diupload --}}
                        <img src="{{ asset('storage/' . $qrCodePath) }}" alt="QR Code Pembayaran Aktif" class="w-32 h-32 object-contain border p-1 rounded-md">
                        <small class="text-gray-500 block mt-1">Ganti QR Code di bawah jika ada perubahan.</small>
                    </div>
                @else
                    <p class="text-yellow-600 text-sm">Belum ada QR Code yang diunggah. Harap unggah QR Code baru.</p>
                @endif
                
                <div class="space-y-2">
                    <label for="qrcode_file" class="block text-sm font-medium text-gray-700">
                        Pilih Gambar QR Code (JPG/PNG, Maks 2MB)
                    </label>
                    <input type="file" name="qrcode_file" id="qrcode_file" required
                           class="block w-full text-sm text-gray-500
                                  file:mr-4 file:py-2 file:px-4
                                  file:rounded-full file:border-0
                                  file:text-sm file:font-semibold
                                  file:bg-indigo-50 file:text-indigo-700
                                  hover:file:bg-indigo-100">
                </div>
                
                <div class="flex justify-end">
                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md
                                   shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        <i class="bi bi-upload me-2"></i> Unggah & Simpan QR Code
                    </button>
                </div>
            </form>
        </div>
    </div>
    {{-- AKHIR FITUR BARU --}}

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