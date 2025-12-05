<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Toko - UMKM Sasuma</title>
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
                    }
                }
            }
        }
    </script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>

<body class="bg-white font-sans text-slate-800 antialiased">

    <x-navigation />

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-32">

        {{-- Store Header --}}
        <div class="bg-[#FEFBE8] rounded-3xl p-6 md:p-10 mb-12 relative overflow-hidden">
            <div class="flex flex-col md:flex-row gap-8 items-start">
                
                {{-- Store Image --}}
                <div class="w-32 h-32 md:w-48 md:h-48 rounded-full overflow-hidden border-4 border-white shadow-lg shrink-0 mx-auto md:mx-0">
                    <img src="https://images.unsplash.com/photo-1555939594-58d7cb561ad1?auto=format&fit=crop&w=300&q=80" 
                        class="w-full h-full object-cover" alt="Toko">
                </div>

                {{-- Store Info --}}
                <div class="flex-1 space-y-4 w-full">
                    <div>
                        <div class="text-slate-600 font-medium mb-1">Tebing</div>
                        <div class="flex flex-wrap items-center gap-3 mb-2">
                            <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900">Tebing UMKM</h1>
                            <span class="px-3 py-1 rounded-md bg-[#FFC107] text-slate-900 text-xs font-bold uppercase">Kuliner</span>
                        </div>
                        <div class="flex items-start gap-2 text-slate-600 text-sm">
                            <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span>Jl. Podang 14 No 113 RT 03/12 blok H2 BSI 2 pengasinan sawangan Depok</span>
                        </div>
                    </div>

                    <div class="border-t border-slate-200/60 pt-3">
                        <h3 class="font-bold text-slate-900 text-base mb-1">Omset Penjualan</h3>
                        <p class="text-slate-600 text-sm">Rp. 10.000 - Rp. 10.000.000</p>
                    </div>

                    <div class="border-t border-slate-200/60 pt-3">
                        <h3 class="font-bold text-slate-900 text-base mb-1">Izin Usaha</h3>
                        <p class="text-slate-600 text-sm">SIB, Sertifikat Halal</p>
                    </div>

                    {{-- Socials --}}
                    <div class="border-t border-slate-200/60 pt-3 grid grid-cols-1 sm:grid-cols-2 gap-y-2 gap-x-4">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-pink-600" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                            <span class="text-sm text-slate-600">@tebingtsaaa</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.791-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                            <span class="text-sm text-slate-600">tebingtsaaa</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-black" fill="currentColor" viewBox="0 0 24 24"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/></svg>
                            <span class="text-sm text-slate-600">tebingtsaaa</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                            <span class="text-sm text-slate-600">google.com</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg></a>
                        </div>
                    </div>

                    {{-- Description --}}
                    <div class="border-t border-slate-200/60 pt-3">
                         <p class="text-slate-600 text-sm leading-relaxed">
                            UMKM kuliner kami menghadirkan jajanan kekinian favorit anak muda, yaitu Cilor (Aci Telor) dan Maklor (Makaroni Telor). Dibuat dari bahan pilihan dengan cita rasa gurih, pedas, dan nikmat, jajanan ini cocok dinikmati kapan saja, baik sebagai camilan santai maupun teman berkumpul bersama teman.
                        </p>
                    </div>

                    {{-- Action Button --}}
                    <div class="pt-2">
                        <button class="bg-[#FFC107] hover:bg-yellow-400 text-slate-900 font-bold px-6 py-2.5 rounded-lg shadow-sm transition-all active:scale-95 text-sm">
                            Lihat Lokasi
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Product Section with Alpine Data --}}
        <div x-data="productLogic()">
            
            {{-- Header Produk (Judul & Filter) --}}
            <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-6 gap-4">
                
                {{-- Judul Kategori (SESUAI PERMINTAAN) --}}
                <div>
                    <h2 class="text-xl font-bold text-slate-900">Daftar Produk</h2>
                    <p class="text-sm text-slate-500 mt-1">
                        Menampilkan: <span class="font-bold text-primary" x-text="category === 'Semua' ? 'Semua Kategori' : category"></span>
                    </p>
                </div>
                
                {{-- Filter & Search --}}
                <div class="flex gap-2">
                    <div class="relative">
                        <input type="text" 
                               x-model.debounce.300ms="search" 
                               placeholder="Cari produk" 
                               class="px-4 py-2 rounded-lg border border-slate-200 text-sm focus:ring-2 focus:ring-primary/20 outline-none w-40 md:w-64 bg-slate-50 focus:bg-white transition-all">
                    </div>

                    {{-- Dropdown Filter Button Wrapper --}}
                    <div class="relative" @click.outside="filterOpen = false">
                        <button @click="filterOpen = !filterOpen" 
                                :class="category !== 'Semua' ? 'bg-[#FFC107] text-slate-900' : 'bg-slate-100 text-slate-500 hover:text-primary'"
                                class="p-2 rounded-lg transition-colors border border-transparent">
                            
                            {{-- Icon Filter (Fixed) --}}
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                        </button>

                        {{-- Dropdown Menu --}}
                        <div x-show="filterOpen" 
                             x-transition.origin.top.right
                             x-cloak
                             class="absolute right-0 top-full mt-2 w-48 bg-white rounded-xl shadow-xl border border-slate-100 z-50 overflow-hidden py-1">
                            <div class="px-4 py-2 bg-slate-50 border-b border-slate-100 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                                Filter Kategori
                            </div>
                            <button @click="setCategory('Semua')" class="w-full text-left px-4 py-2 text-sm hover:bg-slate-50 flex justify-between items-center" :class="category === 'Semua' ? 'text-primary font-bold' : 'text-slate-600'">
                                Semua
                                <span x-show="category === 'Semua'" class="text-primary">✓</span>
                            </button>
                            <button @click="setCategory('Makanan')" class="w-full text-left px-4 py-2 text-sm hover:bg-slate-50 flex justify-between items-center" :class="category === 'Makanan' ? 'text-primary font-bold' : 'text-slate-600'">
                                Makanan
                                <span x-show="category === 'Makanan'" class="text-primary">✓</span>
                            </button>
                            <button @click="setCategory('Minuman')" class="w-full text-left px-4 py-2 text-sm hover:bg-slate-50 flex justify-between items-center" :class="category === 'Minuman' ? 'text-primary font-bold' : 'text-slate-600'">
                                Minuman
                                <span x-show="category === 'Minuman'" class="text-primary">✓</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Product Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                <template x-for="product in displayedProducts" :key="product.id">
                    <div class="bg-white rounded-2xl border border-slate-100 p-3 hover:shadow-xl hover:shadow-slate-200/50 transition-all duration-300 group">
                        <div class="aspect-square rounded-xl bg-slate-100 overflow-hidden relative mb-3">
                            <img :src="product.image" 
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" :alt="product.name">
                            <span class="absolute top-2 left-2 px-2 py-1 bg-white/90 backdrop-blur-sm rounded-md text-[10px] font-bold uppercase text-slate-700" x-text="product.category"></span>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-900 line-clamp-1 group-hover:text-primary transition-colors" x-text="product.name"></h3>
                            <p class="text-xs text-slate-500 mb-2" x-text="product.variant"></p>
                            <div class="flex items-center justify-between">
                                <span class="font-extrabold text-slate-900" x-text="product.price"></span>
                            </div>
                        </div>
                    </div>
                </template>

            </div>

            {{-- Load More Button Logic --}}
            <div class="mt-12 flex justify-center" x-show="hasMore">
                <button @click="loadMore" class="group flex items-center gap-2 px-6 py-3 bg-white border border-slate-200 rounded-full shadow-sm hover:shadow-md hover:border-primary/30 transition-all duration-300">
                    <span class="text-sm font-bold text-slate-600 group-hover:text-primary">Muat Lebih Banyak</span>
                    <svg class="w-5 h-5 text-slate-400 group-hover:text-primary transition-colors animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                    </svg>
                </button>
            </div>
            
            {{-- Pesan jika pencarian tidak ditemukan --}}
            <div x-show="displayedProducts.length === 0" class="mt-12 text-center text-slate-500 text-sm" x-cloak>
                <div class="mb-2">🤔</div>
                Produk "<span x-text="search" class="font-bold"></span>" tidak ditemukan.
                <div class="mt-2">
                     <button @click="resetAll" class="text-primary font-bold hover:underline">Reset Semua Filter</button>
                </div>
            </div>
        </div>

    </main>

    <script>
        function productLogic() {
            return {
                search: '',
                category: 'Semua', 
                filterOpen: false, 
                limit: 4, 
                itemsPerLoad: 4, 
                products: [
                    { id: 1, name: 'Cilor Maklor', category: 'Makanan', variant: 'Pedas / Sedang / Tidak Pedas', price: 'Rp 5.000', image: 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&w=300&q=80' },
                    { id: 2, name: 'Es Teh Manis', category: 'Minuman', variant: 'Dingin / Hangat', price: 'Rp 3.000', image: 'https://images.unsplash.com/photo-1563805042-7684c019e1cb?auto=format&fit=crop&w=300&q=80' },
                    { id: 3, name: 'Nasi Goreng Spesial', category: 'Makanan', variant: 'Pedas / Sedang', price: 'Rp 15.000', image: 'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?auto=format&fit=crop&w=300&q=80' },
                    { id: 4, name: 'Pizza Mini', category: 'Makanan', variant: 'Sosis / Keju', price: 'Rp 10.000', image: 'https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?auto=format&fit=crop&w=300&q=80' },
                    { id: 5, name: 'Kopi Susu Gula Aren', category: 'Minuman', variant: 'Dingin', price: 'Rp 12.000', image: 'https://images.unsplash.com/photo-1497935586351-b67a49e012bf?auto=format&fit=crop&w=300&q=80' },
                    { id: 6, name: 'Seblak Ceker', category: 'Makanan', variant: 'Level 1-5', price: 'Rp 12.000', image: 'https://images.unsplash.com/photo-1565958011703-44f9829ba187?auto=format&fit=crop&w=300&q=80' },
                    { id: 7, name: 'Thai Tea', category: 'Minuman', variant: 'Large Cup', price: 'Rp 8.000', image: 'https://images.unsplash.com/photo-1556679343-c7306c1976bc?auto=format&fit=crop&w=300&q=80' },
                    { id: 8, name: 'Dimsum Ayam', category: 'Makanan', variant: 'Isi 4 Pcs', price: 'Rp 13.000', image: 'https://images.unsplash.com/photo-1496116218417-1a781b1c423c?auto=format&fit=crop&w=300&q=80' },
                    { id: 9, name: 'Roti Bakar Coklat', category: 'Makanan', variant: 'Keju / Coklat', price: 'Rp 10.000', image: 'https://images.unsplash.com/photo-1586985289688-ca3cf47d3e6e?auto=format&fit=crop&w=300&q=80' },
                    { id: 10, name: 'Jus Alpukat', category: 'Minuman', variant: 'Tanpa Gula', price: 'Rp 10.000', image: 'https://images.unsplash.com/photo-1601039641847-7857b994d704?auto=format&fit=crop&w=300&q=80' },
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
</body>
</html>