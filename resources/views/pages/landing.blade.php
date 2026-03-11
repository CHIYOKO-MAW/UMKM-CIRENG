<x-layouts.app>
    <!-- Hero Section -->
    <section id="home" class="min-h-screen flex items-center justify-center pt-20 pb-20 bg-gradient-to-br from-orange-50 via-white to-orange-50 overflow-hidden relative">
        <!-- Decorative Background Elements -->
        <div class="absolute top-10 left-10 w-72 h-72 bg-orange-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse"></div>
        <div class="absolute bottom-10 right-10 w-72 h-72 bg-orange-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse" style="animation-delay: 2s;"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Hero Content -->
                <div class="text-center lg:text-left" data-aos="fade-right" data-aos-duration="800">
                    <h1 class="font-poppins font-bold text-5xl lg:text-6xl text-gray-900 mb-6 leading-tight">
                        Cireng Rujak <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-400 to-orange-600">Premium</span>
                    </h1>
                    <p class="text-lg text-gray-600 mb-8 leading-relaxed max-w-lg mx-auto lg:mx-0">
                        Nikmati kelezatan cireng rujak autentik dengan bahan-bahan pilihan premium. Tersedia dalam berbagai varian rasa yang menggugah selera. Pre-order sekarang dan dapatkan kesegaran langsung ke tangan Anda!
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        @auth
                            <x-button variant="primary" size="lg" href="{{ route('order.create') }}" class="w-full sm:w-auto">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                                Pesan Sekarang
                            </x-button>
                        @else
                            <x-button variant="primary" size="lg" href="{{ route('register') }}" class="w-full sm:w-auto">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                                Pesan Sekarang
                            </x-button>
                        @endauth
                        <x-button variant="outline" size="lg" href="#about" class="w-full sm:w-auto">
                            Pelajari Lebih Lanjut
                        </x-button>
                    </div>

                    <!-- Trust Badges -->
                    <div class="mt-12 pt-8 border-t border-gray-200">
                        <p class="text-sm text-gray-500 mb-4">Dipercaya oleh ribuan pelanggan</p>
                        <div class="flex flex-wrap gap-6 justify-center lg:justify-start">
                            <div class="flex items-center gap-2">
                                <svg class="w-6 h-6 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 3.062v6.006a3.066 3.066 0 01-3.062 3.062H5.5a3.066 3.066 0 01-3.062-3.062V6.517a3.066 3.066 0 012.812-3.062zm7.501 6.753H12a.75.75 0 01-.75-.75V8.5a.75.75 0 01.75-.75h1.768a.75.75 0 01.75.75v.753a.75.75 0 01-.75.75zm.018 6.251a.75.75 0 100-1.5.75.75 0 000 1.5z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-sm font-medium text-gray-700">Pembayaran Aman</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="w-6 h-6 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.5 1.5H5.757a1 1 0 00-.757.364l-4.172 4.172A1 1 0 00.5 5.757v8.486a2 2 0 002 2h12a2 2 0 002-2V3.5a2 2 0 00-2-2zm.5 13h-8a.5.5 0 110-1h8a.5.5 0 110 1zm0-3h-8a.5.5 0 110-1h8a.5.5 0 110 1z"></path>
                                </svg>
                                <span class="text-sm font-medium text-gray-700">Pengiriman Cepat</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="w-6 h-6 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.5 17a4.5 4.5 0 01-1.44-8.765 4.5 4.5 0 018.302-3.046 3.5 3.5 0 014.504 4.272A4 4 0 1015.5 17H5.5zm3.75-2.75a.75.75 0 001.5 0V9.66l1.95 2.53a.75.75 0 101.2-.9l-3.25-4.33a.75.75 0 00-1.2 0l-3.25 4.33a.75.75 0 101.2.9l1.95-2.53v4.59z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-sm font-medium text-gray-700">Gratis Ongkos Kirim</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Hero Image -->
                <div class="relative hidden lg:block" data-aos="fade-left" data-aos-duration="800">
                    <div class="relative w-full h-96 rounded-2xl overflow-hidden shadow-2xl">
                        <div class="absolute inset-0 bg-gradient-to-br from-orange-400 via-orange-500 to-orange-600 flex items-center justify-center">
                            <div class="text-center">
                                <div class="text-9xl mb-4">🌶️</div>
                                <p class="text-white text-2xl font-poppins font-bold">Cireng Rujak</p>
                                <p class="text-orange-100 text-sm mt-2">Rasa Autentik Indonesia</p>
                            </div>
                        </div>
                    </div>
                    <!-- Floating Card -->
                    <div class="absolute -bottom-6 -right-6 bg-white rounded-xl shadow-xl p-4 max-w-xs" data-aos="zoom-in" data-aos-delay="200">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-12 h-12 rounded-full bg-orange-100 flex items-center justify-center text-xl">⭐</div>
                            <div>
                                <p class="font-bold text-gray-900">4.9/5</p>
                                <p class="text-xs text-gray-500">1,200+ Reviews</p>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600">"Paling enak se-Indonesia! Pasti pesan lagi" - Budi K.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="font-poppins font-bold text-4xl text-gray-900 mb-4">Tentang Kami</h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    Kami adalah UMKM yang berdedikasi menghadirkan cireng rujak berkualitas premium dengan cita rasa autentik Indonesia.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- About Image -->
                <div class="rounded-2xl overflow-hidden shadow-xl" data-aos="fade-right">
                    <div class="bg-gradient-to-br from-orange-100 to-orange-50 h-96 flex items-center justify-center">
                        <div class="text-center">
                            <div class="text-8xl mb-4">👨‍🍳</div>
                            <p class="text-gray-700 font-semibold">Resep Turun Temurun</p>
                        </div>
                    </div>
                </div>

                <!-- About Content -->
                <div data-aos="fade-left">
                    <h3 class="font-poppins font-bold text-3xl text-gray-900 mb-6">
                        Kualitas & Kesegaran Terjamin
                    </h3>

                    <div class="space-y-4 mb-8">
                        <div class="flex gap-4">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 rounded-full bg-orange-100 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h4 class="font-poppins font-bold text-gray-900">Bahan Pilihan Premium</h4>
                                <p class="text-gray-600 text-sm">Menggunakan bahan berkualitas tinggi tanpa pengawet berbahaya</p>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 rounded-full bg-orange-100 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h4 class="font-poppins font-bold text-gray-900">Higienis & Aman</h4>
                                <p class="text-gray-600 text-sm">Diproduksi di dapur yang bersih dan berstandar BPOM</p>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 rounded-full bg-orange-100 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h4 class="font-poppins font-bold text-gray-900">Rasa Autentik Terjaga</h4>
                                <p class="text-gray-600 text-sm">Resep turun temurun yang telah teruji cita rasanya</p>
                            </div>
                        </div>
                    </div>

                    <x-button variant="primary" size="lg" href="#how-to-order">
                        Mulai Pesan Sekarang
                    </x-button>
                </div>
            </div>
        </div>
    </section>

    <!-- Menu Section -->
    <section id="menu" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="font-poppins font-bold text-4xl text-gray-900 mb-4">Menu Produk Kami</h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    Pilihan cireng rujak dengan berbagai varian rasa yang lezat dan menggugah selera
                </p>
            </div>

            <!-- Product Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($featuredProducts as $product)
                    <x-product-card
                        image="{{ $product->image_url }}"
                        name="{{ $product->name }}"
                        description="{{ Str::limit($product->description, 80) }}"
                        price="{{ $product->price }}"
                        original_price="{{ $product->original_price ?? null }}"
                        rating="{{ $product->rating ?? 5 }}"
                        reviews="{{ $product->reviews_count ?? 0 }}"
                    />
                @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-gray-600">Produk tidak tersedia. Silakan hubungi kami.</p>
                    </div>
                @endforelse
            </div>

            <!-- CTA Section -->
            <div class="mt-16 text-center">
                    <x-button variant="primary" size="lg" href="{{ route('menu') }}" class="w-full sm:w-auto">
                    Lihat Semua Menu
                </x-button>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="how-to-order" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="font-poppins font-bold text-4xl text-gray-900 mb-4">Cara Pesan</h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    Proses pemesanan yang mudah dan simpel hanya dalam beberapa langkah
                </p>
            </div>

            <!-- Steps Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
                <x-step-card
                    number="1"
                    title="Pilih Produk"
                    description="Pilih jenis cireng rujak favorit Anda dari menu yang tersedia dengan berbagai varian rasa"
                    icon="🛒"
                />

                <x-step-card
                    number="2"
                    title="Tentukan Jadwal"
                    description="Tentukan tanggal pengiriman yang sesuai dengan keinginan Anda"
                    icon="📅"
                />

                <x-step-card
                    number="3"
                    title="Lakukan Pembayaran"
                    description="Lakukan pembayaran melalui transfer bank, e-wallet, atau metode pembayaran lainnya"
                    icon="💳"
                />

                <x-step-card
                    number="4"
                    title="Terima Pesanan"
                    description="Terima pesanan cireng rujak dalam kondisi segar dan siap untuk dinikmati"
                    icon="🎁"
                />
            </div>

            <!-- Timeline -->
            <div class="bg-gradient-to-r from-orange-50 to-orange-100 rounded-2xl p-8 md:p-12">
                <h3 class="font-poppins font-bold text-2xl text-gray-900 mb-8 text-center">Timeline Pre-Order</h3>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div class="text-center">
                        <div class="bg-white rounded-lg p-4 mb-4">
                            <p class="font-poppins font-bold text-lg text-orange-600">-7 hari</p>
                        </div>
                        <p class="text-sm text-gray-600">Pre-order bisa dilakukan maksimal 7 hari sebelum tanggal pengiriman</p>
                    </div>
                    <div class="text-center">
                        <div class="bg-white rounded-lg p-4 mb-4">
                            <p class="font-poppins font-bold text-lg text-orange-600">Status Diproses</p>
                        </div>
                        <p class="text-sm text-gray-600">Pesanan diproses dan dibuat fresh sesuai jadwal pengiriman</p>
                    </div>
                    <div class="text-center">
                        <div class="bg-white rounded-lg p-4 mb-4">
                            <p class="font-poppins font-bold text-lg text-orange-600">Ready To Ship</p>
                        </div>
                        <p class="text-sm text-gray-600">Produk siap dan dikemas dengan rapi dalam kemasan premium</p>
                    </div>
                    <div class="text-center">
                        <div class="bg-white rounded-lg p-4 mb-4">
                            <p class="font-poppins font-bold text-lg text-orange-600">Delivered ✓</p>
                        </div>
                        <p class="text-sm text-gray-600">Produk sampai di tangan Anda dalam kondisi sempurna dan segar</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonial" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="font-poppins font-bold text-4xl text-gray-900 mb-4">Kata Pelanggan Kami</h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    Ribuan pelanggan puas telah merasakan kelezatan cireng rujak kami
                </p>
            </div>

            <!-- Testimonials Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($testimonials as $testimonial)
                    <x-testimonial-card
                        name="{{ $testimonial->customer_name }}"
                        role="{{ $testimonial->customer_role ?? 'Pelanggan' }}"
                        avatar="{{ $testimonial->avatar_url ?? 'https://via.placeholder.com/48x48?text=' . substr($testimonial->customer_name, 0, 1) }}"
                        content="{{ $testimonial->content }}"
                        rating="{{ $testimonial->rating ?? 5 }}"
                    />
                @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-gray-600">Belum ada testimonial. Jadilah yang pertama!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-r from-orange-500 to-orange-600 text-white relative overflow-hidden">
        <!-- Decorative Background -->
        <div class="absolute top-0 left-0 w-96 h-96 bg-white opacity-5 rounded-full -translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-white opacity-5 rounded-full translate-x-1/2 translate-y-1/2"></div>

        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <h2 class="font-poppins font-bold text-4xl mb-6" data-aos="fade-up">
                Siap Menikmati Kelezatan?
            </h2>
            <p class="text-xl mb-8 text-orange-50 max-w-2xl mx-auto" data-aos="fade-up" data-aos-delay="100">
                Pre-order sekarang dan dapatkan cireng rujak premium dengan rasa yang tak terlupakan langsung ke rumah Anda!
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center" data-aos="fade-up" data-aos-delay="200">
                <x-button variant="white" size="lg" href="#menu" class="w-full sm:w-auto">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    Lihat Menu Lengkap
                </x-button>
