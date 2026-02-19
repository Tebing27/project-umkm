{{-- Left: Image Gallery --}}
<div class="lg:col-span-5">
    <div class="sticky top-24 space-y-4">
        {{-- Main Image --}}
        <div class="bg-white rounded-2xl overflow-hidden border border-slate-200">
            <div class="aspect-square relative group">
                <img loading="lazy" :src="imageUrl" :srcset="toCloudinarySrcset(activeImage || product.image)" :alt="seoAltText" sizes="(max-width: 640px) 100vw, 500px" class="w-full h-full object-contain bg-white">
            </div>
        </div>

        {{-- Thumbnails --}}
        <div x-show="product.images && product.images.length > 0" class="grid grid-cols-5 gap-3">
             <template x-for="(img, index) in product.images" :key="img.id || index">
                 <button @click="setActiveImage(img.image)" 
                     class="aspect-square rounded-xl overflow-hidden border-2 transition-all relative"
                     :class="(activeImage === img.image || (!activeImage && index === 0)) ? 'border-slate-300 opacity-100' : 'border-transparent hover:border-slate-300 opacity-70 hover:opacity-100'">
                     <img loading="lazy" :src="toStorageUrl(img.image)" 
                          :srcset="toCloudinarySrcset(img.image)"
                          :alt="seoAltText + ' - ' + (index + 1)"
                          sizes="100px"
                          class="w-full h-full object-cover">
                 </button>
             </template>
        </div>
    </div>
</div>
