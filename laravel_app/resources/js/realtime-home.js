
// --- Section: Imports ---
import { ref, onValue } from "firebase/database";
import { database } from "./firebase";

/**
 * Initialize Realtime Updates for Home Page.
 * Listens to Firebase Realtime Database and updates DOM content dynamically.
 */
document.addEventListener('DOMContentLoaded', () => {
    // Only run on pages with these sections
    const heroSection = document.getElementById('hero-section');
    if (!heroSection) return;

    const handleUpdate = (snapshot) => {
        const data = snapshot.val();
        if (!data) return;

        const freshUrl = window.location.href + (window.location.href.includes('?') ? '&' : '?') + 't=' + new Date().getTime();
        fetch(freshUrl)
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');

                const sections = ['hero-section', 'wilayah-section', 'location'];

                sections.forEach(id => {
                    // FIX: Special handling for Map/Location to prevent destroying Leaflet instance
                    if (id === 'location') {
                        // Dispatch event specifically for map-script.blade.php to handle
                        window.dispatchEvent(new CustomEvent('map-data-updated'));
                        return; 
                    }

                    const newEl = doc.getElementById(id);
                    const oldEl = document.getElementById(id);

                    if (newEl && oldEl) {
                        // Replace the element
                        oldEl.replaceWith(newEl);

                        // --- Section: Re-initialize AlpineJS ---
                        // Menggunakan setTimeout untuk memastikan DOM sudah dirender ulang sepenuhnya oleh browser
                        // sebelum AlpineJS mencoba menginisialisasi komponen pada elemen baru.
                        setTimeout(() => {
                            if (window.Alpine) {
                                window.Alpine.initTree(document.getElementById(id));
                            }
                        }, 50);
                    }
                });
            })
            .catch(err => { });
    };

    // --- Section: Firebase Listeners ---
    
    // Listen to Public Content Channel
    const contentRef = ref(database, 'channels/public-content');
    onValue(contentRef, handleUpdate);

    // Listen to Shops Channel
    const shopsRef = ref(database, 'channels/shops');
    onValue(shopsRef, handleUpdate);
});

