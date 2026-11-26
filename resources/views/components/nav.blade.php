@php
    $user = auth()->user();
@endphp

<header class="app-navbar">
    <div class="nav-container">
        <div class="nav-left">
            <a href="{{ route('dashboard') }}" class="nav-brand">
                <span class="brand-icon"><x-ui-icon name="user" /></span>
                <span>Sistem<strong>Venue</strong></span>
            </a>

            <nav class="nav-links">
                <a href="{{ route('dashboard') }}" @class(['nav-link', 'active' => request()->routeIs('dashboard')])>Dashboard</a>
                <a href="{{ route('lapangan.index') }}" @class(['nav-link', 'active' => request()->routeIs('lapangan.*')])>Data Lapangan</a>
                <a href="{{ route('pelanggan.index') }}" @class(['nav-link', 'active' => request()->routeIs('pelanggan.*')])>Data Pelanggan</a>
                <a href="{{ route('instruktur.index') }}" @class(['nav-link', 'active' => request()->routeIs('instruktur.*')])>Data Instruktur</a>
                <a href="{{ route('pemesanan.index') }}" @class(['nav-link', 'active' => request()->routeIs('pemesanan.*')])>Data Pemesanan</a>
            </nav>
        </div>

        <div class="nav-right">
            <div class="user-profile-badge">
                <span class="user-avatar">{{ mb_strtoupper(mb_substr($user->name, 0, 1)) }}</span>
                <div class="user-info">
                    <span class="user-name">{{ $user->name }}</span>
                    <span class="badge-role {{ $user->role }}">{{ strtoupper($user->role) }}</span>
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
