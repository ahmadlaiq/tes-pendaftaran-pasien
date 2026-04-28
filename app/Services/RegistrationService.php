<?php

namespace App\Services;

use App\Models\Pendaftaran;
use Carbon\Carbon;

class RegistrationService
{
    /**
     * Generate the next queue number for a given poli and date.
     *
     * @param int $poliId
     * @param string $tanggal
     * @return int
     */
    public function generateQueueNumber($poliId, $tanggal)
    {
        $lastRegistration = Pendaftaran::where('poli_id', $poliId)
            ->where('tanggal_kunjungan', $tanggal)
            ->orderBy('nomor_antrian', 'desc')
            ->first();

        return $lastRegistration ? $lastRegistration->nomor_antrian + 1 : 1;
    }

    /**
     * Check if a patient has already registered for a given poli on a given date.
     *
     * @param int $pasienId
     * @param int $poliId
     * @param string $tanggal
     * @return bool
     */
    public function hasRegisteredToday($pasienId, $poliId, $tanggal)
    {
        return Pendaftaran::where('pasien_id', $pasienId)
            ->where('poli_id', $poliId)
            ->where('tanggal_kunjungan', $tanggal)
            ->exists();
    }
}
