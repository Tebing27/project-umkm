@props([
    'disabled' => false,
    'error' => false,
    'icon' => null,
    'variant' => 'default',
])

@php
    $baseClasses =
        'w-full focus:outline-none sm:text-sm p-3 resize-none transition-all duration-200 disabled:opacity-50';

    $paddingClass = $icon ? 'pl-11' : 'px-4';

    $variants = [
        'default' => 'bg-white border border-gray-300 rounded-lg focus:ring-primary/20 focus:border-primary',
        'soft' => 'bg-[#f9f8f6] border border-[#d1d5db] rounded-lg focus:ring-blue-500/10 focus:border-blue-500',
        'gray' => 'bg-gray-50 border border-gray-300 rounded-lg focus:ring-blue-500/20 focus:border-blue-500',
        'transparent' => 'bg-transparent border-transparent focus:border-transparent border-0 focus:ring-0 ring-0 outline-none shadow-none p-0 rounded-none',
    ];

    $errorClasses = $error ? 'border-red-500 focus:ring-red-200' : '';

    $finalClasses =
        $baseClasses .
        ' ' .
        $paddingClass .
        ' ' .
        ($variants[$variant] ?? $variants['default']) .
        ' ' .
        $errorClasses .
        ' ' .
        $attributes->get('class');
@endphp

<div class="relative group w-full">
    @if ($icon)
        <div
            class="absolute top-3 left-0 flex items-start pl-4 pointer-events-none text-slate-500 group-focus-within:text-blue-600 transition-colors">
            {{ $icon }}
        </div>
    @endif

    <textarea {{ $disabled ? 'disabled' : '' }} {{ $attributes->except(['class', 'style', 'variant']) }}
        class="{{ $finalClasses }}">{{ $slot }}</textarea>
</div>
