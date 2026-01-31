
import { database } from '../firebase';
import { ref, onValue } from "firebase/database";

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

            // Firebase Listener Pattern
            const shopsRef = ref(database, 'channels/shops');
            onValue(shopsRef, (snapshot) => {
                const data = snapshot.val();
                if (data) {
                    // Debounce or simple delay
                    setTimeout(() => {
                        this.refreshData();
                    }, 1000);
                }
            });
        },

        refreshData() {
            // Build current URL params
            const params = new URLSearchParams(window.location.search);

            // Convert URLSearchParams to object to merge with extra params
            const currentParams = {};
            for (const [key, value] of params.entries()) {
                currentParams[key] = value;
            }

            window.axios.get('/umkm', {
                params: { ...currentParams, json: true },
                headers: { 'Accept': 'application/json' }
            })
                .then(response => {
                    let newItems = [];
                    // PublicController returns JSON array of items on `wantsJson()` or `json=true`
                    if (Array.isArray(response.data)) {
                        newItems = response.data;
                    } else if (response.data.data && Array.isArray(response.data.data)) {
                        newItems = response.data.data;
                    } else {
                        return;
                    }

                    this.items = newItems;
                })
                .catch(error => { });
        }
    }
}
