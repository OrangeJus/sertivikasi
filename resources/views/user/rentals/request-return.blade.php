@extends('layouts.app')

@section('page-title', 'Request Pengembalian')

@section('content')
<div style="margin-bottom: 30px;">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
        <div>
            <h2 style="font-size: 28px; font-weight: 600; margin-bottom: 10px;">Request Pengembalian Genset</h2>
            <p style="color: #666; font-size: 14px;">Ajukan pengembalian genset yang sudah Anda gunakan</p>
        </div>
        <a href="{{ route('user.rentals.show', $rental->id) }}" style="padding: 12px 24px; background: #e9ecef; color: #495057; border-radius: 10px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 8px; transition: all 0.3s;" onmouseover="this.style.background='#dee2e6'" onmouseout="this.style.background='#e9ecef'">
            <svg style="width: 20px; height: 20px; fill: currentColor;" viewBox="0 0 24 24">
                <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/>
            </svg>
            Kembali
        </a>
    </div>
</div>

@if (session('error'))
    <div style="background: #f8d7da; color: #721c24; padding: 16px 20px; border-radius: 10px; margin-bottom: 25px; border-left: 4px solid #dc3545; display: flex; align-items: center; gap: 12px;">
        <svg style="width: 24px; height: 24px; fill: currentColor; flex-shrink: 0;" viewBox="0 0 24 24">
            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
        </svg>
        <span style="font-weight: 500;">{{ session('error') }}</span>
    </div>
@endif

