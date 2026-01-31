@include('home.partials.location.map-style')
@include('home.partials.location.map-popup')

@include('home.partials.location.icons')

<section id="locations" class="py-0 md:py-12 bg-white overflow-hidden" x-data="umkmMap" x-init="initMap()">
    <script type="application/json" id="map-data">
        {
            "umkms": @json($mapShops),
            "regionList": @json($regionsMap)
        }
    </script>
    <div class="container mx-auto max-w-7xl">
        @include('home.partials.location.header')

        <div
            class="relative flex flex-col md:flex-row h-[90vh] md:h-[1002px] w-full rounded-b-3xl overflow-hidden shadow-2xl bg-white border border-gray-200">

            @include('home.partials.location.sidebar', ['regions' => $regions])

            @include('home.partials.location.map')
        </div>
    </div>
</section>
@include('home.partials.location.map-script', ['umkms' => $mapShops, 'regionList' => $regionsMap, 'categories' => $categories, 'businessTypesWithIcons' => $businessTypesWithIcons])
