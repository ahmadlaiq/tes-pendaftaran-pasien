<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use OpenApi\Attributes as OA;
use App\Http\Requests\StorePasienRequest;
use App\Http\Requests\UpdatePasienRequest;
use App\Http\Resources\PasienResource;
use App\Models\Pasien;
use Illuminate\Http\Request;

class PasienApiController extends Controller
{
    #[OA\Get(
        path: "/pasien",
        summary: "Daftar Pasien",
        description: "Mengambil daftar pasien dengan pagination dan pencarian.",
        security: [["bearerAuth" => []]],
        tags: ["Manajemen Pasien"],
        parameters: [
            new OA\Parameter(
                name: "q",
                in: "query",
                description: "Pencarian berdasarkan Nama atau NIK",
                required: false,
                schema: new OA\Schema(type: "string")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Daftar pasien berhasil diambil",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "status", type: "string", example: "success"),
                        new OA\Property(property: "message", type: "string", example: "Daftar pasien berhasil diambil"),
                        new OA\Property(property: "data", type: "object")
                    ]
                )
            )
        ]
    )]
    public function index(Request $request)
    {
        $query = Pasien::query();

        if ($request->has('q')) {
            $search = $request->q;
            $query->where('nama_lengkap', 'like', "%$search%")
                  ->orWhere('nik', 'like', "%$search%");
        }

        $pasiens = $query->paginate(10);

        return response()->json([
            'status' => 'success',
            'message' => 'Daftar pasien berhasil diambil',
            'data' => PasienResource::collection($pasiens)->response()->getData(true)
        ]);
    }

    #[OA\Post(
        path: "/pasien",
        summary: "Tambah Pasien Baru",
        description: "Menambahkan data pasien baru ke sistem.",
        security: [["bearerAuth" => []]],
        tags: ["Manajemen Pasien"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["nama_lengkap", "nik", "tanggal_lahir", "jenis_kelamin", "alamat", "nomor_telepon"],
                properties: [
                    new OA\Property(property: "nama_lengkap", type: "string", example: "Ani Wijaya"),
                    new OA\Property(property: "nik", type: "string", example: "3201234567890001"),
                    new OA\Property(property: "tanggal_lahir", type: "string", format: "date", example: "1995-05-15"),
                    new OA\Property(property: "jenis_kelamin", type: "string", example: "Perempuan"),
                    new OA\Property(property: "alamat", type: "string", example: "Jl. Mawar No. 10"),
                    new OA\Property(property: "nomor_telepon", type: "string", example: "08571234567")
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: "Pasien berhasil ditambahkan",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "status", type: "string", example: "success"),
                        new OA\Property(property: "message", type: "string", example: "Pasien berhasil ditambahkan"),
                        new OA\Property(property: "data", type: "object")
                    ]
                )
            ),
            new OA\Response(response: 422, description: "Validasi gagal")
        ]
    )]
    public function store(StorePasienRequest $request)
    {
        $pasien = Pasien::create($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Pasien berhasil ditambahkan',
            'data' => new PasienResource($pasien)
        ], 201);
    }

    #[OA\Get(
        path: "/pasien/{id}",
        summary: "Detail Pasien",
        description: "Mengambil informasi detail pasien berdasarkan ID.",
        security: [["bearerAuth" => []]],
        tags: ["Manajemen Pasien"],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Detail pasien berhasil diambil"),
            new OA\Response(response: 404, description: "Pasien tidak ditemukan")
        ]
    )]
    public function show($id)
    {
        $pasien = Pasien::findOrFail($id);

        return response()->json([
            'status' => 'success',
            'message' => 'Detail pasien berhasil diambil',
            'data' => new PasienResource($pasien)
        ]);
    }

    #[OA\Put(
        path: "/pasien/{id}",
        summary: "Update Pasien",
        description: "Memperbarui data pasien yang sudah ada.",
        security: [["bearerAuth" => []]],
        tags: ["Manajemen Pasien"],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))
        ],
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "nama_lengkap", type: "string"),
                    new OA\Property(property: "alamat", type: "string")
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: "Data pasien berhasil diperbarui"),
            new OA\Response(response: 404, description: "Pasien tidak ditemukan")
        ]
    )]
    public function update(UpdatePasienRequest $request, $id)
    {
        $pasien = Pasien::findOrFail($id);
        $pasien->update($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Data pasien berhasil diperbarui',
            'data' => new PasienResource($pasien)
        ]);
    }

    #[OA\Delete(
        path: "/pasien/{id}",
        summary: "Hapus Pasien",
        description: "Menghapus data pasien dari sistem.",
        security: [["bearerAuth" => []]],
        tags: ["Manajemen Pasien"],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Pasien berhasil dihapus"),
            new OA\Response(response: 404, description: "Pasien tidak ditemukan")
        ]
    )]
    public function destroy($id)
    {
        $pasien = Pasien::findOrFail($id);
        $pasien->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Pasien berhasil dihapus',
            'data' => null
        ]);
    }
}
