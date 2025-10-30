@extends('layouts.app')

@section('page-title', 'Riwayat Penyewaan')

@section('content')
<!-- Header -->
<div style="margin-bottom: 30px;">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
        <div>
            <h2 style="font-size: 28px; font-weight: 600; margin-bottom: 10px;">Riwayat Penyewaan</h2>
            <p style="color: #666; font-size: 14px;">Kelola dan pantau semua penyewaan genset Anda</p>
        </div>
        <a href="{{ route('user.dashboard') }}" style="padding: 12px 24px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 10px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 8px; transition: all 0.3s; box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 16px rgba(102, 126, 234, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(102, 126, 234, 0.3)'">
            <svg style="width: 20px; height: 20px; fill: white;" viewBox="0 0 24 24">
                <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
            </svg>
            Sewa Genset Baru
        </a>
    </div>
</div>

<!-- Alert Messages -->
@if (session('success'))
    <div style="background: #d4edda; color: #155724; padding: 16px 20px; border-radius: 10px; margin-bottom: 25px; border-left: 4px solid #28a745; display: flex; align-items: center; gap: 12px;">
        <svg style="width: 24px; height: 24px; fill: currentColor; flex-shrink: 0;" viewBox="0 0 24 24">
            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
        </svg>
        <span style="font-weight: 500;">{{ session('success') }}</span>
    </div>
@endif

@if (session('error'))
    <div style="background: #f8d7da; color: #721c24; padding: 16px 20px; border-radius: 10px; margin-bottom: 25px; border-left: 4px solid #dc3545; display: flex; align-items: center; gap: 12px;">
        <svg style="width: 24px; height: 24px; fill: currentColor; flex-shrink: 0;" viewBox="0 0 24 24">
            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
        </svg>
        <span style="font-weight: 500;">{{ session('error') }}</span>
    </div>
@endif

<!-- Statistics Summary -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px;">
    <!-- Total Rentals -->
    <div style="background: white; border-radius: 12px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); border-left: 4px solid #667eea;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <p style="color: #999; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px; font-weight: 600;">Total Sewa</p>
                <h3 style="font-size: 28px; font-weight: 700; color: #333; margin: 0;">{{ $rentals->total() }}</h3>
            </div>
            <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                <svg style="width: 24px; height: 24px; fill: white;" viewBox="0 0 24 24">
                    <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Pending -->
    <div style="background: white; border-radius: 12px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); border-left: 4px solid #ffc107;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <p style="color: #999; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px; font-weight: 600;">Pending</p>
                <h3 style="font-size: 28px; font-weight: 700; color: #333; margin: 0;">{{ $rentals->where('status', 'pending')->count() }}</h3>
            </div>
            <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                <svg style="width: 24px; height: 24px; fill: white;" viewBox="0 0 24 24">
                    <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Active -->
    <div style="background: white; border-radius: 12px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); border-left: 4px solid #28a745;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <p style="color: #999; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px; font-weight: 600;">Aktif</p>
                <h3 style="font-size: 28px; font-weight: 700; color: #333; margin: 0;">{{ $rentals->where('status', 'active')->count() }}</h3>
            </div>
            <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #28a745 0%, #20c997 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                <svg style="width: 24px; height: 24px; fill: white;" viewBox="0 0 24 24">
                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Completed -->
    <div style="background: white; border-radius: 12px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); border-left: 4px solid #17a2b8;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <p style="color: #999; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px; font-weight: 600;">Selesai</p>
                <h3 style="font-size: 28px; font-weight: 700; color: #333; margin: 0;">{{ $rentals->where('status', 'selesai')->count() }}</h3>
            </div>
            <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #17a2b8 0%, #138496 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                <svg style="width: 24px; height: 24px; fill: white;" viewBox="0 0 24 24">
                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Filter Tabs -->
