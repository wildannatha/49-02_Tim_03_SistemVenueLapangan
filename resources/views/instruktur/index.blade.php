<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Daftar Instruktur — Modul Instruktur & Coach</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

@include('partials.navbar', ['active' => 'index'])

<main class="main-content">
  <div class="page-header">
    <div>
      <div class="breadcrumb">Sistem Venue &rsaquo; Instruktur & Coach</div>
      <h1>Daftar Instruktur & Pelatih Mitra</h1>
      <p>Data instruktur, nomor lisensi, dan keahlian cabang olahraga.</p>
    </div>

    @if(auth()->user()->role === 'admin')
      <a href="{{ route('instruktur.create') }}" class="btn btn-primary">+ Tambah Instruktur</a>
    @endif
  </div>

  @if (session('success'))
    <div class="alert-success">{{ session('success') }}</div>
  @endif

  <form class="filter-box" method="get" action="{{ route('instruktur.index') }}">
    <input type="text" name="q" placeholder="Cari nama, nomor lisensi, atau kontak..." value="{{ $q }}">
    <select name="cabang">
      <option value="">Semua Cabang</option>
      @foreach ($cabangOptions as $c)
        <option value="{{ $c }}" {{ $cabang === $c ? 'selected' : '' }}>{{ $c }}</option>
      @endforeach
    </select>
    <select name="status">
      <option value="">Semua Status</option>
      <option value="Aktif" {{ $status === 'Aktif' ? 'selected' : '' }}>Aktif</option>
      <option value="Nonaktif" {{ $status === 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
    </select>
    <button type="submit" class="btn btn-primary">Cari</button>
    <a href="{{ route('instruktur.index') }}">Reset</a>
  </form>

  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th>No</th>
          <th>Nama Instruktur</th>
          <th>No. Lisensi</th>
          <th>Keahlian Cabang</th>
          <th>Level</th>
          <th>Tarif / Sesi</th>
          <th>Status</th>
          @if(auth()->user()->role === 'admin')
            <th class="col-center">Aksi</th>
          @endif
        </tr>
      </thead>
      <tbody>
        @foreach ($instruktur as $d)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td class="name-cell">
            <strong>{{ $d->nama }}</strong>
            <span>{{ $d->telepon }}</span>
          </td>
          <td>{{ $d->nomor_lisensi }}</td>
          <td>
            @foreach (explode(', ', $d->cabang) as $c)
              <span class="pill">{{ $c }}</span>
            @endforeach
          </td>
          <td>{{ $d->level_sertifikasi }}</td>
          <td>Rp {{ number_format($d->tarif, 0, ',', '.') }}</td>
          <td><span class="badge badge-{{ strtolower($d->status) }}">{{ $d->status }}</span></td>

          @if(auth()->user()->role === 'admin')
          <td class="col-center">
            <div class="action-cell">
              <a class="btn-edit-text" href="{{ route('instruktur.edit', $d->id) }}">Ubah</a>
              <span class="action-sep">|</span>
              <form method="post" action="{{ route('instruktur.destroy', $d->id) }}"
                    onsubmit="return confirm('Yakin hapus data ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-danger-text">Hapus</button>
              </form>
            </div>
          </td>
          @endif
        </tr>
        @endforeach
      </tbody>
    </table>

    @if ($instruktur->isEmpty())
    <div class="empty-state">
      <div class="big">Belum ada data instruktur</div>
      @if(auth()->user()->role === 'admin')
        <div>Klik "Tambah Instruktur" untuk mendaftarkan pelatih mitra pertama.</div>
      @endif
    </div>
    @endif
  </div>
</main>

</body>
</html>
