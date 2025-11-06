<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggan; // <-- PENTING: Import Model Pelanggan

class PelangganController extends Controller
{
    /**
     * Menampilkan daftar semua Pelanggan.
     */
    public function index()
    {
        // 1. Ambil semua data pelanggan
        $pelanggan = Pelanggan::all(); 
        
        // 2. Kirim data '$pelanggan' ke view 'pelanggan.index'
        return view('pelanggan.index', compact('pelanggan'));
    }

    // ... Anda perlu mengimplementasikan logika CRUD di metode lain di sini
    public function create()
    {
        return view('pelanggan.create');
    }

    // ... metode CRUD lainnya (store, show, edit, update, destroy)
}