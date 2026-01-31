@props(['variant' => 'default'])

@php
    $variants = [
        'default' => 'bg-yellow-400 text-slate-900 border-transparent',
        'secondary' => 'bg-gray-100 text-slate-900 border-transparent hover:bg-gray-200/80',
        'outline' => 'text-slate-500 border-slate-200',
        'destructive' => 'bg-red-500 text-white border-transparent hover:bg-red-500/80',
        'success' => 'bg-green-100 text-green-700 border-transparent',
        'info' => 'bg-blue-100 text-blue-700 border-transparent',
        'warning' => 'bg-orange-100 text-orange-700 border-transparent',
    ];

    $baseClasses =
        'inline-flex items-center rounded-md border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-gray-950 focus:ring-offset-2 ';

    $classes = $baseClasses . ($variants[$variant] ?? $variants['default']);
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</div>
