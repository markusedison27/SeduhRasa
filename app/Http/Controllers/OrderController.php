<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Menu;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Halaman form order awal (isi data pelanggan)
     * Route: GET /order
     */
    public function create()
    {
        $menus = Menu::all();

        $customer = [
            'name' => session('customer.name'),
            'id'   => session('customer.id'),
        ];

        // Sesuaikan dengan nama blade kamu untuk form awal customer
        return view('order', compact('menus', 'customer'));
    }

    /**
     * Simpan info customer ke session
     * Route: POST /order
     */
    public function storeCustomerInfo(Request $request)
    {
        $data = $request->validate([
            'name'  => 'required|string|max:100',
            'email' => 'nullable|email|max:100',
            'phone' => 'nullable|string|max:20',
        ]);

        // Simpan ke session saja
        session([
            'customer.name'  => $data['name'],
            'customer.id'    => null,
            'customer.email' => $data['email'] ?? null,
            'customer.phone' => $data['phone'] ?? null,
        ]);

        return redirect()
            ->route('menu')
            ->with('success', 'Data pelanggan disimpan, silakan pilih menu.');
    }

    /**
     * Simpan pesanan baru dari pelanggan (API / AJAX)
     * Route: POST /orders
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
             * items bisa berupa array langsung atau JSON string
             */
            $rawItems = $request->input('items');

            if (is_array($rawItems)) {
                $items = $rawItems;
            } else {
                $items = json_decode($rawItems, true);
            }

            if (!$items || !is_array($items) || count($items) === 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Keranjang masih kosong atau data item tidak valid.'
                ], 422);
            }

            // ✅ VALIDASI STOK SEBELUM PROSES ORDER
            $stockErrors = [];
            foreach ($items as $item) {
                $menuName = $item['name'] ?? null;
                $qty      = (int)($item['qty'] ?? 1);

                if (!$menuName || $qty <= 0) {
                    continue;
                }

                // Cari menu berdasarkan nama
                $menu = Menu::where('nama_menu', $menuName)->first();

                if (!$menu) {
                    $stockErrors[] = "Menu '{$menuName}' tidak ditemukan.";
                    continue;
                }

                // Cek stok
                if ($menu->stok < $qty) {
                    $stockErrors[] = "Stok '{$menuName}' tidak mencukupi. Stok tersedia: {$menu->stok}";
                }
            }

            // Jika ada error stok, kembalikan error
            if (!empty($stockErrors)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pesanan gagal: ' . implode(', ', $stockErrors)
                ], 422);
            }

            // ✅ GUNAKAN TRANSACTION UNTUK KEAMANAN DATA
            DB::beginTransaction();

            $totalQty   = 0;
            $totalHarga = 0;
            $listMenu   = [];

            foreach ($items as $item) {
                $menuName = $item['name']  ?? null;
                $qty      = (int)($item['qty']   ?? 1);
                $price    = (int)($item['price'] ?? 0);

                if (!$menuName || $qty <= 0 || $price < 0) {
                    continue;
                }

                // ✅ KURANGI STOK MENU
                $menu = Menu::where('nama_menu', $menuName)->first();
                if ($menu) {
                    $menu->decreaseStock($qty);
                }

                $totalQty   += $qty;
                $totalHarga += $qty * $price;

                $listMenu[] = $menuName . ' x' . $qty;
            }

            if ($totalQty === 0 || $totalHarga <= 0) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Keranjang tidak valid.'
                ], 422);
            }

            // nama & id pelanggan dari session
            $namaPelanggan = session('customer.name', 'Umum');
            $pelangganId   = session('customer.id');

            $metodePembayaran = $request->input('metode_pembayaran', 'cod');
            $noMeja           = $request->input('no_meja');

            // Generate kode order unik
            $kodeOrder = 'ORD-' . date('Ymd') . '-' . Str::upper(Str::random(5));

            $menuDipesan = implode(', ', $listMenu);

            // Simpan ke tabel orders
            $order = Order::create([
                'pelanggan_id'      => $pelangganId,
                'kode_order'        => $kodeOrder,
                'customer_name'     => $namaPelanggan,
                'subtotal'          => $totalHarga,
                'status'            => 'pending',
                'metode_pembayaran' => $metodePembayaran,
                'no_meja'           => $noMeja,
                'keterangan'        => $menuDipesan,
            ]);

            // ✅ COMMIT TRANSACTION
            DB::commit();

            return response()->json([
                'success'      => true,
                'message'      => 'Pesanan berhasil dibuat.',
                'order_id'     => $order->id,
                'redirect_url' => route('customer.orders.show', $order->id),
            ], 201);

        } catch (\Exception $e) {
            // ✅ ROLLBACK JIKA ERROR
            DB::rollBack();

            \Log::error('Order Store Error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan pesanan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Halaman sukses untuk pelanggan
     * Route: GET /pesanan/{order}/berhasil  (name: customer.orders.show)
     */
    public function showCustomer(Order $order)
    {
        // QR Code untuk pembayaran (kalau ada di tabel settings)
        $qrCodePath = Setting::where('key', 'payment_qr_code_path')->value('value');

        // Ganti 'frontend.order-success' sesuai struktur view kamu
        return view('frontend.order-success', compact('order', 'qrCodePath'));
    }

    /**
     * Daftar order (untuk admin/staff di panel admin)
     * Route:
     *  - GET /admin/orders   (name: admin.orders.index)
     *  - GET /orders         (umum, kalau dipakai)
     */
    public function index()
    {
        $orders = Order::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Detail order (admin)
     * Route: GET /admin/orders/{order}  & GET /orders/{order}
     */
    public function show(Order $order)
    {
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update status order (admin)
     * Route: PATCH /admin/orders/{order}/status
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,diproses,selesai,dibatalkan',
        ]);

        $order->update([
            'status' => $request->status,
        ]);

        return back()->with('success', 'Status pesanan berhasil diperbarui!');
    }

    /**
     * Hapus order (admin)
     * Route: DELETE /admin/orders/{order}
     */
    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()
            ->route('admin.orders.index')
            ->with('success', 'Pesanan berhasil dihapus!');
    }

    /**
     * API: cek status order (JSON)
     * Route: GET /orders/{order}/status-json
     */
    public function statusJson(Order $order)
    {
        return response()->json([
            'status'     => $order->status,
            'kode_order' => $order->kode_order,
        ]);
    }

    /**
     * API: notifikasi order baru (JSON)
     * Route: GET /notifications/orders
     */
    public function notificationsJson()
    {
        $newOrders = Order::where('status', 'pending')
            ->where('created_at', '>=', now()->subMinutes(5))
            ->count();

        return response()->json([
            'count' => $newOrders,
        ]);
    }
}
