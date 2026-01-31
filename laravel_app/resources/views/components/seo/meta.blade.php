@props([
    'title' => 'UMKM Sasuma',
    'description' => 'UMKM Sasuma - Pusat UMKM Depok',
    'image' => asset('images/og_image.webp'),
    'type' => 'website',
    'product' => null,
    'shop' => null,
])

<!-- SEO Meta Tags -->
<title>{{ $title }}</title>
<meta name="description" content="{{ $description }}">
<meta name="author" content="UMKM Sasuma">
<link rel="canonical" href="{{ url()->current() }}">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="{{ $type }}">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:title" content="{{ $title }}">
<meta property="og:description" content="{{ $description }}">
<meta property="og:image" content="{{ $image }}">

<!-- Twitter -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:url" content="{{ url()->current() }}">
<meta name="twitter:title" content="{{ $title }}">
<meta name="twitter:description" content="{{ $description }}">
<meta name="twitter:image" content="{{ $image }}">

<!-- JSON-LD -->
@php
    $schemas = [];

    if ($product) {
        $schemas[] = [
            '@context' => 'https://schema.org/',
            '@type' => 'Product',
            'name' => $product->name,
            'image' => [ $image ],
            'description' => $description,
            'sku' => $product->id,
            'brand' => [
                '@type' => 'Brand',
                'name' => $shop->name ?? 'UMKM Sasuma'
            ],
            'offers' => [
                '@type' => 'Offer',
                'url' => url()->current(),
                'priceCurrency' => 'IDR',
                'price' => $product->price,
                'itemCondition' => 'https://schema.org/NewCondition',
                'availability' => 'https://schema.org/InStock'
            ]
        ];
    }

    if ($shop) {
        $schemas[] = [
            '@context' => 'https://schema.org',
            '@type' => 'LocalBusiness',
            'name' => $shop->name,
            'image' => $shop->logo_url,
            'description' => $shop->description,
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => $shop->address,
                'addressLocality' => 'Depok',
                'addressRegion' => 'Jawa Barat',
                'addressCountry' => 'ID'
            ],
            'url' => url()->current(),
            'priceRange' => '$$'
        ];
    }
@endphp

@foreach($schemas as $schema)
<script type="application/ld+json">
    @json($schema)
</script>
@endforeach
