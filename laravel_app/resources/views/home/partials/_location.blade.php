@include('home.partials.location._map-style')
@include('home.partials.location._map-popup')

@include('home.partials.location._icons')

<section id="locations" class="pt-0 pb-8 md:py-12 bg-white overflow-hidden" x-data="umkmMap" x-init="initMap()">
    <script type="application/json" id="map-data">
        {
            "umkms": @json($mapShops),
            "regionList": @json($regionsMap)
        }
    </script>
    <div class="container mx-auto max-w-7xl">
        @include('home.partials.location._header')

        <div
            class="relative flex flex-col md:flex-row h-[90vh] md:h-[1002px] w-full rounded-b-3xl overflow-hidden shadow-2xl bg-white border border-gray-200">

            @include('home.partials.location._sidebar', ['regions' => $regions])

            @include('home.partials.location._map')
        </div>
    </div>
</section>
@include('home.partials.location._map-script', ['umkms' => $mapShops, 'regionList' => $regionsMap, 'categories' => $categories, 'businessTypesWithIcons' => $businessTypesWithIcons])
