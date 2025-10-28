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
    @if(Auth::user()->role === 'admin')
        <!-- Admin Layout with Sidebar -->
        <div class="dashboard-wrapper">
            @include('layouts.partials.sidebar')
            
            <div class="main-content">
                @include('layouts.partials.header')
                
                <div class="content">
                    @yield('content')
                </div>
            </div>
        </div>
    @else
        <!-- User Layout without Sidebar -->
        <div class="dashboard-wrapper">
            <div class="main-content full-width">
                @include('layouts.partials.header')
                
                <div class="content">
                    @yield('content')
                </div>

                <div class="footer">
                    <p>&copy; {{ date('Y') }} Rental Genset. All rights reserved.</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Sidebar Overlay for Mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <script>
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');
        }

        function toggleDropdown() {
            const dropdown = document.getElementById('userDropdown');
            dropdown.classList.toggle('show');
        }

        // Close dropdown when clicking outside
        window.onclick = function(event) {
            if (!event.target.matches('.dropdown-toggle') && !event.target.closest('.dropdown-toggle')) {
                const dropdown = document.getElementById('userDropdown');
                if (dropdown && dropdown.classList.contains('show')) {
                    dropdown.classList.remove('show');
                }
            }
        }
    </script>
</body>
</html>