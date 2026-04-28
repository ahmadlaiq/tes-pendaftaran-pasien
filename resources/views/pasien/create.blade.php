<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Pasien Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                <form action="{{ route('pasien.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div>
                        <x-input-label for="nama_lengkap" :value="__('Nama Lengkap')" />
                        <x-text-input id="nama_lengkap" name="nama_lengkap" type="text" class="mt-1 block w-full" :value="old('nama_lengkap')" required />
                        <x-input-error class="mt-2" :messages="$errors->get('nama_lengkap')" />
                    </div>

                    <div>
                        <x-input-label for="nik" :value="__('NIK (16 Digit)')" />
                        <x-text-input id="nik" name="nik" type="text" class="mt-1 block w-full" :value="old('nik')" required maxlength="16" />
                        <x-input-error class="mt-2" :messages="$errors->get('nik')" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="tanggal_lahir" :value="__('Tanggal Lahir')" />
                            <x-text-input id="tanggal_lahir" name="tanggal_lahir" type="date" class="mt-1 block w-full" :value="old('tanggal_lahir')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('tanggal_lahir')" />
                        </div>
                        <div>
                            <x-input-label for="jenis_kelamin" :value="__('Jenis Kelamin')" />
                            <select id="jenis_kelamin" name="jenis_kelamin" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('jenis_kelamin')" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="nomor_telepon" :value="__('Nomor Telepon')" />
                        <x-text-input id="nomor_telepon" name="nomor_telepon" type="text" class="mt-1 block w-full" :value="old('nomor_telepon')" required />
                        <x-input-error class="mt-2" :messages="$errors->get('nomor_telepon')" />
                    </div>

                    <div>
                        <x-input-label for="alamat" :value="__('Alamat Lengkap')" />
                        <textarea id="alamat" name="alamat" rows="3" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>{{ old('alamat') }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('alamat')" />
                    </div>

                    <div class="flex items-center justify-end gap-4">
                        <a href="{{ route('pasien.index') }}" class="text-gray-600 hover:text-gray-900">Batal</a>
                        <x-primary-button>{{ __('Simpan Pasien') }}</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
