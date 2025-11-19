<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu; // ← DITAMBAHKAN

class MenuController extends Controller
{
    // ==========================
    // ADMIN MENU (admin.menus.*)
    // ==========================

    public function index()
{
    $menus = Menu::all(); // AMBIL DATA DARI DATABASE
    return view('menus.index', compact('menus'));
}


    public function create()
    {
        return view('menus.create'); // pastikan view ini ada
    }

    public function store(Request $request)
    {
        // ← DITAMBAHKAN (TANPA HAPUS YANG LAIN)
        $request->validate([
            'nama_menu' => 'required',
            'kategori' => 'required',
            'harga' => 'required|numeric',
            'suhu' => 'nullable',
            'gambar' => 'nullable|image',
        ]);

        $gambar = null;
        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar')->store('menu', 'public');
        }

        Menu::create([
            'nama_menu' => $request->nama_menu,
            'kategori' => $request->kategori,
            'harga' => $request->harga,
            'suhu' => $request->suhu,
            'gambar' => $gambar,
        ]);

        // tetap memakai baris kamu
        return redirect()->route('admin.menus.index')->with('success', 'Menu berhasil ditambahkan!');

    }

    // ==========================
    // HALAMAN ORDER PUBLIK /order
    // ==========================
    public function publicOrder()
    {
        // ← DITAMBAHKAN (TIDAK MENGHAPUS DUMMY)
        $menus = Menu::all(); // AMBIL DATA DARI DATABASE

        return view('order', compact('menus'));
    }
}
