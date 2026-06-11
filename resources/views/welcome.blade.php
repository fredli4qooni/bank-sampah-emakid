@extends('layouts.public')

@section('title', 'Bank Sampah Emak.id - Ubah Sampah Jadi Berkah')

@section('content')
    <section class="pb-20 pt-10 lg:pb-28 lg:pt-16 overflow-hidden relative">
        <div class="absolute inset-0 z-0 opacity-10" style="background-image: radial-gradient(#22c55e 1px, transparent 1px); background-size: 20px 20px;"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

                <div class="text-center lg:text-left pt-10">
                    <span class="bg-green-100 text-green-800 font-bold px-4 py-1.5 rounded-full text-sm tracking-wide uppercase shadow-sm border border-green-200 mb-6 inline-block animate-pulse">Platform Digital Bank Sampah</span>
                    <h1 class="text-5xl md:text-6xl font-black text-gray-900 leading-tight mb-6 tracking-tight">
                        Ubah Sampah Lingkungan <br class="hidden md:block" />
                        Menjadi <span class="text-transparent bg-clip-text bg-gradient-to-r from-green-500 to-green-700">Berkah Ekonomi</span>
                    </h1>
                    <p class="mt-4 text-xl text-gray-600 max-w-2xl mx-auto lg:mx-0 mb-10 leading-relaxed">
                        Bergabunglah bersama kami menjaga kebersihan lingkungan sekaligus mendapatkan penghasilan tambahan melalui sistem tabungan sampah digital yang transparan dan terpercaya.
                    </p>
                    <div class="flex flex-col sm:flex-row justify-center lg:justify-start gap-4">
                        <a href="{{ route('program') }}" class="bg-green-600 text-white font-bold px-8 py-3.5 rounded-full shadow-md hover:bg-green-700 hover:shadow-lg transition-all transform hover:-translate-y-1 text-center">Mulai Menabung</a>
                        <a href="#faq" class="bg-white text-green-700 font-bold px-8 py-3.5 rounded-full shadow-md border border-green-100 hover:bg-gray-50 transition-all text-center">Pelajari Lebih Lanjut</a>
                    </div>
                </div>

                <div class="relative hidden lg:block pt-10">
                    <img src="{{ asset('images/ilustrasi-hero.png') }}"
                        alt="Ilustrasi Bank Sampah Emak ID"
                        class="w-full h-auto drop-shadow-2xl transform hover:-translate-y-2 transition duration-500">

                    <div class="absolute -z-10 bg-green-300 rounded-full blur-3xl opacity-30 w-72 h-72 top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2"></div>
                </div>

            </div>
        </div>
    </section>

    <section class="py-16 bg-green-50/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-green-100 text-center hover:shadow-md transition-shadow">
                    <div class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Tabungan Transparan</h3>
                    <p class="text-gray-600">Pantau saldo dan riwayat setoran sampah Anda dengan akurasi terjamin yang dikelola secara profesional.</p>
                </div>
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-green-100 text-center hover:shadow-md transition-shadow">
                    <div class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Peduli Lingkungan</h3>
                    <p class="text-gray-600">Turut berkontribusi langsung dalam mengurangi penumpukan limbah dan menjaga bumi tetap hijau.</p>
                </div>
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-green-100 text-center hover:shadow-md transition-shadow">
                    <div class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Pemberdayaan Warga</h3>
                    <p class="text-gray-600">Bergabung dengan komunitas lokal untuk membangun kemandirian dan kekuatan ekonomi bersama.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="faq" class="py-20 bg-white">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-black text-gray-900 tracking-tight">Pertanyaan yang Sering Diajukan (FAQ)</h2>
                <p class="mt-3 text-gray-500">Temukan panduan dan informasi lengkap tentang layanan Bank Sampah Emak.id.</p>
            </div>

            <div class="space-y-4">
                @forelse($faqs as $faq)
                <div x-data="{ expanded: false }" class="border border-gray-200 rounded-xl bg-white shadow-sm overflow-hidden transition-all hover:border-green-300">
                    <button @click="expanded = ! expanded" class="w-full text-left px-6 py-4 flex justify-between items-center focus:outline-none">
                        <span class="font-bold text-gray-800 text-lg pr-4">{{ $faq->pertanyaan }}</span>
                        <svg class="w-6 h-6 text-green-500 transform transition-transform duration-200 flex-shrink-0" :class="{'rotate-180': expanded}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="expanded" x-collapse x-cloak>
                        <div class="px-6 pb-5 pt-1 text-gray-600 leading-relaxed border-t border-gray-50 mt-2">
                            {!! nl2br(e($faq->jawaban)) !!}
                        </div>
                        @if($faq->kategori)
                        <div class="px-6 pb-4">
                            <span class="text-xs font-bold text-green-600 bg-green-50 px-2.5 py-1 rounded-md">{{ $faq->kategori }}</span>
                        </div>
                        @endif
                    </div>
                </div>
                @empty
                <div class="text-center p-8 bg-gray-50 rounded-xl border border-dashed border-gray-300 text-gray-500 italic">
                    Belum ada informasi FAQ yang dipublikasikan saat ini.
                </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
@endpush