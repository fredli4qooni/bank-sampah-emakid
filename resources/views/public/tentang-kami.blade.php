@extends('layouts.public')

@section('title', 'Tentang Kami - Bank Sampah Emak.id')

@section('content')
    <!-- Hero Section -->
    <section class="bg-gradient-to-b from-green-50 to-white pt-24 pb-16 relative overflow-hidden">
        <!-- Organic Blobs -->
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 bg-green-200 rounded-full mix-blend-multiply filter blur-3xl opacity-50"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 bg-emerald-200 rounded-full mix-blend-multiply filter blur-3xl opacity-50"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <h1 class="text-4xl md:text-6xl font-black text-green-900 mb-6 tracking-tight">Menjaga Bumi, <br class="hidden md:block"/>Memberdayakan Sesama.</h1>
            <p class="text-lg md:text-xl text-green-700 max-w-2xl mx-auto leading-relaxed">
                Cerita kami bukan sekadar tentang mengumpulkan sampah, tapi tentang merawat lingkungan tempat anak-anak kita tumbuh kelak.
            </p>
        </div>
    </section>

    <!-- Cerita Kami -->
    <section class="py-16 bg-white relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-16 items-center">
                <!-- Text Content -->
                <div class="lg:w-1/2">
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-green-100 text-green-800 text-sm font-bold mb-6">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path></svg>
                        Awal Mula Perjalanan
                    </div>
                    <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-6 leading-tight">Berawal dari Kepedulian Sederhana Ibu Rumah Tangga</h2>
                    <div class="space-y-5 text-gray-600 text-lg leading-relaxed">
                        <p>
                            Semuanya bermula dari obrolan ringan ibu-ibu di sore hari tentang selokan yang sering mampet dan bau sampah yang mengganggu. Apa yang awalnya hanya inisiatif kerja bakti akhir pekan, perlahan tumbuh menjadi gerakan yang lebih besar.
                        </p>
                        <p>
                            Kami sadar, menyapu saja tidak cukup. Sampah yang dibuang begitu saja punya nilai jika kita tahu cara memilahnya. Dari sanalah lahir ide membangun ekosistem di mana setiap botol plastik atau kardus bekas bisa disulap menjadi pundi-pundi tabungan untuk kebutuhan dapur dan sekolah anak.
                        </p>
                    </div>
                </div>

                <!-- Organic Card -->
                <div class="lg:w-1/2 w-full relative">
                    <div class="absolute inset-0 bg-gradient-to-tr from-green-300 to-emerald-100 rounded-[3rem] transform rotate-3 scale-105 opacity-50 z-0"></div>
                    <div class="bg-white p-10 md:p-12 rounded-[2.5rem] shadow-xl relative z-10 border border-green-50">
                        <svg class="w-12 h-12 text-green-500 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Mengapa "Emak.id"?</h3>
                        <p class="text-gray-600 leading-relaxed text-lg italic">
                            "Kata 'Emak' mewakili sosok ibu yang telaten merawat keluarga. Kami meminjam semangat ketelatenan itu untuk merawat bumi tempat kita berpijak. Sedangkan '.id' adalah komitmen kami untuk membawa bank sampah ini selangkah lebih maju ke era digital yang transparan dan mudah diakses siapa saja."
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Visi & Misi -->
    <section class="py-24 bg-green-50 relative overflow-hidden">
        <!-- Background Decor -->
        <svg class="absolute top-0 right-0 text-green-100 w-96 h-96 transform translate-x-1/3 -translate-y-1/3" fill="currentColor" viewBox="0 0 100 100"><circle cx="50" cy="50" r="50"></circle></svg>
        <svg class="absolute bottom-0 left-0 text-green-200 w-64 h-64 transform -translate-x-1/3 translate-y-1/3" fill="currentColor" viewBox="0 0 100 100"><circle cx="50" cy="50" r="50"></circle></svg>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-extrabold text-green-900 mb-4">Langkah Bersama Kami</h2>
                <p class="text-green-700 text-lg max-w-2xl mx-auto">Mimpi besar kami untuk lingkungan dan masyarakat tertuang dalam Visi dan Misi berikut.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12">
                <!-- Visi -->
                <div class="bg-white p-10 rounded-[3rem] shadow-sm border border-green-100 hover:shadow-lg transition-shadow duration-300 group">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-6 group-hover:bg-green-500 transition-colors duration-300">
                        <svg class="w-8 h-8 text-green-600 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                    </div>
                    <h3 class="text-2xl font-black text-gray-900 mb-4">Mimpi Kami (Visi)</h3>
                    <p class="text-gray-600 text-lg leading-relaxed">
                        Mewujudkan lingkungan yang bersih, asri, dan lestari melalui pengelolaan sampah rumah tangga yang mandiri. Sekaligus membangun kekuatan ekonomi sirkular yang memberikan senyum kesejahteraan bagi masyarakat sekitar.
                    </p>
                </div>

                <!-- Misi -->
                <div class="bg-white p-10 rounded-[3rem] shadow-sm border border-green-100 hover:shadow-lg transition-shadow duration-300 group">
                    <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mb-6 group-hover:bg-emerald-500 transition-colors duration-300">
                        <svg class="w-8 h-8 text-emerald-600 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <h3 class="text-2xl font-black text-gray-900 mb-6">Tindakan Nyata (Misi)</h3>
                    <ul class="space-y-4">
                        <li class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-emerald-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span class="text-gray-600 text-lg">Mengajak dan mengedukasi warga memilah sampah dari dapur tangga.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-emerald-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span class="text-gray-600 text-lg">Menyediakan platform digital pencatatan tabungan yang jujur dan gampang diakses.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-emerald-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span class="text-gray-600 text-lg">Mengubah stigma "sampah itu kotor" menjadi "sampah itu rezeki yang tercecer".</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-emerald-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span class="text-gray-600 text-lg">Menggandeng pengepul lokal untuk memutar roda ekonomi sirkular bersama.</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
@endsection