{{-- resources/views/menu.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Menu • SeduhRasa</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
  <link href="https://fonts.bunny.net/css?family=playfair-display:700" rel="stylesheet"/>
</head>
<body class="bg-stone-50 text-stone-900">

  @php
    // =======================
    // DATA MENU
    $menu = [
      [
        'title' => 'Mocktail & Tea',
        'items' => [
          ['name'=>'Early Berry',       'price'=>'28K', 'img'=>'https://images.unsplash.com/photo-1514362545857-3bc16c4c76f2?w=900&q=80&auto=format&fit=crop', 'serve'=>['Dingin']],
          ['name'=>'Lazy Bones',        'price'=>'25K', 'img'=>'https://images.unsplash.com/photo-1541976076758-347942db1970?w=900&q=80&auto=format&fit=crop', 'serve'=>['Dingin']],
          ['name'=>'Lemon Slayer',      'price'=>'25K', 'img'=>'https://images.unsplash.com/photo-1497534446932-c925b458314e?w=900&q=80&auto=format&fit=crop', 'serve'=>['Dingin']],
          ['name'=>'Ocean Blue',        'price'=>'30K', 'img'=>'https://images.unsplash.com/photo-1508253578933-a0b73d55d0f0?w=900&q=80&auto=format&fit=crop', 'serve'=>['Dingin']],
          ['name'=>'Sweet Shour',       'price'=>'30K', 'img'=>'https://images.unsplash.com/photo-1517677208171-0bc6725a3e60?w=900&q=80&auto=format&fit=crop', 'serve'=>['Dingin']],
          ['name'=>'Monalisa',          'price'=>'30K', 'img'=>'https://images.unsplash.com/photo-1544145945-f90425340c7e?w=900&q=80&auto=format&fit=crop', 'serve'=>['Dingin']],
          ['name'=>'Kiwi Mojito',       'price'=>'25K', 'img'=>'https://images.unsplash.com/photo-1556679343-c7306c71a929?w=900&q=80&auto=format&fit=crop', 'serve'=>['Dingin']],
          ['name'=>'Peach Tea',         'price'=>'18K', 'img'=>'https://images.unsplash.com/photo-1506059612708-99d6c258160e?w=900&q=80&auto=format&fit=crop', 'serve'=>['Dingin','Panas']],
          ['name'=>'Lychee Tea',        'price'=>'18K', 'img'=>'https://images.unsplash.com/photo-1540148426945-6cf190134e84?w=900&q=80&auto=format&fit=crop', 'serve'=>['Dingin']],
          ['name'=>'Blackcurrant Tea',  'price'=>'20K', 'img'=>'https://images.unsplash.com/photo-1517701604599-bb29b565090c?w=900&q=80&auto=format&fit=crop', 'serve'=>['Dingin']],
        ],
      ],
      [
        'title' => 'Desserts',
        'items' => [
          [
            'name'=>'Chocolate Cake','price'=>'15K',
            'desc'=>'Chocolate cake sprinkled with grated cheese mixture',
            'img'=>'https://images.unsplash.com/photo-1606313564200-e75d5e30476a?w=900&q=80&auto=format&fit=crop'
          ],
          [
            'name'=>'Greentea Lumer','price'=>'15K',
            'desc'=>'Greentea dessert with sprinkled greentea mixture',
            'img'=>'https://images.unsplash.com/photo-1551024506-0bccd828d307?w=900&q=80&auto=format&fit=crop'
          ],
          [
            'name'=>'Tiramisu Malted','price'=>'15K',
            'desc'=>'Tiramisu dessert with a mixture of milk and eggs',
            'img'=>'https://images.unsplash.com/photo-1612208695882-03a6b3e561b0?w=900&q=80&auto=format&fit=crop'
          ],
        ],
      ],
      [
        'title' => 'Kitchen Menu',
        'items' => [
          ['name'=>'Chicken Butter','price'=>'33K','img'=>'https://images.unsplash.com/photo-1529042410759-befb1204b468?w=900&q=80&auto=format&fit=crop'],
          ['name'=>'Chicken Garlic','price'=>'28K','img'=>'https://images.unsplash.com/photo-1604908554007-83e9b06bfa4e?w=900&q=80&auto=format&fit=crop'],
          ['name'=>'Chicken Teriyaki','price'=>'25K','img'=>'https://images.unsplash.com/photo-1512058564366-18510be2db19?w=900&q=80&auto=format&fit=crop'],
          ['name'=>'Chicken Black Paper','price'=>'28K','img'=>'https://images.unsplash.com/photo-1588167056547-c183313da9ce?w=900&q=80&auto=format&fit=crop'],
          ['name'=>'Chicken Fried Rice','price'=>'25K','img'=>'https://images.unsplash.com/photo-1544025162-d76694265947?w=900&q=80&auto=format&fit=crop'],
          ['name'=>'Chicken Matah','price'=>'28K','img'=>'https://images.unsplash.com/photo-1498654077810-12f43e6555ab?w=900&q=80&auto=format&fit=crop'],
        ],
      ],
      [
        'title' => 'Cemilan',
        'items' => [
          ['name'=>'Chicken Strip','price'=>'20K','img'=>'https://images.unsplash.com/photo-1606756790138-261d2b21cd75?w=900&q=80&auto=format&fit=crop'],
          ['name'=>'Mix','price'=>'30K','img'=>'https://images.unsplash.com/photo-1544025162-d76694265947?w=900&q=80&auto=format&fit=crop'],
          ['name'=>'French Fries','price'=>'15K','img'=>'https://images.unsplash.com/photo-1541592106381-b31e9677c0e5?w=900&q=80&auto=format&fit=crop'],
        ],
      ],
      [
        'title' => 'Dimsum',
        'items' => [
          ['name'=>'Dimsum Telur Asin','price'=>'28K','img'=>'https://images.unsplash.com/photo-1551183053-bf91a1d81141?w=900&q=80&auto=format&fit=crop'],
          ['name'=>'Dimsum Ayam','price'=>'26K','img'=>'https://images.unsplash.com/photo-1581287053822-834b9d6f2d7d?w=900&q=80&auto=format&fit=crop'],
          ['name'=>'Dimsum Rumput Laut','price'=>'30K','img'=>'https://images.unsplash.com/photo-1604908554007-83e9b06bfa4e?w=900&q=80&auto=format&fit=crop'],
          ['name'=>'Mix Dimsum','price'=>'35K','img'=>'https://images.unsplash.com/photo-1625944528100-1c0e1d233a7a?w=900&q=80&auto=format&fit=crop'],
          ['name'=>'Dimsum Kepiting','price'=>'25K','img'=>'https://images.unsplash.com/photo-1617093727343-bf2e2c58e445?w=900&q=80&auto=format&fit=crop'],
          ['name'=>'Dimsum Udang','price'=>'25K','img'=>'https://images.unsplash.com/photo-1617195737493-6a5f7e9de86c?w=900&q=80&auto=format&fit=crop'],
        ],
      ],
      [
        'title' => 'Mie',
        'items' => [
          [
            'name'=>'Spaghetti Carbonara','price'=>'35K',
            'desc'=>'Spaghetti with a mixture of cheese, milk and eggs.',
            'img'=>'https://images.unsplash.com/photo-1526312426976-593c2b999512?w=900&q=80&auto=format&fit=crop'
          ],
          [
            'name'=>'Spaghetti Bolognese','price'=>'30K',
            'desc'=>'Spaghetti with a mixture of bolognese sauce and a sprinkling of parsley.',
            'img'=>'https://images.unsplash.com/photo-1523986371872-9d3ba2e2f642?w=900&q=80&auto=format&fit=crop'
          ],
          [
            'name'=>'Mie Yamin Noodle','price'=>'28K',
            'desc'=>'Mix noodles with fish oil, garlic oil, and dumplings',
            'img'=>'https://images.unsplash.com/photo-1544025162-68df1a6f7c5c?w=900&q=80&auto=format&fit=crop'
          ],
          [
            'name'=>'Lecca Fried Noodle','price'=>'20K',
            'desc'=>'Fried noodles cooked with chili sauce and egg.',
            'img'=>'https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=900&q=80&auto=format&fit=crop'
          ],
        ],
      ],
      [
        'title' => 'Coffee',
        'items' => [
          ['name'=>'Americano',            'price'=>'20K','img'=>'https://images.unsplash.com/photo-1498804103079-a6351b050096?w=900&q=80&auto=format&fit=crop', 'serve'=>['Dingin','Panas']],
          ['name'=>'Cafe Latte',           'price'=>'23K','img'=>'https://images.unsplash.com/photo-1541167760496-1628856ab772?w=900&q=80&auto=format&fit=crop', 'serve'=>['Dingin','Panas']],
          ['name'=>'Butterscotch',         'price'=>'25K','img'=>'https://images.unsplash.com/photo-1517705008128-361805f42e86?w=900&q=80&auto=format&fit=crop', 'serve'=>['Panas']],
          ['name'=>'Classic Caramel Latte','price'=>'23K','img'=>'https://images.unsplash.com/photo-1514432324607-a09d9b4aefdd?w=900&q=80&auto=format&fit=crop', 'serve'=>['Dingin','Panas']],
          ['name'=>'Halzenut Brown Sugar', 'price'=>'26K','img'=>'https://images.unsplash.com/photo-1512568400610-62da28bc8a13?w=900&q=80&auto=format&fit=crop', 'serve'=>['Dingin']],
          ['name'=>'Lecca Sweet Latte',    'price'=>'26K','img'=>'https://images.unsplash.com/photo-1534777410147-084c3f5f3d07?w=900&q=80&auto=format&fit=crop', 'serve'=>['Panas']],
          ['name'=>'Sweet Corn Latte',     'price'=>'26K','img'=>'https://images.unsplash.com/photo-1512207846876-c6c77755f5b9?w=900&q=80&auto=format&fit=crop', 'serve'=>['Dingin','Panas']],
        ],
      ],
    ];

    $placeholder = 'https://images.unsplash.com/photo-1509042239860-f550ce710b93?q=80&w=600&auto=format&fit=crop';
  @endphp

  {{-- HERO MINI --}}
  <section class="relative">
    <div class="h-48 md:h-56 w-full overflow-hidden">
      <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1509042239860-f550ce710b93?q=80&w=1600&auto=format&fit=crop')] bg-cover bg-center"></div>
      <div class="absolute inset-0 bg-stone-900/60"></div>
      <div class="relative z-10 h-full max-w-7xl mx-auto px-4 flex items-center">
        <h1 class="text-white text-3xl md:text-5xl font-['Playfair_Display']">Menu</h1>
      </div>
    </div>
  </section>

  {{-- GRID MENU (Kategori -> Card) --}}
  <main class="max-w-7xl mx-auto px-4 py-10">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      @foreach($menu as $group)
        <div class="bg-white/90 backdrop-blur rounded-xl border shadow-sm overflow-hidden">
          <div class="px-5 py-4 border-b">
            <h2 class="font-semibold tracking-wide uppercase text-stone-700">{{ $group['title'] }}</h2>
          </div>

          {{-- LIST ITEM --}}
          <ul class="divide-y">
            @foreach($group['items'] as $item)
              @php
                $src = !empty($item['img']) ? $item['img'] : $placeholder;
              @endphp
              <li class="px-5 py-4">
                <div class="flex items-center gap-4">
                  {{-- Kotak gambar konsisten (persegi) --}}
                  <div class="relative w-20 h-20 overflow-hidden rounded-lg ring-1 ring-stone-200 flex-shrink-0">
                    <img src="{{ $src }}" alt="{{ $item['name'] }}"
                         class="absolute inset-0 w-full h-full object-cover object-center">
                  </div>

                  {{-- Nama + desc + serve badges --}}
                  <div class="flex-1 min-w-0">
                    <div class="flex items-start justify-between gap-3">
                      <div class="min-w-0">
                        <div class="font-medium truncate">{{ $item['name'] }}</div>

                        {{-- BADGE DINGIN / PANAS (opsional per item) --}}
                        @if(!empty($item['serve']) && is_array($item['serve']))
                          <div class="mt-1 flex flex-wrap gap-1">
                            @foreach($item['serve'] as $s)
                              @php
                                $isCold = mb_strtolower($s) === 'dingin';
                                $classes = $isCold
                                  ? 'bg-sky-100 text-sky-700 ring-1 ring-sky-200'
                                  : 'bg-amber-100 text-amber-700 ring-1 ring-amber-200';
                              @endphp
                              <span class="inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-[10px] font-medium {{ $classes }}">
                                @if($isCold)
                                  {{-- snowflake --}}
                                  <svg class="w-3 h-3" viewBox="0 0 24 24" fill="currentColor"><path d="M11 3h2v18h-2zM4.22 6.22l1.42-1.42L12 11.17l6.36-6.37 1.42 1.42L13.41 12l6.37 6.36-1.42 1.42L12 13.41l-6.36 6.37-1.42-1.42L10.59 12 4.22 5.64z"/></svg>
                                @else
                                  {{-- flame --}}
                                  <svg class="w-3 h-3" viewBox="0 0 24 24" fill="currentColor"><path d="M13.5 0S20 5 20 11a8 8 0 1 1-16 0c0-3.5 2-6 5-8 0 0-1 4 3 6 0 0 2-3 1.5-9z"/></svg>
                                @endif
                                {{ $s }}
                              </span>
                            @endforeach
                          </div>
                        @endif

                        @if(!empty($item['desc']))
                          <div class="text-xs text-stone-500 mt-1 max-w-[46ch] overflow-hidden"
                               style="-webkit-line-clamp:2; display:-webkit-box; -webkit-box-orient:vertical;">
                            {{ $item['desc'] }}
                          </div>
                        @endif
                      </div>

                      {{-- Harga --}}
                      <div class="shrink-0 font-semibold text-stone-800 whitespace-nowrap">
                        Rp {{ $item['price'] }}
                      </div>
                    </div>
                  </div>
                </div>
              </li>
            @endforeach
          </ul>
        </div>
      @endforeach
    </div>
  </main>

  <footer class="py-8 text-center text-sm text-stone-500">
    © {{ date('Y') }} SeduhRasa Coffee. All rights reserved.
  </footer>
</body>
</html>
