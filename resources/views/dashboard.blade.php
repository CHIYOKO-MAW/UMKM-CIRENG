<x-layouts.app>
    <!-- Dashboard Section -->
    <section class="min-h-screen pt-32 pb-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-12 flex justify-between items-center">
                <div>
                    <h1 class="font-poppins font-bold text-4xl text-gray-900 mb-2">Dashboard</h1>
                    <p class="text-lg text-gray-600">Selamat datang, {{ Auth::user()->name }}!</p>
                </div>
                <x-button variant="primary" href="{{ route('order.create') }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Pesan Sekarang
                </x-button>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-6 p-4 rounded-lg bg-green-50 border border-green-200">
                    <p class="text-green-600 font-medium">{{ session('success') }}</p>
                </div>
            @endif

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                <!-- Total Orders -->
                <div class="bg-white rounded-xl shadow-md p-8" data-aos="fade-up">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 font-medium mb-2">Total Pesanan</p>
                            <p class="font-poppins font-bold text-3xl text-gray-900">{{ $totalOrders }}</p>
                        </div>
                        <div class="w-16 h-16 rounded-full bg-blue-100 flex items-center justify-center text-2xl">
                            📋
                        </div>
                    </div>
                </div>

                <!-- Completed Orders -->
                <div class="bg-white rounded-xl shadow-md p-8" data-aos="fade-up" data-aos-delay="100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 font-medium mb-2">Pesanan Selesai</p>
                            <p class="font-poppins font-bold text-3xl text-gray-900">{{ $completedOrders }}</p>
                        </div>
                        <div class="w-16 h-16 rounded-full bg-green-100 flex items-center justify-center text-2xl">
                            ✅
                        </div>
                    </div>
                </div>

                <!-- Pending Orders -->
                <div class="bg-white rounded-xl shadow-md p-8" data-aos="fade-up" data-aos-delay="200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 font-medium mb-2">Pesanan Aktif</p>
                            <p class="font-poppins font-bold text-3xl text-gray-900">{{ $pendingOrders }}</p>
                        </div>
                        <div class="w-16 h-16 rounded-full bg-orange-100 flex items-center justify-center text-2xl">
                            ⏳
                        </div>
                    </div>
                </div>
            </div>

            <!-- Orders Tabs -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <!-- Tab Navigation -->
                <div class="border-b border-gray-200 flex gap-4 px-8" role="tablist">
                    <button type="button" role="tab" data-tab="all" class="tab-btn py-4 px-2 border-b-2 border-orange-500 text-orange-600 font-medium transition-colors duration-300 active" aria-selected="true">
                        Semua Pesanan
                    </button>
                    <button type="button" role="tab" data-tab="pending" class="tab-btn py-4 px-2 text-gray-600 hover:text-gray-900 font-medium transition-colors duration-300" aria-selected="false">
                        Pesanan Aktif
                    </button>
                    <button type="button" role="tab" data-tab="completed" class="tab-btn py-4 px-2 text-gray-600 hover:text-gray-900 font-medium transition-colors duration-300" aria-selected="false">
                        Selesai
                    </button>
                </div>

                <!-- Tab Content -->
                <div class="p-8">
                    @if($orders->count() > 0)
                        <div class="space-y-4" id="orders-content">
                            @foreach($orders as $order)
                                <div class="order-item border border-gray-200 rounded-lg p-6 hover:shadow-md transition-all duration-300" data-status="{{ $order->status }}">
                                    <div class="flex justify-between items-start mb-4">
                                        <div>
                                            <h3 class="font-poppins font-bold text-gray-900 text-lg">#{{ $order->order_number }}</h3>
                                            <p class="text-sm text-gray-600">{{ $order->created_at->format('d M Y H:i') }}</p>
                                        </div>

                                        <!-- Status Badge -->
                                        @if($order->status === 'waiting_payment')
                                            <div class="inline-block bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-semibold">
                                                ⏳ Menunggu Pembayaran
                                            </div>
                                        @elseif($order->status === 'payment_uploaded')
                                            <div class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-semibold">
                                                🔎 Menunggu Verifikasi Admin
                                            </div>
                                        @elseif($order->status === 'confirmed')
                                            <div class="inline-block bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-semibold">
                                                ✓ Dikonfirmasi
                                            </div>
                                        @elseif($order->status === 'processing')
                                            <div class="inline-block bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-xs font-semibold">
                                                👨‍🍳 Diproses
                                            </div>
                                        @elseif($order->status === 'ready')
                                            <div class="inline-block bg-indigo-100 text-indigo-800 px-3 py-1 rounded-full text-xs font-semibold">
                                                📦 Siap Dikirim
                                            </div>
                                        @elseif($order->status === 'completed')
                                            <div class="inline-block bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-semibold">
                                                ✅ Selesai
                                            </div>
                                        @elseif($order->status === 'cancelled')
                                            <div class="inline-block bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs font-semibold">
                                                ❌ Dibatalkan
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Order Items Preview -->
                                    <div class="mb-4">
                                        <p class="text-sm text-gray-600 font-medium mb-2">Produk:</p>
                                        <div class="flex gap-2 flex-wrap">
                                            @foreach($order->items as $item)
                                                <span class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded">
                                                    {{ $item->product_name }} x{{ $item->quantity }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>

                                    <!-- Order Details -->
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6 pb-6 border-b border-gray-200">
                                        <div>
                                            <p class="text-xs text-gray-600 font-medium">Tanggal Pengiriman</p>
                                            <p class="text-sm font-medium text-gray-900">{{ Carbon\Carbon::parse($order->pickup_date)->format('d M Y') }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-600 font-medium">Subtotal</p>
                                            <p class="text-sm font-medium text-gray-900">Rp{{ number_format($order->subtotal, 0, ',', '.') }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-600 font-medium">Total</p>
                                            <p class="text-sm font-bold text-orange-600">Rp{{ number_format($order->total_price, 0, ',', '.') }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-600 font-medium">Total Item</p>
                                            <p class="text-sm font-medium text-gray-900">{{ $order->items->sum('quantity') }} pcs</p>
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="flex gap-4">
                                        <a href="{{ route('order.show', $order) }}" class="text-orange-600 hover:text-orange-700 font-medium text-sm transition-colors">
                                            Lihat Detail
                                        </a>
                                        @if($order->status === 'waiting_payment')
                                            <a href="{{ route('order.payment', $order) }}" class="text-orange-600 hover:text-orange-700 font-medium text-sm transition-colors">
                                                Bayar Sekarang
                                            </a>
                                        @endif
                                    </div>

                                    @if($order->status === 'waiting_payment' && $order->payment_expires_at)
                                        <div class="mt-4 p-3 rounded-lg bg-yellow-50 border border-yellow-200">
                                            <p class="text-xs text-yellow-800">
                                                Batas pembayaran:
                                                <span class="font-bold">{{ $order->payment_expires_at->format('d M Y H:i') }}</span>
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-8">
                            {{ $orders->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="text-6xl mb-4">🛒</div>
                            <p class="text-gray-600 font-medium mb-6">Anda belum memiliki pesanan</p>
                            <x-button variant="primary" href="{{ route('order.create') }}">
                                Mulai Pesan Sekarang
                            </x-button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
