<x-layouts.app>
    <!-- Order Details Section -->
    <section class="min-h-screen pt-32 pb-20 bg-gray-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-12 flex justify-between items-start">
                <div>
                    <h1 class="font-poppins font-bold text-4xl text-gray-900 mb-4">Detail Pesanan</h1>
                    <p class="text-lg text-gray-600">Pesanan #{{ $order->order_number }}</p>
                </div>
                <a href="/dashboard" class="text-gray-600 hover:text-gray-900 transition-colors inline-flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Status Section -->
                    <div class="bg-white rounded-xl shadow-md p-8">
                        <h2 class="font-poppins font-bold text-xl text-gray-900 mb-6">Status Pesanan</h2>

                        <!-- Status Badge -->
                        <div class="mb-8">
                            @if($order->status === 'waiting_payment')
                                <div class="inline-block bg-yellow-100 text-yellow-800 px-4 py-2 rounded-full font-medium text-sm">
                                    ⏳ Menunggu Pembayaran
                                </div>
                            @elseif($order->status === 'payment_uploaded')
                                <div class="inline-block bg-blue-100 text-blue-800 px-4 py-2 rounded-full font-medium text-sm">
                                    🔎 Menunggu Verifikasi Admin
                                </div>
                            @elseif($order->status === 'confirmed')
                                <div class="inline-block bg-green-100 text-green-800 px-4 py-2 rounded-full font-medium text-sm">
                                    ✓ Pesanan Dikonfirmasi
                                </div>
                            @elseif($order->status === 'processing')
                                <div class="inline-block bg-purple-100 text-purple-800 px-4 py-2 rounded-full font-medium text-sm">
                                    👨‍🍳 Sedang Diproses
                                </div>
                            @elseif($order->status === 'ready')
                                <div class="inline-block bg-indigo-100 text-indigo-800 px-4 py-2 rounded-full font-medium text-sm">
                                    📦 Siap Dikirim
                                </div>
                            @elseif($order->status === 'completed')
                                <div class="inline-block bg-green-100 text-green-800 px-4 py-2 rounded-full font-medium text-sm">
                                    ✅ Pesanan Selesai
                                </div>
                            @elseif($order->status === 'cancelled')
                                <div class="inline-block bg-red-100 text-red-800 px-4 py-2 rounded-full font-medium text-sm">
                                    ❌ Pesanan Dibatalkan
                                </div>
                            @endif
                        </div>

                        <!-- Timeline -->
                        <div class="space-y-4">
                            <div class="flex gap-3">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 rounded-full {{ $order->status !== null ? 'bg-green-100' : 'bg-gray-200' }} flex items-center justify-center">
                                        <svg class="w-5 h-5 {{ $order->status !== null ? 'text-green-600' : 'text-gray-400' }}" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">Pesanan Dibuat</p>
                                    <p class="text-sm text-gray-500">{{ $order->created_at->format('d M Y H:i') }}</p>
                                </div>
                            </div>

                            <div class="flex gap-3">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 rounded-full {{ in_array($order->status, ['payment_uploaded', 'confirmed', 'processing', 'ready', 'completed']) ? 'bg-green-100' : 'bg-gray-200' }} flex items-center justify-center">
                                        <svg class="w-5 h-5 {{ in_array($order->status, ['payment_uploaded', 'confirmed', 'processing', 'ready', 'completed']) ? 'text-green-600' : 'text-gray-400' }}" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">Menunggu Verifikasi Admin</p>
                                    @if($order->status !== 'waiting_payment')
                                        <p class="text-sm text-gray-500">Pembayaran telah diterima, pesanan menunggu diproses admin</p>
                                    @else
                                        <p class="text-sm text-gray-500">Menunggu penyelesaian pembayaran</p>
                                    @endif
                                </div>
                            </div>

                            <div class="flex gap-3">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 rounded-full {{ in_array($order->status, ['confirmed', 'processing', 'ready', 'completed']) ? 'bg-green-100' : 'bg-gray-200' }} flex items-center justify-center">
                                        <svg class="w-5 h-5 {{ in_array($order->status, ['confirmed', 'processing', 'ready', 'completed']) ? 'text-green-600' : 'text-gray-400' }}" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">Pesanan Diproses</p>
                                    <p class="text-sm text-gray-500">Produk sedang disiapkan</p>
                                </div>
                            </div>

                            <div class="flex gap-3">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 rounded-full {{ in_array($order->status, ['ready', 'completed']) ? 'bg-green-100' : 'bg-gray-200' }} flex items-center justify-center">
                                        <svg class="w-5 h-5 {{ in_array($order->status, ['ready', 'completed']) ? 'text-green-600' : 'text-gray-400' }}" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">Pesanan Dikirim</p>
                                    <p class="text-sm text-gray-500">{{ Carbon\Carbon::parse($order->pickup_date)->format('d M Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Details -->
                    <div class="bg-white rounded-xl shadow-md p-8">
                        <h2 class="font-poppins font-bold text-xl text-gray-900 mb-6">Detail Pesanan</h2>

                        <div class="space-y-4 pb-6 border-b border-gray-200">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Nomor Pesanan</span>
                                <span class="font-medium text-gray-900">#{{ $order->order_number }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tanggal Pesan</span>
                                <span class="font-medium text-gray-900">{{ $order->created_at->format('d M Y H:i') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tanggal Pengiriman</span>
                                <span class="font-medium text-gray-900">{{ Carbon\Carbon::parse($order->pickup_date)->format('d M Y') }}</span>
                            </div>
                            <div class="flex justify-between gap-3">
                                <span class="text-gray-600">Alamat Pengiriman</span>
                                <span class="font-medium text-gray-900 text-right">{{ $order->delivery_address ?: (optional($order->user)->address ?? '-') }}</span>
                            </div>
                            @if($order->pickup_time)
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Waktu Pengiriman</span>
                                    <span class="font-medium text-gray-900">{{ $order->pickup_time }}</span>
                                </div>
                            @endif
                        </div>

                        <!-- Order Items -->
                        <div class="mt-6">
                            <h3 class="font-poppins font-bold text-lg text-gray-900 mb-4">Daftar Produk</h3>
                            <div class="space-y-3">
                                @foreach($order->items as $item)
                                    <div class="flex justify-between items-start p-3 bg-gray-50 rounded-lg">
                                        <div class="flex-1">
                                            <p class="font-medium text-gray-900">{{ $item->product_name }}</p>
                                            <p class="text-sm text-gray-600">{{ $item->quantity }} x Rp{{ number_format($item->price, 0, ',', '.') }}</p>
                                            @if($item->notes)
                                                <p class="text-xs text-gray-500 mt-1">📝 {{ $item->notes }}</p>
                                            @endif
                                        </div>
                                        <p class="font-bold text-orange-600">Rp{{ number_format($item->subtotal, 0, ',', '.') }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Notes -->
                        @if($order->notes)
                            <div class="mt-6 pt-6 border-t border-gray-200">
                                <p class="text-sm text-gray-600 font-medium mb-2">Catatan Pesanan:</p>
                                <p class="text-gray-700">{{ $order->notes }}</p>
                            </div>
                        @endif

                        <!-- Total -->
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <div class="flex justify-between">
                                <span class="font-bold text-lg text-gray-900">Total Harga</span>
                                <span class="font-bold text-2xl text-orange-600">Rp{{ number_format($order->total_price, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="mt-8 flex gap-4 flex-wrap">
                            @if($order->status === 'waiting_payment')
                                <a href="{{ route('order.payment', $order) }}" class="flex-1 btn btn-primary py-3 rounded-lg font-medium text-center transition-all duration-300">
                                    Bayar Sekarang
                                </a>
                            @endif
                            <a href="{{ route('order.invoice', $order) }}" target="_blank" class="btn btn-outline py-3 px-4 rounded-lg font-medium text-center transition-all duration-300">
                                🧾 Lihat Invoice
                            </a>
                            <x-button variant="outline" href="/dashboard" class="flex-1">
                                Kembali ke Dashboard
                            </x-button>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-md p-8 sticky top-24">
                        <h3 class="font-poppins font-bold text-xl text-gray-900 mb-6">Ringkasan</h3>

                        <div class="space-y-4">
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Subtotal</p>
                                <p class="font-bold text-gray-900">Rp{{ number_format($order->subtotal, 0, ',', '.') }}</p>
                            </div>
                            <div class="pt-4 border-t border-gray-200">
                                <p class="text-sm text-gray-600 mb-1">Total</p>
                                <p class="font-bold text-2xl text-orange-600">Rp{{ number_format($order->total_price, 0, ',', '.') }}</p>
                            </div>
                        </div>

                        <!-- Contact Support -->
                        <div class="mt-8 p-4 rounded-lg bg-blue-50 border border-blue-200">
                            <p class="text-sm text-blue-700 font-medium mb-3">❓ Butuh Bantuan?</p>
<a href="https://wa.me/6285183062643" target="_blank" class="inline-flex items-center gap-2 text-sm text-blue-600 hover:text-blue-700 font-medium">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.67-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.076 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421-7.403h-.004a9.87 9.87 0 00-4.946 1.217l-.335.182-.348-.052c-1.136-.08-2.216-.256-3.214-.5L2.702 4.127l.323 1.039c.393 1.259.926 2.417 1.601 3.541L3.4 9.25c-.213.529-.424 1.06-.624 1.585-1.454-1.13-2.323-2.79-2.323-4.587A9.972 9.972 0 0112.051 2.05c5.527 0 10.04 4.513 10.04 10.04 0 5.527-4.513 10.04-10.04 10.04-1.98 0-3.835-.584-5.396-1.59l-.337-.214-.36.043c-1.136.091-2.216.256-3.214.5l1.102-1.81c.471-.772.906-1.579 1.297-2.416 1.02 1.13 2.427 1.835 3.993 1.835 3.032 0 5.5-2.468 5.5-5.5s-2.468-5.5-5.5-5.5z"/>
                                </svg>
                                Chat WhatsApp
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
