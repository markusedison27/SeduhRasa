<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Pelanggan;
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

    // POST /order -> simpan data pelanggan ke session + ke tabel pelanggans, lalu redirect ke /menu
    public function storeCustomerInfo(Request $request)
    {
        // 1. Validasi input form Data Pembeli
        $data = $request->validate([
            'name'  => 'required|string|max:100',
            'phone' => 'required|string|max:30',
            'email' => 'nullable|email|max:100',
        ]);

        // 2. Simpan / update ke tabel pelanggans
        //    KUNCI: nomor telepon (supaya kalau orang yang sama pesan lagi, datanya di-update)
        try {
            $pelanggan = Pelanggan::updateOrCreate(
                [
                    'telepon' => $data['phone'], // <- kolom "telepon" di tabel pelanggans
                ],
                [
                    'nama'   => $data['name'],          // kolom "nama"
                    'email'  => $data['email'] ?? null, // kolom "email"
                    'alamat' => null,                   // kalau belum ada alamat, kosongin dulu
                ]
            );

            // simpan id pelanggan ke session biar bisa dihubungkan ke tabel orders
            session([
                'customer.id'    => $pelanggan->id,
                'customer.name'  => $data['name'],
                'customer.phone' => $data['phone'],
                'customer.email' => $data['email'] ?? null,
            ]);
        } catch (\Exception $e) {
            // kalau gagal simpan pelanggan, jangan bikin user error di layar
            // cukup log, dan lanjut pakai session aja
            \Log::error('Gagal simpan pelanggan: ' . $e->getMessage());

            session([
                'customer.id'    => null,
                'customer.name'  => $data['name'],
                'customer.phone' => $data['phone'],
                'customer.email' => $data['email'] ?? null,
            ]);
        }

        // 3. Lanjut ke halaman menu seperti biasa
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
        try {
            // Validasi ringan (no_meja optional)
            $request->validate([
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
                return response()->json([
                    'success' => false,
                    'message' => 'Keranjang masih kosong atau data item tidak valid.'
                ], 422);
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
                return response()->json([
                    'success' => false,
                    'message' => 'Keranjang tidak valid.'
                ], 422);
            }

            // nama & id pelanggan dari session
            $namaPelanggan = session('customer.name', 'Umum');
            $pelangganId   = session('customer.id'); // boleh null kalau gagal simpan pelanggan tadi

            // metode pembayaran: "cod" / "dana"
            $metodePembayaran = $request->input('metode_pembayaran', 'cod');

            // nomor meja (boleh kosong)
            $noMeja = $request->input('no_meja');

            // Generate kode order unik
            $kodeOrder = 'ORD-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));

            $menuDipesan = implode(', ', $listMenu);

            // Simpan ke tabel orders
            $order = Order::create([
                'pelanggan_id'      => $pelangganId,   // <-- hubungkan ke tabel pelanggans
                'kode_order'        => $kodeOrder,
                'customer_name'     => $namaPelanggan,
                'subtotal'          => $totalHarga,
                'status'            => 'pending',
                'metode_pembayaran' => $metodePembayaran,
                'no_meja'           => $noMeja,
                'keterangan'        => $menuDipesan,
            ]);

            // SELALU balas JSON untuk fetch() request
            return response()->json([
                'success'      => true,
                'message'      => 'Pesanan berhasil dibuat.',
                'order_id'     => $order->id,
                'redirect_url' => route('customer.orders.show', $order->id),
            ], 201);

        } catch (\Exception $e) {
            // Log error untuk debugging
            \Log::error('Order Store Error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan pesanan: ' . $e->getMessage()
            ], 500);
        }
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
            ->get(['id', 'customer_name', 'created_at']);

        return response()->json([
            'count' => $orders->count(),
            'items' => $orders->map(function ($order) {
                return [
                    'id'       => $order->id,
                    'title'    => 'Pesanan pending #' . $order->id,
                    'subtitle' => $order->customer_name ?: 'Pelanggan',
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
