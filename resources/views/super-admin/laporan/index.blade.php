<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                Laporan Pemakaian Ruangan
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-6">
                <form method="GET" action="{{ route('super-admin.laporan.index') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
                    <div>
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-300" for="start_date">Mulai</label>
                        <input
                            id="start_date"
                            name="start_date"
                            type="date"
                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md"
                            value="{{ $startDate }}"
                        />
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-300" for="end_date">Sampai</label>
                        <input
                            id="end_date"
                            name="end_date"
                            type="date"
                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md"
                            value="{{ $endDate }}"
                        />
                    </div>
                    <div class="md:col-span-3 flex md:justify-end">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-rose-600 text-white text-sm font-semibold rounded-lg hover:bg-rose-700">
                            Terapkan
                        </button>
                    </div>
                </form>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-6 overflow-x-auto">
                    <h3 class="text-lg font-semibold mb-3">Jumlah Pemakain per Fakultas (Approved)</h3>
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                        <thead class="text-left bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                            <tr>
                                <th class="px-3 py-2">Fakultas/Unit</th>
                                <th class="px-3 py-2">Jumlah Peminjaman (Distinct)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($facultyStats as $row)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                                    <td class="px-3 py-2">{{ $row->nama_fakultas ?? 'Umum' }}</td>
                                    <td class="px-3 py-2 font-medium">{{ $row->jumlah_peminjaman }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="px-3 py-4 text-center text-gray-500">Belum ada data.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-6 overflow-x-auto">
                    <h3 class="text-lg font-semibold mb-3">Penggunaan per Tipe Ruangan (Approved)</h3>
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                        <thead class="text-left bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                            <tr>
                                <th class="px-3 py-2">Tipe Ruangan</th>
                                <th class="px-3 py-2">Jumlah Penggunaan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($roomTypeStats as $row)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                                    <td class="px-3 py-2">{{ $row->tipe_ruangan }}</td>
                                    <td class="px-3 py-2 font-medium">{{ $row->jumlah_penggunaan_ruangan }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="px-3 py-4 text-center text-gray-500">Belum ada data.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-6 overflow-x-auto">
                <div class="flex items-center justify-between gap-3 mb-3">
                    <h3 class="text-lg font-semibold">Riwayat Peminjaman (Approved) pada Periode</h3>
                </div>
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                    <thead class="text-left bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                        <tr>
                            <th class="px-3 py-2">ID</th>
                            <th class="px-3 py-2">Pemohon</th>
                            <th class="px-3 py-2">Waktu</th>
                            <th class="px-3 py-2">Ruangan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($history as $item)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                                <td class="px-3 py-2">#{{ $item->id_peminjaman }}</td>
                                <td class="px-3 py-2">
                                    <div class="font-medium">{{ $item->user->name ?? '-' }}</div>
                                    <div class="text-gray-500 text-xs">{{ $item->user->email ?? '' }}</div>
                                </td>
                                <td class="px-3 py-2">
                                    <div>{{ \Carbon\Carbon::parse($item->waktu_mulai)->format('d M y, H:i') }}</div>
                                    <div class="text-gray-500 text-xs">s/d {{ \Carbon\Carbon::parse($item->waktu_selesai)->format('d M y, H:i') }}</div>
                                </td>
                                <td class="px-3 py-2">
                                    <div class="flex flex-col gap-1">
                                        @foreach($item->ruangan as $r)
                                            <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-semibold bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200 border border-gray-200 dark:border-gray-600">
                                                {{ $r->nama_ruangan }} ({{ $r->tipe_ruangan }})
                                            </span>
                                        @endforeach
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-3 py-4 text-center text-gray-500">Belum ada riwayat.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>

