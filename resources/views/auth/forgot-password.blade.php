@extends('layouts.guest')
@section('title', 'Lupa Kata Sandi - SeduhRasa')

@section('content')
    <div class="w-full flex justify-center mt-10 lg:mt-16">
        <div class="w-full max-w-sm">
            {{-- Logo --}}
            <div class="mb-8 flex items-center gap-2.5 justify-center">
                <div class="relative">
                    <img src="{{ asset('LOGO2.png') }}"
                         class="h-16 w-16 rounded-xl object-cover shadow-lg shadow-[#7B3F00]/25"
                         alt="SeduhRasa Logo">
                </div>
                <span
                    class="text-xl font-bold tracking-tight bg-gradient-to-r from-[#7B3F00] to-[#C67C4E] bg-clip-text text-transparent">
                    SeduhRasa
                </span>
            </div>

            {{-- Card --}}
            <div
                class="bg-white/90 backdrop-blur-xl rounded-2xl ring-1 ring-stone-200/50
                       shadow-[0_20px_50px_-12px_rgba(123,63,0,0.25)] p-8">

                <div class="mb-6 text-center">
                    <h1 class="text-2xl font-bold text-stone-800 mb-1">Lupa Kata Sandi</h1>
                    <p class="text-sm text-stone-500">
                        Masukkan email akun Anda, kami akan kirimkan kode untuk reset password.
                    </p>
                </div>

                {{-- Status sukses kirim OTP --}}
                @if (session('status'))
                    <div class="mb-4 rounded-xl bg-emerald-50 text-emerald-800 ring-1 ring-emerald-200 px-4 py-3 text-sm">
                        {{ session('status') }}
                    </div>
                @endif

                {{-- Error email --}}
                @if ($errors->has('email'))
                    <div class="mb-3 rounded-xl bg-red-50 text-red-800 ring-1 ring-red-200 px-4 py-2.5 text-sm">
                        {{ $errors->first('email') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                    @csrf

                    {{-- Email --}}
                    <div class="relative group">
                        <input id="email" name="email" type="email" required
                               value="{{ old('email') }}"
                               class="peer w-full px-4 py-3 rounded-xl border-2 border-stone-200 bg-stone-50/50
                                      focus:border-[#C67C4E] focus:bg-white focus:ring-0
                                      placeholder-transparent transition-all duration-200"
                               placeholder="Alamat Email">
                        <label for="email"
                               class="absolute left-4 top-3.5 px-1 text-stone-500 text-sm pointer-events-none
                                      transition-all
                                      peer-focus:text-xs peer-focus:-top-2.5 peer-focus:left-3 peer-focus:bg-white peer-focus:text-[#7B3F00] peer-focus:font-medium
                                      peer-[:not(:placeholder-shown)]:text-xs peer-[:not(:placeholder-shown)]:-top-2.5 peer-[:not(:placeholder-shown)]:left-3 peer-[:not(:placeholder-shown)]:bg-white peer-[:not(:placeholder-shown)]:font-medium">
                            Alamat Email
                        </label>
                    </div>

                    {{-- Tombol kirim --}}
                    <button type="submit"
                            class="w-full py-3.5 rounded-xl bg-gradient-to-r from-[#7B3F00] to-[#8B4513]
                                   text-white font-semibold shadow-[0_6px_0_0_#5a2b00,0_6px_20px_rgba(123,63,0,0.3)]
                                   hover:shadow-[0_6px_0_0_#5a2b00,0_8px_25px_rgba(123,63,0,0.4)]
                                   hover:translate-y-[-2px] active:translate-y-[2px]
                                   active:shadow-[0_2px_0_0_#5a2b00] transition-all duration-150
                                   flex items-center justify-center gap-2">
                        Kirim Kode Reset
                    </button>
                </form>

                {{-- Link kembali --}}
                <div class="mt-4 text-center">
                    <a href="{{ route('login') }}"
                       class="text-sm text-stone-500 hover:text-[#7B3F00] inline-flex items-center gap-1">
                        ← Kembali ke Login
                    </a>
                </div>
            </div>

            {{-- Footer --}}
            <p class="text-center text-xs text-stone-400 mt-6">
                © {{ date('Y') }} SeduhRasa • Crafted with love & coffee
            </p>
        </div>
    </div>
@endsection
