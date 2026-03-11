@php
    /**
     * Testimonial Card Component
     *
     * Props:
     * - name: Customer name
     * - role: Customer role/occupation
     * - avatar: Avatar image URL
     * - content: Testimonial content/message
     * - rating: Star rating (1-5)
     */
    $name = $name ?? '';
    $role = $role ?? '';
    $avatar = $avatar ?? '';
    $content = $content ?? '';
    $rating = $rating ?? null;
@endphp

<div class="testimonial-card bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition-all duration-300"
     data-aos="fade-up" data-aos-duration="600">
    <!-- Quote Icon -->
    <div class="text-orange-400 text-3xl mb-3">"</div>

    <!-- Rating -->
    @if($rating)
        <div class="flex gap-1 mb-3">
            @for($i = 0; $i < 5; $i++)
                @if($i < floor($rating))
                    <svg class="w-4 h-4 fill-yellow-400" viewBox="0 0 20 20">
                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                    </svg>
                @else
                    <svg class="w-4 h-4 fill-gray-300" viewBox="0 0 20 20">
                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                    </svg>
                @endif
            @endfor
        </div>
    @endif

    <!-- Content -->
    <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ $content }}</p>

    <!-- Author -->
    <div class="flex items-center gap-3">
        <div class="w-12 h-12 rounded-full overflow-hidden bg-gray-200 flex-shrink-0">
            <img src="{{ $avatar }}" alt="{{ $name }}" class="w-full h-full object-cover">
        </div>
        <div>
            <h4 class="font-poppins font-bold text-sm text-gray-900">{{ $name }}</h4>
            <p class="text-xs text-gray-500">{{ $role }}</p>
        </div>
    </div>
</div>
