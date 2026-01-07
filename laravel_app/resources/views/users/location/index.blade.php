<x-layouts.guest :title="translate('Lokasi UMKM - UMKM Sasuma')" :header-title="translate('Lokasi UMKM')" :header-subtitle="translate('Tambahkan lokasi baru')">

    <div x-data="locationHybrid()" x-init="init()" class="relative">
        @include('users.location.partials.header')
        @include('users.location.partials.alerts')

        {{-- 3. FORM UTAMA --}}
        <form action="{{ url('/users/lokasi/store') }}" method="POST" class="space-y-8">
            @csrf
            <input type="hidden" name="address" x-model="address">

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                @include('users.location.partials.map-preview')
                @include('users.location.partials.address-form')
            </div>
        </form>

        @include('users.location.partials.mobile-modal')
    </div>

    @push('scripts')
        @include('users.location.partials.scripts')
    @endpush
</x-layouts.guest>

