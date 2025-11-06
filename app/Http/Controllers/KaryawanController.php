<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan; // <-- PENTING: Import Model Karyawan

class KaryawanController extends Controller
{
    /**
     * Menampilkan daftar semua Karyawan.
     */
    public function index()
    {
        // 1. Ambil semua data karyawan
        $karyawan = Karyawan::all(); 
        
        // 2. Kirim data '$karyawan' ke view 'karyawan.index'
        return view('karyawan.index', compact('karyawan'));
    }

    // ... Anda perlu mengimplementasikan logika CRUD di metode lain di sini
    public function create()
    {
        return view('karyawan.create');
    }

    // ... metode CRUD lainnya (store, show, edit, update, destroy)
}