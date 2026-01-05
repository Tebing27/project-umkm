<div class="absolute bottom-0 inset-x-0 p-4 bg-white/80 backdrop-blur-md border-t border-white/50 transition-all duration-300 group-hover:translate-y-full"
    :class="{ 'translate-y-full': photoPreview }">
    <h4 class="text-slate-900 font-bold text-base truncate">
        {{ $region->name }}</h4>
    <div
        class="text-base text-[#004a85] font-medium mt-0.5 flex items-center gap-1 opacity-70">
        <x-icons.map-pin class="w-3 h-3" /> <span>{{translate('Wilayah')}}</span>
    </div>
</div>
