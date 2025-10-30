@extends('layouts.app')

@section('page-title', 'Dashboard User')

@section('content')
    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 16px; padding: 40px 30px; margin-bottom: 30px; color: white; box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);">
        <div style="max-width: 800px;">
            <h1 style="font-size: 32px; font-weight: 700; margin-bottom: 12px;">Selamat Datang, {{ Auth::user()->name }}! 👋</h1>
            <p style="font-size: 16px; opacity: 0.95; margin-bottom: 0;">Temukan genset berkualitas untuk kebutuhan listrik Anda dengan mudah dan cepat</p>
        </div>
    </div>

    @php
        $activeRentalsCount = Auth::user()->rentals()->whereIn('status', ['pending', 'active'])->count();
    @endphp
    @if($activeRentalsCount >= 2)
        <div style="background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%); border-radius: 16px; padding: 24px 30px; margin-bottom: 30px; border-left: 6px solid #dc3545; box-shadow: 0 4px 12px rgba(220, 53, 69, 0.2);">
            <div style="display: flex; align-items: center; gap: 16px;">
                <div style="width: 56px; height: 56px; background: rgba(255, 255, 255, 0.4); backdrop-filter: blur(10px); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <svg style="width: 32px; height: 32px; fill: #721c24;" viewBox="0 0 24 24">
                        <path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"/>
                    </svg>
                </div>
                <div style="flex: 1;">
                    <h3 style="font-size: 18px; font-weight: 700; color: #721c24; margin-bottom: 6px;">Batas Maksimal Penyewaan Tercapai</h3>
                    <p style="color: #721c24; font-size: 14px; margin: 0; opacity: 0.9;">Anda sudah memiliki {{ $activeRentalsCount }} penyewaan aktif. Silakan selesaikan penyewaan yang ada terlebih dahulu sebelum menyewa genset baru.</p>
                </div>
            </div>
        </div>
    @elseif($activeRentalsCount == 1)
        <div style="background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%); border-radius: 16px; padding: 20px 24px; margin-bottom: 30px; border-left: 6px solid #ffc107; box-shadow: 0 4px 12px rgba(255, 193, 7, 0.2);">
            <div style="display: flex; align-items: center; gap: 14px;">
                <div style="width: 48px; height: 48px; background: rgba(255, 255, 255, 0.4); backdrop-filter: blur(10px); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <svg style="width: 26px; height: 26px; fill: #856404;" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                    </svg>
                </div>
                <div style="flex: 1;">
                    <h3 style="font-size: 16px; font-weight: 700; color: #856404; margin-bottom: 4px;">Anda Sudah Memiliki 1 Penyewaan Aktif</h3>
                    <p style="color: #856404; font-size: 13px; margin: 0; opacity: 0.9;">Anda masih bisa menyewa 1 genset lagi. Batas maksimal adalah 2 penyewaan aktif.</p>
                </div>
            </div>
        </div>
    @endif

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; margin-bottom: 30px;">
        <div style="background: white; border-radius: 12px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); border-left: 4px solid #667eea;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <div>
                    <p style="color: #999; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px; font-weight: 600;">Total Genset</p>
                    <h3 style="font-size: 32px; font-weight: 700; color: #333; margin: 0;">{{ $stats['total_gensets'] }}</h3>
                </div>
                <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                    <svg style="width: 26px; height: 26px; fill: white;" viewBox="0 0 24 24">
                        <path d="M13 2L3 14h8l-2 8 10-12h-8l2-8z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div style="background: white; border-radius: 12px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); border-left: 4px solid #28a745;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <div>
                    <p style="color: #999; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px; font-weight: 600;">Tersedia</p>
                    <h3 style="font-size: 32px; font-weight: 700; color: #333; margin: 0;">{{ $stats['available_gensets'] }}</h3>
                </div>
                <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #28a745 0%, #20c997 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                    <svg style="width: 26px; height: 26px; fill: white;" viewBox="0 0 24 24">
                        <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div style="background: white; border-radius: 12px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); border-left: 4px solid #ffc107;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <div>
                    <p style="color: #999; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px; font-weight: 600;">Sewa Aktif</p>
                    <h3 style="font-size: 32px; font-weight: 700; color: #333; margin: 0;">{{ $stats['my_active_rentals'] }}</h3>
                </div>
                <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                    <svg style="width: 26px; height: 26px; fill: white;" viewBox="0 0 24 24">
                        <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div style="background: white; border-radius: 12px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); border-left: 4px solid #17a2b8;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <div>
                    <p style="color: #999; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px; font-weight: 600;">Total Sewa</p>
                    <h3 style="font-size: 32px; font-weight: 700; color: #333; margin: 0;">{{ $stats['my_total_rentals'] }}</h3>
                </div>
                <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #17a2b8 0%, #138496 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                    <svg style="width: 26px; height: 26px; fill: white;" viewBox="0 0 24 24">
                        <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="card" style="margin-bottom: 30px;">
        <form method="GET" action="{{ route('user.dashboard') }}">
            <div style="display: flex; align-items: center; gap: 15px; flex-wrap: wrap;">
                <div style="flex: 1; min-width: 250px;">
                    <div style="position: relative;">
                        <svg style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); width: 18px; height: 18px; fill: #999;" viewBox="0 0 24 24">
                            <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                        </svg>
                        <input 
                            type="text" 
                            name="search"
                            placeholder="Cari genset berdasarkan nama, kapasitas..." 
                            value="{{ request('search') }}"
                            style="width: 100%; padding: 12px 15px 12px 45px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 14px; transition: all 0.3s;"
                            onfocus="this.style.borderColor='#667eea'"
                            onblur="this.style.borderColor='#e0e0e0'"
                        >
                    </div>
                </div>
                <div style="min-width: 180px;">
                    <select name="kapasitas" style="width: 100%; padding: 12px 15px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 14px; background: white; cursor: pointer; transition: all 0.3s;" onfocus="this.style.borderColor='#667eea'" onblur="this.style.borderColor='#e0e0e0'">
                        <option value="">Semua Kapasitas</option>
                        @foreach($capacities as $cap)
                            <option value="{{ $cap }}" {{ request('kapasitas') == $cap ? 'selected' : '' }}>
                                {{ $cap }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div style="min-width: 160px;">
                    <select name="status" style="width: 100%; padding: 12px 15px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 14px; background: white; cursor: pointer; transition: all 0.3s;" onfocus="this.style.borderColor='#667eea'" onblur="this.style.borderColor='#e0e0e0'">
                        <option value="">Semua Status</option>
                        <option value="tersedia" {{ request('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                        <option value="disewa" {{ request('status') == 'disewa' ? 'selected' : '' }}>Disewa</option>
                    </select>
                </div>
                <button type="submit" style="padding: 12px 28px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 10px; font-weight: 600; cursor: pointer; transition: all 0.3s; box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 16px rgba(102, 126, 234, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(102, 126, 234, 0.3)'">
                    <span style="display: flex; align-items: center; gap: 8px;">
                        <svg style="width: 18px; height: 18px; fill: white;" viewBox="0 0 24 24">
                            <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                        </svg>
                        Cari
                    </span>
                </button>
                @if(request()->hasAny(['search', 'kapasitas', 'status']))
                    <a href="{{ route('user.dashboard') }}" style="padding: 12px 24px; background: #f8f9fa; color: #666; border-radius: 10px; text-decoration: none; font-weight: 600; transition: all 0.3s;" onmouseover="this.style.background='#e9ecef'" onmouseout="this.style.background='#f8f9fa'">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <div style="margin-bottom: 30px;">
        <h3 style="font-size: 22px; font-weight: 700; margin-bottom: 20px; color: #333; display: flex; align-items: center; gap: 10px;">
            <svg style="width: 28px; height: 28px; fill: #667eea;" viewBox="0 0 24 24">
                <path d="M13 2L3 14h8l-2 8 10-12h-8l2-8z"/>
            </svg>
            Daftar Genset Tersedia
        </h3>

        @if($gensets->count() > 0)
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 24px;">
                @foreach($gensets as $genset)
                <div style="background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.08); transition: all 0.3s; border: 2px solid transparent;" onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 12px 24px rgba(102, 126, 234, 0.15)'; this.style.borderColor='#667eea'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.08)'; this.style.borderColor='transparent'">
                    
                    <div style="height: 200px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden;">
                        @if($genset->image)
                            <img src="{{ asset('storage/' . $genset->image) }}" alt="{{ $genset->nama_genset }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <svg style="width: 80px; height: 80px; fill: white; opacity: 0.9;" viewBox="0 0 24 24">
                                <path d="M13 2L3 14h8l-2 8 10-12h-8l2-8z"/>
                            </svg>
                        @endif
                        
                        <div style="position: absolute; top: 15px; right: 15px;">
                            @if($genset->status === 'tersedia')
                                <span style="background: rgba(40, 167, 69, 0.95); backdrop-filter: blur(10px); color: white; padding: 6px 14px; border-radius: 20px; font-size: 12px; font-weight: 700; box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);">
                                    ✓ Tersedia
                                </span>
                            @elseif($genset->status === 'disewa')
                                <span style="background: rgba(220, 53, 69, 0.95); backdrop-filter: blur(10px); color: white; padding: 6px 14px; border-radius: 20px; font-size: 12px; font-weight: 700; box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);">
                                    ⊗ Disewa
                                </span>
                            @else
                                <span style="background: rgba(255, 193, 7, 0.95); backdrop-filter: blur(10px); color: white; padding: 6px 14px; border-radius: 20px; font-size: 12px; font-weight: 700; box-shadow: 0 4px 12px rgba(255, 193, 7, 0.3);">
                                    ⚠ Rusak
                                </span>
                            @endif
                        </div>
                    </div>

                    <div style="padding: 24px;">
                        <h3 style="font-size: 20px; font-weight: 700; margin-bottom: 16px; color: #333;">{{ $genset->nama_genset }}</h3>
                        
                        <div style="margin-bottom: 20px;">
                            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px; padding: 10px; background: #f8f9fa; border-radius: 8px;">
                                <svg style="width: 20px; height: 20px; fill: #667eea; flex-shrink: 0;" viewBox="0 0 24 24">
                                    <path d="M13 2L3 14h8l-2 8 10-12h-8l2-8z"/>
                                </svg>
                                <span style="color: #666; font-size: 14px; font-weight: 500;">Kapasitas: <strong style="color: #333;">{{ $genset->kapasitas ?? 'N/A' }}</strong></span>
                            </div>

                            @if($genset->deskripsi)
                            <div style="display: flex; align-items: start; gap: 10px; padding: 10px; background: #f8f9fa; border-radius: 8px;">
                                <svg style="width: 20px; height: 20px; fill: #667eea; flex-shrink: 0; margin-top: 2px;" viewBox="0 0 24 24">
                                    <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>
                                </svg>
                                <span style="color: #666; font-size: 13px; line-height: 1.5;">{{ Str::limit($genset->deskripsi, 80) }}</span>
                            </div>
                            @endif
                        </div>

                        <div style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); padding: 16px; border-radius: 12px; margin-bottom: 16px; text-align: center;">
                            <p style="color: #999; font-size: 12px; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px;">Harga Sewa</p>
                            <p style="font-size: 28px; font-weight: 800; color: #667eea; margin: 0;">
                                Rp {{ number_format($genset->harga_sewa, 0, ',', '.') }}
                                <small style="font-size: 14px; font-weight: 500; color: #999;">/hari</small>
                            </p>
                        </div>

                        @if($genset->status === 'tersedia')
                            <a href="{{ route('user.rentals.create', ['genset_id' => $genset->id]) }}" style="display: block; width: 100%; padding: 14px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 10px; font-weight: 600; cursor: pointer; text-align: center; text-decoration: none; transition: all 0.3s; box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);" onmouseover="this.style.transform='scale(1.02)'; this.style.boxShadow='0 6px 16px rgba(102, 126, 234, 0.4)'" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 4px 12px rgba(102, 126, 234, 0.3)'">
                                <span style="display: flex; align-items: center; justify-content: center; gap: 8px;">
                                    <svg style="width: 20px; height: 20px; fill: white;" viewBox="0 0 24 24">
                                        <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                                    </svg>
                                    Sewa Sekarang
                                </span>
                            </a>
                        @else
                            <button disabled style="display: block; width: 100%; padding: 14px; background: #dee2e6; color: #6c757d; border: none; border-radius: 10px; font-weight: 600; cursor: not-allowed; text-align: center;">
                                Tidak Tersedia
                            </button>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div style="text-align: center; padding: 60px 20px; background: white; border-radius: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                <svg style="width: 80px; height: 80px; fill: #dee2e6; margin-bottom: 20px;" viewBox="0 0 24 24">
                    <path d="M13 2L3 14h8l-2 8 10-12h-8l2-8z"/>
                </svg>
                <h3 style="font-size: 20px; color: #999; margin-bottom: 8px;">Tidak Ada Genset</h3>
                <p style="color: #adb5bd; font-size: 14px;">Belum ada genset yang sesuai dengan filter Anda</p>
            </div>
        @endif
    </div>

    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; padding-bottom: 20px; border-bottom: 2px solid #f0f0f0;">
            <h3 style="font-size: 22px; font-weight: 700; color: #333; margin: 0; display: flex; align-items: center; gap: 10px;">
                <svg style="width: 28px; height: 28px; fill: #667eea;" viewBox="0 0 24 24">
                    <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z"/>
                </svg>
                Riwayat Penyewaan Terbaru
            </h3>
            @if($myRentals->count() > 0)
                <a href="{{ route('user.rentals.index') }}" style="color: #667eea; text-decoration: none; font-weight: 600; font-size: 14px; display: flex; align-items: center; gap: 6px;" onmouseover="this.style.color='#764ba2'" onmouseout="this.style.color='#667eea'">
                    Lihat Semua
                    <svg style="width: 16px; height: 16px; fill: currentColor;" viewBox="0 0 24 24">
                        <path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z"/>
                    </svg>
                </a>
            @endif
        </div>
        
        @if($myRentals->count() > 0)
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); text-align: left;">
                            <th style="padding: 16px; font-weight: 700; color: #333; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Genset</th>
                            <th style="padding: 16px; font-weight: 700; color: #333; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Tanggal Sewa</th>
                            <th style="padding: 16px; font-weight: 700; color: #333; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Durasi</th>
                            <th style="padding: 16px; font-weight: 700; color: #333; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Total</th>
                            <th style="padding: 16px; font-weight: 700; color: #333; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Status</th>
                            <th style="padding: 16px; font-weight: 700; color: #333; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px; text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($myRentals as $rental)
                        <tr style="border-bottom: 1px solid #e9ecef; transition: all 0.2s;" onmouseover="this.style.background='#f8f9fa'" onmouseout="this.style.background='white'">
                            <td style="padding: 16px;">
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                        <svg style="width: 22px; height: 22px; fill: white;" viewBox="0 0 24 24">
                                            <path d="M13 2L3 14h8l-2 8 10-12h-8l2-8z"/>
                                        </svg>
                                    </div>
                                    <span style="color: #333; font-size: 14px; font-weight: 600;">{{ $rental->genset->nama_genset }}</span>
                                </div>
                            </td>
                            <td style="padding: 16px; color: #666; font-size: 14px;">
                                {{ \Carbon\Carbon::parse($rental->tanggal_mulai)->format('d M Y') }}
                            </td>
                            <td style="padding: 16px; color: #666; font-size: 14px; font-weight: 500;">
                                {{ \Carbon\Carbon::parse($rental->tanggal_mulai)->diffInDays(\Carbon\Carbon::parse($rental->tanggal_selesai)) + 1 }} hari
                            </td>
                            <td style="padding: 16px; color: #333; font-size: 14px; font-weight: 700;">
                                Rp {{ number_format($rental->total_harga, 0, ',', '.') }}
                            </td>
                            <td style="padding: 16px;">
                                @if($rental->status === 'pending')
                                    <span style="background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%); color: #856404; padding: 6px 14px; border-radius: 20px; font-size: 12px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px;">
                                        <svg style="width: 12px; height: 12px; fill: currentColor;" viewBox="0 0 24 24">
                                            <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/>
                                        </svg>
                                        Pending
                                    </span>
                                @elseif($rental->status === 'active')
                                    <span style="background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%); color: #155724; padding: 6px 14px; border-radius: 20px; font-size: 12px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px;">
                                        <svg style="width: 12px; height: 12px; fill: currentColor;" viewBox="0 0 24 24">
                                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                                        </svg>
                                        Aktif
                                    </span>
                                @elseif($rental->status === 'selesai')
                                    <span style="background: linear-gradient(135deg, #d1ecf1 0%, #bee5eb 100%); color: #0c5460; padding: 6px 14px; border-radius: 20px; font-size: 12px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px;">
                                        <svg style="width: 12px; height: 12px; fill: currentColor;" viewBox="0 0 24 24">
                                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                                        </svg>
                                        Selesai
                                    </span>
                                @else
                                    <span style="background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%); color: #721c24; padding: 6px 14px; border-radius: 20px; font-size: 12px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px;">
                                        <svg style="width: 12px; height: 12px; fill: currentColor;" viewBox="0 0 24 24">
                                            <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                                        </svg>
                                        Dibatalkan
                                    </span>
                                @endif
                            </td>
                            <td style="padding: 16px; text-align: center;">
                                <a href="{{ route('user.rentals.show', $rental->id) }}" style="padding: 8px 16px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 8px; text-decoration: none; font-size: 13px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px; transition: all 0.3s; box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);" onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 4px 12px rgba(102, 126, 234, 0.4)'" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 2px 8px rgba(102, 126, 234, 0.3)'">
                                    <svg style="width: 16px; height: 16px; fill: white;" viewBox="0 0 24 24">
                                        <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                                    </svg>
                                    Detail
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div style="text-align: center; padding: 50px 20px;">
                <svg style="width: 64px; height: 64px; fill: #dee2e6; margin-bottom: 16px;" viewBox="0 0 24 24">
                    <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z"/>
                </svg>
                <h4 style="font-size: 18px; color: #999; margin-bottom: 8px;">Belum Ada Riwayat Penyewaan</h4>
                <p style="color: #adb5bd; font-size: 14px; margin-bottom: 20px;">Mulai sewa genset untuk melihat riwayat penyewaan Anda</p>
                <a href="#" onclick="window.scrollTo({top: 0, behavior: 'smooth'}); return false;" style="padding: 10px 24px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-block; transition: all 0.3s; box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 16px rgba(102, 126, 234, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(102, 126, 234, 0.3)'">
                    Jelajahi Genset
                </a>
            </div>
        @endif
    </div>

    <div style="margin-top: 30px; display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 16px; padding: 24px; color: white; box-shadow: 0 8px 24px rgba(102, 126, 234, 0.3);">
            <div style="display: flex; align-items: start; gap: 16px;">
                <div style="width: 48px; height: 48px; background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px); border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <svg style="width: 26px; height: 26px; fill: white;" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                    </svg>
                </div>
                <div>
                    <h4 style="font-size: 16px; font-weight: 700; margin-bottom: 8px;">Proses Cepat</h4>
                    <p style="font-size: 13px; opacity: 0.9; line-height: 1.5; margin: 0;">Booking genset dengan mudah dan cepat hanya dalam beberapa klik</p>
                </div>
            </div>
        </div>

        <div style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); border-radius: 16px; padding: 24px; color: white; box-shadow: 0 8px 24px rgba(40, 167, 69, 0.3);">
            <div style="display: flex; align-items: start; gap: 16px;">
                <div style="width: 48px; height: 48px; background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px); border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <svg style="width: 26px; height: 26px; fill: white;" viewBox="0 0 24 24">
                        <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 10.99h7c-.53 4.12-3.28 7.79-7 8.94V12H5V6.3l7-3.11v8.8z"/>
                    </svg>
                </div>
                <div>
                    <h4 style="font-size: 16px; font-weight: 700; margin-bottom: 8px;">Terjamin Aman</h4>
                    <p style="font-size: 13px; opacity: 0.9; line-height: 1.5; margin: 0;">Semua genset dalam kondisi prima dan terawat dengan baik</p>
                </div>
            </div>
        </div>

        <div style="background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%); border-radius: 16px; padding: 24px; color: white; box-shadow: 0 8px 24px rgba(255, 193, 7, 0.3);">
            <div style="display: flex; align-items: start; gap: 16px;">
                <div style="width: 48px; height: 48px; background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px); border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <svg style="width: 26px; height: 26px; fill: white;" viewBox="0 0 24 24">
                        <path d="M20 4H4c-1.11 0-1.99.89-1.99 2L2 18c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V6c0-1.11-.89-2-2-2zm0 14H4v-6h16v6zm0-10H4V6h16v2z"/>
                    </svg>
                </div>
                <div>
                    <h4 style="font-size: 16px; font-weight: 700; margin-bottom: 8px;">Harga Kompetitif</h4>
                    <p style="font-size: 13px; opacity: 0.9; line-height: 1.5; margin: 0;">Dapatkan harga terbaik untuk penyewaan genset berkualitas</p>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Smooth scrolling for the page */
        html {
            scroll-behavior: smooth;
        }

        /* Animation for cards on load */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card {
            animation: fadeInUp 0.6s ease-out;
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