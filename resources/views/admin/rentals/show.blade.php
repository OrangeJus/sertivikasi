@extends('layouts.app')

@section('page-title', 'Detail Penyewaan')

@section('content')
<div style="margin-bottom: 30px;">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
        <div>
            <h2 style="font-size: 28px; font-weight: 600; margin-bottom: 10px;">Detail Penyewaan</h2>
            <p style="color: #666; font-size: 14px;">Informasi lengkap penyewaan genset</p>
        </div>
        <a href="{{ route('admin.rentals.index') }}" style="padding: 12px 24px; background: #667eea; color: white; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 8px;">
            <svg style="width: 20px; height: 20px; fill: white;" viewBox="0 0 24 24">
                <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/>
            </svg>
            Kembali
        </a>
    </div>
</div>

<!-- Success Message -->
@if (session('success'))
    <div class="alert alert-success" style="margin-bottom: 25px;">
        {{ session('success') }}
    </div>
@endif

<!-- Status Card -->
<div class="card" style="margin-bottom: 30px;">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
        <div>
            <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 8px; color: #333;">Status Penyewaan</h3>
            <div style="display: flex; align-items: center; gap: 12px;">
                @if($rental->status === 'pending')
                    <span style="background: #fff3cd; color: #856404; padding: 8px 16px; border-radius: 6px; font-size: 14px; font-weight: 600;">⏳ Pending</span>
                @elseif($rental->status === 'active')
                    <span style="background: #d4edda; color: #155724; padding: 8px 16px; border-radius: 6px; font-size: 14px; font-weight: 600;">✓ Aktif</span>
                @elseif($rental->status === 'selesai')
                    <span style="background: #d1ecf1; color: #0c5460; padding: 8px 16px; border-radius: 6px; font-size: 14px; font-weight: 600;">✓ Selesai</span>
                @else
                    <span style="background: #f8d7da; color: #721c24; padding: 8px 16px; border-radius: 6px; font-size: 14px; font-weight: 600;">✕ Dibatalkan</span>
                @endif
                <span style="color: #999; font-size: 13px;">ID: #{{ $rental->id }}</span>
            </div>
        </div>

        <!-- Action Buttons -->
        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
            @if($rental->status === 'pending')
                <form method="POST" action="{{ route('admin.rentals.update', $rental->id) }}" style="display: inline-block;">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="active">
                    <button type="submit" onclick="return confirm('Aktifkan penyewaan ini?')" style="padding: 10px 20px; background: #28a745; color: white; border: none; border-radius: 6px; font-size: 14px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 8px;">
                        <svg style="width: 18px; height: 18px; fill: white;" viewBox="0 0 24 24">
                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                        </svg>
                        Aktifkan
                    </button>
                </form>

                <form method="POST" action="{{ route('admin.rentals.update', $rental->id) }}" style="display: inline-block;">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="batal">
                    <button type="submit" onclick="return confirm('Batalkan penyewaan ini?')" style="padding: 10px 20px; background: #dc3545; color: white; border: none; border-radius: 6px; font-size: 14px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 8px;">
                        <svg style="width: 18px; height: 18px; fill: white;" viewBox="0 0 24 24">
                            <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                        </svg>
                        Batalkan
                    </button>
                </form>
            @endif

            @if($rental->status === 'active')
                <form method="POST" action="{{ route('admin.rentals.update', $rental->id) }}" style="display: inline-block;">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="selesai">
                    <button type="submit" onclick="return confirm('Selesaikan penyewaan ini?')" style="padding: 10px 20px; background: #17a2b8; color: white; border: none; border-radius: 6px; font-size: 14px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 8px;">
                        <svg style="width: 18px; height: 18px; fill: white;" viewBox="0 0 24 24">
                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                        </svg>
                        Selesaikan
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>

