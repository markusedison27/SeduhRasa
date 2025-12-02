<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title', 'SeduhRasa Panel')</title>

  {{-- Favicon --}}
  <link rel="icon" type="image/png" href="{{ asset('LOGO2.png') }}">
  <link rel="apple-touch-icon" href="{{ asset('LOGO2.png') }}">
  
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  
  <style>
    /* Animations */
    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    @keyframes slideIn {
      from { transform: translateX(-10px); opacity: 0; }
      to { transform: translateX(0); opacity: 1; }
    }
    @keyframes pulse {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.5; }
    }
    
    /* Custom scrollbar */
    ::-webkit-scrollbar { width: 8px; height: 8px; }
    ::-webkit-scrollbar-track { background: #F6F2EC; }
    ::-webkit-scrollbar-thumb { background: #C67C4E; border-radius: 4px; }
    ::-webkit-scrollbar-thumb:hover { background: #A0623C; }

    /* Sidebar mobile toggle */
    #sidebar-mobile {
      transform: translateX(-100%);
      transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    #sidebar-mobile.show {
      transform: translateX(0);
    }

    /* Nav link hover effect */
    .nav-link {
      transition: all 0.2s ease;
      position: relative;
    }
    .nav-link:hover {
      transform: translateX(4px);
    }
    .nav-link.active::before {
      content: '';
      position: absolute;
      left: -16px;
      top: 50%;
      transform: translateY(-50%);
      width: 4px;
      height: 60%;
      background: linear-gradient(180deg, #C67C4E, #8B5E3C);
      border-radius: 0 2px 2px 0;
    }
  </style>
  
  @stack('styles')
</head>
<body class="bg-stone-50 text-stone-800 antialiased">
  <div class="min-h-screen flex">
    @php
        $user = auth()->user();

        if (!$user) {
            $dashboardRoute = 'home';
            $displayName = 'Tamu';
            $role = 'Guest';
        } elseif ($user->role === 'super_admin') {
            $dashboardRoute = 'super.dashboard';
            $displayName = $user->name;
            $role = 'Super Admin';
        } elseif ($user->role === 'owner') {
            $dashboardRoute = 'owner.dashboard';
            $displayName = $user->name;
            $role = 'Owner';
        } else {
            $dashboardRoute = 'staff.dashboard';
            $displayName = $user->name;
            $role = 'Panel Kasir';
        }
    @endphp

    {{-- Sidebar Desktop --}}
    <aside id="sidebar"
      class="fixed inset-y-0 left-0 z-40 w-72 hidden lg:flex flex-col bg-gradient-to-br from-[#2B1B12] via-[#3D2817] to-[#2B1B12] text-white shadow-2xl">
      
      {{-- Brand dengan Logo --}}
      <div class="p-6 border-b border-white/10">
        <a href="{{ route($dashboardRoute) }}" class="flex items-center gap-3 hover:opacity-90 transition">
          <div class="relative">
            <img src="{{ asset('LOGO2.png') }}" class="h-12 w-12 rounded-2xl object-cover shadow-lg" alt="SeduhRasa Logo">
            <div class="absolute -top-1 -right-1 h-4 w-4 bg-green-500 rounded-full border-2 border-[#2B1B12] animate-pulse"></div>
          </div>
          <div>
            <div class="text-lg font-bold">SeduhRasa</div>
            <div class="text-xs text-white/60">{{ $role }}</div>
          </div>
        </a>
      </div>

      {{-- Navigation --}}
      <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
        <div class="text-xs font-semibold uppercase tracking-wider text-white/40 px-3 mb-3">
          Navigasi
        </div>
        
        <a href="{{ route($dashboardRoute) }}"
           @class([
               'nav-link flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium',
               'active bg-white/10 text-white backdrop-blur' => request()->routeIs($dashboardRoute),
               'text-white/70 hover:bg-white/5 hover:text-white' => !request()->routeIs($dashboardRoute),
           ])>
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
          </svg>
          <span>Dashboard</span>
        </a>

        {{-- SUPER ADMIN --}}
        @if($user && $user->role === 'super_admin')
          <div class="text-xs font-semibold uppercase tracking-wider text-white/40 px-3 mb-3 mt-6">
            Manajemen User
          </div>
          
          <a href="{{ route('super.owners.index') }}"
             @class([
                 'nav-link flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium',
                 'active bg-white/10 text-white backdrop-blur' => request()->routeIs('super.owners.*'),
                 'text-white/70 hover:bg-white/5 hover:text-white' => !request()->routeIs('super.owners.*'),
             ])>
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            <span>Pemilik Coffee Shop</span>
          </a>

        {{-- OWNER --}}
        @elseif($user && $user->role === 'owner')
          <div class="text-xs font-semibold uppercase tracking-wider text-white/40 px-3 mb-3 mt-6">
            Manajemen Usaha
          </div>
          
          <a href="{{ route('owner.finance') }}"
             @class([
                 'nav-link flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium',
                 'active bg-white/10 text-white backdrop-blur' => request()->routeIs('owner.finance'),
                 'text-white/70 hover:bg-white/5 hover:text-white' => !request()->routeIs('owner.finance'),
             ])>
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>Keuangan</span>
          </a>
          
          <a href="{{ route('owner.kasir.index') }}"
             @class([
                 'nav-link flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium',
                 'active bg-white/10 text-white backdrop-blur' => request()->routeIs('owner.kasir.*'),
                 'text-white/70 hover:bg-white/5 hover:text-white' => !request()->routeIs('owner.kasir.*'),
             ])>
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            <span>Kelola Kasir</span>
          </a>

        {{-- STAFF / KASIR / ADMIN --}}
        @else
          <div class="text-xs font-semibold uppercase tracking-wider text-white/40 px-3 mb-3 mt-6">
            Manajemen Data
          </div>
          
          <a href="{{ route('admin.menus.index') }}"
             @class([
                 'nav-link flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium',
                 'active bg-white/10 text-white backdrop-blur' => request()->routeIs('admin.menus.*'),
                 'text-white/70 hover:bg-white/5 hover:text-white' => !request()->routeIs('admin.menus.*'),
             ])>
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
            </svg>
            <span>Menu</span>
          </a>

          <a href="{{ route('admin.transaksi.index') }}"
             @class([
                 'nav-link flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium',
                 'active bg-white/10 text-white backdrop-blur' => request()->routeIs('admin.transaksi.*'),
                 'text-white/70 hover:bg-white/5 hover:text-white' => !request()->routeIs('admin.transaksi.*'),
             ])>
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            <span>Transaksi</span>
          </a>

          <a href="{{ route('admin.pelanggan.index') }}"
             @class([
                 'nav-link flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium',
                 'active bg-white/10 text-white backdrop-blur' => request()->routeIs('admin.pelanggan.*'),
                 'text-white/70 hover:bg-white/5 hover:text-white' => !request()->routeIs('admin.pelanggan.*'),
             ])>
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            <span>Pelanggan</span>
          </a>

          {{-- ⚠️ Karyawan DIHAPUS di sini --}}

          <a href="{{ route('admin.orders.index') }}"
             @class([
                 'nav-link flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium',
                 'active bg-white/10 text-white backdrop-blur' => request()->routeIs('admin.orders.*'),
                 'text-white/70 hover:bg-white/5 hover:text-white' => !request()->routeIs('admin.orders.*'),
             ])>
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
            </svg>
            <span>Order</span>
          </a>

          <a href="{{ route('admin.messages.index') }}"
             @class([
                 'nav-link flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium',
                 'active bg-white/10 text-white backdrop-blur' => request()->routeIs('admin.messages.*'),
                 'text-white/70 hover:bg-white/5 hover:text-white' => !request()->routeIs('admin.messages.*'),
             ])>
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 10h8M8 14h5M5 5h14a2 2 0 012 2v8a2 2 0 01-2 2h-6l-4 3v-3H5a2 2 0 01-2-2V7a2 2 0 012-2z"/>
            </svg>
            <span>Pesan</span>
          </a>
        @endif
      </nav>

      {{-- Logout --}}
      <div class="p-4 border-t border-white/10">
        <form action="{{ route('logout') }}" method="POST">
          @csrf
          <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-red-500/20 hover:bg-red-500/30 text-red-200 hover:text-white font-medium transition-all">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
            </svg>
            Logout
          </button>
        </form>
      </div>
    </aside>

    {{-- Content Area --}}
    <div class="flex-1 flex flex-col lg:pl-72">
      {{-- Top Bar --}}
      <header class="sticky top-0 z-30 bg-white/80 backdrop-blur-xl border-b border-stone-200 shadow-sm">
        <div class="h-16 px-4 lg:px-8 flex items-center justify-between">
          <div class="flex items-center gap-4">
            <button class="lg:hidden p-2 rounded-lg hover:bg-stone-100 transition-colors" onclick="toggleSidebar()">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
              </svg>
            </button>
            <h1 class="text-lg lg:text-xl font-semibold text-stone-800">@yield('page-title','Dashboard')</h1>
          </div>

          <div class="flex items-center gap-3">
            {{-- Notifikasi Order --}}
            <div class="relative" id="notif-wrapper">
              <button
                  id="notif-button"
                  type="button"
                  class="relative p-2 rounded-xl hover:bg-stone-100 transition-colors"
              >
                  <svg class="w-6 h-6 text-stone-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                  </svg>

                  {{-- titik merah (kalau ada pending) --}}
                  <span id="notif-dot"
                        class="hidden absolute top-1.5 right-1.5 h-2 w-2 bg-red-500 rounded-full"></span>
              </button>

              {{-- Dropdown notifikasi --}}
              <div
                  id="notif-dropdown"
                  class="hidden absolute right-0 mt-2 w-80 bg-white rounded-2xl shadow-xl border border-stone-200 z-40"
              >
                  <div class="px-4 py-3 border-b border-stone-100 flex items-center justify-between">
                      <div>
                          <p class="text-sm font-semibold text-stone-800">Notifikasi Pesanan</p>
                          <p class="text-xs text-stone-500">Order pending terbaru</p>
                      </div>
                      <button
                          type="button"
                          id="notif-refresh"
                          class="text-xs text-amber-600 hover:text-amber-700 font-medium"
                      >
                          Refresh
                      </button>
                  </div>

                  <div id="notif-list" class="max-h-80 overflow-y-auto divide-y divide-stone-100">
                      <div class="px-4 py-3 text-xs text-stone-500">
                          Memuat notifikasi...
                      </div>
                  </div>

                  <div class="px-4 py-2 border-t border-stone-100 text-center">
                      <a href="{{ route('admin.orders.index') }}"
                         class="text-xs text-amber-600 hover:text-amber-700 font-medium">
                          Lihat semua order
                      </a>
                  </div>
              </div>
            </div>
            
            <div class="hidden sm:flex items-center gap-3 pl-3 border-l border-stone-200">
              <div class="text-right">
                <div class="text-sm font-medium text-stone-800">{{ $displayName }}</div>
                <div class="text-xs text-stone-500">{{ $role }}</div>
              </div>
              <img src="https://ui-avatars.com/api/?name={{ urlencode($displayName) }}&background=C67C4E&color=fff" 
                   class="w-10 h-10 rounded-full ring-2 ring-amber-200" alt="Avatar">
            </div>
          </div>
        </div>
      </header>

      {{-- Main Content --}}
      <main class="p-4 lg:p-8 flex-1">
        @yield('content')
      </main>
    </div>
  </div>

  {{-- Mobile Backdrop --}}
  <div id="backdrop" class="fixed inset-0 bg-black/40 hidden z-30 lg:hidden" onclick="toggleSidebar()"></div>

  @stack('scripts')

  <script>
    const sidebar = document.getElementById('sidebar');
    const backdrop = document.getElementById('backdrop');
    
    function toggleSidebar() {
      const isHidden = sidebar.classList.contains('hidden');
      if (isHidden) {
        sidebar.classList.remove('hidden');
        sidebar.classList.add('flex');
        backdrop.classList.remove('hidden');
      } else {
        sidebar.classList.add('hidden');
        sidebar.classList.remove('flex');
        backdrop.classList.add('hidden');
      }
    }

    // === Notifikasi lonceng ===
    document.addEventListener('DOMContentLoaded', () => {
      const notifWrapper = document.getElementById('notif-wrapper');
      const notifBtn     = document.getElementById('notif-button');
      const notifDrop    = document.getElementById('notif-dropdown');
      const notifDot     = document.getElementById('notif-dot');
      const notifList    = document.getElementById('notif-list');
      const notifRefresh = document.getElementById('notif-refresh');

      if (!notifWrapper || !notifBtn || !notifDrop || !notifList) {
        return;
      }

      const notifUrl = "{{ route('notifications.orders') }}";

      function toggleDropdown() {
        notifDrop.classList.toggle('hidden');
      }

      function closeDropdown() {
        if (!notifDrop.classList.contains('hidden')) {
          notifDrop.classList.add('hidden');
        }
      }

      notifBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        toggleDropdown();
      });

      document.addEventListener('click', (e) => {
        if (!notifWrapper.contains(e.target)) {
          closeDropdown();
        }
      });

      function renderNotifications(data) {
        // update titik merah
        if (data.count > 0) {
          notifDot.classList.remove('hidden');
        } else {
          notifDot.classList.add('hidden');
        }

        if (!data.items || data.items.length === 0) {
          notifList.innerHTML = `
            <div class="px-4 py-3 text-xs text-stone-500">
              Tidak ada order pending.
            </div>
          `;
          return;
        }

        let html = '';
        data.items.forEach(item => {
          html += `
            <a href="${item.url}"
               class="block px-4 py-3 hover:bg-stone-50 text-sm">
              <div class="font-semibold text-stone-800">${item.title}</div>
              <div class="text-xs text-stone-500">${item.subtitle}</div>
              <div class="text-[11px] text-stone-400 mt-0.5">${item.time}</div>
            </a>
          `;
        });

        notifList.innerHTML = html;
      }

      function loadNotifications() {
        notifList.innerHTML = `
          <div class="px-4 py-3 text-xs text-stone-500">
            Memuat notifikasi...
          </div>
        `;

        fetch(notifUrl)
          .then(res => res.json())
          .then(data => {
            renderNotifications(data);
          })
          .catch(err => {
            console.error('Gagal load notif:', err);
            notifList.innerHTML = `
              <div class="px-4 py-3 text-xs text-red-500">
                Gagal memuat notifikasi.
              </div>
            `;
          });
      }

      // load pertama
      loadNotifications();

      // tombol refresh manual
      notifRefresh?.addEventListener('click', (e) => {
        e.stopPropagation();
        loadNotifications();
      });

      // auto refresh tiap 20 detik (opsional)
      setInterval(loadNotifications, 20000);
    });
  </script>
</body>
</html>
