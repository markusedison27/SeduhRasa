<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi; // <-- PENTING: Import Model Transaksi

class TransaksiController extends Controller
{
    /**
     * Menampilkan daftar semua Transaksi.
     */
    public function index()
    {
        // 1. Ambil semua data transaksi
        $transaksi = Transaksi::orderBy('created_at', 'desc')->get(); 
        
        // 2. Kirim data '$transaksi' ke view 'transaksi.index'
        return view('transaksi.index', compact('transaksi'));
    }

    // ... Anda perlu mengimplementasikan logika CRUD di metode lain di sini
    public function create()
    {
        return view('transaksi.create');
    }

    // ... metode CRUD lainnya (store, show, edit, update, destroy)
}