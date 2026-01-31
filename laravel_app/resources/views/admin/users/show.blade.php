<x-layouts.admin :title="translate('Detail User - UMKM Sasuma Admin')" :header-title="translate('Detail User')" :header-subtitle="translate('Verifikasi Data')">
    <div x-data="{ 
        rejectModalOpen: false,
        galleryOpen: false,
        activeImage: 0,
        images: [
            @foreach ($shop->photos as $photo)
                '{{ $photo->path }}',
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

        @include('admin.users.partials.header')

        {{-- Content Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- ================= KOLOM KIRI (Data Teks) ================= --}}
            <div class="lg:col-span-2 space-y-8">
                @include('admin.users.partials.card-owner')
                @include('admin.users.partials.card-business')
                @include('admin.users.partials.card-license')
            </div>

            {{-- ================= KOLOM KANAN (Social Media & Foto) ================= --}}
            <div class="space-y-8">
                @include('admin.users.partials.card-social')
                @include('admin.users.partials.card-photos')
            </div>
        </div>

        @include('admin.users.partials.modal-reject')
        @include('admin.users.partials.modal-gallery')

    </div>

    @push('scripts')
    <script type="module">
        import { initVerificationListener } from "{{ Vite::asset('resources/js/pages/realtime-dashboard.js') }}";
        
        document.addEventListener('DOMContentLoaded', () => {
            const currentShopId = {{ $shop->id }};
            let isInitialLoad = true;
            
            // Listen for updates on this specific shop
            if (currentShopId) {
                initVerificationListener(currentShopId, (data) => {
                    // Ignore the very first snapshot that fires immediately on connection
                     if (isInitialLoad) {
                        isInitialLoad = false;
                        return;
                    }

                     window.location.reload();
                });
            }
        });
    </script>
    @endpush
</x-layouts.admin>

