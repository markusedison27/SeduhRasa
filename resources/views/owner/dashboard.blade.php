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
                <span class="value">{{ $totalTransaksiHariIni ?? 0 }}</span>
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
                    Rp {{ number_format($perkiraanPendapatan ?? 0, 0, ',', '.') }}
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
                <span class="value">{{ $jumlahStaffAktif ?? 0 }}</span>
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

        {{-- Kelola Kasir --}}
        <div class="sr-action-card">
            <div>
                <h3>Kelola Kasir</h3>
                <p>
                    Tambah & kelola akun kasir untuk operasional harian.
                </p>
            </div>
            <a href="{{ route('owner.kasir.index') }}" class="btn-soft">
                Kelola Kasir
            </a>
        </div>

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

        <div class="sr-profile-actions">
            <a href="{{ route('owner.profile.edit') }}" class="btn-outline w-100">
                Edit Profil
            </a>
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
.sr-hero h1{font-size:1.6rem;font-weight:700;margin:0 0 .35rem;}
.sr-hero p{font-size:.9rem;color:#F9E7D5;margin:0;}
.sr-pill{
    display:inline-block;
    font-size:.7rem;
    padding:.3rem .8rem;
    border-radius:999px;
    border:1px solid rgba(252,211,77,.9);
    color:#FCD34D;
    margin-bottom:.6rem;
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
    padding:1rem 1.1rem;
    display:flex;
    gap:1rem;
    box-shadow:0 10px 20px rgba(0,0,0,.06);
    border:1px solid rgba(148,124,96,.18);
}
.sr-stat-card .icon{
    width:44px;height:44px;
    border-radius:14px;
    display:flex;align-items:center;justify-content:center;
    font-size:1.3rem;
}
.bg-green{background:#DCFCE7;color:#15803D;}
.bg-amber{background:#FEF3C7;color:#B45309;}
.bg-blue{background:#DBEAFE;color:#1D4ED8;}

.sr-stat-card .label{font-size:.72rem;color:#6B7280;text-transform:uppercase;letter-spacing:.08em;}
.sr-stat-card .value{font-size:1.25rem;font-weight:800;color:#111827;display:block;margin-top:.1rem;}
.sr-stat-card .hint{font-size:.78rem;color:#9CA3AF;}

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
    padding:1.2rem 1.25rem;
    display:flex;
    flex-direction:column;
    justify-content:space-between;
    box-shadow:0 8px 18px rgba(0,0,0,.06);
    border:1px solid rgba(148,124,96,.12);
}
.sr-action-card h3{font-weight:700;margin:0 0 .35rem;}
.sr-action-card p{font-size:.88rem;color:#6B7280;margin:0 0 1rem;}

.btn-primary, .btn-outline, .btn-soft{
    display:inline-block;
    padding:.7rem .9rem;
    border-radius:12px;
    text-align:center;
    font-size:.88rem;
    font-weight:700;
    text-decoration:none;
    transition:.2s ease;
}
.btn-primary{
    background:#4F46E5;
    color:#FFF;
}
.btn-primary:hover{opacity:.92;}
.btn-outline{
    border:1px solid #D1D5DB;
    color:#111827;
    background:#fff;
}
.btn-outline:hover{background:#F3F4F6;}
.btn-soft{
    background:#FFF7ED;
    border:1px solid #FED7AA;
    color:#9A3412;
}
.btn-soft:hover{background:#FFEDD5;}

/* CARD */
.sr-card{
    background:#FFF;
    border-radius:18px;
    padding:1.3rem;
    margin-bottom:1.2rem;
    box-shadow:0 10px 24px rgba(0,0,0,.08);
    border:1px solid rgba(148,124,96,.12);
}
.sr-card-title{
    font-weight:800;
    display:flex;
    align-items:center;
    gap:.6rem;
    margin:0 0 .8rem;
}
.sr-profile div{
    display:flex;
    justify-content:space-between;
    font-size:.9rem;
    padding:.45rem 0;
    border-bottom:1px dashed #E5E7EB;
}
.sr-profile div:last-child{border-bottom:none;}
.badge{
    background:#E0E7FF;
    color:#3730A3;
    padding:.25rem .7rem;
    border-radius:999px;
    font-size:.72rem;
}
.sr-profile-actions{margin-top:1rem;}
.w-100{width:100%;}
</style>
@endpush
