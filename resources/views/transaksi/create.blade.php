<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-green-800 leading-tight">
            {{ __('Input Setoran Sampah') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 p-6 lg:p-8">
                
                <form id="form-transaksi" action="{{ route('transaksi.store') }}" method="POST">
                    @csrf
                    
                    <!-- Pilih Nasabah -->
                    <div class="mb-8">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Pilih Nasabah <span class="text-red-500">*</span></label>
                        <select name="id_nasabah" class="w-full border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 rounded-lg shadow-sm" required>
                            <option value="" disabled selected>-- Ketik / Pilih Nama Nasabah --</option>
                            @foreach($nasabah as $n)
                                <option value="{{ $n->id_nasabah }}">{{ $n->nama }} ({{ $n->no_rekening }})</option>
                            @endforeach
                        </select>
                    </div>

                    <h3 class="text-lg font-bold text-gray-800 mb-4 border-b border-gray-100 pb-2">Rincian Sampah</h3>

                    <!-- Container Item Sampah -->
                    <div id="item-container" class="space-y-4 mb-4">
                        <!-- Baris Item Pertama (Default) -->
                        <div class="item-row flex flex-col md:flex-row gap-4 bg-gray-50 p-4 rounded-xl border border-gray-200 relative">
                            <div class="flex-1">
                                <label class="block text-gray-600 text-xs font-bold mb-1 uppercase tracking-wider">Jenis Sampah</label>
                                <select name="id_jenis[]" class="jenis-select w-full border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 rounded-lg shadow-sm text-sm" required>
                                    <option value="" data-harga="0" disabled selected>Pilih Jenis</option>
                                    @foreach($jenisSampah as $j)
                                        <option value="{{ $j->id_jenis }}" data-harga="{{ $j->harga_per_kg }}">{{ $j->nama_sampah }} (Rp {{ number_format($j->harga_per_kg, 0, ',', '.') }}/{{ $j->satuan }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="w-full md:w-32">
                                <label class="block text-gray-600 text-xs font-bold mb-1 uppercase tracking-wider">Berat (kg/ltr)</label>
                                <input type="number" name="berat[]" step="0.01" min="0.01" class="berat-input w-full border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 rounded-lg shadow-sm text-sm" placeholder="0.00" required>
                            </div>
                            <div class="w-full md:w-48 flex flex-col justify-end">
                                <label class="block text-gray-600 text-xs font-bold mb-1 uppercase tracking-wider">Subtotal</label>
                                <div class="subtotal-text text-xl font-black text-gray-800 bg-white border border-gray-200 rounded-lg px-3 py-1.5 h-[38px] flex items-center">Rp 0</div>
                            </div>
                            <!-- Tombol Hapus -->
                            <div class="absolute top-2 right-2 md:static md:flex md:flex-col md:justify-end">
                                <button type="button" class="btn-hapus-item text-red-400 hover:text-red-600 p-2 hidden transition-colors" title="Hapus Baris">
                                    <svg class="w-5 h-5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Tambah Item -->
                    <div class="mb-8">
                        <button type="button" id="btn-tambah-item" class="w-full md:w-auto bg-green-50 hover:bg-green-100 text-green-700 border border-green-200 font-bold py-2.5 px-5 rounded-lg text-sm transition-colors flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                            Tambah Jenis Sampah Lain
                        </button>
                    </div>

                    <!-- Total Keseluruhan & Submit -->
                    <div class="flex flex-col md:flex-row items-center justify-between bg-green-600 p-6 rounded-xl shadow-inner mb-6 text-white">
                        <div class="text-green-100 text-lg font-bold uppercase tracking-widest mb-2 md:mb-0">Total Estimasi Nilai</div>
                        <div class="text-4xl font-black tracking-tight" id="total-text">Rp 0</div>
                    </div>

                    <div class="flex items-center justify-end">
                        <button type="submit" onclick="return confirm('Apakah rincian setoran nasabah sudah benar?')" class="w-full md:w-auto bg-gray-800 hover:bg-gray-900 text-white font-bold py-3 px-8 rounded-xl text-lg shadow-lg transform transition hover:-translate-y-1 focus:outline-none focus:ring-4 focus:ring-gray-300">
                            Simpan Transaksi Setoran
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- Script Kalkulasi Dinamis -->
    <x-slot name="scripts">
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const container = document.getElementById('item-container');
                const btnTambah = document.getElementById('btn-tambah-item');
                const totalText = document.getElementById('total-text');

                const formatRupiah = (angka) => {
                    return new Intl.NumberFormat('id-ID').format(angka);
                };

                const hitungTotal = () => {
                    let totalKeseluruhan = 0;
                    const rows = document.querySelectorAll('.item-row');
                    
                    rows.forEach(row => {
                        const selectElement = row.querySelector('.jenis-select');
                        const inputBerat = row.querySelector('.berat-input');
                        const subtotalElement = row.querySelector('.subtotal-text');
                        
                        const harga = parseFloat(selectElement.options[selectElement.selectedIndex].getAttribute('data-harga')) || 0;
                        const berat = parseFloat(inputBerat.value) || 0;
                        
                        const subtotal = harga * berat;
                        totalKeseluruhan += subtotal;
                        
                        subtotalElement.textContent = 'Rp ' + formatRupiah(subtotal);
                    });
                    
                    totalText.textContent = 'Rp ' + formatRupiah(totalKeseluruhan);
                };

                container.addEventListener('input', function(e) {
                    if(e.target.classList.contains('berat-input') || e.target.classList.contains('jenis-select')) {
                        hitungTotal();
                    }
                });

                container.addEventListener('click', function(e) {
                    const btnHapus = e.target.closest('.btn-hapus-item');
                    if(btnHapus) {
                        btnHapus.closest('.item-row').remove();
                        hitungTotal();
                        updateTombolHapus();
                    }
                });

                btnTambah.addEventListener('click', function() {
                    const rowPertama = container.querySelector('.item-row');
                    const rowBaru = rowPertama.cloneNode(true);
                    
                    rowBaru.querySelector('.jenis-select').selectedIndex = 0;
                    rowBaru.querySelector('.berat-input').value = '';
                    rowBaru.querySelector('.subtotal-text').textContent = 'Rp 0';
                    
                    container.appendChild(rowBaru);
                    updateTombolHapus();
                });

                const updateTombolHapus = () => {
                    const rows = document.querySelectorAll('.item-row');
                    rows.forEach(row => {
                        const btnHapus = row.querySelector('.btn-hapus-item');
                        if(rows.length > 1) {
                            btnHapus.classList.remove('hidden');
                        } else {
                            btnHapus.classList.add('hidden');
                        }
                    });
                };
            });
        </script>
    </x-slot>
</x-app-layout>