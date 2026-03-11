<x-layouts.app>
    <!-- Admin Products Section -->
    <section class="min-h-screen pt-32 pb-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-12 flex justify-between items-center">
                <div>
                    <h1 class="font-poppins font-bold text-4xl text-gray-900 mb-2">Kelola Produk</h1>
                    <p class="text-lg text-gray-600">Tambah, edit, atau hapus produk cireng rujak</p>
                </div>
                <div class="flex gap-4">
                    <x-button variant="primary" href="{{ route('admin.products.create') }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Tambah Produk
                    </x-button>
                    <x-button variant="outline" href="{{ route('admin.dashboard') }}">
                        Kembali
                    </x-button>
                </div>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-6 p-4 rounded-lg bg-green-50 border border-green-200">
                    <p class="text-green-600 font-medium">{{ session('success') }}</p>
                </div>
            @endif

            <!-- Products Table -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                @if($products->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-gray-200 bg-gray-50">
                                    <th class="text-left py-4 px-6 font-bold text-gray-700">Nama Produk</th>
                                    <th class="text-left py-4 px-6 font-bold text-gray-700">Kategori</th>
                                    <th class="text-left py-4 px-6 font-bold text-gray-700">Harga</th>
                                    <th class="text-left py-4 px-6 font-bold text-gray-700">Status</th>
                                    <th class="text-left py-4 px-6 font-bold text-gray-700">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                    <tr class="border-b border-gray-200 hover:bg-gray-50 transition-colors">
                                        <td class="py-4 px-6">
                                            <div class="flex items-center gap-3">
                                                <div class="w-12 h-12 rounded-lg bg-gray-200 flex items-center justify-center text-xl">
                                                    🌶️
                                                </div>
                                                <div>
                                                    <p class="font-medium text-gray-900">{{ $product->name }}</p>
                                                    <p class="text-xs text-gray-500">{{ Str::limit($product->short_description ?? $product->description, 50) }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-4 px-6 text-gray-700">{{ ucfirst($product->category) }}</td>
                                        <td class="py-4 px-6 font-medium text-orange-600">Rp{{ number_format($product->price, 0, ',', '.') }}</td>
                                        <td class="py-4 px-6">
                                            <div class="flex gap-2">
                                                @if($product->is_active)
                                                    <span class="inline-block bg-green-100 text-green-800 px-2 py-1 rounded text-xs font-semibold">✓ Aktif</span>
                                                @else
                                                    <span class="inline-block bg-gray-100 text-gray-800 px-2 py-1 rounded text-xs font-semibold">✗ Nonaktif</span>
                                                @endif
                                                @if($product->is_featured)
                                                    <span class="inline-block bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs font-semibold">⭐ Featured</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="py-4 px-6">
                                            <div class="flex gap-3">
                                                <a href="{{ route('admin.products.edit', $product) }}" class="text-blue-600 hover:text-blue-700 font-medium text-sm">
                                                    Edit
                                                </a>
                                                <form method="POST" action="{{ route('admin.products.destroy', $product) }}" class="inline" onsubmit="return confirm('Hapus produk ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-700 font-medium text-sm">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="p-6 border-t border-gray-200">
                        {{ $products->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <p class="text-gray-600 text-lg">Belum ada produk</p>
                        <p class="text-gray-500 text-sm mt-2">Tambahkan produk pertama Anda sekarang</p>
                        <x-button variant="primary" href="{{ route('admin.products.create') }}" class="mt-6">
                            Tambah Produk
                        </x-button>
                    </div>
                @endif
            </div>
        </div>
    </section>
</x-layouts.app>
