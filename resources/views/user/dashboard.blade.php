@extends('layouts.app')

@section('page-title', 'Dashboard User')

@section('content')
<!-- Welcome Section -->
<div style="margin-bottom: 30px;">
    <h2 style="font-size: 28px; font-weight: 600; margin-bottom: 10px;">Selamat Datang, {{ Auth::user()->name }}!</h2>
    <p style="color: #666; font-size: 14px;">Pilih genset yang sesuai dengan kebutuhan Anda</p>
</div>

<!-- Filter Section -->
<div class="card" style="margin-bottom: 30px;">
    <div style="display: flex; align-items: center; gap: 15px; flex-wrap: wrap;">
        <div style="flex: 1; min-width: 200px;">
            <input 
                type="text" 
                placeholder="Cari genset..." 
                style="width: 100%; padding: 12px 15px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px;"
            >
        </div>
        <div style="min-width: 150px;">
            <select style="width: 100%; padding: 12px 15px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px; background: white; cursor: pointer;">
                <option>Semua Kapasitas</option>
                <option>50 kVA</option>
                <option>75 kVA</option>
                <option>100 kVA</option>
                <option>150 kVA</option>
                <option>200 kVA</option>
                <option>250 kVA</option>
            </select>
        </div>
        <div style="min-width: 150px;">
            <select style="width: 100%; padding: 12px 15px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px; background: white; cursor: pointer;">
                <option>Semua Status</option>
                <option>Tersedia</option>
                <option>Disewa</option>
            </select>
        </div>
    </div>
</div>

