
import { database } from '../firebase';
import { ref, onValue } from "firebase/database";

// Listen specifically for Shop updates
const shopsRef = ref(database, 'channels/shops');

onValue(shopsRef, (snapshot) => {
    const data = snapshot.val();
    if (data) {
        // Dispatch custom event to window so Blade/Alpine can react
        // Debouncing is handled in the listener if needed, or we can just dispatch immediately
        window.dispatchEvent(new CustomEvent('map-data-updated', {
            detail: { timestamp: Date.now() }
        }));

        console.log("Firebase: Map data update signal received.");
    }
});
