<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-green-800 leading-tight">
            {{ __('Riwayat Penarikan Saldo') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl relative shadow-sm">
                    <span class="block sm:inline font-bold">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 p-6">
                
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-gray-800">Daftar Pencairan Dana</h3>
                    <a href="{{ route('penarikan.create') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2.5 px-5 rounded-lg shadow-md transition-transform transform hover:-translate-y-0.5 text-sm flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                        Input Penarikan Baru
                    </a>
                </div>

                <div class="overflow-x-auto rounded-lg border border-gray-200">
                    <table class="w-full text-sm text-left text-gray-600">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-4 font-bold">Waktu</th>
                                <th class="px-6 py-4 font-bold">Nasabah</th>
                                <th class="px-6 py-4 font-bold text-right">Nominal (Rp)</th>
                                <th class="px-6 py-4 font-bold text-center">Metode</th>
                                <th class="px-6 py-4 font-bold">Admin</th>
                                <th class="px-6 py-4 font-bold">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($penarikan as $p)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 font-medium">{{ $p->created_at->format('d/m/Y H:i') }}</td>
                                <td class="px-6 py-4 font-bold text-gray-800">{{ $p->nasabah->nama }} <br><span class="text-xs text-gray-400 font-normal">{{ $p->nasabah->no_rekening }}</span></td>
                                <td class="px-6 py-4 font-black text-red-600 text-right">- {{ number_format($p->nominal, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-center">
                                    <span class="bg-gray-100 text-gray-800 text-xs px-2.5 py-1 rounded-full font-bold border border-gray-200">{{ $p->metode }}</span>
                                </td>
                                <td class="px-6 py-4">{{ $p->admin->name }}</td>
                                <td class="px-6 py-4 text-xs italic">{{ $p->keterangan ?? '-' }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="6" class="text-center py-8 text-gray-400">Belum ada riwayat penarikan saldo.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>