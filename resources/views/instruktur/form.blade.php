@php
  $isEdit = isset($instruktur);
  $cabangTerpilih = old('cabang', $isEdit ? explode(', ', $instruktur->cabang) : []);
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Form Instruktur — Modul Instruktur & Coach</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

@include('partials.navbar', ['active' => $isEdit ? 'index' : 'create'])

<main class="main-content">
  <div class="page-header">
    <div>
      <div class="breadcrumb">Instruktur & Coach &rsaquo; {{ $isEdit ? 'Edit' : 'Tambah' }}</div>
      <h1>{{ $isEdit ? 'Edit Data Instruktur' : 'Tambah Instruktur Baru' }}</h1>
      <p>
        {{ $isEdit ? 'Memperbarui data untuk ' . $instruktur->nama . '.' : 'Lengkapi data pelatih mitra untuk didaftarkan ke sistem venue.' }}
      </p>
    </div>
  </div>

  <form id="instrukturForm" method="post"
        action="{{ $isEdit ? route('instruktur.update', $instruktur->id) : route('instruktur.store') }}">
    @csrf
    @if ($isEdit)
      @method('PUT')
    @endif

    <div class="field-grid">
      <div class="field full {{ $errors->has('nama') ? 'invalid' : '' }}">
        <label>Nama Instruktur/Pelatih <span class="req">*</span></label>
        <input type="text" name="nama" placeholder="cth. Andika Pratama" autocomplete="off"
               value="{{ old('nama', $instruktur->nama ?? '') }}">
        <small class="err">{{ $errors->first('nama') }}</small>
      </div>

      <div class="field {{ $errors->has('nomor_lisensi') ? 'invalid' : '' }}">
        <label>Nomor Lisensi <span class="req">*</span></label>
        <input type="text" name="nomor_lisensi" placeholder="cth. LSN-2024-0091" autocomplete="off"
               value="{{ old('nomor_lisensi', $instruktur->nomor_lisensi ?? '') }}">
        <small class="err">{{ $errors->first('nomor_lisensi') }}</small>
      </div>

      <div class="field {{ $errors->has('level_sertifikasi') ? 'invalid' : '' }}">
        <label>Level Sertifikasi <span class="req">*</span></label>
        <select name="level_sertifikasi">
          <option value="">Pilih level</option>
          @foreach (['Daerah', 'Nasional', 'Internasional'] as $lv)
            <option value="{{ $lv }}" {{ old('level_sertifikasi', $instruktur->level_sertifikasi ?? '') === $lv ? 'selected' : '' }}>{{ $lv }}</option>
          @endforeach
        </select>
        <small class="err">{{ $errors->first('level_sertifikasi') }}</small>
      </div>

      <div class="field full {{ $errors->has('cabang') ? 'invalid' : '' }}">
        <label>Keahlian Cabang Olahraga <span class="req">*</span></label>
        <div class="checkgroup">
          @foreach ($cabangOptions as $c)
            <label>
              <input type="checkbox" name="cabang[]" value="{{ $c }}" {{ in_array($c, $cabangTerpilih) ? 'checked' : '' }}>
              {{ $c }}
            </label>
          @endforeach
        </div>
        <small class="err">{{ $errors->first('cabang') }}</small>
      </div>

      <div class="field {{ $errors->has('telepon') ? 'invalid' : '' }}">
        <label>Nomor Telepon <span class="req">*</span></label>
        <input type="text" name="telepon" placeholder="cth. 081234567890" autocomplete="off"
               value="{{ old('telepon', $instruktur->telepon ?? '') }}">
        <small class="err">{{ $errors->first('telepon') }}</small>
      </div>

      <div class="field {{ $errors->has('tarif') ? 'invalid' : '' }}">
        <label>Tarif per Sesi (Rp) <span class="req">*</span></label>
        <input type="number" name="tarif" placeholder="cth. 150000" min="0"
               value="{{ old('tarif', $instruktur->tarif ?? '') }}">
        <small class="err">{{ $errors->first('tarif') }}</small>
      </div>

      <div class="field">
        <label>Status Mitra</label>
        <select name="status">
          @foreach (['Aktif', 'Nonaktif'] as $st)
            <option value="{{ $st }}" {{ old('status', $instruktur->status ?? 'Aktif') === $st ? 'selected' : '' }}>{{ $st }}</option>
          @endforeach
        </select>
      </div>

      <div class="field">
        <label>Tanggal Bergabung</label>
        <input type="date" name="tanggal_gabung" value="{{ old('tanggal_gabung', $instruktur->tanggal_gabung ?? '') }}">
      </div>

      <div class="field full">
        <label>Catatan (opsional)</label>
        <textarea name="catatan" rows="2" placeholder="Catatan tambahan mengenai instruktur...">{{ old('catatan', $instruktur->catatan ?? '') }}</textarea>
      </div>
    </div>

    <div class="form-actions">
      <button type="submit" class="btn btn-primary">{{ $isEdit ? 'Perbarui Data' : 'Simpan Data' }}</button>
      <a href="{{ route('instruktur.index') }}" class="btn btn-ghost">Batal</a>
    </div>
    
  </form>
</main>

</body>
</html>