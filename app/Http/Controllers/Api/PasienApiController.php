<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePasienRequest;
use App\Http\Requests\UpdatePasienRequest;
use App\Http\Resources\PasienResource;
use App\Models\Pasien;
use Illuminate\Http\Request;

class PasienApiController extends Controller
{
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

    public function store(StorePasienRequest $request)
    {
        $pasien = Pasien::create($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Pasien berhasil ditambahkan',
            'data' => new PasienResource($pasien)
        ], 201);
    }

    public function show($id)
    {
        $pasien = Pasien::findOrFail($id);

        return response()->json([
            'status' => 'success',
            'message' => 'Detail pasien berhasil diambil',
            'data' => new PasienResource($pasien)
        ]);
    }

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
