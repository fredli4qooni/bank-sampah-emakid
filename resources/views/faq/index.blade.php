<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-green-800 leading-tight">
            {{ __('Manajemen FAQ Publik') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl relative shadow-sm" role="alert">
                    <span class="block sm:inline font-medium">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
                <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-center gap-4 bg-gray-50/30">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Daftar Konten FAQ</h3>
                        <p class="text-sm text-gray-500">Kelola pertanyaan dan jawaban yang tampil di Halaman Utama Publik.</p>
                    </div>
                    <a href="{{ route('faq.create') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2.5 px-4 rounded-lg shadow-sm transition-colors text-sm flex items-center gap-2 shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                        Tambah FAQ Baru
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-600">
                        <thead class="text-xs text-green-800 uppercase bg-green-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-4 font-bold text-center w-16">Urutan</th>
                                <th class="px-6 py-4 font-bold">Pertanyaan & Jawaban</th>
                                <th class="px-6 py-4 font-bold text-center">Kategori</th>
                                <th class="px-6 py-4 font-bold text-center">Status</th>
                                <th class="px-6 py-4 font-bold text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($faqs as $f)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 font-black text-gray-800 text-center text-lg">{{ $f->urutan }}</td>
                                <td class="px-6 py-4">
                                    <div class="font-bold text-gray-800 mb-1">{{ $f->pertanyaan }}</div>
                                    <div class="text-sm text-gray-500 line-clamp-2">{{ Str::limit($f->jawaban, 100) }}</div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($f->kategori)
                                        <span class="bg-blue-50 text-blue-700 text-xs px-2.5 py-1 rounded font-medium border border-blue-200">{{ $f->kategori }}</span>
                                    @else
                                        <span class="text-gray-400 italic text-xs">Umum</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($f->status == 'aktif')
                                        <span class="bg-green-100 text-green-800 text-xs px-3 py-1 rounded-full font-bold uppercase border border-green-200">Aktif</span>
                                    @else
                                        <span class="bg-gray-100 text-gray-600 text-xs px-3 py-1 rounded-full font-bold uppercase border border-gray-200">Sembunyi</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 flex justify-center gap-3 items-center h-full pt-6">
                                    <a href="{{ route('faq.edit', $f->id_faq) }}" class="text-blue-600 hover:text-blue-800 font-medium hover:underline px-2 py-1">Edit</a>
                                    <form action="{{ route('faq.destroy', $f->id_faq) }}" method="POST" onsubmit="return confirm('Hapus konten FAQ ini secara permanen?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 font-medium hover:underline px-2 py-1">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-8 text-gray-400 italic">Belum ada konten FAQ yang dibuat.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>