<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $isEdit ? 'Edit Fakultas' : 'Tambah Fakultas' }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-6">
                <form method="POST" action="{{ $isEdit ? route('super-admin.fakultas.update', $item) : route('super-admin.fakultas.store') }}" class="space-y-4">
                    @csrf
                    @if($isEdit)
                        @method('PUT')
                    @endif

                    <div>
                        <x-input-label for="id_cabang" value="Cabang" />
                        <select name="id_cabang" id="id_cabang" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md" required>
                            @foreach($cabangs as $c)
                                <option value="{{ $c->id_cabang }}" @selected((string) old('id_cabang', $item->id_cabang) === (string) $c->id_cabang)>
                                    {{ $c->nama_cabang }} ({{ $c->kampus->nama_kampus ?? '-' }})
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('id_cabang')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="nama_fakultas" value="Nama Fakultas" />
                        <x-text-input id="nama_fakultas" name="nama_fakultas" type="text" class="mt-1 block w-full" :value="old('nama_fakultas', $item->nama_fakultas)" required />
                        <x-input-error :messages="$errors->get('nama_fakultas')" class="mt-2" />
                    </div>

                    <div class="pt-2 flex items-center gap-3">
                        <x-primary-button>{{ $isEdit ? 'Simpan Perubahan' : 'Simpan' }}</x-primary-button>
                        <a href="{{ route('super-admin.fakultas.index') }}" class="text-sm text-gray-500 hover:underline">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

