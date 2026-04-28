<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\Poli;
use App\Models\Pendaftaran;
use App\Http\Requests\StorePendaftaranRequest;
use App\Services\RegistrationService;
use Illuminate\Http\Request;

class PendaftaranController extends Controller
{
    protected $registrationService;

    public function __construct(RegistrationService $registrationService)
    {
        $this->registrationService = $registrationService;
    }

    public function index(Request $request)
    {
        $query = Pendaftaran::with(['pasien', 'poli']);

        if ($request->filled('tanggal')) {
            $query->where('tanggal_kunjungan', $request->tanggal);
        }

        if ($request->filled('poli_id')) {
            $query->where('poli_id', $request->poli_id);
        }

        $pendaftarans = $query->latest()->paginate(10);
        $polis = Poli::all();

        return view('pendaftaran.index', compact('pendaftarans', 'polis'));
    }

    public function create(Request $request)
    {
        $pasien = null;
        if ($request->has('pasien_id')) {
            $pasien = Pasien::findOrFail($request->pasien_id);
        }
        $pasiens = Pasien::all();
        $polis = Poli::all();
        return view('pendaftaran.create', compact('pasien', 'pasiens', 'polis'));
    }

    public function store(StorePendaftaranRequest $request)
    {
        $data = $request->validated();
        $data['nomor_antrian'] = $this->registrationService->generateQueueNumber(
            $data['poli_id'],
            $data['tanggal_kunjungan']
        );
        
        Pendaftaran::create($data);

        return redirect()->route('pendaftaran.index')->with('success', 'Pendaftaran berhasil dibuat.');
    }

    public function updateStatus(Request $request, Pendaftaran $pendaftaran)
    {
        $request->validate([
            'status' => 'required|in:Menunggu,Dilayani,Selesai'
        ]);

        $pendaftaran->update(['status' => $request->status]);

        return back()->with('success', 'Status pendaftaran berhasil diperbarui.');
    }

    public function exportPdf(Request $request)
    {
        $query = Pendaftaran::with(['pasien', 'poli']);

        if ($request->filled('tanggal')) {
            $query->where('tanggal_kunjungan', $request->tanggal);
        }

        if ($request->filled('poli_id')) {
            $query->where('poli_id', $request->poli_id);
        }

        $pendaftarans = $query->orderBy('nomor_antrian', 'asc')->get();
        $poli = $request->filled('poli_id') ? Poli::find($request->poli_id) : null;
        $tanggal = $request->filled('tanggal') ? $request->tanggal : date('Y-m-d');

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pendaftaran.pdf', compact('pendaftarans', 'poli', 'tanggal'));
        
        return $pdf->stream('laporan-kunjungan-' . $tanggal . '.pdf');
    }
}