<div class="card" style="margin-bottom: 30px;">
    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
        <a href="{{ route('user.rentals.index') }}" 
           class="filter-tab {{ !request('status') ? 'active' : '' }}"
           style="padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 14px; transition: all 0.3s; {{ !request('status') ? 'background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);' : 'background: #f8f9fa; color: #666;' }}"
           onmouseover="if(!this.classList.contains('active')) { this.style.background='#e9ecef'; }"
           onmouseout="if(!this.classList.contains('active')) { this.style.background='#f8f9fa'; }">
            Semua
        </a>
        <a href="{{ route('user.rentals.index', ['status' => 'pending']) }}" 
           class="filter-tab {{ request('status') == 'pending' ? 'active' : '' }}"
           style="padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 14px; transition: all 0.3s; {{ request('status') == 'pending' ? 'background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%); color: white; box-shadow: 0 4px 12px rgba(255, 193, 7, 0.3);' : 'background: #f8f9fa; color: #666;' }}"
           onmouseover="if(!this.classList.contains('active')) { this.style.background='#e9ecef'; }"
           onmouseout="if(!this.classList.contains('active')) { this.style.background='#f8f9fa'; }">
            Pending
        </a>
        <a href="{{ route('user.rentals.index', ['status' => 'active']) }}" 
           class="filter-tab {{ request('status') == 'active' ? 'active' : '' }}"
           style="padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 14px; transition: all 0.3s; {{ request('status') == 'active' ? 'background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);' : 'background: #f8f9fa; color: #666;' }}"
           onmouseover="if(!this.classList.contains('active')) { this.style.background='#e9ecef'; }"
           onmouseout="if(!this.classList.contains('active')) { this.style.background='#f8f9fa'; }">
            Aktif
        </a>
        <a href="{{ route('user.rentals.index', ['status' => 'selesai']) }}" 
           class="filter-tab {{ request('status') == 'selesai' ? 'active' : '' }}"
           style="padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 14px; transition: all 0.3s; {{ request('status') == 'selesai' ? 'background: linear-gradient(135deg, #17a2b8 0%, #138496 100%); color: white; box-shadow: 0 4px 12px rgba(23, 162, 184, 0.3);' : 'background: #f8f9fa; color: #666;' }}"
           onmouseover="if(!this.classList.contains('active')) { this.style.background='#e9ecef'; }"
           onmouseout="if(!this.classList.contains('active')) { this.style.background='#f8f9fa'; }">
            Selesai
        </a>
        <a href="{{ route('user.rentals.index', ['status' => 'batal']) }}" 
           class="filter-tab {{ request('status') == 'batal' ? 'active' : '' }}"
           style="padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 14px; transition: all 0.3s; {{ request('status') == 'batal' ? 'background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);' : 'background: #f8f9fa; color: #666;' }}"
           onmouseover="if(!this.classList.contains('active')) { this.style.background='#e9ecef'; }"
           onmouseout="if(!this.classList.contains('active')) { this.style.background='#f8f9fa'; }">
            Dibatalkan
        </a>
    </div>
</div>

