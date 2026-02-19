<template x-for="note in notifications" :key="note.id">
    <div x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 -translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-4"
            class="pointer-events-auto max-w-xl w-full rounded-lg shadow-lg border p-4 flex items-center gap-3 relative"
            :class="note.type === 'success' ? 'bg-green-50 text-green-700 border-green-200' : 'bg-red-50 text-red-700 border-red-200'">
        
        <div class="shrink-0">
            <template x-if="note.type === 'success'">
                <x-icons.status-info class="w-6 h-6 text-green-500" />
            </template>
            <template x-if="note.type === 'error'">
                <x-icons.status-info class="w-6 h-6 text-red-500" />
            </template>
        </div>
        
        <div class="flex-1 text-sm font-medium">
            <span x-text="note.message"></span>
        </div>

        <button @click="remove(note.id)" 
                class="shrink-0 p-1 rounded-md hover:bg-black/5 transition-colors"
                :class="note.type === 'success' ? 'text-green-500' : 'text-red-500'">
            <span class="sr-only">Close</span>
            <x-icons.ui-close class="w-4 h-4" />
        </button>
    </div>
</template>
