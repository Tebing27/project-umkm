@props([
    'disabled' => false,
    'icon' => null,
    'error' => false,
    'variant' => 'default',
    'size' => 'md',
])

@php
    $baseClass =
        'w-full border text-slate-900 placeholder-slate-400 font-medium focus:outline-none transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed';

    $sizes = [
        'sm' => 'text-xs py-2',
        'md' => 'text-sm py-3',
        'lg' => 'text-base py-3.5',
    ];

    $paddingClass = $icon ? ($size === 'sm' ? 'pl-9 pr-3' : 'pl-11 pr-4') : ($size === 'sm' ? 'px-3' : 'px-4');

    $variants = [
        'default' =>
            'bg-slate-50 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary ' .
            ($error ? 'border-red-500 focus:ring-red-200' : 'border-slate-200'),
        'outline' =>
            'bg-white rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary ' .
            ($error ? 'border-red-500 focus:ring-red-200' : 'border-slate-200'),
        'transparent' => 'bg-transparent border-none focus:ring-0 shadow-none p-0 h-full',
        'ghost' => 'bg-transparent hover:bg-slate-50 focus:bg-slate-100 border-none rounded-lg',
        'search' =>
            'bg-slate-50 outline-none focus:bg-white rounded-xl border-gray-300 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500',
        'soft' => 'bg-[#f9f8f6] border-[#d1d5db] rounded-lg focus:ring-2 focus:ring-blue-500/10 focus:border-blue-500',
    ];

    $classes =
        $baseClass . ' ' . $sizes[$size] . ' ' . $paddingClass . ' ' . ($variants[$variant] ?? $variants['default']);

    $wrapperBase = 'relative flex items-center group w-full';
    if ($variant === 'transparent') {
        $wrapperBase .= ' h-full w-full';
    }
@endphp

<div {{ $attributes->merge(['class' => $wrapperBase])->only(['class', 'style']) }}>
    @if ($icon)
        <div
            class="absolute inset-y-0 left-0 flex items-center pointer-events-none text-slate-500 group-focus-within:text-blue-600 transition-colors {{ $size === 'sm' ? 'pl-3' : 'pl-4' }}">
            {{ $icon }}
        </div>
    @endif

    <input {{ $disabled ? 'disabled' : '' }} {{ $attributes->except(['class', 'style']) }}
        class="{{ $classes }} {{ $attributes->get('class') }}">
</div>
