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
    <div class="sidebar-menu"> <a href="/dashboard" class="nav-link active">Dashboard</a>

      <div class="menu-header">Manajemen Data</div>

      <a href="{{ route('menus.index') }}" class="nav-link">Menu</a>
      <a href="{{ route('transaksi.index') }}" class="nav-link">Transaksi</a>
      <a href="{{ route('pelanggan.index') }}" class="nav-link">Pelanggan</a>
      <a href="{{ route('karyawan.index') }}" class="nav-link">Karyawan</a>
      <a href="{{ route('orders.index') }}" class="nav-link">Order</a>

      <div class="logout-section">
        <a href="#" class="logout-button">Logout</a>
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