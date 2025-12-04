<?php

namespace App\Http\Controllers;

<<<<<<< HEAD
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Setting;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Tampilkan halaman sukses untuk pelanggan
     * Route: GET /pesanan/{order}/berhasil
     */
    public function showCustomer(Order $order)
    {
        // Ambil QR Code Path dari database
        $qrCodePath = Setting::where('key', 'payment_qr_code_path')->value('value');
        
        // Kirim data ke view
        return view('frontend.order-success', compact('order', 'qrCodePath'));
    }

    /**
     * Simpan pesanan baru dari pelanggan
     * Route: POST /orders
     */
=======
use App\Models\Order;
use App\Models\Pelanggan;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // ... (kode lainnya tetap sama)

>>>>>>> cc71156340b9bc132b8ae9f53784358370701f4a
    public function store(Request $request)
    {
        try {
            // Validasi input - SESUAIKAN dengan nama kolom database
            $validated = $request->validate([
                'customer_name' => 'required|string|max:255',
                'meja_nomor' => 'nullable|integer',
                'metode_pembayaran' => 'required|in:cod,dana,transfer',
                'subtotal' => 'required|numeric|min:0',
                'keterangan' => 'nullable|string',
            ]);

<<<<<<< HEAD
=======
            /*
             * AMBIL ITEMS
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
                $qty = (int)($item['qty'] ?? 1);

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
            $noMeja = $request->input('no_meja');

>>>>>>> cc71156340b9bc132b8ae9f53784358370701f4a
            // Generate kode order unik
            $kodeOrder = 'ORD-' . date('Ymd') . '-' . strtoupper(Str::random(5));

            // Simpan order ke database dengan nama kolom yang benar
            $order = Order::create([
<<<<<<< HEAD
                'kode_order' => $kodeOrder,
                'customer_name' => $validated['customer_name'],
                'meja_nomor' => $validated['meja_nomor'],
                'metode_pembayaran' => $validated['metode_pembayaran'],
                'subtotal' => $validated['subtotal'],
                'keterangan' => $validated['keterangan'] ?? null,
                'status' => 'pending',
                'waktu_order' => now(),
            ]);

            // Simpan items jika ada (ke tabel order_items)
            if ($request->has('items') && is_array($request->items)) {
                foreach ($request->items as $item) {
                    $order->items()->create([
                        'name' => $item['name'],
                        'qty' => $item['qty'],
                        'price' => $item['price'],
                        'line_total' => $item['qty'] * $item['price'],
                    ]);
                }
            }

            // Redirect ke halaman sukses
            return redirect()->route('customer.orders.show', $order->id)
                ->with('success', 'Pesanan berhasil dibuat!');

        } catch (\Exception $e) {
            // Log error untuk debugging
            \Log::error('Order creation failed: ' . $e->getMessage());
            
            return back()
                ->withInput()
                ->withErrors(['error' => 'Gagal membuat pesanan: ' . $e->getMessage()]);
        }
    }

    /**
     * Tampilkan daftar order (untuk admin/staff)
     */
    public function index()
    {
        $orders = Order::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Tampilkan detail order
     */
    public function show(Order $order)
    {
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update status order
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
     * Hapus order
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.orders.index')
            ->with('success', 'Pesanan berhasil dihapus!');
    }

    /**
     * API untuk cek status order (JSON)
     */
    public function statusJson(Order $order)
    {
        return response()->json([
            'status' => $order->status,
            'kode_order' => $order->kode_order,
        ]);
    }

    /**
     * Notifikasi order baru (JSON)
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
=======
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

    // ... (kode lainnya tetap sama)
>>>>>>> cc71156340b9bc132b8ae9f53784358370701f4a
}