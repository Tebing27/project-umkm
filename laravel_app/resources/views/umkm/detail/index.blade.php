<x-layouts.app :title="translate('Detail Toko - UMKM Sasuma')">
    <x-navigation />

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-32">
        @include('umkm.detail.sections.card')
        @include('umkm.detail.sections.products')
    </main>

    @push('scripts')
    @endpush
</x-layouts.app>
