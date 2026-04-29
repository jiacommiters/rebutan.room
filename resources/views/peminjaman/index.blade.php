<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Riwayat Peminjaman Ruangan') }}
            </h2>
            <a href="{{ route('peminjaman.create') }}" class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-red-600 to-rose-500 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest hover:from-red-700 hover:to-rose-600 active:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-all shadow-lg shadow-red-500/30 hover:-translate-y-0.5">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Buat Pengajuan Baru
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl relative shadow-sm" role="alert">
                    <strong class="font-bold">Behasil!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="glass-card overflow-hidden sm:rounded-2xl border-t-4 border-t-red-500">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead>
                                <tr class="bg-gray-50/70 dark:bg-gray-800/60">
                                    <th scope="col" class="py-3 px-6 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
                                    <th scope="col" class="py-3 px-6 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Peminjam</th>
                                    <th scope="col" class="py-3 px-6 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Ruangan</th>
                                    <th scope="col" class="py-3 px-6 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Waktu</th>
                                    <th scope="col" class="py-3 px-6 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tujuan</th>
                                    <th scope="col" class="py-3 px-6 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="py-3 px-6 text-right text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200/50 dark:divide-gray-700/50">
                                @forelse ($data as $item)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-colors">
                                        <td class="py-4 px-6 whitespace-nowrap font-medium">#{{ $item->id_peminjaman }}</td>
                                        <td class="py-4 px-6">
                                            <div class="font-semibold">{{ $item->user->name ?? 'User Dihapus' }}</div>
                                            <div class="text-xs text-gray-500">{{ $item->user->email ?? '' }}</div>
                                        </td>
                                        <td class="py-4 px-6 max-w-xs">
                                            <div class="flex flex-wrap gap-1">
                                            @foreach($item->ruangan as $r)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300">
                                                    {{ $r->nama_ruangan }}
                                                </span>
                                            @endforeach
                                            </div>
                                        </td>
                                        <td class="py-4 px-6 whitespace-nowrap">
                                            <div class="text-sm">
                                                <span class="text-gray-500 dark:text-gray-400 text-xs block">Mulai:</span>
                                                {{ \Carbon\Carbon::parse($item->waktu_mulai)->format('d M Y, H:i') }}
                                            </div>
                                            <div class="text-sm mt-1">
                                                <span class="text-gray-500 dark:text-gray-400 text-xs block">Selesai:</span>
                                                {{ \Carbon\Carbon::parse($item->waktu_selesai)->format('d M Y, H:i') }}
                                            </div>
                                        </td>
                                        <td class="py-4 px-6 text-sm">{{ Str::limit($item->tujuan, 30) }}</td>
                                        <td class="py-4 px-6 whitespace-nowrap">
                                            @if($item->status === 'approved')
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400 border border-green-200 dark:border-green-800">
                                                    Disetujui
                                                </span>
                                            @elseif($item->status === 'rejected')
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400 border border-red-200 dark:border-red-800">
                                                    Ditolak
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400 border border-yellow-200 dark:border-yellow-800">
                                                    Menunggu
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-4 px-6 text-right whitespace-nowrap">
                                            @if($item->status === 'pending' && ($item->id_user === Auth::id() || Auth::user()->isAdmin()))
                                            <form action="{{ route('peminjaman.destroy', $item->id_peminjaman) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan/menghapus pengajuan ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 font-medium text-sm transition-colors bg-red-50 dark:bg-red-900/10 px-3 py-1.5 rounded-lg hover:bg-red-100 dark:hover:bg-red-900/30">
                                                    Batal
                                                </button>
                                            </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="py-12 px-6 text-center text-gray-500 dark:text-gray-400">
                                            <div class="flex flex-col items-center justify-center">
                                                <svg class="w-12 h-12 mb-4 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                                <p>Belum ada data peminjaman ruangan.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>