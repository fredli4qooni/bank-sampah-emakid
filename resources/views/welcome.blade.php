<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bank Sampah Emak.id - Ubah Sampah Jadi Berkah</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-50 text-gray-900">

    <nav class="bg-white border-b border-gray-100 fixed w-full z-50 top-0 transition-all shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <div class="flex items-center gap-2">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                    </svg>
                    <span class="text-2xl font-black text-green-700 tracking-tight">Emak<span class="text-gray-400">.id</span></span>
                </div>
                <div class="flex items-center gap-4">
                    @if (Route::has('login'))
                    @auth
                    <a href="{{ url('/dashboard') }}" class="text-green-700 font-bold hover:text-green-800 px-4 py-2 rounded-lg bg-green-50 transition">Masuk Dashboard</a>
                    @else
                    <a href="{{ route('login') }}" class="text-white bg-green-600 hover:bg-green-700 font-bold px-6 py-2.5 rounded-full shadow-md transition-transform transform hover:-translate-y-0.5">Login Sistem</a>
                    @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <section class="pt-32 pb-20 lg:pt-40 lg:pb-28 overflow-hidden relative">
        <div class="absolute inset-0 z-0 opacity-10" style="background-image: radial-gradient(#22c55e 1px, transparent 1px); background-size: 20px 20px;"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

                <div class="text-center lg:text-left">
                    <span class="bg-green-100 text-green-800 font-bold px-4 py-1.5 rounded-full text-sm tracking-wide uppercase shadow-sm border border-green-200 mb-6 inline-block">Platform Digital Bank Sampah</span>
                    <h1 class="text-5xl md:text-6xl font-black text-gray-900 leading-tight mb-6 tracking-tight">
                        Ubah Sampah Lingkungan <br class="hidden md:block" />
                        Menjadi <span class="text-transparent bg-clip-text bg-gradient-to-r from-green-500 to-green-700">Berkah Ekonomi</span>
                    </h1>
                    <p class="mt-4 text-xl text-gray-600 max-w-2xl mx-auto lg:mx-0 mb-10 leading-relaxed">
                        Bergabunglah bersama kami menjaga kebersihan lingkungan sekaligus mendapatkan penghasilan tambahan melalui sistem tabungan sampah digital yang transparan.
                    </p>
                    <div class="flex justify-center lg:justify-start gap-4">
                        <a href="#faq" class="bg-white text-green-700 font-bold px-8 py-3.5 rounded-full shadow-md border border-green-100 hover:bg-gray-50 transition">Pelajari Lebih Lanjut</a>
                    </div>
                </div>

                <div class="relative hidden sm:block">
                    <img src="{{ asset('images/ilustrasi-hero.png') }}"
                        alt="Ilustrasi Bank Sampah Emak ID"
                        class="w-full h-auto drop-shadow-2xl transform hover:-translate-y-2 transition duration-500">

                    <div class="absolute -z-10 bg-green-300 rounded-full blur-3xl opacity-30 w-72 h-72 top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2"></div>
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

    <footer class="bg-gray-900 py-12 border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="flex justify-center items-center gap-2 mb-6">
                <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                </svg>
                <span class="text-xl font-black text-white tracking-tight">Emak<span class="text-gray-500">.id</span></span>
            </div>
            <p class="text-gray-400 text-sm">
                &copy; {{ date('Y') }} Bank Sampah Emak.id. Mengelola Sampah, Membangun Masyarakat.
            </p>
        </div>
    </footer>

    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
</body>

</html>