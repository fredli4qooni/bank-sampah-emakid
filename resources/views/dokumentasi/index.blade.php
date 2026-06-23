<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-green-800 leading-tight">
            {{ __('Kelola Dokumentasi') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 p-6">
                
                <div class="mb-6 flex justify-between items-center">
                    <a href="{{ route('dokumentasi.create') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2.5 px-5 rounded-lg shadow transition-colors flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Tambah Dokumentasi
                    </a>
                </div>

                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto rounded-lg border border-gray-200">
                    <table class="w-full text-sm text-left text-gray-600">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-4 font-bold w-32">Foto</th>
                                <th class="px-6 py-4 font-bold">Judul</th>
                                <th class="px-6 py-4 font-bold">Deskripsi</th>
                                <th class="px-6 py-4 font-bold">Tanggal</th>
                                <th class="px-6 py-4 font-bold text-center w-32">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($dokumentasi as $doc)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="w-20 h-20 rounded-lg overflow-hidden border border-gray-200 shadow-sm">
                                        <img src="{{ asset('storage/' . $doc->foto) }}" alt="{{ $doc->judul }}" class="w-full h-full object-cover">
                                    </div>
                                </td>
                                <td class="px-6 py-4 font-bold text-gray-800 align-top">
                                    {{ $doc->judul }}
                                </td>
                                <td class="px-6 py-4 align-top">
                                    <p class="text-gray-600 line-clamp-3">{{ $doc->deskripsi ?? '-' }}</p>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-500 align-top">
                                    {{ $doc->created_at->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 align-top">
                                    <div class="flex flex-col gap-2">
                                        <a href="{{ route('dokumentasi.edit', $doc->id) }}" class="w-full text-white bg-yellow-500 hover:bg-yellow-600 text-xs font-bold py-1.5 px-2 rounded text-center transition-colors shadow-sm">Edit</a>
                                        <form action="{{ route('dokumentasi.destroy', $doc->id) }}" method="POST" class="m-0" onsubmit="return confirm('Yakin ingin menghapus dokumentasi ini? Foto akan dihapus secara permanen.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-full text-white bg-red-600 hover:bg-red-700 text-xs font-bold py-1.5 px-2 rounded text-center transition-colors shadow-sm">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-12 text-gray-400">
                                    <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    Belum ada foto dokumentasi.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($dokumentasi->hasPages())
                <div class="mt-6">
                    {{ $dokumentasi->links() }}
                </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
