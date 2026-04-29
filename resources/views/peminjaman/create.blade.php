<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Buat Pengajuan Peminjaman') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="glass-card overflow-hidden sm:rounded-2xl p-8 border-t-4 border-t-red-500 relative">
                
                @if (session('error'))
                    <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl relative" role="alert">
                        <strong class="font-bold">Oops!</strong>
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif
                
                @if ($errors->any())
                    <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl relative">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('peminjaman.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8 relative z-10">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Waktu Mulai -->
                        <div>
                            <label for="waktu_mulai" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Waktu Mulai <span class="text-red-500">*</span></label>
                            <input type="datetime-local" name="waktu_mulai" id="waktu_mulai" required value="{{ old('waktu_mulai') }}"
                                class="w-full glass-input text-gray-900 dark:text-white px-4 py-3">
                        </div>

                        <!-- Waktu Selesai -->
                        <div>
                            <label for="waktu_selesai" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Waktu Selesai <span class="text-red-500">*</span></label>
                            <input type="datetime-local" name="waktu_selesai" id="waktu_selesai" required value="{{ old('waktu_selesai') }}"
                                class="w-full glass-input text-gray-900 dark:text-white px-4 py-3">
                        </div>
                    </div>

                    <!-- Tujuan Peminjaman -->
                    <div>
                        <label for="tujuan" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Tujuan Peminjaman <span class="text-red-500">*</span></label>
                        <textarea name="tujuan" id="tujuan" rows="3" required placeholder="Contoh: Rapat Himpunan Mahasiswa"
                            class="w-full glass-input text-gray-900 dark:text-white px-4 py-3 resize-none">{{ old('tujuan') }}</textarea>
                    </div>

                    <!-- Upload Surat -->
                    <div>
                        <label for="surat" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Lampiran Surat <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="file" name="surat" id="surat" required accept=".pdf,.doc,.docx"
                                class="hidden" onchange="updateFileLabel(this)">
                            <label for="surat" class="flex items-center justify-center w-full px-4 py-6 glass-input text-gray-900 dark:text-white cursor-pointer hover:bg-white/70 dark:hover:bg-gray-800/70 transition-colors group">
                                <div class="text-center">
                                    <div class="w-12 h-12 mx-auto mb-3 bg-rose-100 dark:bg-rose-900/30 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                                        <svg class="w-6 h-6 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                    </div>
                                    <p class="text-sm font-medium" id="file-label">Pilih file surat (PDF, DOC, DOCX)</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Maksimum 2MB</p>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Pilihan Ruangan -->
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Pilih Ruangan <span class="text-red-500">*</span></h3>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($ruangan as $r)
                                <label class="cursor-pointer relative">
                                    <input type="checkbox" name="ruangan[]" value="{{ $r->id_ruangan }}" class="peer sr-only" {{ (is_array(old('ruangan')) && in_array($r->id_ruangan, old('ruangan'))) ? 'checked' : '' }}>
                                    
                                    <div class="p-5 rounded-xl border-2 border-transparent bg-white/60 dark:bg-gray-800/60 shadow-sm hover:bg-white dark:hover:bg-gray-700 peer-checked:border-red-500 peer-checked:bg-red-50 dark:peer-checked:bg-red-900/20 transition-all">
                                        <div class="flex items-center justify-between mb-2">
                                            <h4 class="font-bold text-gray-900 dark:text-gray-100 text-lg">{{ $r->nama_ruangan }}</h4>
                                        </div>
                                        <div class="text-sm text-gray-600 dark:text-gray-400 space-y-1">
                                            <p><span class="font-medium">Kapasitas:</span> {{ $r->kapasitas }} Orang</p>
                                            <p class="truncate"><span class="font-medium">Fasilitas:</span> {{ $r->fasilitas ?? '-' }}</p>
                                            <p><span class="font-medium">Tipe:</span> {{ $r->tipe_ruangan }}</p>
                                            @if($r->gedung)
                                            <p><span class="font-medium">Gedung:</span> {{ $r->gedung->nama_gedung }} (Lt. {{ $r->lantai }})</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="absolute inset-0 border-2 border-red-500 rounded-xl opacity-0 peer-checked:opacity-100 peer-checked:scale-100 scale-95 transition-all pointer-events-none"></div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end pt-6 border-t border-gray-200/50 dark:border-gray-700/50">
                        <a href="{{ route('peminjaman.index') }}" class="px-6 py-3 mr-4 rounded-xl font-semibold text-gray-700 dark:text-gray-300 bg-gray-200/50 hover:bg-gray-300/50 dark:bg-gray-700/50 dark:hover:bg-gray-600/50 backdrop-blur-sm transition-colors">
                            Batal
                        </a>
                        <button type="submit" class="px-8 py-3 rounded-xl font-bold text-white bg-gradient-to-r from-red-600 to-rose-500 hover:from-red-700 hover:to-rose-600 shadow-lg shadow-red-500/30 transition-all hover:-translate-y-0.5">
                            Ajukan Peminjaman
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        function updateFileLabel(input) {
            const label = document.getElementById('file-label');
            if (input.files.length > 0) {
                label.textContent = input.files[0].name;
                label.classList.add('text-rose-600', 'dark:text-rose-400', 'font-semibold');
            } else {
                label.textContent = 'Pilih file surat (PDF, DOC, DOCX)';
                label.classList.remove('text-rose-600', 'dark:text-rose-400', 'font-semibold');
            }
        }
    </script>
</x-app-layout>