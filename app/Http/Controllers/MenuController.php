<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Models\Menu; // Import Model Anda jika sudah dibuat

class MenuController extends Controller
{
    /**
     * Menampilkan daftar semua Menu.
     */
    public function index()
    {
        // $menus = Menu::all();
        // return view('menus.index', compact('menus'));
        return view('menus.index');
    }

    /**
     * Menampilkan form untuk membuat Menu baru.
     */
    public function create()
    {
        return view('menus.create');
    }

    /**
     * Menyimpan Menu baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi input
        // $request->validate([...]);
        
        // Menu::create($request->all());
        // return redirect()->route('menus.index')->with('success', 'Menu berhasil ditambahkan.');
    }

    /**
     * Menampilkan Menu tertentu.
     */
    public function show(string $id)
    {
        // $menu = Menu::findOrFail($id);
        // return view('menus.show', compact('menu'));
    }

    /**
     * Menampilkan form untuk mengedit Menu.
     */
    public function edit(string $id)
    {
        // $menu = Menu::findOrFail($id);
        // return view('menus.edit', compact('menu'));
    }

    /**
     * Memperbarui Menu di database.
     */
    public function update(Request $request, string $id)
    {
        // Validasi input & Logika update
        // $menu = Menu::findOrFail($id);
        // $menu->update($request->all());
        // return redirect()->route('menus.index')->with('success', 'Menu berhasil diperbarui.');
    }

    /**
     * Menghapus Menu dari database.
     */
    public function destroy(string $id)
    {
        // $menu = Menu::findOrFail($id);
        // $menu->delete();
        // return redirect()->route('menus.index')->with('success', 'Menu berhasil dihapus.');
    }
}