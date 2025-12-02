<section class="py-12 bg-white overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" x-data="{
        items: [
            { title: 'Cinangka', count: '22 UMKM', color: 'bg-[#c3daff]', image: 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=600&q=80' },
            { title: 'Kedaung', count: '20 UMKM', color: 'bg-[#cbf3e3]', image: 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=600&q=80' },
            { title: 'Sawangan', count: '15 UMKM', color: 'bg-[#c3daff]', image: 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=600&q=80' },
            { title: 'Pengasinan', count: '20 UMKM', color: 'bg-[#cbf3e3]', image: 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=600&q=80' },
            { title: 'Bojongsari', count: '18 UMKM', color: 'bg-[#c3daff]', image: 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=600&q=80' }
        ],
        getScrollAmount() {
            const card = this.$refs.slider.firstElementChild;
            return card ? card.offsetWidth + 24 : 344;
        },
        next() {
            const el = this.$refs.slider;
            const amount = this.getScrollAmount();
            if (el.scrollLeft + el.clientWidth >= el.scrollWidth - 10) {
                el.scrollTo({ left: 0, behavior: 'smooth' });
            } else {
                el.scrollBy({ left: amount, behavior: 'smooth' });
            }
        },
        prev() {
            const el = this.$refs.slider;
            const amount = this.getScrollAmount();
            if (el.scrollLeft <= 0) {
                el.scrollTo({ left: el.scrollWidth, behavior: 'smooth' });
            } else {
                el.scrollBy({ left: -amount, behavior: 'smooth' });
            }
        }
    }">
        <h1
            class="text-center lg:text-center text-3xl md:text-4xl lg:text-5xl font-bold text-black mb-8 lg:mb-16 tracking-tight">
            Wilayah
        </h1>

        <div class="flex flex-col md:flex-row gap-4 items-center justify-between">

            <div class="w-full md:w-1/3 flex flex-col lg:sticky lg:left-0 lg:top-4">

                <div class="flex flex-col justify-between items-start w-full gap-4 mb-6 lg:mb-0">

                    <div class="w-full px-4 sm:px-6">
                        <h2 class="text-2xl md:text-3xl font-bold text-black leading-tight mb-2 lg:mb-4">
                            Ayo Jelajahi
                        </h2>
                        <p class="text-gray-600 text-sm md:text-lg leading-relaxed text-balance">
                            berbagai jenis usaha lokal di wilayah kalian berada
                        </p>
                    </div>

                    <div class="flex gap-3 shrink-0 md:mt-8 w-full px-4 sm:px-6 justify-end">
                        <button @click="prev()"
                            class="w-10 h-10 md:w-12 md:h-12 rounded-full bg-[#005da6] hover:bg-[#004a85] flex items-center justify-center text-white transition-all shadow-lg active:scale-95"
                            aria-label="Previous Slide">
                            <x-icons.svg name="area-left" class="w-4 h-4 md:w-5 md:h-5" />
                        </button>
                        <button @click="next()"
                            class="w-10 h-10 md:w-12 md:h-12 rounded-full bg-[#005da6] hover:bg-[#004a85] flex items-center justify-center text-white transition-all shadow-lg active:scale-95"
                            aria-label="Next Slide">
                            <x-icons.svg name="area-right" class="w-4 h-4 md:w-5 md:h-5" />
                        </button>
                    </div>
                </div>
            </div>

            <div class="w-full md:w-2/3 min-w-0">
                <div x-ref="slider"
                    class="flex gap-6 overflow-x-auto pb-8 pt-2 snap-x snap-mandatory scroll-smooth [&::-webkit-scrollbar]:hidden [-ms-overflow-style:none] [scrollbar-width:none] -mx-4 px-4 sm:-mx-6 sm:px-6 lg:mx-0 lg:px-0 lg:pl-4 lg:pr-4">
                    <template x-for="(item, index) in items" :key="index">
                        <div class="min-w-[260px] md:min-w-[320px] snap-center rounded-xl overflow-hidden flex flex-col transition-transform hover:scale-[1.02] duration-300 shadow-sm border border-gray-100/50"
                            :class="item.color">
                            <div class="px-6 pt-8 md:px-8 md:pt-12 pb-0 flex justify-center items-end h-48 md:h-64">
                                <img :src="item.image"
                                    class="w-full h-full object-cover rounded-t-xl shadow-md object-center"
                                    alt="Kategori Image" loading="lazy">
                            </div>

                            <div class="p-6 md:p-8 text-center flex flex-col items-center flex-grow bg-opacity-50">
                                <h3 class="text-2xl md:text-3xl font-bold text-black mb-1" x-text="item.title"></h3>
                                <p class="text-gray-700 text-sm mb-4 md:mb-6 font-medium" x-text="item.count"></p>

                                <div class="flex justify-center">
                                    <a href="#"
                                        class="inline-flex items-center gap-1 text-blue-600 font-medium text-sm pt-1 border-b border-transparent hover:border-blue-600">
                                        Lihat Lokasi
                                        <x-icons.svg name="arrow-wilayah" class="w-4 h-4" />
                                    </a>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

        </div>
    </div>
</section>
