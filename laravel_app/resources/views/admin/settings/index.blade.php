<x-layouts.admin :title="translate('Setting Admin - UMKM Sasuma Admin')" :header-title="translate('Pengaturan')" :header-subtitle="translate('Kelola Akun & Sistem')">
    <div class="max-w-5xl mx-auto">
        @include('admin.settings.sections.header')
        @include('admin.settings.sections.alert')
        
        @include('admin.settings.sections.profile-form')

        <div class="border-t border-slate-200 my-12"></div>

        @include('admin.settings.sections.password-form')
    </div>
</x-layouts.admin>
