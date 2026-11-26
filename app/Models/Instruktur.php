<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Instruktur extends Model
{
    protected $table = 'instruktur';
    public $timestamps = false;

    protected $fillable = [
        'nama', 'nomor_lisensi', 'level_sertifikasi', 'cabang',
        'telepon', 'tarif', 'status', 'tanggal_gabung', 'catatan',
    ];
}