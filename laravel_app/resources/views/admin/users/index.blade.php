<x-layouts.admin :title="translate('Kelola User - UMKM Sasuma Admin')" :header-title="translate('Kelola User')" :header-subtitle="translate('Verifikasi & Data UMKM')">
    @include('admin.users.partials.header-filters')
    @include('admin.users.partials.shop-grid')

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (window.Echo) {
                window.Echo.channel('admin-global')
                    .listen('ShopUpdated', (e) => {
                        console.log('Admin Users: ShopUpdated', e);
                        
                        if (e.action === 'refresh' && e.shop_id) {
                            const cardId = `shop-card-${e.shop_id}`;
                            const cardElement = document.getElementById(cardId);
                            
                            if (cardElement) {
                                console.log(`Updating card ${cardId}...`);
                                fetch(window.location.href)
                                    .then(response => response.text())
                                    .then(html => {
                                        const parser = new DOMParser();
                                        const doc = parser.parseFromString(html, 'text/html');
                                        const newCard = doc.getElementById(cardId);
                                        if (newCard) {
                                            cardElement.replaceWith(newCard);
                                            
                                            // Optional: Visual highlight
                                            const updatedCard = document.getElementById(cardId);
                                            updatedCard.classList.add('ring-2', 'ring-blue-500');
                                            setTimeout(() => updatedCard.classList.remove('ring-2', 'ring-blue-500'), 2000);
                                        }
                                    })
                                    .catch(err => console.error('Failed to background update card:', err));

                            } else {
                                // New shop? Reload to show it.
                                window.location.reload();
                            }
                        } else {
                            window.location.reload();
                        }
                    })
                    .listen('UserUpdated', (e) => {
                         window.location.reload();
                    });
            }
        });
    </script>
    @endpush
</x-layouts.admin>