<div style="display: grid; grid-template-columns: 1fr 400px; gap: 30px; align-items: start;">
    
    <div>
        <div class="card" style="margin-bottom: 30px;">
            <h3 style="font-size: 20px; font-weight: 700; margin-bottom: 20px; color: #333; display: flex; align-items: center; gap: 10px; padding-bottom: 16px; border-bottom: 2px solid #f0f0f0;">
                <svg style="width: 26px; height: 26px; fill: #667eea;" viewBox="0 0 24 24">
                    <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>
                </svg>
                Informasi Penyewaan
            </h3>
            <div style="display: grid; gap: 16px;">
                <div style="display: flex; align-items: center; gap: 12px; padding: 16px; background: #f8f9fa; border-radius: 10px;">
                    <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <svg style="width: 26px; height: 26px; fill: white;" viewBox="0 0 24 24">
                            <path d="M13 2L3 14h8l-2 8 10-12h-8l2-8z"/>
                        </svg>
                    </div>
                    <div>
                        <p style="color: #999; font-size: 12px; margin-bottom: 4px;">Genset</p>
                        <p style="color: #333; font-size: 16px; font-weight: 700; margin: 0;">{{ $rental->genset->nama_genset }}</p>
                    </div>
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                    <div style="padding: 14px; background: #f8f9fa; border-radius: 10px;">
                        <p style="color: #999; font-size: 12px; margin-bottom: 4px;">Tanggal Mulai</p>
                        <p style="color: #333; font-size: 14px; font-weight: 600; margin: 0;">{{ $rental->tanggal_mulai->format('d M Y') }}</p>
                    </div>
                    <div style="padding: 14px; background: #f8f9fa; border-radius: 10px;">
                        <p style="color: #999; font-size: 12px; margin-bottom: 4px;">Tanggal Selesai</p>
                        <p style="color: #333; font-size: 14px; font-weight: 600; margin: 0;">{{ $rental->tanggal_selesai->format('d M Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <h3 style="font-size: 20px; font-weight: 700; margin-bottom: 20px; color: #333; display: flex; align-items: center; gap: 10px; padding-bottom: 16px; border-bottom: 2px solid #f0f0f0;">
                <svg style="width: 26px; height: 26px; fill: #667eea;" viewBox="0 0 24 24">
                    <path d="M20 2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h14l4 4V4c0-1.1-.9-2-2-2zm-2 12H6v-2h12v2zm0-3H6V9h12v2zm0-3H6V6h12v2z"/>
                </svg>
                Form Request Pengembalian
            </h3>
            <form method="POST" action="{{ route('user.rentals.store-return', $rental->id) }}">
                @csrf
                <div style="margin-bottom: 24px;">
                    <label style="display: block; color: #333; font-weight: 600; margin-bottom: 10px; font-size: 14px;">
                        Catatan <span style="color: #999; font-weight: 400;">(Opsional)</span>
                    </label>
                    <textarea 
                        name="catatan_pengembalian"
                        rows="5"
                        placeholder="Contoh: Genset dalam kondisi baik, tidak ada kerusakan..."
                        style="width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 14px; resize: vertical; font-family: inherit; transition: all 0.3s;"
                        onfocus="this.style.borderColor='#667eea'"
                        onblur="this.style.borderColor='#e0e0e0'"
                    >{{ old('catatan_pengembalian') }}</textarea>
                    <small style="color: #999; font-size: 13px; display: block; margin-top: 6px;">
                        Anda dapat menambahkan informasi kondisi genset atau catatan lainnya
                    </small>
                </div>

                <div style="background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%); padding: 18px 22px; border-radius: 12px; border-left: 4px solid #2196f3; margin-bottom: 24px;">
                    <div style="display: flex; gap: 12px;">
                        <svg style="width: 24px; height: 24px; fill: #1565c0; flex-shrink: 0;" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                        </svg>
                        <div>
                            <p style="color: #1565c0; font-size: 14px; margin: 0; line-height: 1.6;">
                                Setelah Anda submit request ini, admin akan meninjau dan menghubungi Anda untuk jadwal pengambilan genset.
                            </p>
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
                        Submit Request Pengembalian
                    </button>
                    <a 
                        href="{{ route('user.rentals.show', $rental->id) }}"
                        style="padding: 16px 32px; background: #f8f9fa; color: #495057; border-radius: 10px; font-weight: 600; font-size: 16px; text-decoration: none; transition: all 0.3s; display: flex; align-items: center; justify-content: center;"
                        onmouseover="this.style.background='#e9ecef'"
                        onmouseout="this.style.background='#f8f9fa'"
                    >
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div style="position: sticky; top: 20px;">
        <div class="card">
            <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 20px; color: #333; display: flex; align-items: center; gap: 10px; padding-bottom: 16px; border-bottom: 2px solid #f0f0f0;">
                <svg style="width: 24px; height: 24px; fill: #667eea;" viewBox="0 0 24 24">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                </svg>
                Proses Selanjutnya
            </h3>
            <div style="display: flex; flex-direction: column; gap: 16px;">
                <div style="display: flex; gap: 12px;">
                    <div style="width: 32px; height: 32px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; color: white; font-weight: 700; font-size: 14px;">1</div>
                    <div>
                        <h4 style="font-size: 14px; font-weight: 700; color: #333; margin-bottom: 4px;">Submit Request</h4>
                        <p style="color: #666; font-size: 13px; margin: 0; line-height: 1.5;">Anda mengajukan request pengembalian genset</p>
                    </div>
                </div>
                <div style="display: flex; gap: 12px;">
                    <div style="width: 32px; height: 32px; background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; color: white; font-weight: 700; font-size: 14px;">2</div>
                    <div>
                        <h4 style="font-size: 14px; font-weight: 700; color: #333; margin-bottom: 4px;">Review Admin</h4>
                        <p style="color: #666; font-size: 13px; margin: 0; line-height: 1.5;">Admin meninjau request dan menghubungi Anda</p>
                    </div>
                </div>
                <div style="display: flex; gap: 12px;">
                    <div style="width: 32px; height: 32px; background: linear-gradient(135deg, #17a2b8 0%, #138496 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; color: white; font-weight: 700; font-size: 14px;">3</div>
                    <div>
                        <h4 style="font-size: 14px; font-weight: 700; color: #333; margin-bottom: 4px;">Pengambilan Genset</h4>
                        <p style="color: #666; font-size: 13px; margin: 0; line-height: 1.5;">Tim kami akan mengambil genset sesuai jadwal</p>
                    </div>
                </div>
                <div style="display: flex; gap: 12px;">
                    <div style="width: 32px; height: 32px; background: linear-gradient(135deg, #28a745 0%, #20c997 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; color: white; font-weight: 700; font-size: 14px;">4</div>
                    <div>
                        <h4 style="font-size: 14px; font-weight: 700; color: #333; margin-bottom: 4px;">Selesai</h4>
                        <p style="color: #666; font-size: 13px; margin: 0; line-height: 1.5;">Penyewaan selesai, terima kasih!</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card" style="margin-top: 20px;">
            <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 20px; border-radius: 12px; color: white;">
                <h4 style="font-size: 16px; font-weight: 700; margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
                    <svg style="width: 20px; height: 20px; fill: white;" viewBox="0 0 24 24">
                        <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
                    </svg>
                    Butuh Bantuan?
                </h4>
                <p style="font-size: 13px; opacity: 0.95; line-height: 1.5; margin-bottom: 14px;">
                    Hubungi kami jika ada pertanyaan tentang proses pengembalian.
                </p>
                <a href="tel:+62123456789" style="display: inline-flex; align-items: center; gap: 8px; padding: 10px 16px; background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px); color: white; border-radius: 8px; text-decoration: none; font-size: 14px; font-weight: 600; transition: all 0.3s;" onmouseover="this.style.background='rgba(255, 255, 255, 0.3)'" onmouseout="this.style.background='rgba(255, 255, 255, 0.2)'">
                    <svg style="width: 16px; height: 16px; fill: white;" viewBox="0 0 24 24">
                        <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
                    </svg>
                    +62 123 456 789
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    @media (max-width: 1024px) {
        div[style*="grid-template-columns: 1fr 400px"] {
            grid-template-columns: 1fr !important;
        }
    }
</style>
@endsection