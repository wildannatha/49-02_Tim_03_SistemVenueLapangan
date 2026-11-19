@use('App\Models\Pemesanan')

@php
    $isEdit = $pemesanan->exists;
@endphp

<x-layouts.app :title="$isEdit ? 'Edit Pemesanan' : 'Input Pemesanan'" width="sm">
    <div class="card">
        <h1>Sewa Alat Olahraga</h1>
        <h2>{{ $isEdit ? 'Edit Data Pemesanan' : 'Form Pemesanan Baru' }}</h2>

        <x-form.errors />

        <form method="POST" action="{{ $isEdit ? route('pemesanan.update', $pemesanan) : route('pemesanan.store') }}">
            @csrf
            @if ($isEdit)
                @method('PUT')
            @endif

            <x-form.field name="nama" label="Nama" :value="$pemesanan->nama" required />
            <x-form.field name="tanggal" label="Tanggal" type="date" :value="$pemesanan->tanggal?->format('Y-m-d')" required />
            <x-form.field name="jam" label="Jam" type="time" :value="$pemesanan->jam_singkat" required />

            <h3>Pilih Jumlah Alat</h3>

            <div class="table-wrap">
                <table class="table">
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
                                <td>{{ number_format(Pemesanan::HARGA_PER_ALAT, 0, ',', '.') }}</td>
                                <td>
                                    <input type="number" name="{{ $kolom }}" min="0" max="99"
                                           value="{{ old($kolom, $pemesanan->{$kolom}) }}"
                                           @class(['is-invalid' => $errors->has($kolom)])
                                           aria-label="Jumlah {{ $label }}">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="actions">
                @if ($isEdit)
                    <button type="submit" class="btn btn-warning">Update Data</button>
                    <a href="{{ route('pemesanan.index') }}" class="btn btn-secondary">Batal</a>
                @else
                    <button type="submit" class="btn">Simpan Data</button>
                @endif
            </div>
        </form>
    </div>
</x-layouts.app>
