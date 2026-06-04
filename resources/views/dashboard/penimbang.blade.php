<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Penimbang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 text-center">
            
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Halo, {{ Auth::user()->name }}!</h1>
            <p class="text-gray-600 mb-8">Selamat bertugas di lapangan hari ini.</p>

            <a href="{{ route('transaksi.create') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-black text-2xl py-6 px-12 rounded-2xl shadow-lg transform transition hover:scale-105">
                + INPUT SETORAN BARU
            </a>

            <div class="mt-12 bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 max-w-sm mx-auto border-t-4 border-green-500">
                <p class="text-gray-500 text-sm font-bold uppercase">Setoran Anda Hari Ini</p>
                <p class="text-4xl font-black text-green-600 mt-2">{{ $transaksiSayaHariIni }} <span class="text-lg text-gray-600">Transaksi</span></p>
            </div>

        </div>
    </div>
</x-app-layout>