<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-green-800 leading-tight">
            {{ __('Validasi Transaksi Operasional') }}
        </h2>
    </x-slot>

    <div class="py-8" x-data="{ activeTab: 'harian' }">
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
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-blue-800 font-bold text-lg">Mode Lihat Saja (Read-Only)</h3>
                    <p class="text-blue-600 text-sm mt-1">Anda sedang melihat halaman Validasi. Anda tidak dapat melakukan perubahan data, validasi, ataupun koreksi di halaman ini.</p>
                </div>
            </div>
            @endif

            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-6 flex flex-col sm:flex-row justify-between items-center gap-4">
                <div class="font-bold text-gray-700 flex items-center gap-2">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    Filter Data
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

            <div class="flex gap-2 border-b border-gray-200 mb-6">
                <button @click="activeTab = 'harian'" :class="{'bg-green-50 text-green-700 border-b-2 border-green-600': activeTab === 'harian', 'text-gray-500 hover:text-gray-700 hover:bg-gray-50': activeTab !== 'harian'}" class="px-6 py-3 font-bold text-sm transition-colors rounded-t-lg focus:outline-none">
                    Tab Total Harian
                </button>
                <button @click="activeTab = 'penimbang'" :class="{'bg-green-50 text-green-700 border-b-2 border-green-600': activeTab === 'penimbang', 'text-gray-500 hover:text-gray-700 hover:bg-gray-50': activeTab !== 'penimbang'}" class="px-6 py-3 font-bold text-sm transition-colors rounded-t-lg focus:outline-none">
                    Tab Per Penimbang
                </button>
            </div>

            <div x-show="activeTab === 'harian'" x-cloak class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-600">
                        <thead class="text-xs text-green-800 uppercase bg-green-50 border-b border-green-100">
                            <tr>
                                <th class="px-6 py-4 font-bold">Tanggal</th>
                                <th class="px-6 py-4 font-bold">Total Berat</th>
                                <th class="px-6 py-4 font-bold text-center">Jml Transaksi</th>
                                <th class="px-6 py-4 font-bold text-right">Total Nilai</th>
                                <th class="px-6 py-4 font-bold text-center">Status</th>
                                @if(Auth::user()->role === 'admin')
                                <th class="px-6 py-4 font-bold text-center">Aksi (Validasi Semua)</th>
                                @endif
                            </tr>
                        </thead>

                        @forelse ($tabHarian as $row)
                        <tbody x-data="{ expanded: false }" class="border-b border-gray-100">
                            <tr class="bg-white hover:bg-gray-50 transition-colors group cursor-pointer">
                                <td @click="expanded = !expanded" class="px-6 py-4 font-black text-gray-900 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-400 transform transition-transform" :class="{'rotate-90 text-green-600': expanded}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                    {{ \Carbon\Carbon::parse($row['tanggal'])->format('d M Y') }}
                                </td>
                                <td @click="expanded = !expanded" class="px-6 py-4 font-bold">{{ number_format($row['total_berat'], 2, ',', '.') }} kg</td>
                                <td @click="expanded = !expanded" class="px-6 py-4 text-center"><span class="bg-gray-100 text-gray-800 px-2.5 py-0.5 rounded-full font-bold">{{ $row['jml_transaksi'] }}</span></td>
                                <td @click="expanded = !expanded" class="px-6 py-4 text-right font-bold text-gray-900">Rp {{ number_format($row['total_nilai'], 0, ',', '.') }}</td>
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
                                <td class="px-6 py-4 text-center">
                                    @if($row['id_transaksi_pending'] != '')
                                    <form action="{{ route('validasi.bulk') }}" method="POST" onsubmit="return confirm(`Validasi massal SEMUA transaksi pending di tanggal ini?`);">
                                        @csrf
                                        <input type="hidden" name="ids" value="{{ $row['id_transaksi_pending'] }}">
                                        <button type="submit" class="text-xs bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-1.5 px-3 rounded shadow-sm">Validasi Pending</button>
                                    </form>
                                    @else
                                    <span class="text-xs text-gray-400 italic">Selesai</span>
                                    @endif
                                </td>
                                @endif
                            </tr>
                            <tr x-show="expanded" x-cloak class="bg-gray-50">
                                <td colspan="{{ Auth::user()->role === 'admin' ? '6' : '5' }}" class="p-0 border-t border-gray-100">
                                    <div class="px-10 py-4 bg-gray-50 border-l-4 border-green-500 shadow-inner">
                                        <table class="w-full text-xs text-left text-gray-500">
                                            <thead class="uppercase text-gray-400 border-b border-gray-200">
                                                <tr>
                                                    <th class="py-2">Waktu</th>
                                                    <th class="py-2">Nasabah</th>
                                                    <th class="py-2">Penimbang</th>
                                                    <th class="py-2">Nilai</th>
                                                    <th class="py-2">Status</th>
                                                    @if(Auth::user()->role === 'admin')
                                                    <th class="py-2 text-right">Cek Detail</th>
                                                    @endif
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($row['transaksi'] as $trx)
                                                <tr class="border-b border-gray-100 last:border-0 hover:bg-gray-100 transition-colors">
                                                    <td class="py-2 font-medium">{{ $trx->created_at->format('H:i') }}</td>
                                                    <td class="py-2 font-bold text-gray-800">{{ $trx->nasabah->nama }}</td>
                                                    <td class="py-2">{{ $trx->penimbang->name }}</td>
                                                    <td class="py-2 font-bold text-gray-700">Rp {{ number_format($trx->total_nilai, 0, ',', '.') }}</td>
                                                    <td class="py-2">
                                                        @if($trx->status_validasi == 'valid') <span class="text-green-600 font-bold">Valid</span>
                                                        @elseif($trx->status_validasi == 'terkoreksi') <span class="text-blue-600 font-bold">Terkoreksi</span>
                                                        @else <span class="text-yellow-600 font-bold">Pending</span> @endif
                                                    </td>
                                                    @if(Auth::user()->role === 'admin')
                                                    <td class="py-2 text-right">
                                                        @if($trx->status_validasi == 'pending')
                                                        <a href="{{ route('validasi.show', $trx->id_transaksi) }}" class="text-blue-600 hover:text-blue-800 font-bold hover:underline">Periksa &rarr;</a>
                                                        @endif
                                                    </td>
                                                    @endif
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                        @empty
                        <tbody>
                            <tr>
                                <td colspan="{{ Auth::user()->role === 'admin' ? '6' : '5' }}" class="text-center py-8 text-gray-400 italic">Tidak ada data transaksi pada rentang tanggal tersebut.</td>
                            </tr>
                        </tbody>
                        @endforelse
                    </table>
                </div>
            </div>

            <div x-show="activeTab === 'penimbang'" x-cloak class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-600">
                        <thead class="text-xs text-blue-800 uppercase bg-blue-50 border-b border-blue-100">
                            <tr>
                                <th class="px-6 py-4 font-bold">Petugas Penimbang</th>
                                <th class="px-6 py-4 font-bold">Tanggal</th>
                                <th class="px-6 py-4 font-bold">Total Berat</th>
                                <th class="px-6 py-4 font-bold text-center">Jml Transaksi</th>
                                <th class="px-6 py-4 font-bold text-center">Status</th>
                                @if(Auth::user()->role === 'admin')
                                <th class="px-6 py-4 font-bold text-center">Aksi (Validasi Semua)</th>
                                @endif
                            </tr>
                        </thead>

                        @forelse ($tabPenimbang as $row)
                        <tbody x-data="{ expanded: false }" class="border-b border-gray-100">
                            <tr class="bg-white hover:bg-gray-50 transition-colors group cursor-pointer">
                                <td @click="expanded = !expanded" class="px-6 py-4 font-black text-gray-900 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-400 transform transition-transform" :class="{'rotate-90 text-blue-600': expanded}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                    {{ $row['nama_penimbang'] }}
                                </td>
                                <td @click="expanded = !expanded" class="px-6 py-4 font-medium">{{ \Carbon\Carbon::parse($row['tanggal'])->format('d M Y') }}</td>
                                <td @click="expanded = !expanded" class="px-6 py-4 font-bold">{{ number_format($row['total_berat'], 2, ',', '.') }} kg</td>
                                <td @click="expanded = !expanded" class="px-6 py-4 text-center"><span class="bg-gray-100 text-gray-800 px-2.5 py-0.5 rounded-full font-bold">{{ $row['jml_transaksi'] }}</span></td>
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
                                <td class="px-6 py-4 text-center">
                                    @if($row['id_transaksi_pending'] != '')
                                    <form action="{{ route('validasi.bulk') }}" method="POST" onsubmit="return confirm(`Validasi massal SEMUA transaksi pending milik {{ $row['nama_penimbang'] }} di tanggal ini?`);">
                                        @csrf
                                        <input type="hidden" name="ids" value="{{ $row['id_transaksi_pending'] }}">
                                        <button type="submit" class="text-xs bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-1.5 px-3 rounded shadow-sm">Validasi Pending</button>
                                    </form>
                                    @else
                                    <span class="text-xs text-gray-400 italic">Selesai</span>
                                    @endif
                                </td>
                                @endif
                            </tr>
                            <tr x-show="expanded" x-cloak class="bg-gray-50">
                                <td colspan="{{ Auth::user()->role === 'admin' ? '6' : '5' }}" class="p-0 border-t border-gray-100">
                                    <div class="px-10 py-4 bg-gray-50 border-l-4 border-blue-500 shadow-inner">
                                        <table class="w-full text-xs text-left text-gray-500">
                                            <thead class="uppercase text-gray-400 border-b border-gray-200">
                                                <tr>
                                                    <th class="py-2">Waktu</th>
                                                    <th class="py-2">Nasabah</th>
                                                    <th class="py-2">Nilai</th>
                                                    <th class="py-2">Status</th>
                                                    @if(Auth::user()->role === 'admin')
                                                    <th class="py-2 text-right">Cek Detail</th>
                                                    @endif
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($row['transaksi'] as $trx)
                                                <tr class="border-b border-gray-100 last:border-0 hover:bg-gray-100 transition-colors">
                                                    <td class="py-2 font-medium">{{ $trx->created_at->format('H:i') }}</td>
                                                    <td class="py-2 font-bold text-gray-800">{{ $trx->nasabah->nama }}</td>
                                                    <td class="py-2 font-bold text-gray-700">Rp {{ number_format($trx->total_nilai, 0, ',', '.') }}</td>
                                                    <td class="py-2">
                                                        @if($trx->status_validasi == 'valid') <span class="text-green-600 font-bold">Valid</span>
                                                        @elseif($trx->status_validasi == 'terkoreksi') <span class="text-blue-600 font-bold">Terkoreksi</span>
                                                        @else <span class="text-yellow-600 font-bold">Pending</span> @endif
                                                    </td>
                                                    @if(Auth::user()->role === 'admin')
                                                    <td class="py-2 text-right">
                                                        @if($trx->status_validasi == 'pending')
                                                        <a href="{{ route('validasi.show', $trx->id_transaksi) }}" class="text-blue-600 hover:text-blue-800 font-bold hover:underline">Periksa &rarr;</a>
                                                        @endif
                                                    </td>
                                                    @endif
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                        @empty
                        <tbody>
                            <tr>
                                <td colspan="{{ Auth::user()->role === 'admin' ? '6' : '5' }}" class="text-center py-8 text-gray-400 italic">Tidak ada data transaksi pada rentang tanggal tersebut.</td>
                            </tr>
                        </tbody>
                        @endforelse
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>