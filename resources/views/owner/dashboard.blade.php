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

    {{-- Alert untuk Success/Error Messages --}}
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span class="text-green-800 font-medium">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-red-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <span class="text-red-800 font-medium">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    @if($errors->any())
        <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-red-600 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <div class="flex-1">
                    <p class="text-red-800 font-medium mb-1">Terjadi kesalahan:</p>
                    <ul class="list-disc list-inside text-red-700 text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

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
                        Staff yang terdaftar di sistem.
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

    {{-- FITUR: Pengaturan QR Code Pembayaran --}}
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
                        <img src="{{ asset('storage/' . $qrCodePath) }}" 
                             alt="QR Code Pembayaran Aktif" 
                             class="w-48 h-48 object-contain border-2 border-gray-200 p-2 rounded-lg shadow-sm">
                        <small class="text-gray-500 block mt-2">
                            <svg class="w-4 h-4 inline-block mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                            Ganti QR Code di bawah jika ada perubahan.
                        </small>
                    </div>
                @else
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 mb-4">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-yellow-600 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-yellow-800 text-sm">Belum ada QR Code yang diunggah. Harap unggah QR Code baru.</span>
                        </div>
                    </div>
                @endif
                
                <div class="space-y-2">
                    <label for="qrcode_file" class="block text-sm font-medium text-gray-700">
                        Pilih Gambar QR Code (JPG/PNG, Maks 2MB)
                    </label>
                    <input type="file" 
                           name="qrcode_file" 
                           id="qrcode_file" 
                           accept="image/jpeg,image/png,image/jpg"
                           class="block w-full text-sm text-gray-500
                                  file:mr-4 file:py-2 file:px-4
                                  file:rounded-full file:border-0
                                  file:text-sm file:font-semibold
                                  file:bg-indigo-50 file:text-indigo-700
                                  hover:file:bg-indigo-100 cursor-pointer">
                    <p class="text-xs text-gray-500 mt-1">Format: JPEG, PNG, JPG. Ukuran maksimal: 2MB</p>
                </div>
                
                <div class="flex justify-end">
                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md
                                   shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Unggah & Simpan QR Code
                    </button>
                </div>
            </form>
        </div>
    </div>
    {{-- AKHIR FITUR QR CODE --}}

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
                    <dd class="col-span-2 text-gray-800">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                            {{ ucfirst($owner->role) }}
                        </span>
                    </dd>
                </div>
            </dl>
        </div>
    </div>
@endsection