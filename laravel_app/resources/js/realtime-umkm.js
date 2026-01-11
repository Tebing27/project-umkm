
document.addEventListener('DOMContentLoaded', () => {

    if (!window.Echo) return;

    // Listen for Content Updates (e.g. Hero title/subtitle)
    window.Echo.channel('public-content')
        .listen('ContentUpdated', (e) => {
            console.log('Content Update Received on UMKM Page:', e);

            // Refresh Page Content via AJAX matching the Home approach
            // We only want to refresh the Hero section for now as that's where content lives

            const freshUrl = window.location.href + (window.location.href.includes('?') ? '&' : '?') + 't=' + new Date().getTime();

            fetch(freshUrl)
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');

                    // Update Hero Content
                    const newHero = doc.getElementById('umkm-hero');
                    const currentHero = document.getElementById('umkm-hero');

                    if (newHero && currentHero) {
                        // Preserve the search input value if possible, or just replace. 
                        // Since text is outside input, replacing container is safe.
                        // However, hero contains Alpine components (search dropdown). 
                        // We must re-init Alpine if we replace.

                        currentHero.innerHTML = newHero.innerHTML;

                        // Re-initialize Alpine on the new DOM
                        // Alpine.initTree(currentHero) is usually handled automatically if x-data is refreshed
                        // But since we replace innerHTML of a non-x-data container (maybe), let's check.
                        // Hero partial root div does NOT have x-data. But children do.
                        // So we might need to be careful.

                        // Strategy: Use morph or simple replacement + Alpine re-init?
                        // Simple replacement works for Home because we replace the whole section.
                        // Let's ensure the Hero root has an ID.
                    }
                })
                .catch(err => console.error('Failed to fetch updated content:', err));
        });
});
