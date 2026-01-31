<x-layouts.admin :title="translate('Setting Admin - UMKM Sasuma Admin')" :header-title="translate('Pengaturan')" :header-subtitle="translate('Kelola Akun & Sistem')">
    <div class="max-w-5xl mx-auto">
        @include('admin.settings.partials.header')
        @include('admin.settings.partials.alert')
        
        @include('admin.settings.partials.profile-form')

        <div class="border-t border-gray-200 my-12"></div>

        @include('admin.settings.partials.password-form')
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (window.Echo) {
                window.Echo.channel('admin-global')
                    .listen('SettingsUpdated', (e) => {
                        
                        const notification = document.createElement('div');
                        notification.style.cssText = 'position: fixed; top: 20px; right: 20px; background: #0ea5e9; color: white; padding: 1rem; border-radius: 0.5rem; z-index: 9999; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);';
                        notification.textContent = 'Pengaturan diperbarui, memuat ulang...';
                        document.body.appendChild(notification);
                        
                        setTimeout(() => {
                            window.location.reload();
                        }, 1500);
                    });
            }
        });
    </script>
    @endpush
</x-layouts.admin>
