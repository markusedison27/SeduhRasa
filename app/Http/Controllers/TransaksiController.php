<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order; // PAKAI MODEL ORDER

class TransaksiController extends Controller
{
    /**
     * Laporan transaksi (route: admin.transaksi.index)
     */
    public function index(Request $request)
    {
        // Ambil order, misalnya hanya yang sudah selesai
        $query = Order::query()
            ->where('status', 'selesai'); // kalau mau semua status, silakan hapus baris ini

        // FILTER: tanggal mulai (pakai created_at)
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        // FILTER: tanggal akhir
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // FILTER: metode pembayaran
        if ($request->filled('metode_pembayaran')) {
            $query->where('metode_pembayaran', $request->metode_pembayaran);
        }

        // FILTER: search nama / kode order
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                  ->orWhere('kode_order', 'like', "%{$search}%");
            });
        }

        // Clone query untuk hitung statistik (biar filter-nya sama)
        $statsQuery = clone $query;

        $stats = [
            'total_revenue'      => (clone $statsQuery)->sum('subtotal'),
            'total_transactions' => (clone $statsQuery)->count(),
            'cash_count'         => (clone $statsQuery)->where('metode_pembayaran', 'cod')->count(),
            'transfer_count'     => (clone $statsQuery)->where('metode_pembayaran', 'dana')->count(),
        ];

        // Data transaksi buat tabel (pakai pagination)
        $transactions = $query
            ->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        return view('transaksi.index', [
            'transactions' => $transactions,
            'stats'        => $stats,
        ]);
    }

    /**
     * Detail transaksi (route: admin.transaksi.show)
     */
    public function show($id)
    {
        $transaction = Order::findOrFail($id);

        return view('transaksi.show', [
            'transaction' => $transaction,
        ]);
    }

    /**
     * Hapus transaksi (route: admin.transaksi.destroy)
     */
    public function destroy($id)
    {
        $transaction = Order::findOrFail($id);
        $transaction->delete();

        return back()->with('success', 'Transaksi berhasil dihapus.');
    }

    /**
     * Export Excel (route: admin.transaksi.export)
     * Isi bebas dulu, yang penting route-nya ada.
     */
    public function export(Request $request)
    {
        // Nanti diisi logic export beneran (pakai Laravel Excel, dll)
        // Untuk tes sementara:
        return back()->with('info', 'Fitur export belum diimplementasi.');
    }
}
