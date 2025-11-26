<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    /**
     * Tampilkan daftar pelanggan.
     */
    public function index(Request $request)
    {
        $query = Pelanggan::query();

        // Fitur cari
        if ($request->filled('q')) {
            $search = $request->q;

            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('telepon', 'like', "%{$search}%");
            });
        }

        $pelanggans = $query->latest()->paginate(10)->withQueryString();

        // VIEW: resources/views/pelanggan/index.blade.php
        return view('pelanggan.index', compact('pelanggans'));
    }

    /**
     * Form tambah pelanggan.
     */
    public function create()
    {
        // VIEW: resources/views/pelanggan/create.blade.php
        return view('pelanggan.create');
    }

    /**
     * Simpan pelanggan baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'    => 'required|string|max:255',
            'email'   => 'nullable|email|unique:pelanggans,email',
            'telepon' => 'nullable|string|max:20',
            'alamat'  => 'nullable|string',
        ]);

        Pelanggan::create($validated);

        return redirect()
            ->route('admin.pelanggan.index')
            ->with('success', 'Pelanggan berhasil ditambahkan.');
    }

    /**
     * Form edit pelanggan.
     */
    public function edit(Pelanggan $pelanggan)
    {
        // VIEW: resources/views/pelanggan/edit.blade.php
        return view('pelanggan.edit', compact('pelanggan'));
    }

    /**
     * Update data pelanggan.
     */
    public function update(Request $request, Pelanggan $pelanggan)
    {
        $validated = $request->validate([
            'nama'    => 'required|string|max:255',
            'email'   => 'nullable|email|unique:pelanggans,email,' . $pelanggan->id,
            'telepon' => 'nullable|string|max:20',
            'alamat'  => 'nullable|string',
        ]);

        $pelanggan->update($validated);

        return redirect()
            ->route('admin.pelanggan.index')
            ->with('success', 'Pelanggan berhasil diperbarui.');
    }

    /**
     * Hapus pelanggan.
     */
    public function destroy(Pelanggan $pelanggan)
    {
        $pelanggan->delete();

        return redirect()
            ->route('admin.pelanggan.index')
            ->with('success', 'Pelanggan berhasil dihapus.');
    }
}
