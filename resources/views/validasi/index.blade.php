<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-green-800 leading-tight">
            {{ __('Validasi Transaksi') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
                <div class="p-6 text-gray-900">
                    
                    <div class="flex items-center gap-2 mb-6">
                        <div class="w-3 h-8 bg-yellow-400 rounded-full"></div>
                        <h3 class="text-lg font-black text-gray-800">Antrean Menunggu Validasi</h3>
                    </div>

                    <div class="overflow-x-auto rounded-lg border border-gray-200">
                        <table class="w-full text-sm text-left text-gray-600">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th scope="col" class="px-6 py-4 font-bold">Tanggal / Waktu</th>
                                    <th scope="col" class="px-6 py-4 font-bold">Nasabah</th>
                                    <th scope="col" class="px-6 py-4 font-bold">Penimbang</th>
                                    <th scope="col" class="px-6 py-4 font-bold text-right">Total Estimasi (Rp)</th>
                                    <th scope="col" class="px-6 py-4 font-bold text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse ($transaksiPending as $trx)
                                    <tr class="bg-white hover:bg-yellow-50 transition-colors">
                                        <td class="px-6 py-4 font-medium">{{ $trx->created_at->format('d/m/Y H:i') }}</td>
                                        <td class="px-6 py-4 font-black text-gray-900">{{ $trx->nasabah->nama }}</td>
                                        <td class="px-6 py-4">{{ $trx->penimbang->name }}</td>
                                        <td class="px-6 py-4 font-bold text-gray-900 text-right">Rp {{ number_format($trx->total_nilai, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4 text-center">
                                            <a href="{{ route('validasi.show', $trx->id_transaksi) }}" class="inline-flex items-center justify-center bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded-lg shadow-sm transition-transform transform hover:-translate-y-0.5 text-xs gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                                Cek & Validasi
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center">
                                            <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                            <p class="text-gray-500 font-medium">Semua transaksi sudah tervalidasi.</p>
                                        </td>
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