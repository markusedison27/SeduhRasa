@extends('layouts.app')

@section('title', 'Edit Profil')
@section('page-title', 'Pengaturan Profil')

@section('content')
<div class="max-w-4xl mx-auto space-y-8 animate-[fadeInUp_0.5s_ease-out]">

    {{-- Notifikasi Sukses/Error --}}
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-md" role="alert">
            <p class="font-bold">Berhasil!</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-md" role="alert">
            <p class="font-bold">Gagal!</p>
            <p>{{ session('error') }}</p>
        </div>
    @endif
    
    {{-- Form Edit Informasi Dasar --}}
    <div class="bg-white p-6 md:p-8 rounded-2xl shadow-xl border border-stone-200">
        <h2 class="text-xl font-semibold text-stone-800 mb-6 border-b pb-3">Informasi Akun Dasar</h2>
        
        <form method="POST" action="{{ route('owner.profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT') {{-- Gunakan metode PUT untuk update --}}

            {{-- Avatar --}}
            <div class="mb-6 flex flex-col sm:flex-row items-center gap-6">
                <div class="relative">
                    @php
                        $avatarUrl = auth()->user()->avatar 
                                    ? (str_contains(auth()->user()->avatar, 'googleusercontent.com') 
                                        ? auth()->user()->avatar 
                                        : asset('storage/' . auth()->user()->avatar)) 
                                    : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name ?? 'User') . '&background=C67C4E&color=fff';
                    @endphp
                    <img id="avatar-preview" src="{{ $avatarUrl }}"
                         class="w-24 h-24 rounded-full object-cover ring-4 ring-amber-300 shadow-md" alt="Avatar">
                    
                    <label for="avatar" class="absolute bottom-0 right-0 p-1.5 bg-amber-600 rounded-full cursor-pointer hover:bg-amber-700 transition shadow-lg">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.863-1.438A2 2 0 0110.12 3h3.76a2 2 0 011.664.89l.863 1.438a2 2 0 001.664.89H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </label>
                    <input type="file" id="avatar" name="avatar" class="hidden" accept="image/*" onchange="previewImage(event)">
                </div>

                <div>
                    <p class="text-sm text-stone-600">Unggah foto profil baru. Maksimal 2MB, format JPG/PNG.</p>
                    @error('avatar')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Nama --}}
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-stone-700 mb-1">Nama Lengkap</label>
                <input type="text" id="name" name="name" value="{{ old('name', $owner->name) }}"
                       class="mt-1 block w-full rounded-lg border-stone-300 shadow-sm focus:border-amber-500 focus:ring-amber-500" required>
                @error('name')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div class="mb-6">
                <label for="email" class="block text-sm font-medium text-stone-700 mb-1">Alamat Email</label>
                <input type="email" id="email" name="email" value="{{ old('email', $owner->email) }}"
                       class="mt-1 block w-full rounded-lg border-stone-300 shadow-sm focus:border-amber-500 focus:ring-amber-500" required>
                @error('email')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="flex justify-end">
                <button type="submit" class="inline-flex items-center px-6 py-2 border border-transparent text-sm font-medium rounded-xl shadow-sm text-white bg-amber-600 hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition-all">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    {{-- Form Update Password --}}
    <div class="bg-white p-6 md:p-8 rounded-2xl shadow-xl border border-stone-200">
        <h2 class="text-xl font-semibold text-stone-800 mb-6 border-b pb-3">Perbarui Password</h2>
        
        <form method="POST" action="{{ route('owner.password.update') }}">
            @csrf
            @method('PUT') {{-- Gunakan metode PUT untuk update --}}

            {{-- Password Baru --}}
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-stone-700 mb-1">Password Baru</label>
                <input type="password" id="password" name="password"
                       class="mt-1 block w-full rounded-lg border-stone-300 shadow-sm focus:border-amber-500 focus:ring-amber-500" autocomplete="new-password">
                @error('password')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            {{-- Konfirmasi Password --}}
            <div class="mb-6">
                <label for="password_confirmation" class="block text-sm font-medium text-stone-700 mb-1">Konfirmasi Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation"
                       class="mt-1 block w-full rounded-lg border-stone-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                @error('password_confirmation')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end">
                <button type="submit" class="inline-flex items-center px-6 py-2 border border-transparent text-sm font-medium rounded-xl shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all">
                    Ganti Password
                </button>
            </div>
        </form>
    </div>

</div>
@endsection

@push('scripts')
<script>
    // Fungsi untuk menampilkan preview avatar yang diunggah
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function(){
            const output = document.getElementById('avatar-preview');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endpush