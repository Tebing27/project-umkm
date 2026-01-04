<x-layouts.app :title="translate('Beranda - UMKM Sasuma')">
    <x-home.hero-section :items="$heroItems" :title="$heroTitle" :desc="$heroDesc" :image="$heroImage" />
    <x-home.regions-section :items="$regionItems" :title="$wilayahTitle" :subtitle="$wilayahSubtitle" :desc="$wilayahDesc" />
    <x-home.location-section :mapShops="$mapShops" :regions="$regions" :regions-map="$regionsMap" />
</x-layouts.app>
