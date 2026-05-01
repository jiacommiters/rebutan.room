<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-200 leading-tight">Kelola Ruangan</h2>
            <a href="{{ route('super-admin.ruangan.create') }}" class="inline-flex items-center px-4 py-2 bg-rose-600 text-white text-sm font-semibold rounded-lg hover:bg-rose-700">
                Tambah Ruangan
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 text-green-700 px-4 py-3 rounded-lg">{{ session('success') }}</div>
            @endif

            <div class="bg-white dark:bg-gray-800 shadow rounded-xl overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm mobile-stacked-table">
                    <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                        <tr>
                            <th class="px-4 py-3 text-left">Nama</th>
                            <th class="px-4 py-3 text-left">Tipe</th>
                            <th class="px-4 py-3 text-left">Nomor</th>
                            <th class="px-4 py-3 text-left">Gedung</th>
                            <th class="px-4 py-3 text-left">Kapasitas</th>
                            <th class="px-4 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($ruangan as $item)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                                <td class="px-4 py-3" data-label="Nama">{{ $item->nama_ruangan }}</td>
                                <td class="px-4 py-3" data-label="Tipe">{{ $item->tipe_ruangan }}</td>
                                <td class="px-4 py-3" data-label="Nomor">{{ $item->nomor_ruangan }}</td>
                                <td class="px-4 py-3" data-label="Gedung">{{ $item->gedung->nama_gedung ?? '-' }}</td>
                                <td class="px-4 py-3" data-label="Kapasitas">{{ $item->kapasitas }}</td>
                                <td class="px-4 py-3 text-right actions-cell" data-label="Aksi">
                                    <a href="{{ route('super-admin.ruangan.edit', $item) }}" class="text-blue-600 hover:underline">Edit</a>
                                    <form action="{{ route('super-admin.ruangan.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Hapus ruangan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600 hover:underline ml-3">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-6 text-center text-gray-500">Belum ada data ruangan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $ruangan->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
