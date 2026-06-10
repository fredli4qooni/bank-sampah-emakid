<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <a href="{{ route('validasi.index') }}" class="text-gray-500 hover:text-blue-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h2 class="font-bold text-xl text-blue-800 leading-tight">
                {{ __('Koreksi Data Transaksi') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8" x-data="koreksiForm({{ json_encode($transaksi->detail->map(function($dt) { return ['berat' => (float) $dt->berat, 'harga' => (float) $dt->harga_saat_transaksi]; })) }})">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-6 bg-blue-50 border border-blue-200 rounded-xl p-4 flex items-start gap-4 shadow-sm">
                <div class="bg-blue-100 p-2 rounded-full text-blue-600 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-blue-800 font-bold text-lg">Mode Koreksi Admin</h3>
                    <p class="text-blue-600 text-sm mt-1">Ubah berat atau harga satuan jika terdapat kesalahan input dari Penimbang. Perubahan ini akan langsung mempengaruhi total estimasi nilai transaksi sebelum proses validasi gudang dilakukan.</p>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 p-6 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500 font-bold uppercase tracking-wider mb-1">Nama Nasabah</p>
                        <p class="text-lg font-black text-gray-800">{{ $transaksi->nasabah->nama }} <span class="text-sm font-medium text-gray-500">({{ $transaksi->nasabah->no_rekening }})</span></p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-bold uppercase tracking-wider mb-1">Waktu Transaksi</p>
                        <p class="text-lg font-bold text-gray-800">{{ $transaksi->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 p-6 lg:p-8">
                <form action="{{ route('transaksi.update', $transaksi->id_transaksi) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="overflow-x-auto rounded-lg border border-gray-200 mb-6">
                        <table class="w-full text-sm text-left text-gray-600">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th class="px-6 py-4 font-bold">Jenis Sampah</th>
                                    <th class="px-6 py-4 font-bold">Harga / kg (Rp)</th>
                                    <th class="px-6 py-4 font-bold">Berat (kg)</th>
                                    <th class="px-6 py-4 font-bold text-right">Subtotal (Rp)</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($transaksi->detail as $index => $dt)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 font-bold text-gray-800">{{ $dt->jenisSampah->nama_sampah }}</td>
                                    <td class="px-6 py-4">
                                        <input type="number" name="harga[{{ $dt->id_detail }}]" x-model="items[{{ $index }}].harga" @input="calculateTotal()" class="w-32 border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 rounded-md shadow-sm text-sm" step="1" min="0" required>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <input type="number" name="berat[{{ $dt->id_detail }}]" x-model="items[{{ $index }}].berat" @input="calculateTotal()" class="w-24 border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 rounded-md shadow-sm text-sm" step="0.01" min="0.01" required>
                                            <span class="text-gray-500 font-medium">kg</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 font-black text-gray-900 text-right">
                                        Rp <span x-text="formatRupiah(items[{{ $index }}].harga * items[{{ $index }}].berat)"></span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-gray-50 border-t border-gray-200 font-black text-gray-900 text-base">
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-right uppercase tracking-wider">Total Estimasi Baru:</td>
                                    <td class="px-6 py-4 text-right text-blue-700">Rp <span x-text="formatRupiah(grandTotal)"></span></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="flex items-center justify-end gap-3">
                        <a href="{{ route('validasi.index') }}" class="text-gray-500 hover:text-gray-700 font-medium px-4 py-2 transition-colors">Batal</a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-6 rounded-lg shadow-md transition-colors focus:outline-none focus:ring-4 focus:ring-blue-300">
                            Simpan Koreksi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('koreksiForm', (initialItems) => ({
                    items: initialItems,
                    grandTotal: 0,

                    init() {
                        this.calculateTotal();
                    },

                    calculateTotal() {
                        this.grandTotal = this.items.reduce((sum, item) => sum + (item.berat * item.harga), 0);
                    },

                    formatRupiah(angka) {
                        return new Intl.NumberFormat('id-ID').format(angka);
                    }
                }));
            });
        </script>
    </x-slot>
</x-app-layout>