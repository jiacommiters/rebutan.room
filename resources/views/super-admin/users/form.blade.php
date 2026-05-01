<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $isEdit ? 'Edit User' : 'Tambah User' }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-6">
                <form method="POST" action="{{ $isEdit ? route('super-admin.users.update', $user) : route('super-admin.users.store') }}" class="space-y-4">
                    @csrf
                    @if($isEdit)
                        @method('PUT')
                    @endif

                    <div>
                        <x-input-label for="name" value="Nama" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="email" value="Email" />
                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="password" value="{{ $isEdit ? 'Password Baru (opsional)' : 'Password' }}" />
                            <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="password_confirmation" value="Konfirmasi Password" />
                            <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <x-input-label for="role" value="Role" />
                            <select name="role" id="role" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md">
                                @foreach(['mahasiswa','dosen','staff','admin','super_admin'] as $role)
                                    <option value="{{ $role }}" @selected(old('role', $user->role) === $role)>{{ strtoupper($role) }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('role')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="admin_level" value="Level Admin" />
                            <select name="admin_level" id="admin_level" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md">
                                <option value="">-</option>
                                @foreach(['gedung','fakultas','super'] as $level)
                                    <option value="{{ $level }}" @selected(old('admin_level', $user->admin_level) === $level)>{{ strtoupper($level) }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('admin_level')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="nim_nip" value="NIM/NIP" />
                            <x-text-input id="nim_nip" name="nim_nip" type="text" class="mt-1 block w-full" :value="old('nim_nip', $user->nim_nip)" required />
                            <x-input-error :messages="$errors->get('nim_nip')" class="mt-2" />
                        </div>
                    </div>

                    {{-- ===== AFILIASI SECTION ===== --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                        {{-- Cabang: tampil untuk super_admin / role umum (readonly, diisi otomatis) --}}
                        <div id="field-cabang">
                            <x-input-label for="id_cabang" value="Cabang" />
                            <select name="id_cabang" id="id_cabang" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md">
                                <option value="">-</option>
                                @foreach($cabangs as $item)
                                    <option value="{{ $item->id_cabang }}" @selected((string) old('id_cabang', $user->id_cabang) === (string) $item->id_cabang)>{{ $item->nama_cabang }}</option>
                                @endforeach
                            </select>
                            <p id="hint-cabang" class="mt-1 text-xs text-gray-500 dark:text-gray-400 hidden">Diisi otomatis dari Fakultas / Gedung yang dipilih.</p>
                            <x-input-error :messages="$errors->get('id_cabang')" class="mt-2" />
                        </div>

                        {{-- Fakultas: tampil untuk mahasiswa/dosen/staff dan admin-fakultas --}}
                        <div id="field-fakultas">
                            <x-input-label for="id_fakultas" value="Fakultas" />
                            <select name="id_fakultas" id="id_fakultas" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md">
                                <option value="">-</option>
                                @foreach($fakultas as $item)
                                    <option value="{{ $item->id_fakultas }}" @selected((string) old('id_fakultas', $user->id_fakultas) === (string) $item->id_fakultas)>{{ $item->nama_fakultas }}</option>
                                @endforeach
                            </select>
                            <p id="hint-fakultas" class="mt-1 text-xs text-gray-500 dark:text-gray-400 hidden">Diisi otomatis dari Gedung yang dipilih.</p>
                            <x-input-error :messages="$errors->get('id_fakultas')" class="mt-2" />
                        </div>

                        {{-- Gedung: tampil untuk admin-gedung --}}
                        <div id="field-gedung">
                            <x-input-label for="id_gedung" value="Gedung" />
                            <select name="id_gedung" id="id_gedung" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md">
                                <option value="">-</option>
                                @foreach($gedungs as $item)
                                    <option value="{{ $item->id_gedung }}" @selected((string) old('id_gedung', $user->id_gedung) === (string) $item->id_gedung)>{{ $item->nama_gedung }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('id_gedung')" class="mt-2" />
                        </div>

                    </div>

                    <div class="pt-2 flex items-center gap-3">
                        <x-primary-button>{{ $isEdit ? 'Simpan Perubahan' : 'Simpan' }}</x-primary-button>
                        <a href="{{ route('super-admin.users.index') }}" class="text-sm text-gray-500 hover:underline">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ===== JAVASCRIPT: show/hide field berdasarkan role & admin_level ===== --}}
    <script>
        const roleSelect       = document.getElementById('role');
        const adminLevelSelect = document.getElementById('admin_level');

        const fieldCabang   = document.getElementById('field-cabang');
        const fieldFakultas = document.getElementById('field-fakultas');
        const fieldGedung   = document.getElementById('field-gedung');

        const hintCabang    = document.getElementById('hint-cabang');
        const hintFakultas  = document.getElementById('hint-fakultas');

        const selectCabang   = document.getElementById('id_cabang');
        const selectFakultas = document.getElementById('id_fakultas');
        const selectGedung   = document.getElementById('id_gedung');

        function applyVisibility() {
            const role  = roleSelect.value;
            const level = adminLevelSelect.value;

            // ── Reset semua ke visible dulu ──────────────────────────────────
            [fieldCabang, fieldFakultas, fieldGedung].forEach(el => el.style.display = '');
            [selectCabang, selectFakultas, selectGedung].forEach(el => el.removeAttribute('disabled'));
            [hintCabang, hintFakultas].forEach(el => el.classList.add('hidden'));

            // ── Super Admin ──────────────────────────────────────────────────
            if (role === 'super_admin') {
                // Hanya perlu cabang (opsional), sembunyikan fakultas & gedung
                fieldFakultas.style.display = 'none';
                fieldGedung.style.display   = 'none';
                selectFakultas.setAttribute('disabled', 'disabled');
                selectGedung.setAttribute('disabled', 'disabled');
                return;
            }

            // ── Mahasiswa / Dosen / Staff ────────────────────────────────────
            if (['mahasiswa', 'dosen', 'staff'].includes(role)) {
                // Wajib pilih fakultas. Cabang diisi otomatis oleh controller.
                fieldGedung.style.display = 'none';
                selectGedung.setAttribute('disabled', 'disabled');

                // Cabang tetap tampil tapi readonly (controller override)
                hintCabang.classList.remove('hidden');
                return;
            }

            // ── Admin ────────────────────────────────────────────────────────
            if (role === 'admin') {
                if (level === 'fakultas') {
                    // Wajib pilih fakultas. Cabang & Gedung diisi otomatis.
                    fieldGedung.style.display = 'none';
                    selectGedung.setAttribute('disabled', 'disabled');

                    hintCabang.classList.remove('hidden');
                    return;
                }

                if (level === 'gedung') {
                    // Wajib pilih gedung. Fakultas & Cabang diisi otomatis dari gedung.
                    hintCabang.classList.remove('hidden');
                    hintFakultas.classList.remove('hidden');
                    return;
                }

                // level kosong / super → tampilkan semua
                return;
            }
        }

        roleSelect.addEventListener('change', applyVisibility);
        adminLevelSelect.addEventListener('change', applyVisibility);

        // Inisialisasi saat halaman dimuat
        applyVisibility();
    </script>
</x-app-layout>
