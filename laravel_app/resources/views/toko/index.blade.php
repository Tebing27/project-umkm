<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko - UMKM Sasuma</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        primary: '#004a85',
                        secondary: '#FFC107',
                        'soft-gray': '#F5F5F5',
                    }
                }
            }
        }
    </script>
    <style>
        [x-cloak] {
            display: none !important;
        }

        /* Custom Select Arrow */
        select {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.5rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            padding-right: 2.5rem;
        }
    </style>
</head>

<body>

    <x-navigation />

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-24 pb-20" x-data="storeApp()">

        <!-- Hero Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center mb-16 lg:mb-24 mt-8">

            <div class="flex flex-col justify-center pt-4">
                <h1 class="text-4xl md:text-5xl font-extrabold text-slate-900 mb-4 leading-tight">UMKM SASUMA.</h1>
                <p class="text-slate-500 mb-10 max-w-md">Temukan umkm sasuma yang ingin kamu kunjungi disetiap wilayah
                </p>

                <div class="w-full max-w-lg space-y-4">

                    <div class="relative group">
                        <input type="text" x-model="searchQuery" placeholder="Cari nama toko..."
                            class="w-full bg-soft-gray border-none rounded-xl py-4 pl-6 pr-14 text-slate-800 font-medium focus:ring-2 focus:ring-yellow-400 outline-none transition-all placeholder:text-slate-400">

                        <button
                            class="absolute right-3 top-1/2 -translate-y-1/2 bg-[#FFC107] hover:bg-yellow-400 p-2.5 rounded-full text-slate-900 transition-all shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="grid grid-cols-2 gap-4">

                        <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                            <button @click="open = !open" type="button"
                                class="w-full bg-soft-gray hover:bg-slate-100 border border-transparent hover:border-slate-200 rounded-xl py-4 pl-6 pr-4 text-left font-medium flex items-center justify-between transition-all duration-200 group">

                                <span :class="selectedCategory ? 'text-slate-900' : 'text-slate-400'"
                                    x-text="selectedCategory || 'Pilih Kategori'">
                                </span>

                                <svg class="w-5 h-5 text-slate-400 group-hover:text-primary transition-transform duration-200"
                                    :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <div x-show="open" x-transition.origin.top x-cloak
                                class="absolute top-full left-0 right-0 mt-2 bg-white rounded-xl shadow-xl shadow-slate-200/50 border border-slate-100 z-50 overflow-hidden py-1">

                                <template x-for="cat in ['Semua','Kuliner', 'Jasa', 'Retail']">
                                    <div @click="selectedCategory = (cat === 'Semua' ? '' : cat); open = false"
                                        class="px-5 py-3 text-sm font-medium text-slate-600 hover:bg-yellow-50 hover:text-yellow-700 cursor-pointer flex items-center justify-between transition-colors">
                                        <span x-text="cat"></span>
                                        <svg x-show="selectedCategory === cat" class="w-4 h-4 text-yellow-500"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                            <button @click="open = !open" type="button"
                                class="w-full bg-soft-gray hover:bg-slate-100 border border-transparent hover:border-slate-200 rounded-xl py-4 pl-6 pr-4 text-left font-medium flex items-center justify-between transition-all duration-200 group">

                                <span :class="selectedLocation ? 'text-slate-900' : 'text-slate-400'"
                                    x-text="selectedLocation || 'Pilih Wilayah'">
                                </span>

                                <svg class="w-5 h-5 text-slate-400 group-hover:text-primary transition-transform duration-200"
                                    :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <div x-show="open" x-transition.origin.top x-cloak
                                class="absolute top-full left-0 right-0 mt-2 bg-white rounded-xl shadow-xl shadow-slate-200/50 border border-slate-100 z-50 overflow-hidden py-1">

                                <template x-for="loc in ['Semua', 'Pengasinan', 'Sawangan', 'Bojongsari']">
                                    <div @click="selectedLocation = (loc === 'Semua' ? '' : loc); open = false"
                                        class="px-5 py-3 text-sm font-medium text-slate-600 hover:bg-blue-50 hover:text-blue-700 cursor-pointer flex items-center justify-between transition-colors">
                                        <span x-text="loc"></span>
                                        <svg x-show="selectedLocation === loc" class="w-4 h-4 text-blue-500"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                </template>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

            <div
                class="hidden md:block relative h-[400px] lg:h-[500px] w-full rounded-3xl overflow-hidden shadow-2xl shadow-primary/20 order-1 lg:order-2 group">
                <img src="https://images.unsplash.com/photo-1542838132-92c53300491e?q=80&w=2574&auto=format&fit=crop"
                    class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700"
                    alt="Supermarket Shelf">
                <div class="absolute inset-0 bg-gradient-to-t from-primary/60 via-transparent to-transparent"></div>

                <div class="absolute bottom-0 left-0 p-8">
                    <div class="bg-white/90 backdrop-blur-sm p-4 rounded-2xl inline-block shadow-lg">
                        <p class="text-primary font-bold text-lg">100+ UMKM</p>
                        <p class="text-slate-600 text-sm">Terdaftar di Sasuma</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Store List Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
            <h2 class="text-2xl font-bold text-slate-900">Daftar Toko</h2>
            <div class="text-sm text-slate-500">
                Menampilkan <span x-text="paginatedItems.length" class="font-bold text-slate-900"></span> dari <span
                    x-text="items.length" class="font-bold text-slate-900"></span> toko
            </div>
        </div>

        <!-- Store Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8" id="store-list">

            <template x-for="item in paginatedItems" :key="item.id">
                <div
                    class="group bg-white rounded-2xl shadow-sm border border-slate-100 transition-all duration-300 flex flex-col h-full overflow-hidden">

                    <!-- Card Header with Gradient -->
                    <div class="h-24 relative overflow-hidden group">
                        <img :src="item.image || 'https://via.placeholder.com/400x150'" alt="Cover Image"
                            class="w-full h-full object-cover absolute inset-0 transition-transform duration-500 group-hover:scale-110">

                        <div class="absolute inset-0 bg-black/20"></div>

                        <div class="absolute top-3 right-3 z-10"> <span
                                class="px-3 py-1 rounded-full bg-white/90 backdrop-blur text-xs font-bold text-slate-800 shadow-sm"
                                x-text="item.category"></span>
                        </div>
                    </div>

                    <div class="px-5 pb-6 flex-1 flex flex-col relative">
                        <!-- Logo Avatar -->
                        <div class="-mt-12 mb-3 relative">
                            <div class="w-20 h-20 rounded-full">
                                <img :src="item.image" class="w-full h-full object-cover rounded-full"
                                    :alt="item.name">
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="flex items-start justify-between mb-2">
                            <div class="flex items-center gap-1.5 text-xs font-medium text-slate-500">
                                <svg class="w-3.5 h-3.5 text-primary" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span x-text="item.location"></span>
                            </div>
                        </div>

                        <h3 class="text-xl font-bold text-slate-900 mb-2 group-hover:text-primary transition-colors line-clamp-1"
                            x-text="item.name"></h3>

                        <p class="text-sm text-slate-500 line-clamp-2 mb-6 leading-relaxed flex-1" x-text="item.desc">
                        </p>

                        <a href="/toko/detail"
                            class="w-full inline-flex justify-center items-center gap-2 px-4 py-2.5 bg-primary text-white text-sm font-semibold rounded-lg">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            </template>

        </div>

        <!-- Empty State -->
        <div x-show="paginatedItems.length === 0" class="text-center py-20" x-cloak>
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 mb-4">
                <svg class="w-8 h-8 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <h3 class="text-lg font-medium text-slate-900 mb-1">Tidak ada toko ditemukan</h3>
            <p class="text-slate-500">Coba kata kunci lain atau ubah filter pencarian Anda.</p>
        </div>

        <!-- Pagination -->
        <div class="mt-12 flex items-center justify-center gap-2" x-show="totalPages > 1" x-cloak>

            <button @click="prevPage" :disabled="currentPage === 1"
                class="w-10 h-10 flex items-center justify-center rounded-lg border border-slate-300 text-slate-600 hover:bg-slate-50 hover:text-primary disabled:opacity-50 disabled:cursor-not-allowed transition-all bg-white shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>

            <template x-for="(page, index) in paginationNumbers" :key="index">
                <button x-show="page !== '...'" @click="goToPage(page)"
                    :class="currentPage === page ? 'bg-[#FFC107] border-[#FFC107] text-white shadow-md' :
                        'bg-white border-slate-300 text-slate-600 hover:bg-slate-50 hover:border-slate-400'"
                    class="w-10 h-10 flex items-center justify-center rounded-lg border text-sm font-bold transition-all"
                    x-text="page">
                </button>

                <span x-show="page === '...'"
                    class="w-10 h-10 flex items-end justify-center text-slate-400 font-bold tracking-widest pb-2">
                    ...
                </span>
            </template>

            <button @click="nextPage" :disabled="currentPage === totalPages"
                class="w-10 h-10 flex items-center justify-center rounded-lg border border-slate-300 text-slate-600 hover:bg-slate-50 hover:text-primary disabled:opacity-50 disabled:cursor-not-allowed transition-all bg-white shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>

        </div>
    </main>

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
</body>

</html>
