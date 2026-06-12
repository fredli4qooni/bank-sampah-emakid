<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-green-800 leading-tight">
            {{ __('Validasi & Koreksi Setoran') }}
        </h2>
    </x-slot>

    <div class="py-8" x-data="{ activeTab: 'pending' }">
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
                    <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white font-bold py-2 px-4 rounded-lg shadow-sm text-sm">Terapkan</button>
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

            <div class="flex gap-2 border-b border-gray-200 mb-6 overflow-x-auto">
                <button @click="activeTab = 'pending'" :class="{'bg-yellow-50 text-yellow-700 border-b-2 border-yellow-500': activeTab === 'pending', 'text-gray-500 hover:text-gray-700 hover:bg-gray-50': activeTab !== 'pending'}" class="px-6 py-3 font-bold text-sm transition-colors rounded-t-lg focus:outline-none flex items-center gap-2 whitespace-nowrap">
                    <span class="bg-yellow-200 text-yellow-800 py-0.5 px-2 rounded-full text-xs">{{ count($pendingTransactions) }}</span> Antrean Pending
                </button>
                <button @click="activeTab = 'completed'" :class="{'bg-green-50 text-green-700 border-b-2 border-green-600': activeTab === 'completed', 'text-gray-500 hover:text-gray-700 hover:bg-gray-50': activeTab !== 'completed'}" class="px-6 py-3 font-bold text-sm transition-colors rounded-t-lg focus:outline-none flex items-center gap-2 whitespace-nowrap">
                    <span class="bg-green-200 text-green-800 py-0.5 px-2 rounded-full text-xs">{{ count($completedTransactions) }}</span> Riwayat Selesai
                </button>
                <button @click="activeTab = 'bulk'" :class="{'bg-blue-50 text-blue-700 border-b-2 border-blue-600': activeTab === 'bulk', 'text-gray-500 hover:text-gray-700 hover:bg-gray-50': activeTab !== 'bulk'}" class="px-6 py-3 font-bold text-sm transition-colors rounded-t-lg focus:outline-none flex items-center gap-2 whitespace-nowrap">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                    Mode Validasi Borongan
                </button>
            </div>

            <!-- TAB 1: PENDING -->
            <div x-show="activeTab === 'pending'" x-cloak class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-600">
                        <thead class="text-xs text-yellow-800 uppercase bg-yellow-50 border-b border-yellow-100">
                            <tr>
                                <th class="px-4 py-4 font-bold">Waktu</th>
                                <th class="px-4 py-4 font-bold">Nasabah</th>
                                <th class="px-4 py-4 font-bold">Petugas Lapangan</th>
                                <th class="px-4 py-4 font-bold text-right">Nilai Nominal</th>
                                @if(Auth::user()->role === 'admin')
                                <th class="px-4 py-4 font-bold text-center w-64">Validasi Cepat</th>
                                <th class="px-4 py-4 font-bold text-center">Aksi Lanjutan</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($pendingTransactions as $trx)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-4 font-medium">{{ $trx->created_at->format('d M Y H:i') }}</td>
                                <td class="px-4 py-4 font-bold text-gray-900">{{ $trx->nasabah->nama }}</td>
                                <td class="px-4 py-4 text-gray-500">{{ $trx->penimbang->name }}</td>
                                <td class="px-4 py-4 font-black text-gray-800 text-right">Rp {{ number_format($trx->total_nilai, 0, ',', '.') }}<br><span class="text-xs text-gray-400 font-normal">Berat: {{ $trx->detail->sum('berat') }} kg</span></td>
                                @if(Auth::user()->role === 'admin')
                                <td class="px-4 py-4 align-top text-center" x-data="{ bGudang: '', bLap: {{ $trx->detail->sum('berat') }} }">
                                    <form action="{{ route('validasi.process', $trx->id_transaksi) }}" method="POST" class="flex flex-col gap-1">
                                        @csrf
                                        <input type="hidden" name="total_berat_lapangan" value="{{ $trx->detail->sum('berat') }}">
                                        <div class="flex gap-1">
                                            <input type="number" name="total_berat_gudang" step="0.01" min="0" placeholder="Berat Gudang (kg)" x-model="bGudang" class="text-xs border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 rounded shadow-sm px-2 py-1.5 w-full font-bold text-blue-800" required>
                                            <button type="submit" x-show="bGudang === '' || Math.abs(bLap - parseFloat(bGudang || 0)) <= 10" class="text-[11px] bg-green-600 hover:bg-green-700 text-white font-bold px-2 rounded shadow-sm shrink-0 transition-colors" title="Validasi">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                            </button>
                                        </div>
                                        <div x-show="bGudang !== ''" class="text-[9px] leading-tight text-center font-bold" x-cloak>
                                            <span x-show="Math.abs(bLap - parseFloat(bGudang || 0)) <= 0.1" class="text-green-600">OK</span>
                                            <span x-show="Math.abs(bLap - parseFloat(bGudang || 0)) > 0.1 && Math.abs(bLap - parseFloat(bGudang || 0)) <= 10" class="text-orange-500">Terkoreksi</span>
                                            <span x-show="Math.abs(bLap - parseFloat(bGudang || 0)) > 10" class="text-red-600 block">Selisih terlalu besar! Gunakan "Rombak"</span>
                                        </div>
                                    </form>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <a href="{{ route('validasi.koreksi', $trx->id_transaksi) }}" class="inline-flex items-center gap-1 bg-blue-100 hover:bg-blue-600 text-blue-700 hover:text-white font-bold py-1.5 px-3 rounded text-xs transition-colors shadow-sm whitespace-nowrap">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        Rombak Data
                                    </a>
                                </td>
                                @endif
                            </tr>
                            @empty
                            <tr>
                                <td colspan="{{ Auth::user()->role === 'admin' ? '6' : '4' }}" class="px-4 py-12 text-center text-gray-400 italic">Antrean kosong. Semua setoran sudah divalidasi.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- TAB 2: COMPLETED -->
            <div x-show="activeTab === 'completed'" x-cloak class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-600">
                        <thead class="text-xs text-green-800 uppercase bg-green-50 border-b border-green-100">
                            <tr>
                                <th class="px-4 py-4 font-bold">Waktu & TRX</th>
                                <th class="px-4 py-4 font-bold">Nasabah</th>
                                <th class="px-4 py-4 font-bold text-right">Nilai Nominal</th>
                                <th class="px-4 py-4 font-bold">Status & Catatan Admin</th>
                                <th class="px-4 py-4 font-bold text-center">Aksi Riwayat</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($completedTransactions as $trx)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-4 font-medium text-gray-800">{{ $trx->created_at->format('d M Y H:i') }}<br><span class="text-xs text-gray-400 font-mono">#{{ $trx->id_transaksi }}</span></td>
                                <td class="px-4 py-4 font-bold text-gray-900">{{ $trx->nasabah->nama }}</td>
                                <td class="px-4 py-4 font-black text-gray-800 text-right">Rp {{ number_format($trx->total_nilai, 0, ',', '.') }}<br><span class="text-xs text-gray-400 font-normal">Berat: {{ $trx->detail->sum('berat') }} kg</span></td>
                                <td class="px-4 py-4">
                                    @if($trx->status_validasi == 'valid')
                                        <span class="bg-green-100 text-green-700 text-[10px] px-2.5 py-1 rounded-full font-bold uppercase tracking-wide inline-block mb-1">Valid</span>
                                    @elseif($trx->status_validasi == 'terkoreksi')
                                        <span class="bg-blue-100 text-blue-700 text-[10px] px-2.5 py-1 rounded-full font-bold uppercase tracking-wide inline-block mb-1">Terkoreksi</span>
                                    @endif
                                    <div class="text-[11px] text-gray-500 italic mt-0.5 leading-tight">{{ $trx->catatan_validasi ?? 'Tanpa catatan' }}</div>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <div class="flex justify-center gap-1.5">
                                        <a href="{{ route('transaksi.cetak', $trx->id_transaksi) }}" target="_blank" class="bg-blue-600 hover:bg-blue-700 text-white font-bold p-1.5 rounded shadow-sm transition-colors" title="Cetak Struk">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
                                        </a>
                                        @if($trx->nasabah->no_hp)
                                        @php
                                            $waText = urlencode("Halo " . $trx->nasabah->nama . ",\nSetoran sampah Anda senilai Rp " . number_format($trx->total_nilai, 0, ',', '.') . " (" . ucfirst($trx->status_validasi) . ").\nTerima kasih!");
                                        @endphp
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $trx->nasabah->no_hp) }}?text={{ $waText }}" target="_blank" class="bg-[#25D366] hover:bg-[#128C7E] text-white font-bold p-1.5 rounded shadow-sm transition-colors" title="Kirim Pesan Bukti via WA">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                        </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-4 py-12 text-center text-gray-400 italic">Belum ada riwayat transaksi yang divalidasi pada rentang tanggal ini.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- TAB 3: BULK MODE -->
            <div x-show="activeTab === 'bulk'" x-cloak class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
                <div class="p-5 bg-blue-50 border-b border-blue-100">
                    <h3 class="font-bold text-blue-800 text-sm">Mode Borongan (Bulk Validation)</h3>
                    <p class="text-xs text-blue-600 mt-1">Gunakan mode ini jika Anda ingin melakukan validasi berat total untuk semua setoran dari satu petugas lapangan di hari yang sama sekaligus.</p>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-600">
                        <thead class="text-xs text-blue-800 uppercase bg-blue-50 border-b border-blue-100">
                            <tr>
                                <th class="px-6 py-4 font-bold">Petugas Penimbang</th>
                                <th class="px-6 py-4 font-bold">Tanggal</th>
                                <th class="px-6 py-4 font-bold">Total Berat Lapangan</th>
                                <th class="px-6 py-4 font-bold text-center">Status Agregat</th>
                                @if(Auth::user()->role === 'admin')
                                <th class="px-6 py-4 font-bold text-center w-56">Validasi Total Gudang</th>
                                @endif
                            </tr>
                        </thead>

                        @forelse ($tabPenimbang as $row)
                        <tbody x-data="{ expanded: false }" class="border-b border-gray-100">
                            <tr class="bg-white hover:bg-gray-50 transition-colors group cursor-pointer">
                                <td @click="expanded = !expanded" class="px-6 py-4 font-black text-gray-900 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-400 transform transition-transform" :class="{'rotate-90 text-blue-600': expanded}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                                    {{ $row['nama_penimbang'] }}
                                </td>
                                <td @click="expanded = !expanded" class="px-6 py-4 font-medium">{{ \Carbon\Carbon::parse($row['tanggal'])->format('d M Y') }}</td>
                                <td @click="expanded = !expanded" class="px-6 py-4 font-bold">
                                    {{ number_format($row['total_berat'], 2, ',', '.') }} kg
                                </td>
                                <td @click="expanded = !expanded" class="px-6 py-4 text-center">
                                    @if($row['status_agregat'] == 'Semua Valid')
                                    <span class="bg-green-100 text-green-700 text-xs px-2.5 py-1 rounded-full font-bold">Semua Valid</span>
                                    @elseif($row['status_agregat'] == 'Ada Pending')
                                    <span class="bg-yellow-100 text-yellow-700 text-xs px-2.5 py-1 rounded-full font-bold animate-pulse">Ada Pending</span>
                                    @else
                                    <span class="bg-blue-100 text-blue-700 text-xs px-2.5 py-1 rounded-full font-bold">Ada Koreksi</span>
                                    @endif
                                </td>
                                @if(Auth::user()->role === 'admin')
                                <td class="px-6 py-4 text-center align-top">
                                    @if($row['id_transaksi_pending'] != '')
                                    <form action="{{ route('validasi.bulk') }}" method="POST" class="flex flex-col gap-2" x-data="{ beratGudang: '', beratLapangan: {{ $row['total_berat_pending'] }} }">
                                        @csrf
                                        <input type="hidden" name="ids" value="{{ $row['id_transaksi_pending'] }}">
                                        <input type="hidden" name="total_berat_lapangan" value="{{ $row['total_berat_pending'] }}">
                                        
                                        <input type="number" name="berat_gudang" step="0.01" min="0" placeholder="Berat Gudang (kg)" x-model="beratGudang" title="Timbangan Gudang u/ {{ number_format($row['total_berat_pending'], 2) }}kg Lapangan" class="text-xs border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 rounded shadow-sm px-2 py-1.5 w-full text-center font-bold text-blue-800" required>
                                        
                                        <div x-show="beratGudang !== ''" class="text-[10px] leading-tight text-center font-bold mb-1" x-cloak>
                                            <span x-show="Math.abs(beratLapangan - parseFloat(beratGudang || 0)) <= 0.1" class="text-green-600">Sesuai! (OK)</span>
                                            <span x-show="Math.abs(beratLapangan - parseFloat(beratGudang || 0)) > 0.1 && Math.abs(beratLapangan - parseFloat(beratGudang || 0)) <= 10" class="text-orange-500">Terkoreksi</span>
                                            <span x-show="Math.abs(beratLapangan - parseFloat(beratGudang || 0)) > 10" class="text-red-600 block">Selisih ekstrim! Buka rincian & klik "Rombak Data".</span>
                                        </div>

                                        <button type="submit" x-show="beratGudang === '' || Math.abs(beratLapangan - parseFloat(beratGudang || 0)) <= 10" class="text-[11px] bg-green-600 hover:bg-green-700 text-white font-bold py-1.5 px-2 rounded shadow-sm w-full" onclick="return confirm('Data total sesuai? Saldo akan ditambahkan. Lanjutkan?')">Validasi Grup Ini</button>
                                    </form>
                                    @else
                                    <span class="text-xs text-gray-400 italic font-medium">Selesai Divalidasi</span>
                                    @endif
                                </td>
                                @endif
                            </tr>
                            <tr x-show="expanded" x-cloak class="bg-gray-50">
                                <td colspan="{{ Auth::user()->role === 'admin' ? '5' : '4' }}" class="p-0 border-t border-gray-100">
                                    <div class="px-10 py-4 bg-gray-50 border-l-4 border-blue-500 shadow-inner">
                                        <table class="w-full text-xs text-left text-gray-500">
                                            <thead class="uppercase text-gray-400 border-b border-gray-200">
                                                <tr>
                                                    <th class="py-2">Waktu</th>
                                                    <th class="py-2">Nasabah</th>
                                                    <th class="py-2 text-right">Nilai Lapangan</th>
                                                    <th class="py-2 text-center">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($row['transaksi'] as $trx)
                                                <tr class="border-b border-gray-100 last:border-0 hover:bg-gray-100 transition-colors">
                                                    <td class="py-2 font-medium">{{ $trx->created_at->format('H:i') }}</td>
                                                    <td class="py-2 font-bold text-gray-800">{{ $trx->nasabah->nama }}</td>
                                                    <td class="py-2 font-bold text-gray-700 text-right">Rp {{ number_format($trx->total_nilai, 0, ',', '.') }}</td>
                                                    <td class="py-2 text-center">
                                                        @if($trx->status_validasi == 'valid') <span class="text-green-600 font-bold">Valid</span>
                                                        @elseif($trx->status_validasi == 'terkoreksi') <span class="text-blue-600 font-bold">Terkoreksi</span>
                                                        @else <span class="text-yellow-600 font-bold">Pending</span> @endif
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <div class="mt-2 text-xs text-gray-400 italic">*Untuk aksi cetak struk atau rombak data per item, silakan gunakan Tab "Antrean Pending" atau "Riwayat Selesai".</div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                        @empty
                        <tbody><tr><td colspan="{{ Auth::user()->role === 'admin' ? '5' : '4' }}" class="text-center py-8 text-gray-400 italic">Tidak ada data transaksi grup.</td></tr></tbody>
                        @endforelse
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>