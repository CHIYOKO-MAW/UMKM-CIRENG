<x-layouts.app>
    <!-- Admin Order Detail Section -->
    <section class="min-h-screen pt-32 pb-20 bg-gray-50">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-10 flex justify-between items-start">
                <div>
                    <h1 class="font-poppins font-bold text-4xl text-gray-900 mb-2">Detail Pesanan</h1>
                    <p class="text-lg text-gray-600">#{{ $order->order_number }}</p>
                </div>
                <x-button variant="outline" href="{{ route('admin.orders.index') }}">
                    ← Kembali
                </x-button>
            </div>

            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="mb-6 p-4 rounded-lg bg-green-50 border border-green-200">
                    <p class="text-green-700 font-medium">✅ {{ session('success') }}</p>
                </div>
            @endif
            @if($errors->any())
                <div class="mb-6 p-4 rounded-lg bg-red-50 border border-red-200">
                    <ul class="list-disc pl-5 text-sm text-red-700 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-8">

                    <!-- Order Info -->
                    <div class="bg-white rounded-xl shadow-md p-8">
                        <h2 class="font-poppins font-bold text-xl text-gray-900 mb-6">Informasi Pesanan</h2>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs text-gray-500 font-medium uppercase tracking-wide mb-1">Nomor Pesanan</p>
                                <p class="font-bold text-gray-900">#{{ $order->order_number }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 font-medium uppercase tracking-wide mb-1">Status</p>
                                @php
                                    $statusColors = [
                                        'waiting_payment' => 'bg-yellow-100 text-yellow-800',
                                        'payment_uploaded' => 'bg-blue-100 text-blue-800',
                                        'confirmed' => 'bg-green-100 text-green-800',
                                        'processing' => 'bg-purple-100 text-purple-800',
                                        'ready' => 'bg-indigo-100 text-indigo-800',
                                        'completed' => 'bg-green-100 text-green-800',
                                        'cancelled' => 'bg-red-100 text-red-800',
                                        'pending' => 'bg-gray-100 text-gray-800',
                                    ];
                                    $statusColor = $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="inline-block {{ $statusColor }} px-3 py-1 rounded-full text-sm font-semibold">
                                    {{ $order->status_label }}
                                </span>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 font-medium uppercase tracking-wide mb-1">Tanggal Pesan</p>
                                <p class="font-medium text-gray-900">{{ $order->created_at->format('d M Y H:i') }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 font-medium uppercase tracking-wide mb-1">Payment Status</p>
                                <p class="font-medium text-gray-900">{{ strtoupper($order->payment_status ?? 'pending') }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 font-medium uppercase tracking-wide mb-1">Tanggal Pengiriman</p>
                                <p class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($order->pickup_date)->format('d M Y') }}</p>
                            </div>
                            <div class="col-span-2">
                                <p class="text-xs text-gray-500 font-medium uppercase tracking-wide mb-1">Alamat Pengiriman</p>
                                @php
                                    $deliveryAddress = $order->delivery_address ?: ($order->user->address ?? null);
                                @endphp
                                <p class="font-medium text-gray-900">{{ $deliveryAddress ?? '-' }}</p>
                                @if($deliveryAddress)
                                    <a
                                        href="https://www.google.com/maps/search/?api=1&query={{ urlencode($deliveryAddress) }}"
                                        target="_blank"
                                        class="inline-block mt-2 text-xs font-medium text-orange-600 hover:text-orange-700"
                                    >
                                        Buka rute di Google Maps
                                    </a>
                                @endif
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 font-medium uppercase tracking-wide mb-1">Metode Pembayaran</p>
                                <p class="font-medium text-gray-900">{{ strtoupper($order->payment_method ?? '-') }}</p>
                            </div>
                            @if($order->pickup_time)
                            <div>
                                <p class="text-xs text-gray-500 font-medium uppercase tracking-wide mb-1">Waktu Pengiriman</p>
                                <p class="font-medium text-gray-900">{{ $order->pickup_time }}</p>
                            </div>
                            @endif
                            @if($order->confirmed_at)
                            <div>
                                <p class="text-xs text-gray-500 font-medium uppercase tracking-wide mb-1">Dikonfirmasi Pada</p>
                                <p class="font-medium text-gray-900">{{ $order->confirmed_at->format('d M Y H:i') }}</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Customer Info -->
                    <div class="bg-white rounded-xl shadow-md p-8">
                        <h2 class="font-poppins font-bold text-xl text-gray-900 mb-6">Informasi Pelanggan</h2>
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-14 h-14 rounded-full bg-orange-100 flex items-center justify-center text-2xl font-bold text-orange-600">
                                {{ strtoupper(substr($order->user->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-bold text-gray-900 text-lg">{{ $order->user->name }}</p>
                                <p class="text-gray-600">{{ $order->user->email }}</p>
                                @if($order->user->phone)
                                    <p class="text-gray-600">{{ $order->user->phone }}</p>
                                @endif
                            </div>
                        </div>
                        @if($order->user->address)
                            <div class="mt-4 p-3 bg-gray-50 rounded-lg">
                                <p class="text-xs text-gray-500 font-medium mb-1">Alamat</p>
                                <p class="text-gray-700">{{ $order->user->address }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Order Items -->
                    <div class="bg-white rounded-xl shadow-md p-8">
                        <h2 class="font-poppins font-bold text-xl text-gray-900 mb-6">Daftar Produk</h2>
                        <div class="space-y-3">
                            @foreach($order->items as $item)
                                <div class="flex justify-between items-start p-4 bg-gray-50 rounded-lg border border-gray-100">
                                    <div class="flex-1">
                                        <p class="font-bold text-gray-900">{{ $item->product_name }}</p>
                                        <p class="text-sm text-gray-600 mt-1">{{ $item->quantity }} pcs × Rp{{ number_format($item->price, 0, ',', '.') }}</p>
                                        @if($item->notes)
                                            <p class="text-xs text-orange-600 mt-1">📝 {{ $item->notes }}</p>
                                        @endif
                                    </div>
                                    <p class="font-bold text-orange-600 text-lg">Rp{{ number_format($item->subtotal, 0, ',', '.') }}</p>
                                </div>
                            @endforeach
                        </div>

                        <!-- Total -->
                        <div class="mt-6 pt-6 border-t-2 border-gray-200">
                            <div class="flex justify-between items-center">
                                <span class="font-bold text-xl text-gray-900">Total Pembayaran</span>
                                <span class="font-bold text-2xl text-orange-600">Rp{{ number_format($order->total_price, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        @if($order->notes)
                            <div class="mt-6 p-4 bg-blue-50 rounded-lg border border-blue-100">
                                <p class="text-sm font-medium text-blue-800 mb-1">📝 Catatan Pelanggan:</p>
                                <p class="text-blue-700">{{ $order->notes }}</p>
                            </div>
                        @endif
                    </div>

                </div>

                <!-- Sidebar: Update Status -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- Quick Actions -->
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <h3 class="font-poppins font-bold text-lg text-gray-900 mb-4">Aksi Cepat</h3>
                        <div class="space-y-3">
                            @if($order->status === 'payment_uploaded')
                                <form method="POST" action="{{ route('admin.orders.update-status', $order) }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="confirmed">
                                    <input type="hidden" name="admin_notes" value="Pembayaran telah dikonfirmasi.">
                                    <button type="submit" class="w-full py-2 px-4 bg-green-500 hover:bg-green-600 text-white rounded-lg font-medium text-sm transition-colors">
                                        ✅ Konfirmasi Pembayaran
                                    </button>
                                </form>
                            @endif
                            @if(in_array($order->status, ['confirmed']))
                                <form method="POST" action="{{ route('admin.orders.update-status', $order) }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="processing">
                                    <button type="submit" class="w-full py-2 px-4 bg-purple-500 hover:bg-purple-600 text-white rounded-lg font-medium text-sm transition-colors">
                                        👨‍🍳 Mulai Proses
                                    </button>
                                </form>
                            @endif
                            @if(in_array($order->status, ['processing']))
                                <form method="POST" action="{{ route('admin.orders.update-status', $order) }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="ready">
                                    <button type="submit" class="w-full py-2 px-4 bg-indigo-500 hover:bg-indigo-600 text-white rounded-lg font-medium text-sm transition-colors">
                                        📦 Tandai Siap Kirim
                                    </button>
                                </form>
                            @endif
                            @if(in_array($order->status, ['ready']))
                                <form method="POST" action="{{ route('admin.orders.update-status', $order) }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="completed">
                                    <button type="submit" class="w-full py-2 px-4 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium text-sm transition-colors">
                                        ✅ Selesaikan Pesanan
                                    </button>
                                </form>
                            @endif
                            @if(!in_array($order->status, ['completed', 'cancelled']))
                                <form method="POST" action="{{ route('admin.orders.update-status', $order) }}" onsubmit="return confirm('Batalkan pesanan ini?')">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="cancelled">
                                    <button type="submit" class="w-full py-2 px-4 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg font-medium text-sm transition-colors">
                                        ❌ Batalkan Pesanan
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>

                    <!-- Catatan Admin -->
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <h3 class="font-poppins font-bold text-lg text-gray-900 mb-6">Catatan Admin</h3>

                        <form method="POST" action="{{ route('admin.orders.update-status', $order) }}">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="{{ $order->status }}">

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Catatan Admin (Opsional)</label>
                                <textarea
                                    name="admin_notes"
                                    rows="3"
                                    class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:border-orange-500 outline-none text-sm resize-none"
                                    placeholder="Catatan untuk pelanggan..."
                                >{{ $order->admin_notes }}</textarea>
                            </div>

                            <button type="submit" class="w-full btn-primary py-3 rounded-lg font-medium text-sm text-center">
                                Simpan Catatan
                            </button>
                        </form>

                        @if($order->admin_notes)
                            <div class="mt-4 p-3 bg-orange-50 rounded-lg border border-orange-100">
                                <p class="text-xs text-orange-700 font-medium mb-1">Catatan Admin Saat Ini:</p>
                                <p class="text-xs text-orange-600">{{ $order->admin_notes }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Order Summary Card -->
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <h3 class="font-poppins font-bold text-lg text-gray-900 mb-4">Ringkasan</h3>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Total Item</span>
                                <span class="font-medium">{{ $order->items->sum('quantity') }} pcs</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="font-medium">Rp{{ number_format($order->subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between pt-3 border-t border-gray-200">
                                <span class="font-bold text-gray-900">Total</span>
                                <span class="font-bold text-orange-600">Rp{{ number_format($order->total_price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
