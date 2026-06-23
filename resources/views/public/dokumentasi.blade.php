@extends('layouts.public')

@section('title', 'Dokumentasi Kegiatan - Bank Sampah Emak.id')

@section('content')
<div class="bg-green-50/30 py-16 sm:py-24">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="bg-green-100 text-green-800 font-bold px-4 py-1.5 rounded-full text-sm tracking-wide uppercase shadow-sm border border-green-200 mb-6 inline-block">Galeri Kegiatan</span>
            <h2 class="text-4xl font-black tracking-tight text-gray-900 sm:text-5xl mb-6">
                Dokumentasi <span class="text-transparent bg-clip-text bg-gradient-to-r from-green-600 to-green-800">Emak.id</span>
            </h2>
            <p class="text-xl text-gray-600 leading-relaxed">
                Melihat lebih dekat berbagai aksi nyata, program edukasi, dan partisipasi masyarakat dalam mewujudkan lingkungan yang bersih dan bernilai ekonomi.
            </p>
        </div>

        @if($dokumentasi->isEmpty())
            <div class="text-center py-20 bg-white rounded-3xl shadow-sm border border-green-100">
                <svg class="mx-auto h-16 w-16 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <h3 class="mt-4 text-lg font-bold text-gray-900">Belum Ada Dokumentasi</h3>
                <p class="mt-2 text-gray-500">Galeri foto kegiatan sedang dalam proses pembaruan oleh admin kami.</p>
            </div>
        @else
            <!-- Grid Gallery -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($dokumentasi as $doc)
                <div class="group relative bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 flex flex-col h-full cursor-pointer" x-data="{ openModal: false }">
                    
                    <div class="aspect-w-4 aspect-h-3 bg-gray-200 overflow-hidden" @click="openModal = true">
                        <img src="{{ asset('storage/' . $doc->foto) }}" alt="{{ $doc->judul }}" class="object-cover w-full h-full transform group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-300 flex items-center justify-center">
                            <svg class="w-10 h-10 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/></svg>
                        </div>
                    </div>
                    
                    <div class="p-6 flex-grow flex flex-col justify-between bg-white z-10" @click="openModal = true">
                        <div>
                            <div class="flex items-center text-xs text-green-600 font-bold mb-3 uppercase tracking-wider">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                {{ $doc->created_at->translatedFormat('d F Y') }}
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 group-hover:text-green-700 transition-colors line-clamp-2 mb-3">
                                {{ $doc->judul }}
                            </h3>
                        </div>
                        @if($doc->deskripsi)
                            <p class="text-gray-600 text-sm line-clamp-3 leading-relaxed">
                                {{ $doc->deskripsi }}
                            </p>
                        @endif
                    </div>

                    <!-- Modal / Lightbox Component -->
                    <div x-show="openModal" 
                         style="display: none;" 
                         class="fixed inset-0 z-[100] flex items-center justify-center overflow-hidden bg-black bg-opacity-90 backdrop-blur-sm p-4 sm:p-8"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0">
                        
                        <div class="relative w-full max-w-5xl max-h-full flex flex-col justify-center items-center" @click.away="openModal = false">
                            <button @click="openModal = false" class="absolute top-0 right-0 sm:-top-8 sm:-right-8 text-white hover:text-green-400 focus:outline-none transition-colors z-[110] bg-black bg-opacity-50 p-2 rounded-full sm:bg-transparent">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                            
                            <img src="{{ asset('storage/' . $doc->foto) }}" alt="{{ $doc->judul }}" class="max-h-[75vh] w-auto object-contain rounded-lg shadow-2xl" @click.stop>
                            
                            <div class="w-full bg-black bg-opacity-70 p-6 text-left mt-4 rounded-xl border border-gray-800" @click.stop>
                                <h3 class="text-2xl font-bold text-white mb-2">{{ $doc->judul }}</h3>
                                <p class="text-green-400 text-sm font-semibold mb-3">{{ $doc->created_at->translatedFormat('d F Y') }}</p>
                                @if($doc->deskripsi)
                                    <p class="text-gray-300">{{ $doc->deskripsi }}</p>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-16 flex justify-center">
                {{ $dokumentasi->links() }}
            </div>
        @endif

    </div>
</div>

@push('scripts')
<!-- Add Alpine.js for modal logic if not globally loaded. In this layout, it's usually globally loaded via app.js -->
<style>
    /* Aspect ratio fallback if tailwind aspect-ratio plugin isn't active */
    .aspect-w-4 {
        position: relative;
        padding-bottom: 75%; /* 4:3 */
    }
    .aspect-w-4 > img {
        position: absolute;
        height: 100%;
        width: 100%;
        left: 0;
        top: 0;
        right: 0;
        bottom: 0;
    }
</style>
@endpush

@endsection
