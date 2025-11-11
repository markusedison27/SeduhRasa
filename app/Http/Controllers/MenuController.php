<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        return view('menus.index'); // sudah ada
    }

    public function create()
    {
        // tampilkan form tambah menu
        return view('menus.create'); // pastikan view ini ada
    }

    // optional: biar tombol submit nanti tidak error
    public function store(Request $request)
    {
        // TODO: simpan ke DB (sementara kita terima saja)
        // $request->validate([...]);
        return back()->with('success', 'Menu berhasil ditambahkan (dummy).');
    }
}
