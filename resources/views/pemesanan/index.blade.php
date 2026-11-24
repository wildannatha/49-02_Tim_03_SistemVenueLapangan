@use('App\Models\Pemesanan')

<x-layouts.app title="Data Pemesanan">
    <div class="page-header">
        <div class="page-header-row">
            <div>
                <div class="breadcrumb">
                    @if (auth()->user()->isAdmin())
                        <a href="{{ route('dashboard') }}">Dashboard</a> &gt;
                    @endif
                    Pemesanan Alat
                </div>
                <h1>Data Pemesanan Alat</h1>
                <p>Kelola pemesanan raket, sepatu, dan bola beserta total pembayarannya.</p>
            </div>

            <a href="{{ route('pemesanan.create') }}" class="btn btn-primary"><x-ui-icon name="plus" :size="16" /> Tambah Pemesanan</a>
        </div>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pemesan</th>
                    <th>Tanggal</th>
                    <th>Jam</th>
                    <th>Total Bayar</th>
                    @can('deleteAny', Pemesanan::class)
                        <th>Aksi</th>
                    @endcan
                </tr>
            </thead>
            <tbody>
                @forelse ($pemesanans as $pemesanan)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><strong>{{ $pemesanan->nama }}</strong></td>
                        <td>{{ $pemesanan->tanggal->format('d/m/Y') }}</td>
                        <td>{{ $pemesanan->jam_singkat }}</td>
                        <td>{{ $pemesanan->total_bayar_rupiah }}</td>
                        @can('update', $pemesanan)
                            <td>
                                <div class="action-links">
                                    <a href="{{ route('pemesanan.edit', $pemesanan) }}">Ubah</a>
                                    |
                                    <form action="{{ route('pemesanan.destroy', $pemesanan) }}" method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-reset link-danger">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        @endcan
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="empty">Belum ada pemesanan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layouts.app>
