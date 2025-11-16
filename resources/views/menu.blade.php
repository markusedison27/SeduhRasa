{{-- resources/views/menu.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Menu • SeduhRasa</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
  <link href="https://fonts.bunny.net/css?family=dm-sans:400,600|playfair-display:700" rel="stylesheet"/>
  <style>
    :root{
      --cream:#f6efe9;      /* background */
      --latte:#d7c0ae;      /* chip/lines */
      --latte-ink:#8d6f5b;  /* text accent */
      --espresso:#3b2f2f;   /* utama btn */
      --mocha:#4b3a32;      /* hover */
      --card:#ffffffcc;     /* glass */
    }
    html{scroll-behavior:smooth}
    body{font-family:"DM Sans",ui-sans-serif,system-ui}
    .bg-canvas{
      background:
        radial-gradient(60rem 60rem at 10% -20%, rgba(0,0,0,.06), transparent 60%),
        radial-gradient(70rem 70rem at 110% 10%, rgba(0,0,0,.05), transparent 55%),
        linear-gradient(180deg, var(--cream), #fff);
    }
    .glass{
      background: var(--card);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      border: 1px solid rgba(0,0,0,.08);
      box-shadow: 0 8px 30px rgba(0,0,0,.06);
    }
    .thumb{width:82px;height:82px;border-radius:14px;overflow:hidden}
    .thumb img{width:100%;height:100%;object-fit:cover;transform:scale(1);transition:transform .35s ease}
    .thumb:hover img{transform:scale(1.05)}
    .price-pill{border:1px dashed rgba(0,0,0,.18); background:#fff8}
    .cta{
      background: linear-gradient(135deg, var(--espresso), var(--mocha));
      color:#fff; transition:transform .12s ease, opacity .12s ease;
    }
    .cta:hover{opacity:.95; transform:translateY(-1px)}
    .chip{background:#fff; border:1px solid #ead9cd; color:#5f4635}
    .stickybar{backdrop-filter:blur(10px); -webkit-backdrop-filter:blur(10px)}
    .clamp-2{display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}
  </style>
</head>
<body class="bg-canvas text-stone-900 antialiased">

@php
  /* ========= DATA MENU (boleh kamu ubah) ========= */
  $menu = [
    ['title'=>'Mocktail & Tea','items'=>[
      ['name'=>'Early Berry','price'=>'28K','img'=>'https://images.unsplash.com/photo-1514362545857-3bc16c4c76f2?w=900&q=80&auto=format&fit=crop','serve'=>['Dingin']],
      ['name'=>'Lazy Bones','price'=>'25K','img'=>'https://images.unsplash.com/photo-1541976076758-347942db1970?w=900&q=80&auto=format&fit=crop','serve'=>['Dingin']],
      ['name'=>'Lemon Slayer','price'=>'25K','img'=>'https://images.unsplash.com/photo-1497534446932-c925b458314e?w=900&q=80&auto=format&fit=crop','serve'=>['Dingin']],
      ['name'=>'Ocean Blue','price'=>'30K','img'=>'https://images.unsplash.com/photo-1508253578933-a0b73d55d0f0?w=900&q=80&auto=format&fit=crop','serve'=>['Dingin']],
      ['name'=>'Sweet Shour','price'=>'30K','img'=>'https://images.unsplash.com/photo-1517677208171-0bc6725a3e60?w=900&q=80&auto=format&fit=crop','serve'=>['Dingin']],
      ['name'=>'Monalisa','price'=>'30K','img'=>'https://images.unsplash.com/photo-1544145945-f90425340c7e?w=900&q=80&auto=format&fit=crop','serve'=>['Dingin']],
      ['name'=>'Kiwi Mojito','price'=>'25K','img'=>'https://images.unsplash.com/photo-1556679343-c7306c71a929?w=900&q=80&auto=format&fit=crop','serve'=>['Dingin']],
      ['name'=>'Peach Tea','price'=>'18K','img'=>'https://images.unsplash.com/photo-1506059612708-99d6c258160e?w=900&q=80&auto=format&fit=crop','serve'=>['Dingin','Panas']],
      ['name'=>'Lychee Tea','price'=>'18K','img'=>'https://images.unsplash.com/photo-1540148426945-6cf190134e84?w=900&q=80&auto=format&fit=crop','serve'=>['Dingin']],
      ['name'=>'Blackcurrant Tea','price'=>'20K','img'=>'https://images.unsplash.com/photo-1517701604599-bb29b565090c?w=900&q=80&auto=format&fit=crop','serve'=>['Dingin']],
    ]],
    ['title'=>'Coffee','items'=>[
      ['name'=>'Americano','price'=>'20K','img'=>'https://images.unsplash.com/photo-1498804103079-a6351b050096?w=900&q=80&auto=format&fit=crop','serve'=>['Dingin','Panas']],
      ['name'=>'Cafe Latte','price'=>'23K','img'=>'https://images.unsplash.com/photo-1541167760496-1628856ab772?w=900&q=80&auto=format&fit=crop','serve'=>['Dingin','Panas']],
      ['name'=>'Butterscotch','price'=>'25K','img'=>'https://images.unsplash.com/photo-1517705008128-361805f42e86?w=900&q=80&auto=format&fit=crop','serve'=>['Panas']],
      ['name'=>'Classic Caramel Latte','price'=>'23K','img'=>'https://images.unsplash.com/photo-1514432324607-a09d9b4aefdd?w=900&q=80&auto=format&fit=crop','serve'=>['Dingin','Panas']],
      ['name'=>'Halzenut Brown Sugar','price'=>'26K','img'=>'https://images.unsplash.com/photo-1512568400610-62da28bc8a13?w=900&q=80&auto=format&fit=crop','serve'=>['Dingin']],
      ['name'=>'Lecca Sweet Latte','price'=>'26K','img'=>'https://images.unsplash.com/photo-1534777410147-084c3f5f3d07?w=900&q=80&auto=format&fit=crop','serve'=>['Panas']],
      ['name'=>'Sweet Corn Latte','price'=>'26K','img'=>'https://images.unsplash.com/photo-1512207846876-c6c77755f5b9?w=900&q=80&auto=format&fit=crop','serve'=>['Dingin','Panas']],
    ]],
    ['title'=>'Desserts','items'=>[
      ['name'=>'Chocolate Cake','price'=>'15K','img'=>'https://images.unsplash.com/photo-1606313564200-e75d5e30476a?w=900&q=80&auto=format&fit=crop','desc'=>'Chocolate cake sprinkled with grated cheese mixture'],
      ['name'=>'Greentea Lumer','price'=>'15K','img'=>'https://images.unsplash.com/photo-1551024506-0bccd828d307?w=900&q=80&auto=format&fit=crop','desc'=>'Greentea dessert with sprinkled greentea mixture'],
      ['name'=>'Tiramisu Malted','price'=>'15K','img'=>'https://images.unsplash.com/photo-1612208695882-03a6b3e561b0?w=900&q=80&auto=format&fit=crop','desc'=>'Tiramisu dessert with a mixture of milk and eggs'],
    ]],
    ['title'=>'Kitchen Menu','items'=>[
      ['name'=>'Chicken Butter','price'=>'33K','img'=>'https://images.unsplash.com/photo-1529042410759-befb1204b468?w=900&q=80&auto=format&fit=crop'],
      ['name'=>'Chicken Garlic','price'=>'28K','img'=>'https://images.unsplash.com/photo-1604908554007-83e9b06bfa4e?w=900&q=80&auto=format&fit=crop'],
      ['name'=>'Chicken Teriyaki','price'=>'25K','img'=>'https://images.unsplash.com/photo-1512058564366-18510be2db19?w=900&q=80&auto=format&fit=crop'],
      ['name'=>'Chicken Black Paper','price'=>'28K','img'=>'https://images.unsplash.com/photo-1588167056547-c183313da9ce?w=900&q=80&auto=format&fit=crop'],
      ['name'=>'Chicken Fried Rice','price'=>'25K','img'=>'https://images.unsplash.com/photo-1544025162-d76694265947?w=900&q=80&auto=format&fit=crop'],
      ['name'=>'Chicken Matah','price'=>'28K','img'=>'https://images.unsplash.com/photo-1498654077810-12f43e6555ab?w=900&q=80&auto=format&fit=crop'],
    ]],
    ['title'=>'Cemilan','items'=>[
      ['name'=>'Chicken Strip','price'=>'20K','img'=>'https://images.unsplash.com/photo-1606756790138-261d2b21cd75?w=900&q=80&auto=format&fit=crop'],
      ['name'=>'Mix','price'=>'30K','img'=>'https://images.unsplash.com/photo-1544025162-d76694265947?w=900&q=80&auto=format&fit=crop'],
      ['name'=>'French Fries','price'=>'15K','img'=>'https://images.unsplash.com/photo-1541592106381-b31e9677c0e5?w=900&q=80&auto=format&fit=crop'],
    ]],
    ['title'=>'Dimsum','items'=>[
      ['name'=>'Dimsum Telur Asin','price'=>'28K','img'=>'https://images.unsplash.com/photo-1551183053-bf91a1d81141?w=900&q=80&auto=format&fit=crop'],
      ['name'=>'Dimsum Ayam','price'=>'26K','img'=>'https://images.unsplash.com/photo-1581287053822-834b9d6f2d7d?w=900&q=80&auto=format&fit=crop'],
      ['name'=>'Dimsum Rumput Laut','price'=>'30K','img'=>'https://images.unsplash.com/photo-1604908554007-83e9b06bfa4e?w=900&q=80&auto=format&fit=crop'],
      ['name'=>'Mix Dimsum','price'=>'35K','img'=>'https://images.unsplash.com/photo-1625944528100-1c0e1d233a7a?w=900&q=80&auto=format&fit=crop'],
      ['name'=>'Dimsum Kepiting','price'=>'25K','img'=>'https://images.unsplash.com/photo-1617093727343-bf2e2c58e445?w=900&q=80&auto=format&fit=crop'],
      ['name'=>'Dimsum Udang','price'=>'25K','img'=>'https://images.unsplash.com/photo-1617195737493-6a5f7e9de86c?w=900&q=80&auto=format&fit=crop'],
    ]],
    ['title'=>'Mie','items'=>[
      ['name'=>'Spaghetti Carbonara','price'=>'35K','img'=>'https://images.unsplash.com/photo-1526312426976-593c2b999512?w=900&q=80&auto=format&fit=crop','desc'=>'Spaghetti with a mixture of cheese, milk and eggs.'],
      ['name'=>'Spaghetti Bolognese','price'=>'30K','img'=>'https://images.unsplash.com/photo-1523986371872-9d3ba2e2f642?w=900&q=80&auto=format&fit=crop','desc'=>'Spaghetti with a mixture of bolognese sauce and a sprinkling of parsley.'],
      ['name'=>'Mie Yamin Noodle','price'=>'28K','img'=>'https://images.unsplash.com/photo-1544025162-68df1a6f7c5c?w=900&q=80&auto=format&fit=crop','desc'=>'Mix noodles with fish oil, garlic oil, and dumplings'],
      ['name'=>'Lecca Fried Noodle','price'=>'20K','img'=>'https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=900&q=80&auto=format&fit=crop','desc'=>'Fried noodles cooked with chili sauce and egg.'],
    ]],
  ];
  // urutan: minuman dulu -> makanan
  $priority = ['Mocktail & Tea'=>1,'Coffee'=>2,'Desserts'=>3,'Kitchen Menu'=>4,'Cemilan'=>5,'Dimsum'=>6,'Mie'=>7];
  usort($menu, fn($a,$b)=>($priority[$a['title']]??999)<=>($priority[$b['title']]??999));
@endphp

<header class="pt-10 pb-6 text-center">
  <h1 class="font-['Playfair_Display'] text-5xl md:text-6xl tracking-tight">MENU</h1>
  <p class="text-[15px] mt-2" style="color:var(--latte-ink)">Seduh yang elegan, rasa yang bicara.</p>
</header>

{{-- Quick jump --}}
<nav class="sticky top-0 z-20 px-4">
  <div class="stickybar glass rounded-2xl mx-auto max-w-6xl px-4 py-3 flex flex-wrap gap-2">
    @foreach($menu as $g)
      <a href="#{{ Str::slug($g['title']) }}" class="chip px-3 py-1.5 rounded-full text-sm hover:bg-white">
        {{ $g['title'] }}
      </a>
    @endforeach
  </div>
</nav>

<main class="max-w-6xl mx-auto px-4 pb-28">
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    @foreach($menu as $group)
      <section id="{{ Str::slug($group['title']) }}" class="glass rounded-3xl p-6 md:p-7">
        <h2 class="uppercase tracking-widest text-stone-600 mb-4">{{ $group['title'] }}</h2>
        <ul class="divide-y divide-stone-200/70">
          @foreach($group['items'] as $item)
            <li class="py-4">
              <div class="flex items-center gap-4">
                <div class="thumb ring-1 ring-stone-200 shrink-0">
                  <img loading="lazy" src="{{ $item['img'] ?? '' }}" alt="{{ $item['name'] }}">
                </div>
                <div class="flex-1 min-w-0">
                  <div class="flex items-start justify-between gap-3">
                    <div class="min-w-0">
                      <div class="font-semibold tracking-tight text-[15px] md:text-base">{{ $item['name'] }}</div>
                      @if(!empty($item['desc']))
                        <p class="text-sm text-stone-500 clamp-2 mt-1">{{ $item['desc'] }}</p>
                      @endif

                      {{-- Badge info Dingin/Panas (kalau ada) --}}
                      @if(!empty($item['serve']))
                        <div class="mt-2 flex flex-wrap gap-2">
                          @foreach($item['serve'] as $s)
                            @php $cold = strtolower($s)==='dingin'; @endphp
                            <span class="inline-flex items-center gap-1 rounded-full px-2.5 py-1 text-xs ring-1
                                         {{ $cold ? 'bg-sky-50 text-sky-700 ring-sky-200' : 'bg-amber-50 text-amber-700 ring-amber-200' }}">
                              {!! $cold ? '❄️' : '🔥' !!} {{ $s }}
                            </span>
                          @endforeach
                        </div>
                      @endif
                    </div>

                    <div class="text-right shrink-0">
                      <div class="price-pill inline-flex items-center rounded-full px-3 py-1 text-sm">
                        Rp {{ $item['price'] }}
                      </div>
                      {{-- TOMBOL TAMBAH --}}
                      <button
                        class="cta add-btn w-full mt-2 inline-flex items-center justify-center gap-2 rounded-xl px-3 py-2 text-xs md:text-sm"
                        data-name="{{ $item['name'] }}"
                        data-price="{{ $item['price'] }}">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M11 11V6h2v5h5v2h-5v5h-2v-5H6v-2z"/></svg>
                        Tambah
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </li>
          @endforeach
        </ul>
      </section>
    @endforeach
  </div>
</main>

<footer class="py-10 text-center text-xs text-stone-500">© {{ date('Y') }} SeduhRasa Coffee</footer>

{{-- FAB CART --}}
<button id="cart-fab"
  class="fixed bottom-5 right-5 z-30 inline-flex items-center gap-2 rounded-full cta px-4 py-3 shadow-lg">
  <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-1.99.9-1.99 2S15.9 22 17 22s2-.9 2-2-.9-2-2-2zM7.16 14h9.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49A1 1 0 0 0 21.08 5H6.21L5.27 3H2v2h2l3.6 7.59-1.35 2.45C5.52 15.37 6.16 16 7 16h12v-2H7.42l.74-1.34z"/></svg>
  <span id="cart-count" class="text-sm">0</span>
</button>

{{-- CART DRAWER --}}
<aside id="cart-drawer" class="fixed inset-y-0 right-0 w-full max-w-md bg-white/95 glass z-40 translate-x-full transition-transform">
  <div class="h-full flex flex-col">
    <div class="px-5 py-4 border-b flex items-center justify-between">
      <h3 class="text-lg font-semibold">Keranjang</h3>
      <button id="cart-close" class="rounded-md px-3 py-1.5 hover:bg-stone-100">Tutup</button>
    </div>

    <div id="cart-empty" class="p-6 text-stone-500">Keranjang masih kosong.</div>
    <ul id="cart-list" class="flex-1 overflow-auto divide-y hidden"></ul>

    <div class="border-t p-5 space-y-4">
      <div class="flex items-center justify-between">
        <span class="text-stone-600">Subtotal</span>
        <strong id="cart-subtotal">Rp 0</strong>
      </div>

      {{-- PILIHAN METODE PEMBAYARAN --}}
      <div class="space-y-2">
        <p class="text-sm font-medium text-stone-700">Metode Pembayaran</p>
        <div class="space-y-1 text-sm">
          <label class="flex items-center gap-2">
            <input type="radio" name="metode_pembayaran_ui" value="cod" class="accent-amber-600" checked>
            <span>Bayar di Tempat (kasir)</span>
          </label>
          <label class="flex items-center gap-2">
            <input type="radio" name="metode_pembayaran_ui" value="transfer" class="accent-amber-600">
            <span>Transfer Bank / Virtual Account</span>
          </label>
        </div>
      </div>

      {{-- TOMBOL CHECKOUT --}}
      <button id="checkout-btn" class="w-full cta rounded-xl py-3">Lanjutkan Order</button>

      <p class="text-xs text-stone-500">*Keranjang tersimpan di perangkat (localStorage).</p>
    </div>
  </div>
</aside>

<div id="backdrop" class="fixed inset-0 bg-black/40 z-30 opacity-0 pointer-events-none transition-opacity"></div>

{{-- ========= SCRIPT ========= --}}
<script>
  // Format & parser
  const rupiah = n => 'Rp '+ n.toString().replace(/\B(?=(\d{3})+(?!\d))/g,'.');
  const parsePrice = s => {
    s = (s || '').toUpperCase().trim();
    if (s.endsWith('K')) return parseInt(s) * 1000;
    return parseInt(s.replace(/\D/g,'')) || 0;
  };

  // State
  let cart = JSON.parse(localStorage.getItem('sr_cart') || '[]');

  // Refs
  const cartFab      = document.getElementById('cart-fab');
  const cartCount    = document.getElementById('cart-count');
  const cartDrawer   = document.getElementById('cart-drawer');
  const cartClose    = document.getElementById('cart-close');
  const backdrop     = document.getElementById('backdrop');
  const cartList     = document.getElementById('cart-list');
  const cartEmpty    = document.getElementById('cart-empty');
  const cartSubtotal = document.getElementById('cart-subtotal');
  const checkoutBtn  = document.getElementById('checkout-btn');

  // Tambah ke keranjang
  document.querySelectorAll('.cta.add-btn, .add-btn').forEach(btn=>{
    btn.addEventListener('click',()=>{
      const name = btn.dataset.name;
      const price = parsePrice(btn.dataset.price);
      addToCart({name, price});
    });
  });

  function addToCart(item){
    const f = cart.find(x=>x.name===item.name);
    if (f) f.qty += 1;
    else cart.push({...item, qty:1});
    persist(); renderCart(); openCart();
  }

  function updateQty(i,d){
    cart[i].qty += d;
    if (cart[i].qty <= 0) cart.splice(i,1);
    persist(); renderCart();
  }

  function removeItem(i){
    cart.splice(i,1);
    persist(); renderCart();
  }

  function persist(){
    localStorage.setItem('sr_cart', JSON.stringify(cart));
  }

  function subtotal(){
    return cart.reduce((t,i)=>t+i.price*i.qty,0);
  }

  function renderCart(){
    cartCount.textContent = cart.reduce((t,i)=>t+i.qty,0);
    const has = cart.length > 0;
    cartEmpty.classList.toggle('hidden', has);
    cartList.classList.toggle('hidden', !has);

    cartList.innerHTML = cart.map((it,idx)=>`
      <li class="p-4 flex items-center justify-between gap-3">
        <div class="min-w-0">
          <div class="font-medium">${it.name}</div>
          <div class="text-sm text-stone-500">${rupiah(it.price)}</div>
        </div>
        <div class="flex items-center gap-2">
          <button class="px-2 py-1 rounded-md ring-1 ring-stone-200 hover:bg-stone-100" data-act="dec" data-i="${idx}">−</button>
          <span class="w-6 text-center">${it.qty}</span>
          <button class="px-2 py-1 rounded-md ring-1 ring-stone-200 hover:bg-stone-100" data-act="inc" data-i="${idx}">+</button>
          <button class="ml-2 px-2 py-1 rounded-md text-stone-500 hover:bg-stone-100" data-act="del" data-i="${idx}">Hapus</button>
        </div>
      </li>
    `).join('');

    cartList.querySelectorAll('button').forEach(b=>{
      const i = +b.dataset.i;
      b.addEventListener('click',()=>{
        if (b.dataset.act === 'inc') updateQty(i,1);
        if (b.dataset.act === 'dec') updateQty(i,-1);
        if (b.dataset.act === 'del') removeItem(i);
      });
    });

    cartSubtotal.textContent = rupiah(subtotal());
  }

  // Drawer
  function openCart(){
    cartDrawer.classList.remove('translate-x-full');
    backdrop.classList.remove('pointer-events-none');
    requestAnimationFrame(()=>backdrop.style.opacity='1');
  }

  function closeCart(){
    cartDrawer.classList.add('translate-x-full');
    backdrop.style.opacity='0';
    setTimeout(()=>backdrop.classList.add('pointer-events-none'),200);
  }

  cartFab.addEventListener('click',openCart);
  cartClose.addEventListener('click',closeCart);
  backdrop.addEventListener('click',closeCart);

  // Checkout: kirim pesanan + data pembeli + metode pembayaran ke Laravel
  checkoutBtn.addEventListener('click', () => {
    if (!cart.length) {
      alert('Keranjang masih kosong.');
      return;
    }

    // ambil data pembeli dari localStorage
    const buyer = JSON.parse(localStorage.getItem('sr_buyer') || '{}');

    if (!buyer.nama_pelanggan || !buyer.email || !buyer.telepon) {
      alert('Data pembeli belum lengkap. Silakan isi dulu di halaman sebelumnya.');
      window.location.href = "{{ route('order') }}";
      return;
    }

    // ambil metode pembayaran
    const metodeRadio = document.querySelector('input[name="metode_pembayaran_ui"]:checked');
    const metode = metodeRadio ? metodeRadio.value : 'cod';

    const form = document.createElement('form');
    form.method = 'POST';
    form.action = "{{ route('orders.store') }}";

    form.innerHTML = `
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <input type="hidden" name="nama_pelanggan" value="${buyer.nama_pelanggan}">
      <input type="hidden" name="email" value="${buyer.email}">
      <input type="hidden" name="telepon" value="${buyer.telepon}">
      <input type="hidden" name="items" value='${JSON.stringify(cart)}'>
      <input type="hidden" name="metode_pembayaran" value="${metode}">
    `;

    document.body.appendChild(form);
    form.submit();
  });

  renderCart();
</script>
</body>
</html>
