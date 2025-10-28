@extends('layouts.guest')

@section('content')
<h2>Selamat Datang</h2>
<p>Silakan login untuk melanjutkan</p>

@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul style="list-style: none;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('login') }}">
    @csrf

    <div class="form-group">
        <label for="email">Email</label>
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
                autofocus
            >
        </div>
    </div>

    <div class="form-group">
        <label for="password">Password</label>
        <div class="input-wrapper">
            <svg viewBox="0 0 24 24">
                <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/>
            </svg>
            <input 
                type="password" 
                id="password" 
                name="password" 
                class="form-control" 
                placeholder="••••••••" 
                required
            >
        </div>
    </div>

    <div class="form-check">
        <label>
            <input type="checkbox" name="remember">
            Ingat saya
        </label>
        
        @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" class="text-link">Lupa password?</a>
        @endif
    </div>

    <button type="submit" class="btn btn-primary">Login</button>
</form>

<div class="auth-footer">
    <p>Belum punya akun? <a href="{{ route('register') }}" class="text-link"><strong>Daftar sekarang</strong></a></p>
</div>
@endsection