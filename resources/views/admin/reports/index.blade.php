@extends('layouts.app')

@section('page-title', 'Laporan')

@section('content')
<div style="margin-bottom: 30px;">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
        <div>
            <h2 style="font-size: 28px; font-weight: 600; margin-bottom: 10px;">Laporan & Statistik</h2>
            <p style="color: #666; font-size: 14px;">Ringkasan performa bisnis penyewaan genset</p>
        </div>
        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
            <a href="{{ route('admin.reports.rentals') }}" style="padding: 10px 20px; background: #17a2b8; color: white; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 14px; display: inline-flex; align-items: center; gap: 8px;">
                <svg style="width: 18px; height: 18px; fill: white;" viewBox="0 0 24 24">
                    <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>
                </svg>
                Detail Rentals
            </a>
            <a href="{{ route('admin.reports.export', ['type' => 'csv']) }}" style="padding: 10px 20px; background: #28a745; color: white; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 14px; display: inline-flex; align-items: center; gap: 8px;">
                <svg style="width: 18px; height: 18px; fill: white;" viewBox="0 0 24 24">
                    <path d="M19 12v7H5v-7H3v7c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2v-7h-2zm-6 .67l2.59-2.58L17 11.5l-5 5-5-5 1.41-1.41L11 12.67V3h2z"/>
                </svg>
                Export CSV
            </a>
        </div>
    </div>
</div>

