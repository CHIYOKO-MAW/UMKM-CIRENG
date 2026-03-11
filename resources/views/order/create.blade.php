<x-layouts.app>
    <!-- Order Creation Section -->
    <section class="min-h-screen pt-32 pb-20 bg-gray-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-12">
                <h1 class="font-poppins font-bold text-4xl text-gray-900 mb-4">Pre-Order Cireng Rujak</h1>
                <p class="text-lg text-gray-600">Pesan sekarang untuk tanggal pengiriman yang Anda inginkan</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Order Form -->
                <div class="lg:col-span-2">
                    <form method="POST" action="{{ route('order.store') }}" id="order-form" class="space-y-8">
                        @csrf

                        @if($errors->any())
                            <div class="mb-6 p-4 rounded-lg bg-red-50 border border-red-200">
                                <p class="text-red-700 font-medium mb-2">Periksa data pesanan Anda:</p>
                                <ul class="list-disc pl-5 text-sm text-red-600 space-y-1">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Pickup Date Section -->
                        <div class="bg-white rounded-xl shadow-md p-8">
                            <h2 class="font-poppins font-bold text-xl text-gray-900 mb-6">1. Jadwal Pengiriman</h2>

                            <div>
                                <label for="pickup_date" class="block text-sm font-medium text-gray-700 mb-3">
                                    Pilih Tanggal Pengiriman
                                </label>
                                <input
                                    type="date"
                                    id="pickup_date"
                                    name="pickup_date"
                                    required
                                    value="{{ old('pickup_date') }}"
                                    min="{{ now()->addDay()->format('Y-m-d') }}"
                                    class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none transition-all duration-300"
                                >
                                @error('pickup_date')
                                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                @enderror
                                <p class="text-sm text-gray-500 mt-2">Minimum pengiriman besok (hari berikutnya)</p>
                            </div>

                            <div class="mt-6">
                                <label for="pickup_time" class="block text-sm font-medium text-gray-700 mb-3">
                                    Waktu Pengiriman (Opsional)
                                </label>
                                <select
                                    id="pickup_time"
                                    name="pickup_time"
                                    class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none transition-all duration-300"
                                >
                                    <option value="">-- Pilih Waktu --</option>
                                    <option value="08:00-10:00" {{ old('pickup_time') === '08:00-10:00' ? 'selected' : '' }}>08:00 - 10:00</option>
                                    <option value="10:00-12:00" {{ old('pickup_time') === '10:00-12:00' ? 'selected' : '' }}>10:00 - 12:00</option>
                                    <option value="12:00-14:00" {{ old('pickup_time') === '12:00-14:00' ? 'selected' : '' }}>12:00 - 14:00</option>
                                    <option value="14:00-16:00" {{ old('pickup_time') === '14:00-16:00' ? 'selected' : '' }}>14:00 - 16:00</option>
                                    <option value="16:00-18:00" {{ old('pickup_time') === '16:00-18:00' ? 'selected' : '' }}>16:00 - 18:00</option>
                                </select>
                            </div>
                        </div>

                        <!-- Delivery Address Section -->
                        <div class="bg-white rounded-xl shadow-md p-8">
                            <h2 class="font-poppins font-bold text-xl text-gray-900 mb-6">2. Alamat Pengiriman</h2>

                            <div>
                                <label for="delivery_address" class="block text-sm font-medium text-gray-700 mb-3">
                                    Alamat Lengkap Tujuan
                                </label>
                                <textarea
                                    id="delivery_address"
                                    name="delivery_address"
                                    rows="4"
                                    required
                                    class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none transition-all duration-300"
                                    placeholder="Contoh: Jl. Melati No. 8, RT 02/RW 01, Sukamaju, Kec. Cibinong, Kab. Bogor"
                                >{{ old('delivery_address', $user->address) }}</textarea>
                                @error('delivery_address')
                                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                @enderror
                                <p class="text-sm text-gray-500 mt-2">Pastikan detail alamat jelas agar pengiriman tepat lokasi.</p>
                            </div>
                        </div>

                        <!-- Products Section -->
                        <div class="bg-white rounded-xl shadow-md p-8">
                            <h2 class="font-poppins font-bold text-xl text-gray-900 mb-6">3. Pilih Produk</h2>

                            @error('items')
                                <div class="mb-6 p-4 rounded-lg bg-red-50 border border-red-200">
                                    <p class="text-red-600 text-sm">{{ $message }}</p>
                                </div>
                            @enderror

                            <div class="space-y-4" id="order-items">
                                @php
                                    $groupedProducts = $products->groupBy('category');
                                @endphp

                                @foreach($groupedProducts as $category => $categoryProducts)
                                    <div class="border-b border-gray-200 pb-6 last:border-b-0">
                                        <h3 class="font-poppins font-bold text-lg text-gray-900 mb-4">{{ ucfirst($category) }}</h3>

                                        @foreach($categoryProducts as $product)
                                            <div class="flex items-center gap-4 p-4 rounded-lg border border-gray-200 hover:border-orange-300 hover:bg-orange-50 transition-all duration-300">
                                                <!-- Product Image -->
                                                <div class="w-16 h-16 rounded-lg overflow-hidden flex-shrink-0 bg-gray-200">
                                                    <img
                                                        src="{{ $product->image_url }}"
                                                        alt="{{ $product->name }}"
                                                        class="w-full h-full object-cover"
                                                    >
                                                </div>

                                                <div class="flex-1">
                                                    <h4 class="font-medium text-gray-900">{{ $product->name }}</h4>
                                                    <p class="text-sm text-gray-600">{{ Str::limit($product->description, 60) }}</p>
                                                    <p class="font-bold text-orange-600 mt-1">
                                                        Rp{{ number_format($product->price, 0, ',', '.') }}
                                                    </p>
                                                </div>

                                                <div class="flex items-center gap-2">
                                                    <input
                                                        type="number"
                                                        name="items[{{ $product->id }}][quantity]"
                                                        min="0"
                                                        value="{{ old('items.' . $product->id . '.quantity', 0) }}"
                                                        class="w-20 px-3 py-2 border border-gray-200 rounded-lg text-center focus:border-orange-500 outline-none"
                                                        data-product-id="{{ $product->id }}"
                                                        data-price="{{ $product->price }}"
                                                    >
                                                    <span class="text-sm text-gray-500">pcs</span>
                                                </div>

                                                <input
                                                    type="hidden"
                                                    name="items[{{ $product->id }}][product_id]"
                                                    value="{{ $product->id }}"
                                                >
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>

                            <p class="text-sm text-gray-500 mt-6">Masukkan jumlah (0 untuk tidak memesan)</p>
                        </div>

                        <!-- Notes Section -->
                        <div class="bg-white rounded-xl shadow-md p-8">
                            <h2 class="font-poppins font-bold text-xl text-gray-900 mb-6">4. Catatan Tambahan</h2>

                            <div>
                                <label for="notes" class="block text-sm font-medium text-gray-700 mb-3">
                                    Catatan Pesanan (Opsional)
                                </label>
                                <textarea
                                    id="notes"
                                    name="notes"
                                    rows="4"
                                    class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none transition-all duration-300"
                                    placeholder="Contoh: Tidak terlalu pedas, tambah kacang, dll."
                                >{{ old('notes') }}</textarea>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex gap-4">
                            <x-button variant="primary" size="lg" type="submit" class="flex-1">
                                Lanjutkan ke Pembayaran
                            </x-button>
                            <x-button variant="outline" size="lg" href="/" class="flex-1">
                                Batal
                            </x-button>
                        </div>
                    </form>
                </div>

                <!-- Order Summary Sidebar -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-md p-8 sticky top-24">
                        <h3 class="font-poppins font-bold text-xl text-gray-900 mb-6">Ringkasan Pesanan</h3>

                        <div class="space-y-3 pb-6 border-b border-gray-200" id="order-summary">
                            <p class="text-sm text-gray-600">Pesanan akan muncul di sini</p>
                        </div>

                        <div class="space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="font-medium text-gray-900" id="subtotal">Rp0</span>
                            </div>

                            <div class="pt-3 border-t border-gray-200">
                                <div class="flex justify-between">
                                    <span class="font-bold text-gray-900">Total Harga</span>
                                    <span class="font-bold text-xl text-orange-600" id="total">Rp0</span>
                                </div>
                            </div>
                        </div>

                        <!-- Info Box -->
                        <div class="mt-8 p-4 rounded-lg bg-blue-50 border border-blue-200">
                            <p class="text-sm text-blue-700 font-medium mb-2">💡 Informasi</p>
                            <p class="text-xs text-blue-600">Free ongkos kirim untuk area tertentu. Pengiriman sesuai jadwal yang dipilih.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
