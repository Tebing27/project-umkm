<x-layouts.guest :title="translate('Pengaturan - UMKM Sasuma')" :header-title="translate('Pengaturan')" :header-subtitle="translate('Kelola akun & keamanan')">

    <div class="max-w-5xl mx-auto">
        @include('users.settings.sections.header')
        @include('users.settings.sections.profile-form')
        
        <div class="my-8 border-t border-slate-200"></div>

        @include('users.settings.sections.password-form')
    </div>

</x-layouts.guest>
