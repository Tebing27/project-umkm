@props(['title' => 'Dashboard', 'subtitle' => 'Ringkasan aktivitas'])

<div class="lg:hidden flex items-center justify-between p-5 bg-white border-b border-gray-100 shrink-0 sticky top-0 z-20">
    <div class="flex items-center gap-3">
        <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 hover:text-[#004a85] transition-colors focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
        <div>
            <h1 class="text-lg font-bold text-gray-900 leading-none">{{ $title }}</h1>
            <p class="text-xs text-gray-500 mt-0.5">{{ $subtitle }}</p>
        </div>
    </div>

    <div class="relative">
        <div class="w-9 h-9 rounded-full bg-gray-100 border border-gray-200 overflow-hidden">
            <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?auto=format&fit=crop&w=100&q=80"
                class="w-full h-full object-cover">
        </div>
        <div class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-green-500 rounded-full border-2 border-white"></div>
    </div>
</div>
