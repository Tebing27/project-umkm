<template id="umkm-popup-template">
    <div class="font-sans w-full bg-white overflow-hidden text-left pb-2">

         <div class="relative w-full h-40 md:h-56 overflow-hidden group">
            <img id="popup-img-[[ID]]" src="[[IMAGE_SRC]]" data-index="0" data-images='[[IMAGES_JSON]]' loading="lazy"
                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" alt="[[NAME]]">

            <button onclick="window.changePopupImage([[ID]], -1)"
                class="absolute top-1/2 left-1 md:left-1 -translate-y-1/2 bg-blue-600 opacity-85 backdrop-blur-sm text-white p-1.5 md:p-1.5 rounded-full hover:bg-white/80 transition shadow-lg z-10 cursor-pointer flex items-center justify-center">
                <x-icons.ui-chevron-left class="w-3 h-3 md:w-4 md:h-4" />
            </button>

            <button onclick="window.changePopupImage([[ID]], 1)"
                class="absolute top-1/2 right-1 md:right-1 -translate-y-1/2 bg-blue-600 opacity-85 backdrop-blur-sm text-white p-1.5 md:p-1.5  rounded-full transition shadow-lg z-10 cursor-pointer flex items-center justify-center">
                <x-icons.ui-chevron-right class="w-3 h-3 md:w-4 md:h-4" />
            </button>

        </div>

        <div class="px-3 pt-2 pb-2 md:px-4 md:pt-3 md:pb-3">

            <div class="flex justify-between items-start gap-2">
                <h3 class="text-lg md:text-xl font-bold text-gray-900 leading-tight line-clamp-2">
                    [[NAME]]
                </h3>
                <span
                    class="bg-[#FFC107] text-black text-[10px] md:text-xs font-medium px-2.5 py-1 rounded-md shrink-0 shadow-sm tracking-wide">
                    [[BADGE]]
                </span>
            </div>

            <!-- Description & Social Media Removed for Compactness -->
            
            <div class="h-px bg-gray-200 w-full mt-2 mb-2 md:mt-3 md:mb-3"></div>

            <div class="space-y-1.5 md:space-y-2">
                <div class="flex items-center gap-2 md:gap-3">
                    <x-icons.data-money class="w-3.5 h-3.5 md:w-5 md:h-5 text-gray-800" />
                    <span class="text-xs md:text-sm font-medium text-gray-900">
                        [[OMSET]]
                    </span>
                </div>
                <div class="flex items-center gap-2 md:gap-3">
                    <x-icons.data-document class="w-3.5 h-3.5 md:w-5 md:h-5 text-gray-800" />
                    <span class="text-xs md:text-sm font-medium text-gray-900 truncate max-w-[200px]">
                        [[SURAT]]
                    </span>
                </div>
            </div>

            <div class="mt-3 md:mt-4 flex justify-between items-center">
                 <p class="text-[10px] text-gray-500 italic">{{ translate('Klik tombol untuk detail lengkap') }}</p>
                <button
                    class="bg-[#FFC107] cursor-pointer font-reguler py-1.5 px-3 md:py-2 md:px-4 rounded-lg text-xs md:text-sm w-auto flex items-center justify-center gap-2 transform active:scale-95 shadow-sm hover:shadow-md transition">
                    <span>{{ translate('Lihat Toko') }}</span>
                    <x-icons.ui-area-right class="w-3 h-3 md:w-4 md:h-4" />
                </button>
            </div>

        </div>
    </div>
</template>