<!-- Main Content Grid -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 30px; margin-bottom: 30px;">
    
    <!-- User Information -->
    <div class="card">
        <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 20px; color: #333; display: flex; align-items: center; gap: 10px;">
            <svg style="width: 24px; height: 24px; fill: #667eea;" viewBox="0 0 24 24">
                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
            </svg>
            Informasi Penyewa
        </h3>
        
        <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 20px;">
            <div style="width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 24px;">
                {{ substr($rental->user->name, 0, 1) }}
            </div>
            <div>
                <h4 style="font-size: 16px; font-weight: 600; color: #333; margin-bottom: 4px;">{{ $rental->user->name }}</h4>
                <p style="color: #999; font-size: 14px; margin: 0;">{{ $rental->user->email }}</p>
            </div>
        </div>

        <div style="border-top: 1px solid #e0e0e0; padding-top: 20px;">
            <div style="margin-bottom: 15px;">
                <label style="display: block; color: #999; font-size: 12px; margin-bottom: 5px; text-transform: uppercase; letter-spacing: 0.5px;">No. Telepon</label>
                <p style="color: #333; font-size: 14px; margin: 0; font-weight: 500;">{{ $rental->user->no_telp ?? '-' }}</p>
            </div>
            <div>
                <label style="display: block; color: #999; font-size: 12px; margin-bottom: 5px; text-transform: uppercase; letter-spacing: 0.5px;">Alamat</label>
                <p style="color: #333; font-size: 14px; margin: 0; font-weight: 500;">{{ $rental->user->alamat ?? '-' }}</p>
            </div>
        </div>
    </div>

    <!-- Genset Information -->
    <div class="card">
        <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 20px; color: #333; display: flex; align-items: center; gap: 10px;">
            <svg style="width: 24px; height: 24px; fill: #667eea;" viewBox="0 0 24 24">
                <path d="M13 2L3 14h8l-2 8 10-12h-8l2-8z"/>
            </svg>
            Informasi Genset
        </h3>

        <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 20px;">
            <div style="width: 60px; height: 60px; border-radius: 12px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center;">
                <svg style="width: 32px; height: 32px; fill: white;" viewBox="0 0 24 24">
                    <path d="M13 2L3 14h8l-2 8 10-12h-8l2-8z"/>
                </svg>
            </div>
            <div>
                <h4 style="font-size: 16px; font-weight: 600; color: #333; margin-bottom: 4px;">{{ $rental->genset->nama_genset }}</h4>
                <p style="color: #999; font-size: 14px; margin: 0;">{{ $rental->genset->merek }}</p>
            </div>
        </div>

        <div style="border-top: 1px solid #e0e0e0; padding-top: 20px;">
            <div style="margin-bottom: 15px;">
                <label style="display: block; color: #999; font-size: 12px; margin-bottom: 5px; text-transform: uppercase; letter-spacing: 0.5px;">Daya</label>
                <p style="color: #333; font-size: 14px; margin: 0; font-weight: 500;">{{ $rental->genset->daya }} kVA</p>
            </div>
            <div style="margin-bottom: 15px;">
                <label style="display: block; color: #999; font-size: 12px; margin-bottom: 5px; text-transform: uppercase; letter-spacing: 0.5px;">Harga Sewa/Hari</label>
                <p style="color: #333; font-size: 14px; margin: 0; font-weight: 600;">Rp {{ number_format($rental->genset->harga_sewa, 0, ',', '.') }}</p>
            </div>
            <div>
                <label style="display: block; color: #999; font-size: 12px; margin-bottom: 5px; text-transform: uppercase; letter-spacing: 0.5px;">Status Genset</label>
                @if($rental->genset->status === 'tersedia')
                    <span style="background: #d4edda; color: #155724; padding: 4px 10px; border-radius: 4px; font-size: 12px; font-weight: 600;">Tersedia</span>
                @else
                    <span style="background: #f8d7da; color: #721c24; padding: 4px 10px; border-radius: 4px; font-size: 12px; font-weight: 600;">Disewa</span>
                @endif
            </div>
        </div>
    </div>

</div>

