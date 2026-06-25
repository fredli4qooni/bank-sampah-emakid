<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-green-800 leading-tight">
            {{ __('Data Pendaftaran Calon Unit') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
                <div class="p-6 border-b border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4">
                    <h3 class="text-lg font-bold text-gray-800">Daftar Pendaftar Unit Baru</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-600">
                        <thead class="text-xs text-green-800 uppercase bg-green-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-4 font-bold">Tanggal Daftar</th>
                                <th class="px-6 py-4 font-bold">Nama Lengkap</th>
                                <th class="px-6 py-4 font-bold">Kontak WA</th>
                                <th class="px-6 py-4 font-bold">Alamat</th>
                                <th class="px-6 py-4 font-bold">Jadwal Edukasi</th>
                                <th class="px-6 py-4 font-bold text-center">Status</th>
                                <th class="px-6 py-4 font-bold text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($calonUnits as $calon)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">{{ $calon->created_at->format('d/m/Y H:i') }}</td>
                                <td class="px-6 py-4 font-bold text-gray-800">{{ $calon->nama_lengkap }}</td>
                                <td class="px-6 py-4">
                                    <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $calon->no_wa)) }}" target="_blank" class="text-green-600 hover:text-green-800 font-medium inline-flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                        {{ $calon->no_wa }}
                                    </a>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="max-w-[200px] truncate" title="{{ $calon->alamat_lengkap }}">
                                        {{ $calon->alamat_lengkap }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-800">
                                    {{ \Carbon\Carbon::parse($calon->jadwal_edukasi)->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="text-xs px-2.5 py-1 rounded-full font-bold uppercase border {{ $calon->status == 'dihubungi' ? 'bg-green-100 text-green-800 border-green-200' : 'bg-yellow-100 text-yellow-800 border-yellow-200' }}">
                                        {{ $calon->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        @if($calon->status == 'pending')
                                        <form action="{{ route('calon-unit.update-status', $calon->id_calon) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="dihubungi">
                                            <button type="submit" class="p-1.5 text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 border border-blue-200 transition-colors" title="Tandai Sudah Dihubungi">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                            </button>
                                        </form>
                                        @else
                                        <form action="{{ route('calon-unit.update-status', $calon->id_calon) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="pending">
                                            <button type="submit" class="p-1.5 text-yellow-600 bg-yellow-50 rounded-lg hover:bg-yellow-100 border border-yellow-200 transition-colors" title="Tandai Belum Dihubungi">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                            </button>
                                        </form>
                                        @endif
                                        <form action="{{ route('calon-unit.destroy', $calon->id_calon) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 text-red-600 bg-red-50 rounded-lg hover:bg-red-100 border border-red-200 transition-colors" title="Hapus">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="7" class="text-center py-10 text-gray-400">Belum ada pendaftaran calon unit.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($calonUnits->hasPages())
                <div class="p-4 border-t border-gray-100">
                    {{ $calonUnits->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
