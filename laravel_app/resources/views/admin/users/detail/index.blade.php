<x-layouts.admin :title="translate('Detail User - UMKM Sasuma Admin')" :header-title="translate('Detail User')" :header-subtitle="translate('Verifikasi Data')">
    <div x-data="{ 
        rejectModalOpen: false,
        galleryOpen: false,
        activeImage: 0,
        images: [
            @foreach ($shop->photos as $photo)
                '{{ asset('storage/' . $photo->path) }}',
            @endforeach
        ],
        nextImage() {
            this.activeImage = (this.activeImage + 1) % this.images.length;
        },
        prevImage() {
            this.activeImage = (this.activeImage - 1 + this.images.length) % this.images.length;
        }
    }" 
    @keydown.escape.window="galleryOpen = false"
    @keydown.right.window="if(galleryOpen) nextImage()"
    @keydown.left.window="if(galleryOpen) prevImage()">

        @include('admin.users.detail.partials.header')

        {{-- Content Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- ================= KOLOM KIRI (Data Teks) ================= --}}
            <div class="lg:col-span-2 space-y-8">
                @include('admin.users.detail.partials.card-owner')
                @include('admin.users.detail.partials.card-business')
                @include('admin.users.detail.partials.card-license')
            </div>

            {{-- ================= KOLOM KANAN (Social Media & Foto) ================= --}}
            <div class="space-y-8">
                @include('admin.users.detail.partials.card-social')
                @include('admin.users.detail.partials.card-photos')
            </div>
        </div>

        @include('admin.users.detail.partials.modal-reject')
        @include('admin.users.detail.partials.modal-gallery')

    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            console.log("Admin User Detail: Initializing Echo listener...");
            const currentShopId = {{ $shop->id }};
            const currentUserId = {{ $shop->user_id }};
            
            let attempts = 0;
            const maxAttempts = 60; // 30 seconds
            
            const checkEcho = setInterval(() => {
                attempts++;
                if (window.Echo) {
                    clearInterval(checkEcho);
                    console.log(`Admin User Detail: Echo found after ${attempts} attempts. Subscribing to admin-global...`);
                    
                    window.Echo.channel('admin-global')
                        .listen('ShopUpdated', (e) => {
                            console.log('Admin User Detail: ShopUpdated', e);
                            if (e.shop_id && parseInt(e.shop_id) === currentShopId) {
                                console.log('Current shop updated. Reloading...');
                                window.location.reload();
                            }
                        })
                        .listen('UserUpdated', (e) => {
                            console.log('Admin User Detail: UserUpdated', e);
                             window.location.reload();
                        });
                } else if (attempts >= maxAttempts) {
                    clearInterval(checkEcho);
                    console.error('Admin User Detail: Timed out waiting for Echo.');
                }
            }, 500);
        });
    </script>
    @endpush
</x-layouts.admin>

