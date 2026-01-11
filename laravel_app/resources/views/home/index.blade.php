<x-layouts.app :title="translate('Beranda - UMKM Sasuma')">
    @include('home.partials.hero', ['items' => $heroItems, 'title' => $heroTitle, 'desc' => $heroDesc, 'image' => $heroImage])
    @include('home.partials.regions', ['items' => $regionItems, 'title' => $wilayahTitle, 'subtitle' => $wilayahSubtitle, 'desc' => $wilayahDesc])
    @include('home.partials.location', ['mapShops' => $mapShops, 'regions' => $regions, 'regionsMap' => $regionsMap, 'categories' => $categories])
</x-layouts.app>
