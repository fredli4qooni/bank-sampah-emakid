<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-green-800 leading-tight">
            {{ __('Laporan Operasional Transaksi') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 mb-6 p-6">
                <form action="{{ route('laporan.index') }}" method="GET" class="flex flex-col md:flex-row items-end gap-4">
                    <div class="w-full md:w-1/4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Dari Tanggal</label>
                        <input type="date" name="start_date" value="{{ $startDate }}" class="w-full border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 rounded-lg shadow-sm" required>
                    </div>
                    <div class="w-full md:w-1/4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Sampai Tanggal</label>
                        <input type="date" name="end_date" value="{{ $endDate }}" class="w-full border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 rounded-lg shadow-sm" required>
                    </div>
                    <div class="w-full md:w-1/4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Pilih Unit (Opsional)</label>
                        <select name="id_unit" class="w-full border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 rounded-lg shadow-sm">
                            <option value="">-- Semua Unit --</option>
                            @foreach($units as $unit)
                                <option value="{{ $unit->id_unit }}" {{ $idUnit == $unit->id_unit ? 'selected' : '' }}>
                                    {{ $unit->nama_unit }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-full md:w-1/4 flex gap-2">
                        <button type="submit" class="flex-1 bg-gray-800 hover:bg-gray-900 text-white font-bold py-2.5 px-5 rounded-lg shadow-md transition-colors flex items-center justify-center gap-2" title="Terapkan Filter">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" /></svg>
                        </button>
                        <a href="{{ route('laporan.pdf', ['start_date' => $startDate, 'end_date' => $endDate, 'id_unit' => $idUnit]) }}" target="_blank" class="flex-1 bg-red-600 hover:bg-red-700 text-white font-bold py-2.5 px-4 rounded-lg shadow-md transition-colors flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                            Ekspor PDF
                        </a>
                    </div>
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2 flex items-center justify-between">
                    <span>Pratinjau Data ({{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }})</span>
                    @if($idUnit)
                        <span class="text-xs bg-green-100 text-green-800 px-3 py-1 rounded-full border border-green-200">
                            Filter: {{ $units->where('id_unit', $idUnit)->first()->nama_unit ?? 'Unknown' }}
                        </span>
                    @endif
                </h3>
                
                <div class="overflow-x-auto rounded-lg border border-gray-200">
                    <table class="w-full text-sm text-left text-gray-600">
                        <thead class="text-xs text-green-800 uppercase bg-green-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-4 font-bold">Waktu & TRX</th>
                                <th class="px-6 py-4 font-bold">Nasabah & Unit</th>
                                <th class="px-6 py-4 font-bold">Penimbang</th>
                                <th class="px-6 py-4 font-bold text-center">Status</th>
                                <th class="px-6 py-4 font-bold text-right">Nilai Nominal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @php $totalSemua = 0; @endphp
                            @forelse($transaksi as $trx)
                            @php $totalSemua += $trx->total_nilai; @endphp
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $trx->created_at->format('d/m/Y H:i') }}<br>
                                    <span class="text-xs text-gray-400 font-mono">#{{ $trx->id_transaksi }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-bold text-gray-800">{{ $trx->nasabah->nama }}</div>
                                    <div class="text-xs text-gray-500 mt-0.5">{{ $trx->nasabah->unit->nama_unit ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4">{{ $trx->penimbang->name }}</td>
                                <td class="px-6 py-4 text-center">
                                    <span class="text-xs px-2.5 py-1 rounded-full font-bold uppercase border {{ $trx->status_validasi == 'valid' ? 'bg-green-100 text-green-800 border-green-200' : 'bg-blue-100 text-blue-800 border-blue-200' }}">
                                        {{ $trx->status_validasi }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 font-semibold text-gray-900 text-right">
                                    Rp {{ number_format($trx->total_nilai, 0, ',', '.') }}<br>
                                    <span class="text-xs text-gray-400 font-normal">Berat: {{ $trx->detail->sum('berat') }} kg</span>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center py-10 text-gray-400">Tidak ada transaksi pada kriteria filter tersebut.</td></tr>
                            @endforelse
                        </tbody>
                        <tfoot class="bg-gray-50 border-t border-gray-200 font-black text-gray-900 text-base">
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-right uppercase tracking-wider">Total Keseluruhan:</td>
                                <td class="px-6 py-4 text-right text-green-700">Rp {{ number_format($totalSemua, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>