<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manajemen Pasien') }}
            </h2>
            <a href="{{ route('pasien.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition">
                + Tambah Pasien
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <!-- Search Bar -->
                <form action="{{ route('pasien.index') }}" method="GET" class="mb-6 flex gap-2">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama atau NIK..." class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition">Cari</button>
                    @if(request('search'))
                        <a href="{{ route('pasien.index') }}" class="text-gray-500 hover:text-gray-700 flex items-center px-2">Reset</a>
                    @endif
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
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">NIK</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Lengkap</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">L/P</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No. Telp</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($pasiens as $pasien)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $pasien->nik }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $pasien->nama_lengkap }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $pasien->jenis_kelamin }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $pasien->nomor_telepon }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                        <a href="{{ route('pendaftaran.create', ['pasien_id' => $pasien->id]) }}" class="text-green-600 hover:text-green-900" title="Daftarkan Kunjungan">Daftar</a>
                                        <a href="{{ route('pasien.show', $pasien) }}" class="text-blue-600 hover:text-blue-900">Detail</a>
                                        <a href="{{ route('pasien.edit', $pasien) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                        <form action="{{ route('pasien.destroy', $pasien) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Hapus pasien ini?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-gray-500">Tidak ada data pasien ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    {{ $pasiens->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
