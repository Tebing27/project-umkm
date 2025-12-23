<x-layouts.app title="Toko - UMKM Sasuma">

    <x-navigation />

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-24 pb-20" x-data="storeApp()">

        <!-- Hero Section -->
        <x-umkm.hero-section />

        <!-- Store List Header -->
        <x-umkm.store-list-header />

        <!-- Store Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8" id="store-list">

            <template x-for="item in paginatedItems" :key="item.id">
                <x-umkm.store-card />
            </template>

        </div>

        <!-- Empty State -->
        <div x-show="paginatedItems.length === 0" class="text-center py-20" x-cloak>
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 mb-4">
                <x-icons.magnifying-glass class="w-8 h-8 text-slate-400" />
            </div>
            <h3 class="text-lg font-medium text-slate-900 mb-1">Tidak ada toko ditemukan</h3>
            <p class="text-slate-500">Coba kata kunci lain atau ubah filter pencarian Anda.</p>
        </div>

        <!-- Pagination -->
        <x-ui.pagination />
    </main>

    @push('scripts')
        <script>
            function storeApp() {
                return {
                    // --- STATE ---
                    searchQuery: '',
                    currentPage: 1,
                    itemsPerPage: 6,
                    selectedCategory: '',
                    selectedLocation: '',

                    // --- DATA DUMMY ---
                    items: [{
                            id: 1,
                            name: 'Tebing UMKM',
                            location: 'Tebing',
                            category: 'Kuliner',
                            desc: 'Aneka Kuliner : Pecel lele, Nasi Ayam, Rendang, Keju, Bakwan.',
                            image: 'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?auto=format&fit=crop&w=200&q=80'
                        },
                        {
                            id: 2,
                            name: 'Warung Sawangan',
                            location: 'Sawangan',
                            category: 'Kuliner',
                            desc: 'Menyediakan soto betawi asli dengan kuah susu yang gurih.',
                            image: 'https://images.unsplash.com/photo-1556742049-0cfed4f7a07d?auto=format&fit=crop&w=200&q=80'
                        },
                        {
                            id: 3,
                            name: 'Jasa Service AC',
                            location: 'Pengasinan',
                            category: 'Jasa',
                            desc: 'Layanan perbaikan dan cuci AC bergaransi dan terpercaya.',
                            image: 'https://images.unsplash.com/photo-1581092918056-0c4c3acd3789?auto=format&fit=crop&w=200&q=80'
                        },
                        {
                            id: 4,
                            name: 'Toko Kelontong Berkah',
                            location: 'Bojongsari',
                            category: 'Retail',
                            desc: 'Sembako murah dan lengkap untuk kebutuhan sehari-hari warga.',
                            image: 'https://images.unsplash.com/photo-1578916171728-46686eac8d58?auto=format&fit=crop&w=200&q=80'
                        },
                        {
                            id: 5,
                            name: 'Bakso Mas Kumis',
                            location: 'Tebing',
                            category: 'Kuliner',
                            desc: 'Bakso urat super besar dengan tetelan yang melimpah ruah.',
                            image: 'https://images.unsplash.com/photo-1529692236671-f1f6cf9683ba?auto=format&fit=crop&w=200&q=80'
                        },
                        {
                            id: 6,
                            name: 'Laundry Cepat',
                            location: 'Sawangan',
                            category: 'Jasa',
                            desc: 'Cuci setrika selesai dalam 2 jam, wangi dan rapi.',
                            image: 'https://images.unsplash.com/photo-1545173168-9f1947eebb8f?auto=format&fit=crop&w=200&q=80'
                        },
                        {
                            id: 7,
                            name: 'Depot Air Minum',
                            location: 'Pengasinan',
                            category: 'Retail',
                            desc: 'Air minum isi ulang RO dan Mineral higienis.',
                            image: 'https://images.unsplash.com/photo-1541453267793-1259e06e300d?auto=format&fit=crop&w=200&q=80'
                        },
                        {
                            id: 8,
                            name: 'Sate Padang Ajo',
                            location: 'Bojongsari',
                            category: 'Kuliner',
                            desc: 'Sate padang pariaman dengan kuah kental pedas.',
                            image: 'https://images.unsplash.com/photo-1534723452862-4c874018d66d?auto=format&fit=crop&w=200&q=80'
                        },
                        {
                            id: 9,
                            name: 'Bengkel Motor Jaya',
                            location: 'Tebing',
                            category: 'Jasa',
                            desc: 'Service motor segala merk, ganti oli dan sparepart.',
                            image: 'https://images.unsplash.com/photo-1487754180451-c456f719a1fc?auto=format&fit=crop&w=200&q=80'
                        },
                        {
                            id: 10,
                            name: 'Toko Bangunan Abadi',
                            location: 'Sawangan',
                            category: 'Retail',
                            desc: 'Bahan bangunan lengkap pasir, semen, cat dan besi.',
                            image: 'https://images.unsplash.com/photo-1589939705384-5185137a7f0f?auto=format&fit=crop&w=200&q=80'
                        },
                        {
                            id: 11,
                            name: 'Salon Cantik',
                            location: 'Pengasinan',
                            category: 'Jasa',
                            desc: 'Potong rambut, creambath, dan perawatan wajah.',
                            image: 'https://images.unsplash.com/photo-1560066984-138dadb4c035?auto=format&fit=crop&w=200&q=80'
                        },
                        {
                            id: 12,
                            name: 'Martabak Manis 88',
                            location: 'Bojongsari',
                            category: 'Kuliner',
                            desc: 'Martabak manis dengan topping premium wisman.',
                            image: 'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?auto=format&fit=crop&w=200&q=80'
                        },
                    ],

                    // --- LOGIC FILTER UTAMA ---
                    // Saya pisahkan ini agar tidak ditulis ulang berkali-kali
                    get filteredItems() {
                        return this.items.filter(item => {
                            const matchSearch = item.name.toLowerCase().includes(this.searchQuery.toLowerCase());
                            const matchCategory = this.selectedCategory === '' || this.selectedCategory ===
                                'Semua' || item.category === this.selectedCategory;
                            const matchLocation = this.selectedLocation === '' || this.selectedLocation ===
                                'Semua' || item.location === this.selectedLocation;

                            return matchSearch && matchCategory && matchLocation;
                        });
                    },

                    // --- COMPUTED PROPERTIES ---

                    // 1. Data yang tampil di layar (sudah dipotong halaman)
                    get paginatedItems() {
                        const start = (this.currentPage - 1) * this.itemsPerPage;
                        const end = start + this.itemsPerPage;
                        return this.filteredItems.slice(start, end);
                    },

                    // 2. Total Halaman
                    get totalPages() {
                        return Math.ceil(this.filteredItems.length / this.itemsPerPage);
                    },

                    // 3. Logic Nomor Halaman dengan "..." (Ellipsis)
                    get paginationNumbers() {
                        const total = this.totalPages;
                        const current = this.currentPage;
                        const delta = 1; // Jumlah angka di kiri/kanan halaman aktif
                        const range = [];
                        const rangeWithDots = [];
                        let l;

                        range.push(1);
                        for (let i = current - delta; i <= current + delta; i++) {
                            if (i < total && i > 1) {
                                range.push(i);
                            }
                        }
                        if (total > 1) range.push(total);

                        for (let i of range) {
                            if (l) {
                                if (i - l === 2) rangeWithDots.push(l + 1);
                                else if (i - l !== 1) rangeWithDots.push('...');
                            }
                            rangeWithDots.push(i);
                            l = i;
                        }
                        return rangeWithDots;
                    },

                    // --- ACTIONS / NAVIGASI ---

                    nextPage() {
                        if (this.currentPage < this.totalPages) {
                            this.currentPage++;
                            this.scrollToTop();
                        }
                    },

                    prevPage() {
                        if (this.currentPage > 1) {
                            this.currentPage--;
                            this.scrollToTop();
                        }
                    },

                    goToPage(page) {
                        this.currentPage = page;
                        this.scrollToTop();
                    },

                    scrollToTop() {
                        document.getElementById('store-list').scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    },

                    // --- INIT (WATCHERS) ---
                    // Reset ke halaman 1 jika user mengubah filter
                    init() {
                        this.$watch('searchQuery', () => {
                            this.currentPage = 1;
                        });
                        this.$watch('selectedCategory', () => {
                            this.currentPage = 1;
                        });
                        this.$watch('selectedLocation', () => {
                            this.currentPage = 1;
                        });
                    }
                }
            }
        </script>
    @endpush
</x-layouts.app>
