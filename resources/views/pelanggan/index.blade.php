<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pelanggan & Member</title>
    <link rel="stylesheet" href="{{ asset('css/styling_n.css') }}">
</head>
<body>

    <div class="userbar">
        <span>{{ auth()->user()->name }} <span class="badge-role">{{ auth()->user()->role }}</span></span>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit">Keluar</button>
        </form>
    </div>

    <div class="page-header">
        <p class="breadcrumb">Dashboard > Pelanggan & Member</p>
        <h1>Data member</h1>
        <p>Kelola data pelanggan, level keanggotaan, dan status profil pengguna venue.</p>
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

    @can('create', \App\Models\Pelanggan::class)
        <a href="{{ route('pelanggan.create') }}">+ Tambah Pelanggan</a>
    @endcan
    <br><br>

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

            <button type="submit">Cari</button>
            <a href="{{ route('pelanggan.index') }}">Reset</a>
        </div>
    </form>
    <br>

    <table>
        <tr>
            <th>No</th>
            <th>Nama Pelanggan</th>
            <th>No. HP</th>
            <th>Level Member</th>
            <th>Tanggal Bergabung</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>

        @forelse ($pelanggan as $p)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $p->nama }}</td>
            <td>{{ $p->no_hp }}</td>
            <td><span class="{{ $p->level_member }}">{{ ucfirst($p->level_member) }}</span></td>
            <td>{{ $p->tanggal_bergabung }}</td>
            <td><span class="{{ $p->status }}">{{ ucfirst($p->status) }}</span></td>
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
                            <button type="submit" style="background:none;border:none;padding:0;font:inherit;color:inherit;text-decoration:underline;cursor:pointer;">Hapus</button>
                        </form>
                    @endcan
                @else
                    <span style="color:#94a3b8;">Tidak ada akses</span>
                @endcanany
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7">Data tidak ditemukan.</td>
        </tr>
        @endforelse
    </table>

</body>
</html>
