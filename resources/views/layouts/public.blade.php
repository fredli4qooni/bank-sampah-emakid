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

    <nav x-data="{ open: false, scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 20)"
        :class="{ 'bg-white shadow-md': scrolled, 'bg-green-50/80 backdrop-blur-md': !scrolled }"
        class="fixed w-full z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex-shrink-0 flex items-center gap-2">
                    <div
                        class="w-10 h-10 bg-green-600 rounded-full flex items-center justify-center text-white font-black text-xl shadow-lg">
                        E
                    </div>
                    <a href="{{ route('home') }}" class="font-black text-2xl tracking-tight text-green-800">
                        Emak<span class="text-green-500">.id</span>
                    </a>
                </div>

                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}"
                        class="{{ request()->routeIs('home') ? 'text-green-600 font-bold' : 'text-gray-600 hover:text-green-600 font-medium' }} transition-colors">Home</a>
                    <a href="{{ route('tentang-kami') }}"
                        class="{{ request()->routeIs('tentang-kami') ? 'text-green-600 font-bold' : 'text-gray-600 hover:text-green-600 font-medium' }} transition-colors">Tentang
                        Kami</a>
                    <a href="{{ route('program') }}"
                        class="{{ request()->routeIs('program') ? 'text-green-600 font-bold' : 'text-gray-600 hover:text-green-600 font-medium' }} transition-colors">Program</a>
                    <a href="{{ route('dokumentasi.public') }}"
                        class="{{ request()->routeIs('dokumentasi.public') ? 'text-green-600 font-bold' : 'text-gray-600 hover:text-green-600 font-medium' }} transition-colors">Dokumentasi</a>
                    <a href="{{ route('berita') }}"
                        class="{{ request()->routeIs('berita') ? 'text-green-600 font-bold' : 'text-gray-600 hover:text-green-600 font-medium' }} transition-colors">Berita</a>

                    <div class="pl-4 border-l border-gray-200">
                        @auth
                            <a href="{{ route('dashboard') }}"
                                class="bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-full font-bold shadow-md transition-transform transform hover:-translate-y-0.5">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}"
                                class="bg-white text-green-700 border border-green-200 hover:bg-green-50 px-5 py-2.5 rounded-full font-bold shadow-sm transition-colors">Login
                                Admin</a>
                        @endauth
                    </div>
                </div>

                <div class="md:hidden flex items-center">
                    <button @click="open = !open" class="text-gray-600 hover:text-green-600 focus:outline-none">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                                stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div x-show="open" x-collapse class="md:hidden bg-white border-t border-gray-100 shadow-xl absolute w-full">
            <div class="px-4 pt-2 pb-6 space-y-2">
                <a href="{{ route('home') }}"
                    class="block px-3 py-2 rounded-md font-medium {{ request()->routeIs('home') ? 'bg-green-50 text-green-600' : 'text-gray-700 hover:bg-gray-50' }}">Home</a>
                <a href="{{ route('tentang-kami') }}"
                    class="block px-3 py-2 rounded-md font-medium {{ request()->routeIs('tentang-kami') ? 'bg-green-50 text-green-600' : 'text-gray-700 hover:bg-gray-50' }}">Tentang
                    Kami</a>
                <a href="{{ route('program') }}"
                    class="block px-3 py-2 rounded-md font-medium {{ request()->routeIs('program') ? 'bg-green-50 text-green-600' : 'text-gray-700 hover:bg-gray-50' }}">Program</a>
                <a href="{{ route('dokumentasi.public') }}"
                    class="block px-3 py-2 rounded-md font-medium {{ request()->routeIs('dokumentasi.public') ? 'bg-green-50 text-green-600' : 'text-gray-700 hover:bg-gray-50' }}">Dokumentasi</a>
                <a href="{{ route('berita') }}"
                    class="block px-3 py-2 rounded-md font-medium {{ request()->routeIs('berita') ? 'bg-green-50 text-green-600' : 'text-gray-700 hover:bg-gray-50' }}">Berita</a>
                <div class="pt-4 mt-2 border-t border-gray-100">
                    @auth
                        <a href="{{ route('dashboard') }}"
                            class="block w-full text-center bg-green-600 text-white px-5 py-3 rounded-xl font-bold shadow-md">Buka
                            Dashboard</a>
                    @else
                        <a href="{{ route('login') }}"
                            class="block w-full text-center bg-green-50 text-green-700 px-5 py-3 rounded-xl font-bold border border-green-200">Login
                            Sistem</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-grow pt-20">
        @yield('content')
    </main>

    <footer class="bg-gray-900 text-gray-300 py-6 lg:py-6 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col items-center justify-center text-center">
            <p class="text-sm text-gray-500 mb-2">
                &copy; {{ date('Y') }} Bank Sampah Emak.id. Hak Cipta Dilindungi.
            </p>
            <div class="flex gap-4 text-sm text-gray-500 justify-center">
                <a href="#" class="hover:text-white transition-colors">Syarat & Ketentuan</a>
                <span>|</span>
                <a href="#" class="hover:text-white transition-colors">Kebijakan Privasi</a>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>

</html>
