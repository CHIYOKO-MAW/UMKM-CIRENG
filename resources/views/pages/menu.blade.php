<x-layouts.app>
    <!-- Hero Section -->
    <section class="min-h-screen flex items-center justify-center pt-32 pb-20 bg-gradient-to-br from-orange-50 via-white to-orange-50 relative overflow-hidden">
        <!-- Decorative Background Elements -->
        <div class="absolute top-10 left-10 w-72 h-72 bg-orange-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse"></div>
        <div class="absolute bottom-10 right-10 w-72 h-72 bg-orange-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse" style="animation-delay: 2s;"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full">
            <!-- Header -->
            <div class="text-center mb-16" data-aos="fade-up">
                <h1 class="font-poppins font-bold text-5xl lg:text-6xl text-gray-900 mb-4 leading-tight">
                    Menu <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-400 to-orange-600">Produk Kami</span>
                </h1>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    Pilih cireng rujak favorit Anda dari berbagai varian rasa yang tersedia dengan kualitas premium
                </p>
            </div>

            <!-- Filter Section -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-12" data-aos="fade-up" data-aos-delay="100">
                <div class="flex gap-2 flex-wrap justify-center">
                    <button class="filter-btn px-6 py-2 rounded-full bg-orange-500 text-white font-medium transition-all duration-300"
                        data-category="all">
                        Semua Produk
                    </button>
                    @foreach($categories as $category)
                        <button class="filter-btn px-6 py-2 rounded-full bg-white text-gray-700 border-2 border-gray-200 font-medium hover:border-orange-400 hover:text-orange-600 transition-all duration-300"
                            data-category="{{ $category }}">
                            {{ ucfirst($category) }}
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Products Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="products-container">
                @forelse($products as $product)
                    <div class="product-item" data-category="{{ $product->category }}">
                        <x-product-card
                            image="{{ $product->image_url }}"
                            name="{{ $product->name }}"
                            description="{{ Str::limit($product->description, 80) }}"
                            price="{{ number_format($product->price, 0, ',', '.') }}"
                            original_price="{{ $product->original_price ? number_format($product->original_price, 0, ',', '.') : null }}"
                            rating="{{ $product->rating ?? 5 }}"
                            reviews="{{ $product->reviews_count ?? 0 }}"
                        />
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-gray-600 text-lg">Produk tidak tersedia. Silakan kembali lagi nanti.</p>
                    </div>
                @endforelse
            </div>

            <!-- No Results Message -->
            <div id="no-results" class="hidden col-span-full text-center py-12">
                <p class="text-gray-600 text-lg">Tidak ada produk yang sesuai dengan filter yang dipilih.</p>
            </div>
        </div>
    </section>

    <!-- Why Choose Us Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="font-poppins font-bold text-4xl text-gray-900 mb-4">Mengapa Memilih Kami?</h2>
                <p class="text-lg text-gray-600">Kami berkomitmen untuk memberikan produk terbaik dengan layanan pelanggan terbaik</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center" data-aos="fade-up">
                    <div class="w-16 h-16 rounded-full bg-orange-100 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="font-poppins font-bold text-xl text-gray-900 mb-2">Kualitas Terjamin</h3>
                    <p class="text-gray-600">Semua produk kami dibuat dengan bahan pilihan dan standar kualitas tertinggi</p>
                </div>

                <div class="text-center" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-16 h-16 rounded-full bg-orange-100 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="font-poppins font-bold text-xl text-gray-900 mb-2">Pengiriman Cepat</h3>
                    <p class="text-gray-600">Kami mengirimkan pesanan Anda tepat waktu dalam kondisi segar dan optimal</p>
                </div>

                <div class="text-center" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-16 h-16 rounded-full bg-orange-100 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <h3 class="font-poppins font-bold text-xl text-gray-900 mb-2">Layanan Terbaik</h3>
                    <p class="text-gray-600">Tim kami siap membantu Anda kapan saja dengan respons cepat dan profesional</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-r from-orange-500 to-orange-600 text-white">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="font-poppins font-bold text-4xl mb-6" data-aos="fade-up">
                Siap Memulai Pesanan Anda?
            </h2>
            <p class="text-xl mb-8 text-orange-50" data-aos="fade-up" data-aos-delay="100">
                Pilih produk favorit Anda dan pesan sekarang juga!
            </p>
            <x-button variant="white" size="lg" href="/" class="w-full sm:w-auto" data-aos="fade-up" data-aos-delay="200">
                Kembali ke Beranda
            </x-button>
        </div>
    </section>

</x-layouts.app>