<x-button variant="primary" size="lg" href="https://wa.me/6285183062643" target="_blank" class="w-full sm:w-auto">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.67-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.076 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421-7.403h-.004a9.87 9.87 0 00-4.946 1.217l-.335.182-.348-.052c-1.136-.08-2.216-.256-3.214-.5L2.702 4.127l.323 1.039c.393 1.259.926 2.417 1.601 3.541L3.4 9.25c-.213.529-.424 1.06-.624 1.585-1.454-1.13-2.323-2.79-2.323-4.587A9.972 9.972 0 0112.051 2.05c5.527 0 10.04 4.513 10.04 10.04 0 5.527-4.513 10.04-10.04 10.04-1.98 0-3.835-.584-5.396-1.59l-.337-.214-.36.043c-1.136.091-2.216.256-3.214.5l1.102-1.81c.471-.772.906-1.579 1.297-2.416 1.02 1.13 2.427 1.835 3.993 1.835 3.032 0 5.5-2.468 5.5-5.5s-2.468-5.5-5.5-5.5z"/>
                    </svg>
                    Chat WhatsApp
                </x-button>
            </div>

            <!-- Extra Info -->
            <div class="mt-12 pt-8 border-t border-orange-400">
                <p class="text-sm text-orange-100">
                    💬 Pertanyaan? Hubungi kami kapan saja melalui WhatsApp atau Instagram
                </p>
            </div>
        </div>
    </section>

    <!-- FAQ Section (Optional) -->
    <section id="faq" class="py-20 bg-white">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="font-poppins font-bold text-4xl text-gray-900 mb-4">Pertanyaan Umum</h2>
                <p class="text-lg text-gray-600">
                    Temukan jawaban atas pertanyaan yang sering diajukan
                </p>
            </div>

            <div class="space-y-4">
                <details class="group border border-gray-200 rounded-lg p-6 hover:border-orange-400 transition-colors cursor-pointer" data-aos="fade-up">
                    <summary class="flex items-center justify-between font-poppins font-bold text-gray-900 text-lg cursor-pointer">
                        Apa itu cireng rujak?
                        <svg class="w-5 h-5 text-gray-600 group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                        </svg>
                    </summary>
                    <p class="text-gray-600 mt-4">
                        Cireng rujak adalah makanan tradisional Indonesia yang terbuat dari tepung aci (tapioka) yang digoreng dan disajikan dengan bumbu rujak yang gurih dan pedas. Kami menyajikannya dengan bahan-bahan pilihan premium.
                    </p>
                </details>

                <details class="group border border-gray-200 rounded-lg p-6 hover:border-orange-400 transition-colors cursor-pointer" data-aos="fade-up" data-aos-delay="50">
                    <summary class="flex items-center justify-between font-poppins font-bold text-gray-900 text-lg cursor-pointer">
                        Berapa lama waktu pengiriman?
                        <svg class="w-5 h-5 text-gray-600 group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                        </svg>
                    </summary>
                    <p class="text-gray-600 mt-4">
                        Pengiriman dilakukan sesuai tanggal jadwal yang Anda pilih saat pre-order. Kami mengirimkan produk saat tanggal tersebut agar Anda mendapatkan cireng rujak dalam kondisi paling segar.
                    </p>
                </details>

                <details class="group border border-gray-200 rounded-lg p-6 hover:border-orange-400 transition-colors cursor-pointer" data-aos="fade-up" data-aos-delay="100">
                    <summary class="flex items-center justify-between font-poppins font-bold text-gray-900 text-lg cursor-pointer">
                        Apakah produk aman untuk keluarga?
                        <svg class="w-5 h-5 text-gray-600 group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                        </svg>
                    </summary>
                    <p class="text-gray-600 mt-4">
                        Ya! Semua produk kami dibuat dengan standar higienitas tinggi tanpa pengawet berbahaya. Kami menggunakan bahan-bahan pilihan premium yang aman untuk semua anggota keluarga.
                    </p>
                </details>

                <details class="group border border-gray-200 rounded-lg p-6 hover:border-orange-400 transition-colors cursor-pointer" data-aos="fade-up" data-aos-delay="150">
                    <summary class="flex items-center justify-between font-poppins font-bold text-gray-900 text-lg cursor-pointer">
                        Apakah ada diskon untuk pembelian dalam jumlah besar?
                        <svg class="w-5 h-5 text-gray-600 group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                        </svg>
                    </summary>
                    <p class="text-gray-600 mt-4">
                        Ya! Untuk pembelian dalam jumlah besar atau paket katering, kami menawarkan harga spesial. Silakan hubungi kami melalui WhatsApp untuk mengatur detail pesanan kustom Anda.
                    </p>
                </details>
            </div>
        </div>
    </section>
</x-layouts.app>
