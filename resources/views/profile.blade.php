<x-layouts.app>
    <!-- Profile Section -->
    <section class="min-h-screen pt-32 pb-20 bg-gray-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-12 flex justify-between items-center">
                <div>
                    <h1 class="font-poppins font-bold text-4xl text-gray-900 mb-2">Profil Saya</h1>
                    <p class="text-lg text-gray-600">Kelola informasi profil dan keamanan akun Anda</p>
                </div>
                <a href="/dashboard" class="text-gray-600 hover:text-gray-900 transition-colors inline-flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali
                </a>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-6 p-4 rounded-lg bg-green-50 border border-green-200">
                    <p class="text-green-600 font-medium">{{ session('success') }}</p>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-md p-8">
                        <!-- Profile Avatar -->
                        <div class="text-center mb-8">
                            <div class="w-24 h-24 rounded-full bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center text-white text-4xl mx-auto shadow-lg">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <h2 class="font-poppins font-bold text-2xl text-gray-900 mt-4">{{ Auth::user()->name }}</h2>
                            <p class="text-gray-600 text-sm">{{ Auth::user()->email }}</p>
                        </div>

                        <!-- Quick Links -->
                        <div class="space-y-2 border-t border-gray-200 pt-6">
                            <a href="#profile-info" class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-orange-50 hover:text-orange-600 transition-colors font-medium">
                                Informasi Profil
                            </a>
                            <a href="#change-password" class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-orange-50 hover:text-orange-600 transition-colors font-medium">
                                Ganti Password
                            </a>
                        </div>

                        <!-- Member Info -->
                        <div class="mt-8 p-4 rounded-lg bg-orange-50 border border-orange-200">
                            <p class="text-xs text-orange-600 font-medium mb-3">👤 Status Member</p>
                            <p class="text-sm font-bold text-orange-900">Regular Member</p>
                            <p class="text-xs text-orange-700 mt-2">Bergabung sejak {{ Auth::user()->created_at->format('d M Y') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Profile Information Section -->
                    <div class="bg-white rounded-xl shadow-md p-8" id="profile-info">
                        <h2 class="font-poppins font-bold text-2xl text-gray-900 mb-8">Informasi Profil</h2>

                        @if($errors->any())
                            <div class="mb-6 p-4 rounded-lg bg-red-50 border border-red-200">
                                @foreach($errors->all() as $error)
                                    <p class="text-red-600 text-sm">{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif

                        <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
                            @csrf
                            @method('PUT')

                            <!-- Name Field -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    value="{{ old('name', Auth::user()->name) }}"
                                    required
                                    class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none transition-all duration-300"
                                >
                                @error('name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email Field -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    value="{{ old('email', Auth::user()->email) }}"
                                    required
                                    class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none transition-all duration-300"
                                >
                                @error('email')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Phone Field -->
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                                <input
                                    type="tel"
                                    id="phone"
                                    name="phone"
                                    value="{{ old('phone', Auth::user()->phone) }}"
                                    required
                                    class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none transition-all duration-300"
                                >
                                @error('phone')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Address Field -->
                            <div>
                                <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Alamat (Opsional)</label>
                                <textarea
                                    id="address"
                                    name="address"
                                    rows="3"
                                    class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none transition-all duration-300"
                                >{{ old('address', Auth::user()->address) }}</textarea>
                                @error('address')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <div class="flex gap-4">
                                <button
                                    type="submit"
                                    class="btn btn-primary px-8 py-3 rounded-lg font-medium transition-all duration-300"
                                >
                                    Simpan Perubahan
                                </button>
                                <a href="/dashboard" class="btn btn-outline px-8 py-3 rounded-lg font-medium transition-all duration-300">
                                    Batal
                                </a>
                            </div>
                        </form>
                    </div>

                    <!-- Change Password Section -->
                    <div class="bg-white rounded-xl shadow-md p-8" id="change-password">
                        <h2 class="font-poppins font-bold text-2xl text-gray-900 mb-8">Ganti Password</h2>

                        @if($errors->has('current_password') || $errors->has('password') || $errors->has('password_confirmation'))
                            <div class="mb-6 p-4 rounded-lg bg-red-50 border border-red-200">
                                @foreach($errors->all() as $error)
                                    <p class="text-red-600 text-sm">{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif

                        <form method="POST" action="{{ route('profile.password') }}" class="space-y-6">
                            @csrf
                            @method('PUT')

                            <!-- Current Password Field -->
                            <div>
                                <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">Password Saat Ini</label>
                                <input
                                    type="password"
                                    id="current_password"
                                    name="current_password"
                                    required
                                    class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none transition-all duration-300"
                                >
                                @error('current_password')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- New Password Field -->
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password Baru</label>
                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    required
                                    class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none transition-all duration-300"
                                >
                                <p class="text-xs text-gray-500 mt-1">Minimal 8 karakter</p>
                                @error('password')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Confirm Password Field -->
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password Baru</label>
                                <input
                                    type="password"
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    required
                                    class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none transition-all duration-300"
                                >
                                @error('password_confirmation')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Info Box -->
                            <div class="p-4 rounded-lg bg-blue-50 border border-blue-200">
                                <p class="text-xs text-blue-700 font-medium">💡 Tips Keamanan</p>
                                <ul class="text-xs text-blue-600 mt-2 space-y-1">
                                    <li>• Gunakan password yang kuat (kombinasi huruf, angka, dan simbol)</li>
                                    <li>• Tidak boleh sama dengan password sebelumnya</li>
                                    <li>• Jangan bagikan password kepada siapapun</li>
                                </ul>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex gap-4">
                                <button
                                    type="submit"
                                    class="btn btn-primary px-8 py-3 rounded-lg font-medium transition-all duration-300"
                                >
                                    Ubah Password
                                </button>
                                <a href="/dashboard" class="btn btn-outline px-8 py-3 rounded-lg font-medium transition-all duration-300">
                                    Batal
                                </a>
                            </div>
                        </form>
                    </div>

                    <!-- Danger Zone Section -->
                    <div class="bg-red-50 border-2 border-red-200 rounded-xl p-8">
                        <h2 class="font-poppins font-bold text-2xl text-red-900 mb-4">⚠️ Zona Berbahaya</h2>
                        <p class="text-red-700 mb-6">Tindakan di bawah tidak dapat dibatalkan. Harap hati-hati.</p>

                        <form method="POST" action="{{ route('logout') }}" onsubmit="return confirm('Anda yakin ingin logout?')">
                            @csrf
                            <button
                                type="submit"
                                class="btn bg-red-600 text-white hover:bg-red-700 px-8 py-3 rounded-lg font-medium transition-all duration-300"
                            >
                                Logout dari Semua Perangkat
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
