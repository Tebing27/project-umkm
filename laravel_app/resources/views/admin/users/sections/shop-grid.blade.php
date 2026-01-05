<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
    @forelse($shops as $shop)
        @include('admin.users.sections.shop-card')
    @empty
        <div class="col-span-3 text-center py-12">
            <p class="text-slate-500">{{ translate('Belum ada data UMKM.') }}</p>
        </div>
    @endforelse
</div>
