<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | FLOW SEBELUM MASUK MENU
    |--------------------------------------------------------------------------
    | /order (GET & POST)
    */

    // GET /order -> form data pelanggan
    public function create()
    {
        // SELALU kosong (supaya tiap pesan ulang harus isi lagi)
        $customer = [
            'name'  => null,
            'phone' => null,
            'email' => null,
        ];

        return view('order', compact('customer'));
    }

    // POST /order -> simpan data pelanggan ke session lalu redirect ke /menu
    public function storeCustomerInfo(Request $request)
    {
        $data = $request->validate([
            'name'  => 'required|string|max:100',
            'phone' => 'required|string|max:30',
            'email' => 'nullable|email|max:100',
        ]);

        // disimpan untuk dipakai di /menu saat checkout
        session([
            'customer.name'  => $data['name'],
            'customer.phone' => $data['phone'],
            'customer.email' => $data['email'] ?? null,
        ]);

        return redirect()->route('menu');
    }

    /*
    |--------------------------------------------------------------------------
    | PUBLIC (checkout dari halaman menu)
    |--------------------------------------------------------------------------
    | POST /orders -> route('orders.store')
    */

    public function store(Request $request)
    {
        // Validasi ringan (no_meja optional)
        $request->validate([
            'nama_pelanggan'    => 'nullable|string|max:255',
            'metode_pembayaran' => 'nullable|string|max:50',
            'no_meja'           => 'nullable|string|max:10',
        ]);

        /*
         * AMBIL ITEMS
         * Bisa datang dalam 2 bentuk:
         * 1) String JSON: "[{...},{...}]"
         * 2) Langsung array: [{...},{...}]
         */
        $rawItems = $request->input('items');

        if (is_array($rawItems)) {
            $items = $rawItems;
        } else {
            // anggap string JSON
            $items = json_decode($rawItems, true);
        }

        if (!$items || !is_array($items) || count($items) === 0) {
            $msg = 'Keranjang masih kosong atau data item tidak valid.';
            return response()->json(['success' => false, 'message' => $msg], 422);
        }

        $totalQty   = 0;
        $totalHarga = 0;
        $listMenu   = [];

        foreach ($items as $item) {
            $name  = $item['name']  ?? null;
            $qty   = (int)($item['qty']   ?? 1);
            $price = (int)($item['price'] ?? 0);

            if (!$name || $qty <= 0 || $price < 0) {
                continue;
            }

            $totalQty   += $qty;
            $totalHarga += $qty * $price;

            // contoh: "Americano x2"
            $listMenu[] = $name . ' x' . $qty;
        }

        if ($totalQty === 0 || $totalHarga <= 0) {
            $msg = 'Keranjang tidak valid.';
            return response()->json(['success' => false, 'message' => $msg], 422);
        }

        // nama_pelanggan dikirim dari menu.blade atau fallback dari session
        $namaPelanggan = $request->input('nama_pelanggan')
            ?: session('customer.name', 'Umum');

        // metode pembayaran: "cod" / "dana" / "transfer"
        $metodePembayaran = $request->input('metode_pembayaran', 'cod');

        // nomor meja (boleh kosong)
        $noMeja = $request->input('no_meja');

        $menuDipesan = implode(', ', $listMenu);

        // Simpan ke tabel orders
        $order = Order::create([
            'nama_pelanggan'    => $namaPelanggan,
            'menu_dipesan'      => $menuDipesan,
            'jumlah'            => $totalQty,
            'total_harga'       => $totalHarga,
            'status'            => 'pending',
            'metode_pembayaran' => $metodePembayaran,
            'no_meja'           => $noMeja,
        ]);

        // SELALU balas JSON untuk fetch() request
        return response()->json([
            'success'      => true,
            'message'      => 'Pesanan berhasil dibuat.',
            'order_id'     => $order->id,
            'redirect_url' => route('customer.orders.show', $order->id),
        ], 201);
    }

    // GET /orders/{order}
    public function show(Order $order)
    {
        return view('orders.show', [
            'order' => $order,
        ]);
    }

    // GET /pesanan/{order}/berhasil
    public function showCustomer(Order $order)
    {
        return view('frontend.order-success', [
            'order' => $order,
        ]);
    }

    // GET /orders/{order}/status-json
    public function statusJson(Order $order)
    {
        return response()->json([
            'status' => $order->status,
        ]);
    }

    // GET /notifications/orders  (dipakai ikon lonceng)
    public function notificationsJson()
    {
        // semua order pending terbaru dijadikan "notifikasi"
        $orders = Order::where('status', 'pending')
            ->latest()
            ->take(10)
            ->get(['id', 'nama_pelanggan', 'created_at']);

        return response()->json([
            'count' => $orders->count(),
            'items' => $orders->map(function ($order) {
                return [
                    'id'       => $order->id,
                    'title'    => 'Pesanan pending #' . $order->id,
                    'subtitle' => $order->nama_pelanggan ?: 'Pelanggan',
                    'time'     => $order->created_at->diffForHumans(),
                    'url'      => route('admin.orders.show', $order->id),
                ];
            }),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN (resource /admin/orders)
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $orders = Order::latest()->paginate(15);

        if (view()->exists('admin.orders.index')) {
            return view('admin.orders.index', compact('orders'));
        }

        return view('orders.index', compact('orders'));
    }

    public function adminShow(Order $order)
    {
        if (view()->exists('admin.orders.show')) {
            return view('admin.orders.show', compact('order'));
        }

        return view('orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $data = $request->validate([
            'status'  => 'required|in:pending,proses,selesai,batal',
            'no_meja' => 'nullable|string|max:10',
        ]);

        $order->status = $data['status'];

        if (array_key_exists('no_meja', $data)) {
            $order->no_meja = $data['no_meja'];
        }

        $order->save();

        return back()->with('success', 'Status order berhasil diperbarui.');
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return back()->with('success', 'Order berhasil dihapus.');
    }
}