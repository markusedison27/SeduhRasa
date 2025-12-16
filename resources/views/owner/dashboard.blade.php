@extends('layouts.app')

@section('title', 'Dashboard Owner')
@section('page-title', 'Dashboard')

@section('content')

<div class="sr-dashboard-wrapper">

    {{-- HEADER HERO --}}
    <div class="sr-hero">
        <div>
            <span class="sr-pill">Owner Panel</span>
            <h1>Dashboard Pemilik Coffee Shop</h1>
            <p>
                Selamat datang, <strong>{{ $owner->name }}</strong>.  
                Berikut ringkasan singkat performa usaha SeduhRasa hari ini.
            </p>
        </div>
    </div>

    {{-- STAT CARDS --}}
    <div class="sr-stats-grid">

        {{-- Transaksi Hari Ini --}}
        <div class="sr-stat-card">
            <div class="icon bg-green">
                <i class="bi bi-receipt"></i>
            </div>
            <div class="content">
                <span class="label">Transaksi Hari Ini</span>
                <span class="value">{{ $totalTransaksiHariIni }}</span>
                <span class="hint">Order selesai hari ini</span>
            </div>
        </div>

        {{-- Pendapatan --}}
        <div class="sr-stat-card">
            <div class="icon bg-amber">
                <i class="bi bi-cash-stack"></i>
            </div>
            <div class="content">
                <span class="label">Perkiraan Pendapatan</span>
                <span class="value">
                    Rp {{ number_format($perkiraanPendapatan, 0, ',', '.') }}
                </span>
                <span class="hint">Total omzet transaksi selesai</span>
            </div>
        </div>

        {{-- Staff --}}
        <div class="sr-stat-card">
            <div class="icon bg-blue">
                <i class="bi bi-people"></i>
            </div>
            <div class="content">
                <span class="label">Staff Aktif</span>
                <span class="value">{{ $jumlahStaffAktif }}</span>
                <span class="hint">Kasir terdaftar</span>
            </div>
        </div>

    </div>

    {{-- QUICK ACTION --}}
    <div class="sr-action-grid">

        {{-- Keuangan --}}
        <div class="sr-action-card">
            <div>
                <h3>Keuangan Usaha</h3>
                <p>
                    Pantau pemasukan, pengeluaran, dan laba usaha secara real-time.
                </p>
            </div>
            <a href="{{ route('owner.finance') }}" class="btn-primary">
                Buka Halaman Keuangan
            </a>
        </div>

        {{-- Pesanan --}}
        <div class="sr-action-card">
            <div>
                <h3>Daftar Pesanan</h3>
                <p>
                    Lihat semua pesanan pelanggan dari website.
                </p>
            </div>
            <a href="{{ route('admin.orders.index') }}" class="btn-outline">
                Lihat Pesanan
            </a>
        </div>

    </div>

    {{-- QR CODE --}}
    <div class="sr-card">
        <h3 class="sr-card-title">
            <i class="bi bi-qr-code-scan"></i>
            QR Code Pembayaran
        </h3>

        <p class="sr-muted">
            QR Code (QRIS / Dana / dll) yang tampil di halaman konfirmasi pelanggan.
        </p>

        @if($qrCodePath)
            <div class="qr-preview">
                <img src="{{ asset('storage/' . $qrCodePath) }}" alt="QR Code">
                <span>QR Code aktif saat ini</span>
            </div>
        @else
            <div class="qr-empty">
                <i class="bi bi-exclamation-circle"></i>
                Belum ada QR Code diunggah
            </div>
        @endif

        <form action="{{ route('owner.qrcode.upload') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="qrcode_file" required>
            <button type="submit" class="btn-success">
                Upload & Simpan QR Code
            </button>
        </form>
    </div>

    {{-- PROFIL --}}
    <div class="sr-card">
        <h3 class="sr-card-title">
            <i class="bi bi-person-circle"></i>
            Profil Owner
        </h3>

        <div class="sr-profile">
            <div>
                <span>Nama</span>
                <strong>{{ $owner->name }}</strong>
            </div>
            <div>
                <span>Email</span>
                <strong>{{ $owner->email }}</strong>
            </div>
            <div>
                <span>Role</span>
                <strong class="badge">{{ ucfirst($owner->role) }}</strong>
            </div>
        </div>
    </div>

