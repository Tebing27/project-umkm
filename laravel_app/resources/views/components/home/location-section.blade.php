@props(['mapShops', 'regions', 'regionsMap'])
<x-home.location-section.maps.style />
<x-home.location-section.maps.popup />

<x-home.location-section.icons />

<section id="location" class="py-0 md:py-12 bg-white overflow-hidden" x-data="umkmMap" x-init="initMap()">
    <div class="container mx-auto max-w-7xl">
        <x-home.location-section.header />

        <div
            class="relative flex flex-col md:flex-row h-[90vh] md:h-[1002px] w-full md:w-[1281px] rounded-b-3xl overflow-hidden shadow-2xl bg-white border border-gray-200">

            <x-home.location-section.sidebar :regions="$regions" />

            <x-home.location-section.map />
        </div>
    </div>
</section>
<x-home.location-section.maps.script :map-shops="$mapShops" :regions-map="$regionsMap" />
