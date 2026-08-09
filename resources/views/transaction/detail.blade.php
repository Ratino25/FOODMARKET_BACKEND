<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Transaksi &raquo; #{{ $item->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @php
                $currentStatus = strtoupper($item->status ?? '');

                $statusColor = match ($currentStatus) {
                    'SUCCESS', 'DELIVERED' => 'bg-emerald-100 text-emerald-800',
                    'PENDING', 'ON_DELIVERY' => 'bg-amber-100 text-amber-800',
                    'CANCELLED' => 'bg-rose-100 text-rose-800',
                    default => 'bg-gray-100 text-gray-700',
                };

                $statusDot = match ($currentStatus) {
                    'SUCCESS', 'DELIVERED' => 'bg-emerald-500',
                    'PENDING', 'ON_DELIVERY' => 'bg-amber-500',
                    'CANCELLED' => 'bg-rose-500',
                    default => 'bg-gray-400',
                };

                // Cek nilai asli kolom picturePath di database (accessor model sudah mengubahnya jadi URL penuh)
                $foodImage = $item->food ? $item->food->getRawOriginal('picturePath') : null;

                $statusOptions = [
                    'ON_DELIVERY' => [
                        'label' => 'On Delivery',
                        'current' => 'bg-blue-500 text-white border-blue-500 shadow',
                        'inactive' => 'bg-white text-blue-700 border-blue-200 hover:bg-blue-50',
                    ],
                    'DELIVERED' => [
                        'label' => 'Delivered',
                        'current' => 'bg-emerald-500 text-white border-emerald-500 shadow',
                        'inactive' => 'bg-white text-emerald-700 border-emerald-200 hover:bg-emerald-50',
                    ],
                    'CANCELLED' => [
                        'label' => 'Cancel',
                        'current' => 'bg-rose-500 text-white border-rose-500 shadow',
                        'inactive' => 'bg-white text-rose-700 border-rose-200 hover:bg-rose-50',
                    ],
                ];
            @endphp

            <!-- Back Button -->
            <div class="mb-6 flex items-center justify-between">
                <a href="{{ route('transaction.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-sm font-semibold rounded-lg shadow-sm hover:shadow transition duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Daftar Transaksi
                </a>
                <span class="hidden sm:inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $statusColor }}">
                    <span class="w-2 h-2 rounded-full mr-2 {{ $statusDot }}"></span>
                    {{ $item->status }}
                </span>
            </div>

            <!-- Flash Messages -->
            @if (session('success'))
                <div class="mb-6 flex items-center justify-between bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-lg text-sm" role="alert">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                </div>
            @endif
            @if (session('error'))
                <div class="mb-6 flex items-center justify-between bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded-lg text-sm" role="alert">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="font-medium">{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Kolom Utama (2/3) -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Kartu Detail Pesanan -->
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl border border-gray-100">
                        <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
                            <h3 class="text-lg font-bold text-gray-900">Detail Pesanan</h3>
                            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">#{{ $item->id }}</span>
                        </div>
                        <div class="p-6">
                            <div class="flex flex-col sm:flex-row gap-6">
                                @if ($foodImage)
                                    <img src="{{ Storage::url($foodImage) }}" alt="{{ $item->food->name ?? 'Makanan' }}" class="w-full sm:w-56 h-44 object-cover rounded-xl border border-gray-100">
                                @else
                                    <div class="w-full sm:w-56 h-44 rounded-xl bg-gradient-to-br from-emerald-100 via-emerald-50 to-teal-50 flex items-center justify-center border border-emerald-100">
                                        <span class="text-5xl font-bold text-emerald-600/80">{{ strtoupper(substr($item->food->name ?? '?', 0, 2)) }}</span>
                                    </div>
                                @endif
                                <div class="flex-1">
                                    <h4 class="text-xl font-bold text-gray-900">{{ $item->food->name ?? '-' }}</h4>
                                    <p class="text-sm text-gray-500 mt-0.5">{{ $item->food->types ?? '' }}</p>
                                    <p class="mt-3 text-sm text-gray-600 leading-relaxed">{{ $item->food->description ?? '-' }}</p>
                                    @if ($item->food->ingredients ?? null)
                                        <div class="mt-4">
                                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Bahan</p>
                                            <div class="flex flex-wrap gap-2">
                                                @foreach (explode(',', $item->food->ingredients) as $ingredient)
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-100">
                                                        {{ trim($ingredient) }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Ringkasan singkat -->
                            <div class="mt-6 grid grid-cols-3 gap-4 border-t border-gray-100 pt-5">
                                <div>
                                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Quantity</p>
                                    <p class="mt-1 text-lg font-bold text-gray-900">{{ $item->quantity ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Harga Satuan</p>
                                    <p class="mt-1 text-lg font-bold text-gray-900">Rp{{ number_format($item->food->price ?? 0, 0, ',', '.') }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total</p>
                                    <p class="mt-1 text-lg font-bold text-emerald-600">Rp{{ number_format($item->total ?? 0, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kartu Informasi Pembeli -->
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl border border-gray-100">
                        <div class="px-6 py-5 border-b border-gray-100">
                            <h3 class="text-lg font-bold text-gray-900">Informasi Pembeli</h3>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center mb-6">
                                <div class="h-12 w-12 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-base">
                                    {{ strtoupper(substr($item->user->name ?? '?', 0, 2)) }}
                                </div>
                                <div class="ml-4">
                                    <span class="block text-base font-bold text-gray-900">{{ $item->user->name ?? '-' }}</span>
                                    <span class="block text-sm text-gray-500">{{ $item->user->email ?? '' }}</span>
                                </div>
                            </div>
                            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4 text-sm">
                                <div>
                                    <dt class="text-gray-400">Telepon</dt>
                                    <dd class="mt-0.5 font-semibold text-gray-900">{{ $item->user->phoneNumber ?? '-' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-gray-400">Kota</dt>
                                    <dd class="mt-0.5 font-semibold text-gray-900">{{ $item->user->city ?? '-' }}</dd>
                                </div>
                                <div class="sm:col-span-2">
                                    <dt class="text-gray-400">Alamat</dt>
                                    <dd class="mt-0.5 font-semibold text-gray-900">
                                        {{ $item->user->address ?? '-' }}
                                        @if ($item->user->houseNumber ?? null)
                                            &middot; No. {{ $item->user->houseNumber }}
                                        @endif
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>

                <!-- Sidebar (1/3) -->
                <div class="space-y-6">
                    <!-- Ringkasan Order -->
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl border border-gray-100">
                        <div class="px-6 py-5 border-b border-gray-100">
                            <h3 class="text-lg font-bold text-gray-900">Ringkasan Order</h3>
                        </div>
                        <div class="px-6 py-5 space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">ID Transaksi</span>
                                <span class="font-semibold text-gray-900">#{{ $item->id }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Makanan</span>
                                <span class="font-semibold text-gray-900 text-right">{{ $item->food->name ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Qty</span>
                                <span class="font-semibold text-gray-900">{{ $item->quantity ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Tanggal</span>
                                <span class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y H:i') }}</span>
                            </div>
                            <div class="border-t border-dashed border-gray-200 pt-3 flex justify-between items-center text-sm">
                                <span class="font-semibold text-gray-900">Total</span>
                                <span class="font-bold text-emerald-600 text-base">Rp{{ number_format($item->total ?? 0, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Ubah Status -->
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl border border-gray-100">
                        <div class="px-6 py-5 border-b border-gray-100">
                            <h3 class="text-lg font-bold text-gray-900">Ubah Status</h3>
                        </div>
                        <div class="px-6 py-5 space-y-2">
                            @foreach ($statusOptions as $key => $option)
                                @php $isActive = $currentStatus === $key; @endphp
                                @if ($isActive)
                                    <div class="inline-flex items-center w-full px-4 py-2.5 rounded-lg border text-sm font-bold cursor-default {{ $option['current'] }}">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        {{ $option['label'] }}
                                        <span class="ml-auto text-xs font-semibold opacity-80">saat ini</span>
                                    </div>
                                @else
                                    <form action="{{ route('transactions.changeStatus', ['id' => $item->id, 'status' => $key]) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center w-full px-4 py-2.5 rounded-lg border text-sm font-bold transition duration-150 {{ $option['inactive'] }}">
                                            {{ $option['label'] }}
                                        </button>
                                    </form>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <!-- Pembayaran -->
                    @if ($item->payment_url)
                        <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl border border-gray-100">
                            <div class="px-6 py-5 border-b border-gray-100">
                                <h3 class="text-lg font-bold text-gray-900">Pembayaran</h3>
                            </div>
                            <div class="px-6 py-5">
                                <a href="{{ $item->payment_url }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow-sm hover:shadow transition duration-150">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                    </svg>
                                    Buka Halaman Pembayaran
                                </a>
                            </div>
                        </div>
                    @endif

                    <!-- Hapus Transaksi -->
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl border border-gray-100">
                        <div class="px-6 py-5">
                            <form action="{{ route('transactions.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 bg-rose-500 hover:bg-rose-600 text-white text-sm font-semibold rounded-lg shadow-sm hover:shadow transition duration-150">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Hapus Transaksi Ini
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
