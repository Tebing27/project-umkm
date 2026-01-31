import { database } from '../firebase';
import { ref, onValue } from "firebase/database";

document.addEventListener('alpine:init', () => {
    Alpine.data('productDetail', (initialProduct, shopId) => ({
        product: initialProduct,
        shopId: shopId,
        quantity: 1,
        search: '',
        expanded: false,

        activeImage: null,

        fetchProducts() {
            if (this.search.trim().length > 0) {
                window.location.href = `/umkm/${this.shopId}?tab=produk&search=` + encodeURIComponent(this.search);
            }
        },

        init() {
            // Set initial active image
            this.activeImage = this.product.image;

            window.addEventListener('search-submit', (event) => {
                this.search = event.detail;
                if (this.search.trim().length > 0) {
                    this.fetchProducts();
                }
            });

            const productRef = ref(database, `channels/products/${this.product.id}`);
            onValue(productRef, (snapshot) => {
                const payload = snapshot.val();
                if (payload && payload.data) {
                    this.product = { ...this.product, ...payload.data };
                }
            });
        },

        setActiveImage(img) {
            this.activeImage = img;
        },

        get formattedPrice() {
            return 'Rp ' + new Intl.NumberFormat('id-ID').format(this.product.price);
        },

        get hasDescription() {
            return this.product.description && this.product.description.length > 0;
        },

        get isLongDescription() {
            return this.product.description && this.product.description.length > 250;
        },

        get displayDescription() {
            return this.product.description || 'Tidak ada deskripsi.';
        },

        get imageUrl() {
            const img = this.activeImage || this.product.image;

            if (!img) {
                return 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&w=800&q=80';
            }
            if (img.startsWith('http') || img.startsWith('//') || img.startsWith('/storage/')) {
                return img;
            }
            if (img.startsWith('/')) {
                return img;
            }
            return '/storage/' + img;
        },
    }));
});
