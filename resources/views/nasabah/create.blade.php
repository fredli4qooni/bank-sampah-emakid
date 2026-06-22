<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <a href="{{ route('nasabah.index') }}" class="text-gray-500 hover:text-green-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            </a>
            <h2 class="font-bold text-xl text-green-800 leading-tight">
                {{ __('Tambah Nasabah Baru') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 p-6 lg:p-8">
                
                <form action="{{ route('nasabah.store') }}" method="POST" x-data="nasabahForm()">
                    @csrf
                    
                    <div class="mb-5">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="nama" value="{{ old('nama') }}" class="capitalize w-full border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 rounded-lg shadow-sm transition-colors" required>
                        @error('nama') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-5">
                        <label class="block text-gray-700 text-sm font-bold mb-2">No. HP <span class="text-red-500">*</span></label>
                        <input type="text" name="no_hp" value="{{ old('no_hp', '62') }}" placeholder="62812..." class="w-full border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 rounded-lg shadow-sm transition-colors" required>
                        @error('no_hp') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-5">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Kecamatan <span class="text-red-500">*</span></label>
                        <select name="kecamatan" x-model="selectedKecamatan" @change="filterUnits()" class="w-full border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 rounded-lg shadow-sm transition-colors" required>
                            <option value="">-- Pilih Kecamatan --</option>
                            @foreach($units->pluck('kecamatan')->unique()->filter()->sort() as $kec)
                                <option value="{{ $kec }}">{{ $kec }}</option>
                            @endforeach
                        </select>
                        @error('kecamatan') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-5">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Unit / Kelompok <span class="text-red-500">*</span></label>
                        <select name="id_unit" x-model="selectedUnit" class="w-full border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 rounded-lg shadow-sm transition-colors bg-gray-50" :disabled="filteredUnits.length === 0" required>
                            <option value="">-- Pilih Unit / Kelompok --</option>
                            <template x-for="unit in filteredUnits" :key="unit.id_unit">
                                <option :value="unit.id_unit" x-text="unit.nama_unit" :selected="selectedUnit == unit.id_unit"></option>
                            </template>
                        </select>
                        <p x-show="selectedKecamatan && filteredUnits.length === 0" class="text-xs text-red-500 mt-1 italic" style="display: none;">Belum ada Unit aktif di kecamatan ini. Tambahkan di menu Data Unit.</p>
                        @error('id_unit') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-8">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Alamat Lengkap</label>
                        <textarea name="alamat" rows="3" class="w-full border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 rounded-lg shadow-sm transition-colors">{{ old('alamat') }}</textarea>
                        @error('alamat') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                        <a href="{{ route('nasabah.index') }}" class="text-gray-500 hover:text-gray-700 font-medium px-4 py-2 transition-colors">Batal</a>
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2.5 px-6 rounded-lg shadow-md transition-transform transform hover:-translate-y-0.5 focus:outline-none focus:ring-4 focus:ring-green-300">
                            Simpan Data
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('nasabahForm', () => ({
                    selectedKecamatan: "{{ old('kecamatan') }}",
                    selectedUnit: "{{ old('id_unit') }}",
                    allUnits: JSON.parse('{!! json_encode($units ?? []) !!}'),
                    filteredUnits: [],

                    init() {
                        this.filterUnits();
                    },

                    filterUnits() {
                        if (this.selectedKecamatan) {
                            this.filteredUnits = this.allUnits.filter(u => u.kecamatan === this.selectedKecamatan);
                            
                            const unitExists = this.filteredUnits.find(u => u.id_unit == this.selectedUnit);
                            if (!unitExists) {
                                this.selectedUnit = '';
                            }
                        } else {
                            this.filteredUnits = [];
                            this.selectedUnit = '';
                        }
                    }
                }));
            });
        </script>
    </x-slot>
</x-app-layout>