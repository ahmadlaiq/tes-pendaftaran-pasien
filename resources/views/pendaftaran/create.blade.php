<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pendaftaran Kunjungan Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                <form action="{{ route('pendaftaran.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div>
                        <x-input-label for="pasien_id" :value="__('Pilih Pasien')" />
                        <select id="pasien_id" name="pasien_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm select2">
                            <option value="">-- Pilih Pasien --</option>
                            @foreach($pasiens as $p)
                                <option value="{{ $p->id }}" {{ (old('pasien_id') == $p->id || ($pasien && $pasien->id == $p->id)) ? 'selected' : '' }}>
                                    {{ $p->nama_lengkap }} ({{ $p->nik }})
                                </option>
                            @endforeach
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('pasien_id')" />
                        <p class="mt-1 text-xs text-gray-500">Pasien belum terdaftar? <a href="{{ route('pasien.create') }}" class="text-blue-600 hover:underline">Tambah Pasien Baru</a></p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="poli_id" :value="__('Pilih Poli / Unit')" />
                            <select id="poli_id" name="poli_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">-- Pilih Poli --</option>
                                @foreach($polis as $poli)
                                    <option value="{{ $poli->id }}" {{ old('poli_id') == $poli->id ? 'selected' : '' }}>{{ $poli->nama_poli }}</option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('poli_id')" />
                        </div>
                        <div>
                            <x-input-label for="tanggal_kunjungan" :value="__('Tanggal Kunjungan')" />
                            <x-text-input id="tanggal_kunjungan" name="tanggal_kunjungan" type="date" class="mt-1 block w-full" :value="old('tanggal_kunjungan', date('Y-m-d'))" required />
                            <x-input-error class="mt-2" :messages="$errors->get('tanggal_kunjungan')" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="keluhan" :value="__('Keluhan')" />
                        <textarea id="keluhan" name="keluhan" rows="4" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Tuliskan keluhan pasien..." required>{{ old('keluhan') }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('keluhan')" />
                    </div>

                    <div class="flex items-center justify-end gap-4">
                        <a href="{{ route('pendaftaran.index') }}" class="text-gray-600 hover:text-gray-900">Batal</a>
                        <x-primary-button>{{ __('Daftarkan Pasien') }}</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
