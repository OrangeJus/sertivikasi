@extends('layouts.app')

@section('page-title', 'Tambah User')

@section('content')
<div style="max-width: 800px; margin: 0 auto;">
    <!-- Breadcrumb -->
    <div style="margin-bottom: 30px;">
        <a href="{{ route('admin.users.index') }}" style="color: #667eea; text-decoration: none; font-size: 14px; display: inline-flex; align-items: center; gap: 5px;">
            <svg style="width: 16px; height: 16px; fill: #667eea;" viewBox="0 0 24 24">
                <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/>
            </svg>
            Kembali ke Kelola User
        </a>
    </div>

    <div class="card">
        <div style="margin-bottom: 30px;">
            <h2 style="font-size: 24px; font-weight: 600; margin-bottom: 10px;">Tambah User Baru</h2>
            <p style="color: #666; font-size: 14px;">Isi form di bawah untuk menambahkan user baru</p>
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

        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf

            <div class="form-group">
                <label for="name" style="display: block; margin-bottom: 8px; font-weight: 500; color: #333; font-size: 14px;">
                    Nama Lengkap <span style="color: #dc3545;">*</span>
                </label>
                <div class="input-wrapper">
                    <svg viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        class="form-control" 
                        value="{{ old('name') }}" 
                        placeholder="Masukkan nama lengkap"
                        required 
                        autofocus
                    >
                </div>
            </div>

            <div class="form-group">
                <label for="email" style="display: block; margin-bottom: 8px; font-weight: 500; color: #333; font-size: 14px;">
                    Email <span style="color: #dc3545;">*</span>
                </label>
                <div class="input-wrapper">
                    <svg viewBox="0 0 24 24">
                        <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                    </svg>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        class="form-control" 
                        value="{{ old('email') }}" 
                        placeholder="nama@email.com"
                        required
                    >
                </div>
            </div>

            <div class="form-group">
                <label for="role" style="display: block; margin-bottom: 8px; font-weight: 500; color: #333; font-size: 14px;">
                    Role <span style="color: #dc3545;">*</span>
                </label>
                <div style="position: relative;">
                    <svg style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); width: 20px; height: 20px; fill: #999;" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/>
                    </svg>
                    <select 
                        id="role" 
                        name="role" 
                        required
                        style="width: 100%; padding: 12px 15px 12px 45px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px; background: white; cursor: pointer; transition: all 0.3s;"
                    >
                        <option value="">Pilih Role</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                    </select>
                </div>
                <p class="form-help">Pilih role sesuai dengan hak akses yang diinginkan</p>
            </div>

            <div class="form-group">
                <label for="password" style="display: block; margin-bottom: 8px; font-weight: 500; color: #333; font-size: 14px;">
                    Password <span style="color: #dc3545;">*</span>
                </label>
                <div class="input-wrapper">
                    <svg viewBox="0 0 24 24">
                        <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/>
                    </svg>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        class="form-control" 
                        placeholder="Minimal 8 karakter"
                        required
                    >
                </div>
                <p class="form-help">Password minimal 8 karakter</p>
            </div>

            <div class="form-group">
                <label for="password_confirmation" style="display: block; margin-bottom: 8px; font-weight: 500; color: #333; font-size: 14px;">
                    Konfirmasi Password <span style="color: #dc3545;">*</span>
                </label>
                <div class="input-wrapper">
                    <svg viewBox="0 0 24 24">
                        <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/>
                    </svg>
                    <input 
                        type="password" 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        class="form-control" 
                        placeholder="Ulangi password"
                        required
                    >
                </div>
            </div>

            <div style="display: flex; gap: 15px; margin-top: 30px; padding-top: 20px; border-top: 2px solid #f0f0f0;">
                <button type="submit" class="btn btn-primary" style="flex: 1;">
                    <svg style="width: 18px; height: 18px; fill: white; display: inline-block; vertical-align: middle; margin-right: 5px;" viewBox="0 0 24 24">
                        <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                    </svg>
                    Simpan User
                </button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary" style="text-decoration: none; text-align: center; flex: 1;">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection