@php
    /**
     * Step Card Component
     *
     * Props:
     * - number: Step number
     * - icon: SVG icon or icon class
     * - title: Step title
     * - description: Step description
     */
    $number = $number ?? '';
    $icon = $icon ?? null;
    $title = $title ?? '';
    $description = $description ?? '';
@endphp

<div class="step-card text-center" data-aos="fade-up" data-aos-duration="600">
    <!-- Step Number Circle -->
    <div class="flex justify-center mb-4">
        <div class="w-16 h-16 rounded-full bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center text-white font-poppins font-bold text-2xl shadow-lg">
            {{ $number }}
        </div>
    </div>

    <!-- Icon -->
    @if($icon)
        <div class="mb-4 text-4xl">
            {!! $icon !!}
        </div>
    @endif

    <!-- Title -->
    <h3 class="font-poppins font-bold text-lg text-gray-900 mb-2">{{ $title }}</h3>

    <!-- Description -->
    <p class="text-gray-600 text-sm leading-relaxed">{{ $description }}</p>
</div>
