<div class="hidden md:flex justify-center gap-4 items-center pb-0 pt-2 mt-auto">
    <x-ui.button variant="circle-white" size="icon-lg" @click="prevPage()"
        x-bind:disabled="currentPage == 1">
        <x-icons.ui-arrow-down class="w-6 h-6 -rotate-180" />
    </x-ui.button>
    <span class="text-white text-xs font-bold tracking-wider"><span x-text="currentPage"></span> /
        <span x-text="totalPages"></span></span>
    <x-ui.button variant="circle-white" size="icon-lg" @click="nextPage()"
        x-bind:disabled="currentPage === totalPages">
        <x-icons.ui-arrow-down class="w-6 h-6" />
    </x-ui.button>
</div>
