<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <a href="{{ route('jenis-sampah.index') }}" class="text-gray-500 hover:text-green-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            </a>
            <h2 class="font-bold text-xl text-green-800 leading-tight">
                {{ __('Tambah Jenis Sampah') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 p-6 lg:p-8">
                
                <form action="{{ route('jenis-sampah.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-5">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Nama Jenis Sampah <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_sampah" class="w-full border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 rounded-lg shadow-sm transition-colors" placeholder="Contoh: Plastik Bening" required>
                        @error('nama_sampah') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-5">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Satuan <span class="text-red-500">*</span></label>
                        <select name="satuan" class="w-full border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 rounded-lg shadow-sm transition-colors" required>
                            <option value="kg">Kilogram (kg)</option>
                            <option value="liter">Liter (ltr)</option>
                        </select>
                        @error('satuan') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-8">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Harga per Satuan (Rp) <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 font-bold sm:text-sm">Rp</span>
                            </div>
                            <input type="number" name="harga_per_kg" step="0.01" min="0" class="w-full pl-10 border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 rounded-lg shadow-sm transition-colors" placeholder="0" required>
                        </div>
                        @error('harga_per_kg') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                        <a href="{{ route('jenis-sampah.index') }}" class="text-gray-500 hover:text-gray-700 font-medium px-4 py-2 transition-colors">Batal</a>
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2.5 px-6 rounded-lg shadow-md transition-transform transform hover:-translate-y-0.5 focus:outline-none focus:ring-4 focus:ring-green-300">
                            Simpan Data
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>