</div>
@endsection

@push('styles')
<style>
/* WRAPPER */
.sr-dashboard-wrapper{
    background:#F7F3EE;
    padding:1rem;
    border-radius:24px;
}

/* HERO */
.sr-hero{
    background:linear-gradient(135deg,#2B1B12,#4B2E1F);
    border-radius:22px;
    padding:1.8rem 2rem;
    color:#FFF;
    margin-bottom:1.5rem;
    box-shadow:0 20px 40px rgba(0,0,0,.35);
}
.sr-hero h1{font-size:1.6rem;font-weight:700;}
.sr-hero p{font-size:.9rem;color:#F9E7D5;}
.sr-pill{
    display:inline-block;
    font-size:.7rem;
    padding:.3rem .8rem;
    border-radius:999px;
    border:1px solid #FCD34D;
    color:#FCD34D;
    margin-bottom:.5rem;
}

/* STATS */
.sr-stats-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:1rem;
    margin-bottom:1.5rem;
}
.sr-stat-card{
    background:#FFF;
    border-radius:18px;
    padding:1rem;
    display:flex;
    gap:1rem;
    box-shadow:0 10px 20px rgba(0,0,0,.06);
}
.sr-stat-card .icon{
    width:42px;height:42px;
    border-radius:14px;
    display:flex;align-items:center;justify-content:center;
    font-size:1.3rem;
}
.bg-green{background:#DCFCE7;color:#15803D;}
.bg-amber{background:#FEF3C7;color:#B45309;}
.bg-blue{background:#DBEAFE;color:#1D4ED8;}

.sr-stat-card .label{font-size:.75rem;color:#6B7280;text-transform:uppercase;}
.sr-stat-card .value{font-size:1.2rem;font-weight:700;}
.sr-stat-card .hint{font-size:.75rem;color:#9CA3AF;}

/* ACTION */
.sr-action-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
    gap:1rem;
    margin-bottom:1.5rem;
}
.sr-action-card{
    background:#FFF;
    border-radius:18px;
    padding:1.2rem;
    display:flex;
    flex-direction:column;
    justify-content:space-between;
    box-shadow:0 8px 18px rgba(0,0,0,.06);
}
.sr-action-card h3{font-weight:600;margin-bottom:.3rem;}
.sr-action-card p{font-size:.85rem;color:#6B7280;}

.btn-primary{
    background:#4F46E5;color:#FFF;
    padding:.6rem;border-radius:10px;
    text-align:center;font-size:.85rem;
}
.btn-outline{
    border:1px solid #D1D5DB;
    padding:.6rem;border-radius:10px;
    text-align:center;font-size:.85rem;
}

/* CARD */
.sr-card{
    background:#FFF;
    border-radius:18px;
    padding:1.3rem;
    margin-bottom:1.5rem;
    box-shadow:0 10px 24px rgba(0,0,0,.08);
}
.sr-card-title{
    font-weight:600;
    display:flex;
    align-items:center;
    gap:.5rem;
    margin-bottom:.6rem;
}
.sr-muted{font-size:.85rem;color:#6B7280;margin-bottom:1rem;}

/* QR */
.qr-preview{text-align:center;}
.qr-preview img{width:160px;border-radius:12px;border:1px solid #E5E7EB;}
.qr-preview span{display:block;font-size:.75rem;color:#6B7280;margin-top:.3rem;}
.qr-empty{background:#FEF3C7;color:#92400E;padding:.6rem;border-radius:10px;font-size:.85rem;margin-bottom:1rem;}

.btn-success{
    background:#16A34A;color:#FFF;
    padding:.6rem 1rem;
    border-radius:10px;
    margin-top:.6rem;
}

/* PROFILE */
.sr-profile div{
    display:flex;
    justify-content:space-between;
    font-size:.85rem;
    padding:.4rem 0;
}
.badge{
    background:#E0E7FF;
    color:#3730A3;
    padding:.2rem .6rem;
    border-radius:999px;
    font-size:.7rem;
}
</style>
@endpush
