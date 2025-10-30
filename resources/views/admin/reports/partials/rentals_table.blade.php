<div style="overflow-x: auto;">
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: #f8f9fa; text-align: left;">
                <th style="padding: 15px; font-weight: 600; color: #333; font-size: 14px;">ID</th>
                <th style="padding: 15px; font-weight: 600; color: #333; font-size: 14px;">User</th>
                <th style="padding: 15px; font-weight: 600; color: #333; font-size: 14px;">Genset</th>
                <th style="padding: 15px; font-weight: 600; color: #333; font-size: 14px;">Kategori</th>
                <th style="padding: 15px; font-weight: 600; color: #333; font-size: 14px;">Tanggal</th>
                <th style="padding: 15px; font-weight: 600; color: #333; font-size: 14px;">Total Harga</th>
                <th style="padding: 15px; font-weight: 600; color: #333; font-size: 14px;">Pembayaran</th>
                <th style="padding: 15px; font-weight: 600; color: #333; font-size: 14px;">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rentals as $rental)
            <tr style="border-bottom: 1px solid #e0e0e0;">
                <td style="padding: 15px; color: #666; font-size: 13px; font-family: monospace; font-weight: 600;">
                    #{{ $rental->id }}
                </td>
                <td style="padding: 15px;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <div style="width: 35px; height: 35px; border-radius: 50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 13px;">
                            {{ substr($rental->user->name, 0, 1) }}
                        </div>
                        <div>
                            <span style="color: #333; font-size: 14px; font-weight: 600; display: block;">{{ $rental->user->name }}</span>
                            <span style="color: #999; font-size: 12px;">{{ $rental->user->email }}</span>
                        </div>
                    </div>
                </td>
                <td style="padding: 15px;">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <div style="width: 30px; height: 30px; border-radius: 6px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center;">
                            <svg style="width: 18px; height: 18px; fill: white;" viewBox="0 0 24 24">
                                <path d="M13 2L3 14h8l-2 8 10-12h-8l2-8z"/>
                            </svg>
                        </div>
                        <span style="color: #333; font-size: 14px; font-weight: 600;">{{ $rental->genset->nama_genset }}</span>
                    </div>
                </td>
                <td style="padding: 15px;">
                    <div style="display: flex; flex-wrap: wrap; gap: 4px;">
                        @forelse($rental->genset->categories as $cat)
                            <span style="background: #e3f2fd; color: #1976d2; padding: 3px 8px; border-radius: 4px; font-size: 11px; font-weight: 600;">
                                {{ $cat->nama_kategori }}
                            </span>
                        @empty
                            <span style="color: #999; font-size: 12px;">-</span>
                        @endforelse
                    </div>
                </td>
                <td style="padding: 15px; color: #666; font-size: 13px;">
                    <div>
                        <strong>Mulai:</strong> {{ \Carbon\Carbon::parse($rental->tanggal_mulai)->format('d M Y') }}
                    </div>
                    <div>
                        <strong>Selesai:</strong> {{ \Carbon\Carbon::parse($rental->tanggal_selesai)->format('d M Y') }}
                    </div>
                    <div style="color: #999; font-size: 12px; margin-top: 3px;">
                        ({{ \Carbon\Carbon::parse($rental->tanggal_mulai)->diffInDays(\Carbon\Carbon::parse($rental->tanggal_selesai)) }} hari)
                    </div>
                </td>
                <td style="padding: 15px; color: #333; font-size: 14px; font-weight: 700;">
                    Rp {{ number_format($rental->total_harga, 0, ',', '.') }}
                </td>
                <td style="padding: 15px;">
                    @if($rental->payment)
                        @if($rental->payment->payment_status === 'paid')
                            <span style="background: #d4edda; color: #155724; padding: 5px 10px; border-radius: 5px; font-size: 12px; font-weight: 600;">Lunas</span>
                        @elseif($rental->payment->payment_status === 'pending')
                            <span style="background: #fff3cd; color: #856404; padding: 5px 10px; border-radius: 5px; font-size: 12px; font-weight: 600;">Pending</span>
                        @else
                            <span style="background: #f8d7da; color: #721c24; padding: 5px 10px; border-radius: 5px; font-size: 12px; font-weight: 600;">Batal</span>
                        @endif
                    @else
                        <span style="color: #999; font-size: 12px;">-</span>
                    @endif
                </td>
                <td style="padding: 15px;">
                    @if($rental->status === 'pending')
                        <span style="background: #fff3cd; color: #856404; padding: 6px 12px; border-radius: 5px; font-size: 12px; font-weight: 600;">Pending</span>
                    @elseif($rental->status === 'active')
                        <span style="background: #d4edda; color: #155724; padding: 6px 12px; border-radius: 5px; font-size: 12px; font-weight: 600;">Aktif</span>
                    @elseif($rental->status === 'selesai')
                        <span style="background: #d1ecf1; color: #0c5460; padding: 6px 12px; border-radius: 5px; font-size: 12px; font-weight: 600;">Selesai</span>
                    @else
                        <span style="background: #f8d7da; color: #721c24; padding: 6px 12px; border-radius: 5px; font-size: 12px; font-weight: 600;">Batal</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="padding: 40px; text-align: center; color: #999;">
                    <svg style="width: 64px; height: 64px; fill: #ddd; margin-bottom: 15px;" viewBox="0 0 24 24">
                        <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>
                    </svg>
                    <p style="font-size: 16px; margin: 0;">Tidak ada data rental</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
@if($rentals->hasPages())
<div style="padding: 20px; border-top: 1px solid #e0e0e0;">
    {{ $rentals->links() }}
</div>
@endif