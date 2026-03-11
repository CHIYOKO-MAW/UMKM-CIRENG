<x-layouts.app>
    <!-- Login Section -->
    <section class="min-h-screen flex items-center justify-center pt-32 pb-20 bg-gradient-to-br from-orange-50 via-white to-orange-50 relative overflow-hidden">
        <!-- Decorative Background Elements -->
        <div class="absolute top-10 left-10 w-72 h-72 bg-orange-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse"></div>
        <div class="absolute bottom-10 right-10 w-72 h-72 bg-orange-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse" style="animation-delay: 2s;"></div>

        <div class="max-w-md w-full px-4 relative z-10">
            <!-- Login Card -->
            <div class="bg-white rounded-2xl shadow-xl p-8" data-aos="zoom-in">
                <!-- Logo -->
                <div class="flex justify-center mb-8">
                    <div class="w-16 h-16 rounded-full bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center text-white font-bold text-2xl shadow-lg">
                        🌶️
                    </div>
                </div>

                <!-- Title -->
                <h1 class="font-poppins font-bold text-3xl text-gray-900 text-center mb-2">
                    Masuk
                </h1>
                <p class="text-center text-gray-600 mb-8">
                    Nikmati kemudahan pre-order cireng rujak kami
                </p>

                <!-- Error Messages -->
                @if($errors->any())
                    <div class="mb-6 p-4 rounded-lg bg-red-50 border border-red-200">
                        @foreach($errors->all() as $error)
                            <p class="text-red-600 text-sm">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <!-- Login Form -->
                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email Field -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autocomplete="email"
                            class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none transition-all duration-300"
                            placeholder="nama@example.com"
                        >
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            required
                            autocomplete="current-password"
                            class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none transition-all duration-300"
                            placeholder="Masukkan password Anda"
                        >
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <input
                            type="checkbox"
                            id="remember"
                            name="remember"
                            class="w-4 h-4 text-orange-600 rounded border-gray-300 focus:ring-orange-500 cursor-pointer"
                        >
                        <label for="remember" class="ml-2 text-sm text-gray-700 cursor-pointer">
                            Ingat saya
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button
                        type="submit"
                        class="w-full btn btn-primary py-3 rounded-lg font-medium transition-all duration-300"
                    >
                        Masuk
                    </button>
                </form>

                <!-- Divider -->
                <div class="my-8 flex items-center">
                    <div class="flex-1 border-t border-gray-200"></div>
                    <div class="px-3 text-sm text-gray-600">atau</div>
                    <div class="flex-1 border-t border-gray-200"></div>
                </div>

                <!-- Contact Support -->
                <div class="text-center">
                    <p class="text-sm text-gray-700 mb-4">
                        Butuh bantuan?
                    </p>
                    <a href="https://wa.me/6285183062643" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border-2 border-green-500 text-green-600 hover:bg-green-50 transition-colors duration-300 font-medium">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.67-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.076 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421-7.403h-.004a9.87 9.87 0 00-4.946 1.217l-.335.182-.348-.052c-1.136-.08-2.216-.256-3.214-.5L2.702 4.127l.323 1.039c.393 1.259.926 2.417 1.601 3.541L3.4 9.25c-.213.529-.424 1.06-.624 1.585-1.454-1.13-2.323-2.79-2.323-4.587A9.972 9.972 0 0112.051 2.05c5.527 0 10.04 4.513 10.04 10.04 0 5.527-4.513 10.04-10.04 10.04-1.98 0-3.835-.584-5.396-1.59l-.337-.214-.36.043c-1.136.091-2.216.256-3.214.5l1.102-1.81c.471-.772.906-1.579 1.297-2.416 1.02 1.13 2.427 1.835 3.993 1.835 3.032 0 5.5-2.468 5.5-5.5s-2.468-5.5-5.5-5.5z"/>
                        </svg>
                        Chat WhatsApp
                    </a>
                </div>

                <!-- Register Link -->
                <div class="mt-8 text-center">
                    <p class="text-gray-600">
                        Belum punya akun?
                        <a href="{{ route('register') }}" class="text-orange-600 font-semibold hover:text-orange-700 transition-colors">
                            Daftar Sekarang
                        </a>
                    </p>
                </div>
            </div>

            <!-- Back to Home -->
            <div class="text-center mt-6">
                <a href="/" class="text-gray-600 hover:text-gray-900 transition-colors inline-flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </section>
</x-layouts.app>

