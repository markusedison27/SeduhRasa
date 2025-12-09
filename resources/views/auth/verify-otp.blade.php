@extends('layouts.guest')
@section('title', 'Verifikasi OTP - SeduhRasa')

@section('content')
<div class="w-full flex justify-center mt-16">
    <div class="w-full max-w-sm bg-white rounded-2xl shadow-lg p-8">

        <h2 class="text-2xl font-bold text-center text-stone-800 mb-2">
            Verifikasi Kode OTP
        </h2>

        <p class="text-sm text-center text-stone-500 mb-6">
            Masukkan 6 digit kode yang dikirim ke email:
            <br>
            <span class="font-semibold text-[#7B3F00]">{{ $email }}</span>
        </p>

        {{-- ALERT STATUS --}}
        @if(session('status'))
            <div class="mb-4 p-3 rounded-lg bg-green-50 border border-green-200 text-green-700 text-sm">
                {{ session('status') }}
            </div>
        @endif

        {{-- ALERT ERROR --}}
        @if($errors->any())
            <div class="mb-4 p-3 rounded-lg bg-red-50 border border-red-200 text-red-700 text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.otp.verify') }}" class="space-y-5">
            @csrf

            <input type="hidden" name="email" value="{{ $email }}">

            <div>
                <label class="text-sm text-stone-600">Kode OTP</label>
                <input type="text" name="otp" maxlength="6" required autofocus
                    class="w-full mt-1 px-4 py-3 rounded-xl border border-stone-300 focus:border-[#7B3F00] focus:ring-0"
                    placeholder="Contoh: 123456">
            </div>

            <button type="submit"
                class="w-full py-3 rounded-xl bg-gradient-to-r from-[#7B3F00] to-[#8B4513] text-white font-semibold hover:opacity-90 transition">
                Verifikasi OTP
            </button>
        </form>

        <div class="text-center mt-6 text-sm">
            <a href="{{ route('password.request') }}"
               class="text-[#7B3F00] hover:text-[#C67C4E] font-medium">
                Kirim ulang OTP
            </a>
        </div>

    </div>
</div>
@endsection
