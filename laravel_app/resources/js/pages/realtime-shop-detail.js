import { database } from '../firebase';
import { ref, onValue } from "firebase/database";

document.addEventListener('alpine:init', () => {
    Alpine.data('shopDetail', (initial) => ({
        // Shop Data
        shop: initial.shop,
        formattedOmset: initial.formattedOmset,
        licenses: initial.licenses,

        // Product Data
        products: initial.products,
        categories: [initial.defaultLabel, ...initial.categories],
        search: '',
        category: initial.defaultLabel,
        allLabel: initial.defaultLabel,
        limit: 30, // 30 is divisible by 2, 3, and 5 (perfect for all grids)
        itemsPerLoad: 30,
        isLoading: false,
        loadingMore: false,

        // UI State
        tab: 'toko',

        toStorageUrl(path) {
            if (!path) return '';
            if (path.startsWith('http')) {
                return path;
            }
            return '/storage/' + path;
        },

        toCloudinarySrcset(path) {
            if (!path) return '';
            const url = this.toStorageUrl(path);
            if (!url.includes('res.cloudinary.com')) return '';

            const widths = [320, 640, 800];
            const srcSet = [];

            widths.forEach(w => {
                let variantUrl = url;
                // Check if URL has transformations /upload/.../v...
                const match = variantUrl.match(/\/upload\/(.*?)\/v/);
                if (match) {
                    const params = match[1];
                    let newParams;
                    if (params.includes('w_')) {
                        newParams = params.replace(/w_\d+/, 'w_' + w);
                    } else {
                        newParams = params + ',w_' + w;
                    }
                    variantUrl = variantUrl.replace('/upload/' + params + '/', '/upload/' + newParams + '/');
                } else {
                    variantUrl = variantUrl.replace('/upload/', '/upload/w_' + w + '/');
                }
                srcSet.push(`${variantUrl} ${w}w`);
            });

            return srcSet.join(', ');
        },

        init() {
            this.initFirebase();

            this.$watch('search', () => {
                this.limit = this.itemsPerLoad;
            });

            const urlParams = new URLSearchParams(window.location.search);
            const searchQuery = urlParams.get('search');
            if (searchQuery) {
                this.search = searchQuery;
            }

            const tabQuery = urlParams.get('tab');
            if (tabQuery && ['toko', 'produk'].includes(tabQuery)) {
                this.tab = tabQuery;
            }

            window.addEventListener('search-update', (event) => {
                this.search = event.detail;
                if (this.search.length > 0) {
                    this.tab = 'produk';
                }
            });
        },

        initFirebase() {
            const shopRef = ref(database, `channels/shops/${this.shop.id}`);
            onValue(shopRef, (snapshot) => {
                const payload = snapshot.val();
                if (payload) {
                    clearTimeout(this._refreshTimeout);
                    this._refreshTimeout = setTimeout(() => {
                        this.refreshShop();
                    }, 500);
                }
            });
        },

        refreshShop() {
            const freshUrl = window.location.href + (window.location.href.includes('?') ? '&' :
                '?') + 't=' + new Date().getTime();

            fetch(freshUrl, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
                .then(res => res.json())
                .then(data => {
                    this.shop = data.shop;
                    this.products = data.products;
                    this.categories = [this.allLabel, ...data.categories];
                    this.formattedOmset = data.formattedOmset;
                    this.licenses = data.licenses;
                })
                .catch(err => { });
        },

        sortBy: 'newest', // newest, price_high, price_low

        // Product Logic
        get filteredProducts() {
            const q = this.search.toLowerCase();
            let items = this.products.filter(item => {
                const matchSearch = item.name.toLowerCase().includes(q) ||
                    item.category.toLowerCase().includes(q) ||
                    (item.variant && item.variant.toLowerCase().includes(q));
                const matchCategory = this.category === this.allLabel || item
                    .category === this.category;
                return matchSearch && matchCategory;
            });

            // Sorting Logic
            if (this.sortBy === 'best_seller') {
                items.sort((a, b) => {
                    // Prioritize best seller (true/1 > false/0)
                    const aBest = a.is_best_seller ? 1 : 0;
                    const bBest = b.is_best_seller ? 1 : 0;
                    if (bBest !== aBest) return bBest - aBest;
                    // Secondary sort by ID desc (newest)
                    return b.id - a.id;
                });
            } else if (this.sortBy === 'price_high') {
                items.sort((a, b) => {
                    const priceA = parseInt(a.price.replace(/[^0-9]/g, '')) || 0;
                    const priceB = parseInt(b.price.replace(/[^0-9]/g, '')) || 0;
                    return priceB - priceA;
                });
            } else if (this.sortBy === 'price_low') {
                items.sort((a, b) => {
                    const priceA = parseInt(a.price.replace(/[^0-9]/g, '')) || 0;
                    const priceB = parseInt(b.price.replace(/[^0-9]/g, '')) || 0;
                    return priceA - priceB;
                });
            } else {
                // Default newest (by ID desc as proxy)
                items.sort((a, b) => b.id - a.id);
            }

            return items;
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

        setCategory(cat) {
            this.category = cat;
            this.limit = this.itemsPerLoad;
        },

        resetAll() {
            this.search = '';
            this.category = this.allLabel;
            this.limit = this.itemsPerLoad;
        },

        async fetchProducts() {
            if (this.loadingMore || !this.hasMore) return;
            this.loadingMore = true;
            // Simulate network delay - REMOVED for instant feel (Data is in memory)
            // await new Promise(resolve => setTimeout(resolve, 500));
            this.limit += this.itemsPerLoad;
            this.loadingMore = false;
        },

        shareShop() {
            if (navigator.share) {
                navigator.share({
                    title: this.shop.name,
                    text: 'Cek toko ' + this.shop.name + ' di aplikasi kami!',
                    url: window.location.href,
                });
            } else {
                // Fallback
                alert('Link toko disalin!');
                navigator.clipboard.writeText(window.location.href);
            }
        },

        shareProduct(product) {
            let url = product.link;
            if (!url.startsWith('http')) {
                url = window.location.origin + url;
            }

            if (navigator.share) {
                navigator.share({
                    title: product.name,
                    text: 'Cek produk ' + product.name + ' di ' + this.shop.name,
                    url: url,
                });
            } else {
                alert('Link produk disalin!');
                navigator.clipboard.writeText(url);
            }
        }
    }));
});