<!-- Rentals List -->
@if($rentals->count() > 0)
    <div style="display: grid; gap: 20px;">
        @foreach($rentals as $rental)
        <div class="card" style="transition: all 0.3s; border: 2px solid transparent;" onmouseover="this.style.borderColor='#667eea'; this.style.boxShadow='0 8px 24px rgba(102, 126, 234, 0.15)'" onmouseout="this.style.borderColor='transparent'; this.style.boxShadow='0 2px 8px rgba(0,0,0,0.08)'">
            <div style="display: grid; grid-template-columns: auto 1fr auto; gap: 20px; align-items: start;">
                
                <!-- Genset Icon/Image -->
                <div style="width: 100px; height: 100px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    @if($rental->genset->image)
                        <img src="{{ asset('storage/' . $rental->genset->image) }}" alt="{{ $rental->genset->nama_genset }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 12px;">
                    @else
                        <svg style="width: 48px; height: 48px; fill: white;" viewBox="0 0 24 24">
                            <path d="M13 2L3 14h8l-2 8 10-12h-8l2-8z"/>
                        </svg>
                    @endif
                </div>

                <!-- Rental Details -->
                <div style="flex: 1;">
                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 12px;">
                        <div>
                            <h3 style="font-size: 20px; font-weight: 700; color: #333; margin-bottom: 6px;">{{ $rental->genset->nama_genset }}</h3>
                            <div style="display: flex; align-items: center; gap: 15px; flex-wrap: wrap;">
                                <span style="color: #666; font-size: 14px; display: flex; align-items: center; gap: 6px;">
                                    <svg style="width: 16px; height: 16px; fill: #667eea;" viewBox="0 0 24 24">
                                        <path d="M13 2L3 14h8l-2 8 10-12h-8l2-8z"/>
                                    </svg>
                                    {{ $rental->genset->kapasitas ?? 'N/A' }}
                                </span>
                                <span style="color: #666; font-size: 14px; display: flex; align-items: center; gap: 6px;">
                                    <svg style="width: 16px; height: 16px; fill: #667eea;" viewBox="0 0 24 24">
                                        <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6z"/>
                                    </svg>
                                    ID: #{{ $rental->id }}
                                </span>
                            </div>
                        </div>
                        
                        <!-- Status Badge -->
                        <div>
                            @if($rental->status === 'pending')
                                <span style="background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%); color: #856404; padding: 8px 16px; border-radius: 20px; font-size: 13px; font-weight: 700; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 2px 8px rgba(255, 193, 7, 0.2);">
                                    <svg style="width: 14px; height: 14px; fill: currentColor;" viewBox="0 0 24 24">
                                        <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/>
                                    </svg>
                                    Pending
                                </span>
                            @elseif($rental->status === 'active')
                                <span style="background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%); color: #155724; padding: 8px 16px; border-radius: 20px; font-size: 13px; font-weight: 700; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 2px 8px rgba(40, 167, 69, 0.2);">
                                    <svg style="width: 14px; height: 14px; fill: currentColor;" viewBox="0 0 24 24">
                                        <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                                    </svg>
                                    Aktif
                                </span>
                            @elseif($rental->status === 'selesai')
                                <span style="background: linear-gradient(135deg, #d1ecf1 0%, #bee5eb 100%); color: #0c5460; padding: 8px 16px; border-radius: 20px; font-size: 13px; font-weight: 700; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 2px 8px rgba(23, 162, 184, 0.2);">
                                    <svg style="width: 14px; height: 14px; fill: currentColor;" viewBox="0 0 24 24">
                                        <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                                    </svg>
                                    Selesai
                                </span>
                            @else
                                <span style="background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%); color: #721c24; padding: 8px 16px; border-radius: 20px; font-size: 13px; font-weight: 700; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 2px 8px rgba(220, 53, 69, 0.2);">
                                    <svg style="width: 14px; height: 14px; fill: currentColor;" viewBox="0 0 24 24">
                                        <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                                    </svg>
                                    Dibatalkan
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Rental Info Grid -->
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-top: 16px; padding: 16px; background: #f8f9fa; border-radius: 10px;">
                        <div>
                            <p style="color: #999; font-size: 12px; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px;">Tanggal Mulai</p>
                            <p style="color: #333; font-size: 14px; font-weight: 600; margin: 0; display: flex; align-items: center; gap: 6px;">
                                <svg style="width: 16px; height: 16px; fill: #667eea;" viewBox="0 0 24 24">
                                    <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z"/>
                                </svg>
                                {{ $rental->tanggal_mulai->format('d M Y') }}
                            </p>
                        </div>
                        <div>
                            <p style="color: #999; font-size: 12px; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px;">Tanggal Selesai</p>
                            <p style="color: #333; font-size: 14px; font-weight: 600; margin: 0; display: flex; align-items: center; gap: 6px;">
                                <svg style="width: 16px; height: 16px; fill: #667eea;" viewBox="0 0 24 24">
                                    <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z"/>
                                </svg>
                                {{ $rental->tanggal_selesai->format('d M Y') }}
                            </p>
                        </div>
                        <div>
                            <p style="color: #999; font-size: 12px; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px;">Durasi</p>
                            <p style="color: #333; font-size: 14px; font-weight: 600; margin: 0; display: flex; align-items: center; gap: 6px;">
                                <svg style="width: 16px; height: 16px; fill: #667eea;" viewBox="0 0 24 24">
                                    <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/>
                                </svg>
                                {{ $rental->tanggal_mulai->diffInDays($rental->tanggal_selesai) + 1 }} hari
                            </p>
                        </div>
                        <div>
                            <p style="color: #999; font-size: 12px; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px;">Total Harga</p>
                            <p style="color: #667eea; font-size: 18px; font-weight: 800; margin: 0;">
                                Rp {{ number_format($rental->total_harga, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>

                    @if($rental->catatan)
                    <div style="margin-top: 12px; padding: 12px; background: #fff3cd; border-left: 3px solid #ffc107; border-radius: 6px;">
                        <p style="color: #856404; font-size: 13px; margin: 0; display: flex; align-items: start; gap: 8px;">
                            <svg style="width: 16px; height: 16px; fill: currentColor; flex-shrink: 0; margin-top: 2px;" viewBox="0 0 24 24">
                                <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>
                            </svg>
                            <span><strong>Catatan:</strong> {{ $rental->catatan }}</span>
                        </p>
                    </div>
                    @endif
                </div>

                <!-- Action Button -->
                <div style="display: flex; flex-direction: column; gap: 10px;">
                    <a href="{{ route('user.rentals.show', $rental->id) }}" style="padding: 12px 24px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 10px; text-decoration: none; font-weight: 600; font-size: 14px; text-align: center; transition: all 0.3s; box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3); display: flex; align-items: center; justify-content: center; gap: 8px; white-space: nowrap;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 16px rgba(102, 126, 234, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(102, 126, 234, 0.3)'">
                        <svg style="width: 18px; height: 18px; fill: white;" viewBox="0 0 24 24">
                            <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                        </svg>
                        Detail
                    </a>
                    <p style="color: #999; font-size: 12px; text-align: center; margin: 0;">
                        {{ $rental->created_at->diffForHumans() }}
                    </p>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    @if($rentals->hasPages())
    <div style="margin-top: 30px;">
        <div style="display: flex; justify-content: center;">
            {{ $rentals->links() }}
        </div>
    </div>
    @endif

@else
    <!-- Empty State -->
    <div class="card" style="text-align: center; padding: 60px 20px;">
        <div style="max-width: 400px; margin: 0 auto;">
            <div style="width: 120px; height: 120px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px;">
                <svg style="width: 64px; height: 64px; fill: #dee2e6;" viewBox="0 0 24 24">
                    <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z"/>
                </svg>
            </div>
            <h3 style="font-size: 24px; font-weight: 700; color: #333; margin-bottom: 12px;">
                @if(request('status'))
                    Tidak Ada Penyewaan {{ ucfirst(request('status')) }}
                @else
                    Belum Ada Riwayat Penyewaan
                @endif
            </h3>
            <p style="color: #999; font-size: 15px; margin-bottom: 24px; line-height: 1.6;">
                @if(request('status'))
                    Anda belum memiliki penyewaan dengan status {{ request('status') }}
                @else
                    Mulai sewa genset sekarang untuk memenuhi kebutuhan listrik Anda
                @endif
            </p>
            <a href="{{ route('user.dashboard') }}" style="display: inline-flex; align-items: center; gap: 10px; padding: 14px 32px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 10px; text-decoration: none; font-weight: 700; font-size: 16px; transition: all 0.3s; box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(102, 126, 234, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(102, 126, 234, 0.3)'">
                <svg style="width: 22px; height: 22px; fill: white;" viewBox="0 0 24 24">
                    <path d="M13 2L3 14h8l-2 8 10-12h-8l2-8z"/>
                </svg>
                Jelajahi Genset
            </a>
        </div>
    </div>
@endif

<!-- Info Cards -->
<div style="margin-top: 40px; display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">
    <!-- Info 1 -->
    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 16px; padding: 24px; color: white; box-shadow: 0 8px 24px rgba(102, 126, 234, 0.3);">
        <div style="display: flex; align-items: start; gap: 16px;">
            <div style="width: 48px; height: 48px; background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px); border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <svg style="width: 26px; height: 26px; fill: white;" viewBox="0 0 24 24">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                </svg>
            </div>
            <div>
                <h4 style="font-size: 16px; font-weight: 700; margin-bottom: 8px;">Status Pending</h4>
                <p style="font-size: 13px; opacity: 0.95; line-height: 1.5; margin: 0;">Pesanan Anda sedang menunggu konfirmasi dari admin. Biasanya diproses dalam 1-24 jam.</p>
            </div>
        </div>
    </div>

    <!-- Info 2 -->
    <div style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); border-radius: 16px; padding: 24px; color: white; box-shadow: 0 8px 24px rgba(40, 167, 69, 0.3);">
        <div style="display: flex; align-items: start; gap: 16px;">
            <div style="width: 48px; height: 48px; background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px); border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <svg style="width: 26px; height: 26px; fill: white;" viewBox="0 0 24 24">
                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                </svg>
            </div>
            <div>
                <h4 style="font-size: 16px; font-weight: 700; margin-bottom: 8px;">Sewa Aktif</h4>
                <p style="font-size: 13px; opacity: 0.95; line-height: 1.5; margin: 0;">Pesanan telah disetujui dan genset sedang aktif disewakan kepada Anda.</p>
            </div>
        </div>
    </div>

    <!-- Info 3 -->
    <div style="background: linear-gradient(135deg, #17a2b8 0%, #138496 100%); border-radius: 16px; padding: 24px; color: white; box-shadow: 0 8px 24px rgba(23, 162, 184, 0.3);">
        <div style="display: flex; align-items: start; gap: 16px;">
            <div style="width: 48px; height: 48px; background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px); border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <svg style="width: 26px; height: 26px; fill: white;" viewBox="0 0 24 24">
                    <path d="M20 4H4c-1.11 0-1.99.89-1.99 2L2 18c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V6c0-1.11-.89-2-2-2zm0 14H4v-6h16v6zm0-10H4V6h16v2z"/>
                </svg>
            </div>
            <div>
                <h4 style="font-size: 16px; font-weight: 700; margin-bottom: 8px;">Pembayaran</h4>
                <p style="font-size: 13px; opacity: 0.95; line-height: 1.5; margin: 0;">Lakukan pembayaran sesuai dengan total harga setelah pesanan disetujui admin.</p>
            </div>
        </div>
    </div>
</div>

<style>
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .card > div:first-child {
            grid-template-columns: 1fr !important;
        }
    }

    /* Animation */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .card {
        animation: fadeIn 0.5s ease-out;
    }

    /* Custom scrollbar */
    ::-webkit-scrollbar {
        width: 10px;
        height: 10px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
    }
</style>
@endsection