<!-- Rental Details -->
<div class="card" style="margin-bottom: 30px;">
    <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 25px; color: #333; display: flex; align-items: center; gap: 10px;">
        <svg style="width: 24px; height: 24px; fill: #667eea;" viewBox="0 0 24 24">
            <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/>
        </svg>
        Detail Penyewaan
    </h3>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 25px;">
        <div>
            <label style="display: block; color: #999; font-size: 12px; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Tanggal Mulai</label>
            <div style="display: flex; align-items: center; gap: 10px;">
                <svg style="width: 20px; height: 20px; fill: #667eea;" viewBox="0 0 24 24">
                    <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z"/>
                </svg>
                <p style="color: #333; font-size: 15px; margin: 0; font-weight: 600;">{{ \Carbon\Carbon::parse($rental->tanggal_mulai)->format('d F Y') }}</p>
            </div>
        </div>

        <div>
            <label style="display: block; color: #999; font-size: 12px; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Tanggal Selesai</label>
            <div style="display: flex; align-items: center; gap: 10px;">
                <svg style="width: 20px; height: 20px; fill: #667eea;" viewBox="0 0 24 24">
                    <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z"/>
                </svg>
                <p style="color: #333; font-size: 15px; margin: 0; font-weight: 600;">{{ \Carbon\Carbon::parse($rental->tanggal_selesai)->format('d F Y') }}</p>
            </div>
        </div>

        <div>
            <label style="display: block; color: #999; font-size: 12px; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Lama Sewa</label>
            <div style="display: flex; align-items: center; gap: 10px;">
                <svg style="width: 20px; height: 20px; fill: #667eea;" viewBox="0 0 24 24">
                    <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/>
                </svg>
                <p style="color: #333; font-size: 15px; margin: 0; font-weight: 600;">
                    {{ \Carbon\Carbon::parse($rental->tanggal_mulai)->diffInDays(\Carbon\Carbon::parse($rental->tanggal_selesai)) + 1 }} Hari
                </p>
            </div>
        </div>

        <div>
            <label style="display: block; color: #999; font-size: 12px; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Tanggal Pemesanan</label>
            <div style="display: flex; align-items: center; gap: 10px;">
                <svg style="width: 20px; height: 20px; fill: #999;" viewBox="0 0 24 24">
                    <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/>
                </svg>
                <p style="color: #666; font-size: 14px; margin: 0;">{{ $rental->created_at->format('d F Y, H:i') }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Payment Summary -->
<div class="card">
    <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 25px; color: #333; display: flex; align-items: center; gap: 10px;">
        <svg style="width: 24px; height: 24px; fill: #667eea;" viewBox="0 0 24 24">
            <path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z"/>
        </svg>
        Rincian Pembayaran
    </h3>

    <div style="background: #f8f9fa; padding: 20px; border-radius: 10px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; padding-bottom: 15px; border-bottom: 2px dashed #dee2e6;">
            <span style="color: #666; font-size: 14px;">Harga Sewa per Hari</span>
            <span style="color: #333; font-size: 15px; font-weight: 500;">Rp {{ number_format($rental->genset->harga_sewa, 0, ',', '.') }}</span>
        </div>
        
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; padding-bottom: 15px; border-bottom: 2px dashed #dee2e6;">
            <span style="color: #666; font-size: 14px;">Durasi</span>
            <span style="color: #333; font-size: 15px; font-weight: 500;">
                {{ \Carbon\Carbon::parse($rental->tanggal_mulai)->diffInDays(\Carbon\Carbon::parse($rental->tanggal_selesai)) + 1 }} Hari
            </span>
        </div>

        <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 5px;">
            <span style="color: #333; font-size: 16px; font-weight: 600;">Total Pembayaran</span>
            <span style="color: #667eea; font-size: 24px; font-weight: 700;">Rp {{ number_format($rental->total_harga, 0, ',', '.') }}</span>
        </div>
    </div>
</div>

@endsection