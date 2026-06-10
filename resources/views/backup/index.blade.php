<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-green-800 leading-tight">
            {{ __('Backup & Keamanan Database') }}
        </h2>
    </x-slot>

    <div class="py-8" x-data="{ isBackingUp: false }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('error'))
                <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl relative shadow-sm">
                    <span class="block sm:inline font-bold">{{ session('error') }}</span>
                </div>
            @endif

            <div x-show="isBackingUp" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-60 backdrop-blur-sm transition-opacity">
                <div class="bg-white p-8 rounded-2xl shadow-2xl flex flex-col items-center max-w-sm w-full text-center">
                    <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-b-4 border-green-600 mb-4"></div>
                    <h3 class="text-xl font-black text-gray-800 mb-2">Sedang Memproses...</h3>
                    <p class="text-gray-500 text-sm">Mengekstrak dan mengompresi database. File ZIP akan segera diunduh secara otomatis. Mohon tunggu sejenak.</p>
                </div>
            </div>

            <div class="bg-gradient-to-r from-green-700 to-green-900 overflow-hidden shadow-lg sm:rounded-2xl border border-green-800 mb-8 p-8 relative">
                <div class="absolute top-0 right-0 opacity-10">
                    <svg class="w-64 h-64 -mt-10 -mr-10" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
                </div>
                
                <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
                    <div class="text-white text-center md:text-left">
                        <h3 class="text-2xl font-black mb-2">Amankan Data Operasional Anda</h3>
                        <p class="text-green-100 max-w-xl leading-relaxed text-sm">
                            Fitur ini akan mengekstrak seluruh data nasabah, transaksi, dan pengaturan ke dalam format .sql yang dikompresi (ZIP). Lakukan backup secara berkala untuk menghindari kehilangan data yang tidak diinginkan.
                        </p>
                    </div>
                    
                    <form action="{{ route('backup.process') }}" method="POST" @submit="isBackingUp = true; setTimeout(() => isBackingUp = false, 5000)">
                        @csrf
                        <button type="submit" class="bg-white hover:bg-gray-100 text-green-800 font-black py-4 px-8 rounded-xl shadow-xl transition-transform transform hover:-translate-y-1 flex items-center gap-3 whitespace-nowrap">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                            Buat Backup Sekarang
                        </button>
                    </form>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2 flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    20 Riwayat Backup Terakhir
                </h3>
                
                <div class="overflow-x-auto rounded-lg border border-gray-200">
                    <table class="w-full text-sm text-left text-gray-600">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-4 font-bold">Waktu Eksekusi</th>
                                <th class="px-6 py-4 font-bold">Dieksekusi Oleh</th>
                                <th class="px-6 py-4 font-bold">Ukuran File</th>
                                <th class="px-6 py-4 font-bold text-center">Status</th>
                                <th class="px-6 py-4 font-bold">Keterangan Log</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($logs as $log)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 font-medium">{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                                <td class="px-6 py-4 font-bold text-gray-800">{{ $log->admin->name ?? 'System/Unknown' }}</td>
                                <td class="px-6 py-4">{{ $log->file_size ?? '-' }}</td>
                                <td class="px-6 py-4 text-center">
                                    @if($log->status === 'Berhasil')
                                        <span class="bg-green-100 text-green-800 text-xs px-3 py-1 rounded-full font-bold uppercase border border-green-200">Berhasil</span>
                                    @else
                                        <span class="bg-red-100 text-red-800 text-xs px-3 py-1 rounded-full font-bold uppercase border border-red-200">Gagal</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-xs text-gray-500 italic">{{ $log->keterangan }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center py-8 text-gray-400">Belum ada riwayat backup database yang tercatat.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>