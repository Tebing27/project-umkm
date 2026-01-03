@props(['title' => null])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="description" content="{{ $description ?? 'UMKM Sasuma - Temukan dan jelajahi berbagai UMKM terbaik di wilayah Depok dan sekitarnya. Kuliner, jasa, fashion, dan banyak lagi.' }}">
    <meta name="keywords" content="{{ $keywords ?? 'umkm, ukm, depok, sawangan, bojongsari, pengasinan, kuliner, jasa, toko, belanja' }}">
    <meta name="author" content="{{ $author ?? 'UMKM Sasuma' }}">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $title ?? 'UMKM Sasuma - Pusat UMKM Depok' }}">
    <meta property="og:description" content="{{ $description ?? 'UMKM Sasuma - Temukan dan jelajahi berbagai UMKM terbaik di wilayah Depok dan sekitarnya.' }}">
    <meta property="og:image" content="{{ asset('images/og-image.jpg') }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="{{ $title ?? 'UMKM Sasuma - Pusat UMKM Depok' }}">
    <meta property="twitter:description" content="{{ $description ?? 'UMKM Sasuma - Temukan dan jelajahi berbagai UMKM terbaik di wilayah Depok dan sekitarnya.' }}">
    <meta property="twitter:image" content="{{ asset('images/og-image.jpg') }}">

    <title>{{ $title ?? 'UMKM Sasuma' }}</title>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-slate-900 bg-white selection:bg-yellow-400 selection:text-black">

    <x-navigation />

    <main>
        {{ $slot }}
    </main>

    @stack('scripts')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.15.2/dist/cdn.min.js"></script>
</body>

</html>
