@props(['show' => false, 'maxWidth' => '2xl', 'closeable' => true])

@php
$maxWidth = [
    'sm' => 'sm:max-w-sm',
    'md' => 'sm:max-w-md',
    'lg' => 'sm:max-w-lg',
    'xl' => 'sm:max-w-xl',
    '2xl' => 'sm:max-w-2xl',
][$maxWidth];
@endphp

<div
    x-show="{{ $show }}"
    style="display: none;"
    class="fixed inset-0 overflow-y-auto z-[60]"
    x-cloak
>
    {{-- Blur Backdrop --}}
    <div
        class="fixed inset-0 bg-slate-900/60 transition-opacity"
        x-show="{{ $show }}"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @if($closeable) @click="{{ $show }} = false" @endif
    ></div>

    {{-- Content --}}
    <div class="flex min-h-full items-center justify-center p-4 text-center">
        <div
            x-show="{{ $show }}"
            x-transition:enter="ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="ease-in duration-100"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 translate-y-4"
            class="relative transform overflow-hidden rounded-2xl bg-white text-left align-middle shadow-2xl transition-all w-full {{ $maxWidth }}"
            @click.stop
        >
            {{ $slot }}
        </div>
    </div>
</div>
