<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use Illuminate\Http\Request;

class PengeluaranController extends Controller
{
    public function index()
    {
        $pengeluarans = Pengeluaran::orderBy('tanggal', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10); // bebas mau 10 / 15 / 20

        $totalPengeluaran = Pengeluaran::sum('nominal');

        return view('admin.pengeluaran.index', compact('pengeluarans', 'totalPengeluaran'));
    }



    public function create()
    {
        return view('admin.pengeluaran.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'keterangan' => 'required|string|max:255',
            'nominal' => 'required|numeric|min:0',
        ]);

        $validated['kategori'] = 'Bahan Baku';

        Pengeluaran::create($validated);

        return redirect()->route('admin.pengeluaran.index')
            ->with('success', 'Pengeluaran berhasil ditambahkan');
    }

    public function edit(Pengeluaran $pengeluaran)
    {
        return view('admin.pengeluaran.edit', compact('pengeluaran'));
    }

    public function update(Request $request, Pengeluaran $pengeluaran)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'keterangan' => 'required|string|max:255',
            'nominal' => 'required|numeric|min:0',
        ]);

        $validated['kategori'] = 'Bahan Baku';

        $pengeluaran->update($validated);

        return redirect()->route('admin.pengeluaran.index')
            ->with('success', 'Pengeluaran berhasil diperbarui');
    }

    public function destroy(Pengeluaran $pengeluaran)
    {
        $pengeluaran->delete();

        return redirect()->route('admin.pengeluaran.index')
            ->with('success', 'Pengeluaran berhasil dihapus');
    }
}
