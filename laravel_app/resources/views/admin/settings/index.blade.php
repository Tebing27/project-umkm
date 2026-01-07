<x-layouts.admin :title="translate('Setting Admin - UMKM Sasuma Admin')" :header-title="translate('Pengaturan')" :header-subtitle="translate('Kelola Akun & Sistem')">
    <div class="max-w-5xl mx-auto">
        @include('admin.settings.partials.header')
        @include('admin.settings.partials.alert')
        
        @include('admin.settings.partials.profile-form')

        <div class="border-t border-slate-200 my-12"></div>

        @include('admin.settings.partials.password-form')
    </div>
</x-layouts.admin>

