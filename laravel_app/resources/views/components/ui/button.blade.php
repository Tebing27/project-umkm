@props([
    'variant' => 'default',
    'size' => 'default',
    'type' => 'button',
    'href' => null,
])

@php
    $baseClass =
        'inline-flex items-center justify-center gap-2 font-reguler transition-all focus:outline-none disabled:opacity-50 disabled:pointer-events-none active:scale-95 cursor-pointer';

    $variants = [
        'default' => 'bg-[#FFC107] hover:bg-[#ffcd38] text-slate-900 shadow-md hover:shadow-lg focus:ring-[#FFC107]',
        'primary' => 'bg-[#005da6] hover:bg-[#004a85] text-white', // Fallback if 'primary' is used
        'destructive' => 'bg-red-600 text-white hover:bg-red-700 shadow-sm focus:ring-red-500',
        'outline' =>
            'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 hover:text-slate-900 hover:border-primary shadow-sm',
        'outline-destructive' =>
            'bg-white border border-red-200 text-red-600 hover:bg-red-50 focus:ring-red-500 shadow-sm',
        'secondary' => 'bg-green-600 text-white hover:bg-green-700 shadow-lg shadow-green-200',
        'ghost' => 'hover:bg-slate-100 text-slate-700 hover:text-slate-900',
        'link' =>
            'text-blue-600 hover:text-blue-700 font-medium border-b border-transparent hover:border-blue-600 hover:no-underline',
        'shiny' => 'bg-[#FFC107] text-white hover:-translate-y-0.5 active:translate-y-0 relative overflow-hidden group',
        'trigger' =>
            'justify-between bg-transparent hover:bg-transparent text-slate-700 hover:text-primary font-semibold border-none rounded-lg text-left',
        'filter' => 'rounded-full border shadow-sm transition-all duration-300',
        'tab' => 'rounded-xl transition-all duration-200 whitespace-nowrap',
        'fab' =>
            'bg-[#FFC107] text-slate-900 hover:bg-blue-800 active:scale-95 flex items-center justify-center rounded-full',
        'circle-white' =>
            'bg-white text-[#003366] shadow-lg border border-gray-100 active:scale-95 flex items-center justify-center rounded-full hover:bg-gray-50 disabled:opacity-50',
        'circle-yellow' =>
            'bg-[#FFC107] text-[#003366] shadow-lg hover:bg-yellow-400 active:scale-95 flex items-center justify-center rounded-full transition-transform',
        'dropdown-trigger' =>
            'bg-white text-gray-700 font-medium rounded-lg hover:bg-gray-50 flex items-center justify-between shadow-sm border border-gray-100 transition whitespace-nowrap',
        'map-control' => 'bg-white text-gray-600 hover:bg-gray-50 font-bold flex items-center justify-center',
        'pill-white' =>
            'bg-white text-[#003366] rounded-full shadow-xl border border-gray-200/80 cursor-pointer hover:bg-gray-50',
    ];

    $sizes = [
        'default' => 'px-4 py-2.5',
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
