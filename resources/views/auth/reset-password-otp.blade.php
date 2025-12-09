@extends('layouts.guest')
@section('title', 'Reset Password - SeduhRasa')

@section('content')
<div class="w-full flex justify-center mt-16">
    <div class="w-full max-w-sm bg-white rounded-2xl shadow-lg p-8">

        <h2 class="text-2xl font-bold text-center text-stone-800 mb-2">
            Buat Password Baru
        </h2>

        <p class="text-sm text-center text-stone-500 mb-6">
            Reset password untuk akun:
            <br>
            <span class="font-semibold text-[#7B3F00]">{{ $email }}</span>
        </p>

        {{-- ALERT ERROR --}}
        @if($errors->any())
            <div class="mb-4 p-3 rounded-lg bg-red-50 border border-red-200 text-red-700 text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.reset.otp') }}" class="space-y-5">
            @csrf

            <input type="hidden" name="email" value="{{ $email }}">

            <div>
                <label class="text-sm text-stone-600">Password Baru</label>
                <input type="password" name="password" required
                    class="w-full mt-1 px-4 py-3 rounded-xl border border-stone-300 focus:border-[#7B3F00] focus:ring-0">
            </div>

            <div>
                <label class="text-sm text-stone-600">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" required
                    class="w-full mt-1 px-4 py-3 rounded-xl border border-stone-300 focus:border-[#7B3F00] focus:ring-0">
            </div>

            <button type="submit"
                class="w-full py-3 rounded-xl bg-gradient-to-r from-[#7B3F00] to-[#8B4513] text-white font-semibold hover:opacity-90 transition">
                Simpan Password Baru
            </button>
        </form>

    </div>
</div>
@endsection
