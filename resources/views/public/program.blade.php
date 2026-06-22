@extends('layouts.public')

@section('title', 'Program Kami - Bank Sampah Emak.id')

@section('content')
    <!-- Hero Section -->
    <section class="bg-gradient-to-b from-green-50 to-white pt-24 pb-16 relative overflow-hidden">
        <!-- Organic Blobs -->
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 bg-green-200 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-pulse"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 bg-emerald-200 rounded-full mix-blend-multiply filter blur-3xl opacity-50"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <h1 class="text-4xl md:text-6xl font-black text-green-900 mb-6 tracking-tight">Program & <br class="hidden md:block"/>Inisiatif Kami</h1>
            <p class="text-lg md:text-xl text-green-700 max-w-2xl mx-auto leading-relaxed">
                Kami merancang berbagai cara mudah dan menyenangkan agar Anda dapat ikut serta menyulap "sampah" menjadi "berkah" yang bermanfaat.
            </p>
        </div>
    </section>

    <!-- Program Cards -->
    <section class="py-16 bg-white relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 md:gap-12">
                
                <!-- Card 1: Tabungan Reguler -->
                <div class="bg-white rounded-[3rem] p-10 shadow-sm border border-green-100 relative group hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                    <!-- Soft Blob Background for Icon -->
                    <div class="absolute top-8 right-8 w-24 h-24 bg-green-50 rounded-full group-hover:scale-110 transition-transform duration-500 z-0"></div>
                    
                    <div class="relative z-10 mb-8 mt-2">
                        <div class="w-16 h-16 bg-green-100 text-green-600 rounded-2xl flex items-center justify-center transform rotate-3 group-hover:-rotate-3 transition-transform duration-300 shadow-sm">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                    
                    <div class="relative z-10">
                        <span class="inline-block bg-green-100 text-green-800 text-xs font-bold px-4 py-1.5 rounded-full uppercase tracking-wider mb-4">Ekonomi Pintar</span>
                        <h3 class="text-2xl font-black text-gray-900 mb-4">Tabungan Reguler</h3>
                        <p class="text-gray-600 leading-relaxed text-lg">
                            Pilah sampah Anda (plastik, kertas, logam) dari rumah, serahkan ke kami, dan saksikan ia berubah menjadi pundi-pundi rupiah di buku tabungan Anda. Saldo bisa dicairkan kapan saja untuk kebutuhan keluarga!
                        </p>
                    </div>
                </div>

                <!-- Card 2: Sedekah Sampah -->
                <div class="bg-white rounded-[3rem] p-10 shadow-sm border border-blue-100 relative group hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 mt-0 md:mt-12">
                    <div class="absolute top-8 right-8 w-24 h-24 bg-blue-50 rounded-full group-hover:scale-110 transition-transform duration-500 z-0"></div>
                    
                    <div class="relative z-10 mb-8 mt-2">
                        <div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center transform -rotate-3 group-hover:rotate-3 transition-transform duration-300 shadow-sm">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                        </div>
                    </div>
                    
                    <div class="relative z-10">
                        <span class="inline-block bg-blue-100 text-blue-800 text-xs font-bold px-4 py-1.5 rounded-full uppercase tracking-wider mb-4">Aksi Sosial</span>
                        <h3 class="text-2xl font-black text-gray-900 mb-4">Sedekah Sampah</h3>
                        <p class="text-gray-600 leading-relaxed text-lg">
                            Punya sampah botol tapi enggan menabung? Sedekahkan saja ke kami. Seluruh hasil penjualan dari sampah titipan Anda akan kami salurkan penuh untuk menyantuni anak yatim dan dhuafa di lingkungan kita.
                        </p>
                    </div>
                </div>

                <!-- Card 3: Kelas Daur Ulang -->
                <div class="bg-white rounded-[3rem] p-10 shadow-sm border border-yellow-100 relative group hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 mt-0 md:mt-24">
                    <div class="absolute top-8 right-8 w-24 h-24 bg-yellow-50 rounded-full group-hover:scale-110 transition-transform duration-500 z-0"></div>
                    
                    <div class="relative z-10 mb-8 mt-2">
                        <div class="w-16 h-16 bg-yellow-100 text-yellow-600 rounded-2xl flex items-center justify-center transform rotate-3 group-hover:-rotate-3 transition-transform duration-300 shadow-sm">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                    </div>
                    
                    <div class="relative z-10">
                        <span class="inline-block bg-yellow-100 text-yellow-800 text-xs font-bold px-4 py-1.5 rounded-full uppercase tracking-wider mb-4">Pemberdayaan</span>
                        <h3 class="text-2xl font-black text-gray-900 mb-4">Kelas Kreatif</h3>
                        <p class="text-gray-600 leading-relaxed text-lg">
                            Mari belajar bersama! Kami rutin menggelar kelas santai untuk ibu-ibu menyulap sampah anorganik (seperti bungkus kopi atau kain perca) menjadi aneka kerajinan tangan cantik yang laku dijual.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-20 bg-green-50 relative overflow-hidden">
        <div class="absolute right-0 bottom-0 w-64 h-64 bg-green-200 rounded-full mix-blend-multiply filter blur-3xl opacity-50 transform translate-x-1/2 translate-y-1/2"></div>
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <h2 class="text-3xl md:text-4xl font-extrabold text-green-900 mb-6">Tertarik Mengikuti Salah Satu Program Kami?</h2>
            <p class="text-green-800 text-lg mb-10">Tidak perlu ragu. Pintu kami selalu terbuka lebar untuk siapapun yang ingin berkontribusi bagi lingkungan dan menebar kebaikan.</p>
            <a href="/#kontak" class="inline-flex items-center justify-center px-8 py-4 border border-transparent text-lg font-bold rounded-full text-white bg-green-600 hover:bg-green-700 shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all">
                Hubungi Kami Sekarang
            </a>
        </div>
    </section>
@endsection