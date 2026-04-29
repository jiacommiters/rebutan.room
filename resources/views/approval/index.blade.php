<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Approval Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl relative shadow-sm" role="alert">
                    <strong class="font-bold">Berhasil!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="glass-card overflow-hidden sm:rounded-2xl border-t-4 border-t-rose-500">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <h3 class="text-lg font-semibold mb-6 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Menunggu Persetujuan (Per Ruangan)
                    </h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead>
                                <tr class="bg-gray-50/70 dark:bg-gray-800/60">
                                    <th scope="col" class="py-3 px-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider rounded-tl-lg">ID</th>
                                    <th scope="col" class="py-3 px-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Pemohon</th>
                                    <th scope="col" class="py-3 px-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Waktu & Tujuan</th>
                                    <th scope="col" class="py-3 px-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Ruangan</th>
                                    <th scope="col" class="py-3 px-4 text-center text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider rounded-tr-lg">Keputusan Per Ruangan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200/50 dark:divide-gray-700/50">
                                @forelse ($data as $item)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-colors">
                                        <td class="py-4 px-4 whitespace-nowrap font-medium text-sm align-top">
                                            #{{ $item->id_peminjaman }}<br>
                                            @if($item->surat)
                                                <a href="{{ Storage::url($item->surat) }}" target="_blank" class="mt-2 text-xs flex items-center text-rose-500 hover:text-rose-700">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                                    Lihat Surat
                                                </a>
                                            @endif
                                        </td>
                                        <td class="py-4 px-4 align-top">
                                            <div class="font-bold text-gray-900 dark:text-white">{{ $item->user->name ?? 'User Dihapus' }}</div>
                                            <div class="text-xs text-gray-500">{{ $item->user->email ?? '' }}</div>
                                            <span class="inline-flex mt-1 text-[10px] font-bold uppercase tracking-wider text-rose-500 bg-rose-100 dark:bg-rose-900/30 px-1.5 py-0.5 rounded">
                                                {{ $item->user->role ?? 'Role?' }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-4 align-top">
                                            <div class="text-sm">
                                                {{ \Carbon\Carbon::parse($item->waktu_mulai)->format('d M y, H:i') }} <br>
                                                <span class="text-gray-400 text-xs">s/d</span> <br>
                                                {{ \Carbon\Carbon::parse($item->waktu_selesai)->format('d M y, H:i') }}
                                            </div>
                                            <div class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                                                <strong>Tujuan:</strong><br>
                                                {{ Str::limit($item->tujuan, 50) }}
                                            </div>
                                        </td>
                                        <td class="py-4 px-4 col-span-2 align-top m-0 p-0" colspan="2">
                                            <div class="flex flex-col gap-3">
                                                @foreach($item->ruangan as $r)
                                                    @php
                                                        // Cari persetujuan untuk ruangan ini
                                                        $persetujuan = $item->persetujuan->where('id_ruangan', $r->id_ruangan)->first();
                                                        $canApprove = Auth::user()->canApproveRuangan($r);
                                                    @endphp
                                                    
                                                    @if($canApprove || $persetujuan)
                                                        <div class="flex items-center justify-between p-4 bg-white/60 dark:bg-gray-800/60 rounded-xl border border-gray-200/50 dark:border-gray-700/50 backdrop-blur-sm">
                                                            <div>
                                                                <span class="font-extrabold text-gray-900 dark:text-gray-100 block leading-tight">{{ $r->nama_ruangan }}</span>
                                                                <span class="text-xs text-gray-500 dark:text-gray-400">
                                                                    {{ $r->gedung->nama_gedung ?? '-' }}
                                                                    @if($r->gedung && $r->gedung->fakultas)
                                                                        ({{ $r->gedung->fakultas->nama_fakultas }})
                                                                    @endif
                                                                </span>
                                                                
                                                                @if($persetujuan)
                                                                    <div class="mt-1">
                                                                        @if($persetujuan->status === 'approved')
                                                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400 border border-green-200 dark:border-green-800">Telah Disetujui</span>
                                                                        @elseif($persetujuan->status === 'rejected')
                                                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400 border border-red-200 dark:border-red-800">Telah Ditolak</span>
                                                                        @endif
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            
                                                            @if($canApprove && (!$persetujuan || !in_array($persetujuan->status, ['approved', 'rejected'])))
                                                                <div class="flex flex-wrap gap-2 justify-end ml-4">
                                                                    <!-- Form Setuju -->
                                                                    <form action="{{ route('approval.approve.ruangan', ['id_peminjaman' => $item->id_peminjaman, 'id_ruangan' => $r->id_ruangan]) }}" method="POST" class="flex gap-2">
                                                                        @csrf
                                                                        <input type="text" name="komentar" placeholder="Catatan (opsional)" class="text-xs rounded-lg border-gray-200/60 dark:border-gray-600 dark:bg-gray-900/40 dark:text-white px-2 py-1 w-32 focus:ring-rose-500 focus:border-rose-500">
                                                                        <input type="hidden" name="status" value="approved">
                                                                        <button type="submit" class="inline-flex items-center justify-center w-9 h-9 bg-green-500 hover:bg-green-600 text-white rounded-xl shadow-md transition-all hover:scale-[1.03]" title="Setujui">
                                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                                        </button>
                                                                    </form>

                                                                    <!-- Form Tolak -->
                                                                    <form action="{{ route('approval.approve.ruangan', ['id_peminjaman' => $item->id_peminjaman, 'id_ruangan' => $r->id_ruangan]) }}" method="POST" onsubmit="return confirm('Tolak ruangan ini?');" class="flex">
                                                                        @csrf
                                                                        <!-- Keep the comment from the first form if needed, or require a separate comment input. For simplicity, we just add the reject button here -->
                                                                        <input type="hidden" name="status" value="rejected">
                                                                        <button type="submit" class="inline-flex items-center justify-center w-9 h-9 bg-red-500 hover:bg-red-600 text-white rounded-xl shadow-md transition-all hover:scale-[1.03]" title="Tolak">
                                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            @elseif(!$canApprove)
                                                                <div class="text-xs text-gray-400 italic">Bukan wewenang Anda</div>
                                                            @endif
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-16 px-6 text-center text-gray-500 dark:text-gray-400">
                                            <div class="flex flex-col items-center justify-center">
                                                <div class="w-16 h-16 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mb-4">
                                                    <svg class="w-8 h-8 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                </div>
                                                <p class="text-lg font-medium text-gray-900 dark:text-gray-200">Semua Beres!</p>
                                                <p class="mt-1">Tidak ada pengajuan yang perlu di-review saat ini.</p>
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