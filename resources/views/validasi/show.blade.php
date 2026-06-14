<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <a href="{{ route('validasi.index') }}" class="text-gray-500 hover:text-green-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            </a>
            <h2 class="font-bold text-xl text-green-800 leading-tight">
                {{ __('Validasi Cepat Timbangan Gudang') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if(session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-4 rounded-xl relative shadow-sm font-bold flex items-center gap-3">
                <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                {{ session('error') }}
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 p-6 lg:p-8">
                
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8 border-b border-gray-100 pb-6">
                    <div class="bg-gray-50 p-3 rounded-lg border border-gray-100">
                        <p class="text-xs text-gray-500 uppercase font-bold tracking-wider mb-1">Nasabah</p>
                        <p class="font-black text-gray-900 truncate">{{ $transaksi->nasabah->nama }}</p>
                    </div>
                    <div class="bg-gray-50 p-3 rounded-lg border border-gray-100">
                        <p class="text-xs text-gray-500 uppercase font-bold tracking-wider mb-1">Waktu Input</p>
                        <p class="font-bold text-gray-900">{{ $transaksi->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div class="bg-gray-50 p-3 rounded-lg border border-gray-100">
                        <p class="text-xs text-gray-500 uppercase font-bold tracking-wider mb-1">Penimbang</p>
                        <p class="font-bold text-gray-900 truncate">{{ $transaksi->penimbang->name }}</p>
                    </div>
                    <div class="bg-green-50 p-3 rounded-lg border border-green-100">
                        <p class="text-xs text-green-600 uppercase font-bold tracking-wider mb-1">Total Nilai Uang</p>
                        <p class="font-black text-green-800">Rp {{ number_format($transaksi->total_nilai, 0, ',', '.') }}</p>
                    </div>
                </div>

                <h3 class="font-bold text-gray-800 mb-3 flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Data Nota Lapangan
                </h3>
                <div class="overflow-x-auto mb-8 border border-gray-200 rounded-xl shadow-sm">
                    <table class="w-full text-sm text-left text-gray-600">
                        <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th class="px-5 py-3">Jenis Barang</th>
                                <th class="px-5 py-3 text-center">Berat (kg)</th>
                                <th class="px-5 py-3 text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $total_lapangan = 0; @endphp
                            @foreach($transaksi->detail as $item)
                            @php $total_lapangan += $item->berat; @endphp
                            <tr class="border-b border-gray-50">
                                <td class="px-5 py-3 font-semibold text-gray-800">{{ $item->jenisSampah->nama_sampah }}</td>
                                <td class="px-5 py-3 text-center font-bold">{{ $item->berat }}</td>
                                <td class="px-5 py-3 text-right text-gray-500">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-100 font-black text-gray-800">
                            <tr>
                                <td class="px-5 py-3 text-right uppercase text-xs tracking-widest text-gray-500">Total Berat:</td>
                                <td class="px-5 py-3 text-center text-blue-600 text-lg" id="total-lapangan-text" data-total="{{ $total_lapangan }}">{{ number_format($total_lapangan, 2) }} kg</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <form action="{{ route('validasi.process', $transaksi->id_transaksi) }}" method="POST">
                    @csrf
                    <input type="hidden" name="total_berat_lapangan" value="{{ $total_lapangan }}">

                    <div class="bg-green-50 border-2 border-green-200 p-8 rounded-2xl mb-8 shadow-sm">
                        <h3 class="font-bold text-green-800 mb-2 text-xl text-center">Timbangan Akhir Gudang</h3>
                        <p class="text-sm text-green-600 text-center mb-6">Letakkan seluruh karung milik nasabah ini di atas timbangan gudang, lalu masukkan angka total yang tertera di layar.</p>
                        
                        <div class="max-w-xs mx-auto text-center relative">
                            <label class="block text-xs font-bold text-green-700 uppercase tracking-widest mb-2">Total Berat Gudang</label>
                            <div class="relative">
                                <input type="number" step="0.01" min="0" name="total_berat_gudang" id="input-gudang" class="w-full text-center text-4xl font-black text-gray-900 border-2 border-green-300 focus:border-green-500 focus:ring-green-500 rounded-xl py-4 shadow-inner" placeholder="0.00" required>
                                <div class="absolute inset-y-0 right-0 pr-5 flex items-center pointer-events-none">
                                    <span class="text-gray-400 font-bold text-lg">kg</span>
                                </div>
                            </div>
                            <div id="pesan-selisih" class="mt-4 text-sm font-bold h-6 transition-all"></div>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row justify-between items-center bg-gray-50 p-4 rounded-xl border border-gray-200 gap-4">
                        <a href="{{ route('validasi.index') }}" class="text-gray-500 hover:text-gray-700 font-medium px-4 transition-colors">Batal</a>
                        
                        <button type="submit" id="btn-validasi" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-xl shadow-md transition-all text-base w-full sm:w-auto flex items-center justify-center gap-2" onclick="return confirm('Data total sesuai? Saldo akan langsung dicairkan ke rekening nasabah.')">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Setujui & Validasi
                        </button>
                        
                        <a href="{{ route('validasi.koreksi', $transaksi->id_transaksi) }}" id="btn-koreksi" class="hidden bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-8 rounded-xl shadow-md transition-all text-base w-full sm:w-auto items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            Lanjut ke Koreksi Total
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const inputGudang = document.getElementById('input-gudang');
                const totalLapangan = parseFloat(document.getElementById('total-lapangan-text').getAttribute('data-total'));
                const pesanSelisih = document.getElementById('pesan-selisih');
                const btnValidasi = document.getElementById('btn-validasi');
                const btnKoreksi = document.getElementById('btn-koreksi');

                inputGudang.addEventListener('input', function() {
                    const gudang = parseFloat(this.value) || 0;
                    if(gudang === 0 || this.value === '') {
                        pesanSelisih.innerHTML = '';
                        btnValidasi.classList.remove('hidden');
                        btnValidasi.classList.add('flex');
                        btnKoreksi.classList.add('hidden');
                        btnKoreksi.classList.remove('flex');
                        return;
                    }

                    const selisih = totalLapangan - gudang;
                    const selisihAbs = Math.abs(selisih);

                    if (selisihAbs > 0.1 && selisihAbs <= 10) {
                        pesanSelisih.innerHTML = `<span class="text-orange-500">Ada selisih susut/muai: ${selisihAbs.toFixed(2)} kg. Masih batas aman.</span>`;
                    } else if (selisihAbs === 0) {
                        pesanSelisih.innerHTML = `<span class="text-green-600">Sempurna! Berat 100% Sesuai.</span>`;
                    }

                    if (selisihAbs > 10) {
                        pesanSelisih.innerHTML = `<span class="text-red-600">Selisih terlalu jauh (>10kg)! Harus dikoreksi rinciannya.</span>`;
                        
                        btnValidasi.classList.add('hidden');
                        btnValidasi.classList.remove('flex');
                        btnKoreksi.classList.remove('hidden');
                        btnKoreksi.classList.add('flex');
                    } else {
                        btnValidasi.classList.remove('hidden');
                        btnValidasi.classList.add('flex');
                        btnKoreksi.classList.add('hidden');
                        btnKoreksi.classList.remove('flex');
                    }
                });
            });
        </script>
    </x-slot>
</x-app-layout>