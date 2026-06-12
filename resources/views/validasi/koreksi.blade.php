<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <a href="{{ route('validasi.index') }}" class="text-gray-500 hover:text-blue-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h2 class="font-bold text-xl text-blue-800 leading-tight">
                {{ __('Koreksi Total Transaksi') }} #{{ $transaksi->id_transaksi }}
            </h2>
        </div>
    </x-slot>

    @php
    $itemKeranjang = $transaksi->detail->map(function($item) {
    return [
    'id_jenis' => $item->id_jenis,
    'berat' => $item->berat
    ];
    });
    @endphp
    <div class="py-8" x-data="koreksiForm({{ json_encode($itemKeranjang) }})">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if (session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-4 rounded-xl shadow-sm flex items-start gap-3">
                <svg class="w-6 h-6 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
                <div>
                    <strong class="font-bold">Terjadi Kesalahan Sistem:</strong>
                    <p class="text-sm mt-1">{{ session('error') }}</p>
                </div>
            </div>
            @endif

            @if ($errors->any())
            @endif

            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r-xl mb-6 shadow-sm">
                <h3 class="font-bold text-blue-800">Mode Koreksi Lanjutan (Hard Edit)</h3>
                <p class="text-sm text-blue-600 mt-1">Gunakan halaman ini jika petugas lapangan salah memasukkan jenis sampah atau ada barang yang harus dibatalkan/ditambah. Saldo nasabah akan dihitung ulang secara otomatis.</p>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 p-6 lg:p-8">
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-8 border-b border-gray-100 pb-6">
                    <div class="bg-gray-50 p-3 rounded-lg border border-gray-100">
                        <p class="text-xs text-gray-500 uppercase font-bold tracking-wider mb-1">Nasabah</p>
                        <p class="font-black text-gray-900 truncate">{{ $transaksi->nasabah->nama }}</p>
                    </div>
                    <div class="bg-gray-50 p-3 rounded-lg border border-gray-100">
                        <p class="text-xs text-gray-500 uppercase font-bold tracking-wider mb-1">Penimbang Awal</p>
                        <p class="font-bold text-gray-900 truncate">{{ $transaksi->penimbang->name }}</p>
                    </div>
                    <div class="bg-red-50 p-3 rounded-lg border border-red-100">
                        <p class="text-xs text-red-600 uppercase font-bold tracking-wider mb-1">Nilai Lama</p>
                        <p class="font-black text-red-800">Rp {{ number_format($transaksi->total_nilai, 0, ',', '.') }}</p>
                    </div>
                </div>

                <form action="{{ route('validasi.update_koreksi', $transaksi->id_transaksi) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <h3 class="font-bold text-gray-800 mb-3 flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Rombak Keranjang Barang
                    </h3>

                    <div class="space-y-3 mb-6">
                        <template x-for="(item, index) in items" :key="index">
                            <div class="flex flex-col sm:flex-row gap-3 items-end bg-gray-50 p-4 rounded-xl border border-gray-200">
                                <div class="w-full sm:w-1/2">
                                    <label class="block text-xs font-bold text-gray-600 mb-1">Jenis Sampah</label>
                                    <select :name="`items[${index}][id_jenis]`" x-model="item.id_jenis" class="w-full rounded-lg border-gray-300 text-sm focus:border-blue-500 focus:ring-blue-500 shadow-sm" required>
                                        <option value="" disabled>Pilih Jenis...</option>
                                        @foreach($jenisSampah as $js)
                                        <option value="{{ $js->id_jenis }}">{{ $js->nama_sampah }} (Rp {{ number_format($js->harga_per_kg, 0, ',', '.') }}/{{ $js->satuan }})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="w-full sm:w-1/3">
                                    <label class="block text-xs font-bold text-gray-600 mb-1">Berat Sebenarnya (Kg/Ltr)</label>
                                    <input type="number" step="0.01" min="0.1" :name="`items[${index}][berat]`" x-model="item.berat" class="w-full rounded-lg border-gray-300 text-sm focus:border-blue-500 focus:ring-blue-500 shadow-sm font-bold" required>
                                </div>
                                <div class="w-full sm:w-auto pb-1">
                                    <button type="button" @click="removeItem(index)" class="w-full sm:w-auto bg-red-100 text-red-600 hover:bg-red-200 p-2.5 rounded-lg transition-colors" title="Hapus Baris">
                                        <svg class="w-5 h-5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </template>
                    </div>

                    <button type="button" @click="addItem" class="mb-8 bg-white border-2 border-dashed border-gray-300 hover:border-blue-500 text-gray-500 hover:text-blue-600 font-bold py-3 px-4 rounded-xl w-full text-center transition-colors flex justify-center items-center gap-2 text-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Tambah Baris Barang Lain
                    </button>

                    <div class="mb-8">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Alasan Koreksi (Wajib untuk Audit Log) <span class="text-red-500">*</span></label>
                        <textarea name="catatan_koreksi" rows="3" class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-200 rounded-lg shadow-sm text-sm" placeholder="Contoh: Petugas salah memilih jenis sampah, seharusnya Botol Kaca bukan Plastik..." required></textarea>
                    </div>

                    <div class="flex justify-end items-center bg-gray-50 p-4 rounded-xl border border-gray-200 gap-3">
                        <a href="{{ route('validasi.index') }}" class="text-gray-600 hover:text-gray-800 font-bold px-4 transition-colors">Batal</a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-8 rounded-lg shadow-md transition-transform transform hover:-translate-y-0.5" onclick="return confirm('Apakah Anda yakin data baru ini sudah benar? Saldo lama akan ditarik dan diganti dengan perhitungan baru ini.')">
                            Simpan Hasil Koreksi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            function koreksiForm(initialItems) {
                return {
                    items: initialItems,

                    addItem() {
                        this.items.push({
                            id_jenis: '',
                            berat: ''
                        });
                    },

                    removeItem(index) {
                        if (this.items.length > 1) {
                            this.items.splice(index, 1);
                        } else {
                            alert('Transaksi minimal harus memiliki 1 barang. Jika ingin membatalkan transaksi sepenuhnya, gunakan fitur hapus di halaman utama.');
                        }
                    }
                }
            }
        </script>
    </x-slot>

</x-app-layout>