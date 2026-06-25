<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-green-800 leading-tight">
            {{ __('Laporan Validasi') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-6 flex flex-col sm:flex-row justify-between items-center gap-4">
                <div class="font-bold text-gray-700 flex items-center gap-2">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" /></svg>
                    Filter Rentang Tanggal
                </div>
                <form method="GET" action="{{ route('laporan.validasi') }}" class="flex items-center gap-3 w-full sm:w-auto">
                    <input type="date" name="start_date" value="{{ $startDate }}" class="rounded-lg border-gray-300 text-sm focus:ring-green-500 focus:border-green-500">
                    <span class="text-gray-500 font-medium">s/d</span>
                    <input type="date" name="end_date" value="{{ $endDate }}" class="rounded-lg border-gray-300 text-sm focus:ring-green-500 focus:border-green-500">
                    <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white font-bold py-2.5 px-5 rounded-lg shadow-sm text-sm">Terapkan</button>
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
                <div class="flex justify-between items-center p-6 border-b border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800">Riwayat Grup Validasi</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-600">
                        <thead class="text-xs text-green-800 uppercase bg-green-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-4 font-bold">Waktu Validasi</th>
                                <th class="px-6 py-4 font-bold">Nama Penimbang</th>
                                <th class="px-6 py-4 font-bold text-center">Total Berat<br>Lapangan</th>
                                <th class="px-6 py-4 font-bold text-center">Total Berat<br>Gudang</th>
                                <th class="px-6 py-4 font-bold text-center">Selisih</th>
                                <th class="px-6 py-4 font-bold text-center">Status</th>
                                <th class="px-6 py-4 font-bold">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($riwayatValidasi as $row)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 font-medium">{{ $row['tanggal'] }}</td>
                                <td class="px-6 py-4 font-bold text-gray-800">{{ $row['nama_penimbang'] }}</td>
                                <td class="px-6 py-4 text-center font-bold text-gray-700">{{ number_format($row['total_berat_lapangan'], 2, ',', '.') }} kg</td>
                                <td class="px-6 py-4 text-center font-bold text-blue-700">{{ number_format($row['total_berat_gudang'], 2, ',', '.') }} kg</td>
                                <td class="px-6 py-4 text-center font-bold {{ $row['selisih'] > 0 ? 'text-red-600' : 'text-gray-400' }}">
                                    {{ $row['selisih'] > 0 ? number_format($row['selisih'], 2, ',', '.') . ' kg' : '-' }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="text-xs px-2.5 py-1 rounded-full font-bold uppercase border {{ $row['status'] == 'valid' ? 'bg-green-100 text-green-800 border-green-200' : 'bg-yellow-100 text-yellow-800 border-yellow-200' }}">
                                        {{ $row['status'] }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-xs text-gray-600 italic">
                                    {{ $row['keterangan'] }}
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="7" class="text-center py-10 text-gray-400">Tidak ada data riwayat validasi pada rentang tanggal tersebut.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
