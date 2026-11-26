@php
  $u = auth()->user();
  $active = $active ?? 'index';
@endphp
<header class="app-navbar">
  <div class="nav-container">
    <div class="nav-left">
      <a href="{{ route('dashboard') }}" class="nav-brand">
        <span class="brand-icon">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        </span>
        <span>Sistem<strong>Venue</strong></span>
      </a>
      <nav class="nav-links">
        <a href="{{ route('dashboard') }}" class="nav-link">Dashboard</a>
        <a href="{{ route('lapangan.index') }}" class="nav-link">Data Lapangan</a>
        <a href="{{ route('pelanggan.index') }}" class="nav-link">Data Pelanggan</a>
        <a href="{{ route('instruktur.index') }}" class="nav-link {{ $active === 'index' ? 'active' : '' }}">Data Instruktur</a>
      </nav>
    </div>

    <div class="nav-right">
      <div class="user-profile-badge">
        <span class="user-avatar">{{ strtoupper(substr($u->name, 0, 1)) }}</span>
        <div class="user-info">
          <span class="user-name">{{ $u->name }}</span>
          <span class="badge-role {{ $u->role }}">{{ strtoupper($u->role) }}</span>
        </div>
      </div>
      <form method="POST" action="{{ route('logout') }}" class="logout-form">
        @csrf
        <button type="submit" class="btn-logout">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
          Keluar
        </button>
      </form>
    </div>
  </div>
</header>
