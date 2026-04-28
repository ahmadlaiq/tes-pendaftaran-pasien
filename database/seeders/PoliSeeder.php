<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PoliSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $polis = [
            ['nama_poli' => 'Poli Umum'],
            ['nama_poli' => 'Poli Gigi'],
            ['nama_poli' => 'Poli Anak'],
            ['nama_poli' => 'Poli Penyakit Dalam'],
            ['nama_poli' => 'Poli Mata'],
        ];

        foreach ($polis as $poli) {
            \App\Models\Poli::create($poli);
        }
    }
}
