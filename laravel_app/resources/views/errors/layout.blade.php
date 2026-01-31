@props(['title', 'code' => 'ERROR', 'message'])

<x-layouts.app :title="$title">
    <div class="min-h-[60vh] flex flex-col items-center justify-start px-4 pt-24 pb-12 sm:px-6 lg:px-8 mt-10 sm:mt-20">
        <div class="max-w-2xl w-full text-center space-y-8">
            {{-- Illustration --}}
            <div class="relative mb-8">
                {{-- Simple 'Door Closed' Illustration --}}
                <div class="w-48 h-48 mx-auto bg-emerald-50 rounded-full flex items-center justify-center relative overflow-hidden">
                    <svg class="w-24 h-24 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.5 10.5V6.75a4.5 4.5 0 119 0v3.75M3.75 21.75h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H3.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.5 10.5v10.5m-3-10.5v10.5" />
                    </svg>
                    <!-- Sign -->
                    <div class="absolute top-[55%] bg-emerald-700 text-white text-[10px] font-bold px-3 py-1 rounded-sm -rotate-6 shadow-md border-2 border-emerald-500 border-dashed">
                        {{ $code }}
                    </div>
                </div>
            </div>

            {{-- Text Content --}}
            <div class="space-y-4">
                <h1 class="text-4xl font-black text-slate-900 tracking-tight sm:text-5xl">
                    {{ $title }}
                </h1>
                <p class="text-lg text-slate-500 max-w-lg mx-auto font-medium">
                    {{ $message }}
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center mt-8">
                    <x-ui.button href="/" class="w-full sm:w-auto px-6 py-3 border-none rounded-lg">
                        {{ translate('Kembali ke Beranda') }}
                    </x-ui.button>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
