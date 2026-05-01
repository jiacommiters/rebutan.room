<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-200 leading-tight flex items-center gap-2">
            <svg class="w-6 h-6 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            {{ __('Form Reservasi Ruangan') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (session('error'))
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl flex items-center shadow-sm" role="alert">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif
            
            @if ($errors->any())
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl shadow-sm">
                    <div class="flex items-center mb-2 font-bold">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        Terdapat kesalahan pada input Anda:
                    </div>
                    <ul class="list-disc pl-10 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('peminjaman.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                
                <div class="flex flex-col lg:flex-row gap-6">
                    <!-- Kolom Kiri: Form Detail -->
                    <div class="w-full lg:w-1/3 space-y-6">
                        <!-- Step 1: Waktu -->
                        <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 shadow-xl shadow-rose-500/5 border border-gray-100 dark:border-gray-700">
                            <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100 dark:border-gray-700">
                                <div class="w-8 h-8 rounded-full bg-rose-100 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400 flex items-center justify-center font-bold">1</div>
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Jadwal Kegiatan</h3>
                            </div>
                            
                            <div class="space-y-4">
                                <div>
                                    <label for="waktu_mulai" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Waktu Mulai <span class="text-rose-500">*</span></label>
                                    <input type="datetime-local" name="waktu_mulai" id="waktu_mulai" required value="{{ old('waktu_mulai') }}"
                                        class="w-full bg-gray-50 dark:bg-gray-900 border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-rose-500 focus:border-rose-500 px-4 py-2.5">
                                </div>
                                
                                <div>
                                    <label for="waktu_selesai" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Waktu Selesai <span class="text-rose-500">*</span></label>
                                    <input type="datetime-local" name="waktu_selesai" id="waktu_selesai" required value="{{ old('waktu_selesai') }}"
                                        class="w-full bg-gray-50 dark:bg-gray-900 border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-rose-500 focus:border-rose-500 px-4 py-2.5">
                                </div>
                            </div>
                        </div>

                        <!-- Step 2: Detail Kegiatan -->
                        <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 shadow-xl shadow-rose-500/5 border border-gray-100 dark:border-gray-700">
                            <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100 dark:border-gray-700">
                                <div class="w-8 h-8 rounded-full bg-rose-100 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400 flex items-center justify-center font-bold">2</div>
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Detail Kegiatan</h3>
                            </div>
                            
                            <div class="space-y-5">
                                <div>
                                    <label for="tujuan" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Tujuan Peminjaman <span class="text-rose-500">*</span></label>
                                    <textarea name="tujuan" id="tujuan" rows="3" required placeholder="Contoh: Rapat Himpunan Mahasiswa"
                                        class="w-full bg-gray-50 dark:bg-gray-900 border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-rose-500 focus:border-rose-500 px-4 py-3 resize-none">{{ old('tujuan') }}</textarea>
                                </div>

                                <div>
                                    <label for="surat" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Lampiran Surat Persetujuan <span class="text-rose-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <input type="file" name="surat" id="surat" required accept=".pdf,.doc,.docx"
                                            class="hidden" onchange="updateFileLabel(this)">
                                        <label for="surat" class="flex flex-col items-center justify-center w-full px-4 py-6 bg-gray-50 dark:bg-gray-900 border-2 border-dashed border-gray-300 dark:border-gray-700 rounded-xl cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors group">
                                            <div class="w-10 h-10 mb-2 bg-white dark:bg-gray-800 rounded-full flex items-center justify-center shadow-sm text-gray-400 group-hover:text-rose-500 group-hover:scale-110 transition-all">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                            </div>
                                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 text-center" id="file-label">Pilih file (PDF, DOC)</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Maks. 2MB</p>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kolom Kanan: Pilihan Ruangan -->
                    <div class="w-full lg:w-2/3">
                        <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 shadow-xl shadow-rose-500/5 border border-gray-100 dark:border-gray-700 h-full flex flex-col">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 pb-4 border-b border-gray-100 dark:border-gray-700">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-rose-100 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400 flex items-center justify-center font-bold">3</div>
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Pilih Ruangan <span class="text-rose-500">*</span></h3>
                                </div>
                                
                                <!-- Filter Quick -->
                                <div class="flex items-center bg-gray-50 dark:bg-gray-900 rounded-lg p-1">
                                    <button type="button" class="filter-btn active px-3 py-1.5 rounded-md text-xs font-bold bg-white dark:bg-gray-800 shadow-sm text-rose-600 dark:text-rose-400" data-filter="semua">Semua</button>
                                    <button type="button" class="filter-btn px-3 py-1.5 rounded-md text-xs font-semibold text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors" data-filter="kelas">Kelas</button>
                                    <button type="button" class="filter-btn px-3 py-1.5 rounded-md text-xs font-semibold text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors" data-filter="laboratorium">Lab</button>
                                </div>
                            </div>
                            
                            <div class="overflow-y-auto pr-2 custom-scroll flex-1" style="max-height: 600px;">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    @php
                                        // Cek ruangan yang dipassing via query parameter URL (misal dari welcome page)
                                        $queryRuangan = request()->query('ruangan');
                                    @endphp
                                    
                                    @foreach($ruangan as $r)
                                        @php
                                            $isChecked = (is_array(old('ruangan')) && in_array($r->id_ruangan, old('ruangan'))) || ((string)$queryRuangan === (string)$r->id_ruangan);
                                        @endphp
                                        
                                        <label class="cursor-pointer relative room-item" data-type="{{ $r->tipe_ruangan }}">
                                            <input type="checkbox" name="ruangan[]" value="{{ $r->id_ruangan }}" class="peer sr-only room-checkbox" {{ $isChecked ? 'checked' : '' }}>
                                            
                                            <div class="flex flex-col h-full p-4 rounded-2xl border-2 border-gray-100 dark:border-gray-700 bg-white dark:bg-gray-800 hover:border-gray-300 dark:hover:border-gray-600 peer-checked:border-rose-500 peer-checked:bg-rose-50 dark:peer-checked:bg-rose-900/10 transition-all group">
                                                <div class="flex justify-between items-start mb-3">
                                                    <div>
                                                        <span class="inline-block px-2 py-1 rounded text-[10px] font-bold uppercase tracking-wider bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300 mb-2 peer-checked:bg-rose-200 peer-checked:text-rose-800 dark:peer-checked:bg-rose-800 dark:peer-checked:text-rose-200">
                                                            {{ $r->tipe_ruangan }}
                                                        </span>
                                                        <h4 class="font-bold text-gray-900 dark:text-white leading-tight group-hover:text-rose-600 dark:group-hover:text-rose-400 transition-colors">{{ $r->nama_ruangan }}</h4>
                                                    </div>
                                                    
                                                    <!-- Checkmark Icon Indicator -->
                                                    <div class="w-6 h-6 rounded-full border-2 border-gray-300 dark:border-gray-600 flex items-center justify-center bg-white dark:bg-gray-800 peer-checked:bg-rose-500 peer-checked:border-rose-500 transition-colors">
                                                        <svg class="w-4 h-4 text-white opacity-0 peer-checked:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                                    </div>
                                                </div>
                                                
                                                <div class="mt-auto space-y-2 text-xs text-gray-600 dark:text-gray-400">
                                                    <div class="flex items-center gap-2">
                                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                                        <span>{{ $r->kapasitas }} Orang</span>
                                                    </div>
                                                    @if($r->gedung)
                                                    <div class="flex items-center gap-2 truncate">
                                                        <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                                        <span class="truncate">{{ $r->gedung->nama_gedung }} (Lt. {{ $r->lantai }})</span>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Footer Action Kanan -->
                            <div class="mt-6 pt-4 border-t border-gray-100 dark:border-gray-700 flex flex-col sm:flex-row items-center justify-between gap-4">
                                <div class="text-sm font-medium text-gray-600 dark:text-gray-400">
                                    <span id="selected-count" class="font-bold text-rose-600 dark:text-rose-400">0</span> ruangan dipilih
                                </div>
                                <div class="flex gap-3 w-full sm:w-auto">
                                    <a href="{{ route('peminjaman.index') }}" class="flex-1 sm:flex-none text-center px-6 py-3 rounded-xl font-semibold text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                                        Batal
                                    </a>
                                    <button type="submit" class="flex-1 sm:flex-none px-8 py-3 rounded-xl font-bold text-white bg-gradient-to-r from-red-600 to-rose-500 hover:from-red-700 hover:to-rose-600 shadow-lg shadow-rose-500/30 transition-all hover:-translate-y-0.5 flex items-center justify-center">
                                        Kirim Pengajuan
                                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <style>
        .custom-scroll::-webkit-scrollbar {
            width: 6px;
        }
        .custom-scroll::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scroll::-webkit-scrollbar-thumb {
            background-color: rgba(156, 163, 175, 0.5);
            border-radius: 20px;
        }
        .dark .custom-scroll::-webkit-scrollbar-thumb {
            background-color: rgba(75, 85, 99, 0.5);
        }
    </style>

    <script>
        function updateFileLabel(input) {
            const label = document.getElementById('file-label');
            if (input.files.length > 0) {
                label.textContent = input.files[0].name;
                label.classList.add('text-rose-600', 'dark:text-rose-400', 'font-bold');
                label.classList.remove('text-gray-700', 'dark:text-gray-300');
            } else {
                label.textContent = 'Pilih file (PDF, DOC)';
                label.classList.remove('text-rose-600', 'dark:text-rose-400', 'font-bold');
                label.classList.add('text-gray-700', 'dark:text-gray-300');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Update Selected Count
            const checkboxes = document.querySelectorAll('.room-checkbox');
            const countDisplay = document.getElementById('selected-count');
            
            function updateCount() {
                const checked = document.querySelectorAll('.room-checkbox:checked').length;
                countDisplay.textContent = checked;
            }

            checkboxes.forEach(cb => {
                cb.addEventListener('change', updateCount);
            });
            updateCount(); // Initial count

            // Filter
            const filterBtns = document.querySelectorAll('.filter-btn');
            const roomItems = document.querySelectorAll('.room-item');

            filterBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    // Update active styles
                    filterBtns.forEach(b => {
                        b.classList.remove('bg-white', 'dark:bg-gray-800', 'shadow-sm', 'text-rose-600', 'dark:text-rose-400', 'active');
                        b.classList.add('text-gray-600', 'dark:text-gray-400');
                    });
                    
                    btn.classList.add('bg-white', 'dark:bg-gray-800', 'shadow-sm', 'text-rose-600', 'dark:text-rose-400', 'active');
                    btn.classList.remove('text-gray-600', 'dark:text-gray-400');

                    const filter = btn.getAttribute('data-filter');

                    roomItems.forEach(item => {
                        if (filter === 'semua' || item.getAttribute('data-type') === filter) {
                            item.style.display = '';
                        } else {
                            item.style.display = 'none';
                        }
                    });
                });
            });
        });
    </script>
</x-app-layout>