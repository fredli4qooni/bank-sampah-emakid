<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-green-800 leading-tight">
            {{ Auth::user()->role === 'admin' ? 'Seluruh Riwayat Transaksi' : 'Riwayat Setoran Saya' }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 p-6">
                
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                    <h3 class="text-lg font-bold text-gray-800 shrink-0">{{ Auth::user()->role === 'admin' ? 'Data Keseluruhan Setoran Sampah' : 'Riwayat Transaksi Setoran Sampah' }}</h3>

                    @if(Auth::user()->role === 'admin' || Auth::user()->role === 'pengelola')
                    <form action="{{ route('transaksi.index') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-2 w-full md:w-auto justify-end">
                        <div class="flex items-center gap-2 w-full sm:w-auto">
                            <input type="date" name="start_date" value="{{ request('start_date') }}" class="rounded-lg border-gray-300 text-sm focus:ring-green-500 focus:border-green-500 w-full sm:w-auto" title="Tanggal Awal">
                            <span class="text-gray-500 font-medium">-</span>
                            <input type="date" name="end_date" value="{{ request('end_date') }}" class="rounded-lg border-gray-300 text-sm focus:ring-green-500 focus:border-green-500 w-full sm:w-auto" title="Tanggal Akhir">
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nasabah..." class="rounded-lg border-gray-300 text-sm focus:ring-green-500 focus:border-green-500 w-full sm:w-auto">
                        <div class="flex items-center gap-2 w-full sm:w-auto">
                            <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white font-bold py-2 px-4 rounded-lg shadow-sm text-sm w-full sm:w-auto">Filter</button>
                            @if(request('start_date') || request('end_date') || request('search'))
                                <a href="{{ route('transaksi.index') }}" class="bg-red-50 hover:bg-red-100 text-red-600 font-bold py-2 px-4 rounded-lg shadow-sm text-sm border border-red-200 w-full sm:w-auto text-center">Reset</a>
                            @endif
                        </div>
                    </form>
                    @endif
                </div>

                <div class="overflow-x-auto rounded-lg border border-gray-200">
                    @if(session('success'))
                    <div class="mb-4 p-4 rounded-lg bg-green-50 text-green-800 border border-green-200 text-sm font-medium">
                        {{ session('success') }}
                    </div>
                    @endif
                    <table class="w-full text-sm text-left text-gray-600">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-4 font-bold">Waktu</th>
                                <th class="px-6 py-4 font-bold">Nasabah</th>
                                <th class="px-6 py-4 font-bold">Unit</th>
                                <th class="px-6 py-4 font-bold">Jenis Sampah</th>
                                <th class="px-6 py-4 font-bold">Berat</th>
                                <th class="px-6 py-4 font-bold">Total Nilai (Rp)</th>
                                <th class="px-6 py-4 font-bold text-center">Pengoreksi</th>
                                <th class="px-6 py-4 font-bold text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($transaksi as $t)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 font-medium">{{ $t->created_at->format('d/m/Y H:i') }}</td>
                                <td class="px-6 py-4 font-bold text-gray-800">{{ $t->nasabah->nama }} <br><span class="text-xs text-gray-400 font-normal">{{ $t->nasabah->no_rekening }}</span></td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1 bg-green-50 text-green-700 px-2 py-1 rounded text-xs font-semibold border border-green-200">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                        {{ $t->nasabah->unit->nama_unit ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @foreach($t->detail as $dt)
                                        <div class="mb-1 text-gray-700 font-medium whitespace-nowrap">{{ $dt->jenisSampah->nama_sampah }}</div>
                                    @endforeach
                                </td>
                                <td class="px-6 py-4">
                                    @foreach($t->detail as $dt)
                                        <div class="mb-1 text-gray-700 whitespace-nowrap">{{ number_format($dt->berat, 2, ',', '.') }} kg</div>
                                    @endforeach
                                </td>
                                <td class="px-6 py-4 font-black text-green-700 whitespace-nowrap">Rp {{ number_format($t->total_nilai, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-center">
                                    @if($t->status_validasi === 'terkoreksi' && $t->logKoreksi->count() > 0)
                                        <span class="inline-flex items-center gap-1 bg-yellow-50 text-yellow-700 px-2 py-1 rounded text-xs font-bold border border-yellow-200">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            {{ $t->logKoreksi->last()->admin->name ?? 'Admin' }}
                                        </span>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex flex-col gap-2 min-w-[120px]">
                                        <div class="flex gap-2 w-full">
                                                <a href="{{ route('transaksi.edit', $t->id_transaksi) }}" class="flex-1 text-white bg-yellow-500 hover:bg-yellow-600 text-xs font-bold py-1.5 px-2 rounded text-center transition-colors shadow-sm">Edit</a>
                                                <form action="{{ route('transaksi.destroy', $t->id_transaksi) }}" method="POST" class="flex-1 m-0" onsubmit="return confirm('Yakin ingin menghapus transaksi ini? Jika transaksi sudah valid, saldo nasabah akan ditarik kembali.');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="w-full text-white bg-red-600 hover:bg-red-700 text-xs font-bold py-1.5 px-2 rounded text-center transition-colors shadow-sm">Hapus</button>
                                                </form>
                                        </div>
                                        <div class="flex gap-2 w-full">
                                            <a href="{{ route('transaksi.cetak', $t->id_transaksi) }}" target="_blank" class="flex-1 text-white bg-blue-600 hover:bg-blue-700 text-xs font-bold py-1.5 px-2 rounded text-center inline-flex items-center justify-center gap-1 transition-colors shadow-sm">
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
                                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $t->nasabah->no_hp) }}?text={{ $waText }}" target="_blank" class="flex-1 text-white bg-[#25D366] hover:bg-[#128C7E] text-xs font-bold py-1.5 px-2 rounded text-center inline-flex items-center justify-center gap-1 transition-colors shadow-sm" title="Kirim Pemberitahuan via WA">
                                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                                WA
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="8" class="text-center py-8 text-gray-400">{{ Auth::user()->role === 'admin' ? 'Belum ada riwayat transaksi di sistem.' : 'Belum ada riwayat setoran yang Anda input.' }}</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($transaksi->hasPages())
                <div class="mt-6">
                    {{ $transaksi->links() }}
                </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
