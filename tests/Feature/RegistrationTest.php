<?php

namespace Tests\Feature;

use App\Models\Pasien;
use App\Models\Poli;
use App\Models\Pendaftaran;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $poli;
    protected $pasien;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->poli = Poli::create(['nama_poli' => 'Poli Umum']);
        $this->pasien = Pasien::create([
            'nama_lengkap' => 'Budi Santoso',
            'nik' => '1234567890123456',
            'tanggal_lahir' => '1990-01-01',
            'jenis_kelamin' => 'Laki-laki',
            'alamat' => 'Jl. Merdeka No. 1',
            'nomor_telepon' => '08123456789',
        ]);
    }

    /** @test */
    public function nik_must_be_16_digits()
    {
        $response = $this->actingAs($this->user)->post(route('pasien.store'), [
            'nama_lengkap' => 'Pasien Salah',
            'nik' => '12345', // Too short
            'tanggal_lahir' => '1995-05-05',
            'jenis_kelamin' => 'Perempuan',
            'alamat' => 'Alamat Test',
            'nomor_telepon' => '0811111',
        ]);

        $response->assertSessionHasErrors('nik');
    }

    /** @test */
    public function prevent_duplicate_registration_on_same_day_and_poli()
    {
        $tanggal = date('Y-m-d');

        // First registration
        $this->actingAs($this->user)->post(route('pendaftaran.store'), [
            'pasien_id' => $this->pasien->id,
            'poli_id' => $this->poli->id,
            'tanggal_kunjungan' => $tanggal,
            'keluhan' => 'Sakit kepala',
        ]);

        // Second registration (same day, same poli)
        $response = $this->actingAs($this->user)->post(route('pendaftaran.store'), [
            'pasien_id' => $this->pasien->id,
            'poli_id' => $this->poli->id,
            'tanggal_kunjungan' => $tanggal,
            'keluhan' => 'Sakit perut',
        ]);

        $response->assertSessionHasErrors('pasien_id');
    }

    /** @test */
    public function can_change_registration_status()
    {
        $pendaftaran = Pendaftaran::create([
            'pasien_id' => $this->pasien->id,
            'poli_id' => $this->poli->id,
            'tanggal_kunjungan' => date('Y-m-d'),
            'keluhan' => 'Test status',
            'nomor_antrian' => 1,
            'status' => 'Menunggu',
        ]);

        $response = $this->actingAs($this->user)->patch(route('pendaftaran.update-status', $pendaftaran), [
            'status' => 'Dilayani',
        ]);

        $this->assertEquals('Dilayani', $pendaftaran->fresh()->status);
        $response->assertStatus(302); // Redirect back
    }
}
