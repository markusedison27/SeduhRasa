<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Menu; // 🔹 Supaya bisa ambil daftar menu

class OrderController extends Controller
{
    /**
     * 🟢 Halaman Publik - Tampilkan daftar menu untuk pembeli
     */
    public function showPublicOrderPage()
    {
        // Ambil semua menu dari tabel menus
        $menus = Menu::all();

        // Tampilkan ke halaman resources/views/order.blade.php
        return view('order', compact('menus'));
    }

    /**
     * 🟠 Halaman Admin - Daftar semua Order (CRUD)
     */
    public function index()
    {
        // Ambil semua data order urut terbaru
        $orders = Order::orderBy('created_at', 'desc')->get(); 
        
        return view('orders.index', compact('orders'));
    }

    /**
     * 🔵 Form tambah order (admin)
     */
    public function create()
    {
        return view('orders.create');
    }

    /**
     * 🔵 Simpan data order baru ke database
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_order' => 'required|string|max:255',
            'status' => 'required|string|max:50',
            'meja_nomor' => 'nullable|string|max:50',
            'waktu_order' => 'nullable|date',
            'keterangan' => 'nullable|string',
        ]);

        Order::create($validated);

        return redirect()->route('orders.index')->with('success', 'Order berhasil ditambahkan!');
    }

    /**
     * 🔵 Hapus order (admin)
     */
    public function destroy($id)
    {
        Order::findOrFail($id)->delete();
        return redirect()->route('orders.index')->with('success', 'Order berhasil dihapus!');
    }
}
