<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Dulu model memakai tabel "pemesanan" (singular) padahal migration membuat
 * "pemesanans". Sekarang semuanya memakai "pemesanans".
 *
 * - Di database baru, migration ini tidak melakukan apa-apa.
 * - Kalau tabel lama "pemesanan" masih ada, datanya dipindahkan.
 *   Tabel lama TIDAK dihapus, jadi aman; hapus manual setelah dicek.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('pemesanan')) {
            return;
        }

        if (! Schema::hasTable('pemesanans')) {
            Schema::rename('pemesanan', 'pemesanans');

            if (! Schema::hasColumn('pemesanans', 'created_at')) {
                Schema::table('pemesanans', fn (Blueprint $table) => $table->timestamps());
            }

            return;
        }

        // Dua-duanya ada: salin data lama hanya kalau tabel baru masih kosong.
        if (DB::table('pemesanans')->doesntExist()) {
            DB::table('pemesanan')->orderBy('id')->each(function ($row) {
                DB::table('pemesanans')->insert([
                    'nama' => $row->nama,
                    'tanggal' => $row->tanggal,
                    'jam' => $row->jam,
                    'raket' => $row->raket ?? 0,
                    'sepatu' => $row->sepatu ?? 0,
                    'bola' => $row->bola ?? 0,
                    'total_bayar' => $row->total_bayar ?? 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            });
        }
    }

    public function down(): void
    {
        // Sengaja kosong: penggabungan nama tabel tidak dibalik.
    }
};
