<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-green-800 leading-tight">
            {{ __('Data Nasabah') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
            <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm">
                {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm">
                {{ session('error') }}
            </div>
            @endif

            @if($errors->any())
            <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
                <div class="p-6 text-gray-900">

                    @can('isAdmin')
                    <div class="mb-6 flex justify-between items-center" x-data="{ showImportModal: false, isUploading: false, progress: 0 }">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('nasabah.create') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2.5 px-5 rounded-lg shadow transition-colors flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Tambah Nasabah
                            </a>
                            <button @click="showImportModal = true" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-5 rounded-lg shadow transition-colors flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                </svg>
                                Import Excel
                            </button>
                        </div>

                        <!-- Modal Import -->
                        <div x-show="showImportModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                            <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                                <div x-show="showImportModal" x-transition.opacity class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true" @click="if(!isUploading) showImportModal = false"></div>

                                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                                <div x-show="showImportModal"
                                     x-transition:enter="ease-out duration-300"
                                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                     x-transition:leave="ease-in duration-200"
                                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                     class="inline-block px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-xl shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                                    <div class="sm:flex sm:items-start">
                                        <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto bg-blue-100 rounded-full sm:mx-0 sm:h-10 sm:w-10">
                                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" /></svg>
                                        </div>
                                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                            <h3 class="text-lg font-bold leading-6 text-gray-900" id="modal-title">Import Data Nasabah</h3>
                                            <div class="mt-2">
                                                <p class="text-sm text-gray-500 mb-4">Unggah file Excel (.xlsx, .xls) atau CSV dengan format baris pertama "INPUT NASABAH BARU", baris kedua header "No Rek, Nama, Kelompok", dan data mulai baris ketiga.</p>
                                                <form action="{{ route('nasabah.import') }}" method="POST" enctype="multipart/form-data" 
                                                      @submit="isUploading = true; progress = 0; let interval = setInterval(() => { if (progress < 90) progress += Math.random() * 15; else if (progress < 99) progress += 0.5; }, 400);">
                                                    @csrf
                                                    <div class="mb-4 relative">
                                                        <div x-show="isUploading" class="absolute inset-0 bg-white/50 z-10"></div>
                                                        <input type="file" name="file_excel" accept=".xlsx, .xls, .csv" required class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none focus:ring focus:ring-blue-200">
                                                    </div>
                                                    
                                                    <!-- Progress Bar -->
                                                    <div x-show="isUploading" class="mb-4" x-transition>
                                                        <div class="flex justify-between text-xs font-bold text-blue-600 mb-1">
                                                            <span>Mengunggah & Memproses...</span>
                                                            <span x-text="Math.round(Math.min(progress, 99)) + '%'"></span>
                                                        </div>
                                                        <div class="w-full bg-blue-100 rounded-full h-2.5 overflow-hidden">
                                                            <div class="bg-blue-600 h-2.5 rounded-full transition-all duration-300 ease-out" :style="'width: ' + Math.min(progress, 99) + '%'"></div>
                                                        </div>
                                                    </div>

                                                    <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                                                        <button type="submit" :disabled="isUploading" class="inline-flex justify-center w-full px-4 py-2 text-base font-bold text-white bg-blue-600 border border-transparent rounded-lg shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm disabled:opacity-50 disabled:cursor-not-allowed">
                                                            <span x-show="!isUploading">Mulai Import</span>
                                                            <span x-show="isUploading">Harap Tunggu...</span>
                                                        </button>
                                                        <button type="button" @click="showImportModal = false" :disabled="isUploading" class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:mt-0 sm:w-auto sm:text-sm disabled:opacity-50 disabled:cursor-not-allowed">
                                                            Batal
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endcan

                    <!-- Filter & Pencarian -->
                    <div class="mb-6 bg-gray-50 p-4 rounded-xl border border-gray-200">
                        <form action="{{ route('nasabah.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                            <div class="flex-1">
                                <label for="search" class="sr-only">Cari Nasabah</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                                    </div>
                                    <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Cari nama atau no rekening..." class="w-full pl-10 border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 rounded-lg shadow-sm">
                                </div>
                            </div>
                            <div class="flex-1 md:w-1/3">
                                <label for="id_unit" class="sr-only">Kelompok/Unit</label>
                                <select name="id_unit" id="id_unit" class="w-full border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 rounded-lg shadow-sm">
                                    <option value="">Semua Kelompok/Unit</option>
                                    @foreach($units as $u)
                                        <option value="{{ $u->id_unit }}" {{ request('id_unit') == $u->id_unit ? 'selected' : '' }}>{{ $u->nama_unit }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex gap-2">
                                <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white font-bold py-2 px-6 rounded-lg shadow transition-colors flex items-center gap-2">
                                    Tampilkan
                                </button>
                                @if(request()->hasAny(['search', 'id_unit']) && (request('search') != '' || request('id_unit') != ''))
                                <a href="{{ route('nasabah.index') }}" class="bg-white border border-gray-300 text-gray-700 hover:bg-gray-100 font-bold py-2 px-4 rounded-lg shadow-sm transition-colors text-center flex items-center justify-center">
                                    Reset
                                </a>
                                @endif
                            </div>
                        </form>
                    </div>

                    <div class="overflow-x-auto rounded-lg border border-gray-200">
                        <table class="w-full text-sm text-left text-gray-600">
                            <thead class="text-xs text-green-800 uppercase bg-green-50 border-b border-green-100">
                                <tr>
                                    <th scope="col" class="px-6 py-4 font-bold">No. Rekening</th>
                                    <th scope="col" class="px-6 py-4 font-bold">Nama Lengkap</th>
                                    <th class="px-6 py-4 font-bold">Kecamatan</th>
                                    <th class="px-6 py-4 font-bold">Unit/Kelompok</th>
                                    <th class="px-6 py-4 font-bold">No. HP</th>
                                    <th scope="col" class="px-6 py-4 font-bold">Total Saldo</th>
                                    @can('isAdmin')
                                    <th scope="col" class="px-6 py-4 font-bold text-center">Aksi</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse ($nasabah as $n)
                                <tr class="bg-white hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 font-semibold text-green-700">{{ $n->no_rekening }}</td>
                                    <td class="px-6 py-4 font-bold text-gray-800">{{ $n->nama }}</td>
                                    <td class="px-6 py-4">{{ $n->kecamatan }}</td>
                                    <td class="px-6 py-4 font-medium text-green-700">
                                        {{ $n->unit ? $n->unit->nama_unit : '-' }}
                                    </td>
                                    <td class="px-6 py-4">{{ $n->no_hp }}</td>
                                    <td class="px-6 py-4 font-semibold text-gray-900">Rp {{ number_format($n->saldo, 0, ',', '.') }}</td>

                                    @can('isAdmin')
                                    <td class="px-6 py-4 flex justify-center space-x-3 items-center">
                                        <a href="{{ route('nasabah.cetak', $n->id_nasabah) }}" target="_blank" class="text-blue-600 hover:text-blue-800 font-bold" title="Cetak Buku Tabungan">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                                        </a>
                                        <span class="text-gray-300">|</span>
                                        <a href="{{ route('nasabah.edit', $n->id_nasabah) }}" class="text-green-600 hover:text-green-800 font-medium">Edit</a>
                                        <span class="text-gray-300">|</span>
                                        <form action="{{ route('nasabah.destroy', $n->id_nasabah) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus nasabah ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 font-medium">Hapus</button>
                                        </form>
                                    </td>
                                    @endcan
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-gray-400">Belum ada data nasabah yang terdaftar.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($nasabah->hasPages())
                    <div class="mt-6">
                        {{ $nasabah->links() }}
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>