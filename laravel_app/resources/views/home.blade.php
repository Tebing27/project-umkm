<x-layouts.app :title="translate('Beranda - UMKM Sasuma')">
    <x-home.hero :items="$heroItems" :title="$heroTitle" :desc="$heroDesc" :image="$heroImage" />
    <x-home.wilayah :items="$regionItems" :title="$wilayahTitle" :subtitle="$wilayahSubtitle" :desc="$wilayahDesc" />
    <x-home.lokasi :mapShops="$mapShops" :regions="$regions" :regions-map="$regionsMap" />
</x-layouts.app>
