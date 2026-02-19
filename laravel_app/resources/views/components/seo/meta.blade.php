@props([
    'title' => 'UMKM Sasuma',
    'description' => 'UMKM Sasuma - Pusat UMKM Depok',
    'image' => asset('images/og_image.webp'),
    'type' => 'website',
    'product' => null,
    'shop' => null,
    'canonical' => null,
])

@php
    // Use provided canonical URL or default to clean URL without query params
    $canonicalUrl = $canonical ?? request()->url();
@endphp

<!-- SEO Meta Tags -->
<title>{{ $title }}</title>
<meta name="description" content="{{ $description }}">
<meta name="author" content="UMKM Sasuma">
<link rel="canonical" href="{{ $canonicalUrl }}">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="{{ $type }}">
<meta property="og:url" content="{{ $canonicalUrl }}">
<meta property="og:title" content="{{ $title }}">
<meta property="og:description" content="{{ $description }}">
<meta property="og:image" content="{{ $image }}">

<!-- Twitter -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:url" content="{{ $canonicalUrl }}">
<meta name="twitter:title" content="{{ $title }}">
<meta name="twitter:description" content="{{ $description }}">
<meta name="twitter:image" content="{{ $image }}">

<!-- JSON-LD -->
@php
    $schemas = [];

    if ($product) {
        // Collect all product images for better Google Image indexing
        $productImages = [];
        
        // Add primary image first
        if ($image) {
            $productImages[] = $image;
        }
        
        // Add additional images from product.images relation
        if ($product->relationLoaded('images') && $product->images->count() > 0) {
            foreach ($product->images as $img) {
                $imgUrl = storage_url($img->image);
                // Avoid duplicates
                if ($imgUrl !== $image && !in_array($imgUrl, $productImages)) {
                    $productImages[] = $imgUrl;
                }
            }
        }
        
        $schemas[] = [
            '@context' => 'https://schema.org/',
            '@type' => 'Product',
            'name' => $product->name,
            'image' => $productImages,
            'description' => $description,
            'sku' => $product->id,
            'brand' => [
                '@type' => 'Brand',
                'name' => $shop->name ?? 'UMKM Sasuma'
            ],
            'offers' => [
                '@type' => 'Offer',
                'url' => $canonicalUrl,
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
            'url' => $canonicalUrl,
            'priceRange' => '$$'
        ];
    }
@endphp

@foreach($schemas as $schema)
<script type="application/ld+json">
    @json($schema)
</script>
@endforeach
