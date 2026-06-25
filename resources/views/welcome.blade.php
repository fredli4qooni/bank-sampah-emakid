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
    <!-- Registration Section -->
    <section id="pendaftaran-unit" class="py-16 bg-white relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex flex-col lg:flex-row gap-12 items-center">
                <div class="w-full lg:w-1/2">
                    <h2 class="text-3xl font-black text-gray-900 tracking-tight mb-4">Ingin Menjadi Bagian dari Kami?</h2>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        Daftarkan wilayah Anda untuk menjadi Bank Sampah Unit Emak.id. Dengan bergabung, Anda turut berkontribusi dalam menjaga kebersihan lingkungan sekaligus mendapatkan manfaat ekonomi dari sampah daur ulang.
                    </p>
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-start">
                            <div class="flex-shrink-0 w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-green-600 mt-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-bold text-gray-900">Edukasi Gratis</h4>
                                <p class="text-sm text-gray-500">Dapatkan pelatihan gratis mengenai manajemen bank sampah.</p>
                            </div>
                        </li>
                        <li class="flex items-start">
                            <div class="flex-shrink-0 w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-green-600 mt-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-bold text-gray-900">Pendampingan</h4>
                                <p class="text-sm text-gray-500">Kami siap mendampingi operasional awal bank sampah Anda.</p>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="w-full lg:w-1/2">
                    <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100 relative">
                        <div class="absolute -top-4 -right-4 w-20 h-20 bg-green-100 rounded-full blur-2xl opacity-60"></div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-6 relative z-10">Formulir Pendaftaran Calon Unit</h3>
                        
                        @if(session('success'))
                            <div class="mb-6 p-4 rounded-lg bg-green-50 text-green-800 border border-green-200 text-sm font-medium">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('pendaftaran.unit') }}" method="POST" class="relative z-10">
                            @csrf
                            <div class="space-y-5">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">Nama Lengkap</label>
                                    <input type="text" name="nama_lengkap" required class="w-full rounded-xl border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 transition-colors" placeholder="Masukkan nama lengkap">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">No. WA Aktif</label>
                                    <input type="text" name="no_wa" required class="w-full rounded-xl border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 transition-colors" placeholder="Contoh: 08123456789">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">Alamat Lengkap</label>
                                    <textarea name="alamat_lengkap" rows="3" required class="w-full rounded-xl border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 transition-colors" placeholder="Masukkan alamat lengkap wilayah Anda"></textarea>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">Jadwal Edukasi</label>
                                    <input type="date" name="jadwal_edukasi" required class="w-full rounded-xl border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 transition-colors">
                                    <p class="text-xs text-gray-500 mt-1">Pilih tanggal untuk kami melakukan sosialisasi di tempat Anda.</p>
                                </div>
                                <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                                    Kirim Pendaftaran
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="kontak" class="py-16 bg-green-50/50 border-t border-green-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-black text-gray-900 tracking-tight">Hubungi Kami</h2>
                <p class="mt-3 text-gray-500 max-w-2xl mx-auto">Punya pertanyaan lebih lanjut atau ingin bergabung bersama Bank Sampah Emak.id? Jangan ragu untuk menghubungi kami.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- WhatsApp -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-green-100 text-center hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">WhatsApp</h3>
                    <a href="https://wa.me/6281271523334" target="_blank" class="text-green-600 font-bold hover:text-green-700 transition-colors">+62 812-7152-3334</a>
                </div>

                <!-- Instagram -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-green-100 text-center hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Instagram</h3>
                    <a href="https://instagram.com/banksampahemak.id" target="_blank" class="text-green-600 font-bold hover:text-green-700 transition-colors">@banksampahemak.id</a>
                </div>

                <!-- Jam Operasional -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-green-100 text-center hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Jam Operasional</h3>
                    <p class="text-gray-600 text-sm">Senin - Sabtu<br>Pukul 08.30 - 16.30</p>
                </div>

                <!-- Alamat -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-green-100 text-center hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Alamat Kantor</h3>
                    <p class="text-gray-600 text-xs">Perum, Sohibanila, Kec. Natar, Kabupaten Lampung Selatan, Lampung 35111</p>
                </div>
            </div>

            <!-- Lokasi Map -->
            <div class="mt-12 rounded-2xl overflow-hidden shadow-md border border-green-200 bg-white p-2">
                <iframe 
                    src="https://maps.google.com/maps?q=Perum,%20Sohibanila,%20Kec.%20Natar,%20Kabupaten%20Lampung%20Selatan,%20Lampung%2035111&t=&z=15&ie=UTF8&iwloc=&output=embed" 
                    width="100%" 
                    height="400" 
                    class="rounded-xl"
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>

        </div>
    </section>
@endsection

@push('scripts')
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
@endpush