<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-green-800 leading-tight">
            {{ __('Validasi & Koreksi Setoran') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
            <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl relative shadow-sm">
                <span class="block sm:inline font-bold">{{ session('success') }}</span>
            </div>
            @endif
            @if(session('error'))
            <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl relative shadow-sm">
                <span class="block sm:inline font-bold">{{ session('error') }}</span>
            </div>
            @endif

            @if(Auth::user()->role === 'pengelola')
            <div class="mb-6 bg-blue-50 border border-blue-200 rounded-xl p-4 flex items-start gap-4 shadow-sm">
                <div class="bg-blue-100 p-2 rounded-full text-blue-600 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <h3 class="text-blue-800 font-bold text-lg">Mode Lihat Saja (Read-Only)</h3>
                    <p class="text-blue-600 text-sm mt-1">Anda sedang melihat halaman Validasi. Anda tidak dapat melakukan perubahan data, validasi, ataupun koreksi di halaman ini.</p>
                </div>
            </div>
            @endif

            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-6 flex flex-col sm:flex-row justify-between items-center gap-4">
                <div class="font-bold text-gray-700 flex items-center gap-2">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" /></svg>
                    Filter Data Rentang Tanggal
                </div>
                <form method="GET" action="{{ route('validasi.index') }}" class="flex items-center gap-3 w-full sm:w-auto">
                    <input type="date" name="start_date" value="{{ $startDate }}" class="rounded-lg border-gray-300 text-sm focus:ring-green-500 focus:border-green-500">
                    <span class="text-gray-500 font-medium">s/d</span>
                    <input type="date" name="end_date" value="{{ $endDate }}" class="rounded-lg border-gray-300 text-sm focus:ring-green-500 focus:border-green-500">
                    <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white font-bold py-2.5 px-5 rounded-lg shadow-sm text-sm">Terapkan</button>
                </form>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm border-l-4 border-l-blue-500">
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Total Berat (kg)</p>
                    <p class="text-2xl font-black text-gray-800">{{ number_format($summary['total_berat'], 2, ',', '.') }} <span class="text-sm font-medium text-gray-500">kg</span></p>
                </div>
                <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm border-l-4 border-l-green-500">
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Jml Transaksi</p>
                    <p class="text-2xl font-black text-gray-800">{{ number_format($summary['total_transaksi']) }} <span class="text-sm font-medium text-gray-500">Setoran</span></p>
                </div>
                <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm border-l-4 border-l-yellow-500">
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Status Pending</p>
                    <p class="text-2xl font-black text-yellow-600">{{ number_format($summary['pending']) }} <span class="text-sm font-medium text-gray-500">Antrean</span></p>
                </div>
                <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm border-l-4 border-l-purple-500">
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Estimasi Nilai</p>
                    <p class="text-2xl font-black text-gray-800"><span class="text-sm font-medium text-gray-500">Rp</span> {{ number_format($summary['total_nilai'], 0, ',', '.') }}</p>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
                <div class="p-5 bg-blue-50 border-b border-blue-100">
                    <h3 class="font-bold text-blue-800 text-sm">Validasi Setoran</h3>
                    <p class="text-xs text-blue-600 mt-1">Isi Total Berat Gudang untuk membandingkan selisih antara timbangan lapangan dan gudang. Jika selisih wajar, klik "Validasi Grup". Jika selisih tidak wajar, buka rincian setoran dan "Rombak Data".</p>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-600">
                        <thead class="text-xs text-blue-800 uppercase bg-blue-50 border-b border-blue-100">
                            <tr>
                                <th class="px-6 py-4 font-bold">Nama Penimbang</th>
                                <th class="px-6 py-4 font-bold">Tanggal</th>
                                <th class="px-6 py-4 font-bold">Total Berat Lapangan</th>
                                <th class="px-6 py-4 font-bold text-center w-56">Total Berat Gudang</th>
                                <th class="px-6 py-4 font-bold text-center">Selisih</th>
                                <th class="px-6 py-4 font-bold text-center">Status</th>
                            </tr>
                        </thead>

                        @php $hasPendingGroup = false; @endphp
                        @foreach ($tabPenimbang as $row)
                        @if($row['id_transaksi_pending'] != '')
                        @php $hasPendingGroup = true; @endphp
                        <tbody x-data="{ expanded: false, beratGudang: '', beratLapangan: {{ $row['total_berat_pending'] }} }" class="border-b border-gray-100">
                            <tr class="bg-white hover:bg-gray-50 transition-colors group cursor-pointer">
                                <td @click="expanded = !expanded" class="px-6 py-4 font-black text-gray-900 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-400 transform transition-transform" :class="{'rotate-90 text-blue-600': expanded}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                                    {{ $row['nama_penimbang'] }}
                                </td>
                                <td @click="expanded = !expanded" class="px-6 py-4 font-medium">{{ \Carbon\Carbon::parse($row['tanggal'])->format('d M Y') }}</td>
                                <td @click="expanded = !expanded" class="px-6 py-4 font-bold">
                                    {{ number_format($row['total_berat_pending'], 2, ',', '.') }} kg
                                </td>
                                <td class="px-6 py-4 text-center align-top">
                                    @if(Auth::user()->role === 'admin')
                                    <form id="formBulk{{ $loop->index }}" action="{{ route('validasi.bulk') }}" method="POST" class="flex flex-col gap-2">
                                        @csrf
                                        <input type="hidden" name="ids" value="{{ $row['id_transaksi_pending'] }}">
                                        <input type="hidden" name="total_berat_lapangan" value="{{ $row['total_berat_pending'] }}">
                                        <div>
                                            <input type="number" name="berat_gudang" step="0.01" min="0" max="{{ $row['total_berat_pending'] }}" placeholder="Berat Gudang" x-model="beratGudang" onkeydown="if(event.key === '.') { this.nextElementSibling.classList.remove('hidden'); setTimeout(() => this.nextElementSibling.classList.add('hidden'), 3000); event.preventDefault(); }" title="Timbangan Gudang u/ {{ number_format($row['total_berat_pending'], 2) }}kg Lapangan" class="text-xs border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 rounded shadow-sm px-2 py-1.5 w-full text-center font-bold text-blue-800" required>
                                            <p class="text-red-500 text-[10px] hidden mt-1 font-bold text-center">Gunakan koma (,) bukan titik</p>
                                        </div>
                                        <input type="text" name="keterangan" placeholder="Keterangan opsional" x-show="beratGudang !== '' && Math.abs(beratLapangan - parseFloat(beratGudang || 0)) > 0" x-cloak class="text-[10px] border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 rounded shadow-sm px-2 py-1 w-full text-center text-gray-700">
                                    </form>
                                    @else
                                    <span class="text-xs text-gray-400 italic">Hanya Admin</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center font-bold">
                                    <span x-show="beratGudang === ''" class="text-gray-400 italic text-xs">-</span>
                                    <span x-show="beratGudang !== ''" x-cloak class="text-blue-600" x-text="(Math.abs(beratLapangan - parseFloat(beratGudang || 0))).toFixed(2) + ' kg'"></span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if(Auth::user()->role === 'admin')
                                    <button form="formBulk{{ $loop->index }}" type="submit" x-show="beratGudang !== '' && parseFloat(beratGudang) <= beratLapangan" class="text-[11px] bg-green-600 hover:bg-green-700 text-white font-bold py-1.5 px-3 rounded shadow-sm w-full" onclick="return confirm('Data selisih sesuai? Saldo nasabah akan ditambahkan. Lanjutkan?')">Validasi Grup</button>
                                    <span x-show="beratGudang !== '' && parseFloat(beratGudang) > beratLapangan" x-cloak class="text-[10px] text-red-600 font-bold">Error!<br>Berat gudang > Lapangan</span>
                                    <span x-show="beratGudang !== '' && parseFloat(beratGudang) <= beratLapangan && Math.abs(beratLapangan - parseFloat(beratGudang || 0)) > 10" x-cloak class="text-[10px] text-red-600 font-bold mt-1 block">Selisih Ekstrim!<br>Buka rincian & rombak data</span>
                                    @else
                                    <span class="bg-yellow-100 text-yellow-700 text-[10px] px-2.5 py-1 rounded-full font-bold animate-pulse">Pending</span>
                                    @endif
                                </td>
                            </tr>
                            <tr x-show="expanded" x-cloak class="bg-gray-50">
                                <td colspan="6" class="p-0 border-t border-gray-100">
                                    <div class="px-10 py-4 bg-gray-50 border-l-4 border-blue-500 shadow-inner">
                                        <table class="w-full text-xs text-left text-gray-500">
                                            <thead class="uppercase text-gray-400 border-b border-gray-200">
                                                <tr>
                                                    <th class="py-2">Waktu</th>
                                                    <th class="py-2">Nasabah</th>
                                                    <th class="py-2 text-right">Nilai Lapangan</th>
                                                    <th class="py-2 text-center">Status</th>
                                                    @if(Auth::user()->role === 'admin')
                                                    <th class="py-2 text-center">Aksi</th>
                                                    @endif
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($row['transaksi'] as $trx)
                                                @if($trx->status_validasi == 'pending')
                                                <tr class="border-b border-gray-100 last:border-0 hover:bg-gray-100 transition-colors">
                                                    <td class="py-2 font-medium">{{ $trx->created_at->format('H:i') }}</td>
                                                    <td class="py-2 font-bold text-gray-800">{{ $trx->nasabah->nama }}</td>
                                                    <td class="py-2 font-bold text-gray-700 text-right">Rp {{ number_format($trx->total_nilai, 0, ',', '.') }}</td>
                                                    <td class="py-2 text-center">
                                                        <span class="text-yellow-600 font-bold">Pending</span>
                                                    </td>
                                                    @if(Auth::user()->role === 'admin')
                                                    <td class="py-2 text-center">
                                                        <a href="{{ route('validasi.koreksi', $trx->id_transaksi) }}" class="text-[10px] bg-yellow-100 hover:bg-yellow-500 text-yellow-700 hover:text-white font-bold py-1 px-2 rounded transition-colors shadow-sm inline-block">Rombak Data</a>
                                                    </td>
                                                    @endif
                                                </tr>
                                                @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <div class="mt-2 text-xs text-gray-400 italic">*Setoran di atas adalah rincian dari grup pending yang ada. Untuk cetak struk atau hapus, silakan gunakan "Menu Riwayat Transaksi".</div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                        @endif
                        @endforeach

                        @if(!$hasPendingGroup)
                        <tbody><tr><td colspan="6" class="text-center py-8 text-gray-400 italic">Antrean kosong. Semua setoran harian sudah divalidasi.</td></tr></tbody>
                        @endif
                    </table>
                </div>
            </div>

            <!-- Riwayat Validasi Section -->
            <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
                <div class="p-5 bg-gray-50 border-b border-gray-200">
                    <h3 class="font-bold text-gray-800 text-sm">Riwayat Validasi</h3>
                    <p class="text-xs text-gray-500 mt-1">Daftar transaksi yang sudah divalidasi atau dikoreksi pada rentang tanggal filter di atas.</p>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-600">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-4 font-bold">Waktu</th>
                                <th class="px-6 py-4 font-bold">Penimbang</th>
                                <th class="px-6 py-4 font-bold">Nasabah</th>
                                <th class="px-6 py-4 font-bold">Total Berat</th>
                                <th class="px-6 py-4 font-bold">Total Nilai</th>
                                <th class="px-6 py-4 font-bold text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @php 
                                $riwayatValid = $riwayatTransactions->filter(function($t) { 
                                    return $t->status_validasi !== 'pending'; 
                                });
                            @endphp
                            @forelse($riwayatValid as $trx)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 font-medium">{{ $trx->created_at->format('d M Y H:i') }}</td>
                                <td class="px-6 py-4 text-gray-800 font-bold">{{ $trx->penimbang->name }}</td>
                                <td class="px-6 py-4 font-bold text-gray-800">{{ $trx->nasabah->nama }} <br><span class="text-xs text-gray-400 font-normal">{{ $trx->nasabah->no_rekening }}</span></td>
                                <td class="px-6 py-4 font-bold">{{ number_format($trx->detail->sum('berat'), 2, ',', '.') }} kg</td>
                                <td class="px-6 py-4 font-black text-green-700">Rp {{ number_format($trx->total_nilai, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-center">
                                    @if($trx->status_validasi == 'valid')
                                        <span class="bg-green-100 text-green-700 text-xs px-2.5 py-1 rounded-full font-bold">Valid</span>
                                    @elseif($trx->status_validasi == 'terkoreksi')
                                        <span class="bg-blue-100 text-blue-700 text-xs px-2.5 py-1 rounded-full font-bold">Terkoreksi</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="6" class="text-center py-8 text-gray-400 italic">Belum ada riwayat validasi pada rentang tanggal ini.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>