<!-- Period Filter -->
<div class="card" style="margin-bottom: 30px;">
    <form method="GET" action="{{ route('admin.reports.index') }}" id="periodFilter">
        <div style="display: grid; grid-template-columns: auto 1fr auto; gap: 15px; align-items: end;">
            <!-- Period Type -->
            <div>
                <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #333; font-size: 13px;">Periode</label>
                <select name="period" id="periodSelect" onchange="toggleCustomPeriod()" style="width: 180px; padding: 10px 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px; background: white; cursor: pointer;">
                    <option value="12months" {{ $period == '12months' ? 'selected' : '' }}>12 Bulan Terakhir</option>
                    <option value="custom" {{ $period == 'custom' ? 'selected' : '' }}>Pilih Bulan & Tahun</option>
                </select>
            </div>

            <!-- Custom Period (Year & Month) -->
            <div id="customPeriod" style="display: {{ $period == 'custom' ? 'grid' : 'none' }}; grid-template-columns: 1fr 1fr; gap: 15px;">
                <div>
                    <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #333; font-size: 13px;">Tahun</label>
                    <select name="year" style="width: 100%; padding: 10px 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px; background: white; cursor: pointer;">
                        @for($y = now()->year; $y >= now()->year - 5; $y--)
                            <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>
                <div>
                    <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #333; font-size: 13px;">Bulan</label>
                    <select name="month" style="width: 100%; padding: 10px 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px; background: white; cursor: pointer;">
                        @foreach(['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] as $index => $monthName)
                            <option value="{{ $index + 1 }}" {{ $month == ($index + 1) ? 'selected' : '' }}>{{ $monthName }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit" style="padding: 10px 24px; background: #667eea; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; white-space: nowrap;">
                    Tampilkan
                </button>
            </div>
        </div>
    </form>
</div>

<!-- KPI Cards -->
<div class="card-grid" style="margin-bottom: 30px;">
    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-value">{{ $totalRentals }}</div>
                <div class="card-label">Total Penyewaan</div>
            </div>
            <div class="card-icon blue">
                <svg viewBox="0 0 24 24">
                    <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-value">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                <div class="card-label">Total Pendapatan</div>
            </div>
            <div class="card-icon green">
                <svg viewBox="0 0 24 24">
                    <path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-value">{{ $activeRentals }}</div>
                <div class="card-label">Rental Aktif</div>
            </div>
            <div class="card-icon" style="background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);">
                <svg viewBox="0 0 24 24">
                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-value">Rp {{ number_format($monthlyRevenue, 0, ',', '.') }}</div>
                <div class="card-label">Pendapatan Bulan Ini</div>
            </div>
            <div class="card-icon orange">
                <svg viewBox="0 0 24 24">
                    <path d="M7 11h2v2H7zm0 4h2v2H7zm4-4h2v2h-2zm0 4h2v2h-2zm4-4h2v2h-2zm0 4h2v2h-2z"/>
                    <path d="M5 22h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2h-1V2h-2v2H8V2H6v2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2zM19 8v12H5V8h14z"/>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Charts Section -->
<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 25px; margin-bottom: 30px;">
    <!-- Revenue Chart -->
    <div class="card">
        <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 2px solid #f0f0f0;">{{ $chartTitle }}</h3>
        <div style="height: 300px; display: flex; align-items: flex-end; justify-content: space-around; gap: {{ $period == '12months' ? '5px' : '2px' }};">
            @php
                $maxRevenue = $chartData->max() ?: 1;
            @endphp
            @foreach($chartData as $key => $revenue)
                @php
                    $height = $maxRevenue > 0 ? ($revenue / $maxRevenue) * 100 : 0;
                    if ($period == '12months') {
                        $label = \Carbon\Carbon::parse($key.'-01')->format('M');
                    } else {
                        $label = \Carbon\Carbon::parse($key)->format('d');
                    }
                @endphp
                <div style="flex: 1; display: flex; flex-direction: column; align-items: center; gap: 8px;">
                    <div style="width: 100%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 4px 4px 0 0; transition: all 0.3s; position: relative; height: {{ $height }}%;" title="Rp {{ number_format($revenue, 0, ',', '.') }}">
                        @if($revenue > 0 && ($period == '12months' || $revenue > ($maxRevenue * 0.1)))
                            <span style="position: absolute; top: -25px; left: 50%; transform: translateX(-50%); font-size: 10px; font-weight: 600; color: #333; white-space: nowrap;">{{ number_format($revenue / 1000000, 1) }}M</span>
                        @endif
                    </div>
                    <span style="font-size: {{ $period == '12months' ? '11px' : '9px' }}; color: #999; font-weight: 600;">{{ $label }}</span>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Top Gensets -->
    <div class="card">
        <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 2px solid #f0f0f0;">Top 5 Genset</h3>
        <div style="display: flex; flex-direction: column; gap: 15px;">
            @forelse($topGensets as $index => $item)
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="width: 35px; height: 35px; border-radius: 8px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; font-weight: 700; color: white; font-size: 16px;">
                        {{ $index + 1 }}
                    </div>
                    <div style="flex: 1;">
                        <p style="font-weight: 600; color: #333; font-size: 14px; margin: 0;">{{ $item->genset->nama_genset }}</p>
                        <p style="color: #999; font-size: 12px; margin: 3px 0 0 0;">{{ $item->total_rentals }} rental</p>
                    </div>
                </div>
            @empty
                <p style="color: #999; text-align: center; font-size: 14px;">Belum ada data</p>
            @endforelse
        </div>
    </div>
</div>

<!-- Category Stats -->
<div class="card">
    <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 2px solid #f0f0f0;">Statistik per Kategori</h3>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
        @forelse($perCategory as $cat)
            <div style="background: #f8f9fa; padding: 20px; border-radius: 10px; text-align: center;">
                <div style="width: 50px; height: 50px; border-radius: 50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;">
                    <svg style="width: 28px; height: 28px; fill: white;" viewBox="0 0 24 24">
                        <path d="M12 2l-5.5 9h11L12 2zm0 3.84L13.93 9h-3.87L12 5.84zM17.5 13c-2.49 0-4.5 2.01-4.5 4.5s2.01 4.5 4.5 4.5 4.5-2.01 4.5-4.5-2.01-4.5-4.5-4.5zm0 7c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5zM3 21.5h8v-8H3v8zm2-6h4v4H5v-4z"/>
                    </svg>
                </div>
                <h4 style="font-size: 16px; font-weight: 600; margin-bottom: 5px; color: #333;">{{ $cat->nama_kategori }}</h4>
                <p style="color: #999; font-size: 13px; margin-bottom: 10px;">{{ $cat->gensets->count() }} Genset</p>
                <p style="color: #667eea; font-size: 24px; font-weight: 700; margin: 0;">{{ $cat->rentals_count }}</p>
                <p style="color: #999; font-size: 12px; margin-top: 3px;">Total Rental</p>
            </div>
        @empty
            <p style="color: #999; text-align: center; font-size: 14px; grid-column: 1 / -1;">Belum ada kategori</p>
        @endforelse
    </div>
</div>

<script>
function toggleCustomPeriod() {
    const select = document.getElementById('periodSelect');
    const customDiv = document.getElementById('customPeriod');
    if (select.value === 'custom') {
        customDiv.style.display = 'grid';
    } else {
        customDiv.style.display = 'none';
    }
}
</script>
@endsection