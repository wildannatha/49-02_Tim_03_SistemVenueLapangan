@php
    $user = auth()->user();
@endphp

<header class="app-navbar">
    <div class="nav-container">
        <div class="nav-left">
            <a href="{{ $user->homeUrl() }}" class="nav-brand">
                <span class="brand-icon"><x-ui-icon name="user" /></span>
                <span>Sistem<strong>Venue</strong></span>
            </a>

            <nav class="nav-links">
                @if ($user->isAdmin())
                    <a href="{{ route('dashboard') }}" @class(['nav-link', 'active' => request()->routeIs('dashboard')])>Dashboard</a>
                @endif

                <a href="{{ route('pemesanan.create') }}" @class(['nav-link', 'active' => request()->routeIs('pemesanan.create', 'pemesanan.edit')])>Input Pemesanan</a>
                <a href="{{ route('pemesanan.index') }}" @class(['nav-link', 'active' => request()->routeIs('pemesanan.index')])>Data Pemesanan</a>

                @if ($user->isAdmin())
                    <a href="{{ url('/admin') }}" class="nav-link">Panel Admin</a>
                @endif
            </nav>
        </div>

        <div class="nav-right">
            <div class="user-profile-badge">
                <span class="user-avatar">{{ mb_strtoupper(mb_substr($user->name, 0, 1)) }}</span>
                <div class="user-info">
                    <span class="user-name">{{ $user->name }}</span>
                    <span class="badge-role {{ $user->role }}">{{ $user->role }}</span>
                </div>
            </div>

            <form action="{{ route('logout') }}" method="POST" class="logout-form">
                @csrf
                <button type="submit" class="btn-logout">
                    <x-ui-icon name="logout" :size="16" /> Keluar
                </button>
            </form>
        </div>
    </div>
</header>
