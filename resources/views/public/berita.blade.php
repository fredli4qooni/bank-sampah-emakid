@extends('layouts.public')

@section('title', 'Berita & Edukasi - Bank Sampah Emak.id')

@section('content')
    <section class="bg-green-700 py-16 relative overflow-hidden">
        <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 20px 20px;"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <h1 class="text-4xl md:text-5xl font-black text-white mb-4">Berita & Edukasi</h1>
            <p class="text-xl text-green-100 max-w-2xl mx-auto">Ikuti terus perkembangan terbaru dan tips menarik seputar pengelolaan lingkungan.</p>
        </div>
    </section>

    <section class="py-16 bg-white min-h-[500px]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                
                @forelse($berita as $item)
                    <article class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-shadow group flex flex-col">
                        <div class="h-48 bg-gray-200 overflow-hidden relative">
                            <div class="absolute inset-0 bg-green-900 opacity-10 group-hover:opacity-0 transition-opacity z-10"></div>
                            <img src="{{ $item['urlToImage'] ?? 'https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80' }}" 
                                 alt="{{ $item['title'] }}" 
                                 class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500">
                        </div>
                        <div class="p-6 flex flex-col flex-grow">
                            <div class="flex items-center text-xs text-gray-500 mb-3 gap-4">
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg> 
                                    {{ \Carbon\Carbon::parse($item['publishedAt'])->translatedFormat('d M Y') }}
                                </span>
                                <span class="flex items-center gap-1 text-green-600 font-bold truncate">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg> 
                                    {{ $item['source']['name'] ?? 'Media' }}
                                </span>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-green-600 transition-colors line-clamp-2">
                                {{ $item['title'] }}
                            </h3>
                            <p class="text-gray-600 text-sm leading-relaxed mb-4 line-clamp-3 flex-grow">
                                {{ $item['description'] ?? 'Deskripsi berita tidak tersedia dari sumber.' }}
                            </p>
                            <a href="{{ $item['url'] }}" target="_blank" rel="noopener noreferrer" class="text-green-600 font-bold text-sm hover:underline mt-auto inline-flex items-center gap-1">
                                Baca di Sumber Asli &rarr;
                            </a>
                        </div>
                    </article>
                @empty
                    <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-20 bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200">
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15M9 11l3 3m0 0l3-3m-3 3V8"></path></svg>
                        <h3 class="text-xl font-bold text-gray-700 mb-2">Gagal Memuat Berita</h3>
                        <p class="text-gray-500">Pastikan koneksi internet Anda aktif atau periksa limit API Key Anda.</p>
                    </div>
                @endforelse

            </div>
        </div>
    </section>
@endsection