@extends('layouts.app')

@section('page-title', 'Detail Penyewaan')

@section('content')
    <div style="margin-bottom: 30px;">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
            <div>
                <h2 style="font-size: 28px; font-weight: 600; margin-bottom: 10px;">Detail Penyewaan</h2>
                <p style="color: #666; font-size: 14px;">Informasi lengkap tentang penyewaan genset Anda</p>
            </div>
            <a href="{{ route('user.rentals.index') }}" style="padding: 12px 24px; background: #e9ecef; color: #495057; border-radius: 10px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 8px; transition: all 0.3s;" onmouseover="this.style.background='#dee2e6'" onmouseout="this.style.background='#e9ecef'">
                <svg style="width: 20px; height: 20px; fill: currentColor;" viewBox="0 0 24 24">
                    <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    @if (session('success'))
        <div style="background: #d4edda; color: #155724; padding: 16px 20px; border-radius: 10px; margin-bottom: 25px; border-left: 4px solid #28a745; display: flex; align-items: center; gap: 12px;">
            <svg style="width: 24px; height: 24px; fill: currentColor; flex-shrink: 0;" viewBox="0 0 24 24">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
            </svg>
            <span style="font-weight: 500;">{{ session('success') }}</span>
        </div>
    @endif

    <div style="margin-bottom: 30px;">
        @if($rental->status === 'pending')
            <div style="background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%); border-radius: 16px; padding: 24px 30px; border-left: 6px solid #ffc107; box-shadow: 0 4px 12px rgba(255, 193, 7, 0.2);">
                <div style="display: flex; align-items: center; gap: 16px;">
                    <div style="width: 56px; height: 56px; background: rgba(255, 255, 255, 0.4); backdrop-filter: blur(10px); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <svg style="width: 32px; height: 32px; fill: #856404;" viewBox="0 0 24 24">
                            <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/>
                        </svg>
                    </div>
                    <div style="flex: 1;">
                        <h3 style="font-size: 18px; font-weight: 700; color: #856404; margin-bottom: 6px;">Menunggu Konfirmasi</h3>
                        <p style="color: #856404; font-size: 14px; margin: 0; opacity: 0.9;">Pesanan Anda sedang ditinjau oleh admin. Kami akan mengkonfirmasi dalam waktu 1x24 jam.</p>
                    </div>
                </div>
            </div>
        @elseif($rental->status === 'active')
            <div style="background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%); border-radius: 16px; padding: 24px 30px; border-left: 6px solid #28a745; box-shadow: 0 4px 12px rgba(40, 167, 69, 0.2);">
                <div style="display: flex; align-items: center; gap: 16px;">
                    <div style="width: 56px; height: 56px; background: rgba(255, 255, 255, 0.4); backdrop-filter: blur(10px); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <svg style="width: 32px; height: 32px; fill: #155724;" viewBox="0 0 24 24">
                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                        </svg>
                    </div>
                    <div style="flex: 1;">
                        <h3 style="font-size: 18px; font-weight: 700; color: #155724; margin-bottom: 6px;">Penyewaan Aktif</h3>
                        <p style="color: #155724; font-size: 14px; margin: 0; opacity: 0.9;">Genset sedang aktif disewakan kepada Anda. Pastikan pembayaran sudah dilakukan.</p>
                    </div>
                </div>
            </div>
        @elseif($rental->status === 'selesai')
            <div style="background: linear-gradient(135deg, #d1ecf1 0%, #bee5eb 100%); border-radius: 16px; padding: 24px 30px; border-left: 6px solid #17a2b8; box-shadow: 0 4px 12px rgba(23, 162, 184, 0.2);">
                <div style="display: flex; align-items: center; gap: 16px;">
                    <div style="width: 56px; height: 56px; background: rgba(255, 255, 255, 0.4); backdrop-filter: blur(10px); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <svg style="width: 32px; height: 32px; fill: #0c5460;" viewBox="0 0 24 24">
                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                        </svg>
                    </div>
                    <div style="flex: 1;">
                        <h3 style="font-size: 18px; font-weight: 700; color: #0c5460; margin-bottom: 6px;">Penyewaan Selesai</h3>
                        <p style="color: #0c5460; font-size: 14px; margin: 0; opacity: 0.9;">Penyewaan telah selesai. Terima kasih telah menggunakan layanan kami!</p>
                    </div>
                </div>
            </div>
        @else
            <div style="background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%); border-radius: 16px; padding: 24px 30px; border-left: 6px solid #dc3545; box-shadow: 0 4px 12px rgba(220, 53, 69, 0.2);">
                <div style="display: flex; align-items: center; gap: 16px;">
                    <div style="width: 56px; height: 56px; background: rgba(255, 255, 255, 0.4); backdrop-filter: blur(10px); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <svg style="width: 32px; height: 32px; fill: #721c24;" viewBox="0 0 24 24">
                            <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                        </svg>
                    </div>
                    <div style="flex: 1;">
                        <h3 style="font-size: 18px; font-weight: 700; color: #721c24; margin-bottom: 6px;">Penyewaan Dibatalkan</h3>
                        <p style="color: #721c24; font-size: 14px; margin: 0; opacity: 0.9;">Penyewaan ini telah dibatalkan. Silakan hubungi admin untuk informasi lebih lanjut.</p>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div style="display: grid; grid-template-columns: 1fr 380px; gap: 30px; margin-bottom: 30px;">
        
        <div style="display: flex; flex-direction: column; gap: 30px;">
            
            <div class="card">
                <h3 style="font-size: 20px; font-weight: 700; margin-bottom: 24px; color: #333; display: flex; align-items: center; gap: 10px; padding-bottom: 20px; border-bottom: 2px solid #f0f0f0;">
                    <svg style="width: 26px; height: 26px; fill: #667eea;" viewBox="0 0 24 24">
                        <path d="M13 2L3 14h8l-2 8 10-12h-8l2-8z"/>
                    </svg>
                    Informasi Genset
                </h3>

                <div style="display: flex; gap: 24px; align-items: start;">
                    <div style="width: 160px; height: 160px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 16px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; overflow: hidden;">
                        @if($rental->genset->image)
                            <img src="{{ asset('storage/' . $rental->genset->image) }}" alt="{{ $rental->genset->nama_genset }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <svg style="width: 80px; height: 80px; fill: white;" viewBox="0 0 24 24">
                                <path d="M13 2L3 14h8l-2 8 10-12h-8l2-8z"/>
                            </svg>
                        @endif
                    </div>

                    <div style="flex: 1;">
                        <h4 style="font-size: 22px; font-weight: 700; color: #333; margin-bottom: 12px;">{{ $rental->genset->nama_genset }}</h4>
                        
                        <div style="display: flex; flex-direction: column; gap: 12px;">
                            <div style="display: flex; align-items: center; gap: 10px; padding: 12px; background: #f8f9fa; border-radius: 10px;">
                                <svg style="width: 20px; height: 20px; fill: #667eea; flex-shrink: 0;" viewBox="0 0 24 24">
                                    <path d="M13 2L3 14h8l-2 8 10-12h-8l2-8z"/>
                                </svg>
                                <div>
                                    <p style="color: #999; font-size: 12px; margin: 0;">Kapasitas</p>
                                    <p style="color: #333; font-size: 15px; font-weight: 600; margin: 0;">{{ $rental->genset->kapasitas ?? 'N/A' }}</p>
                                </div>
                            </div>

                            <div style="display: flex; align-items: center; gap: 10px; padding: 12px; background: #f8f9fa; border-radius: 10px;">
                                <svg style="width: 20px; height: 20px; fill: #667eea; flex-shrink: 0;" viewBox="0 0 24 24">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                </svg>
                                <div>
                                    <p style="color: #999; font-size: 12px; margin: 0;">Status Genset</p>
                                    <p style="color: #333; font-size: 15px; font-weight: 600; margin: 0;">
                                        @if($rental->genset->status === 'tersedia')
                                            <span style="color: #28a745;">✓ Tersedia</span>
                                        @elseif($rental->genset->status === 'disewa')
                                            <span style="color: #dc3545;">⊗ Disewa</span>
                                        @else
                                            <span style="color: #ffc107;">⚠ Rusak</span>
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <div style="display: flex; align-items: center; gap: 10px; padding: 12px; background: #f8f9fa; border-radius: 10px;">
                                <svg style="width: 20px; height: 20px; fill: #667eea; flex-shrink: 0;" viewBox="0 0 24 24">
                                    <path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z"/>
                                </svg>
                                <div>
                                    <p style="color: #999; font-size: 12px; margin: 0;">Harga Sewa</p>
                                    <p style="color: #667eea; font-size: 17px; font-weight: 700; margin: 0;">Rp {{ number_format($rental->genset->harga_sewa, 0, ',', '.') }}/hari</p>
                                </div>
                            </div>
                        </div>

                        @if($rental->genset->deskripsi)
                        <div style="margin-top: 16px; padding: 14px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 10px; border-left: 3px solid #667eea;">
                            <p style="color: #666; font-size: 13px; line-height: 1.6; margin: 0;">{{ $rental->genset->deskripsi }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="card">
                <h3 style="font-size: 20px; font-weight: 700; margin-bottom: 24px; color: #333; display: flex; align-items: center; gap: 10px; padding-bottom: 20px; border-bottom: 2px solid #f0f0f0;">
                    <svg style="width: 26px; height: 26px; fill: #667eea;" viewBox="0 0 24 24">
                        <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z"/>
                    </svg>
                    Periode Penyewaan
                </h3>

                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
                    <div style="padding: 20px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 12px; border-left: 4px solid #667eea;">
                        <p style="color: #999; font-size: 12px; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">Tanggal Mulai</p>
                        <p style="color: #333; font-size: 18px; font-weight: 700; margin: 0;">{{ $rental->tanggal_mulai->format('d M Y') }}</p>
                        <p style="color: #666; font-size: 13px; margin-top: 4px; margin-bottom: 0;">{{ $rental->tanggal_mulai->format('l') }}</p>
                    </div>

                    <div style="padding: 20px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 12px; border-left: 4px solid #667eea;">
                        <p style="color: #999; font-size: 12px; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">Tanggal Selesai</p>
                        <p style="color: #333; font-size: 18px; font-weight: 700; margin: 0;">{{ $rental->tanggal_selesai->format('d M Y') }}</p>
                        <p style="color: #666; font-size: 13px; margin-top: 4px; margin-bottom: 0;">{{ $rental->tanggal_selesai->format('l') }}</p>
                    </div>
                </div>

                <div style="margin-top: 20px; padding: 20px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px; text-align: center; color: white;">
                    <p style="font-size: 14px; margin-bottom: 6px; opacity: 0.9;">Total Durasi Penyewaan</p>
                    <p style="font-size: 36px; font-weight: 800; margin: 0;">{{ $rental->tanggal_mulai->diffInDays($rental->tanggal_selesai) + 1 }} <span style="font-size: 18px; font-weight: 600;">Hari</span></p>
                </div>
            </div>

            @if($rental->catatan)
            <div class="card">
                <h3 style="font-size: 20px; font-weight: 700; margin-bottom: 20px; color: #333; display: flex; align-items: center; gap: 10px; padding-bottom: 20px; border-bottom: 2px solid #f0f0f0;">
                    <svg style="width: 26px; height: 26px; fill: #667eea;" viewBox="0 0 24 24">
                        <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>
                    </svg>
                    Catatan Tambahan
                </h3>
                <div style="padding: 18px; background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%); border-radius: 12px; border-left: 4px solid #ffc107;">
                    <p style="color: #856404; font-size: 14px; line-height: 1.7; margin: 0;">{{ $rental->catatan }}</p>
                </div>
            </div>
            @endif

        </div>

        <div style="position: sticky; top: 20px;">
            
            <div class="card">
                <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 20px; color: #333; display: flex; align-items: center; gap: 10px; padding-bottom: 16px; border-bottom: 2px solid #f0f0f0;">
                    <svg style="width: 24px; height: 24px; fill: #667eea;" viewBox="0 0 24 24">
                        <path d="M19 3h-4.18C14.4 1.84 13.3 1 12 1c-1.3 0-2.4.84-2.82 2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 0c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm2 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/>
                    </svg>
                    Ringkasan Pesanan
                </h3>

                <div style="margin-bottom: 20px; padding: 16px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 10px; text-align: center;">
                    <p style="color: #999; font-size: 12px; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px;">Order ID</p>
                    <p style="color: #333; font-size: 20px; font-weight: 800; margin: 0; font-family: monospace;">#{{ str_pad($rental->id, 6, '0', STR_PAD_LEFT) }}</p>
                </div>

                <div style="margin-bottom: 20px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px; padding-bottom: 14px; border-bottom: 2px dashed #dee2e6;">
                        <span style="color: #666; font-size: 14px;">Harga per Hari</span>
                        <span style="color: #333; font-size: 15px; font-weight: 600;">Rp {{ number_format($rental->genset->harga_sewa, 0, ',', '.') }}</span>
                    </div>
                    
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px; padding-bottom: 14px; border-bottom: 2px dashed #dee2e6;">
                        <span style="color: #666; font-size: 14px;">Durasi Sewa</span>
                        <span style="color: #333; font-size: 15px; font-weight: 600;">{{ $rental->tanggal_mulai->diffInDays($rental->tanggal_selesai) + 1 }} hari</span>
                    </div>

                    <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 10px;">
                        <span style="color: #333; font-size: 16px; font-weight: 700;">Total Harga</span>
                        <span style="color: #667eea; font-size: 26px; font-weight: 800;">Rp {{ number_format($rental->total_harga, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div style="padding: 20px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 12px; margin-bottom: 20px;">
                    <p style="color: #333; font-size: 14px; font-weight: 700; margin-bottom: 16px;">Status Perjalanan</p>
                    
                    <div style="position: relative; padding-left: 32px;">
                        <div style="position: absolute; left: 9px; top: 12px; bottom: 12px; width: 2px; background: #dee2e6;"></div>
                        
                        <div style="position: relative; margin-bottom: 20px;">
                            <div style="position: absolute; left: -32px; width: 20px; height: 20px; border-radius: 50%; background: {{ in_array($rental->status, ['pending', 'active', 'selesai']) ? '#28a745' : '#dc3545' }}; border: 3px solid white; box-shadow: 0 2px 8px rgba(0,0,0,0.15);"></div>
                            <p style="color: #333; font-size: 13px; font-weight: 600; margin-bottom: 2px;">Pesanan Dibuat</p>
                            <p style="color: #999; font-size: 11px; margin: 0;">{{ $rental->created_at->format('d M Y, H:i') }}</p>
                        </div>

                        <div style="position: relative; margin-bottom: 20px; {{ !in_array($rental->status, ['active', 'selesai']) ? 'opacity: 0.4;' : '' }}">
                            <div style="position: absolute; left: -32px; width: 20px; height: 20px; border-radius: 50%; background: {{ in_array($rental->status, ['active', 'selesai']) ? '#28a745' : '#dee2e6' }}; border: 3px solid white; box-shadow: 0 2px 8px rgba(0,0,0,0.15);"></div>
                            <p style="color: #333; font-size: 13px; font-weight: 600; margin-bottom: 2px;">Disetujui</p>
                            <p style="color: #999; font-size: 11px; margin: 0;">{{ in_array($rental->status, ['active', 'selesai']) ? ($rental->updated_at->format('d M Y, H:i')) : 'Menunggu' }}</p>
                        </div>

                        <div style="position: relative; {{ $rental->status !== 'selesai' ? 'opacity: 0.4;' : '' }}">
                            <div style="position: absolute; left: -32px; width: 20px; height: 20px; border-radius: 50%; background: {{ $rental->status === 'selesai' ? '#28a745' : '#dee2e6' }}; border: 3px solid white; box-shadow: 0 2px 8px rgba(0,0,0,0.15);"></div>
                            <p style="color: #333; font-size: 13px; font-weight: 600; margin-bottom: 2px;">Selesai</p>
                            <p style="color: #999; font-size: 11px; margin: 0;">{{ $rental->status === 'selesai' ? ($rental->updated_at->format('d M Y, H:i')) : 'Menunggu' }}</p>
                        </div>
                    </div>
                </div>

                @if($rental->status === 'active')
                <div style="padding: 18px; background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%); border-radius: 12px; margin-bottom: 16px; text-align: center;">
                    <svg style="width: 32px; height: 32px; fill: #155724; margin-bottom: 8px;" viewBox="0 0 24 24">
                        <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                    </svg>
                    <p style="color: #155724; font-size: 14px; font-weight: 600; margin: 0;">Penyewaan Sedang Berjalan</p>
                </div>
                @endif

                <div style="padding: 20px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px; color: white; text-align: center;">
                    <svg style="width: 32px; height: 32px; fill: white; margin-bottom: 12px;" viewBox="0 0 24 24">
                        <path d="M20 2H4c-1.1 0-1.99.9-1.99 2L2 22l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-2 12H6v-2h12v2zm0-3H6V9h12v2zm0-3H6V6h12v2z"/>
                    </svg>
                    <h4 style="font-size: 16px; font-weight: 700; margin-bottom: 10px;">Butuh Bantuan?</h4>
                    <p style="font-size: 13px; opacity: 0.95; line-height: 1.5; margin-bottom: 16px;">Hubungi admin jika ada pertanyaan tentang penyewaan Anda</p>
                    <a href="tel:+62123456789" style="display: inline-flex; align-items: center; gap: 10px; padding: 12px 24px; background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px); color: white; border-radius: 10px; text-decoration: none; font-size: 14px; font-weight: 600; transition: all 0.3s;" onmouseover="this.style.background='rgba(255, 255, 255, 0.3)'" onmouseout="this.style.background='rgba(255, 255, 255, 0.2)'">
                        <svg style="width: 18px; height: 18px; fill: white;" viewBox="0 0 24 24">
                            <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
                        </svg>
                        Hubungi Admin
                    </a>
                </div>
            </div>

            <div class="card" style="margin-top: 20px;">
                <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 16px; color: #333; display: flex; align-items: center; gap: 8px;">
                    <svg style="width: 20px; height: 20px; fill: #667eea;" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/>
                    </svg>
                    Informasi Tambahan
                </h3>
                <div style="display: flex; flex-direction: column; gap: 12px; font-size: 13px; color: #666; line-height: 1.6;">
                    <div style="display: flex; align-items: start; gap: 10px;">
                        <svg style="width: 16px; height: 16px; fill: #667eea; flex-shrink: 0; margin-top: 2px;" viewBox="0 0 24 24">
                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                        </svg>
                        <span>Genset akan diantar ke lokasi yang telah ditentukan</span>
                    </div>
                    <div style="display: flex; align-items: start; gap: 10px;">
                        <svg style="width: 16px; height: 16px; fill: #667eea; flex-shrink: 0; margin-top: 2px;" viewBox="0 0 24 24">
                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                        </svg>
                        <span>Operator tersedia untuk bantuan teknis</span>
                    </div>
                    <div style="display: flex; align-items: start; gap: 10px;">
                        <svg style="width: 16px; height: 16px; fill: #667eea; flex-shrink: 0; margin-top: 2px;" viewBox="0 0 24 24">
                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                        </svg>
                        <span>Bahan bakar dan maintenance termasuk dalam harga sewa</span>
                    </div>
                    <div style="display: flex; align-items: start; gap: 10px;">
                        <svg style="width: 16px; height: 16px; fill: #667eea; flex-shrink: 0; margin-top: 2px;" viewBox="0 0 24 24">
                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                        </svg>
                        <span>Garansi penggantian unit jika terjadi kerusakan</span>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @if($rental->denda > 0 || $rental->isOverdue())
    <div class="card" style="margin-bottom: 30px;">
        <h3 style="font-size: 20px; font-weight: 700; margin-bottom: 24px; color: #333; display: flex; align-items: center; gap: 10px; padding-bottom: 20px; border-bottom: 2px solid #f0f0f0;">
            <svg style="width: 26px; height: 26px; fill: #dc3545;" viewBox="0 0 24 24">
                <path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"/>
            </svg>
            Informasi Denda Keterlambatan
        </h3>
        @if($rental->status === 'active' && $rental->isOverdue())
            <div style="padding: 20px; background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%); border-radius: 12px; border-left: 4px solid #dc3545; margin-bottom: 20px;">
                <div style="display: flex; align-items: start; gap: 14px;">
                    <svg style="width: 32px; height: 32px; fill: #721c24; flex-shrink: 0;" viewBox="0 0 24 24">
                        <path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"/>
                    </svg>
                    <div style="flex: 1;">
                        <h4 style="font-size: 16px; font-weight: 700; color: #721c24; margin-bottom: 8px;">⚠️ GENSET TERLAMBAT DIKEMBALIKAN!</h4>
                        <p style="color: #721c24; font-size: 14px; margin-bottom: 12px; line-height: 1.6;">
                            Penyewaan Anda sudah melewati batas waktu pengembalian. 
                            Anda dikenakan denda <strong>2x harga sewa per hari keterlambatan</strong>.
                        </p>
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 12px; margin-top: 16px;">
                            <div style="padding: 12px; background: rgba(255, 255, 255, 0.6); border-radius: 8px;">
                                <p style="color: #856404; font-size: 12px; margin-bottom: 4px;">Hari Terlambat</p>
                                <p style="color: #721c24; font-size: 20px; font-weight: 800; margin: 0;">{{ $rental->hari_terlambat }} Hari</p>
                            </div>
                            <div style="padding: 12px; background: rgba(255, 255, 255, 0.6); border-radius: 8px;">
                                <p style="color: #856404; font-size: 12px; margin-bottom: 4px;">Denda per Hari</p>
                                <p style="color: #721c24; font-size: 18px; font-weight: 800; margin: 0;">Rp {{ number_format($rental->genset->harga_sewa * 2, 0, ',', '.') }}</p>
                            </div>
                            <div style="padding: 12px; background: rgba(255, 255, 255, 0.6); border-radius: 8px;">
                                <p style="color: #856404; font-size: 12px; margin-bottom: 4px;">Total Denda Saat Ini</p>
                                <p style="color: #dc3545; font-size: 22px; font-weight: 900; margin: 0;">Rp {{ number_format($rental->calculateDenda(), 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @elseif($rental->denda > 0)
            <div style="padding: 20px; background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%); border-radius: 12px; border-left: 4px solid #ffc107; margin-bottom: 20px;">
                <div style="display: flex; align-items: start; gap: 14px;">
                    <svg style="width: 28px; height: 28px; fill: #856404; flex-shrink: 0;" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                    </svg>
                    <div style="flex: 1;">
                        <h4 style="font-size: 16px; font-weight: 700; color: #856404; margin-bottom: 8px;">Denda Keterlambatan Diterapkan</h4>
                        <p style="color: #856404; font-size: 14px; margin-bottom: 12px;">
                            Genset dikembalikan terlambat {{ $rental->hari_keterlambatan }} hari dari jadwal.
                        </p>
                    </div>
                </div>
            </div>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
                <div style="padding: 18px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 12px; border-left: 4px solid #ffc107;">
                    <p style="color: #999; font-size: 12px; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">Hari Keterlambatan</p>
                    <p style="color: #333; font-size: 24px; font-weight: 800; margin: 0;">{{ $rental->hari_keterlambatan }} Hari</p>
                </div>
                <div style="padding: 18px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 12px; border-left: 4px solid #ffc107;">
                    <p style="color: #999; font-size: 12px; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">Denda per Hari</p>
                    <p style="color: #333; font-size: 20px; font-weight: 800; margin: 0;">Rp {{ number_format($rental->genset->harga_sewa * 2, 0, ',', '.') }}</p>
                </div>
                <div style="padding: 18px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 12px; border-left: 4px solid #dc3545;">
                    <p style="color: #999; font-size: 12px; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">Total Denda</p>
                    <p style="color: #dc3545; font-size: 24px; font-weight: 900; margin: 0;">Rp {{ number_format($rental->denda, 0, ',', '.') }}</p>
                </div>
                <div style="padding: 18px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px; box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);">
                    <p style="color: rgba(255,255,255,0.9); font-size: 12px; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">Total Pembayaran</p>
                    <p style="color: white; font-size: 24px; font-weight: 900; margin: 0;">Rp {{ number_format($rental->total_pembayaran, 0, ',', '.') }}</p>
                </div>
            </div>
        @endif
    </div>
    @endif

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">
        <div style="background: linear-gradient(135deg, #17a2b8 0%, #138496 100%); border-radius: 16px; padding: 24px; color: white; box-shadow: 0 8px 24px rgba(23, 162, 184, 0.3);">
            <div style="display: flex; align-items: start; gap: 16px;">
                <div style="width: 48px; height: 48px; background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px); border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <svg style="width: 26px; height: 26px; fill: white;" viewBox="0 0 24 24">
                        <path d="M20 4H4c-1.11 0-1.99.89-1.99 2L2 18c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V6c0-1.11-.89-2-2-2zm0 14H4v-6h16v6zm0-10H4V6h16v2z"/>
                    </svg>
                </div>
                <div>
                    <h4 style="font-size: 16px; font-weight: 700; margin-bottom: 8px;">Metode Pembayaran</h4>
                    <p style="font-size: 13px; opacity: 0.95; line-height: 1.5; margin: 0;">Transfer Bank, Cash, atau pembayaran online tersedia untuk kemudahan Anda.</p>
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
                    <h4 style="font-size: 16px; font-weight: 700; margin-bottom: 8px;">Garansi Kualitas</h4>
                    <p style="font-size: 13px; opacity: 0.95; line-height: 1.5; margin: 0;">Semua genset dijamin berkualitas dan akan diganti jika terjadi kerusakan selama masa sewa.</p>
                </div>
            </div>
        </div>

        <div style="background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%); border-radius: 16px; padding: 24px; color: white; box-shadow: 0 8px 24px rgba(255, 193, 7, 0.3);">
            <div style="display: flex; align-items: start; gap: 16px;">
                <div style="width: 48px; height: 48px; background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px); border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <svg style="width: 26px; height: 26px; fill: white;" viewBox="0 0 24 24">
                        <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/>
                    </svg>
                </div>
                <div>
                    <h4 style="font-size: 16px; font-weight: 700; margin-bottom: 8px;">Dukungan 24/7</h4>
                    <p style="font-size: 13px; opacity: 0.95; line-height: 1.5; margin: 0;">Tim support kami siap membantu Anda kapan saja, 24 jam sehari 7 hari seminggu.</p>
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
                    <h4 style="font-size: 16px; font-weight: 700; margin-bottom: 8px;">Garansi Kualitas</h4>
                    <p style="font-size: 13px; opacity: 0.95; line-height: 1.5; margin: 0;">Semua genset dijamin berkualitas dan akan diganti jika terjadi kerusakan selama masa sewa.</p>
                </div>
            </div>
        </div>

        <div style="background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%); border-radius: 16px; padding: 24px; color: white; box-shadow: 0 8px 24px rgba(255, 193, 7, 0.3);">
            <div style="display: flex; align-items: start; gap: 16px;">
                <div style="width: 48px; height: 48px; background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px); border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <svg style="width: 26px; height: 26px; fill: white;" viewBox="0 0 24 24">
                        <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/>
                    </svg>
                </div>
                <div>
                    <h4 style="font-size: 16px; font-weight: 700; margin-bottom: 8px;">Dukungan 24/7</h4>
                    <p style="font-size: 13px; opacity: 0.95; line-height: 1.5; margin: 0;">Tim support kami siap membantu Anda kapan saja, 24 jam sehari 7 hari seminggu.</p>
                </div>
            </div>
        </div>
    </div>
    
<style>
    /* Responsive Design */
    @media (max-width: 1024px) {
        div[style*="grid-template-columns: 1fr 380px"] {
            grid-template-columns: 1fr !important;
        }
        
        div[style*="position: sticky"] {
            position: relative !important;
        }
    }

    @media (max-width: 768px) {
        div[style*="grid-template-columns: repeat(2, 1fr)"] {
            grid-template-columns: 1fr !important;
        }
        
        div[style*="display: flex"] > div[style*="width: 160px"] {
            width: 120px !important;
            height: 120px !important;
        }
    }

    /* Animation */
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

    /* Print Styles */
    @media print {
        body * {
            visibility: hidden;
        }
        
        .card, .card * {
            visibility: visible;
        }
        
        .card {
            position: absolute;
            left: 0;
            top: 0;
            page-break-inside: avoid;
        }
        
        div[style*="position: sticky"] {
            position: relative !important;
        }
    }
</style>
@endsection