<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;        
use App\Models\Pengeluaran;  
use Illuminate\Support\Facades\Storage; 
use Illuminate\Support\Facades\Hash;
use App\Models\Setting;
use App\Http\Requests\ProfileUpdateRequest;

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

        // --- AMBIL PATH QR CODE DARI DATABASE ---
        $qrCodePath = Setting::where('key', 'payment_qr_code_path')->value('value');
        // ----------------------------------------

        return view('owner.dashboard', compact(
            'owner',
            'totalTransaksiHariIni',
            'perkiraanPendapatan',
            'jumlahStaffAktif',
            'qrCodePath' // Dikirim ke dashboard.blade.php
        ));
    }

    /**
     * Logic untuk mengunggah dan menyimpan path QR Code
     */
    public function uploadQrCode(Request $request)
    {
        // 1. Validasi File
        $request->validate([
            'qrcode_file' => 'required|image|mimes:png,jpg,jpeg|max:2048', // Maks 2MB
        ]);

        // 2. Simpan File ke Storage
        $path = $request->file('qrcode_file')->store('public/qrcodes');

        // Hapus 'public/' dari path agar mudah diakses dengan asset('storage/...')
        $storedPath = str_replace('public/', '', $path); 

        // 3. Simpan Path ke Database (Config/Setting)
        Setting::updateOrCreate(
            ['key' => 'payment_qr_code_path'],
            ['value' => $storedPath]
        );

        return redirect()->route('owner.dashboard')->with('success', 'QR Code pembayaran berhasil diperbarui!');
    }

    /**
     * Halaman keuangan pemilik
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

    /**
     * Menampilkan halaman edit profile
     */
    public function editProfile()
    {
        $owner = auth()->user();
        
        return view('owner.edit-profile', compact('owner'));
    }

    /**
     * Update profile owner
     */
    public function updateProfile(ProfileUpdateRequest $request)
    {
        $owner = auth()->user();

        // Update nama dan email
        $owner->name = $request->name;
        $owner->email = $request->email;

        // Handle upload avatar jika ada
        if ($request->hasFile('avatar')) {
            // Hapus avatar lama jika bukan dari Google
            if ($owner->avatar && !str_contains($owner->avatar, 'googleusercontent.com')) {
                Storage::delete('public/' . $owner->avatar);
            }

            // Simpan avatar baru
            $avatarPath = $request->file('avatar')->store('public/avatars');
            $owner->avatar = str_replace('public/', '', $avatarPath);
        }

        // Update password jika diisi
        if ($request->filled('password')) {
            $owner->password = Hash::make($request->password);
        }

        $owner->save();

        return redirect()->route('owner.profile.edit')
            ->with('success', 'Profile berhasil diperbarui!');
    }
}