

<section class="py-12 bg-white overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" x-data="{
        items: {{ json_encode($items) }},
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
        @include('home.partials.regions.header-title', ['title' => $title])

        <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
            @include('home.partials.regions.info-panel', ['subtitle' => $subtitle, 'desc' => $desc])
            
            @include('home.partials.regions.slider')
        </div>
    </div>
</section>
