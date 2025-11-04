<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title','SeduhRasa Panel')</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
  @stack('styles')
</head>
<body class="bg-stone-50 text-stone-800">
  <div class="flex min-h-screen">
    {{-- Sidebar --}}
    <aside class="w-64 bg-stone-900 text-stone-100 flex flex-col">
      <div class="p-4 border-b border-stone-800">
        <div class="text-2xl font-extrabold tracking-wide">
          Seduh<span class="text-amber-400">Rasa</span>
        </div>
        <div class="text-xs text-stone-400">admin dashboard</div>
      </div>

      <nav class="flex-1 p-4 space-y-2 text-sm">
        <a href="{{ route('dashboard') }}" class="block py-2 px-3 rounded hover:bg-stone-800">Dashboard</a>
      </nav>

      <div class="p-4 border-t border-stone-800">
        <a href="#" class="block text-center bg-amber-500 hover:bg-amber-600 text-stone-900 font-medium rounded px-3 py-2">
          Logout
        </a>
      </div>
    </aside>

    {{-- Main --}}
    <div class="flex-1 flex flex-col">
      <header class="bg-white shadow p-4 flex justify-between items-center">
        <h1 class="text-lg font-semibold">@yield('page-title','Dashboard')</h1>
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
