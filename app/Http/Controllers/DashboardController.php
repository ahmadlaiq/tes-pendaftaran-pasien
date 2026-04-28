<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\Pendaftaran;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today()->toDateString();
        
        $stats = [
            'total_pasien' => Pasien::count(),
            'kunjungan_hari_ini' => Pendaftaran::where('tanggal_kunjungan', $today)->count(),
            'antrian_aktif' => Pendaftaran::where('tanggal_kunjungan', $today)
                ->where('status', 'Menunggu')
                ->count(),
        ];

        $recent_visits = Pendaftaran::with(['pasien', 'poli'])
            ->where('tanggal_kunjungan', $today)
            ->orderBy('nomor_antrian', 'asc')
            ->take(5)
            ->get();

        return view('dashboard', compact('stats', 'recent_visits'));
    }
}
