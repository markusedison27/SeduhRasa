<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Pelanggan;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // ... (kode lainnya tetap sama)

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

            // Generate kode order unik
            $kodeOrder = 'ORD-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));

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

    // ... (kode lainnya tetap sama)
}