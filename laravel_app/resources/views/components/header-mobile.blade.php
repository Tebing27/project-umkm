@props(['title' => 'Dashboard', 'subtitle' => 'Ringkasan aktivitas'])

<div
    class="lg:hidden flex items-center justify-between p-5 bg-white border-b border-gray-100 shrink-0 sticky top-0 z-20">
    <div class="flex items-center gap-3">
        <x-ui.button @click="sidebarOpen = !sidebarOpen" variant="ghost" size="icon"
            class="text-gray-500 hover:text-[#004a85] h-auto w-auto p-1">
            <x-icons.menu class="w-6 h-6" />
        </x-ui.button>
        <div>
            <h1 class="text-lg font-bold text-gray-900 leading-none">{{ $title }}</h1>
            <p class="text-xs text-gray-500 mt-0.5">{{ $subtitle }}</p>
        </div>
    </div>

    <div class="relative">
        <div class="w-9 h-9 rounded-full bg-gray-100 border border-gray-200 overflow-hidden">
            <div class="w-full h-full flex items-center justify-center bg-[#0D8ABC] text-white text-xs font-bold">
                {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 2)) }}
            </div>
        </div>
        <div class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-green-500 rounded-full border-2 border-white"></div>
    </div>
</div>
