@php
    $user = auth()->user();
@endphp

<nav class="navbar">
    <div class="navbar-links">
        @if ($user->isAdmin())
            <a href="{{ route('dashboard') }}" @class(['active' => request()->routeIs('dashboard')])>Dashboard</a>
        @endif

        <a href="{{ route('pemesanan.create') }}" @class(['active' => request()->routeIs('pemesanan.create', 'pemesanan.edit')])>Input Data</a>
        <a href="{{ route('pemesanan.index') }}" @class(['active' => request()->routeIs('pemesanan.index')])>Data Pemesanan</a>

        @if ($user->isAdmin())
            <a href="{{ url('/admin') }}">Panel Admin</a>
        @endif
    </div>

    <div class="navbar-user">
        <span>{{ $user->name }} ({{ $user->role }})</span>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </div>
</nav>
