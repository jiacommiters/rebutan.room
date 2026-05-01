<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-200 leading-tight">Kelola Fakultas</h2>
            <a href="{{ route('super-admin.fakultas.create') }}" class="inline-flex items-center px-4 py-2 bg-rose-600 text-white text-sm font-semibold rounded-lg hover:bg-rose-700">
                Tambah Fakultas
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 text-green-700 px-4 py-3 rounded-lg">{{ session('success') }}</div>
            @endif

            <div class="bg-white dark:bg-gray-800 shadow rounded-xl overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm mobile-stacked-table">
                    <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                        <tr>
                            <th class="px-4 py-3 text-left">Kampus</th>
                            <th class="px-4 py-3 text-left">Cabang</th>
                            <th class="px-4 py-3 text-left">Nama Fakultas</th>
                            <th class="px-4 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($fakultas as $item)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                                <td class="px-4 py-3" data-label="Kampus">{{ $item->cabang->kampus->nama_kampus ?? '-' }}</td>
                                <td class="px-4 py-3" data-label="Cabang">{{ $item->cabang->nama_cabang ?? '-' }}</td>
                                <td class="px-4 py-3" data-label="Nama Fakultas">{{ $item->nama_fakultas }}</td>
                                <td class="px-4 py-3 text-right actions-cell" data-label="Aksi">
                                    <a href="{{ route('super-admin.fakultas.edit', $item) }}" class="text-blue-600 hover:underline">Edit</a>
                                    <form action="{{ route('super-admin.fakultas.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Hapus fakultas ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600 hover:underline ml-3">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-6 text-center text-gray-500">Belum ada data.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $fakultas->links() }}
            </div>
        </div>
    </div>
</x-app-layout>

