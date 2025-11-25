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
        // Group menu berdasarkan kategori
        $menuGroups = Menu::select('kategori')
            ->distinct()
            ->get()
            ->map(function ($group) {
                return (object)[
                    'kategori' => $group->kategori,
                    'items' => Menu::where('kategori', $group->kategori)->get()
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
            'nama_menu' => 'required',
            'kategori'  => 'required',
            'harga'     => 'required|numeric',
            'suhu'      => 'nullable',
            'gambar'    => 'nullable|image|max:2048',
            // kalau form punya field group, boleh dibuat required
            'group'     => 'nullable|string',
        ]);

        // Simpan gambar
        $gambar = null;
        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar')->store('menu', 'public');
        }

        // kasih default untuk kolom `group` biar gak error
        $group = $request->input('group') ?? 'General';

        // Simpan ke database
        Menu::create([
            'nama_menu' => $request->nama_menu,
            'kategori'  => $request->kategori,
            'harga'     => $request->harga,
            'suhu'      => $request->suhu,
            'gambar'    => $gambar,
            'group'     => $group,
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
            'nama_menu' => 'required',
            'kategori'  => 'required',
            'harga'     => 'required|numeric',
            'suhu'      => 'nullable',
            'gambar'    => 'nullable|image|max:2048',
            'group'     => 'nullable|string',
        ]);

        $gambar = $menu->gambar;
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($gambar && Storage::disk('public')->exists($gambar)) {
                Storage::disk('public')->delete($gambar);
            }
            $gambar = $request->file('gambar')->store('menu', 'public');
        }

        $group = $request->input('group') ?? $menu->group ?? 'General';

        $menu->update([
            'nama_menu' => $request->nama_menu,
            'kategori'  => $request->kategori,
            'harga'     => $request->harga,
            'suhu'      => $request->suhu,
            'gambar'    => $gambar,
            'group'     => $group,
        ]);

        return redirect()->route('admin.menus.index')
                         ->with('success', 'Menu berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);

        // Hapus gambar jika ada
        if ($menu->gambar && Storage::disk('public')->exists($menu->gambar)) {
            Storage::disk('public')->delete($menu->gambar);
        }

        $menu->delete();

        return redirect()->route('admin.menus.index')
                         ->with('success', 'Menu berhasil dihapus!');
    }
}
