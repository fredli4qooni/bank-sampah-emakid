<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-green-800 leading-tight">
            {{ __('Dashboard Pantauan Pengelola') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-2 h-full bg-blue-500"></div>
                    <h3 class="text-gray-500 text-xs font-bold uppercase tracking-wider">Total Nasabah</h3>
                    <p class="text-3xl font-black text-gray-800 mt-2">{{ number_format($totalNasabah, 0, ',', '.') }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-2 h-full bg-green-500"></div>
                    <h3 class="text-gray-500 text-xs font-bold uppercase tracking-wider">Transaksi Hari Ini</h3>
                    <p class="text-3xl font-black text-gray-800 mt-2">{{ number_format($transaksiHariIni, 0, ',', '.') }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-2 h-full bg-yellow-400"></div>
                    <h3 class="text-gray-500 text-xs font-bold uppercase tracking-wider">Volume Hari Ini</h3>
                    <p class="text-3xl font-black text-gray-800 mt-2">{{ number_format($volumeHariIni, 2, ',', '.') }} <span class="text-sm font-bold text-gray-400">kg</span></p>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-2 h-full bg-purple-500"></div>
                    <h3 class="text-gray-500 text-xs font-bold uppercase tracking-wider">Total Saldo Nasabah</h3>
                    <p class="text-3xl font-black text-gray-800 mt-2"><span class="text-lg">Rp</span> {{ number_format($totalSaldo, 0, ',', '.') }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-gray-800 font-bold mb-4 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                            </svg>
                            Tren Transaksi
                        </div>
                        <form method="GET" action="{{ route('pengelola.dashboard') }}" class="flex items-center gap-2 text-sm w-full sm:w-auto">
                            <input type="date" name="start_date" value="{{ $startDate }}" class="rounded-lg border-gray-300 text-xs py-1.5 focus:ring-green-500 focus:border-green-500">
                            <span class="text-gray-500 font-medium">s/d</span>
                            <input type="date" name="end_date" value="{{ $endDate }}" class="rounded-lg border-gray-300 text-xs py-1.5 focus:ring-green-500 focus:border-green-500">
                            <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white px-4 py-1.5 rounded-lg text-xs font-bold transition-colors shadow-sm">Filter</button>
                        </form>
                    </h3>
                    <div class="relative h-72">
                        <canvas id="lineChart"></canvas>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col">
                    <h3 class="text-gray-800 font-bold mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                        </svg>
                        Komposisi Sampah Hari Ini
                    </h3>
                    <div class="relative flex-1 flex justify-center items-center min-h-[200px]">
                        @if(empty($dataKomposisi))
                        <p class="text-gray-400 text-sm italic">Belum ada transaksi hari ini.</p>
                        @else
                        <canvas id="pieChart"></canvas>
                        @endif
                    </div>
                </div>
            </div>



        </div>
    </div>

    <x-slot name="scripts">
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const labelHari = JSON.parse('{!! json_encode($labelHari) !!}');
                const dataCount = JSON.parse('{!! json_encode($dataCount) !!}');
                const labelKomposisi = JSON.parse('{!! json_encode($labelKomposisi) !!}');
                const dataPie = JSON.parse('{!! json_encode($dataKomposisi) !!}');

                const ctxLine = document.getElementById('lineChart');
                if (ctxLine) {
                    new Chart(ctxLine, {
                        type: 'line',
                        data: {
                            labels: labelHari,
                            datasets: [{
                                label: 'Jumlah Transaksi',
                                data: dataCount,
                                borderColor: '#059669',
                                backgroundColor: 'rgba(5, 150, 105, 0.1)',
                                borderWidth: 3,
                                pointBackgroundColor: '#ffffff',
                                pointBorderColor: '#059669',
                                pointBorderWidth: 2,
                                pointRadius: 4,
                                tension: 0.4,
                                fill: true,
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        precision: 0
                                    }
                                },
                                x: {
                                    grid: {
                                        display: false
                                    }
                                }
                            }
                        }
                    });
                }

                const ctxPie = document.getElementById('pieChart');
                if (ctxPie && dataPie.length > 0) {
                    new Chart(ctxPie, {
                        type: 'doughnut',
                        data: {
                            labels: labelKomposisi,
                            datasets: [{
                                data: dataPie,
                                backgroundColor: ['#059669', '#3b82f6', '#f59e0b', '#ef4444', '#8b5cf6', '#14b8a6', '#f97316'],
                                borderWidth: 0,
                                hoverOffset: 4
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            cutout: '70%',
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                    labels: {
                                        boxWidth: 12,
                                        padding: 15
                                    }
                                }
                            }
                        }
                    });
                }
            });
        </script>
    </x-slot>
</x-app-layout>