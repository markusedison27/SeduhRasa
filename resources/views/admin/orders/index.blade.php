@extends('layouts.app')

@section('title', 'Manajemen Order')
@section('page-title', 'Manajemen Order')

@section('content')
    <div class="max-w-5xl mx-auto space-y-6">

        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h2 class="text-xl font-semibold text-stone-900">Daftar Order Masuk</h2>
                <p class="text-sm text-stone-500">
                    Pantau semua pesanan pelanggan SeduhRasa dalam bentuk kartu.
                </p>
            </div>

            <div class="flex items-center gap-2 text-sm">
                <span class="text-stone-500">Total order:</span>
                <span class="inline-flex items-center px-3 py-1 rounded-full bg-amber-50 text-amber-700 border border-amber-100 font-semibold">
                    {{ $orders->total() ?? $orders->count() }}
                </span>
            </div>
        </div>

        @if($orders->count())
            {{-- List Kartu Order --}}
            <div class="space-y-4">
                @foreach($orders as $o)
                    @php
                        $status = strtolower($o->status);
                        $statusConfig = [
                            'pending' => [
                                'label' => 'Pending',
                                'bg'    => 'bg-amber-50',
                                'pill'  => 'bg-amber-100 text-amber-800 border border-amber-200',
                                'dot'   => 'bg-amber-500',
                                'desc'  => 'Menunggu diproses kasir.'
                            ],
                            'proses' => [
                                'label' => 'Proses',
                                'bg'    => 'bg-sky-50',
                                'pill'  => 'bg-sky-100 text-sky-800 border border-sky-200',
                                'dot'   => 'bg-sky-500',
                                'desc'  => 'Sedang dikerjakan barista.'
                            ],
                            'selesai' => [
                                'label' => 'Selesai',
                                'bg'    => 'bg-emerald-50',
                                'pill'  => 'bg-emerald-100 text-emerald-800 border border-emerald-200',
                                'dot'   => 'bg-emerald-500',
                                'desc'  => 'Pesanan sudah selesai.'
                            ],
                            'batal' => [
                                'label' => 'Batal',
                                'bg'    => 'bg-rose-50',
                                'pill'  => 'bg-rose-100 text-rose-800 border border-rose-200',
                                'dot'   => 'bg-rose-500',
                                'desc'  => 'Pesanan dibatalkan.'
                            ],
                        ];
                        $cfg = $statusConfig[$status] ?? $statusConfig['pending'];
                    @endphp

                    <div class="rounded-2xl border border-stone-200/70 bg-white shadow-sm overflow-hidden hover:shadow-md transition">
                        <div class="h-1 w-full {{ $status === 'selesai' ? 'bg-emerald-400' : ($status === 'proses' ? 'bg-sky-400' : ($status === 'batal' ? 'bg-rose-400' : 'bg-amber-400')) }}"></div>

                        <div class="p-4 sm:p-5 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">

                            {{-- Kiri: info utama --}}
                            <div class="space-y-2">
                                <div class="flex flex-wrap items-center gap-x-3 gap-y-1 text-sm text-stone-500">
                                    <span class="font-semibold text-stone-800">
                                        #{{ $o->id }}
                                    </span>
                                    <span>•</span>
                                    <span>{{ $o->created_at->format('d M Y • H:i') }} WIB</span>
                                </div>

                                <div>
                                    <p class="text-base font-semibold text-stone-900">
                                        {{ $o->nama_pelanggan ?? 'Umum' }}
                                    </p>
                                    <p class="text-sm text-stone-500">
                                        {{ \Illuminate\Support\Str::limit($o->menu_dipesan, 70) }}
                                    </p>
                                </div>

                                <div class="flex flex-wrap items-center gap-2 text-xs text-stone-500">
                                    @if($o->no_meja)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-amber-50 text-amber-700 border border-amber-100">
                                            Meja {{ $o->no_meja }}
                                        </span>
                                    @endif

                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-stone-50 text-stone-600 border border-stone-100">
                                        {{ $o->metode_pembayaran === 'cod' ? 'Bayar di Tempat (Cash)' : 'Non-tunai / Transfer' }}
                                    </span>

                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-stone-50 text-stone-600 border border-stone-100">
                                        {{ $o->jumlah }} item
                                    </span>
                                </div>
                            </div>

                            {{-- Kanan: status + total + aksi --}}
                            <div class="flex flex-col items-end gap-3 text-right min-w-[11rem]">
                                {{-- Status --}}
                                <div class="space-y-1">
                                    <div class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold {{ $cfg['pill'] }}">
                                        <span class="w-2 h-2 rounded-full {{ $cfg['dot'] }} mr-2"></span>
                                        {{ $cfg['label'] }}
                                    </div>
                                    <p class="text-xs text-stone-500">
                                        {{ $cfg['desc'] }}
                                    </p>
                                </div>

                                {{-- Total --}}
                                <div>
                                    <p class="text-[11px] uppercase tracking-[0.16em] text-stone-400">
                                        Total
                                    </p>
                                    <p class="text-lg font-semibold text-emerald-700">
                                        Rp {{ number_format($o->total_harga, 0, ',', '.') }}
                                    </p>
                                </div>

                                {{-- Aksi --}}
                                <div class="flex flex-wrap justify-end gap-2 text-sm">
                                    <a href="{{ route('admin.orders.show', $o->id) }}"
                                       class="inline-flex items-center px-3 py-1.5 rounded-xl border border-amber-200 text-amber-700 bg-amber-50 hover:bg-amber-100 transition">
                                        Detail &amp; Cetak
                                    </a>

                                    @if($status === 'pending')
                                        <form action="{{ route('admin.orders.updateStatus', $o->id) }}"
                                              method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="proses">
                                            <button type="submit"
                                                    class="inline-flex items-center px-3 py-1.5 rounded-xl bg-sky-500 text-white hover:bg-sky-600 transition">
                                                Jadikan Proses
                                            </button>
                                        </form>
                                    @elseif($status === 'proses')
                                        <form action="{{ route('admin.orders.updateStatus', $o->id) }}"
                                              method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="selesai">
                                            <button type="submit"
                                                    class="inline-flex items-center px-3 py-1.5 rounded-xl bg-emerald-500 text-white hover:bg-emerald-600 transition">
                                                Tandai Selesai
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if ($orders->hasPages())
                <div class="pt-4 border-t border-stone-200">
                    {{ $orders->links() }}
                </div>
            @endif
        @else
            {{-- Empty state --}}
            <div class="mt-10 flex flex-col items-center justify-center text-center gap-3">
                <div class="w-14 h-14 rounded-full bg-amber-50 border border-amber-100 flex items-center justify-center text-2xl">
                    ☕
                </div>
                <p class="text-sm font-medium text-stone-700">Belum ada order yang tercatat.</p>
                <p class="text-xs text-stone-500 max-w-xs">
                    Pesanan baru yang masuk akan tampil di sini secara otomatis.
                </p>
            </div>
        @endif
    </div>
@endsection
