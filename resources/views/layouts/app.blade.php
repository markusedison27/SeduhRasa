<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'SeduhRasa Panel')</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  @stack('styles')
</head>
<body class="bg-stone-50 text-stone-800 antialiased">
  <div class="min-h-screen flex">

    {{-- ===== Sidebar (desktop) / Drawer (mobile) ===== --}}
    <aside
      id="sidebar"
      class="fixed inset-y-0 left-0 z-40 w-72 hidden lg:flex flex-col bg-white/90 backdrop-blur border-r border-stone-200">
      <div class="px-6 py-5 flex items-center gap-2 border-b border-stone-200">
        <div class="h-9 w-9 rounded-xl bg-amber-500 text-white grid place-items-center font-bold">SR</div>
        <div class="text-xl font-semibold tracking-tight">SeduhRasa</div>
      </div>

      @php
          $user = auth()->user();

          if (!$user) {
              $dashboardRoute = 'home';
          } elseif ($user->role === 'super_admin') {
              $dashboardRoute = 'super.dashboard';
          } elseif ($user->role === 'owner') {
              $dashboardRoute = 'owner.dashboard';
          } else {
              $dashboardRoute = 'staff.dashboard';
          }
      @endphp

      <nav class="p-4 space-y-3 flex-1 overflow-y-auto">
        <div class="text-xs font-semibold uppercase tracking-wider text-stone-400 px-2">
            Navigasi Panel
        </div>

        {{-- DASHBOARD --}}
        <a href="{{ route($dashboardRoute) }}"
           @class([
             'flex items-center gap-3 px-3 py-2 rounded-xl transition',
             'bg-amber-100 text-amber-800 ring-1 ring-amber-200' => request()->routeIs($dashboardRoute),
             'text-stone-700 hover:bg-amber-50 hover:text-amber-700' => !request()->routeIs($dashboardRoute),
           ])>
          <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path d="M3 12l2-2 7-7 7 7 2 2v8a2 2 0 0 1-2 2h-3a2 2 0 0 1-2-2v-3H10v3a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
          </svg>
          <span>Dashboard</span>
        </a>

        {{-- =============== SUPER ADMIN =============== --}}
        @if($user && $user->role === 'super_admin')
            <div class="pt-2">
                <div class="text-xs font-semibold uppercase tracking-wider text-stone-400 px-2 mb-1">
                    Manajemen User
                </div>

                <a href="{{ route('super.owners.index') }}"
                   @class([
                     'flex items-center gap-3 px-3 py-2 rounded-xl transition',
                     'bg-amber-100 text-amber-800 ring-1 ring-amber-200' => request()->routeIs('super.owners.*'),
                     'text-stone-700 hover:bg-amber-50 hover:text-amber-700' => !request()->routeIs('super.owners.*'),
                   ])>
                  <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M16 11V7a4 4 0 10-8 0v4M5 11h14v9H5z"/>
                  </svg>
                  <span>Pemilik Coffee Shop</span>
                </a>
            </div>

        {{-- =============== OWNER =============== --}}
        @elseif($user && $user->role === 'owner')
            <div class="pt-2">
                <div class="text-xs font-semibold uppercase tracking-wider text-stone-400 px-2 mb-1">
                    Manajemen Usaha
                </div>

                {{-- Keuangan --}}
                <a href="{{ route('owner.finance') }}"
                   @class([
                     'flex items-center gap-3 px-3 py-2 rounded-xl transition',
                     'bg-amber-100 text-amber-800 ring-1 ring-amber-200' => request()->routeIs('owner.finance'),
                     'text-stone-700 hover:bg-amber-50 hover:text-amber-700' => !request()->routeIs('owner.finance'),
                   ])>
                  <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M3 12h18M9 6h6M9 18h6"/>
                  </svg>
                  <span>Keuangan (Masuk & Keluar)</span>
                </a>

                {{-- Kelola Kasir --}}
                <a href="{{ route('owner.kasir.index') }}"
                   @class([
                     'flex items-center gap-3 px-3 py-2 rounded-xl transition',
                     'bg-amber-100 text-amber-800 ring-1 ring-amber-200' => request()->routeIs('owner.kasir.*'),
                     'text-stone-700 hover:bg-amber-50 hover:text-amber-700' => !request()->routeIs('owner.kasir.*'),
                   ])>
                  <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M12 12a4 4 0 100-8 4 4 0 000 8zM4 20a8 8 0 0116 0"/>
                  </svg>
                  <span>Kelola Kasir</span>
                </a>
            </div>

        {{-- =============== STAFF / KASIR =============== --}}
        @else
            <div class="pt-2">
                <div class="text-xs font-semibold uppercase tracking-wider text-stone-400 px-2 mb-1">
                    Manajemen Data
                </div>

                <a href="{{ route('admin.menus.index') }}"
                   @class([
                     'flex items-center gap-3 px-3 py-2 rounded-xl transition',
                     'bg-amber-100 text-amber-800 ring-1 ring-amber-200' => request()->routeIs('admin.menus.*'),
                     'text-stone-700 hover:bg-amber-50 hover:text-amber-700' => !request()->routeIs('admin.menus.*'),
                   ])>
                  <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M4 6h16M4 12h16M4 18h16"/>
                  </svg>
                  <span>Menu</span>
                </a>

                <a href="{{ route('admin.transaksi.index') }}"
                   @class([
                     'flex items-center gap-3 px-3 py-2 rounded-xl transition',
                     'bg-amber-100 text-amber-800 ring-1 ring-amber-200' => request()->routeIs('admin.transaksi.*'),
                     'text-stone-700 hover:bg-amber-50 hover:text-amber-700' => !request()->routeIs('admin.transaksi.*'),
                   ])>
                  <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M3 10h18M7 15h10M5 6h14"/>
                  </svg>
                  <span>Transaksi</span>
                </a>

                <a href="{{ route('admin.pelanggan.index') }}"
                   @class([
                     'flex items-center gap-3 px-3 py-2 rounded-xl transition',
                     'bg-amber-100 text-amber-800 ring-1 ring-amber-200' => request()->routeIs('admin.pelanggan.*'),
                     'text-stone-700 hover:bg-amber-50 hover:text-amber-700' => !request()->routeIs('admin.pelanggan.*'),
                   ])>
                  <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M16 11V7a4 4 0 10-8 0v4M5 11h14v9H5z"/>
                  </svg>
                  <span>Pelanggan</span>
                </a>

                <a href="{{ route('admin.karyawan.index') }}"
                   @class([
                     'flex items-center gap-3 px-3 py-2 rounded-xl transition',
                     'bg-amber-100 text-amber-800 ring-1 ring-amber-200' => request()->routeIs('admin.karyawan.*'),
                     'text-stone-700 hover:bg-amber-50 hover:text-amber-700' => !request()->routeIs('admin.karyawan.*'),
                   ])>
                  <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M12 14l9-5-9-5-9 5 9 5zM12 14v7"/>
                  </svg>
                  <span>Karyawan</span>
                </a>

                <a href="{{ route('admin.orders.index') }}"
                   @class([
                     'flex items-center gap-3 px-3 py-2 rounded-xl transition',
                     'bg-amber-100 text-amber-800 ring-1 ring-amber-200' => request()->routeIs('admin.orders.*'),
                     'text-stone-700 hover:bg-amber-50 hover:text-amber-700' => !request()->routeIs('admin.orders.*'),
                   ])>
                  <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M3 7h18M3 12h18M3 17h18"/>
                  </svg>
                  <span>Order</span>
                </a>
            </div>
        @endif
      </nav>

      <div class="mt-auto p-4 border-t border-stone-200">
        <form action="{{ route('logout') }}" method="POST">
          @csrf
          <button type="submit"
                  class="w-full inline-flex items-center justify-center gap-2 rounded-xl border border-red-200 text-red-600 hover:bg-red-50 px-4 py-2 font-medium transition">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
            </svg>
            Logout
          </button>
        </form>
      </div>
    </aside>

    {{-- ===== Content area ===== --}}
    <div class="flex-1 flex flex-col lg:pl-72">

      {{-- Topbar --}}
      <header class="sticky top-0 z-30 bg-white/70 backdrop-blur border-b border-stone-200">
        <div class="h-16 px-4 lg:px-8 flex items-center justify-between">
          <div class="flex items-center gap-3">
            <button class="lg:hidden inline-flex items-center justify-center h-10 w-10 rounded-xl border border-stone-300"
                    onclick="toggleSidebar()">
              <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
            <h1 class="text-lg lg:text-xl font-semibold">@yield('page-title','Dashboard')</h1>
          </div>

          <div class="flex items-center gap-3">
            @php
                $displayName = $user->name ?? 'Tamu';
            @endphp
            <span class="hidden sm:block text-sm text-stone-500">Hello, {{ $displayName }}</span>
            <img src="https://ui-avatars.com/api/?name={{ urlencode($displayName) }}&background=EAB308&color=111827"
                 class="w-9 h-9 rounded-full ring-2 ring-amber-400/40" alt="avatar">
          </div>
        </div>
      </header>

      {{-- Main --}}
      <main class="p-4 lg:p-8 flex-1">
        @yield('content')
      </main>
    </div>
  </div>

  {{-- Mobile drawer backdrop --}}
  <div id="backdrop" class="fixed inset-0 bg-black/40 hidden z-30 lg:hidden" onclick="toggleSidebar()"></div>

  @stack('scripts')

  <script>
    const sb   = document.getElementById('sidebar');
    const bd   = document.getElementById('backdrop');
    function toggleSidebar() {
      const open = sb.classList.contains('hidden');
      if (open) {
        sb.classList.remove('hidden');
        sb.classList.add('flex');
        sb.classList.add('animate-[slideIn_.2s_ease-out]');
        bd.classList.remove('hidden');
      } else {
        sb.classList.add('hidden');
        sb.classList.remove('flex');
        bd.classList.add('hidden');
      }
    }
  </script>

  <style>
    @keyframes slideIn { from { transform: translateX(-12px); opacity:.6 } to { transform: translateX(0); opacity:1 } }
  </style>
</body>
</html>