<!-- Genset Grid -->
<div class="genset-grid">
    <!-- Genset 1 -->
    <div class="genset-card">
        <div class="genset-image">
            <svg viewBox="0 0 24 24">
                <path d="M13 2L3 14h8l-2 8 10-12h-8l2-8z"/>
            </svg>
        </div>
        <div class="genset-body">
            <h3 class="genset-title">Genset 50 kVA</h3>
            <div class="genset-specs">
                <div class="spec-item">
                    <svg viewBox="0 0 24 24">
                        <path d="M13 2L3 14h8l-2 8 10-12h-8l2-8z"/>
                    </svg>
                    <span>Kapasitas: 50 kVA</span>
                </div>
                <div class="spec-item">
                    <svg viewBox="0 0 24 24">
                        <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/>
                    </svg>
                    <span>Bahan Bakar: Solar</span>
                </div>
                <div class="spec-item">
                    <svg viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                    </svg>
                    <span><strong style="color: #28a745;">Tersedia</strong></span>
                </div>
                <div class="spec-item">
                    <svg viewBox="0 0 24 24">
                        <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/>
                    </svg>
                    <span>Minimal sewa: 1 hari</span>
                </div>
            </div>
            <div class="genset-price">
                Rp 750.000
                <small>/hari</small>
            </div>
            <button class="btn-rent">Sewa Sekarang</button>
        </div>
    </div>

    <!-- Genset 2 -->
    <div class="genset-card">
        <div class="genset-image">
            <svg viewBox="0 0 24 24">
                <path d="M13 2L3 14h8l-2 8 10-12h-8l2-8z"/>
            </svg>
        </div>
        <div class="genset-body">
            <h3 class="genset-title">Genset 75 kVA</h3>
            <div class="genset-specs">
                <div class="spec-item">
                    <svg viewBox="0 0 24 24">
                        <path d="M13 2L3 14h8l-2 8 10-12h-8l2-8z"/>
                    </svg>
                    <span>Kapasitas: 75 kVA</span>
                </div>
                <div class="spec-item">
                    <svg viewBox="0 0 24 24">
                        <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/>
                    </svg>
                    <span>Bahan Bakar: Solar</span>
                </div>
                <div class="spec-item">
                    <svg viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                    </svg>
                    <span><strong style="color: #28a745;">Tersedia</strong></span>
                </div>
                <div class="spec-item">
                    <svg viewBox="0 0 24 24">
                        <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/>
                    </svg>
                    <span>Minimal sewa: 1 hari</span>
                </div>
            </div>
            <div class="genset-price">
                Rp 1.200.000
                <small>/hari</small>
            </div>
            <button class="btn-rent">Sewa Sekarang</button>
        </div>
    </div>

    <!-- Genset 3 -->
    <div class="genset-card">
        <div class="genset-image">
            <svg viewBox="0 0 24 24">
                <path d="M13 2L3 14h8l-2 8 10-12h-8l2-8z"/>
            </svg>
        </div>
        <div class="genset-body">
            <h3 class="genset-title">Genset 100 kVA</h3>
            <div class="genset-specs">
                <div class="spec-item">
                    <svg viewBox="0 0 24 24">
                        <path d="M13 2L3 14h8l-2 8 10-12h-8l2-8z"/>
                    </svg>
                    <span>Kapasitas: 100 kVA</span>
                </div>
                <div class="spec-item">
                    <svg viewBox="0 0 24 24">
                        <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/>
                    </svg>
                    <span>Bahan Bakar: Solar</span>
                </div>
                <div class="spec-item">
                    <svg viewBox="0 0 24 24">
                        <path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"/>
                    </svg>
                    <span><strong style="color: #dc3545;">Disewa</strong></span>
                </div>
                <div class="spec-item">
                    <svg viewBox="0 0 24 24">
                        <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/>
                    </svg>
                    <span>Minimal sewa: 1 hari</span>
                </div>
            </div>
            <div class="genset-price">
                Rp 1.500.000
                <small>/hari</small>
            </div>
            <button class="btn-rent" disabled style="background: #ccc; cursor: not-allowed;">Tidak Tersedia</button>
        </div>
    </div>

    <!-- Genset 4 -->
    <div class="genset-card">
        <div class="genset-image">
            <svg viewBox="0 0 24 24">
                <path d="M13 2L3 14h8l-2 8 10-12h-8l2-8z"/>
            </svg>
        </div>
        <div class="genset-body">
            <h3 class="genset-title">Genset 150 kVA</h3>
            <div class="genset-specs">
                <div class="spec-item">
                    <svg viewBox="0 0 24 24">
                        <path d="M13 2L3 14h8l-2 8 10-12h-8l2-8z"/>
                    </svg>
                    <span>Kapasitas: 150 kVA</span>
                </div>
                <div class="spec-item">
                    <svg viewBox="0 0 24 24">
                        <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/>
                    </svg>
                    <span>Bahan Bakar: Solar</span>
                </div>
                <div class="spec-item">
                    <svg viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                    </svg>
                    <span><strong style="color: #28a745;">Tersedia</strong></span>
                </div>
                <div class="spec-item">
                    <svg viewBox="0 0 24 24">
                        <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/>
                    </svg>
                    <span>Minimal sewa: 1 hari</span>
                </div>
            </div>
            <div class="genset-price">
                Rp 2.000.000
                <small>/hari</small>
            </div>
            <button class="btn-rent">Sewa Sekarang</button>
        </div>
    </div>

    <!-- Genset 5 -->
    <div class="genset-card">
        <div class="genset-image">
            <svg viewBox="0 0 24 24">
                <path d="M13 2L3 14h8l-2 8 10-12h-8l2-8z"/>
            </svg>
        </div>
        <div class="genset-body">
            <h3 class="genset-title">Genset 200 kVA</h3>
            <div class="genset-specs">
                <div class="spec-item">
                    <svg viewBox="0 0 24 24">
                        <path d="M13 2L3 14h8l-2 8 10-12h-8l2-8z"/>
                    </svg>
                    <span>Kapasitas: 200 kVA</span>
                </div>
                <div class="spec-item">
                    <svg viewBox="0 0 24 24">
                        <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/>
                    </svg>
                    <span>Bahan Bakar: Solar</span>
                </div>
                <div class="spec-item">
                    <svg viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                    </svg>
                    <span><strong style="color: #28a745;">Tersedia</strong></span>
                </div>
                <div class="spec-item">
                    <svg viewBox="0 0 24 24">
                        <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/>
                    </svg>
                    <span>Minimal sewa: 1 hari</span>
                </div>
            </div>
            <div class="genset-price">
                Rp 2.500.000
                <small>/hari</small>
            </div>
            <button class="btn-rent">Sewa Sekarang</button>
        </div>
    </div>

    <!-- Genset 6 -->
    <div class="genset-card">
        <div class="genset-image">
            <svg viewBox="0 0 24 24">
                <path d="M13 2L3 14h8l-2 8 10-12h-8l2-8z"/>
            </svg>
        </div>
        <div class="genset-body">
            <h3 class="genset-title">Genset 250 kVA</h3>
            <div class="genset-specs">
                <div class="spec-item">
                    <svg viewBox="0 0 24 24">
                        <path d="M13 2L3 14h8l-2 8 10-12h-8l2-8z"/>
                    </svg>
                    <span>Kapasitas: 250 kVA</span>
                </div>
                <div class="spec-item">
                    <svg viewBox="0 0 24 24">
                        <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/>
                    </svg>
                    <span>Bahan Bakar: Solar</span>
                </div>
                <div class="spec-item">
                    <svg viewBox="0 0 24 24">
                        <path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"/>
                    </svg>
                    <span><strong style="color: #dc3545;">Disewa</strong></span>
                </div>
                <div class="spec-item">
                    <svg viewBox="0 0 24 24">
                        <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/>
                    </svg>
                    <span>Minimal sewa: 1 hari</span>
                </div>
            </div>
            <div class="genset-price">
                Rp 3.000.000
                <small>/hari</small>
            </div>
            <button class="btn-rent" disabled style="background: #ccc; cursor: not-allowed;">Tidak Tersedia</button>
        </div>
    </div>
