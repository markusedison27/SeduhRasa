<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ContactMessage;

class DashboardController extends Controller
{
    public function index()
    {
        // total penjualan hari ini (sementara dari semua order hari ini)
        $today = now()->toDateString();

        $totalPenjualanHariIni = Order::whereDate('created_at', $today)
            // kalau nanti sudah pakai status 'selesai', bisa aktifkan ini:
            // ->where('status', 'selesai')
            ->sum('subtotal'); // <-- ganti dari total_harga ke subtotal

        // total pesanan bulan ini
        $bulanIni = now()->month;
        $tahunIni = now()->year;

        $totalPesananBulanIni = Order::whereYear('created_at', $tahunIni)
            ->whereMonth('created_at', $bulanIni)
            ->count();

        // pengeluaran operasional (sementara 0 dulu)
        $pengeluaranOperasional = 0;

        // JUMLAH PESANAN YANG BELUM DIPROSES (status pending)
        $pendingCount = Order::where('status', 'pending')->count();

        // pesanan terbaru (pending)
        $pesananTerbaru = Order::where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        // 🔹 PESAN DARI HALAMAN CONTACT
        $latestMessages = ContactMessage::latest()
            ->take(5)
            ->get();                     // 5 pesan terbaru

        $totalMessages  = ContactMessage::count(); // total semua pesan

        return view('dashboard', [
            'totalPenjualanHariIni'  => $totalPenjualanHariIni,
            'totalPesananBulanIni'   => $totalPesananBulanIni,
            'pengeluaranOperasional' => $pengeluaranOperasional,
            'pesananTerbaru'         => $pesananTerbaru,
            'pendingCount'           => $pendingCount,

            // data untuk bagian Pesan Pengguna di dashboard (kalau mau dipakai)
            'latestMessages'         => $latestMessages,
            'totalMessages'          => $totalMessages,
        ]);
    }
}
