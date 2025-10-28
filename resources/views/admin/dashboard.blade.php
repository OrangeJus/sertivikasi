@extends('layouts.app')

@section('page-title', 'Dashboard Admin')

@section('content')
<div style="margin-bottom: 30px;">
    <h2 style="font-size: 28px; font-weight: 600; margin-bottom: 10px;">Selamat Datang, {{ Auth::user()->name }}!</h2>
    <p style="color: #666; font-size: 14px;">Berikut adalah ringkasan sistem penyewaan genset</p>
</div>

<div class="card-grid">
    <!-- Total User -->
    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-value">156</div>
                <div class="card-label">Total User</div>
            </div>
            <div class="card-icon blue">
                <svg viewBox="0 0 24 24">
                    <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Genset Tersedia -->
    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-value">24</div>
                <div class="card-label">Genset Tersedia</div>
            </div>
            <div class="card-icon green">
                <svg viewBox="0 0 24 24">
                    <path d="M13 2L3 14h8l-2 8 10-12h-8l2-8z"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Penyewaan Aktif -->
    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-value">12</div>
                <div class="card-label">Penyewaan Aktif</div>
            </div>
            <div class="card-icon orange">
                <svg viewBox="0 0 24 24">
                    <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="card" style="margin-top: 30px;">
    <h3 style="font-size: 20px; font-weight: 600; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 2px solid #f0f0f0;">Aktivitas Terbaru</h3>
    
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f8f9fa; text-align: left;">
                    <th style="padding: 12px; font-weight: 600; color: #333; font-size: 14px;">User</th>
                    <th style="padding: 12px; font-weight: 600; color: #333; font-size: 14px;">Genset</th>
                    <th style="padding: 12px; font-weight: 600; color: #333; font-size: 14px;">Tanggal</th>
                    <th style="padding: 12px; font-weight: 600; color: #333; font-size: 14px;">Status</th>
                </tr>
            </thead>
            <tbody>
                <tr style="border-bottom: 1px solid #e0e0e0;">
                    <td style="padding: 12px; color: #333; font-size: 14px;">John Doe</td>
                    <td style="padding: 12px; color: #666; font-size: 14px;">Genset 50 kVA</td>
                    <td style="padding: 12px; color: #666; font-size: 14px;">28 Okt 2024</td>
                    <td style="padding: 12px;"><span style="background: #d4edda; color: #155724; padding: 5px 12px; border-radius: 5px; font-size: 12px; font-weight: 600;">Aktif</span></td>
                </tr>
                <tr style="border-bottom: 1px solid #e0e0e0;">
                    <td style="padding: 12px; color: #333; font-size: 14px;">Jane Smith</td>
                    <td style="padding: 12px; color: #666; font-size: 14px;">Genset 100 kVA</td>
                    <td style="padding: 12px; color: #666; font-size: 14px;">27 Okt 2024</td>
                    <td style="padding: 12px;"><span style="background: #fff3cd; color: #856404; padding: 5px 12px; border-radius: 5px; font-size: 12px; font-weight: 600;">Pending</span></td>
                </tr>
                <tr style="border-bottom: 1px solid #e0e0e0;">
                    <td style="padding: 12px; color: #333; font-size: 14px;">Bob Johnson</td>
                    <td style="padding: 12px; color: #666; font-size: 14px;">Genset 75 kVA</td>
                    <td style="padding: 12px; color: #666; font-size: 14px;">26 Okt 2024</td>
                    <td style="padding: 12px;"><span style="background: #d1ecf1; color: #0c5460; padding: 5px 12px; border-radius: 5px; font-size: 12px; font-weight: 600;">Selesai</span></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection