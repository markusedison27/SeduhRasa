{{-- resources/views/menu.blade.php (FINAL dengan STOK) --}}
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Menu • SeduhRasa</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.bunny.net/css?family=dm-sans:400,600|playfair-display:700" rel="stylesheet" />

    <style>
        /* ... (CSS tetap sama seperti sebelumnya) ... */
        :root {
            --cream: #f6efe9;
            --latte: #d7c0ae;
            --latte-ink: #8d6f5b;
            --espresso: #3b2f2f;
            --mocha: #4b3a32;
            --card: #ffffffcc;
        }

        html {
            scroll-behavior: smooth
        }

        body {
            font-family: "DM Sans", ui-sans-serif, system-ui
        }

        .bg-canvas {
            background: radial-gradient(60rem 60rem at 10% -20%, rgba(0, 0, 0, .06), transparent 60%),
                radial-gradient(70rem 70rem at 110% 10%, rgba(0, 0, 0, .05), transparent 55%),
                linear-gradient(180deg, var(--cream), #fff);
            min-height: 100vh;
        }

        .glass {
            background: var(--card);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(0, 0, 0, .08);
            box-shadow: 0 8px 30px rgba(0, 0, 0, .06);
        }

        .thumb {
            width: 80px;
            height: 80px;
            border-radius: 12px;
            overflow: hidden;
            flex-shrink: 0;
        }

        @media (max-width: 640px) {
            .thumb {
                width: 70px;
                height: 70px;
            }
        }

        .thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .35s ease;
        }

        .thumb:hover img {
            transform: scale(1.08)
        }

        .price-pill {
            border: 1px dashed rgba(0, 0, 0, .18);
            background: #fff8;
            white-space: nowrap;
        }

        .cta {
            background: linear-gradient(135deg, var(--espresso), var(--mocha));
            color: #fff;
            transition: transform .12s ease, opacity .12s ease, box-shadow .12s ease;
            font-weight: 500;
            box-shadow: 0 2px 8px rgba(59, 47, 47, .2);
        }

        .cta:hover {
            opacity: .95;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(59, 47, 47, .3);
        }

        .cta:active {
            transform: translateY(0);
        }

        .cta:disabled {
            background: #9ca3af;
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .chip {
            background: #fff;
            border: 1px solid #ead9cd;
            color: #5f4635;
            transition: all .2s ease;
        }

        .chip:hover {
            background: #faf8f6;
            border-color: #d7c0ae;
            transform: translateY(-1px);
        }

        .stickybar {
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            background: rgba(255, 255, 255, .85);
            box-shadow: 0 4px 20px rgba(0, 0, 0, .06);
        }

        /* ✅ Badge Stok */
        .stock-badge {
            position: absolute;
            top: 8px;
            right: 8px;
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 10px;
            font-weight: 600;
            backdrop-filter: blur(4px);
        }

        .stock-empty {
            background: rgba(239, 68, 68, 0.9);
            color: white;
        }

        .stock-low {
            background: rgba(234, 179, 8, 0.9);
            color: white;
        }

        .cart-fab {
            position: fixed;
            bottom: 24px;
            right: 24px;
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--espresso), var(--mocha));
            color: white;
            box-shadow: 0 8px 24px rgba(59, 47, 47, .3);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all .3s ease;
            z-index: 50;
        }

        .cart-fab:hover {
            transform: scale(1.1);
            box-shadow: 0 12px 32px rgba(59, 47, 47, .4);
        }

        @media (max-width: 640px) {
            .cart-fab {
                width: 56px;
                height: 56px;
                bottom: 20px;
                right: 20px;
            }
        }

        .cart-badge {
            position: absolute;
            top: -4px;
            right: -4px;
            background: #ef4444;
            color: white;
            border-radius: 12px;
            padding: 2px 6px;
            font-size: 11px;
            font-weight: 600;
            min-width: 20px;
            text-align: center;
        }

        .drawer {
            position: fixed;
            top: 0;
            right: -100%;
            width: 100%;
            max-width: 420px;
            height: 100vh;
            background: white;
            box-shadow: -4px 0 24px rgba(0, 0, 0, .15);
            transition: right .3s ease;
            z-index: 60;
            display: flex;
            flex-direction: column;
        }

        .drawer.open {
            right: 0;
        }

        .backdrop {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .4);
            backdrop-filter: blur(2px);
            opacity: 0;
            pointer-events: none;
            transition: opacity .3s ease;
            z-index: 55;
        }

        .backdrop.show {
            opacity: 1;
            pointer-events: all;
        }

        .pay-pill {
            border-radius: 999px;
            border: 1px solid rgba(0, 0, 0, .08);
            padding: 6px 12px;
            font-size: 12px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #f9f5ef;
            color: #4b3a32;
            cursor: pointer;
            transition: all .18s ease;
            white-space: nowrap;
        }

        .pay-pill:hover {
            border-color: rgba(0, 0, 0, .2);
            transform: translateY(-1px);
        }

        .pay-pill.active {
            background: linear-gradient(135deg, var(--espresso), var(--mocha));
            color: #fff;
            box-shadow: 0 4px 10px rgba(59, 47, 47, .3);
        }

        #order-notif {
            opacity: 0;
            pointer-events: none;
            transition: opacity .25s ease;
        }

        #order-notif.show {
            opacity: 1;
            pointer-events: auto;
        }

        #order-notif .notif-card {
            transform: translateY(16px);
            transition: transform .25s ease;
        }

        #order-notif.show .notif-card {
            transform: translateY(0);
        }
    </style>
