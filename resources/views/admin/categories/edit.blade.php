@extends('layouts.app')

@section('page-title', 'Edit Kategori')

@section('content')
<div style="max-width: 700px; margin: 0 auto;">
    <!-- Breadcrumb -->
    <div style="margin-bottom: 30px;">
        <a href="{{ route('admin.categories.index') }}" style="color: #667eea; text-decoration: none; font-size: 14px; display: inline-flex; align-items: center; gap: 5px;">
            <svg style="width: 16px; height: 16px; fill: #667eea;" viewBox="0 0 24 24">
                <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/>
            </svg>
            Kembali ke Kelola Kategori
        </a>
    </div>

    <div class="card">
        <div style="margin-bottom: 30px;">
            <h2 style="font-size: 24px; font-weight: 600; margin-bottom: 10px;">Edit Kategori</h2>
            <p style="color: #666; font-size: 14px;">Perbarui informasi kategori <strong>{{ $category->nama_kategori }}</strong></p>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger" style="margin-bottom: 25px;">
                <ul style="list-style: none; margin: 0; padding: 0;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.categories.update', $category->id) }}">
            @csrf
            @method('PUT')

            <!-- Nama Kategori -->
            <div class="form-group">
                <label for="nama_kategori" style="display: block; margin-bottom: 8px; font-weight: 500; color: #333; font-size: 14px;">
                    Nama Kategori <span style="color: #dc3545;">*</span>
                </label>
                <input 
                    type="text" 
                    id="nama_kategori" 
                    name="nama_kategori" 
                    class="form-control" 
                    value="{{ old('nama_kategori', $category->nama_kategori) }}" 
                    placeholder="Contoh: Portable, Silent, Diesel"
                    required 
                    autofocus
                    style="padding-left: 15px;"
                >
                <p class="form-help">Nama kategori harus unik</p>
            </div>

            <!-- Deskripsi -->
            <div class="form-group">
                <label for="deskripsi" style="display: block; margin-bottom: 8px; font-weight: 500; color: #333; font-size: 14px;">
                    Deskripsi
                </label>
                <textarea 
                    id="deskripsi" 
                    name="deskripsi" 
                    rows="5"
                    style="width: 100%; padding: 12px 15px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px; font-family: inherit; resize: vertical; transition: all 0.3s;"
                    placeholder="Deskripsi singkat tentang kategori ini..."
                >{{ old('deskripsi', $category->deskripsi) }}</textarea>
                <p class="form-help">Deskripsi kategori (opsional)</p>
            </div>

            <!-- Statistics -->
            <div style="background: #f8f9fa; padding: 20px; border-radius: 12px; margin-bottom: 25px;">
                <p style="font-size: 13px; color: #999; margin-bottom: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Statistik Kategori</p>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div style="background: white; padding: 15px; border-radius: 8px; border: 2px solid #e0e0e0;">
                        <p style="color: #999; font-size: 13px; margin-bottom: 5px;">Jumlah Genset</p>
                        <p style="color: #333; font-size: 28px; font-weight: 700; margin: 0;">{{ $category->gensets->count() }}</p>
                    </div>
                    <div style="background: white; padding: 15px; border-radius: 8px; border: 2px solid #e0e0e0;">
                        <p style="color: #999; font-size: 13px; margin-bottom: 5px;">Dibuat Tanggal</p>
                        <p style="color: #333; font-size: 16px; font-weight: 600; margin: 0;">{{ $category->created_at->format('d M Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- Preview Card -->
            <div style="background: #f8f9fa; padding: 20px; border-radius: 12px; margin-bottom: 25px;">
                <p style="font-size: 13px; color: #999; margin-bottom: 10px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Preview</p>
                <div style="background: white; padding: 20px; border-radius: 8px; border: 2px solid #e0e0e0;">
                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                        <div style="width: 50px; height: 50px; border-radius: 10px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center;">
                            <svg style="width: 28px; height: 28px; fill: white;" viewBox="0 0 24 24">
                                <path d="M12 2l-5.5 9h11L12 2zm0 3.84L13.93 9h-3.87L12 5.84zM17.5 13c-2.49 0-4.5 2.01-4.5 4.5s2.01 4.5 4.5 4.5 4.5-2.01 4.5-4.5-2.01-4.5-4.5-4.5zm0 7c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5zM3 21.5h8v-8H3v8zm2-6h4v4H5v-4z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 id="preview-name" style="font-size: 18px; font-weight: 600; color: #333; margin: 0;">{{ $category->nama_kategori }}</h3>
                            <p style="font-size: 12px; color: #999; margin: 5px 0 0 0;">{{ $category->gensets->count() }} Genset</p>
                        </div>
                    </div>
                    <p id="preview-desc" style="color: {{ $category->deskripsi ? '#666' : '#999' }}; font-size: 14px; line-height: 1.6; margin: 0; font-style: {{ $category->deskripsi ? 'normal' : 'italic' }};">{{ $category->deskripsi ?: 'Tidak ada deskripsi' }}</p>
                </div>
            </div>

            <div style="display: flex; gap: 15px; margin-top: 30px; padding-top: 20px; border-top: 2px solid #f0f0f0;">
                <button type="submit" class="btn btn-primary" style="flex: 1;">
                    <svg style="width: 18px; height: 18px; fill: white; display: inline-block; vertical-align: middle; margin-right: 5px;" viewBox="0 0 24 24">
                        <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                    </svg>
                    Update Kategori
                </button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary" style="text-decoration: none; text-align: center; flex: 1;">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Live Preview Script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const nameInput = document.getElementById('nama_kategori');
        const descInput = document.getElementById('deskripsi');
        const previewName = document.getElementById('preview-name');
        const previewDesc = document.getElementById('preview-desc');

        nameInput.addEventListener('input', function() {
            previewName.textContent = this.value || '{{ $category->nama_kategori }}';
        });

        descInput.addEventListener('input', function() {
            if (this.value) {
                previewDesc.textContent = this.value;
                previewDesc.style.fontStyle = 'normal';
                previewDesc.style.color = '#666';
            } else {
                previewDesc.textContent = 'Tidak ada deskripsi';
                previewDesc.style.fontStyle = 'italic';
                previewDesc.style.color = '#999';
            }
        });
    });
</script>
@endsection