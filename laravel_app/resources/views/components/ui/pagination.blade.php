<div class="mt-12 flex items-center justify-center gap-2" x-show="totalPages > 1" x-cloak>

    <button @click="prevPage" :disabled="currentPage === 1"
        class="w-10 h-10 flex items-center justify-center rounded-lg border border-gray-300 text-slate-600 hover:bg-gray-50 hover:text-primary disabled:opacity-50 disabled:cursor-not-allowed transition-all bg-white shadow-sm">
        <x-icons.ui-chevron-left class="w-5 h-5" stroke-width="2.5" />
    </button>

    <template x-for="(page, index) in paginationNumbers" :key="index">
        <button x-show="page !== '...'" @click="goToPage(page)"
            :class="currentPage === page ? 'bg-brand-blue text-white shadow-md' :
                'bg-white border-gray-300 text-slate-600 hover:bg-gray-50 hover:border-gray-400'"
            class="w-10 h-10 flex items-center justify-center rounded-lg border text-sm font-bold transition-all"
            x-text="page">
        </button>

        <span x-show="page === '...'"
            class="w-10 h-10 flex items-end justify-center text-slate-400 font-bold tracking-widest pb-2">
            ...
        </span>
    </template>

    <button @click="nextPage" :disabled="currentPage === totalPages"
        class="w-10 h-10 flex items-center justify-center rounded-lg border border-gray-300 text-slate-600 hover:bg-gray-50 hover:text-primary disabled:opacity-50 disabled:cursor-not-allowed transition-all bg-white shadow-sm">
        <x-icons.ui-chevron-right class="w-5 h-5" stroke-width="2.5" />
    </button>

</div>
