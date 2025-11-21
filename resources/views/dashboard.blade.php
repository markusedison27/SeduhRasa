@extends('layouts.app')

@section('title', 'Dashboard Kedai Kopi • SeduhRasa')
@section('page-title', 'Dashboard Kedai Kopi')

@push('styles')
<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes scaleIn {
        from { transform: scale(0.95); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }
    
    .stat-card { 
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); 
        animation: scaleIn 0.4s ease-out;
    }
    .stat-card:hover { 
        transform: translateY(-4px); 
        box-shadow: 0 20px 40px rgba(123, 63, 0, 0.15); 
    }
    .stat-card:nth-child(2) { animation-delay: 0.1s; }
    .stat-card:nth-child(3) { animation-delay: 0.2s; }

    .animate-fade-in-up { 
        animation: fadeInUp 0.6s ease-out; 
    }
</style>
@endpush

@section('content')
    <div class="space-y-6">
        {{-- Alert Banner --}}
        <div class="animate-fade-in-up bg-gradient-to-r from-amber-50 to-orange-50 border border-amber-200 rounded-2xl p-4 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="flex-shrink-0">
                    <div class="h-10 w-10 rounded-xl bg-amber-500 flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-amber-900">Pesanan yang belum diproses</p>
                    <p class="text-xs text-amber-700">Segera proses <strong>{{ $pendingCount }} order</strong> yang sedang pending</p>
                </div>
                <a href="{{ route('admin.orders.index') }}" 
                   class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-medium rounded-xl transition-colors">
                    Lihat Sekarang
                </a>
            </div>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Total Penjualan Hari Ini --}}
            <div class="stat-card bg-gradient-to-br from-white to-green-50 rounded-2xl p-6 border border-green-100 shadow-lg">
                <div class="flex items-start justify-between mb-4">
                    <div class="p-3 bg-green-500 rounded-xl shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <span class="px-2 py-1 bg-green-100 text-green-700 text-xs font-medium rounded-lg">
                        Hari Ini
                    </span>
                </div>
                <div>
                    <p class="text-sm font-medium text-stone-500 mb-1">Total Penjualan Hari Ini</p>
                    <p class="text-3xl font-bold text-stone-800 mb-2">Rp {{ number_format($totalPenjualanHariIni, 0, ',', '.') }}</p>
                    <p class="text-xs text-stone-500">Berdasarkan order yang tercatat hari ini</p>
                </div>
            </div>

            {{-- Total Pesanan Bulan Ini --}}
            <div class="stat-card bg-gradient-to-br from-white to-blue-50 rounded-2xl p-6 border border-blue-100 shadow-lg">
                <div class="flex items-start justify-between mb-4">
                    <div class="p-3 bg-blue-500 rounded-xl shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                    </div>
                    <span class="px-2 py-1 bg-blue-100 text-blue-700 text-xs font-medium rounded-lg">
                        Bulan Ini
                    </span>
                </div>
                <div>
                    <p class="text-sm font-medium text-stone-500 mb-1">Total Pesanan Bulan Ini</p>
                    <p class="text-3xl font-bold text-stone-800 mb-2">{{ $totalPesananBulanIni }}</p>
                    <p class="text-xs text-stone-500">Jumlah semua order yang masuk bulan ini</p>
                </div>
            </div>

            {{-- Pengeluaran Operasional --}}
            <div class="stat-card bg-gradient-to-br from-white to-red-50 rounded-2xl p-6 border border-red-100 shadow-lg">
                <div class="flex items-start justify-between mb-4">
                    <div class="p-3 bg-red-500 rounded-xl shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"/>
                        </svg>
                    </div>
                    <span class="px-2 py-1 bg-red-100 text-red-700 text-xs font-medium rounded-lg">
                        Operasional
                    </span>
                </div>
                <div>
                    <p class="text-sm font-medium text-stone-500 mb-1">Pengeluaran Operasional</p>
                    <p class="text-3xl font-bold text-red-600 mb-2">Rp {{ number_format($pengeluaranOperasional, 0, ',', '.') }}</p>
                    <p class="text-xs text-stone-500">Termasuk bahan baku & operasional</p>
                </div>
            </div>
        </div>

        {{-- Recent Orders Table --}}
        <div class="animate-fade-in-up bg-white rounded-2xl shadow-lg border border-stone-200 overflow-hidden">
            <div class="px-6 py-5 border-b border-stone-200 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-bold text-stone-800 flex items-center gap-2">
                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        Pesanan Terbaru
                    </h3>
                    <p class="text-sm text-stone-500">Order yang terakhir masuk dari halaman menu</p>
                </div>
                <a href="{{ route('admin.orders.index') }}" 
                   class="px-4 py-2 bg-[#7B3F00] hover:bg-[#8B4513] text-white text-sm font-medium rounded-xl transition-colors flex items-center gap-2">
                    Lihat Semua
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-stone-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-stone-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-stone-500 uppercase tracking-wider">Deskripsi</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-stone-500 uppercase tracking-wider">Meja</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-stone-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-stone-500 uppercase tracking-wider">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100">
                        @forelse($pesananTerbaru as $order)
                            <tr class="hover:bg-stone-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-stone-600">
                                    {{ $order->created_at->format('Y-m-d H:i') }}
                                </td>
                                <td class="px-6 py-4 text-sm text-stone-800 font-medium">
                                    {{ $order->menu_dipesan }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-stone-600">
                                    @if($order->no_meja)
                                        <span class="inline-flex items-center gap-1">
                                            <svg class="w-4 h-4 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21h18M3 10h18M5 6l7-4 7 4M4 10h16v11H4V10z"/>
                                            </svg>
                                            Meja {{ $order->no_meja }}
                                        </span>
                                    @else
                                        <span class="text-stone-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php $status = strtolower($order->status); @endphp
                                    
                                    @if ($status === 'selesai')
                                        <span class="inline-flex items-center px-3 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                            Selesai
                                        </span>
                                    @elseif($status === 'batal')
                                        <span class="inline-flex items-center px-3 py-1 bg-red-100 text-red-800 text-xs font-medium rounded-full">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                            </svg>
                                            Batal
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 bg-amber-100 text-amber-800 text-xs font-medium rounded-full">
                                            <svg class="w-3 h-3 mr-1 animate-spin" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            Pending
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-semibold text-green-600">
                                    Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <svg class="w-16 h-16 text-stone-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                        </svg>
                                        <div>
                                            <p class="text-sm font-medium text-stone-600">Belum ada pesanan</p>
                                            <p class="text-xs text-stone-400">Pesanan akan muncul di sini</p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Auto refresh setiap 15 detik
    setInterval(function () {
        window.location.reload();
    }, 15000);
</script>
@endpush