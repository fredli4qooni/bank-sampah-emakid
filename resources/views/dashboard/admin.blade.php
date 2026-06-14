<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-green-800 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if($pendingValidasi > 0)
            <div class="mb-8 flex items-center justify-between bg-yellow-50 border border-yellow-200 p-4 rounded-xl shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="bg-yellow-100 p-2 rounded-lg text-yellow-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold text-yellow-800">Tindakan Diperlukan</p>
                        <p class="text-sm text-yellow-700">Terdapat <b>{{ $pendingValidasi }}</b> transaksi menunggu validasi Anda.</p>
                    </div>
                </div>
                <a href="{{ route('validasi.index') }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded-lg text-sm transition-colors shadow-sm">
                    Proses Sekarang
                </a>
            </div>
            @endif

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
                    <h3 class="text-gray-800 font-bold mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                        </svg>
                        Tren Transaksi (7 Hari Terakhir)
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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
                <div class="p-6">
                    <h3 class="text-lg font-bold mb-4 text-gray-800">10 Transaksi Terbaru</h3>
                    <div class="overflow-x-auto rounded-lg border border-gray-200">
                        <table class="w-full text-sm text-left text-gray-600">
                            <thead class="text-xs text-green-800 uppercase bg-green-50 border-b border-gray-200">
                                <tr>
                                    <th class="px-6 py-4 font-bold">Waktu</th>
                                    <th class="px-6 py-4 font-bold">Nasabah</th>
                                    <th class="px-6 py-4 font-bold">Nilai (Rp)</th>
                                    <th class="px-6 py-4 font-bold">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($transaksiTerbaru as $trx)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 font-medium">{{ $trx->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="px-6 py-4 font-bold text-gray-800">{{ $trx->nasabah->nama }}</td>
                                    <td class="px-6 py-4 font-semibold text-gray-900">Rp {{ number_format($trx->total_nilai, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4">
                                        @if($trx->status_validasi == 'pending')
                                        <span class="bg-yellow-100 text-yellow-800 text-xs px-3 py-1 rounded-full font-bold uppercase border border-yellow-200">Pending</span>
                                        @elseif($trx->status_validasi == 'valid')
                                        <span class="bg-green-100 text-green-800 text-xs px-3 py-1 rounded-full font-bold uppercase border border-green-200">Valid</span>
                                        @else
                                        <span class="bg-blue-100 text-blue-800 text-xs px-3 py-1 rounded-full font-bold uppercase border border-blue-200">Terkoreksi</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-8 text-gray-400">Belum ada transaksi di sistem.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div x-data="chatbot()" class="fixed bottom-6 right-6 z-50 font-sans">

        <button @click="toggle()" x-show="!isOpen" x-transition.scale.origin.bottom.right
            class="bg-green-600 hover:bg-green-700 text-white p-4 rounded-full shadow-2xl flex items-center justify-center transform transition hover:scale-110 focus:outline-none focus:ring-4 focus:ring-green-300">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
            </svg>
        </button>

        <div x-show="isOpen" x-cloak x-transition.origin.bottom.right
            class="bg-white w-[380px] h-[500px] max-h-[85vh] rounded-2xl shadow-2xl border border-gray-200 flex flex-col overflow-hidden">

            <div class="bg-gradient-to-r from-green-600 to-green-700 text-white p-4 flex justify-between items-center shadow-md z-10">
                <div class="flex items-center gap-3">
                    <div class="bg-white/20 p-2 rounded-full">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-sm">Admin Assistant</h3>
                        <p class="text-xs text-green-100">Cek data lebih cepat</p>
                    </div>
                </div>
                <div class="flex items-center gap-1">
                    <button @click="clearHistory()" title="Bersihkan Percakapan" class="p-1.5 rounded-lg hover:bg-white/20 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                    <button @click="toggle()" class="p-1.5 rounded-lg hover:bg-white/20 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <div id="chat-container" class="flex-1 p-4 overflow-y-auto bg-gray-50 flex flex-col gap-3">

                <template x-for="(msg, index) in messages" :key="index">
                    <div class="flex flex-col" :class="msg.sender === 'user' ? 'items-end' : 'items-start'">
                        <div class="max-w-[85%] rounded-2xl px-4 py-2.5 text-sm shadow-sm"
                            :class="msg.sender === 'user' ? 'bg-green-600 text-white rounded-br-none' : 'bg-white border border-gray-100 text-gray-800 rounded-bl-none'">
                            <span class="whitespace-pre-wrap" x-text="msg.text"></span>
                        </div>
                    </div>
                </template>

                <div x-show="isLoading" class="flex items-start">
                    <div class="bg-white border border-gray-100 text-gray-500 rounded-2xl rounded-bl-none px-4 py-3 text-sm shadow-sm flex items-center gap-1.5">
                        <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce"></span>
                        <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.1s"></span>
                        <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></span>
                    </div>
                </div>

                <div x-show="messages.length <= 2" class="mt-4 flex flex-wrap gap-2">
                    <p class="w-full text-xs text-gray-400 font-bold uppercase mb-1">Coba Tanyakan:</p>
                    <template x-for="chip in quickChips">
                        <button @click="sendQuickMessage(chip)" class="bg-white border border-green-200 text-green-700 hover:bg-green-50 text-xs px-3 py-1.5 rounded-full transition-colors shadow-sm">
                            <span x-text="chip"></span>
                        </button>
                    </template>
                </div>
            </div>

            <div class="p-3 bg-white border-t border-gray-100">
                <form @submit.prevent="sendMessage()" class="flex items-center gap-2 relative">
                    <input type="text" x-model="newMessage" placeholder="Tanya sesuatu... (Cek saldo, dll)"
                        class="flex-1 border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 rounded-full text-sm pl-4 pr-12 py-2.5 shadow-sm transition-colors"
                        :disabled="isLoading">
                    <button type="submit" :disabled="newMessage.trim() === '' || isLoading"
                        class="absolute right-1 top-1 bottom-1 bg-green-600 hover:bg-green-700 disabled:bg-gray-300 disabled:cursor-not-allowed text-white p-2 rounded-full transition-colors flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('chatbot', () => ({
                isOpen: false,
                isLoading: false,
                newMessage: '',
                messages: [{
                    sender: 'bot',
                    text: 'Halo, Admin! Ada yang bisa saya bantu cek hari ini?'
                }],
                quickChips: [
                    'Saldo nasabah', 'Transaksi hari ini', 'Transaksi pending', 'Total nasabah'
                ],

                init() {
                    this.$watch('messages', () => {
                        this.scrollToBottom();
                    });
                },

                toggle() {
                    this.isOpen = !this.isOpen;
                    if (this.isOpen) {
                        setTimeout(() => this.scrollToBottom(), 100);
                    }
                },

                scrollToBottom() {
                    const container = document.getElementById('chat-container');
                    if (container) {
                        container.scrollTop = container.scrollHeight;
                    }
                },

                clearHistory() {
                    this.messages = [{
                        sender: 'bot',
                        text: 'Riwayat percakapan telah dibersihkan.'
                    }];
                },

                sendQuickMessage(text) {
                    this.newMessage = text;
                    this.sendMessage();
                },

                async sendMessage() {
                    if (this.newMessage.trim() === '') return;

                    const userText = this.newMessage;
                    this.messages.push({
                        sender: 'user',
                        text: userText
                    });
                    this.newMessage = '';
                    this.isLoading = true;

                    try {
                        const response = await fetch('{{ route("chatbot.query") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({
                                message: userText
                            })
                        });

                        const data = await response.json();

                        if (data.status === 'success') {
                            this.messages.push({
                                sender: 'bot',
                                text: data.reply
                            });
                        } else {
                            this.messages.push({
                                sender: 'bot',
                                text: 'Maaf, terjadi kesalahan pada sistem.'
                            });
                        }
                    } catch (error) {
                        this.messages.push({
                            sender: 'bot',
                            text: 'Maaf, terjadi kendala jaringan saat menghubungi server.'
                        });
                    } finally {
                        this.isLoading = false;
                    }
                }
            }));
        });
    </script>

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