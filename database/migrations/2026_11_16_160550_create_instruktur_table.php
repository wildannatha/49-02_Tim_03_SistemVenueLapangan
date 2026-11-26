<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('instruktur', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->string('nomor_lisensi', 50)->unique();
            $table->enum('level_sertifikasi', ['Daerah', 'Nasional', 'Internasional']);
            $table->string('cabang');
            $table->string('telepon', 20);
            $table->integer('tarif');
            $table->enum('status', ['Aktif', 'Nonaktif'])->default('Aktif');
            $table->date('tanggal_gabung')->nullable();
            $table->text('catatan')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('instruktur');
    }
};
