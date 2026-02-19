<div class="flex items-center justify-between mb-3">
    <div class="flex items-center gap-3">
        @if ($region->image)
            <img loading="lazy" src="{{ asset('storage/' . str_replace('\\', '/', $region->image)) }}" class="w-10 h-10 rounded-md object-cover bg-gray-100 shadow-sm border border-gray-100">
        @else
            <div class="w-10 h-10 rounded-md bg-gray-50 border border-gray-100 flex items-center justify-center text-slate-400">
                <x-icons.map-pin class="w-5 h-5" />
            </div>
        @endif
        <label class="block text-base font-bold text-slate-700">{{ $region->name }}</label>
    </div>
    
    <div class="flex flex-col items-end gap-1">
        <label class="text-[10px] uppercase font-bold text-slate-500 tracking-widest">{{ translate('Urutan') }}</label>
        <div class="relative group">
            <div class="absolute inset-y-0 left-0 flex items-center pl-2 pointer-events-none">
                <span class="text-slate-400 font-bold text-xs group-focus-within:text-brand-blue-dark transition-colors">#</span>
            </div>
            
            <input type="number" name="hero_order" value="{{ $region->hero_order }}" 
                class="w-20 h-9 pl-6 pr-2 text-right font-bold text-slate-700 bg-white border border-slate-200 rounded-lg focus:ring-1 focus:ring-brand-blue-dark focus:border-brand-blue-dark shadow-[0_2px_5px_-1px_rgba(0,0,0,0.05)] transition-colors outline-none [-moz-appearance:_textfield] [&::-webkit-inner-spin-button]:m-0 [&::-webkit-inner-spin-button]:appearance-none"
                placeholder="0">
        </div>
    </div>
</div>
