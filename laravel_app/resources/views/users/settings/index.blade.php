<x-layouts.guest :title="translate('Pengaturan - UMKM Sasuma')" :header-title="translate('Pengaturan')" :header-subtitle="translate('Kelola akun & keamanan')">

    <div class="max-w-5xl mx-auto">
        @include('users.settings.sections.header')

        @include('users.settings.sections.form-profile')

        {{-- DIVIDER --}}
        <div class="border-t border-slate-200 my-12"></div>

        @include('users.settings.sections.form-password')
    </div>

</x-layouts.guest>
