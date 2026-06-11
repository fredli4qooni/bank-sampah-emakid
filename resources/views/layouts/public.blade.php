<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Bank Sampah Emak.id - Ubah Sampah Jadi Berkah')</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-gray-900 bg-gray-50 flex flex-col min-h-screen">

    <nav x-data="{ open: false, scrolled: false }" 
         @scroll.window="scrolled = (window.pageYOffset > 20)"
         :class="{'bg-white shadow-md': scrolled, 'bg-green-50/80 backdrop-blur-md': !scrolled}"
         class="fixed w-full z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex-shrink-0 flex items-center gap-2">
                    <div class="w-10 h-10 bg-green-600 rounded-full flex items-center justify-center text-white font-black text-xl shadow-lg">
                        E
                    </div>
                    <a href="{{ route('home') }}" class="font-black text-2xl tracking-tight text-green-800">
                        Emak<span class="text-green-500">.id</span>
                    </a>
                </div>

                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'text-green-600 font-bold' : 'text-gray-600 hover:text-green-600 font-medium' }} transition-colors">Home</a>
                    <a href="{{ route('tentang-kami') }}" class="{{ request()->routeIs('tentang-kami') ? 'text-green-600 font-bold' : 'text-gray-600 hover:text-green-600 font-medium' }} transition-colors">Tentang Kami</a>
                    <a href="{{ route('program') }}" class="{{ request()->routeIs('program') ? 'text-green-600 font-bold' : 'text-gray-600 hover:text-green-600 font-medium' }} transition-colors">Program</a>
                    <a href="{{ route('berita') }}" class="{{ request()->routeIs('berita') ? 'text-green-600 font-bold' : 'text-gray-600 hover:text-green-600 font-medium' }} transition-colors">Berita</a>
                    
                    <div class="pl-4 border-l border-gray-200">
                        @auth
                            <a href="{{ route('dashboard') }}" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-full font-bold shadow-md transition-transform transform hover:-translate-y-0.5">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="bg-white text-green-700 border border-green-200 hover:bg-green-50 px-5 py-2.5 rounded-full font-bold shadow-sm transition-colors">Login Admin</a>
                        @endauth
                    </div>
                </div>

                <div class="md:hidden flex items-center">
                    <button @click="open = !open" class="text-gray-600 hover:text-green-600 focus:outline-none">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div x-show="open" x-collapse class="md:hidden bg-white border-t border-gray-100 shadow-xl absolute w-full">
            <div class="px-4 pt-2 pb-6 space-y-2">
                <a href="{{ route('home') }}" class="block px-3 py-2 rounded-md font-medium {{ request()->routeIs('home') ? 'bg-green-50 text-green-600' : 'text-gray-700 hover:bg-gray-50' }}">Home</a>
                <a href="{{ route('tentang-kami') }}" class="block px-3 py-2 rounded-md font-medium {{ request()->routeIs('tentang-kami') ? 'bg-green-50 text-green-600' : 'text-gray-700 hover:bg-gray-50' }}">Tentang Kami</a>
                <a href="{{ route('program') }}" class="block px-3 py-2 rounded-md font-medium {{ request()->routeIs('program') ? 'bg-green-50 text-green-600' : 'text-gray-700 hover:bg-gray-50' }}">Program</a>
                <a href="{{ route('berita') }}" class="block px-3 py-2 rounded-md font-medium {{ request()->routeIs('berita') ? 'bg-green-50 text-green-600' : 'text-gray-700 hover:bg-gray-50' }}">Berita</a>
                <div class="pt-4 mt-2 border-t border-gray-100">
                    @auth
                        <a href="{{ route('dashboard') }}" class="block w-full text-center bg-green-600 text-white px-5 py-3 rounded-xl font-bold shadow-md">Buka Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="block w-full text-center bg-green-50 text-green-700 px-5 py-3 rounded-xl font-bold border border-green-200">Login Sistem</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-grow pt-20">
        @yield('content')
    </main>

    <footer class="bg-gray-900 text-gray-300 py-12 lg:py-16 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 lg:gap-8">
                
                <div>
                    <div class="flex items-center gap-2 mb-6">
                        <div class="w-10 h-10 bg-green-600 rounded-full flex items-center justify-center text-white font-black text-xl">E</div>
                        <span class="font-black text-2xl tracking-tight text-white">Emak<span class="text-green-500">.id</span></span>
                    </div>
                    <p class="text-sm text-gray-400 leading-relaxed mb-6">
                        Platform inovatif pengelolaan sampah rumah tangga yang mengubah limbah menjadi nilai ekonomi nyata. Bersama kita wujudkan lingkungan bersih dan masyarakat berdaya.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center hover:bg-green-600 hover:text-white transition-colors"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg></a>
                        <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center hover:bg-green-600 hover:text-white transition-colors"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg></a>
                        <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center hover:bg-green-600 hover:text-white transition-colors"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"/></svg></a>
                    </div>
                </div>

                <div>
                    <h4 class="text-white font-bold text-lg mb-6">Tautan Cepat</h4>
                    <ul class="space-y-3 text-sm">
                        <li><a href="{{ route('home') }}" class="hover:text-green-500 transition-colors">Beranda Utama</a></li>
                        <li><a href="{{ route('tentang-kami') }}" class="hover:text-green-500 transition-colors">Profil Bank Sampah</a></li>
                        <li><a href="{{ route('program') }}" class="hover:text-green-500 transition-colors">Program Unggulan</a></li>
                        <li><a href="{{ route('berita') }}" class="hover:text-green-500 transition-colors">Berita & Edukasi</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-green-500 transition-colors">Portal Petugas</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-bold text-lg mb-6">Hubungi Kami</h4>
                    <ul class="space-y-4 text-sm text-gray-400">
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-green-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span>Jl. Raden Intan No. 45, Kecamatan Kedaton, Bandar Lampung, Indonesia 35141</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            <span>+62 812-3456-7890</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <span>halo@emakid.com</span>
                        </li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-bold text-lg mb-6">Jam Operasional</h4>
                    <div class="bg-gray-800 p-4 rounded-xl text-sm border border-gray-700">
                        <div class="flex justify-between py-2 border-b border-gray-700">
                            <span class="text-gray-400">Senin - Jumat</span>
                            <span class="text-green-400 font-bold">08:00 - 16:00</span>
                        </div>
                        <div class="flex justify-between py-2 border-b border-gray-700">
                            <span class="text-gray-400">Sabtu</span>
                            <span class="text-green-400 font-bold">08:00 - 13:00</span>
                        </div>
                        <div class="flex justify-between py-2">
                            <span class="text-gray-400">Minggu/Libur</span>
                            <span class="text-red-400 font-bold">Tutup</span>
                        </div>
                    </div>
                </div>

            </div>
            
            <div class="border-t border-gray-800 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-sm text-gray-500">
                    &copy; {{ date('Y') }} Bank Sampah Emak.id. Hak Cipta Dilindungi.
                </p>
                <div class="flex gap-4 text-sm text-gray-500">
                    <a href="#" class="hover:text-white transition-colors">Syarat & Ketentuan</a>
                    <span>|</span>
                    <a href="#" class="hover:text-white transition-colors">Kebijakan Privasi</a>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>