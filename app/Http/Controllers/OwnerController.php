<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;        
use App\Models\Pengeluaran;  
use App\Models\QrCode;  // ✅ TAMBAHAN: Import Model QrCode
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

        // ✅ UBAH: Ambil QR Code Aktif dari tabel qr_codes (bukan settings)
        $activeQrCode = QrCode::where('is_active', true)->first();
        $qrCodePath = $activeQrCode ? $activeQrCode->file_path : null;

        return view('owner.dashboard', compact(
            'owner',
            'totalTransaksiHariIni',
            'perkiraanPendapatan',
            'jumlahStaffAktif',
            'qrCodePath'
        ));
    }

    /**
     * Logic untuk mengunggah dan menyimpan QR Code
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
            // ✅ UBAH: Ambil QR Code aktif dari tabel qr_codes
            $oldQrCode = QrCode::where('is_active', true)->first();

            // ✅ Hapus file lama jika ada
            if ($oldQrCode && Storage::disk('public')->exists($oldQrCode->file_path)) {
                Storage::disk('public')->delete($oldQrCode->file_path);
                // Hapus record lama dari database
                $oldQrCode->delete();
            }

            // ✅ Simpan file baru ke storage/app/public/qrcodes
            $file = $request->file('qrcode_file');
            $filename = 'qrcode_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('qrcodes', $filename, 'public');

            // ✅ UBAH: Simpan ke tabel qr_codes (bukan settings)
            QrCode::create([
                'file_path' => $path,
                'payment_method' => 'dana', // Default, bisa disesuaikan
                'is_active' => true,
                'description' => 'QR Code pembayaran untuk pelanggan',
            ]);

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

        // Total pemasukan dari order selesai
        $totalPemasukan = Order::where('status', 'selesai')
            ->sum('subtotal');

        // Total pengeluaran dari tabel pengeluaran
        $totalPengeluaran = Pengeluaran::sum('nominal');

        // Laba bersih
        $labaBersih = $totalPemasukan - $totalPengeluaran;

        // 10 Pemasukan terbaru
        $daftarPemasukan = Order::where('status', 'selesai')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // 10 Pengeluaran terbaru
        $daftarPengeluaran = Pengeluaran::orderBy('tanggal', 'desc')
            ->take(10)
            ->get();

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