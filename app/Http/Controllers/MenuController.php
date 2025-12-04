<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    // ==========================
    // HALAMAN MENU PUBLIK /menu
    // ==========================

    public function publicMenu()
    {
        // Group menu berdasarkan kategori (group)
        $menuGroups = Menu::select('group')
            ->distinct()
            ->get()
            ->map(function ($group) {
                return (object)[
                    'kategori' => $group->group,
                    'items' => Menu::where('group', $group->group)->get()
                ];
            });

        return view('menu', compact('menuGroups'));
    }

    // ==========================
    // ADMIN MENU (admin.menus.*)
    // ==========================

    // Tampilkan semua menu di halaman admin
    public function index()
    {
        $menus = Menu::all();
        return view('menus.index', compact('menus'));
    }

    // Form tambah menu
    public function create()
    {
        return view('menus.create');
    }

    // Simpan menu baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_menu'   => 'required|string|max:255|unique:menus,nama_menu',
            'group'       => 'required|string',
            'harga'       => 'required|numeric|min:0',
            'stok'        => 'required|integer|min:0', // ✅ VALIDASI STOK
            'image'       => 'nullable|image|max:2048',
            'description' => 'nullable|string',
        ]);

        // Simpan gambar
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('menu', 'public');
        }

        // Simpan ke database
        Menu::create([
            'nama_menu'   => $request->nama_menu,
            'group'       => $request->group,
            'harga'       => $request->harga,
            'stok'        => $request->stok, // ✅ SIMPAN STOK
            'image'       => $imagePath,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.menus.index')
                         ->with('success', 'Menu berhasil ditambahkan!');
    }

    // Form edit
    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        return view('menus.edit', compact('menu'));
    }

    // Update menu
    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        $request->validate([
            'nama_menu'   => 'required|string|max:255|unique:menus,nama_menu,' . $id,
            'group'       => 'required|string',
            'harga'       => 'required|numeric|min:0',
            'stok'        => 'required|integer|min:0', // ✅ VALIDASI STOK
            'image'       => 'nullable|image|max:2048',
            'description' => 'nullable|string',
        ]);

        $imagePath = $menu->image;
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
            $imagePath = $request->file('image')->store('menu', 'public');
        }

        $menu->update([
            'nama_menu'   => $request->nama_menu,
            'group'       => $request->group,
            'harga'       => $request->harga,
            'stok'        => $request->stok, // ✅ UPDATE STOK
            'image'       => $imagePath,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.menus.index')
                         ->with('success', 'Menu berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);

        // Hapus gambar jika ada
        if ($menu->image && Storage::disk('public')->exists($menu->image)) {
            Storage::disk('public')->delete($menu->image);
        }

        $menu->delete();

        return redirect()->route('admin.menus.index')
                         ->with('success', 'Menu berhasil dihapus!');
    }
}