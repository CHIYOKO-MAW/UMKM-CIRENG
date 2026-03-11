@php
    /**
     * Product Card Component
     *
     * Props:
     * - image: Product image URL
     * - name: Product name
     * - description: Product description
     * - price: Product price
     * - rating: Product rating (1-5)
     * - reviews: Number of reviews
     */
    $image = $image ?? '';
    $name = $name ?? '';
    $description = $description ?? '';
    $price = $price ?? '';
    $rating = $rating ?? null;
    $reviews = $reviews ?? null;
    $original_price = $original_price ?? null;
@endphp

<div class="product-card bg-white rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1"
     data-aos="fade-up" data-aos-duration="600">
    <!-- Product Image -->
    <div class="relative w-full h-48 bg-gray-200 overflow-hidden">
        <img src="{{ $image }}" alt="{{ $name }}" class="w-full h-full object-cover hover:scale-110 transition-transform duration-300">
        <div class="absolute top-3 right-3 bg-orange-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
            Pre-Order
        </div>
    </div>

    <!-- Product Info -->
    <div class="p-4">
        <!-- Name and Rating -->
        <div class="flex justify-between items-start mb-2">
            <h3 class="font-poppins font-bold text-lg text-gray-900 flex-1">{{ $name }}</h3>
            @if($rating)
                <div class="flex items-center gap-1">
                    <div class="flex text-yellow-400">
                        @for($i = 0; $i < 5; $i++)
                            @if($i < floor($rating))
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                            @else
                                <svg class="w-4 h-4 fill-gray-300" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                            @endif
                        @endfor
                    </div>
                    @if($reviews)
                        <span class="text-xs text-gray-500">({{ $reviews }})</span>
                    @endif
                </div>
            @endif
        </div>

        <!-- Description -->
        <p class="text-sm text-gray-600 mb-4 line-clamp-2">{{ $description }}</p>

        <!-- Price and Button -->
        <div class="flex items-center justify-between">
            <div class="flex flex-col">
                @if($original_price)
                    <span class="text-xs text-gray-400 line-through">Rp{{ number_format($original_price, 0, ',', '.') }}</span>
                @endif
                <span class="text-lg font-bold text-orange-500">Rp{{ number_format($price, 0, ',', '.') }}</span>
            </div>
            @auth
                <a href="{{ route('order.create') }}" class="btn btn-primary px-4 py-2 text-sm inline-flex items-center gap-2 hover:bg-orange-600 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Pesan
                </a>
            @else
                <a href="{{ route('register') }}" class="btn btn-primary px-4 py-2 text-sm inline-flex items-center gap-2 hover:bg-orange-600 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Pesan
                </a>
            @endauth
        </div>
    </div>
</div>
