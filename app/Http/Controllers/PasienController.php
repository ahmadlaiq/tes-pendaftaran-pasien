<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Http\Requests\StorePasienRequest;
use App\Http\Requests\UpdatePasienRequest;
use Illuminate\Http\Request;

class PasienController extends Controller
{
    public function index(Request $request)
    {
        $query = Pasien::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('nama_lengkap', 'like', "%$search%")
                  ->orWhere('nik', 'like', "%$search%");
        }

        $pasiens = $query->latest()->paginate(10);

        return view('pasien.index', compact('pasiens'));
    }

    public function create()
    {
        return view('pasien.create');
    }

    public function store(StorePasienRequest $request)
    {
        Pasien::create($request->validated());

        return redirect()->route('pasien.index')->with('success', 'Pasien berhasil ditambahkan.');
    }

    public function show(Pasien $pasien)
    {
        return view('pasien.show', compact('pasien'));
    }

    public function edit(Pasien $pasien)
    {
        return view('pasien.edit', compact('pasien'));
    }

    public function update(UpdatePasienRequest $request, Pasien $pasien)
    {
        $pasien->update($request->validated());

        return redirect()->route('pasien.index')->with('success', 'Data pasien berhasil diperbarui.');
    }

    public function destroy(Pasien $pasien)
    {
        $pasien->delete();

        return redirect()->route('pasien.index')->with('success', 'Pasien berhasil dihapus.');
    }
}
