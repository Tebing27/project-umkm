@props([
    'variant' => 'default',
    'size' => 'default',
    'type' => 'button',
    'href' => null,
])

@php
    $baseClass =
        'inline-flex items-center justify-center gap-2 text-base font-semibold transition-all focus:outline-none disabled:opacity-50 disabled:pointer-events-none active:scale-95 cursor-pointer';

    $variants = [
        'default' => 'bg-brand-yellow hover:bg-brand-yellow-hover text-slate-900 shadow-md hover:shadow-lg focus:ring-brand-yellow',
        'primary' => 'bg-brand-blue hover:bg-brand-blue-dark text-white',
        'destructive' => 'bg-red-600 text-white hover:bg-red-700 shadow-sm focus:ring-red-500',
        'outline' =>
            'bg-white border border-gray-200 text-slate-600 hover:bg-gray-50 hover:text-slate-900 hover:border-primary shadow-sm',

        'ghost' => 'hover:bg-gray-100 text-slate-700 hover:text-slate-900',

        'link' =>
            'text-blue-600 hover:text-blue-700 font-medium border-b border-transparent hover:border-blue-600 hover:no-underline',
        'shiny' => 'bg-brand-yellow text-white hover:-translate-y-0.5 active:translate-y-0 relative overflow-hidden group',
        'trigger' =>
            'justify-between bg-transparent hover:bg-transparent text-slate-700 hover:text-primary font-semibold border-none rounded-lg text-left',
        'filter' => 'rounded-full border shadow-sm transition-all duration-300',
        'tab' => 'rounded-lg transition-all duration-200 whitespace-nowrap',
        'fab' =>
            'bg-brand-yellow text-slate-900 hover:bg-blue-800 active:scale-95 flex items-center justify-center rounded-full',
        'circle-white' =>
            'bg-white text-brand-navy shadow-lg border border-gray-100 active:scale-95 flex items-center justify-center rounded-full hover:bg-gray-50 disabled:opacity-50',
        'circle-yellow' =>
            'bg-brand-yellow text-brand-navy shadow-lg hover:bg-yellow-400 active:scale-95 flex items-center justify-center rounded-full transition-transform',
        'dropdown-trigger' =>
            'bg-white text-slate-700 font-medium rounded-lg hover:bg-gray-50 flex items-center justify-between shadow-sm border border-gray-100 transition whitespace-nowrap',
        'map-control' => 'bg-white text-slate-600 hover:bg-gray-50 font-bold flex items-center justify-center',
        'pill-white' =>
            'bg-white text-brand-navy rounded-full shadow-xl border border-gray-200/80 cursor-pointer hover:bg-gray-50',

        // New Variants for Refactor
        'link-gray' =>
            'text-slate-600 hover:text-slate-900 underline underline-offset-4 rounded-md focus:ring-2 focus:ring-offset-2 focus:ring-blue-500',
        'circle-red' => 'bg-red-500 text-white rounded-full shadow-lg hover:scale-110 transition p-2.5',
        'circle-white-action' => 'bg-white text-slate-900 rounded-full shadow-lg hover:scale-110 transition p-2.5',
        'icon-box' =>
            'bg-white text-slate-700 border border-gray-200 shadow-sm hover:bg-gray-50 hover:text-brand-blue-dark rounded-md p-1.5',
        'icon-box-danger' => 'bg-red-500 text-white shadow-sm hover:bg-red-600 rounded-md p-1.5',
        'soft-edit' =>
            'bg-gray-100 text-slate-600 hover:bg-brand-blue-dark hover:text-white rounded-lg font-bold transition-all duration-200',
        'soft-delete' =>
            'bg-red-50 text-red-600 hover:bg-red-600 hover:text-white rounded-lg font-bold transition-all duration-200',
        'dashed-card' =>
            'bg-gray-50 border-2 border-dashed border-gray-300 hover:border-brand-blue-dark hover:bg-blue-50/30 rounded-2xl transition-all duration-300 flex flex-col items-center justify-center relative overflow-hidden h-full',
        'ghost-circle' => 'rounded-full hover:bg-gray-100 text-slate-500 p-2',
        'circle-white-lg' =>
            'bg-white border border-gray-200 text-slate-700 hover:text-blue-600 shadow-lg rounded-full active:bg-gray-50 p-3',
    ];

    $sizes = [
        'default' => 'px-4 py-2.5',
        'xs' => 'py-2',
        'sm' => 'h-9 px-3 rounded-lg text-xs',
        'lg' => 'h-11 px-8 rounded-xl',
        'xl' => 'px-6 py-3 rounded-xl text-lg',
        'icon' => 'h-8 w-8',
        'icon-link' => 'h-auto p-0 rounded-none pt-1',
        'compact' => 'px-4 py-2 h-auto',
        'chip' => 'px-5 py-2.5',
        'fab' => 'p-4',
        'icon-lg' => 'w-10 h-10 p-0',
        'map-ctrl' => 'w-8 h-8',
        'square' => 'aspect-square p-0 flex items-center justify-center',
    ];

    $classes = $baseClass . ' ' . ($variants[$variant] ?? $variants['default']) . ' ' . $sizes[$size];
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif
