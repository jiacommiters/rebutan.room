<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $isEdit ? 'Edit Gedung' : 'Tambah Gedung' }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-6">
                <form method="POST" action="{{ $isEdit ? route('super-admin.gedung.update', $item) : route('super-admin.gedung.store') }}" class="space-y-4">
                    @csrf
                    @if($isEdit)
                        @method('PUT')
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
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
                            <x-input-label for="kategori" value="Kategori Gedung" />
                            <select name="kategori" id="kategori" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md" required>
                                @foreach(['umum' => 'Gedung Kuliah Umum (umum)', 'fakultas' => 'Gedung Khusus Fakultas (fakultas)'] as $value => $label)
                                    <option value="{{ $value }}" @selected((string) old('kategori', $item->kategori) === (string) $value)>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('kategori')" class="mt-2" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="kode_gedung" value="Kode Gedung" />
                            <x-text-input id="kode_gedung" name="kode_gedung" type="text" class="mt-1 block w-full" :value="old('kode_gedung', $item->kode_gedung)" required />
                            <x-input-error :messages="$errors->get('kode_gedung')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="nama_gedung" value="Nama Gedung" />
                            <x-text-input id="nama_gedung" name="nama_gedung" type="text" class="mt-1 block w-full" :value="old('nama_gedung', $item->nama_gedung)" required />
                            <x-input-error :messages="$errors->get('nama_gedung')" class="mt-2" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <x-input-label for="jumlah_lantai" value="Jumlah Lantai" />
                            <x-text-input id="jumlah_lantai" name="jumlah_lantai" type="number" min="0" class="mt-1 block w-full" :value="old('jumlah_lantai', $item->jumlah_lantai)" required />
                            <x-input-error :messages="$errors->get('jumlah_lantai')" class="mt-2" />
                        </div>

                        {{-- ===== FAKULTAS SECTION: hanya tampil jika kategori=fakultas ===== --}}
                        <div class="md:col-span-2" id="fakultas-section">
                            <x-input-label for="id_fakultas" value="Fakultas" />
                            <select name="id_fakultas" id="id_fakultas" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md">
                                <option value="">-- Pilih Fakultas --</option>
                                @foreach($fakultas as $f)
                                    <option
                                        value="{{ $f->id_fakultas }}"
                                        data-cabang="{{ $f->id_cabang }}"
                                        @selected((string) old('id_fakultas', $item->id_fakultas) === (string) $f->id_fakultas)
                                    >
                                        {{ $f->nama_fakultas }} &mdash; {{ $f->cabang->nama_cabang ?? '-' }}
                                    </option>
                                @endforeach
                            </select>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                Pilih cabang terlebih dahulu agar opsi fakultas terfilter.
                            </p>
                            <x-input-error :messages="$errors->get('id_fakultas')" class="mt-2" />
                        </div>
                    </div>

                    <div class="pt-2 flex items-center gap-3">
                        <x-primary-button>{{ $isEdit ? 'Simpan Perubahan' : 'Simpan' }}</x-primary-button>
                        <a href="{{ route('super-admin.gedung.index') }}" class="text-sm text-gray-500 hover:underline">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ===== JAVASCRIPT: toggle & filter fakultas ===== --}}
    <script>
        const kategoriSelect  = document.getElementById('kategori');
        const cabangSelect    = document.getElementById('id_cabang');
        const fakultasSection = document.getElementById('fakultas-section');
        const fakultasSelect  = document.getElementById('id_fakultas');

        /** Sembunyikan / tampilkan section fakultas berdasarkan nilai kategori */
        function toggleFakultasSection() {
            if (kategoriSelect.value === 'fakultas') {
                fakultasSection.style.display = '';
                fakultasSelect.removeAttribute('disabled');
            } else {
                fakultasSection.style.display = 'none';
                fakultasSelect.setAttribute('disabled', 'disabled');
                fakultasSelect.value = '';   // reset pilihan agar tidak terkirim
            }
        }

        /**
         * Filter opsi fakultas berdasarkan cabang yang dipilih.
         * Setiap <option> punya data-cabang="{{ $f->id_cabang }}"
         */
        function filterFakultasByCabang(preserveSelected) {
            const selectedCabang = cabangSelect.value;
            const options = fakultasSelect.querySelectorAll('option[data-cabang]');
            let hasVisible = false;

            options.forEach(opt => {
                const match = (opt.getAttribute('data-cabang') === selectedCabang);
                opt.style.display = match ? '' : 'none';
                if (match) hasVisible = true;

                // Jika opsi yang sedang terpilih bukan dari cabang ini, kosongkan pilihan
                if (!preserveSelected && opt.selected && !match) {
                    opt.selected = false;
                    fakultasSelect.value = '';
                }
            });

            // Jika tidak ada fakultas untuk cabang ini, tampilkan hint
            const emptyOpt = fakultasSelect.querySelector('option[value=""]');
            if (emptyOpt) {
                emptyOpt.textContent = hasVisible
                    ? '-- Pilih Fakultas --'
                    : '-- Tidak ada fakultas untuk cabang ini --';
            }
        }

        // ── Event listeners ──────────────────────────────────────────────────
        kategoriSelect.addEventListener('change', toggleFakultasSection);
        cabangSelect.addEventListener('change', () => filterFakultasByCabang(false));

        // ── Inisialisasi saat halaman dimuat ─────────────────────────────────
        toggleFakultasSection();
        filterFakultasByCabang(true); // preserve selected (penting untuk mode edit)
    </script>
</x-app-layout>
