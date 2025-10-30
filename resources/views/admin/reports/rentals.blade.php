@extends('layouts.app')

@section('page-title', 'Laporan Penyewaan')

@section('content')
<div style="margin-bottom: 30px;">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
        <div>
            <a href="{{ route('admin.reports.index') }}" style="color: #667eea; text-decoration: none; font-size: 14px; display: inline-flex; align-items: center; gap: 5px; margin-bottom: 10px;">
                <svg style="width: 16px; height: 16px; fill: #667eea;" viewBox="0 0 24 24">
                    <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/>
                </svg>
                Kembali ke Laporan
            </a>
            <h2 style="font-size: 28px; font-weight: 600; margin-bottom: 10px;">Detail Laporan Penyewaan</h2>
            <p style="color: #666; font-size: 14px;">Filter dan lihat detail penyewaan genset</p>
        </div>
        <a href="{{ route('admin.reports.export', array_merge(['type' => 'csv'], request()->query())) }}" style="padding: 12px 24px; background: #28a745; color: white; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 8px;">
            <svg style="width: 20px; height: 20px; fill: white;" viewBox="0 0 24 24">
                <path d="M19 12v7H5v-7H3v7c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2v-7h-2zm-6 .67l2.59-2.58L17 11.5l-5 5-5-5 1.41-1.41L11 12.67V3h2z"/>
            </svg>
            Export CSV
        </a>
    </div>
</div>

<!-- Filters -->
<div class="card" style="margin-bottom: 30px;">
    <form method="GET" action="{{ route('admin.reports.rentals') }}" id="filterForm">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
            <!-- Status Filter -->
            <div>
                <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #333; font-size: 13px;">Status</label>
                <select name="status" style="width: 100%; padding: 10px 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px; background: white;">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="batal" {{ request('status') == 'batal' ? 'selected' : '' }}>Batal</option>
                </select>
            </div>

            <!-- Date From -->
            <div>
                <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #333; font-size: 13px;">Dari Tanggal</label>
                <input type="date" name="from" value="{{ request('from') }}" style="width: 100%; padding: 10px 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px;">
            </div>

            <!-- Date To -->
            <div>
                <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #333; font-size: 13px;">Sampai Tanggal</label>
                <input type="date" name="to" value="{{ request('to') }}" style="width: 100%; padding: 10px 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px;">
            </div>

            <!-- Actions -->
            <div style="display: flex; gap: 10px; align-items: flex-end;">
                <button type="submit" style="flex: 1; padding: 10px; background: #667eea; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">
                    Filter
                </button>
                @if(request()->hasAny(['status', 'from', 'to']))
                    <a href="{{ route('admin.reports.rentals') }}" style="flex: 1; padding: 10px; background: #e0e0e0; color: #333; border-radius: 8px; font-weight: 600; text-align: center; text-decoration: none;">
                        Reset
                    </a>
                @endif
            </div>
        </div>
    </form>
</div>

<!-- Results Count -->
<div style="margin-bottom: 20px;">
    <p style="color: #666; font-size: 14px;">
        Menampilkan <strong>{{ $rentals->total() }}</strong> hasil
        @if(request()->hasAny(['status', 'from', 'to']))
            dengan filter aktif
        @endif
    </p>
</div>

<!-- Rentals Table -->
<div class="card" id="rentalsTableContainer">
    @include('admin.reports.partials.rentals_table', ['rentals' => $rentals])
</div>
@endsection