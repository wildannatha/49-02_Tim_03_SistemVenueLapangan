<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pelanggan & Member - Sistem Venue</title>
    <link rel="stylesheet" href="{{ asset('css/styling_n.css') }}">
</head>
<body>

    <header class="app-navbar">
        <div class="nav-container">
            <div class="nav-left">
                <a href="{{ route('dashboard') }}" class="nav-brand">
                    <div class="brand-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="4" width="20" height="16" rx="2"></rect>
                            <line x1="12" y1="4" x2="12" y2="20"></line>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                    </div>
                    <span>Sistem<strong>Venue</strong></span>
                </a>
                <nav class="nav-links">
                    <a href="{{ route('dashboard') }}" class="nav-link">Dashboard</a>
                    <a href="{{ route('lapangan.index') }}" class="nav-link">Data Lapangan</a>
                    <a href="{{ route('pelanggan.index') }}" class="nav-link active">Data Pelanggan</a>
                    <a href="{{ route('instruktur.index') }}" class="nav-link">Data Instruktur</a>
                    <a href="{{ route('pemesanan.index') }}" class="nav-link">Data Pemesanan</a>
                </nav>
            </div>

            <div class="nav-right">
                <div class="user-profile-badge">
                    <div class="user-avatar">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="user-info">
                        <span class="user-name">{{ auth()->user()->name }}</span>
                        <span class="badge-role role-{{ auth()->user()->role }}">{{ ucfirst(auth()->user()->role) }}</span>
                    </div>
                </div>

                <form action="{{ route('logout') }}" method="POST" class="logout-form">
                    @csrf
                    <button type="submit" class="btn-logout" title="Keluar dari sistem">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                            <polyline points="16 17 21 12 16 7"></polyline>
                            <line x1="21" y1="12" x2="9" y2="12"></line>
                        </svg>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>
        </div>
    </header>

    <main class="main-content">
        <div class="page-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
            <div>
                <p class="breadcrumb"><a href="{{ route('dashboard') }}">Dashboard</a> &gt; Pelanggan & Member</p>
                <h1>Data Pelanggan & Member</h1>
                <p>Kelola data pelanggan, level keanggotaan, dan status profil pengguna venue.</p>
            </div>
            @can('create', \App\Models\Pelanggan::class)
                <a href="{{ route('pelanggan.create') }}" class="btn btn-primary">+ Tambah Pelanggan</a>
            @endcan
        </div>

        @if (session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        @can('lihat-ringkasan')
        <div class="summary">
            <div class="summary-card">
                <p>Total Pelanggan</p>
                <h2>{{ $ringkasan['total'] }}</h2>
            </div>
            <div class="summary-card">
                <p>Member Basic</p>
                <h2>{{ $ringkasan['basic'] }}</h2>
            </div>
            <div class="summary-card">
                <p>Member Gold</p>
                <h2>{{ $ringkasan['gold'] }}</h2>
            </div>
            <div class="summary-card">
                <p>Member VIP</p>
                <h2>{{ $ringkasan['vip'] }}</h2>
            </div>
            <div class="summary-card">
                <p>Status Aktif</p>
                <h2>{{ $ringkasan['aktif'] }}</h2>
            </div>
        </div>
        @endcan

        <form method="GET" action="{{ route('pelanggan.index') }}">
            <div class="filter-box">
                <input type="text" name="cari" placeholder="Cari nama, email, atau no. HP..." value="{{ $cari }}">

                <select name="level">
                    <option value="">Semua Level Member</option>
                    <option value="basic" @selected($level == 'basic')>Basic</option>
                    <option value="gold" @selected($level == 'gold')>Gold</option>
                    <option value="vip" @selected($level == 'vip')>VIP</option>
                </select>

                <select name="status">
                    <option value="">Semua Status</option>
                    <option value="aktif" @selected($status == 'aktif')>Aktif</option>
                    <option value="nonaktif" @selected($status == 'nonaktif')>Nonaktif</option>
                </select>

                <button type="submit" class="btn btn-primary">Cari</button>
                <a href="{{ route('pelanggan.index') }}">Reset</a>
            </div>
        </form>

        <div style="overflow-x: auto;">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pelanggan</th>
                        <th>No. HP</th>
                        <th>Level Member</th>
                        <th>Tanggal Bergabung</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pelanggan as $p)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><strong>{{ $p->nama }}</strong></td>
                        <td>{{ $p->no_hp ?? '-' }}</td>
                        <td><span class="badge-pill {{ $p->level_member }}">{{ ucfirst($p->level_member) }}</span></td>
                        <td>{{ $p->tanggal_bergabung }}</td>
                        <td><span class="badge-pill {{ $p->status }}">{{ ucfirst($p->status) }}</span></td>
                        <td>
                            @canany(['update', 'delete'], $p)
                                @can('update', $p)
                                    <a href="{{ route('pelanggan.edit', $p) }}">Ubah</a>
                                @endcan

                                @can('delete', $p)
                                    |
                                    <form action="{{ route('pelanggan.destroy', $p) }}" method="POST" style="display:inline"
                                          onsubmit="return confirm('Yakin mau menghapus data ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="background:none;border:none;padding:0;font:inherit;color:#ef4444;text-decoration:underline;cursor:pointer;">Hapus</button>
                                    </form>
                                @endcan
                            @else
                                <span style="color:#94a3b8;">Tidak ada akses</span>
                            @endcanany
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align: center; color: var(--text-muted); padding: 32px;">Data tidak ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>

</body>
</html>
