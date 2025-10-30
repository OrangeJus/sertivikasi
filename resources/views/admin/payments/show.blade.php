@extends('layouts.app')

@section('page-title', 'Detail Pembayaran')

@section('content')
<div style="max-width: 1000px; margin: 0 auto;">
    <!-- Breadcrumb -->
    <div style="margin-bottom: 30px;">
        <a href="{{ route('admin.payments.index') }}" style="color: #667eea; text-decoration: none; font-size: 14px; display: inline-flex; align-items: center; gap: 5px;">
            <svg style="width: 16px; height: 16px; fill: #667eea;" viewBox="0 0 24 24">
                <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/>
            </svg>
            Kembali ke Kelola Pembayaran
        </a>
    </div>

    <!-- Success Message -->
    @if (session('success'))
        <div class="alert alert-success" style="margin-bottom: 25px;">
            {{ session('success') }}
        </div>
    @endif

    <div style="display: grid; grid-template-columns: 1fr; gap: 25px;">
        <!-- Payment Info -->
        <div class="card">
            <div style="padding-bottom: 20px; margin-bottom: 20px; border-bottom: 2px solid #f0f0f0; display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h3 style="font-size: 20px; font-weight: 600; margin-bottom: 5px;">Detail Pembayaran</h3>
                    <p style="color: #999; font-size: 13px;">ID Pembayaran: #{{ $payment->id }}</p>
                </div>
                @if($payment->payment_status === 'pending')
                    <span style="background: #fff3cd; color: #856404; padding: 8px 16px; border-radius: 8px; font-size: 13px; font-weight: 600;">Pending</span>
                @elseif($payment->payment_status === 'paid')
                    <span style="background: #d4edda; color: #155724; padding: 8px 16px; border-radius: 8px; font-size: 13px; font-weight: 600;">Lunas</span>
                @else
                    <span style="background: #f8d7da; color: #721c24; padding: 8px 16px; border-radius: 8px; font-size: 13px; font-weight: 600;">Dibatalkan</span>
                @endif
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
                <div>
                    <p style="color: #999; font-size: 13px; margin-bottom: 5px;">Jumlah Pembayaran</p>
                    <p style="color: #333; font-size: 24px; font-weight: 700;">Rp {{ number_format($payment->amount, 0, ',', '.') }}</p>
                </div>

                <div>
                    <p style="color: #999; font-size: 13px; margin-bottom: 5px;">Metode Pembayaran</p>
                    <p style="color: #333; font-size: 18px; font-weight: 600;">
                        @if($payment->payment_method === 'transfer')
                            <span style="background: #e3f2fd; color: #1976d2; padding: 5px 12px; border-radius: 5px; font-size: 14px;">Transfer Bank</span>
                        @else
                            <span style="background: #e8f5e9; color: #388e3c; padding: 5px 12px; border-radius: 5px; font-size: 14px;">Cash</span>
                        @endif
                    </p>
                </div>

                <div>
                    <p style="color: #999; font-size: 13px; margin-bottom: 5px;">Tanggal Pembayaran</p>
                    <p style="color: #333; font-size: 16px; font-weight: 600;">
                        @if($payment->payment_date)
                            {{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y, H:i') }}
                        @else
                            <span style="color: #999;">Belum dibayar</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <!-- User Info -->
        <div class="card">
            <h4 style="font-size: 18px; font-weight: 600; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 2px solid #f0f0f0;">Informasi Penyewa</h4>
            
            <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 20px;">
                <div style="width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 24px;">
                    {{ substr($payment->rental->user->name, 0, 1) }}
                </div>
                <div>
                    <p style="color: #333; font-size: 18px; font-weight: 600; margin-bottom: 3px;">{{ $payment->rental->user->name }}</p>
                    <p style="color: #666; font-size: 14px;">{{ $payment->rental->user->email }}</p>
                </div>
            </div>
        </div>

        <!-- Rental Info -->
        <div class="card">
            <h4 style="font-size: 18px; font-weight: 600; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 2px solid #f0f0f0;">Informasi Penyewaan</h4>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
                <div>
                    <p style="color: #999; font-size: 13px; margin-bottom: 5px;">Genset</p>
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <div style="width: 40px; height: 40px; border-radius: 8px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center;">
                            <svg style="width: 24px; height: 24px; fill: white;" viewBox="0 0 24 24">
                                <path d="M13 2L3 14h8l-2 8 10-12h-8l2-8z"/>
                            </svg>
                        </div>
                        <p style="color: #333; font-size: 16px; font-weight: 600;">{{ $payment->rental->genset->nama_genset }}</p>
                    </div>
                </div>

                <div>
                    <p style="color: #999; font-size: 13px; margin-bottom: 5px;">Tanggal Mulai</p>
                    <p style="color: #333; font-size: 16px; font-weight: 600;">{{ \Carbon\Carbon::parse($payment->rental->tanggal_mulai)->format('d M Y') }}</p>
                </div>

                <div>
                    <p style="color: #999; font-size: 13px; margin-bottom: 5px;">Tanggal Selesai</p>
                    <p style="color: #333; font-size: 16px; font-weight: 600;">{{ \Carbon\Carbon::parse($payment->rental->tanggal_selesai)->format('d M Y') }}</p>
                </div>

                <div>
                    <p style="color: #999; font-size: 13px; margin-bottom: 5px;">Status Rental</p>
                    <p>
                        @if($payment->rental->status === 'pending')
                            <span style="background: #fff3cd; color: #856404; padding: 5px 12px; border-radius: 5px; font-size: 13px; font-weight: 600;">Pending</span>
                        @elseif($payment->rental->status === 'active')
                            <span style="background: #d4edda; color: #155724; padding: 5px 12px; border-radius: 5px; font-size: 13px; font-weight: 600;">Aktif</span>
                        @elseif($payment->rental->status === 'selesai')
                            <span style="background: #d1ecf1; color: #0c5460; padding: 5px 12px; border-radius: 5px; font-size: 13px; font-weight: 600;">Selesai</span>
                        @else
                            <span style="background: #f8d7da; color: #721c24; padding: 5px 12px; border-radius: 5px; font-size: 13px; font-weight: 600;">Dibatalkan</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <!-- Payment Proof -->
        @if($payment->payment_proof)
        <div class="card">
            <h4 style="font-size: 18px; font-weight: 600; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 2px solid #f0f0f0;">Bukti Pembayaran</h4>
            
            <div style="text-align: center;">
                <img src="{{ asset('storage/' . $payment->payment_proof) }}" alt="Bukti Pembayaran" style="max-width: 100%; max-height: 500px; border-radius: 8px; border: 2px solid #e0e0e0;">
                <p style="margin-top: 15px;">
                    <a href="{{ asset('storage/' . $payment->payment_proof) }}" target="_blank" style="color: #667eea; text-decoration: none; font-weight: 600;">
                        <svg style="width: 18px; height: 18px; fill: #667eea; display: inline-block; vertical-align: middle; margin-right: 5px;" viewBox="0 0 24 24">
                            <path d="M19 19H5V5h7V3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2v-7h-2v7zM14 3v2h3.59l-9.83 9.83 1.41 1.41L19 6.41V10h2V3h-7z"/>
                        </svg>
                        Lihat Gambar Full
                    </a>
                </p>
            </div>
        </div>
        @endif

        <!-- Action Buttons -->
        @if($payment->payment_status === 'pending')
        <div class="card" style="background: #f8f9fa;">
            <h4 style="font-size: 18px; font-weight: 600; margin-bottom: 20px;">Tindakan</h4>
            
            <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                <form method="POST" action="{{ route('admin.payments.update', $payment->id) }}" style="flex: 1; min-width: 200px;">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="payment_status" value="paid">
                    <button type="submit" onclick="return confirm('Konfirmasi pembayaran ini sebagai LUNAS?')" style="width: 100%; padding: 15px; background: #28a745; color: white; border: none; border-radius: 8px; font-size: 16px; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 10px;">
                        <svg style="width: 20px; height: 20px; fill: white;" viewBox="0 0 24 24">
                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                        </svg>
                        Konfirmasi Pembayaran
                    </button>
                </form>

                <form method="POST" action="{{ route('admin.payments.update', $payment->id) }}" style="flex: 1; min-width: 200px;">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="payment_status" value="cancelled">
                    <button type="submit" onclick="return confirm('Batalkan pembayaran ini?')" style="width: 100%; padding: 15px; background: #dc3545; color: white; border: none; border-radius: 8px; font-size: 16px; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 10px;">
                        <svg style="width: 20px; height: 20px; fill: white;" viewBox="0 0 24 24">
                            <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                        </svg>
                        Batalkan Pembayaran
                    </button>
                </form>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection