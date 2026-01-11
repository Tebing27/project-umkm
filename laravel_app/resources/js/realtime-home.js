
document.addEventListener('DOMContentLoaded', () => {
    // Only run on pages with these sections
    const heroSection = document.getElementById('hero-section');
    if (!heroSection || !window.Echo) return;

    console.log('Real-time updates initialized.');

    const handleUpdate = (e) => {
        console.log('Real-time update received:', e);

        const freshUrl = window.location.href + (window.location.href.includes('?') ? '&' : '?') + 't=' + new Date().getTime();
        fetch(freshUrl)
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');

                const sections = ['hero-section', 'wilayah-section', 'location'];

                sections.forEach(id => {
                    const newEl = doc.getElementById(id);
                    const oldEl = document.getElementById(id);

                    if (newEl && oldEl) {
                        // Replace the element
                        oldEl.replaceWith(newEl);

                        // Re-initialize Alpine on the new element
                        // We wait a tick to ensure DOM is ready
                        setTimeout(() => {
                            if (window.Alpine) {
                                window.Alpine.initTree(document.getElementById(id));
                            }
                        }, 50);
                    }
                });
            })
            .catch(err => console.error('Failed to fetch real-time updates:', err));
    };

    // Public Content Channel
    window.Echo.channel('public-content')
        .listen('ContentUpdated', handleUpdate);

    // Shops Channel
    window.Echo.channel('shops')
        .listen('ShopUpdated', handleUpdate);
});
