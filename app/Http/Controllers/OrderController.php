<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order; // <-- PENTING: Import Model Order

class OrderController extends Controller
{
    /**
     * Menampilkan daftar semua Order.
     */
    public function index()
    {
        // 1. Ambil semua data order, diurutkan dari yang terbaru (descending)
        $orders = Order::orderBy('created_at', 'desc')->get(); 
        
        // 2. Kirim data '$orders' ke view 'orders.index'
        return view('orders.index', compact('orders'));
    }

    // ... Anda perlu mengimplementasikan logika CRUD di metode lain di sini
    public function create()
    {
        return view('orders.create');
    }

    // ... metode CRUD lainnya (store, show, edit, update, destroy)
}