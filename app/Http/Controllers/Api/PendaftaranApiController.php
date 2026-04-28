<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use OpenApi\Attributes as OA;
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

    #[OA\Get(
        path: "/pendaftaran",
        summary: "Daftar Pendaftaran Kunjungan",
        description: "Mengambil daftar pendaftaran kunjungan dengan filter tanggal dan poli.",
        security: [["bearerAuth" => []]],
        tags: ["Pendaftaran Kunjungan"],
        parameters: [
            new OA\Parameter(name: "tanggal", in: "query", description: "Filter tanggal (YYYY-MM-DD)", schema: new OA\Schema(type: "string", format: "date")),
            new OA\Parameter(name: "poli_id", in: "query", description: "Filter ID Poli", schema: new OA\Schema(type: "integer"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Daftar pendaftaran berhasil diambil")
        ]
    )]
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

    #[OA\Post(
        path: "/pendaftaran",
        summary: "Buat Pendaftaran Baru",
        description: "Mendaftarkan pasien ke poli tertentu.",
        security: [["bearerAuth" => []]],
        tags: ["Pendaftaran Kunjungan"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["pasien_id", "poli_id", "tanggal_kunjungan", "keluhan"],
                properties: [
                    new OA\Property(property: "pasien_id", type: "integer", example: 1),
                    new OA\Property(property: "poli_id", type: "integer", example: 2),
                    new OA\Property(property: "tanggal_kunjungan", type: "string", format: "date", example: "2026-04-28"),
                    new OA\Property(property: "keluhan", type: "string", example: "Sakit gigi geraham kanan")
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: "Pendaftaran berhasil dibuat"),
            new OA\Response(response: 422, description: "Validasi gagal")
        ]
    )]
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

    #[OA\Patch(
        path: "/pendaftaran/{id}/status",
        summary: "Ubah Status Kunjungan",
        description: "Memperbarui status pendaftaran kunjungan.",
        security: [["bearerAuth" => []]],
        tags: ["Pendaftaran Kunjungan"],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["status"],
                properties: [
                    new OA\Property(property: "status", type: "string", enum: ["Menunggu", "Dilayani", "Selesai"], example: "Dilayani")
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: "Status pendaftaran berhasil diperbarui"),
            new OA\Response(response: 404, description: "Pendaftaran tidak ditemukan")
        ]
    )]
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
