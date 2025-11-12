<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title','SeduhRasa')</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
  <style>
    :root{
      --latte:#F6F2EC; --foam:#EADCCF; --caramel:#C67C4E; --espresso:#7B3F00;
    }
    body{ background:var(--latte); }

    /* ===== Canvas background ===== */
    .scene{ position:fixed; inset:0; z-index:-1; overflow:hidden; }
    /* big soft radial gradient */
    .radial{
      position:absolute; inset:-20%;
      background:
        radial-gradient(1200px 800px at 15% 10%, #f1e6d7, transparent 65%),
        radial-gradient(1200px 900px at 85% 90%, #ecd9c0, transparent 60%),
        linear-gradient(180deg, #f7f1ea 0%, #f3ece4 100%);
    }
    /* fine grain for premium feel */
    .grain{
      position:absolute; inset:0; opacity:.07; mix-blend-mode:multiply; pointer-events:none;
      background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='120' height='120' viewBox='0 0 120 120'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='2' stitchTiles='stitch'/%3E%3CfeColorMatrix type='saturate' values='0'/%3E%3C/filter%3E%3Crect width='120' height='120' filter='url(%23n)' opacity='0.25'/%3E%3C/svg%3E");
      animation: grainMove 18s linear infinite;
    }
    @keyframes grainMove{
      0%{transform:translate3d(0,0,0)}100%{transform:translate3d(-120px,-120px,0)}
    }

    /* subtle dots */
    .dots{ position:absolute; inset:0; opacity:.12;
      background-image: radial-gradient(#cdbfae 1.1px, transparent 1.1px);
      background-size: 20px 20px;
      mask-image: radial-gradient(circle at 50% 50%, #000 50%, transparent 80%);
      animation: dotsPan 40s linear infinite;
    }
    @keyframes dotsPan{ 0%{background-position:0 0}100%{background-position:200px 200px}}

    /* spotlight following cursor (very soft) */
    .spotlight{
      --x:50%; --y:50%;
      position:absolute; inset:0; pointer-events:none; opacity:.28;
      background: radial-gradient(500px 500px at var(--x) var(--y), rgba(255,255,255,.65), transparent 60%);
      transition: opacity .25s ease;
    }

    @media (prefers-reduced-motion: reduce){
      .grain,.dots{ animation:none!important }
    }
  </style>
</head>
<body class="antialiased text-stone-800">
  <div class="scene">
    <div class="radial"></div>
    <div class="grain"></div>
    <div class="dots"></div>
    <div class="spotlight" id="spot"></div>
  </div>

  <main class="relative min-h-screen flex items-center justify-center p-6">
    @yield('content')
  </main>

  <script>
    // Spotlight follow cursor (non-intrusive)
    const s = document.getElementById('spot');
    const preferReduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (s && !preferReduce) {
      window.addEventListener('pointermove', (e) => {
        const x = (e.clientX / window.innerWidth) * 100;
        const y = (e.clientY / window.innerHeight) * 100;
        s.style.setProperty('--x', x + '%');
        s.style.setProperty('--y', y + '%');
      }, { passive: true });
    }
  </script>
</body>
</html>