</div>

<!-- My Rentals Section -->
<div class="card" style="margin-top: 40px;">
    <h3 style="font-size: 20px; font-weight: 600; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 2px solid #f0f0f0;">Riwayat Penyewaan Saya</h3>
    
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f8f9fa; text-align: left;">
                    <th style="padding: 12px; font-weight: 600; color: #333; font-size: 14px;">Genset</th>
                    <th style="padding: 12px; font-weight: 600; color: #333; font-size: 14px;">Tanggal Sewa</th>
                    <th style="padding: 12px; font-weight: 600; color: #333; font-size: 14px;">Durasi</th>
                    <th style="padding: 12px; font-weight: 600; color: #333; font-size: 14px;">Total</th>
                    <th style="padding: 12px; font-weight: 600; color: #333; font-size: 14px;">Status</th>
                    <th style="padding: 12px; font-weight: 600; color: #333; font-size: 14px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr style="border-bottom: 1px solid #e0e0e0;">
                    <td style="padding: 12px; color: #333; font-size: 14px; font-weight: 500;">Genset 50 kVA</td>
                    <td style="padding: 12px; color: #666; font-size: 14px;">20 Okt 2024</td>
                    <td style="padding: 12px; color: #666; font-size: 14px;">5 hari</td>
                    <td style="padding: 12px; color: #333; font-size: 14px; font-weight: 600;">Rp 3.750.000</td>
                    <td style="padding: 12px;"><span style="background: #d4edda; color: #155724; padding: 5px 12px; border-radius: 5px; font-size: 12px; font-weight: 600;">Aktif</span></td>
                    <td style="padding: 12px;">
                        <button style="padding: 6px 12px; background: #667eea; color: white; border: none; border-radius: 5px; font-size: 12px; cursor: pointer;">Detail</button>
                    </td>
                </tr>
                <tr style="border-bottom: 1px solid #e0e0e0;">
                    <td style="padding: 12px; color: #333; font-size: 14px; font-weight: 500;">Genset 100 kVA</td>
                    <td style="padding: 12px; color: #666; font-size: 14px;">10 Okt 2024</td>
                    <td style="padding: 12px; color: #666; font-size: 14px;">3 hari</td>
                    <td style="padding: 12px; color: #333; font-size: 14px; font-weight: 600;">Rp 4.500.000</td>
                    <td style="padding: 12px;"><span style="background: #d1ecf1; color: #0c5460; padding: 5px 12px; border-radius: 5px; font-size: 12px; font-weight: 600;">Selesai</span></td>
                    <td style="padding: 12px;">
                        <button style="padding: 6px 12px; background: #667eea; color: white; border: none; border-radius: 5px; font-size: 12px; cursor: pointer;">Detail</button>
                    </td>
                </tr>
                <tr style="border-bottom: 1px solid #e0e0e0;">
                    <td style="padding: 12px; color: #333; font-size: 14px; font-weight: 500;">Genset 75 kVA</td>
                    <td style="padding: 12px; color: #666; font-size: 14px;">01 Okt 2024</td>
                    <td style="padding: 12px; color: #666; font-size: 14px;">2 hari</td>
                    <td style="padding: 12px; color: #333; font-size: 14px; font-weight: 600;">Rp 2.400.000</td>
                    <td style="padding: 12px;"><span style="background: #d1ecf1; color: #0c5460; padding: 5px 12px; border-radius: 5px; font-size: 12px; font-weight: 600;">Selesai</span></td>
                    <td style="padding: 12px;">
                        <button style="padding: 6px 12px; background: #667eea; color: white; border: none; border-radius: 5px; font-size: 12px; cursor: pointer;">Detail</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection