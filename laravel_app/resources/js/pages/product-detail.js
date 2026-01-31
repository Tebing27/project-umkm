window.productLogic = function (initialProducts, initialCategories = [], defaultLabel = 'Semua') {
    return {
        search: '',
        category: defaultLabel,
        allLabel: defaultLabel,
        filterOpen: false,
        limit: 4,
        itemsPerLoad: 4,
        products: initialProducts,
        categories: [defaultLabel, ...initialCategories],
        isLoading: false,
        loadingMore: false,
        selectedProduct: null,
        detailModalOpen: false,

        openDetailModal(product) {
            this.selectedProduct = product;
            this.detailModalOpen = true;
        },

        setCategory(cat) {
            this.category = cat;
            this.filterOpen = false;
            this.limit = this.itemsPerLoad;
        },

        resetAll() {
            this.search = '';
            this.category = this.allLabel;
            this.limit = this.itemsPerLoad;
        },

        get filteredProducts() {
            const q = this.search.toLowerCase();
            return this.products.filter(item => {
                const matchSearch = item.name.toLowerCase().includes(q) ||
                    item.category.toLowerCase().includes(q) ||
                    item.variant.toLowerCase().includes(q);
                const matchCategory = this.category === this.allLabel || item.category === this.category;
                return matchSearch && matchCategory;
            });
        },

        get displayedProducts() {
            return this.filteredProducts.slice(0, this.limit);
        },

        get hasMore() {
            return this.limit < this.filteredProducts.length;
        },

        get page() {
            return this.limit / this.itemsPerLoad;
        },

        async fetchProducts() {
            if (this.loadingMore || !this.hasMore) return;

            this.loadingMore = true;

            // Simulate network delay for better UX (so spinner shows)
            await new Promise(resolve => setTimeout(resolve, 800));

            this.limit += this.itemsPerLoad;
            this.loadingMore = false;
        },

        init() {
            this.$watch('search', () => {
                this.limit = this.itemsPerLoad;
            });

            // Listen for global shop updates
            window.addEventListener('shop-data-updated', (e) => {
                if (e.detail) {
                    if (e.detail.products) {
                        this.products = e.detail.products;
                        // Reset limit if products change? Maybe not needed for UX stability
                    }
                    if (e.detail.categories) {
                        this.categories = [this.allLabel, ...e.detail.categories];
                    }
                }
            });
        }
    }
}
