<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-green-800 leading-tight">
            {{ __('Manajemen Unit / Kelompok') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
            <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl relative shadow-sm" role="alert">
                <span class="block sm:inline font-medium">{{ session('success') }}</span>
            </div>
            @endif

            @if(session('error'))
            <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl relative shadow-sm" role="alert">
                <span class="block sm:inline font-medium">{{ session('error') }}</span>
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">

                <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-center gap-4 bg-gray-50/30">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Daftar Unit Terdaftar</h3>
                        <p class="text-sm text-gray-500">Kelola kelompok atau unit yang ada di bawah kecamatan.</p>
                    </div>
                    <a href="{{ route('units.create') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2.5 px-4 rounded-lg shadow-sm transition-colors text-sm flex items-center gap-2 shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Tambah Unit Baru
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-600">
                        <thead class="text-xs text-green-800 uppercase bg-green-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-4 font-bold">Nama Unit</th>
                                <th class="px-6 py-4 font-bold">Kecamatan</th>
                                <th class="px-6 py-4 font-bold">Ketua & Kontak</th>
                                <th class="px-6 py-4 font-bold">Terdaftar</th>
                                <th class="px-6 py-4 font-bold text-center">Status</th>
                                <th class="px-6 py-4 font-bold text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($units as $u)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 font-bold text-gray-800">{{ $u->nama_unit }}</td>
                                <td class="px-6 py-4">{{ $u->kecamatan }}</td>
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-800">{{ $u->nama_ketua ?: '-' }}</div>
                                    <div class="text-xs text-gray-500">{{ $u->no_hp_ketua ?: '-' }}</div>
                                </td>
                                <td class="px-6 py-4">{{ \Carbon\Carbon::parse($u->tanggal_daftar)->format('d M Y') }}</td>
                                <td class="px-6 py-4 text-center">
                                    @if($u->status == 'aktif')
                                    <span class="bg-green-100 text-green-800 text-xs px-3 py-1.5 rounded-full font-bold uppercase border border-green-200">Aktif</span>
                                    @else
                                    <span class="bg-gray-100 text-gray-600 text-xs px-3 py-1.5 rounded-full font-bold uppercase border border-gray-200">Nonaktif</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 flex justify-center gap-3">
                                    <a href="{{ route('units.edit', $u->id_unit) }}" class="text-blue-600 hover:text-blue-800 font-medium hover:underline px-2 py-1">Edit</a>
                                    <form action="{{ route('units.destroy', $u->id_unit) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus Unit ini? Pastikan tidak ada nasabah yang tertaut.');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 font-medium hover:underline px-2 py-1">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-8 text-gray-400 italic">Belum ada data Unit/Kelompok yang terdaftar.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>