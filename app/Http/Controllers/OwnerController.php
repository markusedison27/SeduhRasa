<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Pengeluaran;

class OwnerController extends Controller
{
    /**
     * Dashboard owner
     */
    public function index()
    {
        $owner = auth()->user();

        // contoh ringkasan dummy (silakan sambung ke tabelmu kalau mau)
        $totalTransaksiHariIni = Transaksi::whereDate('created_at', today())->count();
        $perkiraanPendapatan   = Transaksi::sum('total_harga'); // ganti kolom kalau beda
        $jumlahStaffAktif      = 0; // nanti bisa diambil dari tabel karyawan

        return view('owner.dashboard', compact(
            'owner',
            'totalTransaksiHariIni',
            'perkiraanPendapatan',
            'jumlahStaffAktif'
        ));
    }

    /**
     * Halaman keuangan (pemasukan & pengeluaran)
     */
    public function finance()
    {
        $owner = auth()->user();

        // --- Pemasukan (dari transaksi) ---
        // Kalau ada kolom status (paid, selesai, dll) bisa ditambah where-status di sini
        $totalPemasukan = Transaksi::sum('total_harga'); // ganti ke nama kolom total punyamu
        $daftarPemasukan = Transaksi::orderByDesc('created_at')
            ->limit(10)
            ->get();

        // --- Pengeluaran (dari tabel pengeluarans) ---
        $totalPengeluaran = Pengeluaran::sum('nominal');
        $daftarPengeluaran = Pengeluaran::orderByDesc('tanggal')
            ->limit(10)
            ->get();

        return view('owner.finance', compact(
            'owner',
            'totalPemasukan',
            'totalPengeluaran',
            'daftarPemasukan',
            'daftarPengeluaran'
        ));
    }
}
