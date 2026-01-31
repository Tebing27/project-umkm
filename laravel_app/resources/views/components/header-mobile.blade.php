@props(['title' => 'Dashboard', 'subtitle' => 'Ringkasan aktivitas'])

<div
    class="lg:hidden flex items-center justify-between p-5 bg-white border-b border-gray-100 shrink-0 sticky top-0 z-20">
    <div class="flex items-center gap-3">
        <x-ui.button @click="sidebarOpen = !sidebarOpen" variant="ghost" size="icon"
            class="text-slate-500 hover:text-brand-blue-dark h-auto w-auto p-1">
            <x-icons.ui-menu class="w-6 h-6" />
        </x-ui.button>
        <div>
            <h1 class="text-lg font-bold text-slate-900 leading-none">{{ $title }}</h1>
            <p class="text-xs text-slate-500 mt-0.5">{{ $subtitle }}</p>
        </div>
    </div>

    <div class="relative">
        <div class="w-9 h-9 rounded-full bg-gray-100 border border-gray-200 overflow-hidden">
            <img loading="lazy" src="{{ Auth::user()->shop->logo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=0D8ABC&color=fff' }}"
                        class="w-10 h-10 rounded-full object-cover ring-2 ring-white shadow-md transition-transform duration-300 group-hover:scale-105">
        </div>
        <div class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-green-500 rounded-full border-2 border-white"></div>
    </div>
</div>
