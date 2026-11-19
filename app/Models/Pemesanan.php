<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    use HasFactory;

    /** Harga sewa per satu alat (rupiah). */
    public const HARGA_PER_ALAT = 25_000;

    /** Alat yang bisa disewa: kolom di database => label tampilan. */
    public const ALAT = [
        'raket' => 'Raket Badminton',
        'sepatu' => 'Sepatu Futsal',
        'bola' => 'Bola Futsal',
    ];

    /**
     * 'total_bayar' sengaja tidak ada di sini: selalu dihitung otomatis
     * saat disimpan, jadi tidak bisa diisi dari luar.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nama',
        'tanggal',
        'jam',
        'raket',
        'sepatu',
        'bola',
    ];

    protected $attributes = [
        'raket' => 0,
        'sepatu' => 0,
        'bola' => 0,
        'total_bayar' => 0,
    ];

    protected static function booted(): void
    {
        static::saving(function (self $pemesanan): void {
            $pemesanan->total_bayar = $pemesanan->hitungTotal();
        });
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
            'raket' => 'integer',
            'sepatu' => 'integer',
            'bola' => 'integer',
            'total_bayar' => 'integer',
        ];
    }

    public function hitungTotal(): int
    {
        $jumlahAlat = collect(array_keys(self::ALAT))
            ->sum(fn (string $alat): int => (int) $this->{$alat});

        return $jumlahAlat * self::HARGA_PER_ALAT;
    }

    /** Jam tanpa detik, contoh: "10:00". */
    protected function jamSingkat(): Attribute
    {
        return Attribute::get(fn (): string => substr((string) $this->jam, 0, 5));
    }

    /** Total bayar siap tampil, contoh: "Rp 75.000". */
    protected function totalBayarRupiah(): Attribute
    {
        return Attribute::get(
            fn (): string => 'Rp '.number_format($this->total_bayar, 0, ',', '.')
        );
    }
}
