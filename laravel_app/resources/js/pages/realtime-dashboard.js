
import { database } from '../firebase';
import { ref, onValue, off } from "firebase/database";

/**
 * Initialize Real-time Verification Listener
 * 
 * @param {number} shopId - Shop ID to listen for
 * @param {function} onUpdate - Callback function when data changes
 * @returns {function} cleanup function to stop listening
 */
export function initVerificationListener(shopId, onUpdate) {
    if (!shopId) return () => { };

    // Logic: Listen to 'channels/shops' or specific shop path based on how PushToFirebase works
    // Looking at PushToFirebase: $firebaseUrl/channels/{channel}.json
    // And Channel is 'shops' or 'admin-global'.
    // If PushToFirebase pushes to /channels/shops, it likely pushes the WHOLE event payload.
    // We should check the structure. Usually simpler to listen to a specific node if possible.
    // But based on PushToFirebase: 
    // Http::put("{$firebaseUrl}/channels/{$channel}.json", $payload);
    // This overwrites the channel node with the latest event.

    const shopsChannelRef = ref(database, 'channels/shops');
    const adminChannelRef = ref(database, 'channels/admin-global');

    const handleSnapshot = (snapshot) => {
        const data = snapshot.val();
        if (data && data.shop_id && parseInt(data.shop_id) === parseInt(shopId)) {
            onUpdate(data);
        }
    };

    // Listen to shops channel
    const unsubShops = onValue(shopsChannelRef, handleSnapshot);

    return () => {
        off(shopsChannelRef, 'value', handleSnapshot);
    };
}

/**
 * Initialize Global Admin Listener
 * 
 * @param {function} onUpdate - Callback function when data changes
 * @returns {function} cleanup function to stop listening
 */
export function initGlobalListener(onUpdate) {
    const adminChannelRef = ref(database, 'channels/admin-global');

    const handleSnapshot = (snapshot) => {
        const data = snapshot.val();
        if (data) {
            onUpdate(data);
        }
    };

    const unsub = onValue(adminChannelRef, handleSnapshot);

    return () => {
        off(adminChannelRef, 'value', handleSnapshot);
    };
}
