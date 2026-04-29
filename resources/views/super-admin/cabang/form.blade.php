<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $isEdit ? 'Edit Cabang' : 'Tambah Cabang' }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-6">
                <form method="POST" action="{{ $isEdit ? route('super-admin.cabang.update', $item) : route('super-admin.cabang.store') }}" class="space-y-4">
                    @csrf
                    @if($isEdit)
                        @method('PUT')
                    @endif

                    <div>
                        <x-input-label for="id_kampus" value="Kampus" />
                        <select name="id_kampus" id="id_kampus" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md" required>
                            @foreach($kampus as $k)
                                <option value="{{ $k->id_kampus }}" @selected((string) old('id_kampus', $item->id_kampus) === (string) $k->id_kampus)>
                                    {{ $k->nama_kampus }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('id_kampus')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="nama_cabang" value="Nama Cabang" />
                        <x-text-input id="nama_cabang" name="nama_cabang" type="text" class="mt-1 block w-full" :value="old('nama_cabang', $item->nama_cabang)" required />
                        <x-input-error :messages="$errors->get('nama_cabang')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="alamat" value="Alamat" />
                        <x-text-input id="alamat" name="alamat" type="text" class="mt-1 block w-full" :value="old('alamat', $item->alamat)" required />
                        <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="kontak" value="Kontak" />
                        <x-text-input id="kontak" name="kontak" type="text" class="mt-1 block w-full" :value="old('kontak', $item->kontak)" required />
                        <x-input-error :messages="$errors->get('kontak')" class="mt-2" />
                    </div>

                    <div class="pt-2 flex items-center gap-3">
                        <x-primary-button>{{ $isEdit ? 'Simpan Perubahan' : 'Simpan' }}</x-primary-button>
                        <a href="{{ route('super-admin.cabang.index') }}" class="text-sm text-gray-500 hover:underline">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

