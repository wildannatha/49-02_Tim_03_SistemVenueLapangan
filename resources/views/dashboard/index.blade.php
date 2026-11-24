@use('App\Models\Pemesanan')

@php
    $user = auth()->user();

    // Dashboard hanya bisa dibuka admin, jadi semua hak akses aktif.
    $hakAkses = [
        ['Akses Dashboard', 'Melihat ringkasan dan profil akun'],
        ['Lihat Data Pemesanan', 'Akses daftar pemesanan alat'],
        ['Tambah & Ubah Data', 'Input dan edit pemesanan'],
        ['Hapus Data Pemesanan', 'Khusus hak akses Administrator'],
    ];
@endphp

<x-layouts.app title="Dashboard Admin">
    <section class="dashboard-hero">
        <div class="hero-content">
            <span class="hero-tag"><span class="status-indicator"></span> Sesi Login Aktif</span>
            <h1>Selamat datang, {{ $user->name }}! 👋</h1>
            <p>Anda masuk ke dalam sistem dengan hak akses sebagai <span class="hero-role-pill role-{{ $user->role }}">{{ $user->role }}</span></p>
        </div>

        <div class="hero-meta">
            <div class="meta-item">
                <span class="meta-label">Email Terdaftar</span>
                <span class="meta-val">{{ $user->email }}</span>
            </div>
            <div class="meta-item">
                <span class="meta-label">Bergabung Sejak</span>
                <span class="meta-val">{{ $user->created_at?->translatedFormat('d M Y') }}</span>
            </div>
        </div>
    </section>

    <div class="dashboard-grid">
        <div class="dashboard-main">
            <div class="card module-card highlight">
                <div class="card-icon-wrapper"><x-ui-icon name="calendar" :size="24" /></div>

                <div class="module-details">
                    <h3>Kelola Pemesanan Alat Olahraga</h3>
                    <p>Akses daftar pemesanan raket, sepatu, dan bola, lengkap dengan total bayar. Admin dapat menambah, mengubah, dan menghapus data.</p>

                    <div class="module-actions">
                        <a href="{{ route('pemesanan.index') }}" class="btn btn-primary">Buka Data Pemesanan <x-ui-icon name="chevron" :size="16" /></a>
                        <a href="{{ route('pemesanan.create') }}" class="btn btn-outline">+ Tambah Pemesanan</a>
                    </div>
                </div>
            </div>

            <div class="card">
                <h3 class="card-heading">Ringkasan Pemesanan</h3>

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
            </div>

            <div class="card">
                <h3 class="card-heading">5 Pemesanan Terbaru</h3>

                <div class="table-wrap">
                    <table>
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
                                    <td><strong>{{ $pemesanan->nama }}</strong></td>
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
            </div>
        </div>

        <aside class="card permission-card">
            <div class="card-title-row">
                <x-ui-icon name="lock" />
                <h4>Ringkasan Hak Akses Anda</h4>
            </div>

            <ul class="permission-list">
                @foreach ($hakAkses as [$judul, $keterangan])
                    <li class="active">
                        <span class="icon-check">✓</span>
                        <div>
                            <strong>{{ $judul }}</strong>
                            <small>{{ $keterangan }}</small>
                        </div>
                    </li>
                @endforeach
            </ul>
        </aside>
    </div>
</x-layouts.app>
