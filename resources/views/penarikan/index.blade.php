<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-green-800 leading-tight">
            {{ __('Riwayat Penarikan Saldo') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl relative shadow-sm">
                    <span class="block sm:inline font-bold">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 p-6">
                
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-gray-800">Daftar Pencairan Dana</h3>
                    <a href="{{ route('penarikan.create') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2.5 px-5 rounded-lg shadow-md transition-transform transform hover:-translate-y-0.5 text-sm flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                        Input Penarikan Baru
                    </a>
                </div>

                <div class="overflow-x-auto rounded-lg border border-gray-200">
                    <table class="w-full text-sm text-left text-gray-600">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-4 font-bold">Waktu</th>
                                <th class="px-6 py-4 font-bold">Nasabah</th>
                                <th class="px-6 py-4 font-bold text-right">Nominal (Rp)</th>
                                <th class="px-6 py-4 font-bold text-center">Metode</th>
                                <th class="px-6 py-4 font-bold">Keterangan</th>
                                <th class="px-6 py-4 font-bold">Admin</th>
                                <th class="px-6 py-4 font-bold text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($penarikan as $p)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 font-medium">{{ $p->created_at->format('d/m/Y H:i') }}</td>
                                <td class="px-6 py-4 font-bold text-gray-800">{{ $p->nasabah->nama }} <br><span class="text-xs text-gray-400 font-normal">{{ $p->nasabah->no_rekening }}</span></td>
                                <td class="px-6 py-4 font-black text-red-600 text-right">
                                    - {{ number_format($p->nominal, 0, ',', '.') }}
                                    @if($p->biaya_admin > 0)
                                        <div class="text-[10px] text-gray-500 font-normal mt-1 leading-tight">Biaya Admin:<br>Rp {{ number_format($p->biaya_admin, 0, ',', '.') }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="bg-gray-100 text-gray-800 text-xs px-2.5 py-1 rounded-full font-bold border border-gray-200">{{ $p->metode }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-xs italic text-gray-500">{{ $p->keterangan ?? '-' }}</div>
                                    @if($p->metode == 'Token Listrik' && $p->nomor_token)
                                        <div class="mt-2 not-italic">
                                            <span class="font-bold text-xs text-gray-700">Token:</span><br>
                                            <span class="font-mono text-xs text-blue-700 font-black tracking-widest bg-blue-50 px-1.5 py-0.5 rounded border border-blue-100">{{ $p->nomor_token }}</span>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $p->admin->name }}</td>
                                <td class="px-6 py-4 flex flex-col gap-2 justify-center">
                                    @if(in_array($p->metode, ['Transfer Bank', 'E-Wallet (Dana/OVO/GoPay)']) && $p->bukti_transfer)
                                        <a href="{{ Storage::url($p->bukti_transfer) }}" target="_blank" class="text-white bg-blue-600 hover:bg-blue-700 text-xs font-bold py-1.5 px-3 rounded text-center inline-flex items-center justify-center gap-1 transition-colors shadow-sm">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                            Lihat Bukti
                                        </a>
                                    @endif
                                    @if($p->nasabah->no_hp)
                                        @php
                                            $waText = urlencode("Halo " . $p->nasabah->nama . ",\nPencairan saldo Bank Sampah Anda senilai Rp " . number_format($p->nominal, 0, ',', '.') . " via " . $p->metode . " telah berhasil diproses.\nTerima kasih!");
                                        @endphp
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $p->nasabah->no_hp) }}?text={{ $waText }}" target="_blank" class="text-white bg-[#25D366] hover:bg-[#128C7E] text-xs font-bold py-1.5 px-3 rounded text-center inline-flex items-center justify-center gap-1 transition-colors shadow-sm" title="Kirim Pemberitahuan via WA">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                            Kirim WA
                                        </a>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="6" class="text-center py-8 text-gray-400">Belum ada riwayat penarikan saldo.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>