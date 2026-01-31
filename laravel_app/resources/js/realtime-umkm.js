
import { ref, onValue } from "firebase/database";
import { database } from "./firebase";

document.addEventListener('DOMContentLoaded', () => {

    // Listen for Content Updates (e.g. Hero title/subtitle)
    const contentRef = ref(database, 'channels/public-content');

    onValue(contentRef, (snapshot) => {
        const data = snapshot.val();
        if (!data) return;

        if (!data) return;

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
                    currentHero.innerHTML = newHero.innerHTML;

                    // Re-initialize Alpine on the new DOM
                    setTimeout(() => {
                        if (window.Alpine) {
                            // Assuming the parent or children need re-init. 
                            // Since we replaced innerHTML, we might need to init children.
                            // But initTree on the container is safest.
                            window.Alpine.initTree(currentHero);
                        }
                    }, 50);
                }
            })
            .catch(err => { });
    });
});

