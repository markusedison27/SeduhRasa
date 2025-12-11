<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;        
use App\Models\Pengeluaran;  
use App\Models\Setting;
use App\Models\User;
use App\Http\Requests\ProfileUpdateRequest;

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

        // Jumlah Staff Aktif
        $jumlahStaffAktif = User::where('role', 'staff')
            ->where('owner_id', $owner->id)
            ->count();

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
        // Validasi file upload
        $request->validate([
            'qrcode_file' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Max 2MB
        ], [
            'qrcode_file.required' => 'File QR Code wajib dipilih.',
            'qrcode_file.image' => 'File harus berupa gambar.',
            'qrcode_file.mimes' => 'Format file harus jpeg, png, atau jpg.',
            'qrcode_file.max' => 'Ukuran file maksimal 2MB.',
        ]);

        try {
            // Ambil QR Code lama dari database
            $oldQrCodePath = Setting::where('key', 'payment_qr_code_path')->value('value');

            // Hapus file lama jika ada
            if ($oldQrCodePath && Storage::disk('public')->exists($oldQrCodePath)) {
                Storage::disk('public')->delete($oldQrCodePath);
            }

            // Simpan file baru ke storage/app/public/qrcodes
            $file = $request->file('qrcode_file');
            $filename = 'qrcode_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('qrcodes', $filename, 'public');

            // Simpan path ke database menggunakan updateOrCreate
            Setting::updateOrCreate(
                ['key' => 'payment_qr_code_path'],
                ['value' => $path]
            );

            return redirect()->route('owner.dashboard')
                ->with('success', 'QR Code pembayaran berhasil diunggah dan disimpan!');

        } catch (\Exception $e) {
            // Log error untuk debugging
            \Log::error('Error uploading QR Code: ' . $e->getMessage());

            return redirect()->route('owner.dashboard')
                ->with('error', 'Terjadi kesalahan saat mengunggah QR Code. Silakan coba lagi.');
        }
    }

    /**
     * Tampilkan halaman keuangan
     */
    public function finance()
    {
        $owner = auth()->user();

        // ==========================
        // TOTAL PEMASUKAN (sesuai blade: $totalPemasukan)
        // ==========================
        $totalPemasukan = Order::where('status', 'selesai')
            ->sum('subtotal');

        // ==========================
        // TOTAL PENGELUARAN
        // SEBELUMNYA: Pengeluaran::sum('jumlah'); -> ERROR (kolom 'jumlah' tidak ada)
        // DI DB & BLADE: pakai kolom 'nominal'
        // ==========================
        $totalPengeluaran = Pengeluaran::sum('nominal');

        // ==========================
        // LABA BERSIH (sesuai blade: $labaBersih)
        // ==========================
        $labaBersih = $totalPemasukan - $totalPengeluaran;

        // ==========================
        // 10 PEMASUKAN TERBARU (sesuai blade: $daftarPemasukan)
        // ==========================
        $daftarPemasukan = Order::where('status', 'selesai')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // ==========================
        // 10 PENGELUARAN TERBARU (sesuai blade: $daftarPengeluaran)
        // ==========================
        $daftarPengeluaran = Pengeluaran::orderBy('tanggal', 'desc')
            ->take(10)
            ->get();

        // Kirim data yang DIPAKAI di owner.finance.blade.php
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

        // 3. Update password jika diisi
        if ($request->filled('password')) {
            $owner->password = Hash::make($request->password); 
        }

        $owner->save();

        return redirect()->route('owner.profile.edit')
            ->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Update password owner
     */
    public function updatePassword(ProfileUpdateRequest $request)
    {
        if (!$request->filled('password')) {
            return redirect()->route('owner.profile.edit')
                ->with('error', 'Password baru tidak boleh kosong.');
        }

        $user = $request->user();
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('owner.profile.edit')
            ->with('success', 'Password berhasil diperbarui!');
    }
}
