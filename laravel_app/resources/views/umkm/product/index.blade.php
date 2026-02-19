<x-layouts.app :title="$product->name . ' - ' . $shop->name" :hideNavigation="true" :product="$product" :shop="$shop">
    <div x-data="{
        seoAltText: 'Jual ' + @js($product->name) + ' di ' + @js($shop->name) + ' - Sasuma',
        ...productDetail({{ $product->toJson() }}, {{ $shop->id }}),
        toStorageUrl(path) {
            if (!path) return '';
            // If it's already a full URL or starts with /storage/ or /
            if (path.startsWith('http') || path.startsWith('//') || path.startsWith('/storage/')) {
                 return path;
            }
            if (path.startsWith('/')) {
                return path;
            }
            return '/storage/' + path;
        },
        toCloudinarySrcset(path) {
            if (!path) return '';
            const url = this.toStorageUrl(path);
            if (!url.includes('res.cloudinary.com')) return '';

            const widths = [320, 640, 800];
            const srcSet = [];

            widths.forEach(w => {
                let variantUrl = url;
                // Check if URL has transformations /upload/.../v...
                const match = variantUrl.match(/\/upload\/(.*?)\/v/);
                if (match) {
                    const params = match[1];
                    let newParams;
                    if (params.includes('w_')) {
                        newParams = params.replace(/w_\d+/, 'w_' + w);
                    } else {
                        newParams = params + ',w_' + w;
                    }
                    variantUrl = variantUrl.replace('/upload/' + params + '/', '/upload/' + newParams + '/');
                } else {
                    variantUrl = variantUrl.replace('/upload/', '/upload/w_' + w + '/');
                }
                srcSet.push(`${variantUrl} ${w}w`);
            });

            return srcSet.join(', ');
        }
    }" 
    @search-update.window="search = $event.detail"
    class="min-h-screen pb-20">

        {{-- Reusing Custom Navigation from Shop Detail --}}
        <x-navigation-umkm />

        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            {{-- Breadcrumb --}}
            <nav class="flex mb-6 text-sm font-medium text-slate-500">
                <a href="/" class="hover:text-brand-blue-dark">{{ translate('Home') }}</a>
                <span class="mx-2">/</span>
                <a href="{{ route('umkm.comment', ['id' => $shop->id, 'tab' => 'produk']) }}" class="hover:text-brand-blue-dark">{{ $shop->name }}</a>
                <span class="mx-2">/</span>
                <span class="text-slate-900 line-clamp-1" x-text="product.name">{{ $product->name }}</span>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12">
                @include('umkm.product.partials._gallery')
                @include('umkm.product.partials._info')
            </div>

            @include('umkm.product.partials._related')

        </main>
    </div>
</x-layouts.app>
