<x-layouts.app>
    @php
        $transferMethods = $paymentMethods->get('transfer', collect());
        $ewalletMethods = $paymentMethods->get('ewallet', collect());
        $qrisMethods = $paymentMethods->get('qris', collect());

        $defaultTransfer = $transferMethods->first();
        $defaultEwallet = $ewalletMethods->first();
        $defaultQris = $qrisMethods->first();

        $defaultMethod = $defaultTransfer['code'] ?? $defaultEwallet['code'] ?? $defaultQris['code'] ?? '';
        $defaultMethodLabel = $defaultTransfer['label'] ?? $defaultEwallet['label'] ?? $defaultQris['label'] ?? 'Belum dipilih';
    @endphp

    <section class="min-h-screen pt-32 pb-20 bg-gray-50">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-10">
                <h1 class="font-poppins font-bold text-4xl text-gray-900 mb-3">Pembayaran Pesanan</h1>
                <p class="text-lg text-gray-600">
                    Pesanan #{{ $order->order_number }} -
                    <span class="font-bold text-orange-600">Rp{{ number_format($order->total_price, 0, ',', '.') }}</span>
                </p>
            </div>

            @if(session('success'))
                <div class="mb-6 p-4 rounded-lg bg-green-50 border border-green-200">
                    <p class="text-green-700 font-medium">{{ session('success') }}</p>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 p-4 rounded-lg bg-red-50 border border-red-200">
                    <p class="text-red-700 font-medium mb-2">Pembayaran belum berhasil:</p>
                    <ul class="list-disc pl-5 text-sm text-red-600 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 space-y-8">
                    <div class="bg-white rounded-xl shadow-md p-8">
                        <h2 class="font-poppins font-bold text-xl text-gray-900 mb-5">Ringkasan Pesanan</h2>
                        <div class="space-y-3 pb-5 border-b border-gray-200">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Nomor Pesanan</span>
                                <span class="font-medium text-gray-900">#{{ $order->order_number }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tanggal Pengiriman</span>
                                <span class="font-medium text-gray-900">{{ $order->pickup_date->format('d M Y') }}</span>
                            </div>
                            <div class="flex justify-between gap-3">
                                <span class="text-gray-600">Alamat Tujuan</span>
                                <span class="font-medium text-gray-900 text-right">{{ $order->delivery_address ?: (optional($order->user)->address ?? '-') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Referensi Pembayaran</span>
                                <span class="font-medium text-gray-900">{{ $order->payment_reference ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Total</span>
                                <span class="font-bold text-orange-600">Rp{{ number_format($order->total_price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <div class="mt-5 space-y-3">
                            @foreach($order->items as $item)
                                <div class="flex justify-between items-start p-3 bg-gray-50 rounded-lg">
                                    <div class="flex-1">
                                        <p class="font-medium text-gray-900">{{ $item->product_name }}</p>
                                        <p class="text-sm text-gray-600">{{ $item->quantity }} x Rp{{ number_format($item->price, 0, ',', '.') }}</p>
                                    </div>
                                    <p class="font-bold text-orange-600">Rp{{ number_format($item->subtotal, 0, ',', '.') }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    @if($order->status === 'waiting_payment')
                        <div class="bg-white rounded-xl shadow-md p-8">
                            <div class="flex items-center justify-between gap-4 mb-6">
                                <h2 class="font-poppins font-bold text-xl text-gray-900">Simulasi Payment Gateway Indonesia</h2>
                                <div class="px-3 py-2 rounded-lg bg-orange-50 border border-orange-200">
                                    <p class="text-xs text-orange-700">Batas bayar</p>
                                    <p class="text-lg font-bold text-orange-600" id="payment-countdown" data-expires-at="{{ optional($order->payment_expires_at)->toIso8601String() }}">--:--</p>
                                </div>
                            </div>

                            <div class="flex gap-2 mb-6 flex-wrap" id="payment-tabs">
                                @if($defaultTransfer)
                                    <button type="button" data-method="transfer" data-method-code="{{ $defaultTransfer['code'] }}" data-method-label="{{ $defaultTransfer['label'] }}" class="payment-tab active-tab px-4 py-2 rounded-lg font-medium text-sm transition-all duration-200 bg-orange-500 text-white shadow-md">
                                        🏦 Transfer Bank
                                    </button>
                                @endif
                                @if($defaultEwallet)
                                    <button type="button" data-method="ewallet" data-method-code="{{ $defaultEwallet['code'] }}" data-method-label="{{ $defaultEwallet['label'] }}" class="payment-tab px-4 py-2 rounded-lg font-medium text-sm transition-all duration-200 bg-white text-gray-700 border border-gray-200 hover:border-orange-300">
                                        📱 E-Wallet
                                    </button>
                                @endif
                                @if($defaultQris)
                                    <button type="button" data-method="qris" data-method-code="{{ $defaultQris['code'] }}" data-method-label="{{ $defaultQris['label'] }}" class="payment-tab px-4 py-2 rounded-lg font-medium text-sm transition-all duration-200 bg-white text-gray-700 border border-gray-200 hover:border-orange-300">
                                        📷 QRIS
                                    </button>
                                @endif
                            </div>

                            <div id="panel-transfer" class="payment-panel space-y-3 {{ $defaultTransfer ? '' : 'hidden' }}">
                                @foreach($transferMethods as $method)
                                    <button
                                        type="button"
                                        class="w-full text-left p-4 rounded-xl border border-gray-200 hover:border-orange-300 hover:bg-orange-50 transition-all"
                                        onclick="document.getElementById('selected-payment-method').value='{{ $method['code'] }}'; document.getElementById('selected-method-label').textContent='{{ $method['label'] }}';"
                                    >
                                        <p class="font-bold text-gray-900">{{ $method['label'] }}</p>
                                        <p class="text-sm text-gray-600">No. Tujuan: <span class="font-mono">{{ $method['account_number'] }}</span> ({{ $method['account_name'] }})</p>
                                        <p class="text-xs text-gray-500 mt-1">{{ $method['instruction'] }}</p>
                                    </button>
                                @endforeach
                            </div>

                            <div id="panel-ewallet" class="payment-panel hidden space-y-3">
                                @foreach($ewalletMethods as $method)
                                    <button
                                        type="button"
                                        class="w-full text-left p-4 rounded-xl border border-gray-200 hover:border-orange-300 hover:bg-orange-50 transition-all"
                                        onclick="document.getElementById('selected-payment-method').value='{{ $method['code'] }}'; document.getElementById('selected-method-label').textContent='{{ $method['label'] }}';"
                                    >
                                        <p class="font-bold text-gray-900">{{ $method['label'] }}</p>
                                        <p class="text-sm text-gray-600">No. Tujuan: <span class="font-mono">{{ $method['account_number'] }}</span> ({{ $method['account_name'] }})</p>
                                        <p class="text-xs text-gray-500 mt-1">{{ $method['instruction'] }}</p>
                                    </button>
                                @endforeach
                            </div>

                            <div id="panel-qris" class="payment-panel hidden space-y-3">
                                @foreach($qrisMethods as $method)
                                    <button
                                        type="button"
                                        class="w-full text-left p-4 rounded-xl border border-gray-200 hover:border-orange-300 hover:bg-orange-50 transition-all"
                                        onclick="document.getElementById('selected-payment-method').value='{{ $method['code'] }}'; document.getElementById('selected-method-label').textContent='{{ $method['label'] }}';"
                                    >
                                        <p class="font-bold text-gray-900">{{ $method['label'] }}</p>
                                        <p class="text-sm text-gray-600">Ref QRIS: <span class="font-mono">{{ $method['account_number'] }}</span> ({{ $method['account_name'] }})</p>
                                        <p class="text-xs text-gray-500 mt-1">{{ $method['instruction'] }}</p>
                                    </button>
                                @endforeach
                            </div>

                            <form method="POST" action="{{ route('order.upload-payment', $order) }}" class="mt-8">
                                @csrf
                                <input type="hidden" id="selected-payment-method" name="payment_method" value="{{ $defaultMethod }}">
                                <div class="mb-4 p-3 rounded-lg bg-blue-50 border border-blue-200">
                                    <p class="text-sm text-blue-700">Metode terpilih: <span id="selected-method-label" class="font-bold">{{ $defaultMethodLabel }}</span></p>
                                </div>
                                <button type="submit" class="w-full btn-primary py-3 rounded-lg font-medium">
                                    Bayar Sekarang (Simulasi)
                                </button>
                                <p class="text-xs text-gray-500 mt-3 text-center">
                                    Setelah klik tombol ini, pembayaran dianggap berhasil dan pesanan akan langsung masuk dashboard admin.
                                </p>
                            </form>
                        </div>
                    @else
                        <div class="bg-green-50 border border-green-200 rounded-xl p-6">
                            <h2 class="font-poppins font-bold text-lg text-green-800 mb-2">Status Pembayaran: {{ $order->status_label }}</h2>
                            <p class="text-green-700">Pesanan ini tidak berada pada status menunggu pembayaran.</p>
                            <div class="mt-4">
                                <x-button variant="primary" href="{{ route('dashboard') }}">Kembali ke Dashboard</x-button>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-md p-8 sticky top-24">
                        <h3 class="font-poppins font-bold text-xl text-gray-900 mb-6">Status Pesanan</h3>
                        <div class="mb-6">
                            @if($order->status === 'waiting_payment')
                                <span class="inline-block bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-semibold">⏳ Menunggu Pembayaran</span>
                            @elseif($order->status === 'payment_uploaded')
                                <span class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-semibold">💳 Menunggu Verifikasi Admin</span>
                            @elseif($order->status === 'cancelled')
                                <span class="inline-block bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-semibold">❌ Pesanan Dibatalkan</span>
                            @else
                                <span class="inline-block bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm font-semibold">{{ $order->status_label }}</span>
                            @endif
                        </div>

                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Payment Status</span>
                                <span class="font-medium">{{ strtoupper($order->payment_status ?? 'pending') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Referensi</span>
                                <span class="font-medium text-right">{{ $order->payment_reference ?? '-' }}</span>
                            </div>
                            @if($order->payment_paid_at)
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Waktu Bayar</span>
                                    <span class="font-medium text-right">{{ $order->payment_paid_at->format('d M Y H:i') }}</span>
                                </div>
                            @endif
                        </div>

                        <div class="mt-6 p-4 rounded-lg bg-blue-50 border border-blue-200">
                            <p class="text-sm text-blue-700 font-medium mb-2">💬 Butuh Bantuan?</p>
                            <a href="https://wa.me/6285183062643" target="_blank" class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                                Chat WhatsApp Admin
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
