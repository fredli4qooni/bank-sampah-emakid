<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-green-800 leading-tight">
            {{ __('Manajemen Jenis Sampah') }}
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
                    
                    <div class="mb-6 flex justify-between items-center">
                        <a href="{{ route('jenis-sampah.create') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2.5 px-5 rounded-lg shadow transition-colors flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                            Tambah Jenis Sampah
                        </a>
                    </div>

                    <div class="overflow-x-auto rounded-lg border border-gray-200">
                        <table class="w-full text-sm text-left text-gray-600">
                            <thead class="text-xs text-green-800 uppercase bg-green-50 border-b border-green-100">
                                <tr>
                                    <th scope="col" class="px-6 py-4 font-bold">Nama Sampah</th>
                                    <th scope="col" class="px-6 py-4 font-bold">Satuan</th>
                                    <th scope="col" class="px-6 py-4 font-bold">Harga / Satuan</th>
                                    <th scope="col" class="px-6 py-4 font-bold text-center">Status</th>
                                    <th scope="col" class="px-6 py-4 font-bold text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse ($jenisSampah as $item)
                                    <tr class="bg-white hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 font-bold text-gray-800">{{ $item->nama_sampah }}</td>
                                        <td class="px-6 py-4 font-semibold uppercase text-gray-500">{{ $item->satuan }}</td>
                                        <td class="px-6 py-4 font-semibold text-gray-900">Rp {{ number_format($item->harga_per_kg, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4 text-center">
                                            @if($item->status_aktif)
                                                <span class="bg-green-100 text-green-800 text-xs font-bold px-3 py-1 rounded-full border border-green-200">Aktif</span>
                                            @else
                                                <span class="bg-gray-100 text-gray-600 text-xs font-bold px-3 py-1 rounded-full border border-gray-200">Nonaktif</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 flex justify-center space-x-3 items-center">
                                            <a href="{{ route('jenis-sampah.edit', $item->id_jenis) }}" class="text-green-600 hover:text-green-800 font-medium">Edit</a>
                                            @if($item->status_aktif)
                                                <span class="text-gray-300">|</span>
                                                <form action="{{ route('jenis-sampah.destroy', $item->id_jenis) }}" method="POST" onsubmit="return confirm('Nonaktifkan jenis sampah ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-700 font-medium">Nonaktifkan</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-8 text-center text-gray-400">Belum ada data jenis sampah.</td>
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