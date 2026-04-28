<!DOCTYPE html>
<html>
<head>
    <title>Laporan Kunjungan Pasien</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { bg-color: #f2f2f2; }
        .header { text-align: center; margin-bottom: 30px; }
        .footer { position: fixed; bottom: 0; width: 100%; text-align: right; font-size: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN KUNJUNGAN PASIEN</h2>
        <p>Klinik Media Araya</p>
        <hr>
        <p>
            Tanggal: {{ $tanggal }} | 
            Poli: {{ $poli ? $poli->nama_poli : 'Semua Poli' }}
        </p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Antrian</th>
                <th>Nama Pasien</th>
                <th>NIK</th>
                <th>Poli</th>
                <th>Keluhan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pendaftarans as $index => $visit)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td style="font-weight: bold; color: blue;">{{ $visit->nomor_antrian }}</td>
                    <td>{{ $visit->pasien->nama_lengkap }}</td>
                    <td>{{ $visit->pasien->nik }}</td>
                    <td>{{ $visit->poli->nama_poli }}</td>
                    <td>{{ $visit->keluhan }}</td>
                    <td>{{ $visit->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ date('d-m-Y H:i:s') }}
    </div>
</body>
</html>
