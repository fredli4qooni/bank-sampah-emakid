<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-green-800 leading-tight">
            {{ __('Data Nasabah') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
            <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm">
                {{ session('success') }}
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
                <div class="p-6 text-gray-900">

                    @can('isAdmin')
                    <div class="mb-6 flex justify-between items-center">
                        <a href="{{ route('nasabah.create') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2.5 px-5 rounded-lg shadow transition-colors flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Tambah Nasabah
                        </a>
                    </div>
                    @endcan

                    <div class="overflow-x-auto rounded-lg border border-gray-200">
                        <table class="w-full text-sm text-left text-gray-600">
                            <thead class="text-xs text-green-800 uppercase bg-green-50 border-b border-green-100">
                                <tr>
                                    <th scope="col" class="px-6 py-4 font-bold">No. Rekening</th>
                                    <th scope="col" class="px-6 py-4 font-bold">Nama Lengkap</th>
                                    <th class="px-6 py-4 font-bold">Kecamatan</th>
                                    <th class="px-6 py-4 font-bold">Unit/Kelompok</th>
                                    <th class="px-6 py-4 font-bold">No. HP</th>
                                    <th scope="col" class="px-6 py-4 font-bold">Total Saldo</th>
                                    @can('isAdmin')
                                    <th scope="col" class="px-6 py-4 font-bold text-center">Aksi</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse ($nasabah as $n)
                                <tr class="bg-white hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 font-semibold text-green-700">{{ $n->no_rekening }}</td>
                                    <td class="px-6 py-4 font-bold text-gray-800">{{ $n->nama }}</td>
                                    <td class="px-6 py-4">{{ $n->kecamatan }}</td>
                                    <td class="px-6 py-4 font-medium text-green-700">
                                        {{ $n->unit ? $n->unit->nama_unit : '-' }}
                                    </td>
                                    <td class="px-6 py-4">{{ $n->no_hp }}</td>
                                    <td class="px-6 py-4 font-semibold text-gray-900">Rp {{ number_format($n->saldo, 0, ',', '.') }}</td>

                                    @can('isAdmin')
                                    <td class="px-6 py-4 flex justify-center space-x-3">
                                        <a href="{{ route('nasabah.edit', $n->id_nasabah) }}" class="text-green-600 hover:text-green-800 font-medium">Edit</a>
                                        <span class="text-gray-300">|</span>
                                        <form action="{{ route('nasabah.destroy', $n->id_nasabah) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus nasabah ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 font-medium">Hapus</button>
                                        </form>
                                    </td>
                                    @endcan
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-gray-400">Belum ada data nasabah yang terdaftar.</td>
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