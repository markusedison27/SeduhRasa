<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | PUBLIC (checkout dari halaman menu)
    |--------------------------------------------------------------------------
    */

    // POST /orders  -> route('orders.store')
    public function store(Request $request)
    {
        // items dikirim dari JS (menu.blade.php) sebagai JSON string
        $raw   = $request->input('items');
        $items = json_decode($raw, true);

        if (!$items || !is_array($items) || count($items) === 0) {
            return back()->with('error', 'Keranjang masih kosong.')->withInput();
        }

        $totalQty   = 0;
        $totalHarga = 0;
        $listMenu   = [];

        foreach ($items as $item) {
            $name  = $item['name']  ?? null;
            $qty   = (int)($item['qty'] ?? 1);
            $price = (int)($item['price'] ?? 0);

            if (!$name || $qty <= 0 || $price < 0) {
                continue;
            }

            $totalQty   += $qty;
            $totalHarga += $qty * $price;

            // contoh format: "Americano x2"
            $listMenu[] = $name . ' x' . $qty;
        }

        if ($totalQty === 0 || $totalHarga <= 0) {
            return back()->with('error', 'Keranjang tidak valid.')->withInput();
        }

        // nama_pelanggan dikirim dari menu.blade (bukan customer_name lagi)
        $namaPelanggan = $request->input('nama_pelanggan') ?: 'Umum';

        // metode pembayaran: "cod" atau "transfer"
        $metodePembayaran = $request->input('metode_pembayaran', 'cod');

        $menuDipesan = implode(', ', $listMenu);

        // Simpan ke tabel orders sesuai struktur DB kamu
        $order = Order::create([
            'nama_pelanggan'    => $namaPelanggan,
            'menu_dipesan'      => $menuDipesan,
            'jumlah'            => $totalQty,
            'total_harga'       => $totalHarga,
            'status'            => 'pending',
            'metode_pembayaran' => $metodePembayaran,   // <--- baru
        ]);

        // Redirect ke halaman detail pesanan
        return redirect()
            ->route('orders.show', $order->id)
            ->with('success', 'Pesanan berhasil dibuat!');
    }

    // GET /orders/{order}  -> route('orders.show')
    public function show(Order $order)
    {
        return view('orders.show', [
            'order' => $order,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN (resource /admin/orders)
    |--------------------------------------------------------------------------
    */

    // GET /admin/orders  -> admin.orders.index
    public function index()
    {
        $orders = Order::latest()->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    // GET /admin/orders/{order} -> admin.orders.show
    public function adminShow(Order $order)
    {
        return view('admin.orders.show', compact('order'));
    }

    // DELETE /admin/orders/{order} -> admin.orders.destroy
    public function destroy(Order $order)
    {
        $order->delete();

        return back()->with('success', 'Order berhasil dihapus.');
    }
}
