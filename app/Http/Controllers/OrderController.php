<?php

namespace App\Http\Controllers;

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

            // Generate kode order unik
            $kodeOrder = 'ORD-' . date('Ymd') . '-' . strtoupper(Str::random(5));

            // Simpan order ke database dengan nama kolom yang benar
            $order = Order::create([
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
}