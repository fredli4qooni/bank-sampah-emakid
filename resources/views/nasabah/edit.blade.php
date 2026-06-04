<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <a href="{{ route('nasabah.index') }}" class="text-gray-500 hover:text-green-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            </a>
            <h2 class="font-bold text-xl text-green-800 leading-tight">
                {{ __('Edit Data Nasabah') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 p-6 lg:p-8">
                
                <form action="{{ route('nasabah.update', $nasabah->id_nasabah) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-5">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Nomor Rekening</label>
                        <input type="text" value="{{ $nasabah->no_rekening }}" class="w-full bg-gray-50 border-gray-200 text-gray-500 rounded-lg shadow-sm cursor-not-allowed" disabled>
                        <p class="text-xs text-gray-400 mt-1">Nomor rekening digenerate otomatis oleh sistem dan tidak dapat diubah.</p>
                    </div>

                    <div class="mb-5">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="nama" value="{{ $nasabah->nama }}" class="w-full border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 rounded-lg shadow-sm transition-colors" required>
                    </div>

                    <div class="mb-5">
                        <label class="block text-gray-700 text-sm font-bold mb-2">No. HP <span class="text-red-500">*</span></label>
                        <input type="text" name="no_hp" value="{{ $nasabah->no_hp }}" class="w-full border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 rounded-lg shadow-sm transition-colors" required>
                    </div>

                    <div class="mb-5">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Kecamatan</label>
                        <input type="text" name="kecamatan" value="{{ $nasabah->kecamatan }}" class="w-full border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 rounded-lg shadow-sm transition-colors">
                    </div>

                    <div class="mb-8">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Alamat Lengkap</label>
                        <textarea name="alamat" rows="3" class="w-full border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 rounded-lg shadow-sm transition-colors">{{ $nasabah->alamat }}</textarea>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                        <a href="{{ route('nasabah.index') }}" class="text-gray-500 hover:text-gray-700 font-medium px-4 py-2 transition-colors">Batal</a>
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2.5 px-6 rounded-lg shadow-md transition-transform transform hover:-translate-y-0.5 focus:outline-none focus:ring-4 focus:ring-green-300">
                            Perbarui Data
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>