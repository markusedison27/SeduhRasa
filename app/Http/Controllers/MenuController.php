<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;

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
            'nama_menu'   => 'required|string|max:255|unique:menus,nama_menu',
            'group'       => 'required|string',
            'harga'       => 'required|numeric|min:0',
            'stok'        => 'required|integer|min:0',
            'kategori'    => 'nullable|string|max:255',
            'suhu'        => 'nullable|string|max:50',
            'gambar'      => 'nullable|image|max:2048',
            'description' => 'nullable|string',
        ]);

        $menu = new Menu();
        $menu->nama_menu   = $request->nama_menu;
        $menu->group       = $request->group;
        $menu->harga       = $request->harga;
        $menu->stok        = $request->stok;
        $menu->kategori    = $request->kategori;
        $menu->suhu        = $request->suhu;
        $menu->description = $request->description;

        // upload gambar ke public/uploads/menu
        if ($request->hasFile('gambar')) {
            $file     = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();

            // simpan fisik file
            $file->move(public_path('uploads/menu'), $filename);

            // simpan path di database: "menu/namafile.jpg"
            $menu->gambar = 'menu/' . $filename;
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
            'nama_menu'   => 'required|string|max:255|unique:menus,nama_menu,' . $id,
            'harga'       => 'required|numeric|min:0',
            'stok'        => 'required|integer|min:0',
            'kategori'    => 'nullable|string|max:255',
            'suhu'        => 'nullable|string|max:50',
            'gambar'      => 'nullable|image|max:2048',
            'description' => 'nullable|string',
        ]);

        // update field teks
        $menu->nama_menu   = $request->nama_menu;
        $menu->harga       = $request->harga;
        $menu->stok        = $request->stok;
        $menu->kategori    = $request->kategori;
        $menu->suhu        = $request->suhu;
        $menu->description = $request->description;

        // kalau ada gambar baru di-upload
        if ($request->hasFile('gambar')) {

            // hapus gambar lama kalau ada di public/uploads/...
            if ($menu->gambar && file_exists(public_path('uploads/' . $menu->gambar))) {
                @unlink(public_path('uploads/' . $menu->gambar));
            }

            $file     = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();

            // simpan ke public/uploads/menu
            $file->move(public_path('uploads/menu'), $filename);

            // update path di DB
            $menu->gambar = 'menu/' . $filename;
        }

        $menu->save();

        return redirect()
            ->route('admin.menus.index')
            ->with('success', 'Menu berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);

        // hapus file gambar kalau masih ada di public/uploads/...
        if ($menu->gambar && file_exists(public_path('uploads/' . $menu->gambar))) {
            @unlink(public_path('uploads/' . $menu->gambar));
        }

        $menu->delete();

        return redirect()
            ->route('admin.menus.index')
            ->with('success', 'Menu berhasil dihapus!');
    }
}
