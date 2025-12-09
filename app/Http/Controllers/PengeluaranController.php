<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengeluaranController extends Controller
{
    /**
     * Tampilkan daftar semua pengeluaran
     */
    public function index()
    {
        $pengeluarans = Pengeluaran::orderBy('tanggal', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $totalPengeluaran = Pengeluaran::sum('nominal');

        return view('admin.pengeluaran.index', compact('pengeluarans', 'totalPengeluaran'));
    }

    /**
     * Tampilkan form tambah pengeluaran
     */
    public function create()
    {
        return view('admin.pengeluaran.create');
    }

    /**
     * Simpan pengeluaran baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'keterangan' => 'required|string|max:255',
            'nominal' => 'required|numeric|min:0',
        ], [
            'tanggal.required' => 'Tanggal harus diisi',
            'tanggal.date' => 'Format tanggal tidak valid',
            'keterangan.required' => 'Nama barang harus diisi',
            'keterangan.max' => 'Nama barang maksimal 255 karakter',
            'nominal.required' => 'Harga harus diisi',
            'nominal.numeric' => 'Harga harus berupa angka',
            'nominal.min' => 'Harga tidak boleh negatif',
        ]);

        // Kategori fixed: Bahan Baku
        $validated['kategori'] = 'Bahan Baku';

        Pengeluaran::create($validated);

        return redirect()->route('admin.pengeluaran.index')
            ->with('success', 'Pengeluaran berhasil ditambahkan');
    }

    /**
     * Tampilkan form edit pengeluaran
     */
    public function edit(Pengeluaran $pengeluaran)
    {
        return view('admin.pengeluaran.edit', compact('pengeluaran'));
    }

    /**
     * Update pengeluaran
     */
    public function update(Request $request, Pengeluaran $pengeluaran)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'keterangan' => 'required|string|max:255',
            'nominal' => 'required|numeric|min:0',
        ], [
            'tanggal.required' => 'Tanggal harus diisi',
            'tanggal.date' => 'Format tanggal tidak valid',
            'keterangan.required' => 'Nama barang harus diisi',
            'keterangan.max' => 'Nama barang maksimal 255 karakter',
            'nominal.required' => 'Harga harus diisi',
            'nominal.numeric' => 'Harga harus berupa angka',
            'nominal.min' => 'Harga tidak boleh negatif',
        ]);

        $validated['kategori'] = 'Bahan Baku';

        $pengeluaran->update($validated);

        return redirect()->route('admin.pengeluaran.index')
            ->with('success', 'Pengeluaran berhasil diperbarui');
    }

    /**
     * Hapus pengeluaran
     */
    public function destroy(Pengeluaran $pengeluaran)
    {
        $pengeluaran->delete();

        return redirect()->route('admin.pengeluaran.index')
            ->with('success', 'Pengeluaran berhasil dihapus');
    }
}