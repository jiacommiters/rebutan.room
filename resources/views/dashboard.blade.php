<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Dashboard') }}
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Selamat datang, <span class="font-semibold text-rose-500">{{ Auth::user()->name }}</span>
                    <span class="inline-flex items-center ml-2 px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-rose-100 text-rose-600 dark:bg-rose-900/30 dark:text-rose-400">{{ Auth::user()->role }}</span>
                </p>
            </div>
            @if(!Auth::user()->isAdmin())
            <a href="{{ route('peminjaman.create') }}" class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-red-600 to-rose-500 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest hover:from-red-700 hover:to-rose-600 transition-all shadow-lg shadow-red-500/30 hover:-translate-y-0.5">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Buat Pengajuan Baru
            </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- ============ STATISTIK CARDS ============ --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                {{-- Total --}}
                <div class="glass-card rounded-2xl p-5 sm:p-6 relative overflow-hidden group hover:-translate-y-1 transition-all duration-300">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-bl from-gray-200/30 dark:from-gray-700/20 to-transparent rounded-bl-full"></div>
                    <div class="relative">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gray-100 dark:bg-gray-800 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <p class="text-xs sm:text-sm font-medium text-gray-500 dark:text-gray-400">Total Pengajuan</p>
                        <p class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $stats['total'] }}</p>
                    </div>
                </div>
                {{-- Pending --}}
                <div class="glass-card rounded-2xl p-5 sm:p-6 relative overflow-hidden group hover:-translate-y-1 transition-all duration-300">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-bl from-yellow-200/30 dark:from-yellow-700/20 to-transparent rounded-bl-full"></div>
                    <div class="relative">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-yellow-100 dark:bg-yellow-900/30 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <p class="text-xs sm:text-sm font-medium text-gray-500 dark:text-gray-400">Menunggu</p>
                        <p class="text-2xl sm:text-3xl font-bold text-yellow-600 dark:text-yellow-400 mt-1">{{ $stats['pending'] }}</p>
                    </div>
                </div>
                {{-- Approved --}}
                <div class="glass-card rounded-2xl p-5 sm:p-6 relative overflow-hidden group hover:-translate-y-1 transition-all duration-300">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-bl from-green-200/30 dark:from-green-700/20 to-transparent rounded-bl-full"></div>
                    <div class="relative">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-green-100 dark:bg-green-900/30 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <p class="text-xs sm:text-sm font-medium text-gray-500 dark:text-gray-400">Disetujui</p>
                        <p class="text-2xl sm:text-3xl font-bold text-green-600 dark:text-green-400 mt-1">{{ $stats['approved'] }}</p>
                    </div>
                </div>
                {{-- Rejected --}}
                <div class="glass-card rounded-2xl p-5 sm:p-6 relative overflow-hidden group hover:-translate-y-1 transition-all duration-300">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-bl from-red-200/30 dark:from-red-700/20 to-transparent rounded-bl-full"></div>
                    <div class="relative">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-red-100 dark:bg-red-900/30 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <p class="text-xs sm:text-sm font-medium text-gray-500 dark:text-gray-400">Ditolak</p>
                        <p class="text-2xl sm:text-3xl font-bold text-red-600 dark:text-red-400 mt-1">{{ $stats['rejected'] }}</p>
                    </div>
                </div>
            </div>

            {{-- ============ ADMIN VIEW: LIST PENGAJUAN PENDING ============ --}}
            @if(Auth::user()->isAdmin() && isset($pending))
            <div class="glass-card overflow-hidden sm:rounded-2xl border-t-4 border-t-rose-500">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-bold flex items-center">
                            <svg class="w-5 h-5 mr-2 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Pengajuan Menunggu Persetujuan
                        </h3>
                        <a href="{{ route('approval.index') }}" class="text-sm font-semibold text-rose-500 hover:text-rose-600 transition-colors flex items-center">
                            Lihat Semua
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </div>

                    @if($pending->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead>
                                <tr class="bg-gray-50/70 dark:bg-gray-800/60">
                                    <th scope="col" class="py-3 px-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider rounded-tl-lg">ID</th>
                                    <th scope="col" class="py-3 px-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Pemohon</th>
                                    <th scope="col" class="py-3 px-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Ruangan</th>
                                    <th scope="col" class="py-3 px-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Waktu</th>
                                    <th scope="col" class="py-3 px-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tujuan</th>
                                    <th scope="col" class="py-3 px-4 text-center text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider rounded-tr-lg">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200/50 dark:divide-gray-700/50">
                                @foreach ($pending->take(5) as $item)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-colors">
                                        <td class="py-4 px-4 whitespace-nowrap font-medium text-sm">#{{ $item->id_peminjaman }}</td>
                                    <td class="py-4 px-4">
                                        <div class="font-bold text-gray-900 dark:text-white">{{ $item->user->name ?? 'User Dihapus' }}</div>
                                        <div class="text-xs text-gray-500">{{ $item->user->email ?? '' }}</div>
                                        <span class="inline-flex mt-1 text-[10px] font-bold uppercase tracking-wider text-rose-500 bg-rose-100 dark:bg-rose-900/30 px-1.5 py-0.5 rounded">
                                            {{ $item->user->role ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-4 max-w-xs">
                                        <div class="flex flex-col gap-1 items-start">
                                        @foreach($item->ruangan as $r)
                                            <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-semibold bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200 border border-gray-200 dark:border-gray-600 shadow-sm">
                                                {{ $r->nama_ruangan }}
                                            </span>
                                        @endforeach
                                        </div>
                                    </td>
                                    <td class="py-4 px-4 whitespace-nowrap">
                                        <div class="text-sm">
                                            {{ \Carbon\Carbon::parse($item->waktu_mulai)->format('d M y, H:i') }} <br>
                                            <span class="text-gray-400 text-xs">s/d</span> <br>
                                            {{ \Carbon\Carbon::parse($item->waktu_selesai)->format('d M y, H:i') }}
                                        </div>
                                    </td>
                                    <td class="py-4 px-4 text-sm">{{ Str::limit($item->tujuan, 30) }}</td>
                                    <td class="py-4 px-4 text-center whitespace-nowrap">
                                        <div class="flex justify-center flex-wrap gap-2">
                                            {{-- Approve --}}
                                            <form action="{{ route('approval.approve', $item->id_peminjaman) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="status" value="approved">
                                                <button type="submit" class="inline-flex items-center justify-center w-10 h-10 bg-green-500 hover:bg-green-600 text-white rounded-xl shadow-md shadow-green-500/20 transition-all hover:-translate-y-0.5 group" title="Setujui">
                                                    <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                                </button>
                                            </form>
                                            {{-- Reject --}}
                                            <form action="{{ route('approval.approve', $item->id_peminjaman) }}" method="POST" onsubmit="return confirm('Tolak pengajuan ini?');">
                                                @csrf
                                                <input type="hidden" name="status" value="rejected">
                                                <button type="submit" class="inline-flex items-center justify-center w-10 h-10 bg-red-500 hover:bg-red-600 text-white rounded-xl shadow-md shadow-red-500/20 transition-all hover:-translate-y-0.5 group" title="Tolak">
                                                    <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if($pending->count() > 5)
                        <div class="mt-4 text-center">
                            <a href="{{ route('approval.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-semibold text-rose-600 dark:text-rose-400 bg-rose-50 dark:bg-rose-900/20 rounded-xl hover:bg-rose-100 dark:hover:bg-rose-900/30 transition-colors">
                                Lihat {{ $pending->count() - 5 }} pengajuan lainnya
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </a>
                        </div>
                    @endif
                    @else
                    <div class="py-12 text-center text-gray-500 dark:text-gray-400">
                        <div class="flex flex-col items-center justify-center">
                            <div class="w-16 h-16 bg-green-100 dark:bg-green-900/20 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-green-500 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <p class="text-lg font-medium text-gray-900 dark:text-gray-200">Semua Beres!</p>
                            <p class="mt-1">Tidak ada pengajuan yang perlu di-review saat ini.</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            {{-- ============ USER VIEW: LIST PEMINJAMAN SAYA ============ --}}
            @if(!Auth::user()->isAdmin() && isset($myPeminjaman))
            <div class="glass-card overflow-hidden sm:rounded-2xl border-t-4 border-t-rose-500">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-bold flex items-center">
                            <svg class="w-5 h-5 mr-2 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            Peminjaman Saya
                        </h3>
                        <a href="{{ route('peminjaman.index') }}" class="text-sm font-semibold text-rose-500 hover:text-rose-600 transition-colors flex items-center">
                            Lihat Semua
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </div>

                    @if($myPeminjaman->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead>
                                <tr class="bg-gray-50/70 dark:bg-gray-800/60">
                                    <th scope="col" class="py-3 px-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider rounded-tl-lg">ID</th>
                                    <th scope="col" class="py-3 px-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Ruangan</th>
                                    <th scope="col" class="py-3 px-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Waktu</th>
                                    <th scope="col" class="py-3 px-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tujuan</th>
                                    <th scope="col" class="py-3 px-4 text-center text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider rounded-tr-lg">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200/50 dark:divide-gray-700/50">
                                @foreach ($myPeminjaman->take(5) as $item)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-colors">
                                    <td class="py-4 px-4 whitespace-nowrap font-medium text-sm">#{{ $item->id_peminjaman }}</td>
                                    <td class="py-4 px-4 max-w-xs">
                                        <div class="flex flex-col gap-1 items-start">
                                        @foreach($item->ruangan as $r)
                                            <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-semibold bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200 border border-gray-200 dark:border-gray-600 shadow-sm">
                                                {{ $r->nama_ruangan }}
                                            </span>
                                        @endforeach
                                        </div>
                                    </td>
                                    <td class="py-4 px-4 whitespace-nowrap">
                                        <div class="text-sm">
                                            {{ \Carbon\Carbon::parse($item->waktu_mulai)->format('d M y, H:i') }} <br>
                                            <span class="text-gray-400 text-xs">s/d</span> <br>
                                            {{ \Carbon\Carbon::parse($item->waktu_selesai)->format('d M y, H:i') }}
                                        </div>
                                    </td>
                                    <td class="py-4 px-4 text-sm">{{ Str::limit($item->tujuan, 30) }}</td>
                                    <td class="py-4 px-4 text-center whitespace-nowrap">
                                        @if($item->status === 'approved')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400 border border-green-200 dark:border-green-800">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                                Disetujui
                                            </span>
                                        @elseif($item->status === 'rejected')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400 border border-red-200 dark:border-red-800">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                                Ditolak
                                            </span>
                                        @elseif($item->status === 'cancelled')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400 border border-gray-200 dark:border-gray-800">
                                                Dibatalkan
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400 border border-yellow-200 dark:border-yellow-800">
                                                <svg class="w-3 h-3 mr-1 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                                                Menunggu
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if($myPeminjaman->count() > 5)
                        <div class="mt-4 text-center">
                            <a href="{{ route('peminjaman.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-semibold text-rose-600 dark:text-rose-400 bg-rose-50 dark:bg-rose-900/20 rounded-xl hover:bg-rose-100 dark:hover:bg-rose-900/30 transition-colors">
                                Lihat {{ $myPeminjaman->count() - 5 }} peminjaman lainnya
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </a>
                        </div>
                    @endif
                    @else
                    <div class="py-12 text-center text-gray-500 dark:text-gray-400">
                        <div class="flex flex-col items-center justify-center">
                            <div class="w-16 h-16 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            </div>
                            <p class="text-lg font-medium text-gray-900 dark:text-gray-200">Belum Ada Pengajuan</p>
                            <p class="mt-1">Anda belum membuat pengajuan peminjaman ruangan.</p>
                            <a href="{{ route('peminjaman.create') }}" class="mt-4 inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-red-600 to-rose-500 rounded-xl font-semibold text-sm text-white hover:from-red-700 hover:to-rose-600 transition-all shadow-lg shadow-red-500/30 hover:-translate-y-0.5">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Buat Pengajuan Pertama
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endif

        </div>
    </div>
</x-app-layout>
