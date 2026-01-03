@props(['class' => ''])

<div {{ $attributes->merge(['class' => 'bg-white rounded-3xl border border-slate-100 shadow-[0_2px_20px_-4px_rgba(0,0,0,0.05)] ' . $class]) }}>
    {{ $slot }}
</div>
