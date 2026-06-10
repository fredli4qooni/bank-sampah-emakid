<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-green-800 leading-tight">
            {{ __('Edit Unit: ') }} {{ $unit->nama_unit }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 overflow-hidden">
                <form action="{{ route('units.update', $unit->id_unit) }}" method="POST" class="p-6">
                    @csrf @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Nama Unit/Kelompok <span class="text-red-500">*</span></label>
                            <input type="text" name="nama_unit" value="{{ old('nama_unit', $unit->nama_unit) }}" required class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 shadow-sm">
                            @error('nama_unit') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Kecamatan <span class="text-red-500">*</span></label>
                            <input type="text" name="kecamatan" value="{{ old('kecamatan', $unit->kecamatan) }}" required class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 shadow-sm">
                            @error('kecamatan') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Nama Ketua</label>
                            <input type="text" name="nama_ketua" value="{{ old('nama_ketua', $unit->nama_ketua) }}" class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 shadow-sm">
                            @error('nama_ketua') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">No. HP Ketua</label>
                            <input type="text" name="no_hp_ketua" value="{{ old('no_hp_ketua', $unit->no_hp_ketua) }}" class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 shadow-sm">
                            @error('no_hp_ketua') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Tanggal Daftar <span class="text-red-500">*</span></label>
                            <input type="date" name="tanggal_daftar" value="{{ old('tanggal_daftar', $unit->tanggal_daftar) }}" required class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 shadow-sm">
                            @error('tanggal_daftar') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Status <span class="text-red-500">*</span></label>
                            <select name="status" required class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 shadow-sm">
                                <option value="aktif" {{ $unit->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="nonaktif" {{ $unit->status == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                            @error('status') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 mt-8 border-t pt-5">
                        <a href="{{ route('units.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-800 font-bold py-2 px-4 rounded-lg transition-colors text-sm">Batal</a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-sm transition-colors text-sm">Update Unit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>