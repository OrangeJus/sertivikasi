@extends('layouts.app')

@section('page-title', 'Edit Genset')

@section('content')
<div style="max-width: 900px; margin: 0 auto;">
    <!-- Breadcrumb -->
    <div style="margin-bottom: 30px;">
        <a href="{{ route('admin.gensets.index') }}" style="color: #667eea; text-decoration: none; font-size: 14px; display: inline-flex; align-items: center; gap: 5px;">
            <svg style="width: 16px; height: 16px; fill: #667eea;" viewBox="0 0 24 24">
                <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/>
            </svg>
            Kembali ke Kelola Genset
        </a>
    </div>

    <div class="card">
        <div style="margin-bottom: 30px;">
            <h2 style="font-size: 24px; font-weight: 600; margin-bottom: 10px;">Edit Genset Baru</h2>
            <p style="color: #666; font-size: 14px;">Perbarui informasi genset di bawah ini</p>
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

        <form method="POST" action="{{ route('admin.gensets.update', $genset->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div id="preview-container" style="margin-top:10px;">
                @if($genset->image)
                    <img id="preview-image" 
                        src="{{ asset('storage/' . $genset->image) }}" 
                        alt="Foto Genset" 
                        style="width: 180px; height: 180px; background-image: url('{{ asset('storage/' . $genset->image) }}'); background-size: cover; background-position: center; background-repeat: no-repeat; max-width: 180px; border-radius:8px; border:1px solid #ccc;">
                @else
                    <img id="preview-image" 
                        src="#" 
                        alt="Preview Foto" 
                        style="max-width: 180px; border-radius:8px; border:1px solid #ccc; object-fit:cover; display:none;">
                @endif
            </div>
            <div class="form-group" style="margin-top: 20px;">
            <label for="image" style="display:block; margin-bottom:8px; font-weight:500;">Foto Genset</label>
            <input 
                type="file" 
                id="image" 
                name="image" 
                accept="image/*"
                onchange="previewImage(event)"
                style="margin-bottom:10px;"
            />
            <p class="form-help">Unggah foto baru (jpg, png, webp). Kosongkan jika tidak ingin mengubah.</p>
        </div>


            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <!-- Nama Genset -->
                <div class="form-group">
                    <label for="nama_genset" style="display: block; margin-bottom: 8px; font-weight: 500; color: #333; font-size: 14px;">
                        Nama Genset <span style="color: #dc3545;">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="nama_genset" 
                        name="nama_genset" 
                        class="form-control" 
                        value="{{ old('nama_genset', $genset->nama_genset) }}" 
                        placeholder="Contoh: Honda 10KVA"
                        required
                        style="padding-left: 15px;"
                    >
                </div>

                                <!-- Kapasitas -->
                <div class="form-group">
                    <label for="kapasitas" style="display: block; margin-bottom: 8px; font-weight: 500; color: #333; font-size: 14px;">
                        Kapasitas
                    </label>
                    <input 
                        type="text" 
                        id="kapasitas" 
                        name="kapasitas" 
                        class="form-control" 
                        value="{{ old('kapasitas', $genset->kapasitas) }}" 
                        placeholder="Contoh: 10 KVA"
                        style="padding-left: 15px;"
                    >
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <!-- Kategori -->
                {{-- <div class="form-group">
                    <label for="category_id" style="display: block; margin-bottom: 8px; font-weight: 500; color: #333; font-size: 14px;">
                        Kategori <span style="color: #dc3545;">*</span>
                    </label>
                    <select 
                        id="category_id" 
                        name="category_id" 
                        required
                        style="width: 100%; padding: 12px 15px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px; background: white; cursor: pointer; transition: all 0.3s;"
                    >
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div> --}}


                {{-- Kategori --}}
                <div class="form-group">
                    <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #333; font-size: 14px;">
                        Kategori <span style="color: #dc3545;">*</span>
                    </label>

                    <div class="dropdown-multi" id="dropdownMulti">
                        <div class="dropdown-selected" id="dropdownSelected">
                            <span class="dropdown-text" id="dropdownText">Pilih kategori...</span>
                        </div>
                        <div class="dropdown-options" id="dropdownOptions">
                            @foreach($categories as $cat)
                            <div class="dropdown-option">
                                <input type="checkbox" 
                                    id="category-{{ $cat->id }}" 
                                    name="category_ids[]" 
                                    value="{{ $cat->id }}"
                                    @checked(in_array($cat->id, old('category_ids', $genset->categories->pluck('id')->toArray())))>
                                <label for="category-{{ $cat->id }}">{{ $cat->nama_kategori }}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div> 
                {{-- Kategori --}}  

                <!-- Status -->
                <div class="form-group">
                    <label for="status" style="display: block; margin-bottom: 8px; font-weight: 500; color: #333; font-size: 14px;">
                        Status <span style="color: #dc3545;">*</span>
                    </label>
                    <select 
                        id="status" 
                        name="status" 
                        required
                        style="width: 100%; padding: 12px 15px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px; background: white; cursor: pointer; transition: all 0.3s; -webkit-appearance: none;"
                    >
                        <option value="" >Pilih Status ...</option>
                        <option value="tersedia" {{ old('status', $genset->status) == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                        <option value="disewa" {{ old('status', $genset->status) == 'disewa' ? 'selected' : '' }}>Disewa</option>
                        <option value="rusak" {{ old('status', $genset->status) == 'rusak' ? 'selected' : '' }}>Rusak</option>
                    </select>
                </div>

            </div>

            <!-- Harga Sewa -->
            <div class="form-group">
                <label for="harga_sewa" style="display: block; margin-bottom: 8px; font-weight: 500; color: #333; font-size: 14px;">
                    Harga Sewa (per hari) <span style="color: #dc3545;">*</span>
                </label>
                <div style="position: relative;">
                    <span style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #999; font-weight: 600;">Rp</span>
                    <input 
                        type="number" 
                        id="harga_sewa" 
                        name="harga_sewa" 
                        class="form-control" 
                        value="{{ old('harga_sewa', $genset->harga_sewa) }}" 
                        placeholder="150000"
                        required
                        min="0"
                        step="1000"
                        style="padding-left: 45px;"
                    >
                </div>
                <p class="form-help">Harga sewa per hari dalam Rupiah</p>
            </div>

            <!-- Deskripsi -->
            <div class="form-group">
                <label for="deskripsi" style="display: block; margin-bottom: 8px; font-weight: 500; color: #333; font-size: 14px;">
                    Deskripsi
                </label>
                <textarea 
                    id="deskripsi" 
                    name="deskripsi" 
                    rows="4"
                    style="width: 100%; padding: 12px 15px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px; font-family: inherit; resize: vertical; transition: all 0.3s;"
                    placeholder="Deskripsi singkat tentang genset ini..."
                >{{ old('deskripsi', $genset->deskripsi) }}</textarea>
                <p class="form-help">Informasi tambahan tentang genset (opsional)</p>
            </div>

            <div style="display: flex; gap: 15px; margin-top: 30px; padding-top: 20px; border-top: 2px solid #f0f0f0;">
                <button type="submit" class="btn btn-primary" style="flex: 1;">
                    <svg style="width: 18px; height: 18px; fill: white; display: inline-block; vertical-align: middle; margin-right: 5px;" viewBox="0 0 24 24">
                        <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                    </svg>
                    Perbarui Data Genset
                </button>
                <a href="{{ route('admin.gensets.index') }}" class="btn btn-secondary" style="text-decoration: none; text-align: center; flex: 1;">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script>
function previewImage(event) {
    const file = event.target.files[0];
    const previewImage = document.getElementById('preview-image');

    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImage.src = e.target.result;
            previewImage.style.display = 'block';
        }
        reader.readAsDataURL(file);
    } else {
        previewImage.style.display = 'none';
    }
}
</script>

@endsection