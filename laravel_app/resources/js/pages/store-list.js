window.storeApp = function (initialData) {
    return {
        // --- STATE ---
        searchQuery: '',
        currentPage: 1,
        itemsPerPage: 6,
        selectedCategory: '',
        selectedLocation: '',
        allLabel: 'Semua',

        // --- DATA ---
        items: initialData,

        // --- LOGIC FILTER UTAMA ---
        get filteredItems() {
            return this.items.filter(item => {
                const matchSearch = item.name.toLowerCase().includes(this.searchQuery.toLowerCase());
                const matchCategory = this.selectedCategory === '' || this.selectedCategory === 'Semua' || item.category === this.selectedCategory;
                const matchLocation = this.selectedLocation === '' || this.selectedLocation === 'Semua' || item.location === this.selectedLocation;

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
            const el = document.getElementById('store-list');
            if (el) {
                el.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
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

            // Listen for Pusher events
            if (window.Echo) {
                window.Echo.channel('shops')
                    .listen('ShopUpdated', (e) => {
                        console.log('ShopUpdated event received', e);
                        this.refreshData();
                    });
            }
        },

        refreshData() {
            console.log('Refreshing data...');
            window.axios.get('/umkm')
                .then(response => {
                    if (Array.isArray(response.data)) {
                        this.items = response.data;
                    }
                })
                .catch(error => {
                    console.error('Error refreshing data:', error);
                });
        }
    }
}
