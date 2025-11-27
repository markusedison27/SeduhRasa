<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;        // pemasukan dari penjualan
use App\Models\Pengeluaran;  // pengeluaran operasional

class OwnerController extends Controller
{
    /**
     * Dashboard owner
     */
    public function index()
    {
        $owner = auth()->user();

        // Total transaksi selesai hari ini
        $totalTransaksiHariIni = Order::where('status', 'selesai')
            ->whereDate('created_at', today())
            ->count();

        // Perkiraan pendapatan (dari semua order selesai)
        $perkiraanPendapatan = Order::where('status', 'selesai')
            ->sum('subtotal');

        // Sementara dummy, nanti bisa diambil dari tabel karyawan
        $jumlahStaffAktif = 0;

        return view('owner.dashboard', compact(
            'owner',
            'totalTransaksiHariIni',
            'perkiraanPendapatan',
            'jumlahStaffAktif'
        ));
    }

    /**
     * Halaman keuangan pemilik
     * Menampilkan ringkasan pemasukan & pengeluaran
     */
    public function finance()
    {
        $owner = auth()->user();

        // --- PEMASUKAN (dari orders yang sudah selesai) ---
        $orderQuery = Order::where('status', 'selesai');

        $totalPemasukan = $orderQuery->sum('subtotal');

        // 10 pemasukan terbaru
        $daftarPemasukan = (clone $orderQuery)
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        // --- PENGELUARAN (dari tabel pengeluarans) ---
        // pastikan di tabel pengeluarans ada kolom 'nominal' & 'tanggal'
        $pengeluaranQuery = Pengeluaran::query();

        $totalPengeluaran = $pengeluaranQuery->sum('nominal');

        // 10 pengeluaran terbaru
        $daftarPengeluaran = $pengeluaranQuery
            ->orderByDesc('tanggal')
            ->limit(10)
            ->get();

        // --- LABA SEDERHANA ---
        $labaBersih = $totalPemasukan - $totalPengeluaran;

        return view('owner.finance', compact(
            'owner',
            'totalPemasukan',
            'totalPengeluaran',
            'labaBersih',
            'daftarPemasukan',
            'daftarPengeluaran'
        ));
    }
}
