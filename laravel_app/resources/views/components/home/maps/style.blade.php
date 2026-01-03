<style>
    [x-cloak] {
        display: none !important;
    }

    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }

    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.3);
        border-radius: 4px;
    }

    .leaflet-div-icon {
        background: transparent;
        border: none;
    }

    /* Hide Spinners for Number Input */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Style Khusus Popup Clean */
    .custom-popup-clean .leaflet-popup-content-wrapper {
        padding: 0 !important;
        /* Hapus padding putih bawaan */
        border-radius: 12px !important;
        /* Rounded corner card */
        overflow: hidden;
    }

    .custom-popup-clean .leaflet-popup-content {
        margin: 0 !important;
        /* MOBILE FIRST: Gunakan lebar layar HP (misal 85% dari lebar layar) */
        width: 90vw !important;
        max-width: 350px !important;
        /* Batasi maksimal lebar seperti desain awal */
    }

    @media (min-width: 1024px) {
        .custom-popup-clean .leaflet-popup-content {
            max-width: 400px !important;
        }
    }

    @media (max-width: 640px) {
        .custom-popup-clean .leaflet-popup-content {
            /* Opsional: Sedikit penyesuaian margin jika perlu */
        }
    }

    /* Style Tombol Close (X) agar terlihat bagus di atas gambar */
    .custom-popup-clean .leaflet-popup-close-button {
        color: white !important;
        font-size: 24px !important;
        top: 8px !important;
        right: 8px !important;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
        /* Shadow agar terlihat di gambar terang */
        transition: all 0.2s;
    }

    .custom-popup-clean .leaflet-popup-close-button:hover {
        color: #FFC107 !important;
        /* Warna kuning saat hover */
    }

    /* Agar ujung panah popup menyatu warnanya */
    .custom-popup-clean .leaflet-popup-tip {
        background: white;
    }
</style>
