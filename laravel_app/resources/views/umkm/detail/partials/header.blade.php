<div>
    <p class="text-slate-500 font-medium text-base mb-1">{{translate('Pemilik')}}: <span
    class="text-slate-900 font-bold" x-text="shop.user ? shop.user.name : (shop.user_name || '{{ $shop->user->name ?? 'Nama Pemilik' }}')">{{ $shop->user->name ?? 'Nama Pemilik' }}</span></p>
    <div class="flex flex-wrap items-center gap-3 mb-2">
        <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900" x-text="shop.name">{{ $shop->name }}</h1>
        <x-ui.badge class="px-2.5 py-1.5" x-text="shop.business_type">{{ $shop->business_type }}</x-ui.badge>
    </div>

    <div class="flex items-start gap-2 text-slate-900 text-base">
        <x-icons.map-pin class="shrink-0" />
        <span x-text="shop.address">{{ $shop->address }}</span>
    </div>
</div>
