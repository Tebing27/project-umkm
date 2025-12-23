<template id="umkm-popup-template">
    <div class="font-sans w-full bg-white overflow-hidden text-left pb-2">

        <div class="relative w-full h-40 md:h-56 overflow-hidden group">
            <img id="popup-img-[[ID]]" src="[[IMAGE_SRC]]" data-index="0" data-images='[[IMAGES_JSON]]'
                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" alt="[[NAME]]">

            <button onclick="window.changePopupImage([[ID]], -1)"
                class="absolute top-1/2 left-1 md:left-1 -translate-y-1/2 bg-blue-600 opacity-85 backdrop-blur-sm text-white p-2 md:p-2 rounded-full hover:bg-white/80 transition shadow-lg z-10 cursor-pointer flex items-center justify-center">
                <x-icons.chevron-left class="w-3 h-3 md:w-5 md:h-5" />
            </button>

            <button onclick="window.changePopupImage([[ID]], 1)"
                class="absolute top-1/2 right-1 md:right-1 -translate-y-1/2 bg-blue-600 opacity-85 backdrop-blur-sm text-white p-2 md:p-2  rounded-full transition shadow-lg z-10 cursor-pointer flex items-center justify-center">
                <x-icons.chevron-right class="w-3 h-3 md:w-5 md:h-5" />
            </button>

        </div>

        <div class="px-4 pt-3 pb-3 md:px-6 md:pt-5 md:pb-4">

            <div class="flex justify-between items-center gap-3">
                <h3 class="text-xl md:text-2xl font-bold text-gray-900 leading-tight line-clamp-2">
                    [[NAME]]
                </h3>
                <span
                    class="bg-[#FFC107] text-black text-[10px] md:text-sm font-medium px-2 py-1 rounded-md shrink-0 mt-1 shadow-sm tracking-wide">
                    [[BADGE]]
                </span>
            </div>

            <div class="flex items-start gap-1 mt-2 text-gray-600">
                <x-icons.location class="w-4 h-4 md:w-5 md:h-5 shrink-0 text-black mt-[12px]" />
                <p class="text-[12px] md:text-sm leading-snug font-reguler">
                    Jl. Podang 14 No 113 RT 03/12 blok H2 BSI 2 pengasinan sawangan Depok
                </p>
            </div>

            <div class="mt-1 max-h-24 md:max-h-32 overflow-y-auto custom-scrollbar pr-2">
                <p class="text-xs md:text-[16px] text-gray-700 leading-relaxed md:leading-7">
                    [[DESCRIPTION]]
                </p>
            </div>

            <div class="h-px bg-gray-200 w-full mt-3 mb-3 md:mt-5 md:mb-5"></div>

            <div class="space-y-2 md:space-y-3">
                <div class="flex items-center gap-2 md:gap-3">
                    <x-icons.money class="w-4 h-4 md:w-6 md:h-6 text-gray-800" />
                    <span class="text-xs md:text-base font-medium text-gray-900">
                        [[OMSET]]
                    </span>
                </div>
                <div class="flex items-center gap-2 md:gap-3">
                    <x-icons.document class="w-4 h-4 md:w-6 md:h-6 text-gray-800" />
                    <span class="text-xs md:text-base font-medium text-gray-900 truncate max-w-[240px] md:max-w-none">
                        [[SURAT]]
                    </span>
                </div>
            </div>

            <div
                class="grid grid-cols-2 gap-x-2 gap-y-2 md:gap-y-3 mt-4 md:mt-6 text-[10px] md:text-sm font-medium text-gray-600">

                <div
                    class="flex text-[12px] md:text-[14px] items-center gap-1.5 md:gap-2.5 overflow-hidden group cursor-pointer">
                    <a href="https://www.instagram.com/" target="_blank" rel="noopener noreferrer"
                        class="flex items-center gap-1.5 md:gap-2.5 overflow-hidden group cursor-pointer !text-black !font-normal">
                        <x-icons.instagram class="w-3.5 h-3.5 md:w-5 md:h-5 text-[#E4405F] shrink-0 transition-transform" />
                        @tebingtsaaa
                    </a>
                </div>

                <div
                    class="flex text-[12px] md:text-[14px] items-center gap-1.5 md:gap-2.5 overflow-hidden group cursor-pointer transition">
                    <a href="https://www.instagram.com/" target="_blank" rel="noopener noreferrer"
                        class="flex items-center gap-1.5 md:gap-2.5 overflow-hidden group cursor-pointer !text-black !font-normal">
                        <x-icons.globe class="w-3.5 h-3.5 md:w-5 md:h-5 text-gray-800 shrink-0 transition-transform" />
                        google.com
                    </a>
                </div>

                <div
                    class="flex text-[12px] md:text-[14px] items-center gap-1.5 md:gap-2.5 overflow-hidden group cursor-pointer transition">
                    <a href="https://www.instagram.com/" target="_blank" rel="noopener noreferrer"
                        class="flex items-center gap-1.5 md:gap-2.5 overflow-hidden group cursor-pointer !text-black !font-normal">
                        <x-icons.facebook class="w-3.5 h-3.5 md:w-5 md:h-5 text-[#1877F2] shrink-0 transition-transform" />
                        tebingtsaaa
                    </a>
                </div>

                <div
                    class="flex text-[12px] md:text-[14px] items-center gap-1.5 md:gap-2.5 overflow-hidden group cursor-pointer transition">
                    <a href="https://www.instagram.com/" target="_blank" rel="noopener noreferrer"
                        class="flex items-center gap-1.5 md:gap-2.5 overflow-hidden group cursor-pointer !text-black !font-normal">
                        <x-icons.tiktok class="w-3.5 h-3.5 md:w-5 md:h-5 text-black shrink-0 transition-transform" />
                        @tebing_tiktok
                    </a>
                </div>

                <div
                    class="col-span-2 text-[12px] md:text-[14px] flex items-center gap-1.5 md:gap-2.5 overflow-hidden group cursor-pointer transition">
                    <a href="https://www.instagram.com/" target="_blank" rel="noopener noreferrer"
                        class="flex items-center gap-1.5 md:gap-2.5 overflow-hidden group cursor-pointer !text-black !font-normal">
                        <x-icons.whatsapp class="w-3.5 h-3.5 md:w-5 md:h-5 text-[#25D366] shrink-0 transition-transform" />
                        081292209345
                    </a>
                </div>
            </div>

            <div class="mt-4 md:mt-8 mb-1 md:mb-2 flex justify-end">
                <button
                    class="bg-[#FFC107] cursor-pointer font-reguler py-2.5 px-4 md:py-2 md:px-4 rounded-lg text-xs md:text-base w-auto md:w-auto flex items-center justify-center gap-2 transform active:scale-95">
                    <span class="text-[12px] md:text-[14px]">Lihat Toko</span>
                    <x-icons.area-right class="w-4 h-4" />
                </button>
            </div>

        </div>
    </div>
</template>
