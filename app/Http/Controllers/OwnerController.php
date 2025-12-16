<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Pengeluaran;
use App\Models\User;
use App\Http\Requests\ProfileUpdateRequest;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class OwnerController extends Controller
{
    /**
     * Dashboard owner (TANPA QR)
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

        // QR DIHAPUS → kirim null biar blade aman (kalau masih ada variabelnya)
        $qrCodePath = null;

        return view('owner.dashboard', compact(
            'owner',
            'totalTransaksiHariIni',
            'perkiraanPendapatan',
            'jumlahStaffAktif',
            'qrCodePath'
        ));
    }

    /**
     * Halaman Keuangan Owner (fix stats + chart)
     */
    public function finance()
    {
        $owner = auth()->user();

        // =========================
        // STATS (sesuai finance.blade.php kamu)
        // =========================
        $stats = [
            'income_today'  => Order::where('status', 'selesai')
                ->whereDate('created_at', today())
                ->sum('subtotal'),

            'income_month'  => Order::where('status', 'selesai')
                ->whereYear('created_at', now()->year)
                ->whereMonth('created_at', now()->month)
                ->sum('subtotal'),

            'income_year'   => Order::where('status', 'selesai')
                ->whereYear('created_at', now()->year)
                ->sum('subtotal'),

            'income_total'  => Order::where('status', 'selesai')
                ->sum('subtotal'),

            'expense_today' => Pengeluaran::whereDate('tanggal', today())
                ->sum('nominal'),

            'expense_month' => Pengeluaran::whereYear('tanggal', now()->year)
                ->whereMonth('tanggal', now()->month)
                ->sum('nominal'),

            'expense_year'  => Pengeluaran::whereYear('tanggal', now()->year)
                ->sum('nominal'),

            'expense_total' => Pengeluaran::sum('nominal'),
        ];

        $totalPemasukan   = $stats['income_total'];
        $totalPengeluaran = $stats['expense_total'];
        $labaBersih       = $totalPemasukan - $totalPengeluaran;

        // 10 pemasukan terbaru
        $daftarPemasukan = Order::where('status', 'selesai')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // 10 pengeluaran terbaru
        $daftarPengeluaran = Pengeluaran::orderBy('tanggal', 'desc')
            ->take(10)
            ->get();

        // =========================
        // DATA CHART (12 bulan tahun ini)
        // =========================
        $year = now()->year;

        $monthLabels   = [];
        $incomeByMonth = [];
        $expenseByMonth = [];

        for ($m = 1; $m <= 12; $m++) {
            $monthLabels[] = Carbon::create($year, $m, 1)->translatedFormat('M');

            $incomeByMonth[] = (float) Order::where('status', 'selesai')
                ->whereYear('created_at', $year)
                ->whereMonth('created_at', $m)
                ->sum('subtotal');

            $expenseByMonth[] = (float) Pengeluaran::whereYear('tanggal', $year)
                ->whereMonth('tanggal', $m)
                ->sum('nominal');
        }

        return view('owner.finance', compact(
            'owner',
            'stats',
            'monthLabels',
            'incomeByMonth',
            'expenseByMonth',
            'totalPemasukan',
            'totalPengeluaran',
            'labaBersih',
            'daftarPemasukan',
            'daftarPengeluaran'
        ));
    }

    public function editProfile()
    {
        $owner = auth()->user();
        return view('owner.edit-profile', compact('owner'));
    }

    public function updateProfile(ProfileUpdateRequest $request)
    {
        $owner = $request->user();

        $owner->fill($request->validated());

        if ($request->hasFile('avatar')) {
            if ($owner->avatar && !str_contains($owner->avatar, 'googleusercontent.com')) {
                Storage::disk('public')->delete($owner->avatar);
            }

            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $owner->avatar = $avatarPath;
        }

        if ($request->filled('password')) {
            $owner->password = Hash::make($request->password);
        }

        $owner->save();

        return redirect()->route('owner.profile.edit')
            ->with('success', 'Profil berhasil diperbarui!');
    }

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
