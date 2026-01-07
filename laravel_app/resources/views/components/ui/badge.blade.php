@props(['variant' => 'default'])

@php
    $variants = [
        'default' => 'bg-yellow-400 text-slate-900',
    ];

    $baseClasses = 'text-xs font-medium ';
    $variantClasses = $variants[$variant] ?? $variants['default'];
    
    $classes = 'rounded-md text-xs font-medium ' . ($variants[$variant] ?? $variants['default']);
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</div>
