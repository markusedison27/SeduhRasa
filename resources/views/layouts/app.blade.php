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
              // kalau belum login, pakai home saja
              $dashboardRoute = 'home';
          } elseif ($user->role === 'super_admin') {
              $dashboardRoute = 'super.dashboard';
          } elseif ($user->role === 'owner') {
              $dashboardRoute = 'owner.dashboard';
          } else {
              // default: staff/kasir
              $dashboardRoute = 'staff.dashboard';
          }
      @endphp

      <nav class="p-4 space-y-3 flex-1 overflow-y-auto">
        {{-- Navigasi Panel --}}
        <div class="text-xs font-semibold uppercase tracking-wider text-stone-400 px-2">Navigasi Panel</div>

        {{-- Link: Dashboard (menyesuaikan role) --}}
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

        {{-- ===== MENU BERDASARKAN ROLE ===== --}}
        @if($user && $user->role === 'super_admin')
          {{-- SUPER ADMIN: hanya manajemen pemilik --}}
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


                {{-- Link: Dashboard --}}
@if (Route::has('dashboard'))
    <a href="{{ route('dashboard') }}"
        @class([
            'flex items-center gap-3 px-3 py-2 rounded-xl transition group',
            'bg-amber-100 text-amber-800 ring-1 ring-amber-200' => request()->routeIs('dashboard'),
            'text-stone-700 hover:bg-amber-50 hover:text-amber-700' => !request()->routeIs('dashboard'),
        ])>
@else
    <a href="#"
        @class([
            'flex items-center gap-3 px-3 py-2 rounded-xl transition group',
            'text-stone-700 hover:bg-amber-50 hover:text-amber-700',
        ])>
@endif

                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        {{-- Icon Home --}}
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2 7-7 7 7 2 2v8a2 2 0 01-2 2h-3a2 2 0 01-2-2v-3H9v3a2 2 0 01-2 2H5a2 2 0 01-2-2v-8z" />
                    </svg>
                    <span>Dashboard</span>
                </a>

                <div class="pt-2">
                    <div class="text-xs font-semibold uppercase tracking-wider text-stone-400 px-2 mb-1">Manajemen Data</div>

                    {{-- Link: Menu --}}
                    <a href="{{ route('admin.menus.index') }}"
                        @class([
                            'flex items-center gap-3 px-3 py-2 rounded-xl transition group',
                            'bg-amber-100 text-amber-800 ring-1 ring-amber-200' => request()->routeIs('admin.menus.*'),
                            'text-stone-700 hover:bg-amber-50 hover:text-amber-700' => !request()->routeIs('admin.menus.*'),
                        ])>
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            {{-- Icon Menu --}}
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <span>Menu</span>
                    </a>

                    {{-- Link: Transaksi --}}
                    <a href="{{ route('admin.transaksi.index') }}"
                        @class([
                            'flex items-center gap-3 px-3 py-2 rounded-xl transition group',
                            'bg-amber-100 text-amber-800 ring-1 ring-amber-200' => request()->routeIs('admin.transaksi.*'),
                            'text-stone-700 hover:bg-amber-50 hover:text-amber-700' => !request()->routeIs('admin.transaksi.*'),
                        ])>
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            {{-- Icon Transaksi --}}
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8V6m0 12v-2" />
                        </svg>
                        <span>Transaksi</span>
                    </a>

                    {{-- Link: Pelanggan --}}
                    <a href="{{ route('admin.pelanggan.index') }}"
                        @class([
                            'flex items-center gap-3 px-3 py-2 rounded-xl transition group',
                            'bg-amber-100 text-amber-800 ring-1 ring-amber-200' => request()->routeIs('admin.pelanggan.*'),
                            'text-stone-700 hover:bg-amber-50 hover:text-amber-700' => !request()->routeIs('admin.pelanggan.*'),
                        ])>
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            {{-- Icon Users --}}
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span>Pelanggan</span>
                    </a>

                    {{-- Link: Karyawan --}}
                    <a href="{{ route('admin.karyawan.index') }}"
                        @class([
                            'flex items-center gap-3 px-3 py-2 rounded-xl transition group',
                            'bg-amber-100 text-amber-800 ring-1 ring-amber-200' => request()->routeIs('admin.karyawan.*'),
                            'text-stone-700 hover:bg-amber-50 hover:text-amber-700' => !request()->routeIs('admin.karyawan.*'),
                        ])>
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            {{-- Icon Briefcase / Job --}}
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.593 23.593 0 0112 15c-3.18 0-6.357-.492-9-1.745V20a2 2 0 002 2h14a2 2 0 002-2v-6.745zM16 11V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        <span>Karyawan</span>
                    </a>

                    {{-- Link: Order --}}
                    <a href="{{ route('admin.orders.index') }}"
                        @class([
                            'flex items-center gap-3 px-3 py-2 rounded-xl transition group',
                            'bg-amber-100 text-amber-800 ring-1 ring-amber-200' => request()->routeIs('admin.orders.*'),
                            'text-stone-700 hover:bg-amber-50 hover:text-amber-700' => !request()->routeIs('admin.orders.*'),
                        ])>
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            {{-- Icon Clipboard List --}}
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M10 15h.01" />
                        </svg>
                        <span>Order</span>
                    </a>
                </div>
            </nav>

            {{-- Logout Button --}}
            <div class="mt-auto p-4 border-t border-stone-200">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                            class="w-full inline-flex items-center justify-center gap-2 rounded-xl border border-red-300 text-red-600 hover:bg-red-50 px-4 py-2 font-medium transition">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Logout
                    </button>
                </form>

        @else
          {{-- OWNER / STAFF: manajemen data biasa --}}
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
                  class="w-full inline-flex items-center justify-center gap-2 rounded-xl border border-red-200 text-red-600 hover:bg-red-50 px-4 py-2 font-medium">
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
    // Sidebar toggle for mobile
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
    /* small slide-in animation for sidebar */
    @keyframes slideIn { from { transform: translateX(-12px); opacity:.6 } to { transform: translateX(0); opacity:1 } }
  </style>
</body>
</html>



