<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-green-800 leading-tight">
            {{ __('Dashboard Penimbang') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 text-center mt-6 lg:mt-10">
            
            <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 rounded-full mb-6 shadow-sm">
                <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>

            <h1 class="text-3xl font-black text-gray-800 mb-2">Halo, {{ Auth::user()->name }}!</h1>
            <p class="text-gray-500 mb-10 text-lg">Selamat bertugas di lapangan hari ini.</p>

            <a href="{{ route('transaksi.create') }}" class="inline-flex flex-col items-center justify-center bg-green-600 hover:bg-green-700 text-white font-black text-2xl lg:text-3xl py-8 px-10 lg:px-16 rounded-[2rem] shadow-xl transform transition duration-300 hover:scale-105 hover:shadow-2xl border-b-8 border-green-800 w-11/12 sm:w-auto">
                <svg class="w-12 h-12 lg:w-16 lg:h-16 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                <span>INPUT SETORAN BARU</span>
            </a>

            <div class="mt-16 bg-white overflow-hidden shadow-sm rounded-3xl border border-gray-100 p-8 max-w-xs mx-auto relative group">
                <div class="absolute top-0 right-0 w-2 h-full bg-green-500 transition-all duration-300 group-hover:w-full group-hover:opacity-10"></div>
                <p class="text-gray-500 text-sm font-bold uppercase tracking-widest relative z-10">Setoran Anda Hari Ini</p>
                <p class="text-5xl font-black text-green-600 mt-4 relative z-10">{{ $transaksiSayaHariIni }} <span class="text-xl text-gray-400 font-bold">Transaksi</span></p>
            </div>

        </div>
    </div>
</x-app-layout>