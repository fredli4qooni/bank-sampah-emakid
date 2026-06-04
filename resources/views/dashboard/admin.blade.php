<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if($pendingValidasi > 0)
                <div class="mb-6 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded shadow-sm" role="alert">
                    <p class="font-bold">Perhatian</p>
                    <p>Ada <b>{{ $pendingValidasi }}</b> transaksi yang menunggu untuk divalidasi. <a href="{{ route('validasi.index') }}" class="underline font-bold">Lihat sekarang</a></p>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow-sm p-6 border-b-4 border-blue-500">
                    <h3 class="text-gray-500 text-sm font-bold uppercase">Total Nasabah</h3>
                    <p class="text-3xl font-black text-gray-800 mt-2">{{ number_format($totalNasabah, 0, ',', '.') }}</p>
                </div>
                <div class="bg-white rounded-lg shadow-sm p-6 border-b-4 border-green-500">
                    <h3 class="text-gray-500 text-sm font-bold uppercase">Transaksi Hari Ini</h3>
                    <p class="text-3xl font-black text-gray-800 mt-2">{{ number_format($transaksiHariIni, 0, ',', '.') }}</p>
                </div>
                <div class="bg-white rounded-lg shadow-sm p-6 border-b-4 border-yellow-500">
                    <h3 class="text-gray-500 text-sm font-bold uppercase">Volume Masuk Hari Ini</h3>
                    <p class="text-3xl font-black text-gray-800 mt-2">{{ number_format($volumeHariIni, 2, ',', '.') }} <span class="text-sm">Kg/Ltr</span></p>
                </div>
                <div class="bg-white rounded-lg shadow-sm p-6 border-b-4 border-indigo-500">
                    <h3 class="text-gray-500 text-sm font-bold uppercase">Total Saldo Nasabah</h3>
                    <p class="text-3xl font-black text-gray-800 mt-2">Rp {{ number_format($totalSaldo, 0, ',', '.') }}</p>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4 border-b pb-2">10 Transaksi Terakhir</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3">Waktu</th>
                                    <th class="px-6 py-3">Nasabah</th>
                                    <th class="px-6 py-3">Nilai (Rp)</th>
                                    <th class="px-6 py-3">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transaksiTerbaru as $trx)
                                <tr class="border-b">
                                    <td class="px-6 py-4">{{ $trx->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="px-6 py-4 font-bold text-gray-800">{{ $trx->nasabah->nama }}</td>
                                    <td class="px-6 py-4">Rp {{ number_format($trx->total_nilai, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4">
                                        @if($trx->status_validasi == 'pending')
                                            <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded font-bold uppercase">Pending</span>
                                        @elseif($trx->status_validasi == 'valid')
                                            <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded font-bold uppercase">Valid</span>
                                        @else
                                            <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded font-bold uppercase">Terkoreksi</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="text-center py-4">Belum ada transaksi.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>