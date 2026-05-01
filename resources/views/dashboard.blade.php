<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Dashboard') }}
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 flex items-center gap-2">
                    Selamat datang, <span class="font-bold text-gray-900 dark:text-white">{{ Auth::user()->name }}</span>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-rose-100 text-rose-700 dark:bg-rose-500/20 dark:text-rose-400 border border-rose-200 dark:border-rose-500/30">
                        {{ str_replace('_', ' ', Auth::user()->role) }}
                    </span>
                </p>
            </div>
            
            @if(!Auth::user()->isAdmin())
            <a href="{{ route('peminjaman.create') }}" class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-red-600 to-rose-500 rounded-xl font-bold text-sm text-white hover:from-red-700 hover:to-rose-600 shadow-lg shadow-rose-500/30 transition-all hover:-translate-y-0.5 whitespace-nowrap">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Buat Pengajuan Baru
            </a>
            @endif
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            @if(!Auth::user()->isAdmin() && empty(Auth::user()->id_fakultas))
                <div class="bg-amber-50 dark:bg-amber-500/10 border-l-4 border-amber-500 p-4 rounded-r-xl shadow-sm">
                    <div class="flex items-start sm:items-center justify-between gap-4 flex-col sm:flex-row">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-amber-100 dark:bg-amber-500/20 text-amber-600 dark:text-amber-400 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-amber-800 dark:text-amber-400">Lengkapi Profil Anda</h3>
                                <p class="text-sm text-amber-700 dark:text-amber-300">Tambahkan informasi fakultas agar admin lebih mudah memverifikasi pengajuan Anda.</p>
                            </div>
                        </div>
                        <a href="{{ route('profile.edit') }}" class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-bold rounded-lg transition-colors whitespace-nowrap shadow-sm">
                            Buka Profil
                        </a>
                    </div>
                </div>
            @endif

            {{-- ============ STATISTIK CARDS ============ --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                {{-- Total --}}
                <div class="bg-white dark:bg-gray-800 rounded-3xl p-5 sm:p-6 shadow-sm border border-gray-100 dark:border-gray-700 relative overflow-hidden group hover:shadow-xl transition-all duration-300">
                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-gray-50 dark:bg-gray-700/50 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
                    <div class="relative flex flex-col justify-between h-full min-h-[100px]">
                        <div class="flex justify-between items-start mb-4">
                            <div class="w-12 h-12 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded-2xl flex items-center justify-center">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <span class="text-3xl font-extrabold text-gray-900 dark:text-white">{{ $stats['total'] }}</span>
                        </div>
                        <p class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Total Pengajuan</p>
                    </div>
                </div>

                {{-- Pending --}}
                <div class="bg-white dark:bg-gray-800 rounded-3xl p-5 sm:p-6 shadow-sm border border-gray-100 dark:border-gray-700 relative overflow-hidden group hover:shadow-xl transition-all duration-300">
                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-amber-50 dark:bg-amber-500/10 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
                    <div class="relative flex flex-col justify-between h-full min-h-[100px]">
                        <div class="flex justify-between items-start mb-4">
                            <div class="w-12 h-12 bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 rounded-2xl flex items-center justify-center">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <span class="text-3xl font-extrabold text-amber-600 dark:text-amber-400">{{ $stats['pending'] }}</span>
                        </div>
                        <p class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Menunggu</p>
                    </div>
                </div>

                {{-- Approved --}}
                <div class="bg-white dark:bg-gray-800 rounded-3xl p-5 sm:p-6 shadow-sm border border-gray-100 dark:border-gray-700 relative overflow-hidden group hover:shadow-xl transition-all duration-300">
                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-emerald-50 dark:bg-emerald-500/10 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
                    <div class="relative flex flex-col justify-between h-full min-h-[100px]">
                        <div class="flex justify-between items-start mb-4">
                            <div class="w-12 h-12 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 rounded-2xl flex items-center justify-center">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <span class="text-3xl font-extrabold text-emerald-600 dark:text-emerald-400">{{ $stats['approved'] }}</span>
                        </div>
                        <p class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Disetujui</p>
                    </div>
                </div>

                {{-- Rejected --}}
                <div class="bg-white dark:bg-gray-800 rounded-3xl p-5 sm:p-6 shadow-sm border border-gray-100 dark:border-gray-700 relative overflow-hidden group hover:shadow-xl transition-all duration-300">
                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-red-50 dark:bg-red-500/10 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
                    <div class="relative flex flex-col justify-between h-full min-h-[100px]">
                        <div class="flex justify-between items-start mb-4">
                            <div class="w-12 h-12 bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 rounded-2xl flex items-center justify-center">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <span class="text-3xl font-extrabold text-red-600 dark:text-red-400">{{ $stats['rejected'] }}</span>
                        </div>
                        <p class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Ditolak</p>
                    </div>
                </div>
            </div>

            {{-- ============ SUPER ADMIN QUICK ACTIONS ============ --}}
            @if(Auth::user()->isSuperAdmin())
            <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    Akses Cepat Pengelolaan
                </h3>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3">
                    <a href="{{ route('super-admin.kampus.index') }}" class="flex flex-col items-center justify-center p-4 rounded-2xl bg-gray-50 dark:bg-gray-700/50 hover:bg-rose-50 dark:hover:bg-rose-900/20 group transition-colors border border-transparent hover:border-rose-100 dark:hover:border-rose-800">
                        <svg class="w-8 h-8 text-gray-400 group-hover:text-rose-500 mb-2 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        <span class="text-xs font-bold text-gray-600 dark:text-gray-300 group-hover:text-rose-600 dark:group-hover:text-rose-400">Kampus</span>
                    </a>
                    <a href="{{ route('super-admin.cabang.index') }}" class="flex flex-col items-center justify-center p-4 rounded-2xl bg-gray-50 dark:bg-gray-700/50 hover:bg-rose-50 dark:hover:bg-rose-900/20 group transition-colors border border-transparent hover:border-rose-100 dark:hover:border-rose-800">
                        <svg class="w-8 h-8 text-gray-400 group-hover:text-rose-500 mb-2 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        <span class="text-xs font-bold text-gray-600 dark:text-gray-300 group-hover:text-rose-600 dark:group-hover:text-rose-400">Cabang</span>
                    </a>
                    <a href="{{ route('super-admin.fakultas.index') }}" class="flex flex-col items-center justify-center p-4 rounded-2xl bg-gray-50 dark:bg-gray-700/50 hover:bg-rose-50 dark:hover:bg-rose-900/20 group transition-colors border border-transparent hover:border-rose-100 dark:hover:border-rose-800">
                        <svg class="w-8 h-8 text-gray-400 group-hover:text-rose-500 mb-2 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        <span class="text-xs font-bold text-gray-600 dark:text-gray-300 group-hover:text-rose-600 dark:group-hover:text-rose-400">Fakultas</span>
                    </a>
                    <a href="{{ route('super-admin.gedung.index') }}" class="flex flex-col items-center justify-center p-4 rounded-2xl bg-gray-50 dark:bg-gray-700/50 hover:bg-rose-50 dark:hover:bg-rose-900/20 group transition-colors border border-transparent hover:border-rose-100 dark:hover:border-rose-800">
                        <svg class="w-8 h-8 text-gray-400 group-hover:text-rose-500 mb-2 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path></svg>
                        <span class="text-xs font-bold text-gray-600 dark:text-gray-300 group-hover:text-rose-600 dark:group-hover:text-rose-400">Gedung</span>
                    </a>
                    <a href="{{ route('super-admin.ruangan.index') }}" class="flex flex-col items-center justify-center p-4 rounded-2xl bg-gray-50 dark:bg-gray-700/50 hover:bg-rose-50 dark:hover:bg-rose-900/20 group transition-colors border border-transparent hover:border-rose-100 dark:hover:border-rose-800">
                        <svg class="w-8 h-8 text-gray-400 group-hover:text-rose-500 mb-2 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"></path></svg>
                        <span class="text-xs font-bold text-gray-600 dark:text-gray-300 group-hover:text-rose-600 dark:group-hover:text-rose-400">Ruangan</span>
                    </a>
                    <a href="{{ route('super-admin.users.index') }}" class="flex flex-col items-center justify-center p-4 rounded-2xl bg-gray-50 dark:bg-gray-700/50 hover:bg-rose-50 dark:hover:bg-rose-900/20 group transition-colors border border-transparent hover:border-rose-100 dark:hover:border-rose-800">
                        <svg class="w-8 h-8 text-gray-400 group-hover:text-rose-500 mb-2 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        <span class="text-xs font-bold text-gray-600 dark:text-gray-300 group-hover:text-rose-600 dark:group-hover:text-rose-400">User</span>
                    </a>
                </div>
            </div>
            @endif

            {{-- ============ ADMIN VIEW: PENDING APPROVAL ============ --}}
            @if(Auth::user()->isAdmin() && isset($pending))
            <div class="bg-white dark:bg-gray-800 rounded-3xl overflow-hidden shadow-sm border border-gray-100 dark:border-gray-700">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center">
                            <svg class="w-5 h-5 mr-2 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            Perlu Persetujuan Anda
                        </h3>
                        <a href="{{ route('approval.index') }}" class="text-sm font-bold text-rose-500 hover:text-rose-600 transition-colors flex items-center bg-rose-50 dark:bg-rose-500/10 px-3 py-1.5 rounded-lg">
                            Lihat Semua
                        </a>
                    </div>

                    @if($pending->count() > 0)
                        <!-- Tampilan Card untuk Mobile, Tabel untuk Desktop -->
                        <div class="block lg:hidden space-y-4">
                            @foreach ($pending->take(5) as $item)
                                <div class="bg-gray-50 dark:bg-gray-700/30 border border-gray-200 dark:border-gray-600 rounded-2xl p-4 flex flex-col gap-3">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <span class="text-xs font-bold text-gray-500 dark:text-gray-400">#{{ $item->id_peminjaman }}</span>
                                            <h4 class="font-bold text-gray-900 dark:text-white leading-tight mt-1">{{ $item->user->name ?? 'User Dihapus' }}</h4>
                                            <span class="inline-block px-2 py-0.5 mt-1 rounded text-[10px] font-bold uppercase tracking-wider bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-300">
                                                {{ $item->user->role ?? 'N/A' }}
                                            </span>
                                        </div>
                                        <div class="flex gap-2">
                                            <form action="{{ route('approval.approve', $item->id_peminjaman) }}" method="POST">
                                                @csrf <input type="hidden" name="status" value="approved">
                                                <button type="submit" class="w-8 h-8 bg-emerald-100 hover:bg-emerald-500 text-emerald-600 hover:text-white rounded-lg flex items-center justify-center transition-colors" title="Setujui"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg></button>
                                            </form>
                                            <form action="{{ route('approval.approve', $item->id_peminjaman) }}" method="POST" onsubmit="return confirm('Tolak pengajuan ini?');">
                                                @csrf <input type="hidden" name="status" value="rejected">
                                                <button type="submit" class="w-8 h-8 bg-red-100 hover:bg-red-500 text-red-600 hover:text-white rounded-lg flex items-center justify-center transition-colors" title="Tolak"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="text-sm">
                                        <p class="font-semibold text-gray-700 dark:text-gray-300 mb-1">Ruangan:</p>
                                        <div class="flex flex-wrap gap-1">
                                            @foreach($item->ruangan as $r)
                                                <span class="inline-block px-2 py-1 rounded bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 text-xs">{{ $r->nama_ruangan }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 rounded-lg p-2 border border-gray-100 dark:border-gray-700">
                                        {{ \Carbon\Carbon::parse($item->waktu_mulai)->format('d M y, H:i') }} - {{ \Carbon\Carbon::parse($item->waktu_selesai)->format('H:i') }}
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="hidden lg:block overflow-x-auto rounded-xl border border-gray-200 dark:border-gray-700">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                                <thead class="bg-gray-50 dark:bg-gray-800">
                                    <tr>
                                        <th scope="col" class="py-3 px-4 text-left font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Pemohon</th>
                                        <th scope="col" class="py-3 px-4 text-left font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Ruangan</th>
                                        <th scope="col" class="py-3 px-4 text-left font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Waktu</th>
                                        <th scope="col" class="py-3 px-4 text-left font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tujuan</th>
                                        <th scope="col" class="py-3 px-4 text-center font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800/50">
                                    @foreach ($pending->take(5) as $item)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                        <td class="py-4 px-4">
                                            <div class="font-bold text-gray-900 dark:text-white">{{ $item->user->name ?? 'User Dihapus' }}</div>
                                            <span class="inline-flex mt-1 text-[10px] font-bold uppercase tracking-wider text-rose-600 bg-rose-100 dark:bg-rose-500/20 px-2 py-0.5 rounded-full">
                                                {{ $item->user->role ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-4">
                                            <div class="flex flex-wrap gap-1">
                                            @foreach($item->ruangan as $r)
                                                <span class="inline-flex items-center px-2 py-1 rounded bg-gray-100 dark:bg-gray-700 text-xs font-semibold text-gray-700 dark:text-gray-300">
                                                    {{ $r->nama_ruangan }}
                                                </span>
                                            @endforeach
                                            </div>
                                        </td>
                                        <td class="py-4 px-4 whitespace-nowrap text-gray-600 dark:text-gray-300">
                                            {{ \Carbon\Carbon::parse($item->waktu_mulai)->format('d M y') }}<br>
                                            <span class="font-bold">{{ \Carbon\Carbon::parse($item->waktu_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($item->waktu_selesai)->format('H:i') }}</span>
                                        </td>
                                        <td class="py-4 px-4 text-gray-600 dark:text-gray-300">{{ Str::limit($item->tujuan, 30) }}</td>
                                        <td class="py-4 px-4 text-center">
                                            <div class="flex justify-center gap-2">
                                                <form action="{{ route('approval.approve', $item->id_peminjaman) }}" method="POST">
                                                    @csrf <input type="hidden" name="status" value="approved">
                                                    <button type="submit" class="w-9 h-9 bg-emerald-100 hover:bg-emerald-500 text-emerald-600 hover:text-white rounded-xl flex items-center justify-center transition-all hover:scale-110 shadow-sm" title="Setujui"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg></button>
                                                </form>
                                                <form action="{{ route('approval.approve', $item->id_peminjaman) }}" method="POST" onsubmit="return confirm('Tolak pengajuan ini?');">
                                                    @csrf <input type="hidden" name="status" value="rejected">
                                                    <button type="submit" class="w-9 h-9 bg-red-100 hover:bg-red-500 text-red-600 hover:text-white rounded-xl flex items-center justify-center transition-all hover:scale-110 shadow-sm" title="Tolak"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="py-12 text-center text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-800/50 rounded-2xl border border-dashed border-gray-200 dark:border-gray-700">
                            <div class="w-16 h-16 bg-emerald-100 dark:bg-emerald-900/30 rounded-full flex items-center justify-center mx-auto mb-3">
                                <svg class="w-8 h-8 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <p class="font-bold text-gray-900 dark:text-gray-200">Semua Beres!</p>
                            <p class="text-sm mt-1">Tidak ada pengajuan yang menunggu persetujuan Anda saat ini.</p>
                        </div>
                    @endif
                </div>
            </div>
            @endif

            {{-- ============ USER VIEW: LIST PEMINJAMAN SAYA ============ --}}
            @if(!Auth::user()->isAdmin() && isset($myPeminjaman))
            <div class="bg-white dark:bg-gray-800 rounded-3xl overflow-hidden shadow-sm border border-gray-100 dark:border-gray-700">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center">
                            <svg class="w-5 h-5 mr-2 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Peminjaman Terbaru Anda
                        </h3>
                        @if($myPeminjaman->count() > 0)
                        <a href="{{ route('peminjaman.index') }}" class="text-sm font-bold text-rose-500 hover:text-rose-600 transition-colors flex items-center">
                            Riwayat Lengkap
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                        @endif
                    </div>

                    @if($myPeminjaman->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                            @foreach ($myPeminjaman->take(6) as $item)
                                <div class="bg-gray-50 dark:bg-gray-700/30 rounded-2xl p-5 border border-gray-100 dark:border-gray-700 hover:border-rose-200 dark:hover:border-rose-800 transition-colors group">
                                    <div class="flex justify-between items-start mb-4">
                                        <div>
                                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1 block">ID #{{ $item->id_peminjaman }}</span>
                                            <h4 class="font-bold text-gray-900 dark:text-white leading-tight">
                                                @foreach($item->ruangan as $r)
                                                    {{ $r->nama_ruangan }}{{ !$loop->last ? ', ' : '' }}
                                                @endforeach
                                            </h4>
                                        </div>
                                        <div>
                                            @if($item->status === 'approved')
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-400">Disetujui</span>
                                            @elseif($item->status === 'rejected')
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-red-100 text-red-700 dark:bg-red-500/20 dark:text-red-400">Ditolak</span>
                                            @elseif($item->status === 'cancelled')
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-gray-200 text-gray-700 dark:bg-gray-600 dark:text-gray-300">Dibatalkan</span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-amber-100 text-amber-700 dark:bg-amber-500/20 dark:text-amber-400">
                                                    <svg class="w-3 h-3 mr-1 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                                                    Menunggu
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="bg-white dark:bg-gray-800 rounded-xl p-3 border border-gray-100 dark:border-gray-700 mb-3">
                                        <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-300">
                                            <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            <span class="font-semibold">{{ \Carbon\Carbon::parse($item->waktu_mulai)->format('d M y') }}</span>
                                        </div>
                                        <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-300 mt-1">
                                            <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            <span>{{ \Carbon\Carbon::parse($item->waktu_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($item->waktu_selesai)->format('H:i') }}</span>
                                        </div>
                                    </div>

                                    <div class="text-xs text-gray-500 dark:text-gray-400 line-clamp-2">
                                        <span class="font-semibold text-gray-700 dark:text-gray-300">Tujuan:</span> {{ $item->tujuan }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="py-12 text-center bg-gray-50 dark:bg-gray-800/50 rounded-2xl border border-dashed border-gray-200 dark:border-gray-700">
                            <div class="w-16 h-16 bg-white dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Belum Ada Pengajuan</h3>
                            <p class="text-gray-500 dark:text-gray-400 mt-1 max-w-sm mx-auto">Anda belum membuat pengajuan peminjaman ruangan. Klik tombol di bawah untuk mulai memesan ruangan.</p>
                            <a href="{{ route('peminjaman.create') }}" class="mt-6 inline-flex items-center px-6 py-3 bg-gradient-to-r from-red-600 to-rose-500 rounded-xl font-bold text-sm text-white hover:from-red-700 hover:to-rose-600 transition-all shadow-lg shadow-rose-500/30 hover:-translate-y-0.5">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Cari Ruangan
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            @endif

        </div>
    </div>
</x-app-layout>
