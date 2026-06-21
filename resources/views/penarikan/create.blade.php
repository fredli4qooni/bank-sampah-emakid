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
                <form action="{{ route('penarikan.store') }}" method="POST" enctype="multipart/form-data" onsubmit="return confirm('Apakah data pencairan sudah benar? Saldo nasabah akan langsung terpotong.')">
                    @csrf
                    
                    <div class="mb-5">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Pilih Nasabah <span class="text-red-500">*</span></label>
                        <select id="select-nasabah" name="id_nasabah" x-model="selectedNasabah" @change="updateSaldo()" class="w-full border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 rounded-lg shadow-sm transition-colors" required>
                            <option value="">-- Cari / Ketik Nama Nasabah --</option>
                            @foreach($nasabah as $n)
                                <option value="{{ $n->id_nasabah }}" data-saldo="{{ $n->saldo }}">
                                    {{ $n->nama }} ({{ $n->unit->nama_unit ?? 'Tanpa Unit' }})
                                </option>
                            @endforeach
                        </select>
                        <div x-show="selectedNasabah" x-cloak class="mt-2 p-3 bg-blue-50 border border-blue-100 rounded-lg flex justify-between items-center">
                            <span class="text-sm font-medium text-blue-800">Saldo Tersedia:</span>
                            <span class="text-lg font-black text-blue-700">Rp <span x-text="formatRupiah(currentSaldo)"></span></span>
                        </div>
                    </div>

                    <div class="mb-5 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Nominal Penarikan (Rp) <span class="text-red-500">*</span></label>
                            <input type="number" name="nominal" x-model="nominalInput" value="{{ old('nominal') }}" min="100" class="w-full border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 rounded-lg shadow-sm transition-colors text-lg font-bold" required>
                            <p x-show="isNominalExceed" x-cloak class="text-xs text-red-500 mt-1 font-bold">Peringatan: Nominal penarikan melebihi saldo tersedia!</p>
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Biaya Admin (Rp)</label>
                            <input type="number" name="biaya_admin" value="{{ old('biaya_admin', 0) }}" min="0" class="w-full border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 rounded-lg shadow-sm transition-colors text-lg font-bold">
                            <p class="text-xs text-gray-500 mt-1">Diisi manual untuk mencatat biaya transfer antar bank. Biaya saat ini ditanggung Bank Sampah Emak.id (tidak memotong saldo nasabah).</p>
                        </div>
                    </div>

                    <div class="mb-5">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Metode Pencairan <span class="text-red-500">*</span></label>
                        <select name="metode" x-model="metodeInput" class="w-full border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 rounded-lg shadow-sm transition-colors" required>
                            <option value="Tunai">Uang Tunai</option>
                            <option value="Transfer Bank">Transfer Bank</option>
                            <option value="E-Wallet (Dana/OVO/GoPay)">E-Wallet (Dana/OVO/GoPay)</option>
                            <option value="Token Listrik">Pulsa / Token Listrik</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>

                    <div x-show="metodeInput === 'Token Listrik'" x-cloak class="mb-5 bg-yellow-50 p-4 rounded-xl border border-yellow-200 animate-fade-in-down">
                        <label class="block text-yellow-800 text-sm font-bold mb-2">Nomor Token / Struk (20 Digit) <span class="text-red-500">*</span></label>
                        <input type="text" name="nomor_token" value="{{ old('nomor_token') }}" class="w-full border-yellow-300 focus:border-yellow-500 focus:ring focus:ring-yellow-200 rounded-lg shadow-sm font-mono tracking-widest text-lg" placeholder="0000-0000-0000-0000-0000">
                        <p class="text-xs text-yellow-600 mt-1">Masukkan kode token listrik di sini agar tersimpan dan bisa dicetak untuk nasabah.</p>
                    </div>

                    <div x-show="metodeInput === 'Transfer Bank' || metodeInput === 'E-Wallet (Dana/OVO/GoPay)'" x-cloak class="mb-5 bg-blue-50 p-4 rounded-xl border border-blue-200 animate-fade-in-down">
                        <label class="block text-blue-800 text-sm font-bold mb-2">Upload Bukti Transfer <span class="text-blue-500 text-xs font-normal">(Opsional)</span></label>
                        <input type="file" name="bukti_transfer" accept="image/*" class="w-full border-blue-300 focus:border-blue-500 focus:ring focus:ring-blue-200 rounded-lg shadow-sm bg-white p-2">
                        <p class="text-xs text-blue-600 mt-1">Anda dapat mengunggah *screenshot* atau foto bukti transfer ke rekening/ewallet nasabah.</p>
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
        <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                new TomSelect("#select-nasabah", {
                    create: false,
                    sortField: {
                        field: "text",
                        direction: "asc"
                    },
                    onChange: function(value) {
                        const selectElement = document.getElementById('select-nasabah');
                        selectElement.dispatchEvent(new Event('change', { bubbles: true }));
                    }
                });
            });

            document.addEventListener('alpine:init', () => {
                Alpine.data('penarikanForm', () => ({
                    selectedNasabah: "",
                    currentSaldo: 0,
                    nominalInput: "",
                    metodeInput: "Tunai",

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
        <style>
            .animate-fade-in-down {
                animation: fadeInDown 0.3s ease-out;
            }
            @keyframes fadeInDown {
                0% { opacity: 0; transform: translateY(-10px); }
                100% { opacity: 1; transform: translateY(0); }
            }
        </style>
    </x-slot>
</x-app-layout>