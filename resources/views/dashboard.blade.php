@extends('layouts.app')

@section('title','Dashboard')
@section('page-title','Dashboard Kedai Kopi')

@section('content')
<div class="space-y-8">

  {{-- ===== KPI Cards ===== --}}
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
    {{-- Total Penjualan Hari Ini --}}
    <div class="bg-white rounded-2xl border border-stone-200 shadow-sm p-5">
      <div class="flex items-start justify-between">
        <div>
          <p class="text-sm text-stone-500">Total Penjualan Hari Ini</p>
          <p class="mt-2 text-3xl font-bold tracking-tight">
            Rp {{ number_format(($salesToday ?? 185000), 0, ',', '.') }}
          </p>
        </div>
        <div class="h-10 w-10 rounded-xl bg-amber-100 text-amber-700 grid place-items-center">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
        </div>
      </div>
      <p class="mt-3 text-xs text-stone-500">+12% dibanding kemarin</p>
    </div>

    {{-- Total Pesanan Bulan Ini --}}
    <div class="bg-white rounded-2xl border border-stone-200 shadow-sm p-5">
      <div class="flex items-start justify-between">
        <div>
          <p class="text-sm text-stone-500">Total Pesanan Bulan Ini</p>
          <p class="mt-2 text-3xl font-bold tracking-tight">
            {{ $ordersThisMonth ?? 342 }}
          </p>
        </div>
        <div class="h-10 w-10 rounded-xl bg-green-100 text-green-700 grid place-items-center">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
        </div>
      </div>
      <p class="mt-3 text-xs text-stone-500">+5% dibanding bulan lalu</p>
    </div>

    {{-- Pengeluaran Operasional --}}
    <div class="bg-white rounded-2xl border border-stone-200 shadow-sm p-5">
      <div class="flex items-start justify-between">
        <div>
          <p class="text-sm text-stone-500">Pengeluaran Operasional</p>
          <p class="mt-2 text-3xl font-bold tracking-tight text-red-600">
            Rp {{ number_format(($expenses ?? 1250000), 0, ',', '.') }}
          </p>
        </div>
        <div class="h-10 w-10 rounded-xl bg-red-100 text-red-700 grid place-items-center">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 8v8m0 0l-3-3m3 3l3-3M4 4h16v16H4z"/></svg>
        </div>
      </div>
      <p class="mt-3 text-xs text-stone-500">Termasuk bahan baku dan listrik</p>
    </div>
  </div>

  {{-- ===== Transaksi Terbaru ===== --}}
  <section class="bg-white rounded-2xl border border-stone-200 shadow-sm">
    <div class="px-6 py-4 border-b border-stone-100 flex justify-between items-center">
      <div>
        <h3 class="text-base font-semibold">Transaksi Terbaru</h3>
        <p class="text-sm text-stone-500">Penjualan & pengeluaran terakhir</p>
      </div>
      <a href="{{ route('admin.transaksi.index') }}" class="text-sm text-amber-700 hover:underline">Lihat Semua</a>
    </div>

    <div class="p-4">
      <div class="overflow-hidden rounded-xl ring-1 ring-stone-200">
        <table class="min-w-full divide-y divide-stone-200">
          <thead class="bg-stone-50">
            <tr>
              <th class="px-4 py-3 text-left text-xs font-semibold text-stone-500 uppercase tracking-wider">Tanggal</th>
              <th class="px-4 py-3 text-left text-xs font-semibold text-stone-500 uppercase tracking-wider">Deskripsi</th>
              <th class="px-4 py-3 text-left text-xs font-semibold text-stone-500 uppercase tracking-wider">Tipe</th>
              <th class="px-4 py-3 text-right text-xs font-semibold text-stone-500 uppercase tracking-wider">Jumlah</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-stone-200 bg-white">
            @foreach(($transactions ?? [
              ['date'=>'2025-11-11','desc'=>'Kopi Latte (2x)','type'=>'Penjualan','amount'=>45000],
              ['date'=>'2025-11-11','desc'=>'Beli Susu Cair','type'=>'Pengeluaran','amount'=>30000],
              ['date'=>'2025-11-10','desc'=>'Cappuccino (1x)','type'=>'Penjualan','amount'=>25000],
            ]) as $t)
              <tr class="hover:bg-stone-50/70 transition">
                <td class="px-4 py-3 text-sm text-stone-600">{{ $t['date'] }}</td>
                <td class="px-4 py-3 text-sm text-stone-800">{{ $t['desc'] }}</td>
                <td class="px-4 py-3">
                  @if($t['type'] === 'Penjualan')
                    <span class="inline-flex items-center gap-1 rounded-lg bg-green-50 text-green-700 px-2 py-1 text-xs ring-1 ring-green-200">
                      {{ $t['type'] }}
                    </span>
                  @else
                    <span class="inline-flex items-center gap-1 rounded-lg bg-red-50 text-red-700 px-2 py-1 text-xs ring-1 ring-red-200">
                      {{ $t['type'] }}
                    </span>
                  @endif
                </td>
                <td class="px-4 py-3 text-sm text-right font-semibold {{ $t['type'] === 'Penjualan' ? 'text-green-700' : 'text-red-700' }}">
                  Rp {{ number_format($t['amount'], 0, ',', '.') }}
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </section>

</div>
@endsection
