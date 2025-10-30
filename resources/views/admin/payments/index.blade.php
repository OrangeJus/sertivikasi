@extends('layouts.app')

@section('page-title', 'Kelola Pembayaran')

@section('content')
<div style="margin-bottom: 30px;">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
        <div>
            <h2 style="font-size: 28px; font-weight: 600; margin-bottom: 10px;">Kelola Pembayaran</h2>
            <p style="color: #666; font-size: 14px;">Manajemen pembayaran penyewaan genset</p>
        </div>
    </div>
</div>

<!-- Success Message -->
@if (session('success'))
    <div class="alert alert-success" style="margin-bottom: 25px;">
        {{ session('success') }}
    </div>
@endif

<!-- Search -->
<div class="card" style="margin-bottom: 30px;">
    <form method="GET" action="{{ route('admin.payments.index') }}">
        <div style="display: flex; align-items: center; gap: 15px; flex-wrap: wrap;">
            <div style="flex: 1; min-width: 300px;">
                <input 
                    type="text" 
                    name="q"
                    placeholder="Cari nama user atau genset..." 
                    value="{{ request('q') }}"
                    style="width: 100%; padding: 12px 15px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px;"
                >
            </div>
            <button type="submit" style="padding: 12px 24px; background: #667eea; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">
                Cari
            </button>
            @if(request('q'))
                <a href="{{ route('admin.payments.index') }}" style="padding: 12px 24px; background: #e0e0e0; color: #333; border-radius: 8px; text-decoration: none; font-weight: 600;">
                    Reset
                </a>
            @endif
        </div>
    </form>
</div>

<!-- Statistics Cards -->
<div class="card-grid" style="margin-bottom: 30px;">
    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-value">{{ $payments->where('payment_status', 'pending')->count() }}</div>
                <div class="card-label">Pending</div>
            </div>
            <div class="card-icon" style="background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);">
                <svg viewBox="0 0 24 24">
                    <path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-value">{{ $payments->where('payment_status', 'paid')->count() }}</div>
                <div class="card-label">Lunas</div>
            </div>
            <div class="card-icon green">
                <svg viewBox="0 0 24 24">
                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-value">{{ $payments->where('payment_status', 'cancelled')->count() }}</div>
                <div class="card-label">Dibatalkan</div>
            </div>
            <div class="card-icon orange">
                <svg viewBox="0 0 24 24">
                    <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-value">Rp {{ number_format($payments->where('payment_status', 'paid')->sum('amount'), 0, ',', '.') }}</div>
                <div class="card-label">Total Pendapatan</div>
            </div>
            <div class="card-icon blue">
                <svg viewBox="0 0 24 24">
                    <path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z"/>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Payments Table -->
