<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <a href="{{ route('penarikan.index') }}" class="text-gray-500 hover:text-green-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            </a>
            <h2 class="font-bold text-xl text-green-800 leading-tight">
                {{ __('Proses Penarikan Saldo') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8" x-data="penarikanForm()">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('error'))
                <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl relative shadow-sm">
                    <span class="block sm:inline font-bold">{{ session('error') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 p-6 lg:p-8">
                <form action="{{ route('penarikan.store') }}" method="POST" onsubmit="return confirm('Apakah data pencairan sudah benar? Saldo nasabah akan langsung terpotong.')">
                    @csrf
                    
                    <div class="mb-5">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Pilih Nasabah <span class="text-red-500">*</span></label>
                        <select name="id_nasabah" x-model="selectedNasabah" @change="updateSaldo()" class="w-full border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 rounded-lg shadow-sm transition-colors" required>
                            <option value="">-- Cari Nama Nasabah --</option>
                            @foreach($nasabah as $n)
                                <option value="{{ $n->id_nasabah }}" data-saldo="{{ $n->saldo }}">
                                    {{ $n->no_rekening }} - {{ $n->nama }}
                                </option>
                            @endforeach
                        </select>
                        <div x-show="selectedNasabah" x-cloak class="mt-2 p-3 bg-blue-50 border border-blue-100 rounded-lg flex justify-between items-center">
                            <span class="text-sm font-medium text-blue-800">Saldo Tersedia:</span>
                            <span class="text-lg font-black text-blue-700">Rp <span x-text="formatRupiah(currentSaldo)"></span></span>
                        </div>
                    </div>

                    <div class="mb-5">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Nominal Penarikan (Rp) <span class="text-red-500">*</span></label>
                        <input type="number" name="nominal" x-model="nominalInput" value="{{ old('nominal') }}" min="100" class="w-full border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 rounded-lg shadow-sm transition-colors text-lg font-bold" required>
                        <p x-show="isNominalExceed" x-cloak class="text-xs text-red-500 mt-1 font-bold">Peringatan: Nominal penarikan melebihi saldo tersedia!</p>
                    </div>

                    <div class="mb-5">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Metode Pencairan <span class="text-red-500">*</span></label>
                        <select name="metode" class="w-full border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 rounded-lg shadow-sm transition-colors" required>
                            <option value="Tunai">Uang Tunai</option>
                            <option value="Transfer Bank">Transfer Bank</option>
                            <option value="E-Wallet (Dana/OVO/GoPay)">E-Wallet (Dana/OVO/GoPay)</option>
                            <option value="Token Listrik">Pulsa / Token Listrik</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>

                    <div class="mb-8">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Keterangan / Catatan Admin</label>
                        <textarea name="keterangan" rows="2" placeholder="Misal: Dicairkan via Dana ke nomor 08123xxx" class="w-full border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 rounded-lg shadow-sm transition-colors">{{ old('keterangan') }}</textarea>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                        <a href="{{ route('penarikan.index') }}" class="text-gray-500 hover:text-gray-700 font-medium px-4 py-2 transition-colors">Batal</a>
                        <button type="submit" :disabled="isNominalExceed || !selectedNasabah || !nominalInput" :class="(isNominalExceed || !selectedNasabah || !nominalInput) ? 'bg-gray-400 cursor-not-allowed' : 'bg-green-600 hover:bg-green-700'" class="text-white font-bold py-2.5 px-6 rounded-lg shadow-md transition-colors focus:outline-none focus:ring-4 focus:ring-green-300">
                            Proses Penarikan
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('penarikanForm', () => ({
                    selectedNasabah: "",
                    currentSaldo: 0,
                    nominalInput: "",

                    get isNominalExceed() {
                        return Number(this.nominalInput) > Number(this.currentSaldo);
                    },

                    updateSaldo() {
                        if (this.selectedNasabah) {
                            const selectElement = document.querySelector('select[name="id_nasabah"]');
                            const selectedOption = selectElement.options[selectElement.selectedIndex];
                            this.currentSaldo = selectedOption.getAttribute('data-saldo');
                        } else {
                            this.currentSaldo = 0;
                        }
                    },

                    formatRupiah(angka) {
                        return new Intl.NumberFormat('id-ID').format(angka);
                    }
                }));
            });
        </script>
    </x-slot>
</x-app-layout>