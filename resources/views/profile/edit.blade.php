@extends('layouts.app')

@section('page-title', 'Profile')

@section('content')
<div class="profile-container">
    <!-- Profile Header -->
    <div class="profile-header">
        <div class="profile-avatar-large">
            {{ substr(Auth::user()->name, 0, 1) }}
        </div>
        <h2 class="profile-name">{{ Auth::user()->name }}</h2>
        <p class="profile-email">{{ Auth::user()->email }}</p>
    </div>

    <!-- Success Message -->
    @if (session('status') === 'profile-updated')
        <div class="alert alert-success" style="margin-bottom: 25px;">
            Profile berhasil diperbarui!
        </div>
    @endif

    @if (session('status') === 'password-updated')
        <div class="alert alert-success" style="margin-bottom: 25px;">
            Password berhasil diubah!
        </div>
    @endif

    <!-- Update Profile Information -->
    <div class="profile-form">
        <div class="form-section">
            <h3>Informasi Profile</h3>

            @if ($errors->updateProfileInformation->any())
                <div class="alert alert-danger">
                    <ul style="list-style: none;">
                        @foreach ($errors->updateProfileInformation->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PATCH')

                <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        class="form-control" 
                        value="{{ old('name', Auth::user()->name) }}" 
                        required
                        style="padding-left: 15px;"
                    >
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        class="form-control" 
                        value="{{ old('email', Auth::user()->email) }}" 
                        required
                        style="padding-left: 15px;"
                    >
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Update Password -->
    <div class="profile-form" style="margin-top: 25px;">
        <div class="form-section">
            <h3>Ubah Password</h3>

            @if ($errors->updatePassword->any())
                <div class="alert alert-danger">
                    <ul style="list-style: none;">
                        @foreach ($errors->updatePassword->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="current_password">Password Saat Ini</label>
                    <input 
                        type="password" 
                        id="current_password" 
                        name="current_password" 
                        class="form-control" 
                        required
                        style="padding-left: 15px;"
                    >
                </div>

                <div class="form-group">
                    <label for="password">Password Baru</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        class="form-control" 
                        required
                        style="padding-left: 15px;"
                    >
                    <p class="form-help">Minimal 8 karakter</p>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password Baru</label>
                    <input 
                        type="password" 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        class="form-control" 
                        required
                        style="padding-left: 15px;"
                    >
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Ubah Password</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Account -->
    <div class="profile-form" style="margin-top: 25px;">
        <div class="form-section">
            <h3 style="color: #dc3545;">Hapus Akun</h3>
            <p style="color: #666; margin-bottom: 20px;">Setelah akun Anda dihapus, semua sumber daya dan data akan dihapus secara permanen.</p>

            <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun ini? Tindakan ini tidak dapat dibatalkan.');">
                @csrf
                @method('DELETE')

                <div class="form-group">
                    <label for="delete_password">Password</label>
                    <input 
                        type="password" 
                        id="delete_password" 
                        name="password" 
                        class="form-control" 
                        placeholder="Masukkan password untuk konfirmasi"
                        required
                        style="padding-left: 15px;"
                    >
                </div>

                <div class="form-actions">
                    <button type="submit" style="background: #dc3545; color: white; padding: 12px 24px; border: none; border-radius: 8px; cursor: pointer; font-weight: 600;">
                        Hapus Akun
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection