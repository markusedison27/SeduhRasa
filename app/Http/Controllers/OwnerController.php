<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;        
use App\Models\Pengeluaran;  
use App\Models\Setting;
use App\Models\User; // Ditambahkan jika Anda memerlukannya untuk menghitung staff
use App\Http\Requests\ProfileUpdateRequest; // <-- SUMBER MASALAH 'CLASS NOT FOUND'

// Import yang diperlukan
use Illuminate\Support\Facades\Storage; 
use Illuminate\Support\Facades\Hash;

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

        // Jumlah Staff Aktif (sebaiknya diambil dari tabel user)
        // Contoh: $jumlahStaffAktif = User::where('role', 'staff')->count();
        $jumlahStaffAktif = 0; 

        // Ambil Path QR Code dari Database
        $qrCodePath = Setting::where('key', 'payment_qr_code_path')->value('value');

        return view('owner.dashboard', compact(
            'owner',
            'totalTransaksiHariIni',
            'perkiraanPendapatan',
            'jumlahStaffAktif',
            'qrCodePath'
        ));
    }

    /**
     * Logic untuk mengunggah dan menyimpan path QR Code
     */
    public function uploadQrCode(Request $request)
    {
        // Logika untuk upload QR Code (asumsi sudah ada)
        // ...
    }

    /**
     * Tampilkan halaman keuangan (placeholder)
     */
    public function finance()
    {
        // Logika untuk halaman finance (asumsi sudah ada)
        // ...
    }


    /**
     * Menampilkan halaman edit profile (Digunakan oleh Owner & Staff/Admin)
     */
    public function editProfile()
    {
        $owner = auth()->user();
        return view('owner.edit-profile', compact('owner'));
    }

    /**
     * Update profile owner (Informasi Dasar, Avatar, dan Password jika diisi)
     */
    public function updateProfile(ProfileUpdateRequest $request) // <-- MASALAH UTAMA 1
    {
        $owner = $request->user();

        // 1. Update data dasar (name dan email)
        $owner->fill($request->validated());

        // 2. Handle upload avatar jika ada
        if ($request->hasFile('avatar')) {
            // Hapus avatar lama jika bukan dari Google dan ada file yang tersimpan
            if ($owner->avatar && !str_contains($owner->avatar, 'googleusercontent.com')) {
                Storage::disk('public')->delete($owner->avatar); 
            }

            // Simpan avatar baru dan update path di database
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $owner->avatar = $avatarPath; 
        }

        // 3. Update password jika diisi (sudah divalidasi oleh ProfileUpdateRequest)
        if ($request->filled('password')) {
            $owner->password = Hash::make($request->password); 
        }

        $owner->save();

        return redirect()->route('owner.profile.edit')
            ->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Update password owner (Metode terpisah untuk formulir password)
     */
    public function updatePassword(ProfileUpdateRequest $request) // <-- MASALAH UTAMA 2
    {
        // Karena ProfileUpdateRequest memiliki aturan 'password', kita hanya perlu cek apakah diisi
        if (!$request->filled('password')) {
            return redirect()->route('owner.profile.edit')
                ->with('error', 'Password baru tidak boleh kosong.');
        }

        $user = $request->user();

        // Enkripsi dan simpan password baru
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('owner.profile.edit')
            ->with('success', 'Password berhasil diperbarui!');
    }
}