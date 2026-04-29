<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $isEdit ? 'Edit Ruangan' : 'Tambah Ruangan' }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-6">
                <form method="POST" action="{{ $isEdit ? route('super-admin.ruangan.update', $item) : route('super-admin.ruangan.store') }}" class="space-y-4">
                    @csrf
                    @if($isEdit)
                        @method('PUT')
                    @endif

                    <div>
                        <x-input-label for="id_gedung" value="Gedung" />
                        <select name="id_gedung" id="id_gedung" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md">
                            @foreach($gedungs as $gedung)
                                <option value="{{ $gedung->id_gedung }}" @selected((string) old('id_gedung', $item->id_gedung) === (string) $gedung->id_gedung)>
                                    {{ $gedung->nama_gedung }} - {{ $gedung->fakultas->nama_fakultas ?? 'Tanpa Fakultas' }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('id_gedung')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="nama_ruangan" value="Nama Ruangan" />
                            <x-text-input id="nama_ruangan" name="nama_ruangan" type="text" class="mt-1 block w-full" :value="old('nama_ruangan', $item->nama_ruangan)" required />
                            <x-input-error :messages="$errors->get('nama_ruangan')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="tipe_ruangan" value="Tipe Ruangan" />
                            <select name="tipe_ruangan" id="tipe_ruangan" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md" required>
                                @foreach([
                                    'kelas' => 'Ruang kelas',
                                    'laboratorium' => 'Laboratorium',
                                    'seminar' => 'Ruang seminar/sidang',
                                    'auditorium' => 'Auditorium',
                                ] as $value => $label)
                                    <option value="{{ $value }}" @selected((string) old('tipe_ruangan', $item->tipe_ruangan) === (string) $value)>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('tipe_ruangan')" class="mt-2" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <x-input-label for="nomor_ruangan" value="Nomor Ruangan" />
                            <x-text-input id="nomor_ruangan" name="nomor_ruangan" type="text" class="mt-1 block w-full" :value="old('nomor_ruangan', $item->nomor_ruangan)" required />
                            <x-input-error :messages="$errors->get('nomor_ruangan')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="kapasitas" value="Kapasitas" />
                            <x-text-input id="kapasitas" name="kapasitas" type="number" min="1" class="mt-1 block w-full" :value="old('kapasitas', $item->kapasitas)" required />
                            <x-input-error :messages="$errors->get('kapasitas')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="lantai" value="Lantai" />
                            <x-text-input id="lantai" name="lantai" type="number" min="0" class="mt-1 block w-full" :value="old('lantai', $item->lantai)" required />
                            <x-input-error :messages="$errors->get('lantai')" class="mt-2" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="fasilitas" value="Fasilitas" />
                        <textarea id="fasilitas" name="fasilitas" rows="4" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md">{{ old('fasilitas', $item->fasilitas) }}</textarea>
                        <x-input-error :messages="$errors->get('fasilitas')" class="mt-2" />
                    </div>

                    <div class="pt-2 flex items-center gap-3">
                        <x-primary-button>{{ $isEdit ? 'Simpan Perubahan' : 'Simpan' }}</x-primary-button>
                        <a href="{{ route('super-admin.ruangan.index') }}" class="text-sm text-gray-500 hover:underline">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
