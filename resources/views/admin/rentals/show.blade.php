@extends('layouts.app')

@section('page-title', 'Detail Penyewaan')

@section('content')
<div style="max-width: 1200px; margin: 0 auto;">

    <div style="margin-bottom: 30px;">
        <a href="{{ route('admin.rentals.index') }}" style="color: #667eea; text-decoration: none; font-size: 14px; display: inline-flex; align-items: center; gap: 5px;">
            <svg style="width: 16px; height: 16px; fill: #667eea;" viewBox="0 0 24 24">
                <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/>
            </svg>
            Kembali ke Kelola Penyewaan
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success" style="margin-bottom: 25px;">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger" style="margin-bottom: 25px;">
            {{ session('error') }}
        </div>
    @endif

    @if($rental->isOverdue() && $rental->status === 'active' && !$rental->isPenaltyPaidAndVerified())
        <div style="background: #fff3cd; border-left: 4px solid #ffc107; padding: 20px; border-radius: 8px; margin-bottom: 25px;">
            <div style="display: flex; align-items: start; gap: 15px;">
                <svg style="width: 24px; height: 24px; fill: #856404; flex-shrink: 0;" viewBox="0 0 24 24">
                    <path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"/>
                </svg>
                <div style="flex: 1;">
                    <h4 style="color: #856404; font-size: 16px; font-weight: 600; margin-bottom: 8px;">⚠️ Penyewaan Terlambat!</h4>
                    <p style="color: #856404; font-size: 14px; margin-bottom: 8px;">
                        Rental ini sudah melewati deadline <strong>{{ $rental->getOverdueDays() }} hari</strong>.
                        Denda keterlambatan: <strong>Rp {{ number_format($rental->calculatePenaltyAmount(), 0, ',', '.') }}</strong>
                    </p>
                    <p style="color: #856404; font-size: 13px; margin: 0;">
                        User harus membayar denda terlebih dahulu sebelum dapat mengajukan pengembalian.
                    </p>
                </div>
            </div>
        </div>
    @endif

    @if($rental->isPenaltyPaidAndVerified())
        <div style="background: #d4edda; border-left: 4px solid #28a745; padding: 20px; border-radius: 8px; margin-bottom: 25px;">
            <div style="display: flex; align-items: start; gap: 15px;">
                <svg style="width: 24px; height: 24px; fill: #155724; flex-shrink: 0;" viewBox="0 0 24 24">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                </svg>
                <div style="flex: 1;">
                    <h4 style="color: #155724; font-size: 16px; font-weight: 600; margin-bottom: 8px;">✅ Denda Sudah Terverifikasi</h4>
                    <p style="color: #155724; font-size: 14px; margin: 0;">
                        Pembayaran denda sebesar <strong>Rp {{ number_format($rental->denda, 0, ',', '.') }}</strong> sudah diverifikasi.
                        User sekarang dapat mengajukan pengembalian.
                    </p>
                </div>
            </div>
        </div>
    @endif

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 25px; margin-bottom: 30px;">
        
        <div>
            <div class="card" style="margin-bottom: 25px;">
                <h3 style="font-size: 20px; font-weight: 600; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 2px solid #f0f0f0;">
                    Detail Penyewaan #{{ $rental->id }}
                </h3>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <div>
                        <p style="color: #999; font-size: 13px; margin-bottom: 5px;">Status Rental</p>
                        @if($rental->status === 'pending')
                            <span style="background: #fff3cd; color: #856404; padding: 6px 14px; border-radius: 6px; font-size: 13px; font-weight: 600;">Pending</span>
                        @elseif($rental->status === 'active')
                            <span style="background: #d4edda; color: #155724; padding: 6px 14px; border-radius: 6px; font-size: 13px; font-weight: 600;">Aktif</span>
                        @elseif($rental->status === 'selesai')
                            <span style="background: #d1ecf1; color: #0c5460; padding: 6px 14px; border-radius: 6px; font-size: 13px; font-weight: 600;">Selesai</span>
                        @else
                            <span style="background: #f8d7da; color: #721c24; padding: 6px 14px; border-radius: 6px; font-size: 13px; font-weight: 600;">Dibatalkan</span>
                        @endif
                    </div>
                    <div>
                        <p style="color: #999; font-size: 13px; margin-bottom: 5px;">Status Pengembalian</p>
                        @if($rental->status_pengembalian === 'diminta')
                            <span style="background: #fff3cd; color: #856404; padding: 6px 14px; border-radius: 6px; font-size: 13px; font-weight: 600;">📤 Diminta</span>
                        @elseif($rental->status_pengembalian === 'disetujui')
                            <span style="background: #d4edda; color: #155724; padding: 6px 14px; border-radius: 6px; font-size: 13px; font-weight: 600;">✅ Disetujui</span>
                        @elseif($rental->status_pengembalian === 'ditolak')
                            <span style="background: #f8d7da; color: #721c24; padding: 6px 14px; border-radius: 6px; font-size: 13px; font-weight: 600;">❌ Ditolak</span>
                        @else
                            <span style="color: #999; font-size: 13px;">Belum ada request</span>
                        @endif
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div>
                        <p style="color: #999; font-size: 13px; margin-bottom: 5px;">Tanggal Mulai</p>
                        <p style="color: #333; font-size: 16px; font-weight: 600; margin: 0;">
                            {{ \Carbon\Carbon::parse($rental->tanggal_mulai)->format('d M Y') }}
                        </p>
                    </div>
                    <div>
                        <p style="color: #999; font-size: 13px; margin-bottom: 5px;">Tanggal Selesai</p>
                        <p style="color: #333; font-size: 16px; font-weight: 600; margin: 0;">
                            {{ \Carbon\Carbon::parse($rental->tanggal_selesai)->format('d M Y') }}
                        </p>
                    </div>
                    <div>
                        <p style="color: #999; font-size: 13px; margin-bottom: 5px;">Durasi</p>
                        <p style="color: #333; font-size: 16px; font-weight: 600; margin: 0;">
                            {{ $rental->durasi }} hari
                        </p>
                    </div>
                    <div>
                        <p style="color: #999; font-size: 13px; margin-bottom: 5px;">Total Harga Sewa</p>
                        <p style="color: #333; font-size: 16px; font-weight: 600; margin: 0;">
                            Rp {{ number_format($rental->total_harga, 0, ',', '.') }}
                        </p>
                    </div>
                    @if($rental->isOverdue())
                        <div>
                            <p style="color: #999; font-size: 13px; margin-bottom: 5px;">Keterlambatan</p>
                            <p style="color: #dc3545; font-size: 16px; font-weight: 600; margin: 0;">
                                {{ $rental->getOverdueDays() }} hari
                            </p>
                        </div>
                        <div>
                            <p style="color: #999; font-size: 13px; margin-bottom: 5px;">Denda</p>
                            <p style="color: #dc3545; font-size: 16px; font-weight: 600; margin: 0;">
                                Rp {{ number_format($rental->calculatePenaltyAmount(), 0, ',', '.') }}
                            </p>
                        </div>
                    @endif
                    @if($rental->denda > 0 && $rental->isPenaltyPaidAndVerified())
                        <div>
                            <p style="color: #999; font-size: 13px; margin-bottom: 5px;">Denda Terverifikasi</p>
                            <p style="color: #28a745; font-size: 16px; font-weight: 600; margin: 0;">
                                Rp {{ number_format($rental->denda, 0, ',', '.') }}
                            </p>
                        </div>
                        <div>
                            <p style="color: #999; font-size: 13px; margin-bottom: 5px;">Total Pembayaran</p>
                            <p style="color: #333; font-size: 16px; font-weight: 600; margin: 0;">
                                Rp {{ number_format($rental->total_pembayaran, 0, ',', '.') }}
                            </p>
                        </div>
                    @endif
                </div>
                
                @if($rental->catatan)
                    <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #f0f0f0;">
                        <p style="color: #999; font-size: 13px; margin-bottom: 5px;">Catatan User:</p>
                        <p style="color: #666; font-size: 14px; margin: 0; line-height: 1.6;">
                            {{ $rental->catatan }}
                        </p>
                    </div>
                @endif
            </div>

            @if($rental->payment)
                <div class="card" style="margin-bottom: 25px;">
                    <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 2px solid #f0f0f0;">
                        💳 Pembayaran Sewa
                    </h3>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                        <div>
                            <p style="color: #999; font-size: 13px; margin-bottom: 5px;">Jumlah Pembayaran</p>
                            <p style="color: #333; font-size: 18px; font-weight: 700; margin: 0;">
                                Rp {{ number_format($rental->payment->amount, 0, ',', '.') }}
                            </p>
                        </div>
                        <div>
                            <p style="color: #999; font-size: 13px; margin-bottom: 5px;">Metode Pembayaran</p>
                            <p style="color: #333; font-size: 14px; font-weight: 600; margin: 0; text-transform: capitalize;">
                                {{ $rental->payment->payment_method }}
                            </p>
                        </div>
                        <div>
                            <p style="color: #999; font-size: 13px; margin-bottom: 5px;">Tanggal Pembayaran</p>
                            <p style="color: #333; font-size: 14px; font-weight: 600; margin: 0;">
                                {{ \Carbon\Carbon::parse($rental->payment->payment_date)->format('d M Y, H:i') }}
                            </p>
                        </div>
                        <div>
                            <p style="color: #999; font-size: 13px; margin-bottom: 5px;">Status Pembayaran</p>
                            @if($rental->payment->payment_status === 'pending')
                                <span style="background: #fff3cd; color: #856404; padding: 6px 12px; border-radius: 5px; font-size: 12px; font-weight: 600;">Pending</span>
                            @elseif($rental->payment->payment_status === 'paid')
                                <span style="background: #d4edda; color: #155724; padding: 6px 12px; border-radius: 5px; font-size: 12px; font-weight: 600;">Lunas</span>
                            @else
                                <span style="background: #f8d7da; color: #721c24; padding: 6px 12px; border-radius: 5px; font-size: 12px; font-weight: 600;">Dibatalkan</span>
                            @endif
                        </div>
                    </div>

                    @if($rental->payment->payment_proof)
                        <div>
                            <p style="color: #999; font-size: 13px; margin-bottom: 10px;">Bukti Transfer:</p>
                            <div style="text-align: center; background: #f8f9fa; padding: 15px; border-radius: 8px;">
                                <img src="{{ asset('storage/' . $rental->payment->payment_proof) }}" alt="Bukti Transfer" style="max-width: 100%; max-height: 400px; border-radius: 8px; border: 2px solid #e0e0e0;">
                                <p style="margin-top: 10px;">
                                    <a href="{{ asset('storage/' . $rental->payment->payment_proof) }}" target="_blank" style="color: #667eea; text-decoration: none; font-weight: 600; font-size: 14px;">
                                        <svg style="width: 16px; height: 16px; fill: #667eea; display: inline-block; vertical-align: middle; margin-right: 5px;" viewBox="0 0 24 24">
                                            <path d="M19 19H5V5h7V3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2v-7h-2v7zM14 3v2h3.59l-9.83 9.83 1.41 1.41L19 6.41V10h2V3h-7z"/>
                                        </svg>
                                        Lihat Ukuran Penuh
                                    </a>
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
            @endif

            @if($rental->pendingPenaltyPayment)
                <div class="card" style="margin-bottom: 25px; border: 2px solid #ffc107;">
                    <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 2px solid #f0f0f0; color: #856404;">
                        💰 Pembayaran Denda Pending
                    </h3>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                        <div>
                            <p style="color: #999; font-size: 13px; margin-bottom: 5px;">Jumlah Denda</p>
                            <p style="color: #333; font-size: 18px; font-weight: 700; margin: 0;">
                                Rp {{ number_format($rental->pendingPenaltyPayment->amount, 0, ',', '.') }}
                            </p>
                        </div>
                        <div>
                            <p style="color: #999; font-size: 13px; margin-bottom: 5px;">Tanggal Upload</p>
                            <p style="color: #333; font-size: 14px; font-weight: 600; margin: 0;">
                                {{ \Carbon\Carbon::parse($rental->pendingPenaltyPayment->payment_date)->format('d M Y, H:i') }}
                            </p>
                        </div>
                    </div>
                    <div style="margin-bottom: 20px;">
                        <p style="color: #999; font-size: 13px; margin-bottom: 10px;">Bukti Transfer:</p>
                        <div style="text-align: center; background: #f8f9fa; padding: 15px; border-radius: 8px;">
                            <img src="{{ asset('storage/' . $rental->pendingPenaltyPayment->payment_proof) }}" alt="Bukti Transfer" style="max-width: 100%; max-height: 400px; border-radius: 8px; border: 2px solid #e0e0e0;">
                            <p style="margin-top: 10px;">
                                <a href="{{ asset('storage/' . $rental->pendingPenaltyPayment->payment_proof) }}" target="_blank" style="color: #667eea; text-decoration: none; font-weight: 600; font-size: 14px;">
                                    <svg style="width: 16px; height: 16px; fill: #667eea; display: inline-block; vertical-align: middle; margin-right: 5px;" viewBox="0 0 24 24">
                                        <path d="M19 19H5V5h7V3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2v-7h-2v7zM14 3v2h3.59l-9.83 9.83 1.41 1.41L19 6.41V10h2V3h-7z"/>
                                    </svg>
                                    Lihat Ukuran Penuh
                                </a>
                            </p>
                        </div>
                    </div>
                    <div style="display: flex; gap: 15px;">
                        <form method="POST" action="{{ route('admin.rentals.verify-penalty', $rental->id) }}" style="flex: 1;">
                            @csrf
                            <input type="hidden" name="action" value="approve">
                            <button type="submit" onclick="return confirm('Verifikasi pembayaran denda ini?')" style="width: 100%; padding: 12px; background: #28a745; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px;">
                                <svg style="width: 18px; height: 18px; fill: white;" viewBox="0 0 24 24">
                                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                                </svg>
                                Approve Pembayaran
                            </button>
                        </form>
                        <button type="button" onclick="document.getElementById('rejectPenaltyModal').style.display='flex'" style="flex: 1; padding: 12px; background: #dc3545; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px;">
                            <svg style="width: 18px; height: 18px; fill: white;" viewBox="0 0 24 24">
                                <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                            </svg>
                            Tolak Pembayaran
                        </button>
                    </div>
                </div>
            @endif

            @if($rental->isPenaltyPaidAndVerified())
                <div class="card" style="margin-bottom: 25px; border: 2px solid #28a745;">
                    <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 2px solid #f0f0f0; color: #155724;">
                        ✅ Denda Terverifikasi
                    </h3>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div>
                            <p style="color: #999; font-size: 13px; margin-bottom: 5px;">Jumlah Denda</p>
                            <p style="color: #28a745; font-size: 18px; font-weight: 700; margin: 0;">
                                Rp {{ number_format($rental->denda, 0, ',', '.') }}
                            </p>
                        </div>
                        <div>
                            <p style="color: #999; font-size: 13px; margin-bottom: 5px;">Hari Keterlambatan</p>
                            <p style="color: #333; font-size: 16px; font-weight: 600; margin: 0;">
                                {{ $rental->hari_keterlambatan }} hari
                            </p>
                        </div>
                        <div>
                            <p style="color: #999; font-size: 13px; margin-bottom: 5px;">Diverifikasi Oleh</p>
                            <p style="color: #333; font-size: 14px; font-weight: 600; margin: 0;">
                                {{ $rental->verifiedBy->name ?? '-' }}
                            </p>
                        </div>
                        <div>
                            <p style="color: #999; font-size: 13px; margin-bottom: 5px;">Tanggal Verifikasi</p>
                            <p style="color: #333; font-size: 14px; font-weight: 600; margin: 0;">
                                {{ $rental->denda_verified_at ? \Carbon\Carbon::parse($rental->denda_verified_at)->format('d M Y, H:i') : '-' }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            @if($rental->status_pengembalian === 'diminta')
                <div class="card" style="margin-bottom: 25px; border: 2px solid #17a2b8;">
                    <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 2px solid #f0f0f0; color: #0c5460;">
                        📤 Request Pengembalian
                    </h3>
                    <div style="background: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                        <p style="color: #999; font-size: 13px; margin-bottom: 5px;">Tanggal Request:</p>
                        <p style="color: #333; font-size: 14px; font-weight: 600; margin-bottom: 15px;">
                            {{ \Carbon\Carbon::parse($rental->tanggal_request_pengembalian)->format('d M Y, H:i') }}
                        </p>
                        <p style="color: #999; font-size: 13px; margin-bottom: 5px;">Catatan User:</p>
                        <p style="color: #333; font-size: 14px; margin: 0; line-height: 1.6;">
                            {{ $rental->catatan_pengembalian_user ?: 'Tidak ada catatan' }}
                        </p>
                    </div>
                    <div style="display: flex; gap: 15px;">
                        <button type="button" onclick="document.getElementById('approveReturnModal').style.display='flex'" style="flex: 1; padding: 12px; background: #28a745; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px;">
                            <svg style="width: 18px; height: 18px; fill: white;" viewBox="0 0 24 24">
                                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                            </svg>
                            Approve Pengembalian
                        </button>
                        <button type="button" onclick="document.getElementById('rejectReturnModal').style.display='flex'" style="flex: 1; padding: 12px; background: #dc3545; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px;">
                            <svg style="width: 18px; height: 18px; fill: white;" viewBox="0 0 24 24">
                                <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                            </svg>
                            Tolak Pengembalian
                        </button>
                    </div>
                </div>
            @endif

            @if($rental->status_pengembalian === 'disetujui')
                <div class="card" style="margin-bottom: 25px; background: #d4edda; border: 2px solid #28a745;">
                    <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 15px; color: #155724;">
                        ✅ Pengembalian Disetujui
                    </h3>
                    <p style="color: #155724; font-size: 14px; margin-bottom: 10px;">
                        <strong>Disetujui pada:</strong> {{ $rental->tanggal_pengembalian_aktual ? \Carbon\Carbon::parse($rental->tanggal_pengembalian_aktual)->format('d M Y, H:i') : '-' }}
                    </p>
                    @if($rental->catatan_pengembalian_admin)
                        <p style="color: #155724; font-size: 14px; margin: 0;">
                            <strong>Catatan Admin:</strong> {{ $rental->catatan_pengembalian_admin }}
                        </p>
                    @endif
                </div>
            @endif

            @if($rental->status_pengembalian === 'ditolak')
                <div class="card" style="margin-bottom: 25px; background: #f8d7da; border: 2px solid #dc3545;">
                    <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 15px; color: #721c24;">
                        ❌ Pengembalian Ditolak
                    </h3>
                    @if($rental->catatan_pengembalian_admin)
                        <p style="color: #721c24; font-size: 14px; margin: 0;">
                            <strong>Alasan:</strong> {{ $rental->catatan_pengembalian_admin }}
                        </p>
                    @endif
                </div>
            @endif

            @if($rental->status !== 'selesai' && $rental->status !== 'batal')
                <div class="card">
                    <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 2px solid #f0f0f0;">
                        🔄 Update Status Rental
                    </h3>
                    <form method="POST" action="{{ route('admin.rentals.update', $rental->id) }}">
                        @csrf
                        @method('PATCH')
                        
                        <div style="margin-bottom: 20px;">
                            <label style="display: block; margin-bottom: 10px; font-weight: 600; color: #333; font-size: 14px;">
                                Pilih Status Baru:
                            </label>
                            
                            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 12px;">
                                @if($rental->status === 'pending')
                                    <label style="cursor: pointer;">
                                        <input type="radio" name="status" value="active" required style="margin-right: 8px;">
                                        <span style="font-size: 14px; color: #155724;">✅ Aktifkan</span>
                                    </label>
                                    <label style="cursor: pointer;">
                                        <input type="radio" name="status" value="batal" required style="margin-right: 8px;">
                                        <span style="font-size: 14px; color: #721c24;">❌ Batalkan</span>
                                    </label>
                                @endif
                                
                                @if($rental->status === 'active')
                                    <label style="cursor: pointer;">
                                        <input type="radio" name="status" value="selesai" required style="margin-right: 8px;">
                                        <span style="font-size: 14px; color: #0c5460;">✔️ Selesaikan</span>
                                    </label>
                                    <label style="cursor: pointer;">
                                        <input type="radio" name="status" value="batal" required style="margin-right: 8px;">
                                        <span style="font-size: 14px; color: #721c24;">❌ Batalkan</span>
                                    </label>
                                @endif
                            </div>
                        </div>

                        @if($rental->status === 'active' && $rental->isOverdue() && !$rental->isPenaltyPaidAndVerified())
                            <div style="background: #fff3cd; padding: 12px 15px; border-radius: 6px; margin-bottom: 20px; border-left: 3px solid #ffc107;">
                                <p style="color: #856404; font-size: 13px; margin: 0;">
                                    ⚠️ <strong>Perhatian:</strong> Rental terlambat dan denda belum terverifikasi. Anda tidak dapat menyelesaikan rental ini sampai denda diverifikasi.
                                </p>
                            </div>
                        @endif

                        <button type="submit" onclick="return confirm('Yakin ingin mengubah status rental ini?')" style="width: 100%; padding: 12px 24px; background: #667eea; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; font-size: 14px;">
                            Update Status
                        </button>
                    </form>
                </div>
            @endif

        </div>

        <div>
            <div class="card" style="margin-bottom: 25px;">
                <h4 style="font-size: 16px; font-weight: 600; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 2px solid #f0f0f0;">Informasi Penyewa</h4>
                
                <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 20px;">
                    <div style="width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 24px;">
                        {{ substr($rental->user->name, 0, 1) }}
                    </div>
                    <div>
                        <p style="color: #333; font-size: 16px; font-weight: 600; margin-bottom: 3px;">{{ $rental->user->name }}</p>
                        <p style="color: #666; font-size: 14px; margin: 0;">{{ $rental->user->email }}</p>
                    </div>
                </div>

                <div style="background: #f8f9fa; padding: 12px; border-radius: 8px;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <svg style="width: 20px; height: 20px; fill: #667eea;" viewBox="0 0 24 24">
                            <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                        </svg>
                        <div style="flex: 1;">
                            <p style="color: #999; font-size: 12px; margin: 0;">Email</p>
                            <p style="color: #333; font-size: 14px; font-weight: 600; margin: 0; word-break: break-all;">{{ $rental->user->email }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card" style="margin-bottom: 25px;">
                <h4 style="font-size: 16px; font-weight: 600; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 2px solid #f0f0f0;">Informasi Genset</h4>
                
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 15px;">
                    <div style="width: 50px; height: 50px; border-radius: 10px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center;">
                        <svg style="width: 28px; height: 28px; fill: white;" viewBox="0 0 24 24">
                            <path d="M13 2L3 14h8l-2 8 10-12h-8l2-8z"/>
                        </svg>
                    </div>
                    <div>
                        <p style="color: #333; font-size: 16px; font-weight: 600; margin: 0;">{{ $rental->genset->nama_genset }}</p>
                    </div>
                </div>

                <div style="margin-bottom: 15px;">
                    <p style="color: #999; font-size: 12px; margin-bottom: 5px;">Kapasitas:</p>
                    <p style="color: #333; font-size: 14px; font-weight: 600; margin: 0;">{{ $rental->genset->kapasitas }}</p>
                </div>
                <div style="margin-bottom: 15px;">
                    <p style="color: #999; font-size: 12px; margin-bottom: 5px;">Harga Sewa per Hari:</p>
                    <p style="color: #333; font-size: 14px; font-weight: 600; margin: 0;">Rp {{ number_format($rental->genset->harga_sewa, 0, ',', '.') }}</p>
                </div>
                <div style="margin-bottom: 15px;">
                    <p style="color: #999; font-size: 12px; margin-bottom: 8px;">Kategori:</p>
                    <div style="display: flex; flex-wrap: wrap; gap: 6px;">
                        @forelse($rental->genset->categories as $cat)
                            <span style="background: #e3f2fd; color: #1976d2; padding: 5px 10px; border-radius: 5px; font-size: 12px; font-weight: 600;">
                                {{ $cat->nama_kategori }}
                            </span>
                        @empty
                            <span style="color: #999; font-size: 12px;">Tidak ada kategori</span>
                        @endforelse
                    </div>
                </div>
                <div>
                    <p style="color: #999; font-size: 12px; margin-bottom: 5px;">Status Genset:</p>
                    @if($rental->genset->status === 'tersedia')
                        <span style="background: #d4edda; color: #155724; padding: 6px 12px; border-radius: 5px; font-size: 12px; font-weight: 600;">Tersedia</span>
                    @elseif($rental->genset->status === 'disewa')
                        <span style="background: #fff3cd; color: #856404; padding: 6px 12px; border-radius: 5px; font-size: 12px; font-weight: 600;">Disewa</span>
                    @else
                        <span style="background: #f8d7da; color: #721c24; padding: 6px 12px; border-radius: 5px; font-size: 12px; font-weight: 600;">Rusak</span>
                    @endif
                </div>
            </div>

            <div class="card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                <h4 style="font-size: 16px; font-weight: 600; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 2px solid rgba(255,255,255,0.2);">Ringkasan Pembayaran</h4>
                
                <div style="margin-bottom: 15px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                        <span style="font-size: 14px; opacity: 0.9;">Biaya Sewa:</span>
                        <span style="font-size: 14px; font-weight: 600;">Rp {{ number_format($rental->total_harga, 0, ',', '.') }}</span>
                    </div>
                    
                    @if($rental->denda > 0)
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                            <span style="font-size: 14px; opacity: 0.9;">Denda:</span>
                            <span style="font-size: 14px; font-weight: 600;">Rp {{ number_format($rental->denda, 0, ',', '.') }}</span>
                        </div>
                    @endif
                </div>

                <div style="padding-top: 15px; border-top: 2px solid rgba(255,255,255,0.2);">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-size: 16px; font-weight: 600;">Total:</span>
                        <span style="font-size: 20px; font-weight: 700;">Rp {{ number_format($rental->total_pembayaran, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<div id="rejectPenaltyModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center;">
    <div style="background: white; border-radius: 12px; max-width: 500px; width: 90%; padding: 30px;">
        <h3 style="font-size: 20px; font-weight: 600; margin-bottom: 20px; color: #dc3545;">❌ Tolak Pembayaran Denda</h3>
        <form method="POST" action="{{ route('admin.rentals.verify-penalty', $rental->id) }}">
            @csrf
            <input type="hidden" name="action" value="reject">
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #333; font-size: 14px;">Alasan Penolakan <span style="color: #dc3545;">*</span></label>
                <textarea name="rejection_reason" rows="4" required style="width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px; font-family: inherit;" placeholder="Contoh: Bukti transfer tidak valid atau tidak jelas"></textarea>
            </div>
            <div style="display: flex; gap: 15px;">
                <button type="submit" style="flex: 1; padding: 12px; background: #dc3545; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">Tolak</button>
                <button type="button" onclick="document.getElementById('rejectPenaltyModal').style.display='none'" style="flex: 1; padding: 12px; background: #e0e0e0; color: #333; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">Batal</button>
            </div>
        </form>
    </div>
</div>

<div id="approveReturnModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center;">
    <div style="background: white; border-radius: 12px; max-width: 500px; width: 90%; padding: 30px;">
        <h3 style="font-size: 20px; font-weight: 600; margin-bottom: 20px; color: #28a745;">✅ Approve Pengembalian</h3>
        <form method="POST" action="{{ route('admin.rentals.approve-return', $rental->id) }}">
            @csrf
            <input type="hidden" name="action" value="approve">
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #333; font-size: 14px;">Catatan Admin (Opsional)</label>
                <textarea name="catatan_admin" rows="4" style="width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px; font-family: inherit;" placeholder="Contoh: Kondisi genset baik, tidak ada kerusakan"></textarea>
            </div>
            <div style="display: flex; gap: 15px;">
                <button type="submit" style="flex: 1; padding: 12px; background: #28a745; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">Approve</button>
                <button type="button" onclick="document.getElementById('approveReturnModal').style.display='none'" style="flex: 1; padding: 12px; background: #e0e0e0; color: #333; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">Batal</button>
            </div>
        </form>
    </div>
</div>

<div id="rejectReturnModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center;">
    <div style="background: white; border-radius: 12px; max-width: 500px; width: 90%; padding: 30px;">
        <h3 style="font-size: 20px; font-weight: 600; margin-bottom: 20px; color: #dc3545;">❌ Tolak Pengembalian</h3>
        <form method="POST" action="{{ route('admin.rentals.approve-return', $rental->id) }}">
            @csrf
            <input type="hidden" name="action" value="reject">
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #333; font-size: 14px;">Catatan Admin <span style="color: #dc3545;">*</span></label>
                <textarea name="catatan_admin" rows="4" required style="width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px; font-family: inherit;" placeholder="Contoh: Genset rusak, perlu perbaikan. User harus mengganti kerusakan"></textarea>
            </div>
            <div style="display: flex; gap: 15px;">
                <button type="submit" style="flex: 1; padding: 12px; background: #dc3545; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">Tolak</button>
                <button type="button" onclick="document.getElementById('rejectReturnModal').style.display='none'" style="flex: 1; padding: 12px; background: #e0e0e0; color: #333; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">Batal</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Close modal when clicking outside
    document.getElementById('rejectPenaltyModal')?.addEventListener('click', function(e) {
        if (e.target === this) this.style.display = 'none';
    });
    document.getElementById('approveReturnModal')?.addEventListener('click', function(e) {
        if (e.target === this) this.style.display = 'none';
    });
    document.getElementById('rejectReturnModal')?.addEventListener('click', function(e) {
        if (e.target === this) this.style.display = 'none';
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.getElementById('rejectPenaltyModal').style.display = 'none';
            document.getElementById('approveReturnModal').style.display = 'none';
            document.getElementById('rejectReturnModal').style.display = 'none';
        }
    });
</script>
@endsection