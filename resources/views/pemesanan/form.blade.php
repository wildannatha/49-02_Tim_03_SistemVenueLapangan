@use('App\Models\Pemesanan')

@php
    $isEdit = $pemesanan->exists;
@endphp

<x-layouts.app :title="$isEdit ? 'Edit Pemesanan' : 'Input Pemesanan'">
    <div class="page-header">
        <div class="breadcrumb">
            <a href="{{ route('pemesanan.index') }}">Pemesanan Alat</a> &gt; {{ $isEdit ? 'Edit' : 'Tambah' }}
        </div>
        <h1>{{ $isEdit ? 'Edit Data Pemesanan' : 'Sewa Alat Olahraga' }}</h1>
        <p>{{ $isEdit ? 'Perbarui data pemesanan, total bayar dihitung ulang otomatis.' : 'Isi data pemesanan dan pilih jumlah alat yang disewa.' }}</p>
    </div>

    <div class="form-card form-card--wide">
        <x-form.errors />

        <form method="POST" action="{{ $isEdit ? route('pemesanan.update', $pemesanan) : route('pemesanan.store') }}">
            @csrf
            @if ($isEdit)
                @method('PUT')
            @endif

            <x-form.field name="nama" label="Nama:" :value="$pemesanan->nama" required />
            <x-form.field name="tanggal" label="Tanggal:" type="date" :value="$pemesanan->tanggal?->format('Y-m-d')" required />
            <x-form.field name="jam" label="Jam:" type="time" :value="$pemesanan->jam_singkat" required />

            <h3 class="form-section-title">Pilih Jumlah Alat</h3>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Alat</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (Pemesanan::ALAT as $kolom => $label)
                            <tr>
                                <td>{{ $label }}</td>
                                <td>Rp {{ number_format(Pemesanan::HARGA_PER_ALAT, 0, ',', '.') }}</td>
                                <td>
                                    <input type="number" name="{{ $kolom }}" min="0" max="99"
                                           value="{{ old($kolom, $pemesanan->{$kolom}) }}"
                                           @class(['qty-input', 'is-invalid' => $errors->has($kolom)])
                                           aria-label="Jumlah {{ $label }}">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="form-actions">
                <button type="submit">{{ $isEdit ? 'Update Data' : 'Simpan Data' }}</button>

                @if ($isEdit)
                    <a href="{{ route('pemesanan.index') }}" class="btn btn-outline">Batal</a>
                @endif
            </div>
        </form>
    </div>
</x-layouts.app>
