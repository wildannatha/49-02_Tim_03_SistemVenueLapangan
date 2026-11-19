@use('App\Models\Pemesanan')

<x-layouts.app title="Dashboard Admin" width="lg">
    <div class="card">
        <h1>Dashboard Admin</h1>
        <p>Selamat datang, <strong>{{ auth()->user()->name }}</strong>.</p>

        <div class="stat-grid">
            <x-stat-card label="Total Pemesanan" :value="$totals->pemesanan" />
            <x-stat-card label="Total Pendapatan" :value="'Rp '.number_format($totals->pendapatan, 0, ',', '.')" />
            <x-stat-card label="User Terdaftar" :value="$totalUser" />
        </div>

        <div class="stat-grid">
            @foreach (Pemesanan::ALAT as $kolom => $label)
                <x-stat-card :label="$label.' Disewa'" :value="$totals->{$kolom}" small />
            @endforeach
        </div>

        <h2>5 Pemesanan Terbaru</h2>

        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Total Bayar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($terbaru as $pemesanan)
                        <tr>
                            <td>{{ $pemesanan->nama }}</td>
                            <td>{{ $pemesanan->tanggal->format('d/m/Y') }}</td>
                            <td>{{ $pemesanan->jam_singkat }}</td>
                            <td>{{ $pemesanan->total_bayar_rupiah }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="empty">Belum ada pemesanan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="actions">
            <a href="{{ route('pemesanan.index') }}" class="btn">Kelola Data</a>
            <a href="{{ url('/admin') }}" class="btn btn-secondary">Buka Panel Admin</a>
        </div>
    </div>
</x-layouts.app>
