@props(['variant' => 'default'])

@php
    $variants = [
        'default' => 'bg-yellow-400 text-slate-900',
        'secondary' => 'bg-green-50 text-green-700 border-green-100 ring-green-500/20', // Verified
        'warning' => 'bg-yellow-100 text-yellow-700 border-yellow-200 ring-yellow-500/20', // Pending
        'destructive' => 'bg-red-50 text-red-700 border-red-100 ring-red-500/20', // Failed
        'outline' => 'text-slate-900 border-slate-200',
    ];

    $baseClasses = 'text-xs font-medium ';
    $variantClasses = $variants[$variant] ?? $variants['default'];
    
    $classes = 'rounded-md text-xs font-medium ' . ($variants[$variant] ?? $variants['default']);
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</div>
