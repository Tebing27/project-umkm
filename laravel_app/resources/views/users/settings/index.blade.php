<x-layouts.guest :title="translate('Pengaturan - UMKM Sasuma')" :header-title="translate('Pengaturan')" :header-subtitle="translate('Kelola akun & keamanan')">
    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            let attempt = 0;
            const waitForEcho = setInterval(() => {
                attempt++;
                if (window.Echo) {
                    clearInterval(waitForEcho);
                    const userId = {{ auth()->id() }};
                    window.Echo.private(`private-user.${userId}`)
                        .listen('UserUpdated', (e) => {
                            setTimeout(() => {
                                window.location.reload(); 
                            }, 1000);
                        });
                } else if (attempt > 20) {
                    clearInterval(waitForEcho);
                }
            }, 500);
        });
    </script>
    @endpush

    <div class="max-w-5xl mx-auto">
        @include('users.settings.partials.header')
        @include('users.settings.partials.profile-form')
        
        <div class="my-8 border-t border-gray-200"></div>

        @include('users.settings.partials.password-form')
    </div>

</x-layouts.guest>

