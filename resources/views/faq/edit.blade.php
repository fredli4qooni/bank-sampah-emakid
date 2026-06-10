<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <a href="{{ route('faq.index') }}" class="text-gray-500 hover:text-green-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            </a>
            <h2 class="font-bold text-xl text-green-800 leading-tight">
                {{ __('Edit Konten FAQ') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6 lg:p-8">
                <form action="{{ route('faq.update', $faq->id_faq) }}" method="POST">
                    @csrf @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-1">Pertanyaan <span class="text-red-500">*</span></label>
                            <input type="text" name="pertanyaan" value="{{ old('pertanyaan', $faq->pertanyaan) }}" required class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 shadow-sm">
                            @error('pertanyaan') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-1">Jawaban / Solusi <span class="text-red-500">*</span></label>
                            <textarea name="jawaban" rows="5" required class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 shadow-sm">{{ old('jawaban', $faq->jawaban) }}</textarea>
                            @error('jawaban') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Urutan Tampil <span class="text-red-500">*</span></label>
                            <input type="number" name="urutan" value="{{ old('urutan', $faq->urutan) }}" min="1" required class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 shadow-sm">
                            <p class="text-xs text-gray-500 mt-1">Angka 1 akan tampil paling atas.</p>
                            @error('urutan') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Kategori (Opsional)</label>
                            <input type="text" name="kategori" value="{{ old('kategori', $faq->kategori) }}" class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 shadow-sm">
                            @error('kategori') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-1">Status Publikasi <span class="text-red-500">*</span></label>
                            <select name="status" required class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 shadow-sm">
                                <option value="aktif" {{ $faq->status == 'aktif' ? 'selected' : '' }}>Aktif (Tampilkan di Publik)</option>
                                <option value="nonaktif" {{ $faq->status == 'nonaktif' ? 'selected' : '' }}>Nonaktif (Sembunyikan Sementara)</option>
                            </select>
                            @error('status') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 mt-8 border-t pt-5">
                        <a href="{{ route('faq.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-800 font-bold py-2.5 px-6 rounded-lg transition-colors text-sm">Batal</a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-6 rounded-lg shadow-sm transition-transform transform hover:-translate-y-0.5 text-sm">Update FAQ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>