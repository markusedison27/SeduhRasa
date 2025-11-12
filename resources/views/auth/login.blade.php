@extends('layouts.guest')
@section('title','Masuk - SeduhRasa')

@section('content')
<div class="w-full max-w-sm">
  <div class="mb-5 flex items-center gap-2 justify-center">
    <div class="h-8 w-8 rounded-lg bg-[#C67C4E] text-white grid place-items-center text-sm font-bold">SR</div>
    <span class="text-base font-semibold tracking-tight">SeduhRasa</span>
  </div>

  <div class="bg-white/85 backdrop-blur rounded-xl ring-1 ring-stone-200 shadow-[0_10px_30px_-12px_rgba(0,0,0,.25)] p-6">
    <h1 class="text-lg font-semibold">Masuk</h1>
    <p class="text-sm text-stone-500 mb-5">Kelola operasional kedai kopi.</p>

    @if ($errors->any())
      <div class="mb-4 rounded-lg bg-red-50 text-red-700 ring-1 ring-red-200 px-3 py-2 text-sm">
        {{ $errors->first() }}
      </div>
    @endif

    <form method="POST" action="{{ route('login.post') }}" class="space-y-4">
      @csrf

      {{-- Floating label input --}}
      <div class="relative">
        <input id="email" name="email" type="email" autocomplete="username" required
               value="{{ old('email') }}"
               class="peer w-full rounded-lg border-stone-300 focus:border-[#C67C4E] focus:ring-[#C67C4E] placeholder-transparent"
               placeholder="Email">
        <label for="email"
               class="absolute left-3 top-2 px-1 text-stone-500 text-sm transition-all
                      peer-focus:text-xs peer-focus:-top-2 peer-focus:bg-white peer-focus:text-[#7B3F00]
                      peer-[:not(:placeholder-shown)]:text-xs peer-[:not(:placeholder-shown)]:-top-2 peer-[:not(:placeholder-shown)]:bg-white">
          Email
        </label>
      </div>

      <div class="relative">
        <input id="password" name="password" type="password" autocomplete="current-password" required
               class="peer w-full rounded-lg border-stone-300 focus:border-[#C67C4E] focus:ring-[#C67C4E] placeholder-transparent"
               placeholder="Password">
        <label for="password"
               class="absolute left-3 top-2 px-1 text-stone-500 text-sm transition-all
                      peer-focus:text-xs peer-focus:-top-2 peer-focus:bg-white peer-focus:text-[#7B3F00]
                      peer-[:not(:placeholder-shown)]:text-xs peer-[:not(:placeholder-shown)]:-top-2 peer-[:not(:placeholder-shown)]:bg-white">
          Password
        </label>
      </div>

      <div class="flex items-center justify-between">
        <label class="inline-flex items-center gap-2 text-sm">
          <input type="checkbox" name="remember" class="rounded border-stone-300 text-[#7B3F00] focus:ring-[#C67C4E]">
          Ingat saya
        </label>
        <a href="#" class="text-sm text-stone-500 hover:text-stone-700">Lupa password?</a>
      </div>

      <button type="submit"
        class="w-full py-2.5 rounded-lg bg-[#7B3F00] text-white font-medium
               shadow-[0_6px_0_0_#5a2b00] hover:translate-y-[-1px] active:translate-y-[1px] active:shadow-[0_3px_0_0_#5a2b00]
               transition-transform">
        Masuk
      </button>
    </form>
  </div>

  <p class="text-center text-xs text-stone-500 mt-4">© {{ date('Y') }} SeduhRasa</p>
</div>
@endsection
