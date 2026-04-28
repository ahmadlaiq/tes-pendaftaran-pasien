<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePendaftaranRequest;
use App\Http\Resources\PendaftaranResource;
use App\Models\Pendaftaran;
use App\Services\RegistrationService;
use Illuminate\Http\Request;

class PendaftaranApiController extends Controller
{
    protected $registrationService;

    public function __construct(RegistrationService $registrationService)
    {
        $this->registrationService = $registrationService;
    }

    public function index(Request $request)
    {
        $query = Pendaftaran::with(['pasien', 'poli']);

        if ($request->has('tanggal')) {
            $query->where('tanggal_kunjungan', $request->tanggal);
        }

        if ($request->has('poli_id')) {
            $query->where('poli_id', $request->poli_id);
        }

        $pendaftarans = $query->paginate(10);

        return response()->json([
            'status' => 'success',
            'message' => 'Daftar pendaftaran berhasil diambil',
            'data' => PendaftaranResource::collection($pendaftarans)->response()->getData(true)
        ]);
    }

    public function store(StorePendaftaranRequest $request)
    {
        $data = $request->validated();
        $data['nomor_antrian'] = $this->registrationService->generateQueueNumber(
            $data['poli_id'],
            $data['tanggal_kunjungan']
        );
        $data['status'] = 'Menunggu';

        $pendaftaran = Pendaftaran::create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Pendaftaran berhasil dibuat',
            'data' => new PendaftaranResource($pendaftaran->load(['pasien', 'poli']))
        ], 201);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Menunggu,Dilayani,Selesai'
        ]);

        $pendaftaran = Pendaftaran::findOrFail($id);
        $pendaftaran->update(['status' => $request->status]);

        return response()->json([
            'status' => 'success',
            'message' => 'Status pendaftaran berhasil diperbarui',
            'data' => new PendaftaranResource($pendaftaran->load(['pasien', 'poli']))
        ]);
    }
}
