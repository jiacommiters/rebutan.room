<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('peminjaman.index') }}" class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                Detail Peminjaman #{{ $data->id_peminjaman }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- STATUS BANNER --}}
            <div class="glass-card rounded-2xl p-6 border-t-4 
                @if($data->status === 'approved') border-t-green-500
                @elseif($data->status === 'rejected') border-t-red-500
                @elseif($data->status === 'cancelled') border-t-gray-500
                @else border-t-yellow-500
                @endif">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Status Peminjaman Keseluruhan</p>
                        <div class="mt-2">
                            @if($data->status === 'approved')
                                <span class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-bold bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400 border border-green-200 dark:border-green-800">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Disetujui
                                </span>
                            @elseif($data->status === 'rejected')
                                <span class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-bold bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400 border border-red-200 dark:border-red-800">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Ditolak
                                </span>
                            @elseif($data->status === 'cancelled')
                                <span class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-bold bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400 border border-gray-200 dark:border-gray-800">
                                    Dibatalkan
                                </span>
                            @else
                                <span class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-bold bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400 border border-yellow-200 dark:border-yellow-800">
                                    <svg class="w-5 h-5 mr-2 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                                    Menunggu Persetujuan Ruangan
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Diajukan pada</p>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white mt-1">{{ \Carbon\Carbon::parse($data->waktu_pengajuan)->format('d M Y, H:i') }}</p>
                    </div>
                </div>
            </div>

            {{-- INFO PEMINJAM --}}
            <div class="glass-card rounded-2xl p-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Informasi Peminjam
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider font-medium">Nama</p>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white mt-1">{{ $data->user->name ?? 'User Dihapus' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider font-medium">Email</p>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white mt-1">{{ $data->user->email ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider font-medium">Role</p>
                        <span class="inline-flex mt-1 text-[10px] font-bold uppercase tracking-wider text-rose-500 bg-rose-100 dark:bg-rose-900/30 px-2 py-0.5 rounded">
                            {{ $data->user->role ?? 'N/A' }}
                        </span>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider font-medium">NIM/NIP</p>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white mt-1">{{ $data->user->nim_nip ?? '-' }}</p>
                    </div>
                </div>
            </div>

            {{-- DETAIL PEMINJAMAN --}}
            <div class="glass-card rounded-2xl p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center">
                        <svg class="w-5 h-5 mr-2 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Detail Waktu & Tujuan
                    </h3>
                    @if($data->surat)
                        <a href="{{ Storage::url($data->surat) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-rose-50 dark:bg-rose-900/20 text-rose-600 dark:text-rose-400 text-sm font-semibold rounded-lg hover:bg-rose-100 dark:hover:bg-rose-900/30 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            Lihat Surat Lampiran
                        </a>
                    @endif
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                    <div class="bg-gray-50/50 dark:bg-gray-800/50 rounded-xl p-4 border border-gray-200/50 dark:border-gray-700/50">
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider font-medium">Waktu Mulai</p>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white mt-1">{{ \Carbon\Carbon::parse($data->waktu_mulai)->format('d M Y, H:i') }}</p>
                    </div>
                    <div class="bg-gray-50/50 dark:bg-gray-800/50 rounded-xl p-4 border border-gray-200/50 dark:border-gray-700/50">
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider font-medium">Waktu Selesai</p>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white mt-1">{{ \Carbon\Carbon::parse($data->waktu_selesai)->format('d M Y, H:i') }}</p>
                    </div>
                </div>
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider font-medium mb-2">Tujuan Peminjaman</p>
                    <div class="bg-gray-50/50 dark:bg-gray-800/50 rounded-xl p-4 border border-gray-200/50 dark:border-gray-700/50">
                        <p class="text-sm text-gray-900 dark:text-white">{{ $data->tujuan }}</p>
                    </div>
                </div>
            </div>

            {{-- RUANGAN & STATUS PERSETUJUAN PER RUANGAN (BUSINESS RULE 3 & 6) --}}
            <div class="glass-card rounded-2xl p-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    Ruangan & Status Persetujuan
                </h3>
                <div class="space-y-4">
                    @foreach($data->ruangan as $r)
                        @php
                            $persetujuan = $data->persetujuan->where('id_ruangan', $r->id_ruangan)->first();
                        @endphp
                        <div class="bg-white/60 dark:bg-gray-800/60 rounded-xl p-5 border border-gray-200/50 dark:border-gray-700/50 relative overflow-hidden">
                            <div class="absolute left-0 top-0 bottom-0 w-1 
                                @if($persetujuan && $persetujuan->status === 'approved') bg-green-500 
                                @elseif($persetujuan && $persetujuan->status === 'rejected') bg-red-500
                                @else bg-yellow-500 @endif
                            "></div>
                            
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                <div>
                                    <h4 class="font-bold text-gray-900 dark:text-gray-100 text-lg">{{ $r->nama_ruangan }}</h4>
                                    <div class="flex flex-col sm:flex-row sm:items-center text-xs text-gray-500 dark:text-gray-400 gap-1 sm:gap-4 mt-1">
                                        <span><span class="font-medium">Tipe:</span> {{ $r->tipe_ruangan }}</span>
                                        <span class="hidden sm:inline">•</span>
                                        <span><span class="font-medium">Kapasitas:</span> {{ $r->kapasitas }} org</span>
                                        <span class="hidden sm:inline">•</span>
                                        <span><span class="font-medium">Gedung:</span> {{ $r->gedung->nama_gedung ?? '-' }} (Lt.{{ $r->lantai }})</span>
                                    </div>
                                    <p class="text-xs mt-1 text-gray-500">
                                        <span class="font-medium">Fasilitas:</span> {{ $r->fasilitas }}
                                    </p>
                                </div>
                                <div class="shrink-0 text-left sm:text-right">
                                    <p class="text-xs text-gray-500 uppercase tracking-wider mb-1 font-medium">Status Ruangan</p>
                                    @if($persetujuan)
                                        @if($persetujuan->status === 'approved')
                                            <span class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-bold bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">Diizinkan</span>
                                        @elseif($persetujuan->status === 'rejected')
                                            <span class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-bold bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">Ditolak</span>
                                        @endif
                                        <p class="text-[10px] mt-1 text-gray-400">
                                            Oleh: {{ $persetujuan->admin->name ?? 'Admin' }} ({{ $persetujuan->level_admin }})<br>
                                            Pada: {{ \Carbon\Carbon::parse($persetujuan->waktu_persetujuan)->format('d/m/y H:i') }}
                                        </p>
                                        @if($persetujuan->komentar)
                                            <div class="mt-2 text-xs bg-gray-50 dark:bg-gray-700/50 p-2 rounded text-gray-600 dark:text-gray-300">
                                                <span class="font-semibold block">Catatan Admin:</span>
                                                {{ $persetujuan->komentar }}
                                            </div>
                                        @endif
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-bold bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">Menunggu</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- ACTIONS --}}
            <div class="flex justify-between items-center">
                <a href="{{ route('peminjaman.index') }}" class="inline-flex items-center px-5 py-2.5 rounded-xl font-semibold text-sm text-gray-700 dark:text-gray-300 bg-gray-200/50 hover:bg-gray-300/50 dark:bg-gray-700/50 dark:hover:bg-gray-600/50 backdrop-blur-sm transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    Kembali
                </a>

                @if($data->status === 'pending' && ($data->id_user === Auth::id() || Auth::user()->isAdmin()))
                <form action="{{ route('peminjaman.destroy', $data->id_peminjaman) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pengajuan ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center px-5 py-2.5 rounded-xl font-semibold text-sm text-white bg-red-500 hover:bg-red-600 shadow-lg shadow-red-500/30 transition-all hover:-translate-y-0.5">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        Batalkan Pengajuan
                    </button>
                </form>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
