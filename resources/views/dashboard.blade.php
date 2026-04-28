<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500">
                    <div class="text-sm font-medium text-gray-500 uppercase">Total Pasien</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900">{{ $stats['total_pasien'] }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-green-500">
                    <div class="text-sm font-medium text-gray-500 uppercase">Kunjungan Hari Ini</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900">{{ $stats['kunjungan_hari_ini'] }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-yellow-500">
                    <div class="text-sm font-medium text-gray-500 uppercase">Antrian Aktif</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900">{{ $stats['antrian_aktif'] }}</div>
                </div>
            </div>

            <!-- Recent Visits Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4">5 Antrian Terbaru Hari Ini</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Antrian</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Pasien</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Poli</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($recent_visits as $visit)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-blue-600">{{ $visit->nomor_antrian }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $visit->pasien->nama_lengkap }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $visit->poli->nama_poli }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $visit->status == 'Menunggu' ? 'bg-yellow-100 text-yellow-800' : ($visit->status == 'Dilayani' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') }}">
                                            {{ $visit->status }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">Belum ada kunjungan hari ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
