
import { initializeApp } from "firebase/app";
import { getDatabase } from "firebase/database";

const firebaseConfig = {
    apiKey: "AIzaSyADWlH15VXKeyUE3VJxjWS_GadafJBV2jI",
    authDomain: "umkm-93abd.firebaseapp.com",
    databaseURL: "https://umkm-93abd-default-rtdb.asia-southeast1.firebasedatabase.app",
    projectId: "umkm-93abd",
    storageBucket: "umkm-93abd.firebasestorage.app",
    messagingSenderId: "767007699982",
    appId: "1:767007699982:web:4cd8963d3223d6191b785f",
    measurementId: "G-ZJ9M5LC7VG"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const database = getDatabase(app);

export { database };
