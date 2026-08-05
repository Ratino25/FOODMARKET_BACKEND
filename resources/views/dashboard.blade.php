<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <!-- Card Total Revenue -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 border-l-4 border-emerald-500">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-emerald-100 text-emerald-600 mr-4">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Total Pendapatan</p>
                            <p class="text-2xl font-bold text-gray-900 mt-1">Rp{{ number_format($totalRevenue, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Card Total Transactions -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 border-l-4 border-blue-500">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Total Transaksi</p>
                            <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($totalTransactions) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Card Total Foods -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 border-l-4 border-amber-500">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-amber-100 text-amber-600 mr-4">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Total Makanan</p>
                            <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($totalFood) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Card Total Users -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 border-l-4 border-purple-500">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-purple-100 text-purple-600 mr-4">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Total Pelanggan</p>
                            <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($totalUsers) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detail & Diagram section -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-6">Status Transaksi</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Progress / Bars for transaction statuses -->
                    <div class="space-y-4">
                        @foreach(['PENDING', 'SUCCESS', 'CANCELLED', 'DELIVERED', 'ON_DELIVERY'] as $status)
                            @php
                                $count = $statusCounts[$status] ?? ($statusCounts[strtolower($status)] ?? 0);
                                $percentage = $totalTransactions > 0 ? ($count / $totalTransactions) * 100 : 0;
                                $color = match($status) {
                                    'SUCCESS', 'DELIVERED' => 'bg-emerald-500',
                                    'PENDING', 'ON_DELIVERY' => 'bg-amber-500',
                                    default => 'bg-rose-500'
                                };
                            @endphp
                            <div>
                                <div class="flex justify-between text-sm font-semibold text-gray-700 mb-1">
                                    <span>{{ $status }}</span>
                                    <span>{{ $count }} ({{ round($percentage) }}%)</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-3">
                                    <div class="{{ $color }} h-3 rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Welcome / Info Info -->
                    <div class="flex flex-col justify-between p-6 bg-gradient-to-br from-emerald-600 to-teal-500 rounded-xl text-white shadow-md">
                        <div>
                            <h4 class="text-xl font-bold mb-3">Selamat Datang di Admin Panel FoodMarket!</h4>
                            <p class="text-sm text-teal-50 leading-relaxed">
                                Di dashboard ini, Anda dapat memantau aktivitas transaksi penjualan, mendaftarkan makanan baru, serta memantau status pesanan pelanggan secara realtime.
                            </p>
                        </div>
                        <div class="mt-6 flex justify-between items-center text-xs text-teal-100 border-t border-white/20 pt-4">
                            <span>Waktu Server: {{ now()->format('d M Y H:i') }}</span>
                            <span class="px-3 py-1 bg-white/20 rounded-full text-white font-bold tracking-wide">AKTIF</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
