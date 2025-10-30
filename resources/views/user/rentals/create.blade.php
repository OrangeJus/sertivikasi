@extends('layouts.app')

@section('page-title', 'Sewa Genset')

@section('content')
    <div style="margin-bottom: 30px;">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
            <div>
                <h2 style="font-size: 28px; font-weight: 600; margin-bottom: 10px;">Sewa Genset</h2>
                <p style="color: #666; font-size: 14px;">Lengkapi informasi penyewaan dan pembayaran genset Anda</p>
            </div>
            <a href="{{ route('user.dashboard') }}" style="padding: 12px 24px; background: #e9ecef; color: #495057; border-radius: 10px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 8px; transition: all 0.3s;" onmouseover="this.style.background='#dee2e6'" onmouseout="this.style.background='#e9ecef'">
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

    @if (session('error'))
        <div style="background: #f8d7da; color: #721c24; padding: 16px 20px; border-radius: 10px; margin-bottom: 25px; border-left: 4px solid #dc3545; display: flex; align-items: center; gap: 12px;">
            <svg style="width: 24px; height: 24px; fill: currentColor; flex-shrink: 0;" viewBox="0 0 24 24">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
            </svg>
            <span style="font-weight: 500;">{{ session('error') }}</span>
        </div>
    @endif

    @if ($errors->any())
        <div style="background: #f8d7da; color: #721c24; padding: 16px 20px; border-radius: 10px; margin-bottom: 25px; border-left: 4px solid #dc3545;">
            <div style="display: flex; align-items: start; gap: 12px; margin-bottom: 12px;">
                <svg style="width: 24px; height: 24px; fill: currentColor; flex-shrink: 0;" viewBox="0 0 24 24">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                </svg>
                <div style="flex: 1;">
                    <strong style="display: block; margin-bottom: 8px;">Terdapat beberapa kesalahan:</strong>
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li style="margin-bottom: 4px;">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <form method="POST" action="{{ route('user.rentals.store') }}" id="rentalForm" enctype="multipart/form-data">
        @csrf

        <div style="display: grid; grid-template-columns: 1fr 400px; gap: 30px; align-items: start;">
            
            <div style="display: flex; flex-direction: column; gap: 30px;">
                
                <div class="card">
                    <h3 style="font-size: 20px; font-weight: 700; margin-bottom: 24px; color: #333; display: flex; align-items: center; gap: 10px; padding-bottom: 20px; border-bottom: 2px solid #f0f0f0;">
                        <svg style="width: 26px; height: 26px; fill: #667eea;" viewBox="0 0 24 24">
                            <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>
                        </svg>
                        Informasi Penyewaan
                    </h3>

                    <div style="margin-bottom: 24px;">
                        <label style="display: block; color: #333; font-weight: 600; margin-bottom: 10px; font-size: 14px;">
                            Pilih Genset <span style="color: #dc3545;">*</span>
                        </label>
                        <select 
                            name="genset_id" 
                            id="gensetSelect"
                            required
                            style="width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 14px; background: white; cursor: pointer; transition: all 0.3s;"
                            onfocus="this.style.borderColor='#667eea'"
                            onblur="this.style.borderColor='#e0e0e0'"
                            onchange="updateGensetInfo()"
                        >
                            <option value="">-- Pilih Genset --</option>
                            @foreach($gensets as $g)
                                <option 
                                    value="{{ $g->id }}"
                                    data-name="{{ $g->nama_genset }}"
                                    data-capacity="{{ $g->kapasitas }}"
                                    data-price="{{ $g->harga_sewa }}"
                                    {{ (old('genset_id', $genset->id ?? '') == $g->id) ? 'selected' : '' }}
                                >
                                    {{ $g->nama_genset }} - {{ $g->kapasitas }} (Rp {{ number_format($g->harga_sewa, 0, ',', '.') }}/hari)
                                </option>
                            @endforeach
                        </select>
                        @error('genset_id')
                            <small style="color: #dc3545; font-size: 13px; margin-top: 6px; display: block;">{{ $message }}</small>
                        @enderror
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 24px;">
                        <div>
                            <label style="display: block; color: #333; font-weight: 600; margin-bottom: 10px; font-size: 14px;">
                                Tanggal Mulai <span style="color: #dc3545;">*</span>
                            </label>
                            <input 
                                type="date" 
                                name="tanggal_mulai"
                                id="tanggalMulai"
                                value="{{ old('tanggal_mulai', date('Y-m-d')) }}"
                                min="{{ date('Y-m-d') }}"
                                required
                                style="width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 14px; transition: all 0.3s;"
                                onfocus="this.style.borderColor='#667eea'"
                                onblur="this.style.borderColor='#e0e0e0'"
                                onchange="calculateTotal()"
                            >
                            @error('tanggal_mulai')
                                <small style="color: #dc3545; font-size: 13px; margin-top: 6px; display: block;">{{ $message }}</small>
                            @enderror
                        </div>

                        <div>
                            <label style="display: block; color: #333; font-weight: 600; margin-bottom: 10px; font-size: 14px;">
                                Tanggal Selesai <span style="color: #dc3545;">*</span>
                            </label>
                            <input 
                                type="date" 
                                name="tanggal_selesai"
                                id="tanggalSelesai"
                                value="{{ old('tanggal_selesai') }}"
                                min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                required
                                style="width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 14px; transition: all 0.3s;"
                                onfocus="this.style.borderColor='#667eea'"
                                onblur="this.style.borderColor='#e0e0e0'"
                                onchange="calculateTotal()"
                            >
                            @error('tanggal_selesai')
                                <small style="color: #dc3545; font-size: 13px; margin-top: 6px; display: block;">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div style="margin-bottom: 0;">
                        <label style="display: block; color: #333; font-weight: 600; margin-bottom: 10px; font-size: 14px;">
                            Catatan Tambahan <span style="color: #999; font-weight: 400;">(Opsional)</span>
                        </label>
                        <textarea 
                            name="catatan"
                            rows="4"
                            placeholder="Tambahkan catatan atau permintaan khusus..."
                            style="width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 14px; resize: vertical; font-family: inherit; transition: all 0.3s;"
                            onfocus="this.style.borderColor='#667eea'"
                            onblur="this.style.borderColor='#e0e0e0'"
                        >{{ old('catatan') }}</textarea>
                    </div>
                </div>

                <div class="card">
                    <h3 style="font-size: 20px; font-weight: 700; margin-bottom: 24px; color: #333; display: flex; align-items: center; gap: 10px; padding-bottom: 20px; border-bottom: 2px solid #f0f0f0;">
                        <svg style="width: 26px; height: 26px; fill: #667eea;" viewBox="0 0 24 24">
                            <path d="M20 4H4c-1.11 0-1.99.89-1.99 2L2 18c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V6c0-1.11-.89-2-2-2zm0 14H4v-6h16v6zm0-10H4V6h16v2z"/>
                        </svg>
                        Informasi Pembayaran
                    </h3>

                    <div style="margin-bottom: 24px;">
                        <label style="display: block; color: #333; font-weight: 600; margin-bottom: 12px; font-size: 14px;">
                            Metode Pembayaran <span style="color: #dc3545;">*</span>
                        </label>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                            <label style="position: relative; display: block; cursor: pointer;">
                                <input type="radio" name="payment_method" value="transfer" {{ old('payment_method', 'transfer') == 'transfer' ? 'checked' : '' }} required style="position: absolute; opacity: 0;">
                                <div class="payment-method-card" style="padding: 20px; border: 2px solid #e0e0e0; border-radius: 12px; transition: all 0.3s; text-align: center;">
                                    <svg style="width: 40px; height: 40px; fill: #667eea; margin-bottom: 12px;" viewBox="0 0 24 24">
                                        <path d="M20 4H4c-1.11 0-1.99.89-1.99 2L2 18c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V6c0-1.11-.89-2-2-2zm0 14H4v-6h16v6zm0-10H4V6h16v2z"/>
                                    </svg>
                                    <p style="font-weight: 700; color: #333; margin-bottom: 4px; font-size: 15px;">Transfer Bank</p>
                                    <p style="color: #999; font-size: 13px; margin: 0;">Transfer via ATM/M-Banking</p>
                                </div>
                            </label>

                            <label style="position: relative; display: block; cursor: pointer;">
                                <input type="radio" name="payment_method" value="cash" {{ old('payment_method') == 'cash' ? 'checked' : '' }} required style="position: absolute; opacity: 0;">
                                <div class="payment-method-card" style="padding: 20px; border: 2px solid #e0e0e0; border-radius: 12px; transition: all 0.3s; text-align: center;">
                                    <svg style="width: 40px; height: 40px; fill: #667eea; margin-bottom: 12px;" viewBox="0 0 24 24">
                                        <path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z"/>
                                    </svg>
                                    <p style="font-weight: 700; color: #333; margin-bottom: 4px; font-size: 15px;">Cash/Tunai</p>
                                    <p style="color: #999; font-size: 13px; margin: 0;">Bayar langsung di tempat</p>
                                </div>
                            </label>
                        </div>
                        @error('payment_method')
                            <small style="color: #dc3545; font-size: 13px; margin-top: 6px; display: block;">{{ $message }}</small>
                        @enderror
                    </div>

                    <div id="bankAccountInfo" style="display: none; margin-bottom: 24px; padding: 20px; background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%); border-radius: 12px; border-left: 4px solid #2196f3;">
                        <h4 style="font-size: 15px; font-weight: 700; color: #1565c0; margin-bottom: 16px; display: flex; align-items: center; gap: 8px;">
                            <svg style="width: 20px; height: 20px; fill: #1565c0;" viewBox="0 0 24 24">
                                <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/>
                            </svg>
                            Informasi Rekening Transfer
                        </h4>
                        <div style="display: flex; flex-direction: column; gap: 12px;">
                            <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px; background: rgba(255, 255, 255, 0.7); border-radius: 8px;">
                                <span style="color: #666; font-size: 14px;">Bank</span>
                                <span style="color: #333; font-size: 14px; font-weight: 700;">BCA</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px; background: rgba(255, 255, 255, 0.7); border-radius: 8px;">
                                <span style="color: #666; font-size: 14px;">No. Rekening</span>
                                <span style="color: #333; font-size: 16px; font-weight: 700; font-family: monospace;">1234567890</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px; background: rgba(255, 255, 255, 0.7); border-radius: 8px;">
                                <span style="color: #666; font-size: 14px;">Atas Nama</span>
                                <span style="color: #333; font-size: 14px; font-weight: 700;">PT. Rental Genset Indonesia</span>
                            </div>
                        </div>
                    </div>

                    <div style="margin-bottom: 0;">
                        <label style="display: block; color: #333; font-weight: 600; margin-bottom: 10px; font-size: 14px;">
                            Bukti Pembayaran <span style="color: #999; font-weight: 400;">(Opsional - dapat diupload nanti)</span>
                        </label>
                        <div style="position: relative;">
                            <input 
                                type="file" 
                                name="payment_proof"
                                id="paymentProof"
                                accept="image/jpeg,image/jpg,image/png"
                                style="display: none;"
                                onchange="previewPaymentProof(this)"
                            >
                            <label for="paymentProof" style="display: flex; align-items: center; justify-content: center; padding: 40px 20px; border: 2px dashed #e0e0e0; border-radius: 12px; cursor: pointer; transition: all 0.3s; background: #f8f9fa;" onmouseover="this.style.borderColor='#667eea'; this.style.background='#f0f4ff'" onmouseout="this.style.borderColor='#e0e0e0'; this.style.background='#f8f9fa'">
                                <div style="text-align: center;">
                                    <svg style="width: 48px; height: 48px; fill: #667eea; margin-bottom: 12px;" viewBox="0 0 24 24">
                                        <path d="M19 7v2.99s-1.99.01-2 0V7h-3s.01-1.99 0-2h3V2h2v3h3v2h-3zm-3 4V8h-3V5H5c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2v-8h-3zM5 19l3-4 2 3 3-4 4 5H5z"/>
                                    </svg>
                                    <p style="color: #333; font-weight: 600; margin-bottom: 6px;">Klik untuk upload bukti transfer</p>
                                    <p style="color: #999; font-size: 13px; margin: 0;">Format: JPG, JPEG, PNG (Max. 2MB)</p>
                                </div>
                            </label>
                            <div id="previewContainer" style="display: none; margin-top: 16px; position: relative;">
                                <img id="previewImage" src="" alt="Preview" style="width: 100%; max-width: 400px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                                <button type="button" onclick="removePreview()" style="position: absolute; top: 10px; right: 10px; width: 32px; height: 32px; background: #dc3545; color: white; border: none; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(220, 53, 69, 0.3);">
                                    <svg style="width: 16px; height: 16px; fill: white;" viewBox="0 0 24 24">
                                        <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        @error('payment_proof')
                            <small style="color: #dc3545; font-size: 13px; margin-top: 6px; display: block;">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div style="background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 50%); padding: 20px 24px; border-radius: 12px; border-left: 4px solid #ffc107;">
                    <div style="display: flex; gap: 14px;">
                        <svg style="width: 24px; height: 24px; fill: #856404; flex-shrink: 0;" viewBox="0 0 24 24">
                            <path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"/>
                        </svg>
                        <div>
                            <strong style="color: #856404; display: block; margin-bottom: 8px; font-size: 15px;">Informasi Penting:</strong>
                            <ul style="color: #856404; font-size: 13px; line-height: 1.7; margin: 0; padding-left: 20px;">
                                <li>Pesanan akan menunggu konfirmasi dari admin</li>
                                <li>Jika memilih transfer, silakan upload bukti pembayaran setelah melakukan transfer</li>
                                <li>Jika memilih cash, pembayaran dilakukan saat genset diantar</li>
                                <li>Pastikan tanggal penyewaan sudah benar sebelum submit</li>
                                <li>Bukti pembayaran dapat diupload nanti melalui halaman detail pesanan</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div style="background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%); border-radius: 12px; padding: 20px 24px; border-left: 4px solid #2196f3; margin-bottom: 24px;">
                    <div style="display: flex; gap: 14px;">
                        <svg style="width: 24px; height: 24px; fill: #1565c0; flex-shrink: 0;" viewBox="0 0 24 24">
                            <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/>
                        </svg>
                        <div>
                            <strong style="color: #1565c0; display: block; margin-bottom: 8px; font-size: 15px;">Informasi Durasi & Denda:</strong>
                            <ul style="color: #1565c0; font-size: 13px; line-height: 1.7; margin: 0; padding-left: 20px;">
                                <li><strong>Maksimal durasi penyewaan: 5 hari</strong></li>
                                <li>Keterlambatan pengembalian dikenakan denda <strong>2x harga sewa per hari</strong></li>
                                <li>Contoh: Genset Rp 500.000/hari, terlambat 2 hari = denda Rp 2.000.000</li>
                                <li>Pastikan mengembalikan genset tepat waktu untuk menghindari denda</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div style="display: flex; gap: 12px;">
                    <button 
                        type="submit"
                        style="flex: 1; padding: 16px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 10px; font-weight: 700; font-size: 16px; cursor: pointer; transition: all 0.3s; box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3); display: flex; align-items: center; justify-content: center; gap: 10px;"
                        onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(102, 126, 234, 0.4)'"
                        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(102, 126, 234, 0.3)'"
                    >
                        <svg style="width: 22px; height: 22px; fill: white;" viewBox="0 0 24 24">
                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                        </svg>
                        Ajukan Penyewaan
                    </button>
                    <a 
                        href="{{ route('user.dashboard') }}"
                        style="padding: 16px 32px; background: #f8f9fa; color: #495057; border-radius: 10px; font-weight: 600; font-size: 16px; text-decoration: none; transition: all 0.3s; display: flex; align-items: center; justify-content: center;"
                        onmouseover="this.style.background='#e9ecef'"
                        onmouseout="this.style.background='#f8f9fa'"
                    >
                        Batal
                    </a>
                </div>
            </div>

            <div style="position: sticky; top: 20px;">
                <div class="card">
                    <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 20px; color: #333; display: flex; align-items: center; gap: 10px; padding-bottom: 16px; border-bottom: 2px solid #f0f0f0;">
                        <svg style="width: 24px; height: 24px; fill: #667eea;" viewBox="0 0 24 24">
                            <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z"/>
                        </svg>
                        Ringkasan Pesanan
                    </h3>

                    <div id="gensetInfo" style="display: none; margin-bottom: 20px; padding: 16px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 10px;">
                        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                            <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <svg style="width: 26px; height: 26px; fill: white;" viewBox="0 0 24 24">
                                    <path d="M13 2L3 14h8l-2 8 10-12h-8l2-8z"/>
                                </svg>
                            </div>
                            <div>
                                <h4 id="gensetName" style="font-size: 16px; font-weight: 700; color: #333; margin-bottom: 4px;">-</h4>
                                <p id="gensetCapacity" style="color: #666; font-size: 13px; margin: 0;">-</p>
                            </div>
                        </div>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; padding-bottom: 12px; border-bottom: 1px dashed #dee2e6;">
                            <span style="color: #666; font-size: 14px;">Harga per Hari:</span>
                            <span id="pricePerDay" style="color: #333; font-size: 14px; font-weight: 600;">Rp 0</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; padding-bottom: 12px; border-bottom: 1px dashed #dee2e6;">
                            <span style="color: #666; font-size: 14px;">Durasi:</span>
                            <span id="duration" style="color: #333; font-size: 14px; font-weight: 600;">0 hari</span>
                        </div>

                        <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 8px;">
                            <span style="color: #333; font-size: 16px; font-weight: 700;">Total Harga:</span>
                            <span id="totalPrice" style="color: #667eea; font-size: 24px; font-weight: 800;">Rp 0</span>
                        </div>
                    </div>

                    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 16px; border-radius: 10px; color: white;">
                        <h4 style="font-size: 14px; font-weight: 700; margin-bottom: 10px; display: flex; align-items: center; gap: 8px;">
                            <svg style="width: 18px; height: 18px; fill: white;" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/>
                            </svg>
                            Butuh Bantuan?
                        </h4>
                        <p style="font-size: 13px; opacity: 0.95; line-height: 1.5; margin: 0;">
                            Hubungi kami jika ada pertanyaan tentang penyewaan genset.
                        </p>
                        <a href="tel:+62123456789" style="display: inline-flex; align-items: center; gap: 8px; margin-top: 12px; padding: 10px 16px; background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px); color: white; border-radius: 8px; text-decoration: none; font-size: 13px; font-weight: 600; transition: all 0.3s;" onmouseover="this.style.background='rgba(255, 255, 255, 0.3)'" onmouseout="this.style.background='rgba(255, 255, 255, 0.2)'">
                            <svg style="width: 16px; height: 16px; fill: white;" viewBox="0 0 24 24">
                                <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
                            </svg>
                            Hubungi Admin
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </form>
    <script>
        function updateGensetInfo() {
            const select = document.getElementById('gensetSelect');
            const selectedOption = select.options[select.selectedIndex];
            
            if (selectedOption.value) {
                const name = selectedOption.dataset.name;
                const capacity = selectedOption.dataset.capacity;
                const price = parseFloat(selectedOption.dataset.price);
                
                document.getElementById('gensetName').textContent = name;
                document.getElementById('gensetCapacity').textContent = capacity;
                document.getElementById('pricePerDay').textContent = 'Rp ' + price.toLocaleString('id-ID');
                document.getElementById('gensetInfo').style.display = 'block';
                
                calculateTotal();
            } else {
                document.getElementById('gensetInfo').style.display = 'none';
                document.getElementById('pricePerDay').textContent = 'Rp 0';
                document.getElementById('duration').textContent = '0 hari';
                document.getElementById('totalPrice').textContent = 'Rp 0';
            }
        }

        function calculateTotal() {
            const select = document.getElementById('gensetSelect');
            const selectedOption = select.options[select.selectedIndex];
            const startDate = document.getElementById('tanggalMulai').value;
            const endDate = document.getElementById('tanggalSelesai').value;
            
            if (selectedOption.value && startDate && endDate) {
                const price = parseFloat(selectedOption.dataset.price);
                const start = new Date(startDate);
                const end = new Date(endDate);
                
                // Ensure end date is not before start date
                if (end < start) {
                    document.getElementById('duration').textContent = '0 hari';
                    document.getElementById('duration').style.color = '#333';
                    document.getElementById('totalPrice').textContent = 'Rp 0';
                    document.getElementById('totalPrice').style.color = '#667eea';
                    hideDurationWarning();
                    return;
                }

                const diffTime = Math.abs(end - start);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1; // +1 to include the start day
                
                if (diffDays > 0) {
                    // VALIDASI: Maksimal 5 hari
                    if (diffDays > 5) {
                        document.getElementById('duration').textContent = diffDays + ' hari';
                        document.getElementById('duration').style.color = '#dc3545';
                        document.getElementById('totalPrice').textContent = 'Maks. 5 hari';
                        document.getElementById('totalPrice').style.fontSize = '18px'; // Smaller font for warning
                        document.getElementById('totalPrice').style.color = '#dc3545';
                        
                        // Show warning
                        showDurationWarning();
                    } else {
                        const total = price * diffDays;
                        document.getElementById('duration').textContent = diffDays + ' hari';
                        document.getElementById('duration').style.color = '#333';
                        document.getElementById('totalPrice').textContent = 'Rp ' + total.toLocaleString('id-ID');
                        document.getElementById('totalPrice').style.fontSize = '24px'; // Reset font size
                        document.getElementById('totalPrice').style.color = '#667eea';
                        
                        // Hide warning
                        hideDurationWarning();
                    }
                }
            }
        }

        function showDurationWarning() {
            let warning = document.getElementById('durationWarning');
            if (!warning) {
                warning = document.createElement('div');
                warning.id = 'durationWarning';
                warning.style.cssText = 'margin-top: 16px; padding: 14px 18px; background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%); border-radius: 10px; border-left: 4px solid #dc3545;';
                warning.innerHTML = `
                    <div style="display: flex; align-items: start; gap: 10px;">
                        <svg style="width: 20px; height: 20px; fill: #721c24; flex-shrink: 0; margin-top: 2px;" viewBox="0 0 24 24">
                            <path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"/>
                        </svg>
                        <div>
                            <strong style="color: #721c24; display: block; margin-bottom: 4px; font-size: 14px;">Durasi Melebihi Batas!</strong>
                            <p style="color: #721c24; font-size: 13px; margin: 0; line-height: 1.5;">Maksimal durasi penyewaan adalah <strong>5 hari</strong>. Silakan pilih tanggal lain.</p>
                        </div>
                    </div>
                `;
                
                // Find the summary card (the sticky one) and append the warning
                const summaryCard = document.querySelector('div[style*="position: sticky"] > .card');
                if (summaryCard) {
                    summaryCard.appendChild(warning);
                }
            }
            warning.style.display = 'block';
        }

        function hideDurationWarning() {
            const warning = document.getElementById('durationWarning');
            if (warning) {
                warning.style.display = 'none';
            }
        }

        // Update min date for end date when start date changes
        document.getElementById('tanggalMulai').addEventListener('change', function() {
            const startDate = new Date(this.value);
            const nextDay = new Date(startDate);
            nextDay.setDate(nextDay.getDate() + 1);
            
            const endDateInput = document.getElementById('tanggalSelesai');
            const minDate = nextDay.toISOString().split('T')[0];
            endDateInput.min = minDate;
            
            if (endDateInput.value && endDateInput.value < minDate) {
                endDateInput.value = '';
            }
            calculateTotal(); // Recalculate after changing dates
        });
        
        // Also recalculate when end date changes
        document.getElementById('tanggalSelesai').addEventListener('change', calculateTotal);

        // Payment method radio handler
        document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
            radio.addEventListener('change', function() {
                document.querySelectorAll('.payment-method-card').forEach(card => {
                    card.style.borderColor = '#e0e0e0';
                    card.style.background = 'white';
                    card.style.boxShadow = 'none';
                });
                
                const card = this.parentElement.querySelector('.payment-method-card');
                card.style.borderColor = '#667eea';
                card.style.background = 'linear-gradient(135deg, #f0f4ff 0%, #e8eeff 100%)';
                card.style.boxShadow = '0 4px 12px rgba(102, 126, 234, 0.2)';
                
                const bankInfo = document.getElementById('bankAccountInfo');
                if (this.value === 'transfer') {
                    bankInfo.style.display = 'block';
                } else {
                    bankInfo.style.display = 'none';
                }
            });
        });

        // Preview payment proof
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
            document.getElementById('paymentProof').value = '';
            document.getElementById('previewContainer').style.display = 'none';
            document.getElementById('previewImage').src = '';
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateGensetInfo();

            // Set initial min date for tanggalSelesai
            const startDateInput = document.getElementById('tanggalMulai');
            const startDate = new Date(startDateInput.value);
            const nextDay = new Date(startDate);
            nextDay.setDate(nextDay.getDate() + 1);
            document.getElementById('tanggalSelesai').min = nextDay.toISOString().split('T')[0];

            // Trigger payment method change to show selected style
            const selectedPaymentMethod = document.querySelector('input[name="payment_method"]:checked');
            if (selectedPaymentMethod) {
                selectedPaymentMethod.dispatchEvent(new Event('change'));
            }
            
            // Initial calculation in case dates are pre-filled (e.g., from old())
            calculateTotal();
        });
    </script>
    <style>
        /* Custom date input styling */
        input[type="date"]::-webkit-calendar-picker-indicator {
            cursor: pointer;
            filter: invert(0.5);
        }

        input[type="date"]:hover::-webkit-calendar-picker-indicator {
            filter: invert(0.3);
        }

        /* Payment method card transition */
        .payment-method-card {
            transition: all 0.3s ease;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            div[style*="grid-template-columns: 1fr 400px"] {
                grid-template-columns: 1fr !important;
            }
            
            div[style*="position: sticky"] {
                position: relative !important;
                top: auto !important;
            }
        }

        @media (max-width: 768px) {
            div[style*="grid-template-columns: 1fr 1fr"] {
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
    </style>
@endsection