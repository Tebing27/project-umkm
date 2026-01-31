<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Dashboard UMKM' }}</title>

    <link rel="preconnect" href="https://res.cloudinary.com">

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

</head>

{{-- STATE GLOBAL SIDEBAR ADA DI SINI --}}

<body x-data="{ sidebarOpen: false, sidebarExpanded: true }">

    <div class="flex min-h-screen relative">

        {{-- SIDEBAR DIPANGGIL DI LAYOUT --}}
        <x-navigation-users />

        {{-- MAIN CONTENT WRAPPER --}}
        <div class="flex-1 flex flex-col min-h-screen bg-gray-50 overflow-x-hidden"
            :class="sidebarExpanded ? 'lg:ml-72' : 'lg:ml-8'">

            {{-- MOBILE HEADER --}}
            <x-header-mobile :title="$headerTitle ?? 'Dashboard'" :subtitle="$headerSubtitle ?? ''" />

            {{-- CONTENT SLOT --}}
            <main class="flex-1 p-6 md:p-10 lg:p-12 w-full max-w-7xl mx-auto">
                {{ $slot }}
            </main>
        </div>

        {{-- MOBILE OVERLAY --}}
        <div x-show="sidebarOpen" @click="sidebarOpen = false"
            class="fixed inset-0 z-40 bg-gray-900/50 backdrop-blur-sm lg:hidden" x-cloak>
        </div>

    </div>

    @stack('scripts')
</body>

</html>
