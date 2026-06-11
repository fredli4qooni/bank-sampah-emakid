@extends('layouts.public')

@section('title', 'Program Kami - Bank Sampah Emak.id')

@section('content')
    <section class="bg-green-700 py-16 relative overflow-hidden">
        <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 20px 20px;"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <h1 class="text-4xl md:text-5xl font-black text-white mb-4">Program Unggulan</h1>
            <p class="text-xl text-green-100 max-w-2xl mx-auto">Berbagai inisiatif kami untuk memaksimalkan potensi sampah tangga menjadi hal yang lebih bernilai.</p>
        </div>
    </section>

    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition-all transform hover:-translate-y-1">
                    <div class="h-48 bg-green-100 flex items-center justify-center relative overflow-hidden">
                        <div class="absolute inset-0 opacity-30 bg-center bg-cover" style="background-image: url('https://www.transparenttextures.com/patterns/cubes.png');"></div>
                        <svg class="w-24 h-24 text-green-600 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div class="p-8">
                        <span class="bg-green-100 text-green-800 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide">Ekonomi</span>
                        <h3 class="text-2xl font-black text-gray-900 mt-4 mb-3">Tabungan Reguler</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Program utama kami. Nasabah dapat menyetorkan sampah terpilah (plastik, kertas, logam) untuk dikonversi menjadi saldo rupiah yang dapat ditarik kapan saja atau ditukar dengan sembako.
                        </p>
                    </div>
                </div>

                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition-all transform hover:-translate-y-1">
                    <div class="h-48 bg-blue-100 flex items-center justify-center relative overflow-hidden">
                        <div class="absolute inset-0 opacity-30 bg-center bg-cover" style="background-image: url('https://www.transparenttextures.com/patterns/cubes.png');"></div>
                        <svg class="w-24 h-24 text-blue-600 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    </div>
                    <div class="p-8">
                        <span class="bg-blue-100 text-blue-800 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide">Sosial</span>
                        <h3 class="text-2xl font-black text-gray-900 mt-4 mb-3">Sedekah Sampah</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Salurkan kepedulian Anda. Hasil penjualan dari sampah yang disedekahkan melalui program ini akan dialokasikan 100% untuk menyantuni anak yatim dan kaum dhuafa di lingkungan sekitar.
                        </p>
                    </div>
                </div>

                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition-all transform hover:-translate-y-1">
                    <div class="h-48 bg-yellow-100 flex items-center justify-center relative overflow-hidden">
                        <div class="absolute inset-0 opacity-30 bg-center bg-cover" style="background-image: url('https://www.transparenttextures.com/patterns/cubes.png');"></div>
                        <svg class="w-24 h-24 text-yellow-600 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <div class="p-8">
                        <span class="bg-yellow-100 text-yellow-800 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide">Edukasi</span>
                        <h3 class="text-2xl font-black text-gray-900 mt-4 mb-3">Kelas Daur Ulang</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Kami secara rutin mengadakan kelas gratis bagi warga dan ibu rumah tangga untuk menyulap sampah anorganik (seperti bungkus kopi atau botol plastik) menjadi kerajinan tangan bernilai jual.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection