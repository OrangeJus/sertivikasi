<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Rental Genset') }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="guest-container">
        <div class="guest-logo">
            <div class="logo-icon">
                <svg viewBox="0 0 24 24">
                    <path d="M13 2L3 14h8l-2 8 10-12h-8l2-8z"/>
                </svg>
            </div>
            <h1>Rental Genset</h1>
            <p>Solusi Kebutuhan Listrik Anda</p>
        </div>

        <div class="auth-card">
            @yield('content')
        </div>

        <p style="color: white; margin-top: 20px; font-size: 14px;">
            &copy; {{ date('Y') }} Rental Genset. All rights reserved.
        </p>
    </div>
</body>
</html>