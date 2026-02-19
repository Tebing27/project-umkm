<x-layouts.app :title="translate('Beranda - UMKM Sasuma')">
    {{-- Section: Hero Slider --}}
    @include('home.partials._hero', ['items' => $heroItems, 'title' => $heroTitle, 'desc' => $heroDesc, 'image' => $heroImage])
    {{-- End Section: Hero Slider --}}

    {{-- Section: Regions List --}}
    @include('home.partials._regions', ['items' => $regionItems, 'title' => $wilayahTitle, 'subtitle' => $wilayahSubtitle, 'desc' => $wilayahDesc])
    {{-- End Section: Regions List --}}

    {{-- Section: Map Location --}}
    @include('home.partials._location', ['mapShops' => $mapShops, 'regions' => $regions, 'regionsMap' => $regionsMap, 'categories' => $categories])
    {{-- End Section: Map Location --}}
</x-layouts.app>
