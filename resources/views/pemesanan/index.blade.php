@use('App\Models\Pemesanan')

<x-layouts.app title="Data Pemesanan" width="lg">
    <div class="card">
        <h1>Daftar Pemesanan</h1>

        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama</th>
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
                            <td>{{ $pemesanan->nama }}</td>
                            <td>{{ $pemesanan->tanggal->format('d/m/Y') }}</td>
                            <td>{{ $pemesanan->jam_singkat }}</td>
                            <td>{{ $pemesanan->total_bayar_rupiah }}</td>
                            @can('update', $pemesanan)
                                <td class="actions-cell">
                                    <a href="{{ route('pemesanan.edit', $pemesanan) }}" class="btn btn-sm btn-warning">Edit</a>

                                    <form action="{{ route('pemesanan.destroy', $pemesanan) }}" method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>
                            @endcan
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="empty">Belum ada pemesanan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.app>
