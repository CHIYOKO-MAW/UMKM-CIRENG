<x-layouts.app>
    <!-- Admin Edit Product Section -->
    <section class="min-h-screen pt-32 pb-20 bg-gray-50">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-10">
                <h1 class="font-poppins font-bold text-4xl text-gray-900 mb-2">Edit Produk</h1>
                <p class="text-lg text-gray-600">Perbarui informasi produk cireng rujak</p>
            </div>

            <!-- Error Messages -->
            @if($errors->any())
                <div class="mb-6 p-4 rounded-lg bg-red-50 border border-red-200">
                    <ul class="list-disc list-inside text-sm text-red-600">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Edit Form -->
            <div class="bg-white rounded-xl shadow-md p-8">
                <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Current Image Preview -->
                    @if($product->image)
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Saat Ini</label>
                        <div class="relative inline-block">
                            <img
                                src="{{ asset('storage/' . $product->image) }}"
                                alt="{{ $product->name }}"
                                class="w-32 h-32 object-cover rounded-lg border border-gray-200"
                            >
                        </div>
                    </div>
                    @endif

                    <!-- Product Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Produk <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name', $product->name) }}"
                            required
                            class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none transition-all duration-300"
                            placeholder="Contoh: Cireng Isi Ayam"
                        >
                    </div>

                    <!-- Short Description -->
                    <div>
                        <label for="short_description" class="block text-sm font-medium text-gray-700 mb-2">
                            Deskripsi Pendek
                        </label>
                        <input
                            type="text"
                            id="short_description"
                            name="short_description"
                            value="{{ old('short_description', $product->short_description) }}"
                            class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none transition-all duration-300"
                            placeholder="Deskripsi singkat untuk tampilan kartu produk"
                        >
                    </div>

                    <!-- Full Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            Deskripsi Lengkap
                        </label>
                        <textarea
                            id="description"
                            name="description"
                            rows="4"
                            class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none transition-all duration-300"
                            placeholder="Deskripsi lengkap produk..."
                        >{{ old('description', $product->description) }}</textarea>
                    </div>

                    <!-- Price and Category Row -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Price -->
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                                Harga <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500">Rp</span>
                                <input
                                    type="number"
                                    id="price"
                                    name="price"
                                    value="{{ old('price', $product->price) }}"
                                    required
                                    min="0"
                                    class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none transition-all duration-300"
                                    placeholder="5000"
                                >
                            </div>
                        </div>

                        <!-- Category -->
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                                Kategori <span class="text-red-500">*</span>
                            </label>
                            <select
                                id="category"
                                name="category"
                                required
                                class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none transition-all duration-300"
                            >
                                <option value="">-- Pilih Kategori --</option>
                                <option value="cireng" {{ old('category', $product->category) == 'cireng' ? 'selected' : '' }}>Cireng</option>
                                <option value="basreng" {{ old('category', $product->category) == 'basreng' ? 'selected' : '' }}>Basreng</option>
                                <option value="rujak" {{ old('category', $product->category) == 'rujak' ? 'selected' : '' }}>Rujak</option>
                                <option value="minuman" {{ old('category', $product->category) == 'minuman' ? 'selected' : '' }}>Minuman</option>
                                <option value="paket" {{ old('category', $product->category) == 'paket' ? 'selected' : '' }}>Paket</option>
                                <option value="lainnya" {{ old('category', $product->category) == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                        </div>
                    </div>

                    <!-- Min Order and Unit Row -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Min Order -->
                        <div>
                            <label for="min_order" class="block text-sm font-medium text-gray-700 mb-2">
                                Minimum Pesanan <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="number"
                                id="min_order"
                                name="min_order"
                                value="{{ old('min_order', $product->min_order) }}"
                                required
                                min="1"
                                class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none transition-all duration-300"
                            >
                        </div>

                        <!-- Unit -->
                        <div>
                            <label for="unit" class="block text-sm font-medium text-gray-700 mb-2">
                                Satuan <span class="text-red-500">*</span>
                            </label>
                            <select
                                id="unit"
                                name="unit"
                                required
                                class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none transition-all duration-300"
                            >
                                <option value="pcs" {{ old('unit', $product->unit) == 'pcs' ? 'selected' : '' }}>Pcs (Piece)</option>
                                <option value="porsi" {{ old('unit', $product->unit) == 'porsi' ? 'selected' : '' }}>Porsi</option>
                                <option value="pack" {{ old('unit', $product->unit) == 'pack' ? 'selected' : '' }}>Pack</option>
                                <option value="box" {{ old('unit', $product->unit) == 'box' ? 'selected' : '' }}>Box</option>
                            </select>
                        </div>
                    </div>

                    <!-- Image Upload -->
                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                            Ganti Gambar Produk
                        </label>
                        <div class="relative">
                            <input
                                type="file"
                                id="image"
                                name="image"
                                accept="image/jpeg,image/png,image/webp"
                                class="hidden"
                            >
                            <label for="image" class="block cursor-pointer">
                                <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-orange-500 hover:bg-orange-50 transition-all duration-300" id="upload-area">
                                    <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <p class="font-medium text-gray-900">Klik untuk upload gambar baru</p>
                                    <p class="text-sm text-gray-500 mt-1">JPG, PNG, atau WebP (Max 2MB)</p>
                                    <p class="text-xs text-gray-400 mt-2">Kosongkan jika tidak ingin mengganti gambar</p>
                                </div>
                            </label>
                            <div id="file-info" class="mt-4 hidden">
                                <div class="flex items-center gap-3 p-3 bg-green-50 rounded-lg border border-green-200">
                                    <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="text-sm text-green-700" id="file-name"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Status Checkboxes -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="flex items-center">
                            <input
                                type="checkbox"
                                id="is_active"
                                name="is_active"
                                value="1"
                                {{ old('is_active', $product->is_active) ? 'checked' : '' }}
                                class="w-5 h-5 rounded border-gray-300 text-orange-500 focus:ring-orange-500"
                            >
                            <label for="is_active" class="ml-3 text-sm font-medium text-gray-700">
                                Produk Aktif
                            </label>
                        </div>

                        <div class="flex items-center">
                            <input
                                type="checkbox"
                                id="is_featured"
                                name="is_featured"
                                value="1"
                                {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}
                                class="w-5 h-5 rounded border-gray-300 text-orange-500 focus:ring-orange-500"
                            >
                            <label for="is_featured" class="ml-3 text-sm font-medium text-gray-700">
                                Produk Unggulan
                            </label>
                        </div>
                    </div>

                    <!-- Sort Order -->
                    <div>
                        <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-2">
                            Urutan Tampilan
                        </label>
                        <input
                            type="number"
                            id="sort_order"
                            name="sort_order"
                            value="{{ old('sort_order', $product->sort_order) }}"
                            min="0"
                            class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none transition-all duration-300"
                            placeholder="0"
                        >
                        <p class="text-xs text-gray-500 mt-1">Angka lebih kecil akan ditampilkan lebih dulu</p>
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-4 pt-6">
                        <button
                            type="submit"
                            class="flex-1 btn-primary py-3 px-6 rounded-lg font-medium text-center transition-all duration-300"
                        >
                            Perbarui Produk
                        </button>
                        <x-button variant="outline" href="{{ route('admin.products.index') }}" class="flex-1 text-center">
                            Batal
                        </x-button>
                    </div>
                </form>

                <!-- Delete Button -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini? Tindakan ini tidak dapat dibatalkan.')">
                        @csrf
                        @method('DELETE')
                        <button
                            type="submit"
                            class="w-full py-3 px-6 bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 rounded-lg font-medium text-center transition-all duration-300"
                        >
                            🗑️ Hapus Produk
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
    <script>
        // File Upload Preview
        const fileInput = document.getElementById('image');
        const uploadArea = document.getElementById('upload-area');
        const fileInfo = document.getElementById('file-info');
        const fileName = document.getElementById('file-name');

        if (fileInput) {
            fileInput.addEventListener('change', function(e) {
                if (this.files.length > 0) {
                    const file = this.files[0];
                    fileName.textContent = file.name + ' (' + (file.size / 1024).toFixed(1) + ' KB)';
                    fileInfo.classList.remove('hidden');
                    uploadArea.classList.add('border-green-400', 'bg-green-50');
                    uploadArea.classList.remove('border-gray-300');
                }
            });

            // Drag and drop
            uploadArea.addEventListener('dragover', (e) => {
                e.preventDefault();
                uploadArea.classList.add('border-orange-500', 'bg-orange-50');
            });

            uploadArea.addEventListener('dragleave', () => {
                uploadArea.classList.remove('border-orange-500', 'bg-orange-50');
            });

            uploadArea.addEventListener('drop', (e) => {
                e.preventDefault();
                uploadArea.classList.remove('border-orange-500', 'bg-orange-50');
                fileInput.files = e.dataTransfer.files;
                const event = new Event('change', { bubbles: true });
                fileInput.dispatchEvent(event);
            });
        }
    </script>
    @endpush
</x-layouts.app>

