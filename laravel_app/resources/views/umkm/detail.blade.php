<x-layouts.app title="Detail Toko - UMKM Sasuma">

    <x-navigation />

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-32">

        {{-- Store Header Section --}}
        <div class="bg-[#FEFBE8] rounded-3xl p-6 md:p-10 mb-12 relative overflow-hidden">
            <div class="flex flex-col md:flex-row gap-8 items-start">

                {{-- Store Image --}}
                <div
                    class="w-32 h-32 md:w-48 md:h-48 rounded-full overflow-hidden border-4 border-white shadow-lg shrink-0 mx-auto md:mx-0">
                    <img src="https://images.unsplash.com/photo-1555939594-58d7cb561ad1?auto=format&fit=crop&w=300&q=80"
                        class="w-full h-full object-cover" alt="Toko">
                </div>

                {{-- Store Info --}}
                <div class="flex-1 space-y-4 w-full">
                    <div>
                        <div class="text-slate-600 font-medium mb-1">Tebing</div>
                        <div class="flex flex-wrap items-center gap-3 mb-2">
                            <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900">Tebing UMKM</h1>

                            <x-ui.badge class="px-2.5 py-1">Kuliner</x-ui.badge>
                        </div>

                        <div class="flex items-start gap-2 text-slate-600 text-sm">
                            <x-icons.location class="!w-5 !h-5 shrink-0" />
                            <span class="mt-1">Jl. Podang 14 No 113 RT 03/12 blok H2 BSI 2 pengasinan sawangan
                                Depok</span>
                        </div>
                    </div>

                    {{-- Omset --}}
                    <div class="border-t border-slate-200/60 pt-3">
                        <h3 class="font-bold text-slate-900 text-base mb-1">Omset Penjualan</h3>
                        <p class="text-slate-600 text-sm">Rp. 10.000 - Rp. 10.000.000</p>
                    </div>

                    {{-- Izin --}}
                    <div class="border-t border-slate-200/60 pt-3">
                        <h3 class="font-bold text-slate-900 text-base mb-1">Izin Usaha</h3>
                        <p class="text-slate-600 text-sm">SIB, Sertifikat Halal</p>
                    </div>

                    {{-- Social Media Links --}}
                    <div class="border-t border-slate-200/60 pt-3 grid grid-cols-1 sm:grid-cols-2 gap-y-2 gap-x-4">
                        <div class="flex items-center gap-2">
                            <x-icons.instagram class="w-5 h-5 text-red-500" />
                            <span class="text-sm text-slate-900">@tebingtsaaa</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <x-icons.facebook class="text-[#1877F2]" />
                            <span class="text-sm text-slate-900">tebingtsaaa</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <x-icons.tiktok class="text-slate-900" />
                            <span class="text-sm text-slate-600">tebingtsaaa</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <x-icons.globe class="w-5 h-5 text-slate-900" />
                            <span class="text-sm text-slate-600">google.com</span>
                        </div>

                    </div>

                    {{-- Description --}}
                    <div class="border-t border-slate-200/60 pt-3">
                        <p class="text-slate-600 text-sm leading-relaxed">
                            UMKM kuliner kami menghadirkan jajanan kekinian favorit anak muda, yaitu Cilor (Aci Telor)
                            dan Maklor (Makaroni Telor). Dibuat dari bahan pilihan dengan cita rasa gurih, pedas, dan
                            nikmat, jajanan ini cocok dinikmati kapan saja, baik sebagai camilan santai maupun teman
                            berkumpul bersama teman.
                        </p>
                    </div>

                    {{-- Action Button --}}
                    <div class="pt-2">
                        <x-ui.button
                            class="bg-[#FFC107] hover:bg-yellow-400 text-slate-900 font-medium px-6 py-2.5 rounded-lg shadow-sm transition-all active:scale-95 text-sm h-auto border-none">
                            Lihat Lokasi
                        </x-ui.button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Product Section Logic --}}
        <div x-data="productLogic()">

            {{-- Header Produk (Judul & Filter) --}}
            <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">

                {{-- Judul --}}
                <div>
                    <h2 class="text-2xl font-bold text-slate-900 shrink-0">Daftar Produk</h2>
                    <p class="text-sm text-slate-500 mt-1">
                        Menampilkan: <span class="font-bold text-primary"
                            x-text="category === 'Semua' ? 'Semua Kategori' : category"></span>
                    </p>
                </div>

                {{-- Tools: Search & Filter --}}
                <div class="flex flex-row sm:flex-row gap-3 w-full md:w-auto">

                    {{-- Search Input --}}
                    <div class="relative w-64 sm:w-64">
                        <div
                            class="absolute left-3 top-1/2 -translate-y-[46%] md:-translate-y-[54%] pointer-events-none text-slate-400">
                            <x-icons.location-search class="w-5 h-5" />
                        </div>

                        {{-- Menggunakan input biasa sesuai request design, tapi dibungkus logic x-model --}}
                        <input type="text" x-model.debounce.300ms="search" placeholder="Cari menu favorit..."
                            class="pl-10 pr-4 py-2.5 rounded-xl border-slate-200 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none w-full bg-slate-50 focus:bg-white transition-all shadow-sm">
                    </div>

                    {{-- Dropdown Filter --}}
                    <div class="relative" @click.outside="filterOpen = false">
                        <x-ui.button @click="filterOpen = !filterOpen" variant="ghost" size="icon"
                            x-bind:class="category !== 'Semua' ? 'bg-[#FFC107] text-slate-900' :
                                'bg-slate-100 text-slate-500 hover:text-primary'"
                            class="rounded-lg transition-colors border border-transparent w-9 h-9">
                            <x-icons.filter class="w-5 h-5" />
                        </x-ui.button>

                        {{-- Dropdown Menu --}}
                        <div x-show="filterOpen" x-transition.origin.top.right x-cloak
                            class="absolute right-0 top-full mt-2 w-48 bg-white rounded-xl shadow-xl border border-slate-100 z-50 overflow-hidden py-1">

                            <div
                                class="px-4 py-2 bg-slate-50 border-b border-slate-100 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                                Filter Kategori
                            </div>

                            <template x-for="cat in ['Semua', 'Makanan', 'Minuman']">
                                <x-ui.button @click="setCategory(cat)" variant="ghost"
                                    class="w-full text-left px-4 py-2 text-sm hover:bg-slate-50 flex justify-between items-center rounded-none"
                                    x-bind:class="category === cat ? 'text-primary font-bold' : 'text-slate-600'">
                                    <span x-text="cat"></span>
                                    <span x-show="category === cat" class="text-primary">✓</span>
                                </x-ui.button>
                            </template>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Product Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                <template x-for="product in displayedProducts" :key="product.id">
                    {{-- Card Produk --}}
                    <div
                        class="bg-white rounded-2xl border border-slate-100 overflow-hidden hover:shadow-[0_8px_30px_rgb(0,0,0,0.12)] transition-all duration-300 group flex flex-col">

                        {{-- Image Container --}}
                        <div class="aspect-[4/3] sm:aspect-square bg-slate-100 relative overflow-hidden shrink-0">
                            <img :src="product.image"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                                :alt="product.name">

                            {{-- Badge Kategori Produk --}}
                            <span
                                class="absolute top-3 left-3 px-2.5 py-1.5 bg-white/90 backdrop-blur-md rounded-lg text-[10px] font-bold uppercase tracking-wider text-slate-800 shadow-sm"
                                x-text="product.category"></span>
                        </div>

                        {{-- Content --}}
                        <div class="p-5 flex flex-col flex-1 justify-between">
                            <div>
                                <h3 class="font-bold text-slate-900 text-lg line-clamp-1 group-hover:text-primary transition-colors mb-1"
                                    x-text="product.name"></h3>
                                <p class="text-sm text-slate-500 line-clamp-2" x-text="product.variant"></p>
                            </div>

                            <div class="flex items-center justify-between mt-4 pt-4 border-t border-slate-100">
                                <div>
                                    <p class="text-[12px] text-slate-400 font-bold tracking-wider mb-0.5">Harga</p>
                                    <span class="font-extrabold text-slate-900 text-xl" x-text="product.price"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>

                {{-- Empty State --}}
                <div x-show="filteredProducts.length === 0" x-cloak class="col-span-full text-center py-12">
                    <div class="bg-slate-50 rounded-2xl p-8 border border-slate-100 inline-block">
                        <p class="text-slate-600 mb-2">Produk "<span x-text="search" class="font-bold"></span>" tidak
                            ditemukan.</p>
                        <x-ui.button @click="resetAll" variant="link"
                            class="text-primary font-bold hover:underline p-0 h-auto">Reset Semua
                            Filter</x-ui.button>
                    </div>
                </div>
            </div>

            {{-- Load More Button --}}
            <div class="mt-8 text-center" x-show="hasMore" x-cloak>
                <x-ui.button @click="loadMore" variant="outline"
                    class="group flex items-center gap-2 mx-auto px-6 py-2.5 rounded-full border-slate-200 text-slate-600 font-bold text-sm hover:border-primary hover:text-primary hover:bg-slate-50 transition-all duration-300 shadow-sm hover:shadow-md">
                    <span>Lihat Lebih Banyak</span>
                    <x-icons.chevron-down class="w-5 h-5 group-hover:translate-y-0.5 transition-transform" />
                </x-ui.button>
            </div>
        </div>

    </main>

    {{-- Script AlpineJS --}}
    @push('scripts')
        <script>
            function productLogic() {
                return {
                    search: '',
                    category: 'Semua',
                    filterOpen: false,
                    limit: 4,
                    itemsPerLoad: 4,
                    products: [{
                            id: 1,
                            name: 'Cilor Maklor',
                            category: 'Makanan',
                            variant: 'Pedas / Sedang / Tidak Pedas',
                            price: 'Rp 5.000',
                            image: 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&w=300&q=80'
                        },
                        {
                            id: 2,
                            name: 'Es Teh Manis',
                            category: 'Minuman',
                            variant: 'Dingin / Hangat',
                            price: 'Rp 3.000',
                            image: 'https://images.unsplash.com/photo-1563805042-7684c019e1cb?auto=format&fit=crop&w=300&q=80'
                        },
                        {
                            id: 3,
                            name: 'Nasi Goreng Spesial',
                            category: 'Makanan',
                            variant: 'Pedas / Sedang',
                            price: 'Rp 15.000',
                            image: 'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?auto=format&fit=crop&w=300&q=80'
                        },
                        {
                            id: 4,
                            name: 'Pizza Mini',
                            category: 'Makanan',
                            variant: 'Sosis / Keju',
                            price: 'Rp 10.000',
                            image: 'https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?auto=format&fit=crop&w=300&q=80'
                        },
                        {
                            id: 5,
                            name: 'Kopi Susu Gula Aren',
                            category: 'Minuman',
                            variant: 'Dingin',
                            price: 'Rp 12.000',
                            image: 'https://images.unsplash.com/photo-1497935586351-b67a49e012bf?auto=format&fit=crop&w=300&q=80'
                        },
                        {
                            id: 6,
                            name: 'Seblak Ceker',
                            category: 'Makanan',
                            variant: 'Level 1-5',
                            price: 'Rp 12.000',
                            image: 'https://images.unsplash.com/photo-1565958011703-44f9829ba187?auto=format&fit=crop&w=300&q=80'
                        },
                        {
                            id: 7,
                            name: 'Thai Tea',
                            category: 'Minuman',
                            variant: 'Large Cup',
                            price: 'Rp 8.000',
                            image: 'https://images.unsplash.com/photo-1556679343-c7306c1976bc?auto=format&fit=crop&w=300&q=80'
                        },
                        {
                            id: 8,
                            name: 'Dimsum Ayam',
                            category: 'Makanan',
                            variant: 'Isi 4 Pcs',
                            price: 'Rp 13.000',
                            image: 'https://images.unsplash.com/photo-1496116218417-1a781b1c423c?auto=format&fit=crop&w=300&q=80'
                        },
                        {
                            id: 9,
                            name: 'Roti Bakar Coklat',
                            category: 'Makanan',
                            variant: 'Keju / Coklat',
                            price: 'Rp 10.000',
                            image: 'https://images.unsplash.com/photo-1586985289688-ca3cf47d3e6e?auto=format&fit=crop&w=300&q=80'
                        },
                        {
                            id: 10,
                            name: 'Jus Alpukat',
                            category: 'Minuman',
                            variant: 'Tanpa Gula',
                            price: 'Rp 10.000',
                            image: 'https://images.unsplash.com/photo-1601039641847-7857b994d704?auto=format&fit=crop&w=300&q=80'
                        },
                    ],

                    setCategory(cat) {
                        this.category = cat;
                        this.filterOpen = false;
                        this.limit = this.itemsPerLoad;
                    },

                    resetAll() {
                        this.search = '';
                        this.category = 'Semua';
                        this.limit = this.itemsPerLoad;
                    },

                    get filteredProducts() {
                        const q = this.search.toLowerCase();
                        return this.products.filter(item => {
                            const matchSearch = item.name.toLowerCase().includes(q) ||
                                item.category.toLowerCase().includes(q) ||
                                item.variant.toLowerCase().includes(q);
                            const matchCategory = this.category === 'Semua' || item.category === this.category;
                            return matchSearch && matchCategory;
                        });
                    },

                    get displayedProducts() {
                        return this.filteredProducts.slice(0, this.limit);
                    },

                    get hasMore() {
                        return this.limit < this.filteredProducts.length;
                    },

                    loadMore() {
                        this.limit += this.itemsPerLoad;
                    },

                    init() {
                        this.$watch('search', () => {
                            this.limit = this.itemsPerLoad;
                        });
                    }
                }
            }
        </script>
    @endpush

</x-layouts.app>