<div class="card">
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f8f9fa; text-align: left;">
                    <th style="padding: 15px; font-weight: 600; color: #333; font-size: 14px;">No</th>
                    <th style="padding: 15px; font-weight: 600; color: #333; font-size: 14px;">User</th>
                    <th style="padding: 15px; font-weight: 600; color: #333; font-size: 14px;">Genset</th>
                    <th style="padding: 15px; font-weight: 600; color: #333; font-size: 14px;">Tanggal Bayar</th>
                    <th style="padding: 15px; font-weight: 600; color: #333; font-size: 14px;">Jumlah</th>
                    <th style="padding: 15px; font-weight: 600; color: #333; font-size: 14px;">Metode</th>
                    <th style="padding: 15px; font-weight: 600; color: #333; font-size: 14px;">Status</th>
                    <th style="padding: 15px; font-weight: 600; color: #333; font-size: 14px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $index => $payment)
                <tr style="border-bottom: 1px solid #e0e0e0;">
                    <td style="padding: 15px; color: #666; font-size: 14px;">{{ $payments->firstItem() + $index }}</td>
                    <td style="padding: 15px;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 14px;">
                                {{ substr($payment->rental->user->name, 0, 1) }}
                            </div>
                            <div>
                                <span style="color: #333; font-size: 14px; font-weight: 600; display: block;">{{ $payment->rental->user->name }}</span>
                                <span style="color: #999; font-size: 12px;">{{ $payment->rental->user->email }}</span>
                            </div>
                        </div>
                    </td>
                    <td style="padding: 15px;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="width: 35px; height: 35px; border-radius: 8px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center;">
                                <svg style="width: 20px; height: 20px; fill: white;" viewBox="0 0 24 24">
                                    <path d="M13 2L3 14h8l-2 8 10-12h-8l2-8z"/>
                                </svg>
                            </div>
                            <span style="color: #333; font-size: 14px; font-weight: 600;">{{ $payment->rental->genset->nama_genset }}</span>
                        </div>
                    </td>
                    <td style="padding: 15px; color: #666; font-size: 14px;">
                        @if($payment->payment_date)
                            {{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y H:i') }}
                        @else
                            <span style="color: #999;">-</span>
                        @endif
                    </td>
                    <td style="padding: 15px; color: #333; font-size: 14px; font-weight: 600;">
                        Rp {{ number_format($payment->amount, 0, ',', '.') }}
                    </td>
                    <td style="padding: 15px;">
                        @if($payment->payment_method === 'transfer')
                            <span style="background: #e3f2fd; color: #1976d2; padding: 5px 10px; border-radius: 5px; font-size: 12px; font-weight: 600;">Transfer</span>
                        @else
                            <span style="background: #e8f5e9; color: #388e3c; padding: 5px 10px; border-radius: 5px; font-size: 12px; font-weight: 600;">Cash</span>
                        @endif
                    </td>
                    <td style="padding: 15px;">
                        @if($payment->payment_status === 'pending')
                            <span style="background: #fff3cd; color: #856404; padding: 6px 12px; border-radius: 5px; font-size: 12px; font-weight: 600;">Pending</span>
                        @elseif($payment->payment_status === 'paid')
                            <span style="background: #d4edda; color: #155724; padding: 6px 12px; border-radius: 5px; font-size: 12px; font-weight: 600;">Lunas</span>
                        @else
                            <span style="background: #f8d7da; color: #721c24; padding: 6px 12px; border-radius: 5px; font-size: 12px; font-weight: 600;">Dibatalkan</span>
                        @endif
                    </td>
                    <td style="padding: 15px;">
                        <div style="display: flex; gap: 8px; justify-content: center; flex-wrap: wrap;">
                            <a href="{{ route('admin.payments.show', $payment->id) }}" style="padding: 8px 12px; background: #17a2b8; color: white; border-radius: 5px; text-decoration: none; font-size: 12px; font-weight: 600; display: inline-flex; align-items: center; gap: 5px; white-space: nowrap;">
                                <svg style="width: 16px; height: 16px; fill: white;" viewBox="0 0 24 24">
                                    <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                                </svg>
                                Detail
                            </a>

                            @if($payment->payment_status === 'pending')
                                <form method="POST" action="{{ route('admin.payments.update', $payment->id) }}" style="display: inline-block;">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="payment_status" value="paid">
                                    <button type="submit" onclick="return confirm('Konfirmasi pembayaran ini sebagai LUNAS?')" style="padding: 8px 12px; background: #28a745; color: white; border: none; border-radius: 5px; font-size: 12px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 5px; white-space: nowrap;">
                                        <svg style="width: 16px; height: 16px; fill: white;" viewBox="0 0 24 24">
                                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                                        </svg>
                                        Konfirmasi
                                    </button>
                                </form>

                                <form method="POST" action="{{ route('admin.payments.update', $payment->id) }}" style="display: inline-block;">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="payment_status" value="cancelled">
                                    <button type="submit" onclick="return confirm('Batalkan pembayaran ini?')" style="padding: 8px 12px; background: #dc3545; color: white; border: none; border-radius: 5px; font-size: 12px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 5px; white-space: nowrap;">
                                        <svg style="width: 16px; height: 16px; fill: white;" viewBox="0 0 24 24">
                                            <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                                        </svg>
                                        Batalkan
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="padding: 40px; text-align: center; color: #999;">
                        <svg style="width: 64px; height: 64px; fill: #ddd; margin-bottom: 15px;" viewBox="0 0 24 24">
                            <path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z"/>
                        </svg>
                        <p style="font-size: 16px; margin: 0;">Tidak ada data pembayaran</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($payments->hasPages())
    <div style="padding: 20px; border-top: 1px solid #e0e0e0;">
        {{ $payments->links() }}
    </div>
    @endif
</div>
@endsection