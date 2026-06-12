<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-30 w-64 overflow-y-auto transition duration-300 transform bg-white border-r border-gray-100 shadow-lg lg:translate-x-0 lg:static lg:inset-auto flex flex-col justify-between">

    <div>
        <div class="flex items-center justify-center h-20 border-b border-gray-100 bg-white">
            <div class="flex items-center gap-2">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                </svg>
                <span class="text-2xl font-black text-green-700 tracking-tight">Emak<span class="text-gray-400">.id</span></span>
            </div>
        </div>

        <nav class="mt-6 px-4 space-y-2">

            <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 rounded-r-full {{ request()->routeIs('dashboard*') || request()->routeIs('admin.dashboard') || request()->routeIs('penimbang.dashboard') ? 'bg-green-50 text-green-700 font-bold border-l-4 border-green-600' : 'text-gray-500 hover:bg-green-50 hover:text-green-700 transition-colors' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                </svg>
                <span>Dashboard</span>
            </a>

            <p class="px-4 pt-4 pb-2 text-xs font-bold text-gray-400 uppercase tracking-wider">Operasional Lapangan</p>

            @if(Auth::user()->role === 'penimbang')
            <a href="{{ route('transaksi.create') }}" class="flex items-center px-4 py-3 rounded-r-full {{ request()->routeIs('transaksi.create') ? 'bg-green-50 text-green-700 font-bold border-l-4 border-green-600' : 'text-gray-500 hover:bg-green-50 hover:text-green-700 transition-colors' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span>Input Setoran</span>
            </a>
            
            <a href="{{ route('transaksi.index') }}" class="flex items-center px-4 py-3 rounded-r-full {{ request()->routeIs('transaksi.index') ? 'bg-green-50 text-green-700 font-bold border-l-4 border-green-600' : 'text-gray-500 hover:bg-green-50 hover:text-green-700 transition-colors' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <span>Riwayat Setoran Saya</span>
            </a>
            @endif

            @if(Auth::user()->role === 'admin' || Auth::user()->role === 'penimbang')
            <a href="{{ route('nasabah.index') }}" class="flex items-center px-4 py-3 rounded-r-full {{ request()->routeIs('nasabah.*') ? 'bg-green-50 text-green-700 font-bold border-l-4 border-green-600' : 'text-gray-500 hover:bg-green-50 hover:text-green-700 transition-colors' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <span>Data Nasabah</span>
            </a>
            @endif

            @can('isAdmin')
            <p class="px-4 pt-4 pb-2 text-xs font-bold text-gray-400 uppercase tracking-wider">Manajemen Back-Office</p>

            <a href="{{ route('validasi.index') }}" class="flex items-center px-4 py-3 rounded-r-full {{ request()->routeIs('validasi.*') ? 'bg-green-50 text-green-700 font-bold border-l-4 border-green-600' : 'text-gray-500 hover:bg-green-50 hover:text-green-700 transition-colors' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Validasi & Koreksi</span>
            </a>
            
            <a href="{{ route('jenis-sampah.index') }}" class="flex items-center px-4 py-3 rounded-r-full {{ request()->routeIs('jenis-sampah.*') ? 'bg-green-50 text-green-700 font-bold border-l-4 border-green-600' : 'text-gray-500 hover:bg-green-50 hover:text-green-700 transition-colors' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
                <span>Master Jenis Sampah</span>
            </a>

            <a href="{{ route('users.index') }}" class="flex items-center px-4 py-3 rounded-r-full {{ request()->routeIs('users.*') ? 'bg-green-50 text-green-700 font-bold border-l-4 border-green-600' : 'text-gray-500 hover:bg-green-50 hover:text-green-700 transition-colors' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <span>Manajemen Pengguna</span>
            </a>

            <a href="{{ route('penarikan.index') }}" class="flex items-center px-4 py-3 rounded-r-full {{ request()->routeIs('penarikan.*') ? 'bg-green-50 text-green-700 font-bold border-l-4 border-green-600' : 'text-gray-500 hover:bg-green-50 hover:text-green-700 transition-colors' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <span>Riwayat Penarikan</span>
            </a>

            <a href="{{ route('units.index') }}" class="flex items-center px-4 py-3 rounded-r-full {{ request()->routeIs('units.*') ? 'bg-green-50 text-green-700 font-bold border-l-4 border-green-600' : 'text-gray-500 hover:bg-green-50 hover:text-green-700 transition-colors' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                </svg>
                <span>Data Unit</span>
            </a>

            <a href="{{ route('backup.index') }}" class="flex items-center px-4 py-3 rounded-r-full {{ request()->routeIs('backup.*') ? 'bg-green-50 text-green-700 font-bold border-l-4 border-green-600' : 'text-gray-500 hover:bg-green-50 hover:text-green-700 transition-colors' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                </svg>
                <span>Backup Database</span>
            </a>

            <a href="{{ route('faq.index') }}" class="flex items-center px-4 py-3 rounded-r-full {{ request()->routeIs('faq.*') ? 'bg-green-50 text-green-700 font-bold border-l-4 border-green-600' : 'text-gray-500 hover:bg-green-50 hover:text-green-700 transition-colors' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Konten FAQ Publik</span>
            </a>

            <a href="{{ route('chatbot.setting') }}" class="flex items-center px-4 py-3 rounded-r-full {{ request()->routeIs('chatbot.setting*') ? 'bg-green-50 text-green-700 font-bold border-l-4 border-green-600' : 'text-gray-500 hover:bg-green-50 hover:text-green-700 transition-colors' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                </svg>
                <span>Pengaturan Chatbot</span>
            </a>
            @endcan

            @if(Auth::user()->role === 'admin' || Auth::user()->role === 'pengelola')
            <p class="px-4 pt-4 pb-2 text-xs font-bold text-gray-400 uppercase tracking-wider">Laporan & Rekap</p>

            <a href="{{ route('laporan.index') }}" class="flex items-center px-4 py-3 rounded-r-full {{ request()->routeIs('laporan.*') ? 'bg-green-50 text-green-700 font-bold border-l-4 border-green-600' : 'text-gray-500 hover:bg-green-50 hover:text-green-700 transition-colors' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span>Laporan Operasional</span>
            </a>
            @endif

        </nav>
    </div>

    <div class="p-4 m-4 bg-green-50 rounded-xl border border-green-100 text-center">
        <p class="text-xs text-green-600 font-bold uppercase tracking-widest">Akses Saat Ini</p>
        <p class="text-lg font-black text-green-800 capitalize">{{ Auth::user()->role }}</p>
    </div>
</aside>