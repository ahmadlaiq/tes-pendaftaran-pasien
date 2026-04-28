<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    /** @use HasFactory<\Database\Factories\PasienFactory> */
    use HasFactory;

    protected $fillable = [
        'nama_lengkap',
        'nik',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'nomor_telepon',
    ];

    public function pendaftarans()
    {
        return $this->hasMany(Pendaftaran::class);
    }
}
