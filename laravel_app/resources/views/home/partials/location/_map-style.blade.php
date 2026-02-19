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
        color: var(--color-brand-yellow) !important;
        /* Warna kuning saat hover */
    }

    /* Agar ujung panah popup menyatu warnanya */
    .custom-popup-clean .leaflet-popup-tip {
        background: white;
    }

    /* ========== LEGEND SCROLLBAR (Desktop & Mobile) ========== */
    .map-legend {
        margin-bottom: 8px !important;
    }

    /* Desktop: Scrollbar tipis & elegan */
    .map-legend>div::-webkit-scrollbar {
        width: 5px;
    }

    .map-legend>div::-webkit-scrollbar-track {
        background: #F3F4F6;
        border-radius: 10px;
        margin: 6px 0;
    }

    .map-legend>div::-webkit-scrollbar-thumb {
        background: linear-gradient(180deg, #767c87, #767c87);
        border-radius: 10px;
        transition: background 0.3s;
    }

    .map-legend>div::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(180deg, #767c87, #767c87);
    }

    /* Firefox */
    .map-legend>div {
        scrollbar-width: thin;
        scrollbar-color: #767c87 #F3F4F6;
    }

    /* Mobile */
    @media (max-width: 767px) {
        .map-legend {
            margin-bottom: 4px !important;
            margin-left: 4px !important;
        }

        .map-legend>div {
            max-height: 180px !important;
            font-size: 11px !important;
        }

        .map-legend>div::-webkit-scrollbar {
            width: 4px;
        }

        .map-legend>div::-webkit-scrollbar-track {
            background: transparent;
        }

        .map-legend>div::-webkit-scrollbar-thumb {
            background: rgba(81, 96, 118, 0.5);
            border-radius: 10px;
        }

        .map-legend>div::-webkit-scrollbar-thumb:hover {
            background: rgba(81, 96, 118, 0.8);
        }

        /* Firefox mobile */
        .map-legend>div {
            scrollbar-width: thin;
            scrollbar-color: rgba(81, 96, 118, 0.5) transparent;
        }
    }
</style>
