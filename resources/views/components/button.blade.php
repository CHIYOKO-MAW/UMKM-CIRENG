@php
    /**
     * Button Component
     *
     * Props:
     * - variant: 'primary' (default), 'outline', 'white'
     * - size: 'sm', 'md' (default), 'lg'
     * - href: For button href (if not set, renders as <button>)
     * - type: Button type (default: 'button')
     * - class: Additional CSS classes
     * - icon: Optional icon to display before text
     * - disabled: Whether button is disabled
     * - loading: Show loading state
     */

    $variant = $variant ?? 'primary';
    $size = $size ?? 'md';
    $href = $href ?? null;
    $type = $type ?? 'button';
    $class = $class ?? '';
    $icon = $icon ?? null;
    $disabled = $disabled ?? false;
    $loading = $loading ?? false;

    // Size classes
    $sizeClasses = match($size) {
        'sm' => 'px-3 py-1.5 text-sm',
        'lg' => 'px-6 py-3.5 text-lg',
        default => 'px-4 py-2 text-base',
    };

    // Variant classes
    $variantClasses = match($variant) {
        'outline' => 'btn-outline',
        'white' => 'btn-white',
        default => 'btn-primary',
    };

    // Base classes
    $baseClasses = "inline-flex items-center justify-center gap-2 font-medium rounded-full transition-all duration-300 whitespace-nowrap";

    // Disabled state
    $disabledClasses = $disabled || $loading ? "opacity-60 cursor-not-allowed pointer-events-none" : "";
@endphp

@if($href)
    <a href="{{ $href }}" @class([$baseClasses, $variantClasses, $sizeClasses, $disabledClasses, $class])>
        @if($loading)
            <svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        @elseif($icon)
            {!! $icon !!}
        @endif
        {{ $slot }}
    </a>
@else
    <button
        type="{{ $type }}"
        @class([$baseClasses, $variantClasses, $sizeClasses, $disabledClasses, $class])
        @if($disabled || $loading) disabled @endif
    >
        @if($loading)
            <svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        @elseif($icon)
            {!! $icon !!}
        @endif
        {{ $slot }}
    </button>
@endif
