<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Daftar Kunjungan Pasien') }}
            </h2>
            <a href="{{ route('pendaftaran.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition">
                + Buat Pendaftaran
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <!-- Filters -->
                <form action="{{ route('pendaftaran.index') }}" method="GET" class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                    <div>
                        <x-input-label for="tanggal" :value="__('Tanggal')" />
                        <x-text-input id="tanggal" name="tanggal" type="date" value="{{ request('tanggal') }}" class="mt-1 block w-full" />
                    </div>
                    <div>
                        <x-input-label for="poli_id" :value="__('Poli / Unit')" />
                        <select id="poli_id" name="poli_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="">Semua Poli</option>
                            @foreach($polis as $poli)
                                <option value="{{ $poli->id }}" {{ request('poli_id') == $poli->id ? 'selected' : '' }}>{{ $poli->nama_poli }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition">Filter</button>
                        <a href="{{ route('pendaftaran.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300 transition">Reset</a>
                        <a href="{{ route('pendaftaran.export-pdf', request()->all()) }}" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            Cetak PDF
                        </a>
                    </div>
                </form>

                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                        <p>{{ session('success') }}</p>
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Antrian</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pasien</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Poli</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Keluhan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($pendaftarans as $visit)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap text-lg font-bold text-blue-600">{{ $visit->nomor_antrian }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $visit->pasien->nama_lengkap }}</div>
                                        <div class="text-xs text-gray-500">{{ $visit->pasien->nik }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $visit->poli->nama_poli }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate">{{ $visit->keluhan }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $visit->status == 'Menunggu' ? 'bg-yellow-100 text-yellow-800' : ($visit->status == 'Dilayani' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') }}">
                                            {{ $visit->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end gap-2">
                                            @if($visit->status == 'Menunggu')
                                                <form action="{{ route('pendaftaran.update-status', $visit) }}" method="POST">
                                                    @csrf @method('PATCH')
                                                    <input type="hidden" name="status" value="Dilayani">
                                                    <button type="submit" class="text-blue-600 hover:text-blue-900">Layani</button>
                                                </form>
                                            @elseif($visit->status == 'Dilayani')
                                                <form action="{{ route('pendaftaran.update-status', $visit) }}" method="POST">
                                                    @csrf @method('PATCH')
                                                    <input type="hidden" name="status" value="Selesai">
                                                    <button type="submit" class="text-green-600 hover:text-green-900">Selesai</button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-10 text-center text-gray-500">Tidak ada data pendaftaran.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    {{ $pendaftarans->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
