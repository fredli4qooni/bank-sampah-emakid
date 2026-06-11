@extends('layouts.public')

@section('title', 'Tentang Kami - Bank Sampah Emak.id')

@section('content')
    <section class="bg-green-700 py-16 relative overflow-hidden">
        <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 20px 20px;"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <h1 class="text-4xl md:text-5xl font-black text-white mb-4">Mengenal Lebih Dekat</h1>
            <p class="text-xl text-green-100 max-w-2xl mx-auto">Perjalanan kami membangun ekosistem peduli lingkungan dan berdaya secara ekonomi.</p>
        </div>
    </section>

    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center mb-16">
                <div>
                    <h2 class="text-3xl font-black text-gray-900 mb-6">Awal Mula Perjalanan Kami</h2>
                    <div class="space-y-4 text-gray-600 leading-relaxed">
                        <p>
                            Bank Sampah Emak.id lahir dari kepedulian sekelompok ibu rumah tangga terhadap masalah penumpukan sampah di lingkungan sekitar. Apa yang awalnya hanya kegiatan gotong royong membersihkan selokan, kini bertransformasi menjadi sebuah gerakan sosial-ekonomi.
                        </p>
                        <p>
                            Kami percaya bahwa sampah bukanlah akhir dari sebuah barang, melainkan awal dari nilai ekonomi baru jika dikelola dengan manajemen yang tepat, modern, dan transparan[cite: 10].
                        </p>
                    </div>
                </div>
                <div class="bg-green-50 p-8 rounded-3xl border border-green-100 relative">
                    <div class="absolute -top-6 -left-6 w-12 h-12 bg-green-500 rounded-full opacity-50"></div>
                    <div class="absolute -bottom-4 -right-4 w-20 h-20 bg-green-300 rounded-full opacity-50"></div>
                    <h3 class="text-xl font-bold text-green-800 mb-4">Mengapa "Emak.id"?</h3>
                    <p class="text-green-700 italic">
                        "Emak" merepresentasikan sosok ibu yang selalu telaten merawat rumah dan keluarga. Melalui nama ini, kami ingin semangat ketelatenan merawat bumi menular kepada seluruh lapisan masyarakat, dipadukan dengan kata ".id" sebagai simbol digitalisasi sistem bank sampah modern[cite: 10].
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-white p-8 rounded-2xl shadow-sm border-t-4 border-t-blue-500 border-x border-b border-gray-100">
                    <div class="flex items-center gap-3 mb-4">
                        <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                        <h2 class="text-2xl font-black text-gray-900">Visi Kami</h2>
                    </div>
                    <p class="text-gray-600 leading-relaxed">
                        Mewujudkan lingkungan yang bersih, sehat, dan lestari melalui pengelolaan sampah rumah tangga yang mandiri, inovatif, dan berkesinambungan, serta membangun ekonomi sirkular yang menyejahterakan masyarakat.
                    </p>
                </div>
                <div class="bg-white p-8 rounded-2xl shadow-sm border-t-4 border-t-green-500 border-x border-b border-gray-100">
                    <div class="flex items-center gap-3 mb-4">
                        <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                        <h2 class="text-2xl font-black text-gray-900">Misi Kami</h2>
                    </div>
                    <ul class="text-gray-600 space-y-2 list-disc pl-5">
                        <li>Memberikan edukasi pemilahan sampah dari rumah.</li>
                        <li>Menyediakan platform tabungan digital yang transparan[cite: 10, 110].</li>
                        <li>Mengubah cara pandang masyarakat terhadap nilai sampah.</li>
                        <li>Menjalin kemitraan dengan pengepul dan pendaur ulang industri.</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
@endsection