@php
    $isAdminArea = request()->routeIs('admin.*');
    $isAdminUser = auth()->check() && auth()->user()->isAdmin();
    $sectionHref = function (string $sectionId): string {
        return request()->routeIs('home')
            ? "#{$sectionId}"
            : route('home') . "#{$sectionId}";
    };
@endphp

<nav class="navbar fixed top-0 left-0 right-0 z-50 bg-white/50" x-data="{ mobileMenuOpen: false }" @scroll.window="$el.classList.toggle('scrolled', window.scrollY > 50)">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center text-white font-bold text-xl">
                    🌶️
                </div>
                <div>
                    <h1 class="text-lg font-bold font-poppins text-gray-900">Cireng Rujak</h1>
                    <p class="text-xs text-gray-600">UMKM Kota Serang</p>
                </div>
            </a>

            <div class="hidden md:flex items-center gap-8">
                @if($isAdminArea && $isAdminUser)
                    <a href="{{ route('admin.dashboard') }}" class="font-medium text-gray-700 hover:text-orange-500 transition-colors duration-300">Dashboard Admin</a>
                    <a href="{{ route('admin.orders.index') }}" class="font-medium text-gray-700 hover:text-orange-500 transition-colors duration-300">Pesanan</a>
                    <a href="{{ route('admin.orders.history') }}" class="font-medium text-gray-700 hover:text-orange-500 transition-colors duration-300">Riwayat</a>
                    <a href="{{ route('admin.products.index') }}" class="font-medium text-gray-700 hover:text-orange-500 transition-colors duration-300">Produk</a>
                @else
                    <a href="{{ $sectionHref('home') }}" class="font-medium text-gray-700 hover:text-orange-500 transition-colors duration-300">Beranda</a>
                    <a href="{{ $sectionHref('about') }}" class="font-medium text-gray-700 hover:text-orange-500 transition-colors duration-300">Tentang</a>
                    <a href="{{ $sectionHref('menu') }}" class="font-medium text-gray-700 hover:text-orange-500 transition-colors duration-300">Menu</a>
                    <a href="{{ $sectionHref('how-to-order') }}" class="font-medium text-gray-700 hover:text-orange-500 transition-colors duration-300">Cara Pesan</a>
                    <a href="{{ $sectionHref('testimonial') }}" class="font-medium text-gray-700 hover:text-orange-500 transition-colors duration-300">Testimoni</a>
                @endif
            </div>

            <div class="hidden md:flex items-center gap-3">
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="btn-primary text-sm">
                            Admin Dashboard
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" class="btn-primary text-sm">
                            Dashboard
                        </a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn-outline text-sm">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn-outline text-sm">Login</a>
                    <a href="{{ route('register') }}" class="btn-primary text-sm">
                        Pesan Sekarang
                    </a>
                @endauth
            </div>

            <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden p-2 rounded-lg hover:bg-orange-50 transition-colors">
                <svg class="w-6 h-6" :class="mobileMenuOpen ? 'hidden' : 'block'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
                <svg class="w-6 h-6" :class="mobileMenuOpen ? 'block' : 'hidden'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <div x-show="mobileMenuOpen" x-transition class="md:hidden pb-4 space-y-2">
            @if($isAdminArea && $isAdminUser)
                <a href="{{ route('admin.dashboard') }}" @click="mobileMenuOpen = false" class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-orange-50 transition-colors">Dashboard Admin</a>
                <a href="{{ route('admin.orders.index') }}" @click="mobileMenuOpen = false" class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-orange-50 transition-colors">Pesanan</a>
                <a href="{{ route('admin.orders.history') }}" @click="mobileMenuOpen = false" class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-orange-50 transition-colors">Riwayat</a>
                <a href="{{ route('admin.products.index') }}" @click="mobileMenuOpen = false" class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-orange-50 transition-colors">Produk</a>
            @else
                <a href="{{ $sectionHref('home') }}" @click="mobileMenuOpen = false" class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-orange-50 transition-colors">Beranda</a>
                <a href="{{ $sectionHref('about') }}" @click="mobileMenuOpen = false" class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-orange-50 transition-colors">Tentang</a>
                <a href="{{ $sectionHref('menu') }}" @click="mobileMenuOpen = false" class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-orange-50 transition-colors">Menu</a>
                <a href="{{ $sectionHref('how-to-order') }}" @click="mobileMenuOpen = false" class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-orange-50 transition-colors">Cara Pesan</a>
                <a href="{{ $sectionHref('testimonial') }}" @click="mobileMenuOpen = false" class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-orange-50 transition-colors">Testimoni</a>
            @endif

            <div class="pt-2 space-y-2 border-t border-gray-200">
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="block w-full btn-primary text-center text-sm">Admin Dashboard</a>
                    @else
                        <a href="{{ route('dashboard') }}" class="block w-full btn-primary text-center text-sm">Dashboard</a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="block w-full btn-outline text-center text-sm">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="block w-full btn-outline text-center text-sm">Login</a>
                    <a href="{{ route('register') }}" class="block w-full btn-primary text-center text-sm">Pesan Sekarang</a>
                @endauth
            </div>
        </div>
    </div>
</nav>

<div class="h-20"></div>
