@extends('layouts.app')

@section('page-title', 'Bayar Denda')

@section('content')
    <div style="margin-bottom: 30px;">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
            <div>
                <h2 style="font-size: 28px; font-weight: 600; margin-bottom: 10px;">Pembayaran Denda Keterlambatan</h2>
                <p style="color: #666; font-size: 14px;">Upload bukti pembayaran denda untuk melanjutkan proses pengembalian</p>
            </div>
            <a href="{{ route('user.rentals.show', $rental->id) }}"
                style="padding: 12px 24px; background: #e9ecef; color: #495057; border-radius: 10px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 8px; transition: all 0.3s;"
                onmouseover="this.style.background='#dee2e6'" onmouseout="this.style.background='#e9ecef'">
                <svg style="width: 20px; height: 20px; fill: currentColor;" viewBox="0 0 24 24">
                    <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z" />
                </svg>
                Kembali
            </a>
        </div>
    </div>

    @if (session('error'))
        <div
            style="background: #f8d7da; color: #721c24; padding: 16px 20px; border-radius: 10px; margin-bottom: 25px; border-left: 4px solid #dc3545; display: flex; align-items: center; gap: 12px;">
            <svg style="width: 24px; height: 24px; fill: currentColor; flex-shrink: 0;" viewBox="0 0 24 24">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z" />
            </svg>
            <span style="font-weight: 500;">{{ session('error') }}</span>
        </div>
    @endif

    @if ($errors->any())
        <div
            style="background: #f8d7da; color: #721c24; padding: 16px 20px; border-radius: 10px; margin-bottom: 25px; border-left: 4px solid #dc3545;">
            <div style="display: flex; align-items: start; gap: 12px;">
                <svg style="width: 24px; height: 24px; fill: currentColor; flex-shrink: 0;" viewBox="0 0 24 24">
                    <path
                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z" />
                </svg>
                <div>
                    <strong style="display: block; margin-bottom: 8px;">Terdapat kesalahan:</strong>
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <div
        style="background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%); border-radius: 16px; padding: 24px 30px; margin-bottom: 30px; border-left: 6px solid #dc3545; box-shadow: 0 4px 12px rgba(220, 53, 69, 0.2);">
        <div style="display: flex; align-items: start; gap: 16px;">
            <div
                style="width: 56px; height: 56px; background: rgba(255, 255, 255, 0.4); backdrop-filter: blur(10px); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <svg style="width: 32px; height: 32px; fill: #721c24;" viewBox="0 0 24 24">
                    <path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z" />
                </svg>
            </div>
            <div style="flex: 1;">
                <h3 style="font-size: 18px; font-weight: 700; color: #721c24; margin-bottom: 8px;">⚠️ Genset Terlambat
                    Dikembalikan</h3>
                <p style="color: #721c24; font-size: 14px; margin: 0; opacity: 0.9;">
                    Anda terlambat mengembalikan genset. Silakan bayar denda terlebih dahulu sebelum mengajukan request
                    pengembalian.
                </p>
            </div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 400px; gap: 30px; align-items: start;">
        <div>
            <div class="card" style="margin-bottom: 30px;">
                <h3
                    style="font-size: 20px; font-weight: 700; margin-bottom: 20px; color: #333; display: flex; align-items: center; gap: 10px; padding-bottom: 16px; border-bottom: 2px solid #f0f0f0;">
                    <svg style="width: 26px; height: 26px; fill: #dc3545;" viewBox="0 0 24 24">
                        <path
                            d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z" />
                    </svg>
                    Rincian Denda
                </h3>
                <div style="display: grid; gap: 16px; margin-bottom: 20px;">
                    <div
                        style="display: flex; justify-content: space-between; align-items: center; padding: 14px; background: #f8f9fa; border-radius: 10px;">
                        <span style="color: #666; font-size: 14px;">Genset</span>
                        <span style="color: #333; font-size: 15px; font-weight: 700;">{{ $rental->genset->nama_genset }}</span>
                    </div>
                    <div
                        style="display: flex; justify-content: space-between; align-items: center; padding: 14px; background: #f8f9fa; border-radius: 10px;">
                        <span style="color: #666; font-size: 14px;">Seharusnya Kembali</span>
                        <span style="color: #333; font-size: 15px; font-weight: 600;">{{ $rental->tanggal_selesai->format('d M Y') }}</span>
                    </div>
                    <div
                        style="display: flex; justify-content: space-between; align-items: center; padding: 14px; background: #f8f9fa; border-radius: 10px;">
                        <span style="color: #666; font-size: 14px;">Hari Ini</span>
                        <span style="color: #333; font-size: 15px; font-weight: 600;">{{ now()->format('d M Y') }}</span>
                    </div>
                    <div
                        style="display: flex; justify-content: space-between; align-items: center; padding: 14px; background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%); border-radius: 10px; border-left: 4px solid #ffc107;">
                        <span style="color: #856404; font-size: 14px; font-weight: 600;">Hari Keterlambatan</span>
                        <span style="color: #856404; font-size: 20px; font-weight: 800;">{{ $overdueDays }} Hari</span>
                    </div>
                    <div
                        style="display: flex; justify-content: space-between; align-items: center; padding: 14px; background: #f8f9fa; border-radius: 10px;">
                        <span style="color: #666; font-size: 14px;">Harga Sewa per Hari</span>
                        <span style="color: #333; font-size: 15px; font-weight: 600;">Rp {{ number_format($rental->genset->harga_sewa, 0, ',', '.') }}</span>
                    </div>
                    <div
                        style="display: flex; justify-content: space-between; align-items: center; padding: 14px; background: #f8f9fa; border-radius: 10px;">
                        <span style="color: #666; font-size: 14px;">Denda per Hari (2x Harga Sewa)</span>
                        <span style="color: #333; font-size: 16px; font-weight: 700;">Rp {{ number_format($penaltyPerDay, 0, ',', '.') }}</span>
                    </div>
                </div>
                <div
                    style="padding: 20px; background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%); border-radius: 12px; border-left: 4px solid #dc3545;">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="color: #721c24; font-size: 18px; font-weight: 700;">TOTAL DENDA</span>
                        <span style="color: #dc3545; font-size: 28px; font-weight: 900;">Rp {{ number_format($penaltyAmount, 0, ',', '.') }}</span>
                    </div>
                    <p style="color: #721c24; font-size: 13px; margin-top: 8px; margin-bottom: 0; opacity: 0.9;">
                        {{ $overdueDays }} hari × Rp {{ number_format($penaltyPerDay, 0, ',', '.') }}
                    </p>
                </div>
            </div>

            <div class="card" style="margin-bottom: 30px;">
                <h3
                    style="font-size: 20px; font-weight: 700; margin-bottom: 20px; color: #333; display: flex; align-items: center; gap: 10px; padding-bottom: 16px; border-bottom: 2px solid #f0f0f0;">
                    <svg style="width: 26px; height: 26px; fill: #667eea;" viewBox="0 0 24 24">
                        <path
                            d="M20 4H4c-1.11 0-1.99.89-1.99 2L2 18c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V6c0-1.11-.89-2-2-2zm0 14H4v-6h16v6zm0-10H4V6h16v2z" />
                    </svg>
                    Informasi Rekening Transfer
                </h3>
                <div
                    style="background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%); padding: 20px; border-radius: 12px; border-left: 4px solid #2196f3;">
                    <div style="display: flex; flex-direction: column; gap: 14px;">
                        <div
                            style="display: flex; justify-content: space-between; align-items: center; padding: 14px; background: rgba(255, 255, 255, 0.7); border-radius: 8px;">
                            <span style="color: #1565c0; font-size: 14px; font-weight: 600;">Bank</span>
                            <span style="color: #333; font-size: 16px; font-weight: 800;">BCA</span>
                        </div>
                        <div
                            style="display: flex; justify-content: space-between; align-items: center; padding: 14px; background: rgba(255, 255, 255, 0.7); border-radius: 8px;">
                            <span style="color: #1565c0; font-size: 14px; font-weight: 600;">No. Rekening</span>
                            <span
                                style="color: #333; font-size: 18px; font-weight: 800; font-family: monospace;">1234567890</span>
                        </div>
                        <div
                            style="display: flex; justify-content: space-between; align-items: center; padding: 14px; background: rgba(255, 255, 255, 0.7); border-radius: 8px;">
                            <span style="color: #1565c0; font-size: 14px; font-weight: 600;">Atas Nama</span>
                            <span style="color: #333; font-size: 15px; font-weight: 700;">PT. Rental Genset
                                Indonesia</span>
                        </div>
                        <div
                            style="display: flex; justify-content: space-between; align-items: center; padding: 14px; background: rgba(255, 255, 255, 0.7); border-radius: 8px;">
                            <span style="color: #1565c0; font-size: 14px; font-weight: 600;">Jumlah Transfer</span>
                            <span style="color: #dc3545; font-size: 20px; font-weight: 900;">Rp
                                {{ number_format($penaltyAmount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <h3
                    style="font-size: 20px; font-weight: 700; margin-bottom: 20px; color: #333; display: flex; align-items: center; gap: 10px; padding-bottom: 16px; border-bottom: 2px solid #f0f0f0;">
                    <svg style="width: 26px; height: 26px; fill: #667eea;" viewBox="0 0 24 24">
                        <path
                            d="M19 7v2.99s-1.99.01-2 0V7h-3s.01-1.99 0-2h3V2h2v3h3v2h-3zm-3 4V8h-3V5H5c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2v-8h-3zM5 19l3-4 2 3 3-4 4 5H5z" />
                    </svg>
                    Upload Bukti Pembayaran
                </h3>
                <form method="POST" action="{{ route('user.rentals.upload-penalty', $rental->id) }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div style="margin-bottom: 24px;">
                        <label style="display: block; color: #333; font-weight: 600; margin-bottom: 10px; font-size: 14px;">
                            Bukti Transfer <span style="color: #dc3545;">*</span>
                        </label>
                        <input type="file" name="payment_proof" id="paymentProof"
                            accept="image/*" required style="display: none;"
                            onchange="previewPaymentProof(this)"> <label for="paymentProof"
                            style="display: flex; align-items: center; justify-content: center; padding: 50px 20px; border: 2px dashed #e0e0e0; border-radius: 12px; cursor: pointer; transition: all 0.3s; background: #f8f9fa;"
                            onmouseover="this.style.borderColor='#667eea'; this.style.background='#f0f4ff'"
                            onmouseout="this.style.borderColor='#e0e0e0'; this.style.background='#f8f9fa'">
                            <div style="text-align: center;">
                                <svg style="width: 56px; height: 56px; fill: #667eea; margin-bottom: 12px;"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M19 7v2.99s-1.99.01-2 0V7h-3s.01-1.99 0-2h3V2h2v3h3v2h-3zm-3 4V8h-3V5H5c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2v-8h-3zM5 19l3-4 2 3 3-4 4 5H5z" />
                                </svg>
                                <p style="color: #333; font-weight: 600; margin-bottom: 8px; font-size: 16px;">Klik untuk
                                    upload bukti transfer</p>
                                <p style="color: #999; font-size: 13px; margin: 0;">Format: JPG, JPEG, PNG (Max. 2MB)</p>
                            </div>
                        </label>
                        <div id="previewContainer" style="display: none; margin-top: 16px; text-align: center;">
                            <div style="position: relative; display: inline-block; max-width: 100%;">
                                <img id="previewImage" src="" alt="Preview"
                                    style="width: 100%; max-width: 500px; display: block; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                                <button type="button" onclick="removePreview()"
                                    style="position: absolute; top: 10px; right: 10px; width: 36px; height: 36px; background: #dc3545; color: white; border: none; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(220, 53, 69, 0.4); transition: all 0.3s;"
                                    onmouseover="this.style.transform='scale(1.1)'"
                                    onmouseout="this.style.transform='scale(1)'">
                                    <svg style="width: 18px; height: 18px; fill: white;" viewBox="0 0 24 24">
                                        <path
                                            d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div style="margin-bottom: 24px;">
                        <label style="display: block; color: #333; font-weight: 600; margin-bottom: 10px; font-size: 14px;">
                            Catatan <span style="color: #999; font-weight: 400;">(Opsional)</span>
                        </label>
                        <textarea name="catatan" rows="3" placeholder="Tambahkan catatan jika diperlukan..."
                            style="width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 14px; resize: vertical; font-family: inherit; transition: all 0.3s;"
                            onfocus="this.style.borderColor='#667eea'"
                            onblur="this.style.borderColor='#e0e0e0'">{{ old('catatan') }}</textarea>
                    </div>
                    <div
                        style="background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%); padding: 16px 20px; border-radius: 10px; border-left: 4
px solid #ffc107; margin-bottom: 24px;">
                        <div style="display: flex; gap: 12px;">
                            <svg style="width: 22px; height: 22px; fill: #856404; flex-shrink: 0;" viewBox="0 0 24 24">
                                <path
                                    d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z" />
                            </svg>
                            <div>
                                <p style="color: #856404; font-size: 13px; margin: 0; line-height: 1.6;">
                                    <strong>Penting:</strong> Setelah upload, admin akan memverifikasi pembayaran Anda
                                    dalam waktu 1x24 jam.
                                    Setelah terverifikasi, Anda dapat mengajukan request pengembalian genset.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div style="display: flex; gap: 12px;">
                        <button type="submit"
                            style="flex: 1; padding: 16px; background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; border: none; border-radius: 10px; font-weight: 700; font-size: 16px; cursor: pointer; transition: all 0.3s; box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3); display: flex; align-items: center; justify-content: center; gap: 10px;"
                            onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(220, 53, 69, 0.4)'"
                            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(220, 53, 69, 0.3)'">
                            <svg style="width: 22px; height: 22px; fill: white;" viewBox="0 0 24 24">
                                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z" />
                            </svg>
                            Upload Bukti Pembayaran
                        </button>
                        <a href="{{ route('user.rentals.show', $rental->id) }}"
                            style="padding: 16px 32px; background: #f8f9fa; color: #495057; border-radius: 10px; font-weight: 600; font-size: 16px; text-decoration: none; transition: all 0.3s; display: flex; align-items: center; justify-content: center;"
                            onmouseover="this.style.background='#e9ecef'" onmouseout="this.style.background='#f8f9fa'">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div style="position: sticky; top: 20px;">
            <div class="card" style="margin-bottom: 20px;">
                <div
                    style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); padding: 24px; border-radius: 12px; color: white; text-align: center;">
                    <svg style="width: 48px; height: 48px; fill: white; margin-bottom: 12px; opacity: 0.9;"
                        viewBox="0 0 24 24">
                        <path
                            d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z" />
                    </svg>
                    <p style="font-size: 14px; opacity: 0.9; margin-bottom: 8px;">Total yang Harus Dibayar</p>
                    <p style="font-size: 32px; font-weight: 900; margin: 0;">Rp {{ number_format($penaltyAmount, 0, ',', '.') }}
                    </p>
                </div>
            </div>
            <div class="card">
                <h3
                    style="font-size: 18px; font-weight: 700; margin-bottom: 20px; color: #333; display: flex; align-items: center; gap: 10px; padding-bottom: 16px; border-bottom: 2px solid #f0f0f0;">
                    <svg style="width: 24px; height: 24px; fill: #667eea;" viewBox="0 0 24 24">
                        <path
                            d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z" />
                    </svg>
                    Langkah Selanjutnya
                </h3>
                <div style="display: flex; flex-direction: column; gap: 16px;">
                    <div style="display: flex; gap: 12px;">
                        <div
                            style="width: 32px; height: 32px; background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; color: white; font-weight: 700; font-size: 14px;">
                            1</div>
                        <div>
                            <h4 style="font-size: 14px; font-weight: 700; color: #333; margin-bottom: 4px;">Transfer Denda
                            </h4>
                            <p style="color: #666; font-size: 13px; margin: 0; line-height: 1.5;">Transfer sesuai nominal
                                ke rekening yang tertera</p>
                        </div>
                    </div>
                    <div style="display: flex; gap: 12px;">
                        <div
                            style="width: 32px; height: 32px; background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; color: white; font-weight: 700; font-size: 14px;">
                            2</div>
                        <div>
                            <h4 style="font-size: 14px; font-weight: 700; color: #333; margin-bottom: 4px;">Upload Bukti
                            </h4>
                            <p style="color: #666; font-size: 13px; margin: 0; line-height: 1.5;">Upload foto/screenshot
                                bukti transfer</p>
                        </div>
                    </div>
                    <div style="display: flex; gap: 12px;">
                        <div
                            style="width: 32px; height: 32px; background: linear-gradient(135deg, #17a2b8 0%, #138496 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; color: white; font-weight: 700; font-size: 14px;">
                            3</div>
                        <div>
                            <h4 style="font-size: 14px; font-weight: 700; color: #333; margin-bottom: 4px;">Verifikasi Admin
                            </h4>
                            <p style="color: #666; font-size: 13px; margin: 0; line-height: 1.5;">Tunggu admin verifikasi
                                (maks. 1x24 jam)</p>
                        </div>
                    </div>
                    <div style="display: flex; gap: 12px;">
                        <div
                            style="width: 32px; height: 32px; background: linear-gradient(135deg, #28a745 0%, #20c997 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; color: white; font-weight: 700; font-size: 14px;">
                            4</div>
                        <div>
                            <h4 style="font-size: 14px; font-weight: 700; color: #333; margin-bottom: 4px;">Request
                                Pengembalian</h4>
                            <p style="color: #666; font-size: 13px; margin: 0; line-height: 1.5;">Setelah verified, ajukan
                                request pengembalian</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    
    <script>
        function previewPaymentProof(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('previewImage').src = e.target.result;
                    document.getElementById('previewContainer').style.display = 'block';
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function removePreview() {
            document.getElementById('paymentProof').value = ''; // Mengosongkan input file
            document.getElementById('previewContainer').style.display = 'none'; // Sembunyikan container
            document.getElementById('previewImage').src = ''; // Hapus source gambar
        }
    </script>
    
    <style>
        @media (max-width: 1024px) {
            div[style*="grid-template-columns: 1fr 400px"] {
                grid-template-columns: 1fr !important;
            }
        }
    </style>
@endsection