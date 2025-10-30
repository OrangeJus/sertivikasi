@extends('layouts.app')

@section('page-title', 'Kelola Penyewaan')

@section('content')
<div style="margin-bottom: 30px;">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
        <div>
            <h2 style="font-size: 28px; font-weight: 600; margin-bottom: 10px;">Kelola Penyewaan</h2>
            <p style="color: #666; font-size: 14px;">Manajemen data penyewaan genset</p>
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
    <form method="GET" action="{{ route('admin.rentals.index') }}">
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
                <a href="{{ route('admin.rentals.index') }}" style="padding: 12px 24px; background: #e0e0e0; color: #333; border-radius: 8px; text-decoration: none; font-weight: 600;">
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
                <div class="card-value">{{ $rentals->where('status', 'pending')->count() }}</div>
                <div class="card-label">Pending</div>
            </div>
            <div class="card-icon" style="background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);">
                <svg viewBox="0 0 24 24">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-value">{{ $rentals->where('status', 'active')->count() }}</div>
                <div class="card-label">Aktif</div>
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
                <div class="card-value">{{ $rentals->where('status', 'selesai')->count() }}</div>
                <div class="card-label">Selesai</div>
            </div>
            <div class="card-icon" style="background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);">
                <svg viewBox="0 0 24 24">
                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-value">{{ $rentals->where('status', 'batal')->count() }}</div>
                <div class="card-label">Dibatalkan</div>
            </div>
            <div class="card-icon orange">
                <svg viewBox="0 0 24 24">
                    <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Rentals Table -->
<div class="card">
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f8f9fa; text-align: left;">
                    <th style="padding: 15px; font-weight: 600; color: #333; font-size: 14px;">No</th>
                    <th style="padding: 15px; font-weight: 600; color: #333; font-size: 14px;">User</th>
                    <th style="padding: 15px; font-weight: 600; color: #333; font-size: 14px;">Genset</th>
                    <th style="padding: 15px; font-weight: 600; color: #333; font-size: 14px;">Tanggal Mulai</th>
                    <th style="padding: 15px; font-weight: 600; color: #333; font-size: 14px;">Tanggal Selesai</th>
                    <th style="padding: 15px; font-weight: 600; color: #333; font-size: 14px;">Total Harga</th>
                    <th style="padding: 15px; font-weight: 600; color: #333; font-size: 14px;">Status</th>
                    <th style="padding: 15px; font-weight: 600; color: #333; font-size: 14px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rentals as $index => $rental)
                <tr style="border-bottom: 1px solid #e0e0e0;">
                    <td style="padding: 15px; color: #666; font-size: 14px;">{{ $rentals->firstItem() + $index }}</td>
                    <td style="padding: 15px;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 14px;">
                                {{ substr($rental->user->name, 0, 1) }}
                            </div>
                            <div>
                                <span style="color: #333; font-size: 14px; font-weight: 600; display: block;">{{ $rental->user->name }}</span>
                                <span style="color: #999; font-size: 12px;">{{ $rental->user->email }}</span>
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
                            <div>
                                <span style="color: #333; font-size: 14px; font-weight: 600;">{{ $rental->genset->nama_genset }}</span>
                            </div>
                        </div>
                    </td>
                    <td style="padding: 15px; color: #666; font-size: 14px;">
                        {{ \Carbon\Carbon::parse($rental->tanggal_mulai)->format('d M Y') }}
                    </td>
                    <td style="padding: 15px; color: #666; font-size: 14px;">
                        {{ \Carbon\Carbon::parse($rental->tanggal_selesai)->format('d M Y') }}
                    </td>
                    <td style="padding: 15px; color: #333; font-size: 14px; font-weight: 600;">
                        Rp {{ number_format($rental->total_harga, 0, ',', '.') }}
                    </td>
                    <td style="padding: 15px;">
                        @if($rental->status === 'pending')
                            <span style="background: #fff3cd; color: #856404; padding: 6px 12px; border-radius: 5px; font-size: 12px; font-weight: 600;">Pending</span>
                        @elseif($rental->status === 'active')
                            <span style="background: #d4edda; color: #155724; padding: 6px 12px; border-radius: 5px; font-size: 12px; font-weight: 600;">Aktif</span>
                        @elseif($rental->status === 'selesai')
                            <span style="background: #d1ecf1; color: #0c5460; padding: 6px 12px; border-radius: 5px; font-size: 12px; font-weight: 600;">Selesai</span>
                        @else
                            <span style="background: #f8d7da; color: #721c24; padding: 6px 12px; border-radius: 5px; font-size: 12px; font-weight: 600;">Dibatalkan</span>
                        @endif
                    </td>
                    <td style="padding: 15px;">
                        <div style="display: flex; gap: 8px; justify-content: center; flex-wrap: wrap;">
                            <a href="{{ route('admin.rentals.show', $rental->id) }}" style="padding: 8px 12px; background: #17a2b8; color: white; border-radius: 5px; text-decoration: none; font-size: 12px; font-weight: 600; display: inline-flex; align-items: center; gap: 5px; white-space: nowrap;">
                                <svg style="width: 16px; height: 16px; fill: white;" viewBox="0 0 24 24">
                                    <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                                </svg>
                                Detail
                            </a>

                            @if($rental->status === 'pending')
                                <!-- Approve to Active -->
                                <form method="POST" action="{{ route('admin.rentals.update', $rental->id) }}" style="display: inline-block;">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="active">
                                    <button type="submit" onclick="return confirm('Aktifkan penyewaan ini?')" style="padding: 8px 12px; background: #28a745; color: white; border: none; border-radius: 5px; font-size: 12px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 5px; white-space: nowrap;">
                                        <svg style="width: 16px; height: 16px; fill: white;" viewBox="0 0 24 24">
                                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                                        </svg>
                                        Aktifkan
                                    </button>
                                </form>

                                <!-- Cancel -->
                                <form method="POST" action="{{ route('admin.rentals.update', $rental->id) }}" style="display: inline-block;">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="batal">
                                    <button type="submit" onclick="return confirm('Batalkan penyewaan ini?')" style="padding: 8px 12px; background: #dc3545; color: white; border: none; border-radius: 5px; font-size: 12px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 5px; white-space: nowrap;">
                                        <svg style="width: 16px; height: 16px; fill: white;" viewBox="0 0 24 24">
                                            <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                                        </svg>
                                        Batalkan
                                    </button>
                                </form>
                            @endif

                            @if($rental->status === 'active')
                                <!-- Complete -->
                                <form method="POST" action="{{ route('admin.rentals.update', $rental->id) }}" style="display: inline-block;">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="selesai">
                                    <button type="submit" onclick="return confirm('Selesaikan penyewaan ini?')" style="padding: 8px 12px; background: #17a2b8; color: white; border: none; border-radius: 5px; font-size: 12px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 5px; white-space: nowrap;">
                                        <svg style="width: 16px; height: 16px; fill: white;" viewBox="0 0 24 24">
                                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                                        </svg>
                                        Selesai
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
                            <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>
                        </svg>
                        <p style="font-size: 16px; margin: 0;">Tidak ada data penyewaan</p>
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
</div>
@endsection