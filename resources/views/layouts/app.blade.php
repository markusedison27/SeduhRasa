<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'SeduhRasa Panel')</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  @stack('styles')
</head>

<body class="bg-stone-50 text-stone-800">
  <div class="flex min-h-screen">
    {{-- Sidebar --}}
    <div class="w-64 bg-white shadow-md border-r p-4 flex flex-col justify-between">
      <div>
        <h2 class="text-xl font-bold text-amber-600 mb-4 text-center">SeduhRasa</h2>
        <nav class="space-y-2">
          <a href="{{ url('/dashboard') }}" class="block px-4 py-2 rounded-lg font-medium text-stone-700 bg-amber-100 hover:bg-amber-200 transition">
            Dashboard
          </a>

          <p class="mt-4 mb-1 text-xs font-semibold text-stone-400 uppercase tracking-wide">Manajemen Data</p>

          <a href="{{ route('menus.index') }}" class="block px-4 py-2 rounded-lg text-stone-600 hover:bg-amber-50 hover:text-amber-600 transition">Menu</a>
          <a href="{{ route('transaksi.index') }}" class="block px-4 py-2 rounded-lg text-stone-600 hover:bg-amber-50 hover:text-amber-600 transition">Transaksi</a>
          <a href="{{ route('pelanggan.index') }}" class="block px-4 py-2 rounded-lg text-stone-600 hover:bg-amber-50 hover:text-amber-600 transition">Pelanggan</a>
          <a href="{{ route('karyawan.index') }}" class="block px-4 py-2 rounded-lg text-stone-600 hover:bg-amber-50 hover:text-amber-600 transition">Karyawan</a>

          {{-- 🔹 Diperbaiki agar Order menuju halaman publik (produk) --}}
          <a href="{{ url('/order') }}" class="block px-4 py-2 rounded-lg text-stone-600 hover:bg-amber-50 hover:text-amber-600 transition">Order</a>
        </nav>
      </div>

      {{-- Logout --}}
      <div class="mt-6 border-t pt-4">
        <form action="{{ route('logout') }}" method="POST">
          @csrf
          <button type="submit"
            class="w-full px-4 py-2 text-left rounded-lg text-red-600 hover:bg-red-50 font-medium transition">
            Logout
          </button>
        </form>
      </div>
    </div>

    {{-- Main --}}
    <div class="flex-1 flex flex-col">
      <header class="bg-white shadow p-4 flex justify-between items-center">
        <h1 class="text-lg font-semibold">@yield('page-title', 'Dashboard')</h1>
        <div class="flex items-center gap-3">
          <span class="hidden sm:block text-stone-500">Hello, Admin</span>
          <img src="https://ui-avatars.com/api/?name=Admin&background=EAB308&color=111827"
            class="w-9 h-9 rounded-full ring-2 ring-amber-400/40" alt="admin">
        </div>
      </header>

      <main class="p-6 flex-1">
        @yield('content')
      </main>
    </div>
  </div>

  @stack('scripts')
</body>

</html>
