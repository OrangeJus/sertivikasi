<header class="header">
    <div class="header-left">
        @if(Auth::user()->role === 'admin')
            <button class="menu-toggle" onclick="toggleSidebar()">
                <svg viewBox="0 0 24 24">
                    <path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"/>
                </svg>
            </button>
            <h1 class="page-title">@yield('page-title', 'Dashboard')</h1>
        @else
            <div style="display: flex; align-items: center; gap: 15px;">
                <div class="sidebar-logo" style="width: 45px; height: 45px;">
                    <svg viewBox="0 0 24 24">
                        <path d="M13 2L3 14h8l-2 8 10-12h-8l2-8z"/>
                    </svg>
                </div>
                <h1 class="page-title">Rental Genset</h1>
            </div>
        @endif
    </div>

    <div class="header-right">
        <div class="user-dropdown">
            <button class="dropdown-toggle" onclick="toggleDropdown()">
                <div class="user-avatar" style="width: 35px; height: 35px; font-size: 14px;">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <span style="font-weight: 500; color: #333;">{{ Auth::user()->name }}</span>
                <svg style="width: 16px; height: 16px; fill: #666;" viewBox="0 0 24 24">
                    <path d="M7 10l5 5 5-5z"/>
                </svg>
            </button>

            <div class="dropdown-menu" id="userDropdown">
                <a href="{{ route('profile.edit') }}" class="dropdown-item">
                    <svg style="width: 18px; height: 18px; fill: #333; margin-right: 10px; display: inline-block; vertical-align: middle;" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                    Profile
                </a>
                
                <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                    @csrf
                    <button type="submit" class="btn-logout">
                        <svg style="width: 18px; height: 18px; fill: #dc3545; margin-right: 10px; display: inline-block; vertical-align: middle;" viewBox="0 0 24 24">
                            <path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>