@extends('layouts.app')

@section('title', 'Riwayat Order')

@section('content')
<div class="container py-4">

    <h4 class="mb-3 fw-semibold">Riwayat Order Kamu</h4>

    {{-- TOAST CONTAINER --}}
    <div id="toast-container"
         style="position: fixed; top: 18px; right: 18px; z-index: 9999; display:flex; flex-direction:column; gap:10px;">
    </div>

    @php
        $statusBadge = [
            'pending' => 'warning',
            'proses'  => 'primary',
            'selesai' => 'success',
            'batal'   => 'danger',
        ];
        $statusLabel = [
            'pending' => 'Pending',
            'proses'  => 'Diproses',
            'selesai' => 'Selesai',
            'batal'   => 'Dibatalkan',
        ];
    @endphp

    @if ($orders->count())
        <div class="table-responsive">
            <table class="table table-sm align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tanggal</th>
                        <th>Nama</th>
                        <th>Status</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $o)
                        @php
                            $st = $o->status ?? 'pending';
                            $badge = $statusBadge[$st] ?? 'secondary';
                            $label = $statusLabel[$st] ?? ucfirst($st);
                        @endphp
                        <tr class="order-row" data-order-id="{{ $o->id }}" data-status="{{ $st }}">
                            <td style="white-space:nowrap;">#{{ $o->id }}</td>
                            <td style="white-space:nowrap;">{{ optional($o->created_at)->format('d M Y H:i') ?? '-' }}</td>
                            <td>{{ $o->customer_name ?? 'Umum' }}</td>
                            <td style="white-space:nowrap;">
                                <span class="badge bg-{{ $badge }} status-badge">{{ $label }}</span>
                            </td>
                            <td style="white-space:nowrap;">
                                Rp {{ number_format($o->subtotal ?? 0, 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if ($orders->hasPages())
            <div class="mt-3">
                {{ $orders->links() }}
            </div>
        @endif
    @else
        <p class="text-muted">Belum ada order.</p>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const rows = document.querySelectorAll('.order-row');
    if (!rows.length) return;

    const current = {};
    rows.forEach(r => current[r.dataset.orderId] = r.dataset.status || 'pending');

    function badgeClass(status){
        switch(status){
            case 'pending': return 'bg-warning';
            case 'proses':  return 'bg-primary';
            case 'selesai': return 'bg-success';
            case 'batal':   return 'bg-danger';
            default:        return 'bg-secondary';
        }
    }
    function statusLabel(status){
        switch(status){
            case 'pending': return 'Pending';
            case 'proses':  return 'Diproses';
            case 'selesai': return 'Selesai';
            case 'batal':   return 'Dibatalkan';
            default:        return status;
        }
    }

    function showToast(title, message, type='info'){
        const wrap = document.getElementById('toast-container');
        if (!wrap) return;

        let border = '#0d6efd';
        if (type === 'success') border = '#198754';
        if (type === 'danger')  border = '#dc3545';

        const el = document.createElement('div');
        el.style.cssText = `
            min-width: 280px;
            max-width: 360px;
            background: #fff;
            border: 1px solid rgba(0,0,0,.08);
            border-left: 6px solid ${border};
            border-radius: 12px;
            box-shadow: 0 14px 32px rgba(0,0,0,.12);
            padding: 12px 14px;
            font-family: system-ui, -apple-system, Segoe UI, sans-serif;
        `;

        el.innerHTML = `
            <div style="display:flex; justify-content:space-between; gap:10px; align-items:flex-start;">
                <div>
                    <div style="font-weight:700; font-size:14px; margin-bottom:2px;">${title}</div>
                    <div style="font-size:13px; color:#334155;">${message}</div>
                </div>
                <button style="border:none; background:transparent; font-size:16px; line-height:1; cursor:pointer; color:#64748b;">×</button>
            </div>
        `;

        el.querySelector('button').addEventListener('click', () => el.remove());
        wrap.appendChild(el);

        setTimeout(() => {
            el.style.transition = 'all .35s ease';
            el.style.opacity = '0';
            el.style.transform = 'translateY(-6px)';
            setTimeout(() => el.remove(), 350);
        }, 4000);
    }

    function updateRowUI(orderId, newStatus){
        const row = document.querySelector(`.order-row[data-order-id="${orderId}"]`);
        if (!row) return;

        row.dataset.status = newStatus;

        const badge = row.querySelector('.status-badge');
        if (badge){
            badge.className = 'badge ' + badgeClass(newStatus) + ' status-badge';
            badge.textContent = statusLabel(newStatus);
        }
    }

    async function poll(){
        for (const r of rows){
            const id = r.dataset.orderId;
            try{
                const res = await fetch(`{{ url('/orders') }}/${id}/status-json`, { cache:'no-store' });
                const data = await res.json();
                const newStatus = data.status;

                if (!newStatus || newStatus === current[id]) continue;

                current[id] = newStatus;
                updateRowUI(id, newStatus);

                if (newStatus === 'proses'){
                    showToast('Pesanan Diproses ✅', `Order #${id} sudah diproses oleh kasir/barista.`, 'success');
                } else if (newStatus === 'selesai'){
                    showToast('Pesanan Selesai 🎉', `Order #${id} sudah selesai. Silakan ambil ya.`, 'success');
                } else if (newStatus === 'batal'){
                    showToast('Pesanan Dibatalkan ❌', `Order #${id} dibatalkan. Hubungi kasir jika perlu.`, 'danger');
                } else {
                    showToast('Status Berubah', `Order #${id} status menjadi "${newStatus}".`, 'info');
                }

            } catch(e){
                console.error('Polling status gagal:', e);
            }
        }
    }

    setInterval(poll, 5000);
});
</script>
@endsection
