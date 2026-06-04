<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <a href="{{ route('validasi.index') }}" class="text-gray-500 hover:text-green-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            </a>
            <h2 class="font-bold text-xl text-green-800 leading-tight">
                {{ __('Detail & Validasi Transaksi') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
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
                        <p class="text-xs text-green-600 uppercase font-bold tracking-wider mb-1">Total Lapangan</p>
                        <p class="font-black text-green-800">Rp {{ number_format($transaksi->total_nilai, 0, ',', '.') }}</p>
                    </div>
                </div>

                <form action="{{ route('validasi.process', $transaksi->id_transaksi) }}" method="POST">
                    @csrf
                    
                    <h3 class="font-bold text-gray-800 mb-3 flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                        Rincian Setoran Barang
                    </h3>
                    
                    <div class="overflow-x-auto mb-8 border border-gray-200 rounded-xl shadow-sm">
                        <table class="w-full text-sm text-left text-gray-600">
                            <thead class="text-xs text-green-800 uppercase bg-green-50 border-b border-green-100">
                                <tr>
                                    <th class="px-5 py-4 font-bold">Jenis Sampah</th>
                                    <th class="px-5 py-4 font-bold">Harga / Kg</th>
                                    <th class="px-5 py-4 font-bold text-center">B. Lapangan</th>
                                    <th class="px-5 py-4 font-bold text-center bg-yellow-100 text-yellow-900 border-l border-r border-yellow-200">B. Gudang (Kg/Ltr)</th>
                                    <th class="px-5 py-4 font-bold text-center">Selisih (Δ)</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($transaksi->detail as $item)
                                <tr class="bg-white item-row">
                                    <td class="px-5 py-4 font-semibold text-gray-800">{{ $item->jenisSampah->nama_sampah }}</td>
                                    <td class="px-5 py-4">Rp {{ number_format($item->harga_saat_transaksi, 0, ',', '.') }}</td>
                                    <td class="px-5 py-4 text-center font-black text-gray-900 berat-lapangan" data-berat="{{ $item->berat }}">{{ $item->berat }}</td>
                                    <td class="px-5 py-3 bg-yellow-50 border-l border-r border-yellow-100">
                                        <input type="number" step="0.01" name="berat_gudang[{{ $item->id_detail }}]" value="{{ $item->berat }}" class="berat-gudang-input w-24 mx-auto border-yellow-300 focus:border-yellow-500 focus:ring-yellow-200 rounded-lg text-sm text-center font-bold text-gray-900" required>
                                    </td>
                                    <td class="px-5 py-4 text-center font-black selisih-text text-gray-400">0.00</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div id="area-koreksi" class="mb-8 p-5 bg-red-50 border border-red-200 rounded-xl hidden shadow-inner">
                        <div class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-red-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                            <div class="w-full">
                                <h4 class="font-bold text-red-800 mb-1">Terdapat Selisih Signifikan</h4>
                                <p class="text-sm text-red-600 mb-3">Sistem mendeteksi selisih antara lapangan dan gudang. Anda <b>diwajibkan</b> mengisi alasan koreksi di bawah ini untuk dicatat ke dalam Audit Log.</p>
                                <textarea name="catatan_alasan" rows="3" class="w-full border-red-300 focus:border-red-500 focus:ring-red-200 rounded-lg shadow-sm text-sm" placeholder="Contoh: Timbangan lapangan rusak 0.2kg, sudah dikonfirmasi ke penimbang..."></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-between items-center bg-gray-50 p-4 rounded-xl border border-gray-200">
                        <a href="{{ route('validasi.index') }}" class="text-gray-500 hover:text-gray-700 font-medium px-4 transition-colors">Batal</a>
                        <div class="space-x-2">
                            <button type="submit" name="action" value="validasi" id="btn-validasi" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2.5 px-6 rounded-lg shadow-md transition-transform transform hover:-translate-y-0.5" onclick="return confirm('Data lapangan dan gudang sesuai. Lanjutkan validasi dan update saldo nasabah?')">
                                Validasi Sesuai Lapangan
                            </button>
                            <button type="submit" name="action" value="koreksi" id="btn-koreksi" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2.5 px-6 rounded-lg shadow-md transition-transform transform hover:-translate-y-0.5 hidden" onclick="return confirm('Simpan perubahan data ini dan catat ke Audit Log?')">
                                Simpan Koreksi & Validasi
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const inputs = document.querySelectorAll('.berat-gudang-input');
                const areaKoreksi = document.getElementById('area-koreksi');
                const btnValidasi = document.getElementById('btn-validasi');
                const btnKoreksi = document.getElementById('btn-koreksi');
                const textareaAlasan = document.querySelector('textarea[name="catatan_alasan"]');

                const cekSelisih = () => {
                    let adaSelisihSignifikan = false;

                    document.querySelectorAll('.item-row').forEach(row => {
                        const bLapangan = parseFloat(row.querySelector('.berat-lapangan').getAttribute('data-berat'));
                        const inputGudang = row.querySelector('.berat-gudang-input');
                        const bGudang = parseFloat(inputGudang.value) || 0;
                        
                        const selisih = bLapangan - bGudang; // Δ = B_lapangan - B_gudang
                        const selisihElement = row.querySelector('.selisih-text');
                        
                        // Menambahkan format tanda + untuk nilai positif agar jelas
                        selisihElement.textContent = (selisih > 0 ? '+' : '') + selisih.toFixed(2);

                        // Fitur F-43: Merah jika > 0.1 kg
                        if (Math.abs(selisih) > 0.1) {
                            selisihElement.classList.add('text-red-600');
                            selisihElement.classList.remove('text-gray-400', 'text-green-600');
                            adaSelisihSignifikan = true;
                        } else if(selisih !== 0) {
                            selisihElement.classList.add('text-green-600');
                            selisihElement.classList.remove('text-red-600', 'text-gray-400');
                        } else {
                            selisihElement.classList.add('text-gray-400');
                            selisihElement.classList.remove('text-red-600', 'text-green-600');
                        }
                    });

                    // Atur visibilitas tombol & form wajib
                    if (adaSelisihSignifikan) {
                        areaKoreksi.classList.remove('hidden');
                        btnKoreksi.classList.remove('hidden');
                        btnValidasi.classList.add('hidden');
                        textareaAlasan.setAttribute('required', 'required');
                    } else {
                        areaKoreksi.classList.add('hidden');
                        btnKoreksi.classList.add('hidden');
                        btnValidasi.classList.remove('hidden');
                        textareaAlasan.removeAttribute('required');
                    }
                };

                inputs.forEach(input => {
                    input.addEventListener('input', cekSelisih);
                });
            });
        </script>
    </x-slot>
</x-app-layout>