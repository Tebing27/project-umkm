@props(['image', 'category', 'name', 'price', 'initialActive' => true])

<div x-data="{ active: {{ $initialActive ? 'true' : 'false' }} }"
    x-show="activeTab === 'semua' || (activeTab === 'aktif' && active) || (activeTab === 'tidak_aktif' && !active)"
    :class="{ 'opacity-75': !active }"
    class="bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-slate-200/50 transition-all duration-300 group overflow-hidden flex flex-col hover:-translate-y-1">
    <div class="relative aspect-[4/3] bg-slate-100 overflow-hidden">
        <img src="{{ $image }}"
            :class="{ 'grayscale': !active }"
            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
            alt="{{ $name }}">

        {{-- Badge --}}
        <span
            class="absolute top-3 left-3 backdrop-blur-md px-3 py-1 rounded-full text-[10px] font-bold shadow-sm ring-1 ring-white/50 uppercase tracking-wide"
            :class="active ? 'bg-white/90 text-slate-700' : 'bg-slate-200/90 text-slate-500'">
            {{ $category }}
        </span>
    </div>

    <div class="p-5 flex-1 flex flex-col">
        <div class="flex justify-between items-start mb-2 gap-2">
            <h3 class="font-bold text-slate-800 line-clamp-1 text-lg transition-colors">
                {{ $name }}</h3>
            <span
                class="shrink-0 inline-flex items-center gap-1 text-[10px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wide border"
                :class="active ? 'text-green-700 bg-green-100 border-green-200' :
                    'text-slate-500 bg-slate-100 border-slate-200'"
                x-text="active ? 'Aktif' : 'Tidak Aktif'">
            </span>
        </div>
        <p class="text-slate-900 font-extrabold text-lg mb-4">{{ $price }}</p>

        <div class="mt-auto pt-4 border-t border-slate-50 space-y-3">

            {{-- Status Toggle --}}
            <div class="flex items-center justify-between text-xs text-slate-500 font-semibold">
                <div class="flex items-center gap-2">
                    <span class="text-slate-400">Status:</span>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" value="" class="sr-only peer" x-model="active">
                        <div
                            class="w-9 h-5 bg-slate-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-[#004a85]/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-green-500">
                        </div>
                    </label>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="grid grid-cols-2 gap-2">
                <button @click="editProductModal = true"
                    class="flex items-center justify-center gap-2 px-3 py-2 bg-slate-100 text-slate-600 rounded-lg text-sm font-bold hover:bg-[#004a85] hover:text-white transition-all duration-200 group/btn">
                    <x-icons.pencil class="w-4 h-4" />

                    Edit
                </button>
                <button
                    class="flex items-center justify-center gap-2 px-3 py-2 bg-red-50 text-red-600 rounded-lg text-sm font-bold hover:bg-red-600 hover:text-white transition-all duration-200 group/btn">
                    <x-icons.trash class="w-4 h-4" />
                    Hapus
                </button>
            </div>
        </div>
    </div>
</div>
