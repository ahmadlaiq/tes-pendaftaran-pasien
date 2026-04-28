<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poli extends Model
{
    /** @use HasFactory<\Database\Factories\PoliFactory> */
    use HasFactory;

    protected $fillable = [
        'nama_poli',
    ];

    public function pendaftarans()
    {
        return $this->hasMany(Pendaftaran::class);
    }
}
