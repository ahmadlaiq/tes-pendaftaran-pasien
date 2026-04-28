<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PendaftaranResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'pasien' => new PasienResource($this->whenLoaded('pasien')),
            'poli' => $this->poli->nama_poli ?? null,
            'tanggal_kunjungan' => $this->tanggal_kunjungan,
            'keluhan' => $this->keluhan,
            'nomor_antrian' => $this->nomor_antrian,
            'status' => $this->status,
            'created_at' => $this->created_at,
        ];
    }
}