</head>

<body class="bg-canvas text-stone-900 antialiased">

    <header class="pt-8 pb-6 px-4 text-center">
        <h1 class="font-['Playfair_Display'] text-4xl sm:text-5xl md:text-6xl tracking-tight">MENU</h1>
        <p class="text-sm sm:text-[15px] mt-2" style="color:var(--latte-ink)">Seduh yang elegan, rasa yang bicara.</p>
    </header>

    <nav class="sticky top-0 z-20 px-3 sm:px-4 mb-6">
        <div
            class="stickybar rounded-2xl mx-auto max-w-6xl px-3 sm:px-4 py-2.5 sm:py-3 flex flex-wrap gap-1.5 sm:gap-2">
            @forelse($menuGroups as $group)
                <a href="#{{ Str::slug($group->kategori) }}"
                    class="chip px-2.5 sm:px-3 py-1.5 rounded-full text-xs sm:text-sm hover:bg-white">
                    {{ $group->kategori }}
                </a>
            @empty
                <p class="text-sm text-stone-500 py-1">Belum ada kategori menu</p>
            @endforelse
        </div>
    </nav>

    <main class="max-w-6xl mx-auto px-3 sm:px-4 pb-32">
        @forelse($menuGroups as $group)
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6 mb-6">
                <section id="{{ Str::slug($group->kategori) }}"
                    class="glass rounded-2xl sm:rounded-3xl p-4 sm:p-6 md:p-7">
                    <h2 class="uppercase tracking-widest text-stone-600 text-sm sm:text-base mb-4">
                        {{ $group->kategori }}</h2>

                    @if ($group->items->count() > 0)
                        <ul class="divide-y divide-stone-200/70">
                            @foreach ($group->items as $item)
                                @php
                                    $stok = $item->stok ?? 0;
                                    $isOutOfStock = $stok <= 0;
                                @endphp

                                <li class="py-3 sm:py-4 {{ $isOutOfStock ? 'opacity-60' : '' }}">
                                    <div class="flex items-start gap-3 sm:gap-4">
                                        <div class="thumb ring-1 ring-stone-200 relative">
                                            @if ($item->gambar)
                                                <img loading="lazy" src="{{ asset('uploads/' . $item->gambar) }}"
                                                    alt="{{ $item->nama_menu }}">
                                            @else
                                                <div
                                                    class="w-full h-full bg-stone-200 flex items-center justify-center">
                                                    <svg class="w-8 h-8 text-stone-400" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                </div>
                                            @endif

                                            {{-- ✅ Badge Stok pada Thumbnail --}}
                                            @if ($isOutOfStock)
                                                <span class="stock-badge stock-empty">HABIS</span>
                                            @elseif($stok <= 5)
                                                <span class="stock-badge stock-low">SISA {{ $stok }}</span>
                                            @endif
                                        </div>

                                        <div class="flex-1 min-w-0">
                                            <div
                                                class="flex flex-col sm:flex-row sm:items-start justify-between gap-2 sm:gap-3">
                                                <div class="min-w-0 flex-1">
                                                    <h3
                                                        class="font-semibold tracking-tight text-sm sm:text-[15px] md:text-base leading-snug">
                                                        {{ $item->nama_menu }}
                                                    </h3>
                                                    @if ($item->suhu)
                                                        <p class="text-xs sm:text-sm text-stone-500 mt-1">
                                                            {{ $item->suhu }}</p>
                                                    @endif

                                                    {{-- ✅ Info Stok di Bawah Nama --}}
                                                    <p class="text-[10px] sm:text-xs mt-1">
                                                        @if ($isOutOfStock)
                                                            <span class="text-red-600 font-semibold">● Stok Habis</span>
                                                        @elseif($stok <= 5)
                                                            <span class="text-yellow-600 font-semibold">● Tersisa
                                                                {{ $stok }}</span>
                                                        @else
                                                            <span class="text-green-600 font-semibold">● Stok:
                                                                {{ $stok }}</span>
                                                        @endif
                                                    </p>
                                                </div>

                                                <div
                                                    class="flex sm:flex-col items-center sm:items-end gap-2 sm:gap-2 shrink-0">
                                                    <div
                                                        class="price-pill inline-flex items-center rounded-full px-2.5 sm:px-3 py-1 text-xs sm:text-sm font-medium">
                                                        Rp {{ number_format($item->harga, 0, ',', '.') }}
                                                    </div>

                                                    {{-- ✅ Tombol dengan Validasi Stok --}}
                                                    @if ($isOutOfStock)
                                                        <button disabled
                                                            class="cta add-btn inline-flex items-center justify-center gap-1.5 rounded-lg sm:rounded-xl px-3 sm:px-4 py-1.5 sm:py-2 text-xs sm:text-sm whitespace-nowrap opacity-50 cursor-not-allowed">
                                                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="currentColor"
                                                                viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd"
                                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                                    clip-rule="evenodd" />
                                                            </svg>
                                                            Habis
                                                        </button>
                                                    @else
                                                        <button
                                                            class="cta add-btn inline-flex items-center justify-center gap-1.5 rounded-lg sm:rounded-xl px-3 sm:px-4 py-1.5 sm:py-2 text-xs sm:text-sm whitespace-nowrap"
                                                            data-name="{{ $item->nama_menu }}"
                                                            data-price="{{ $item->harga }}"
                                                            data-stock="{{ $stok }}">
                                                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" viewBox="0 0 24 24"
                                                                fill="currentColor">
                                                                <path d="M11 11V6h2v5h5v2h-5v5h-2v-5H6v-2z" />
                                                            </svg>
                                                            Tambah
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-sm text-stone-400 text-center py-8">Belum ada menu di kategori ini</p>
                    @endif
                </section>
            </div>
        @empty
            <div class="glass rounded-3xl p-12 text-center">
                <svg class="w-16 h-16 mx-auto text-stone-300 mb-4" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="text-xl font-semibold text-stone-600 mb-2">Belum Ada Menu</h3>
                <p class="text-stone-500">Menu akan ditampilkan setelah admin menambahkan data</p>
            </div>
        @endforelse
    </main>

    <button class="cart-fab" id="cart-fab" aria-label="Buka keranjang">
        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
        </svg>
        <span class="cart-badge" id="cart-count">0</span>
    </button>

    <div class="backdrop" id="backdrop"></div>

    <div class="drawer" id="cart-drawer">
        <div class="p-4 sm:p-6 border-b border-stone-200 flex items-center justify-between">
            <h2 class="text-lg sm:text-xl font-semibold">Keranjang Belanja</h2>
            <button id="cart-close"
                class="w-8 h-8 rounded-full hover:bg-stone-100 flex items-center justify-center transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="flex-1 overflow-y-auto">
            <div id="cart-empty" class="p-8 text-center">
                <svg class="w-16 h-16 mx-auto text-stone-300 mb-4" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
                <p class="text-stone-500">Keranjang masih kosong</p>
            </div>

            <ul id="cart-list" class="hidden divide-y divide-stone-200"></ul>
        </div>

        <div class="p-4 sm:p-6 border-t border-stone-200 bg-stone-50 space-y-3">
            <div class="space-y-1">
                <span class="text-xs sm:text-sm text-stone-500">Metode Pembayaran</span>
                <div class="flex flex-wrap gap-2">
                    <button type="button" class="pay-pill active" data-method="cod">
                        Bayar di Tempat (COD)
                    </button>
                    <button type="button" class="pay-pill" data-method="dana">
                        Dana (QRIS / Transfer)
                    </button>
                </div>
                <input type="hidden" id="payment-method" value="cod">
            </div>

            <div class="space-y-1">
                <span class="text-xs sm:text-sm text-stone-500">Nomor Meja</span>
                <input id="table-number-input" type="text"
                    class="w-full rounded-xl border border-stone-200 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-300 focus:border-amber-300"
                    placeholder="Contoh: 5, 12, A1">
            </div>

            <div class="flex items-center justify-between">
                <span class="text-stone-600">Subtotal</span>
                <span class="text-xl font-bold" id="cart-subtotal">Rp 0</span>
            </div>

            <button id="checkout-btn"
                class="cta w-full py-3 rounded-xl text-base font-semibold flex items-center justify-center gap-2">
                <span>Checkout</span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>
    </div>

    {{-- Notif Modal (sama seperti sebelumnya) --}}
    <div id="order-notif" class="fixed inset-0 z-[70] flex items-center justify-center">
        {{-- ... (kode notif tetap sama) ... --}}
    </div>

    {{-- FOOTER --}}
    <footer class="w-full bg-[#ff8c00] text-white text-center py-4 text-sm">
        
    </footer>
    
    <script>
        const rupiah = n => 'Rp ' + n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        let cart = [];
        let maxStock = {}; // ✅ Simpan max stok per item

        const ORDER_URL = "{{ route('orders.store') }}";
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        const cartFab = document.getElementById('cart-fab');
        const cartCount = document.getElementById('cart-count');
        const cartDrawer = document.getElementById('cart-drawer');
        const cartClose = document.getElementById('cart-close');
        const backdrop = document.getElementById('backdrop');
        const cartList = document.getElementById('cart-list');
        const cartEmpty = document.getElementById('cart-empty');
        const cartSubtotal = document.getElementById('cart-subtotal');
        const checkoutBtn = document.getElementById('checkout-btn');
        const tableInput = document.getElementById('table-number-input');
        const payMethodInput = document.getElementById('payment-method');
        const payMethodButtons = document.querySelectorAll('.pay-pill');

        function renderCart() {
            const totalItems = cart.reduce((t, i) => t + i.qty, 0);
            cartCount.textContent = totalItems;
            cartCount.classList.toggle('hidden', totalItems === 0);

            const hasItems = cart.length > 0;
            cartEmpty.classList.toggle('hidden', hasItems);
            cartList.classList.toggle('hidden', !hasItems);

            cartList.innerHTML = cart.map((it, idx) => `
                <li class="p-4 flex items-center justify-between gap-3">
                    <div class="min-w-0 flex-1">
                        <div class="font-medium text-sm sm:text-base">${it.name}</div>
                        <div class="text-xs sm:text-sm text-stone-500">${rupiah(it.price)}</div>
                    </div>
                    <div class="flex items-center gap-2">
                        <button data-act="dec" data-i="${idx}" class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-stone-100 hover:bg-stone-200 flex items-center justify-center transition text-sm sm:text-base">−</button>
                        <span class="w-8 text-center font-medium text-sm sm:text-base">${it.qty}</span>
                        <button data-act="inc" data-i="${idx}" class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-stone-100 hover:bg-stone-200 flex items-center justify-center transition text-sm sm:text-base">+</button>
                        <button data-act="del" data-i="${idx}" class="ml-2 text-red-500 hover:text-red-700 text-xs sm:text-sm transition">Hapus</button>
                    </div>
                </li>
            `).join('');

            cartList.querySelectorAll('button').forEach(b => {
                const i = +b.dataset.i;
                const item = cart[i];

                if (b.dataset.act === 'inc') {
                    b.onclick = () => {
                        // ✅ Validasi stok sebelum tambah qty
                        if (item.qty >= maxStock[item.name]) {
                            alert(`Stok ${item.name} hanya tersisa ${maxStock[item.name]}`);
                            return;
                        }
                        cart[i].qty++;
                        renderCart();
                    };
                }
                if (b.dataset.act === 'dec') {
                    b.onclick = () => {
                        cart[i].qty--;
                        if (cart[i].qty <= 0) cart.splice(i, 1);
                        renderCart();
                    };
                }
                if (b.dataset.act === 'del') {
                    b.onclick = () => {
                        cart.splice(i, 1);
                        renderCart();
                    };
                }
            });

            cartSubtotal.textContent = rupiah(cart.reduce((t, i) => t + i.price * i.qty, 0));
        }

        // ✅ Add to cart dengan validasi stok
        document.querySelectorAll('.add-btn').forEach(btn => {
            btn.onclick = () => {
                if (btn.disabled) return;

                const name = btn.dataset.name;
                const price = parseInt(btn.dataset.price);
                const stock = parseInt(btn.dataset.stock || 0);

                // Simpan max stock
                maxStock[name] = stock;

                const existing = cart.find(x => x.name === name);

                if (existing) {
                    // ✅ Cek apakah qty belum melebihi stok
                    if (existing.qty >= stock) {
                        alert(`Stok ${name} hanya tersisa ${stock}`);
                        return;
                    }
                    existing.qty++;
                } else {
                    cart.push({
                        name,
                        price,
                        qty: 1
                    });
                }

                renderCart();

                // Feedback
                btn.textContent = '✓ Ditambahkan';
                setTimeout(() => {
                    btn.innerHTML =
                        '<svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M11 11V6h2v5h5v2h-5v5h-2v-5H6v-2z"/></svg> Tambah';
                }, 1000);
            };
        });

        cartFab.onclick = () => {
            cartDrawer.classList.add('open');
            backdrop.classList.add('show');
        };

        const closeDrawer = () => {
            cartDrawer.classList.remove('open');
            backdrop.classList.remove('show');
        };

        cartClose.onclick = closeDrawer;
        backdrop.onclick = closeDrawer;

        payMethodButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                payMethodButtons.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                payMethodInput.value = btn.dataset.method;
            });
        });

        checkoutBtn.onclick = () => {
            if (cart.length === 0) {
                alert('Keranjang masih kosong!');
                return;
            }

            const method = payMethodInput.value || 'cod';
            const meja = (tableInput?.value || '').trim();

            const payload = {
                items: JSON.stringify(cart),
                metode_pembayaran: method,
                no_meja: meja,
            };

            fetch(ORDER_URL, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify(payload),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.redirect_url) {
                        window.location.href = data.redirect_url;
                    } else {
                        alert(data.message ||
                            'Terjadi kesalahan');
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('Terjadi kesalahan saat mengirim pesanan. Silakan coba lagi.');
                });
        };

        renderCart();
    </script>

</body>

</html>
