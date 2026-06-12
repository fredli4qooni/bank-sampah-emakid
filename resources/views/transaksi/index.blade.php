<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-green-800 leading-tight">
            {{ __('Riwayat Setoran Saya') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 p-6">
                
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-gray-800">Daftar Transaksi yang Anda Input</h3>
                    <a href="{{ route('transaksi.create') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2.5 px-5 rounded-lg shadow-md transition-colors text-sm flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                        Input Baru
                    </a>
                </div>

                <div class="overflow-x-auto rounded-lg border border-gray-200">
                    <table class="w-full text-sm text-left text-gray-600">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-4 font-bold">Waktu</th>
                                <th class="px-6 py-4 font-bold">Nasabah</th>
                                <th class="px-6 py-4 font-bold">Total Nilai (Rp)</th>
                                <th class="px-6 py-4 font-bold">Status</th>
                                <th class="px-6 py-4 font-bold text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($transaksi as $t)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 font-medium">{{ $t->created_at->format('d/m/Y H:i') }}</td>
                                <td class="px-6 py-4 font-bold text-gray-800">{{ $t->nasabah->nama }} <br><span class="text-xs text-gray-400 font-normal">{{ $t->nasabah->no_rekening }}</span></td>
                                <td class="px-6 py-4 font-black text-green-700">+ {{ number_format($t->total_nilai, 0, ',', '.') }}</td>
                                <td class="px-6 py-4">
                                    @if($t->status_validasi == 'valid')
                                        <span class="bg-green-100 text-green-800 text-xs px-2.5 py-1 rounded-full font-bold border border-green-200">Valid</span>
                                    @elseif($t->status_validasi == 'terkoreksi')
                                        <span class="bg-yellow-100 text-yellow-800 text-xs px-2.5 py-1 rounded-full font-bold border border-yellow-200">Terkoreksi</span>
                                    @else
                                        <span class="bg-gray-100 text-gray-800 text-xs px-2.5 py-1 rounded-full font-bold border border-gray-200">Pending</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 flex flex-col sm:flex-row gap-2 justify-center items-center">
                                    <a href="{{ route('transaksi.cetak', $t->id_transaksi) }}" target="_blank" class="text-white bg-blue-600 hover:bg-blue-700 text-xs font-bold py-1.5 px-3 rounded text-center inline-flex items-center justify-center gap-1 transition-colors shadow-sm">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
                                        Cetak
                                    </a>
                                    @if($t->nasabah->no_hp)
                                        @php
                                            $waText = urlencode("Halo " . $t->nasabah->nama . ",\nSetoran sampah Anda senilai Rp " . number_format($t->total_nilai, 0, ',', '.') . " telah berhasil diinput oleh tim Bank Sampah dan sedang menunggu validasi.\nTerima kasih!");
                                            if($t->status_validasi != 'pending') {
                                                $waText = urlencode("Halo " . $t->nasabah->nama . ",\nSetoran sampah Anda senilai Rp " . number_format($t->total_nilai, 0, ',', '.') . " telah divalidasi dan masuk ke saldo Anda.\nTerima kasih!");
                                            }
                                        @endphp
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $t->nasabah->no_hp) }}?text={{ $waText }}" target="_blank" class="text-white bg-[#25D366] hover:bg-[#128C7E] text-xs font-bold py-1.5 px-3 rounded text-center inline-flex items-center justify-center gap-1 transition-colors shadow-sm" title="Kirim Pemberitahuan via WA">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                            WA
                                        </a>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center py-8 text-gray-400">Belum ada riwayat setoran yang Anda input.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
