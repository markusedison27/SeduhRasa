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
        // Group menu berdasarkan field "group"
        $menuGroups = Menu::select('group')
            ->distinct()
            ->get()
            ->map(function ($group) {
                return (object) [
                    'kategori' => $group->group,
                    'items'    => Menu::where('group', $group->group)->get(),
                ];
            });

        return view('menu', compact('menuGroups'));
    }

    // ==========================
    // ADMIN MENU
    // ==========================

    public function index()
    {
        $menus = Menu::all();
        return view('menus.index', compact('menus'));
    }

    public function create()
    {
        return view('menus.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_menu' => 'required|string|max:255|unique:menus,nama_menu',
            'group'     => 'required|string',
            'harga'     => 'required|numeric|min:0',
            'stok'      => 'required|integer|min:0',
            'kategori'  => 'nullable|string|max:255',
            'suhu'      => 'nullable|string|max:50',
            'gambar'    => 'nullable|image|max:2048',
            'description' => 'nullable|string',
        ]);

        $menu = new Menu();
        $menu->nama_menu = $request->nama_menu;
        $menu->group     = $request->group;
        $menu->harga     = $request->harga;
        $menu->stok      = $request->stok;
        $menu->kategori  = $request->kategori;
        $menu->suhu      = $request->suhu;
        $menu->description = $request->description;

        // upload gambar (pakai field "gambar" karena itu yang ada di blade)
        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('menu', 'public');
            $menu->gambar = $path;
        }

        $menu->save();

        return redirect()
            ->route('admin.menus.index')
            ->with('success', 'Menu berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        return view('menus.edit', compact('menu'));
    }

    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        $request->validate([
            'nama_menu' => 'required|string|max:255|unique:menus,nama_menu,' . $id,
            'harga'     => 'required|numeric|min:0',
            'stok'      => 'required|integer|min:0',
            'kategori'  => 'nullable|string|max:255',
            'suhu'      => 'nullable|string|max:50',
            'gambar'    => 'nullable|image|max:2048',
            'description' => 'nullable|string',
        ]);

        // UPDATE FIELD MANUAL (biar nggak kehalang fillable)
        $menu->nama_menu   = $request->nama_menu;
        $menu->harga       = $request->harga;
        $menu->stok        = $request->stok;        // ⬅️ INI YANG PENTING
        $menu->kategori    = $request->kategori;
        $menu->suhu        = $request->suhu;
        $menu->description = $request->description;

        // handle gambar
        if ($request->hasFile('gambar')) {
            // hapus gambar lama jika ada
            if ($menu->gambar && Storage::disk('public')->exists($menu->gambar)) {
                Storage::disk('public')->delete($menu->gambar);
            }

            $path = $request->file('gambar')->store('menu', 'public');
            $menu->gambar = $path;
        }

        $menu->save(); // ⬅️ SIMPAN PERUBAHAN

        return redirect()
            ->route('admin.menus.index')
            ->with('success', 'Menu berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);

        if ($menu->gambar && Storage::disk('public')->exists($menu->gambar)) {
            Storage::disk('public')->delete($menu->gambar);
        }

        $menu->delete();

        return redirect()
            ->route('admin.menus.index')
            ->with('success', 'Menu berhasil dihapus!');
    }
}
