<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    /** @use HasFactory<\Database\Factories\PendaftaranFactory> */
    use HasFactory;

    protected $fillable = [
        'pasien_id',
        'poli_id',
        'tanggal_kunjungan',
        'keluhan',
        'nomor_antrian',
        'status',
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }

    public function poli()
    {
        return $this->belongsTo(Poli::class);
    }
}
