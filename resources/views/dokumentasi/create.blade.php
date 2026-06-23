<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <a href="{{ route('dokumentasi.index') }}" class="text-gray-500 hover:text-green-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            </a>
            <h2 class="font-bold text-xl text-green-800 leading-tight">
                {{ __('Tambah Dokumentasi') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8" x-data="{ isSubmitting: false }">
        
        <!-- Loading Bar Overlay -->
        <div x-show="isSubmitting" x-cloak class="fixed top-0 left-0 w-full h-1.5 z-50 bg-green-100 overflow-hidden">
            <div class="h-full bg-green-600 rounded-r-full" style="animation: loading-bar 1.5s infinite ease-in-out;"></div>
        </div>
        <style>
            @keyframes loading-bar {
                0% { width: 0%; transform: translateX(-100%); }
                50% { width: 50%; transform: translateX(0%); }
                100% { width: 100%; transform: translateX(150%); }
            }
        </style>

        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 p-6 lg:p-8">
                
                <form action="{{ route('dokumentasi.store') }}" method="POST" enctype="multipart/form-data" @submit="isSubmitting = true">
                    @csrf
                    
                    <div class="mb-5">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Judul / Nama Kegiatan <span class="text-red-500">*</span></label>
                        <input type="text" name="judul" value="{{ old('judul') }}" class="w-full border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 rounded-lg shadow-sm transition-colors" required>
                        @error('judul') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-5">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Deskripsi Kegiatan</label>
                        <textarea name="deskripsi" rows="4" class="w-full border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 rounded-lg shadow-sm transition-colors">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-8">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Foto Dokumentasi <span class="text-red-500">*</span></label>
                        <input type="file" name="foto" accept="image/*" class="w-full border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 rounded-lg shadow-sm transition-colors p-2 border border-dashed bg-gray-50" required>
                        <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, WEBP. Maksimal ukuran: 15MB (Akan otomatis dikonversi ke WebP untuk performa).</p>
                        @error('foto') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                        <a href="{{ route('dokumentasi.index') }}" class="text-gray-500 hover:text-gray-700 font-medium px-4 py-2 transition-colors" x-bind:class="{ 'opacity-50 pointer-events-none': isSubmitting }">Batal</a>
                        <button type="submit" x-bind:disabled="isSubmitting" class="relative bg-green-600 hover:bg-green-700 text-white font-bold py-2.5 px-6 rounded-lg shadow-md transition-transform transform hover:-translate-y-0.5 focus:outline-none focus:ring-4 focus:ring-green-300 disabled:opacity-70 disabled:cursor-not-allowed">
                            <span x-show="!isSubmitting">Simpan Dokumentasi</span>
                            <span x-show="isSubmitting" x-cloak>Sedang Mengunggah...</span>
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
