<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard Admin - UMKM Sasuma' }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        /* Mencegah scroll horizontal pada level root */
        html, body { overflow-x: hidden; }
    </style>
</head>

<body class="bg-gray-50 font-sans text-slate-800 antialiased" x-data="{
    sidebarOpen: false,
    sidebarExpanded: true
}">

    <div class="flex min-h-screen relative overflow-hidden">

        {{-- SIDEBAR --}}
        <x-navigation-admin />

        {{-- MAIN CONTENT WRAPPER --}}
        <div class="flex-1 flex flex-col min-h-screen bg-gray-50 relative overflow-x-hidden"
            :class="sidebarExpanded ? 'lg:ml-72' : 'lg:ml-20'">

            {{-- MOBILE HEADER --}}
            <x-header-mobile :title="$headerTitle ?? 'Dashboard Admin'" :subtitle="$headerSubtitle ?? 'Overview & Statistik'" />

            {{-- CONTENT AREA --}}
            <main class="flex-1 py-8 px-4 sm:px-6 lg:px-8 w-full mx-auto max-w-[1600px]">
                {{ $slot }}
            </main>
        </div>

        {{-- OVERLAY SIDEBAR MOBILE --}}
        <div x-show="sidebarOpen" @click="sidebarOpen = false"
            x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-40 bg-gray-900/50 backdrop-blur-sm lg:hidden" x-cloak>
        </div>

    </div>

    @stack('scripts')
</body>

</html>
