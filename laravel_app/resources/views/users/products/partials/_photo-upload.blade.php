@props(['i'])

<div class="bg-white rounded-2xl p-5 shadow-[0_2px_8px_rgba(0,0,0,0.04)] hover:shadow-[0_8px_24px_rgba(0,0,0,0.06)] border border-gray-100 transition-all duration-300 group/card"
    x-data="{ photoName: null, photoPreview: null }">

    {{-- Header Card --}}
    <div class="flex items-center justify-between mb-4">
        <span
            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-700">
            Foto Utama #{{ $i }}
        </span>
    </div>

    {{-- Upload Area --}}
    <div class="relative w-full aspect-[4/3] rounded-xl overflow-hidden bg-gray-50 border-2 border-dashed border-gray-200 hover:border-brand-blue-dark hover:bg-blue-50/30 transition-all cursor-pointer group/upload"
        x-on:click="photoPreview ? openZoom(photoPreview) : $refs.photo_{{ $i }}.click()">

        <input type="file" name="photos[{{ $i }}]" class="hidden"
            x-ref="photo_{{ $i }}"
            x-on:change="
                photoName = $refs.photo_{{ $i }}.files[0].name;
                const reader = new FileReader();
                reader.onload = (e) => { photoPreview = e.target.result; };
                reader.readAsDataURL($refs.photo_{{ $i }}.files[0]);
            ">

        {{-- Placeholder --}}
        <div class="absolute inset-0 flex flex-col items-center justify-center text-slate-400 group-hover/upload:text-brand-blue-dark transition-colors p-4"
            x-show="!photoPreview">
            <div
                class="w-12 h-12 rounded-full bg-white shadow-sm flex items-center justify-center mb-3 group-hover/upload:scale-110 transition-transform">
                <x-icons.data-photo class="w-6 h-6" />
            </div>
            <span class="text-sm font-medium text-center">Klik untuk upload</span>
            <span class="text-xs text-slate-300 mt-1">PNG, JPG up to 2MB</span>
        </div>

        {{-- Preview --}}
        <div class="absolute inset-0 bg-cover bg-center" x-show="photoPreview"
            :style="'background-image: url(\'' + photoPreview + '\');'" style="display: none;">
            <div
                class="absolute inset-0 bg-black/0 group-hover/upload:bg-black/10 transition-colors">
            </div>
        </div>

        {{-- Edit/View Icons (Hanya muncul saat hover di desktop) --}}
        <div class="absolute top-2 right-2 flex gap-2" x-show="photoPreview" style="display: none;">
            {{-- Zoom Button --}}
            <button type="button"
                class="p-2 bg-white/90 backdrop-blur-sm rounded-full shadow-sm text-slate-600 hover:text-blue-600 hover:scale-105 transition-all w-8 h-8 flex items-center justify-center"
                @click.stop="openZoom(photoPreview)" title="Lihat Foto">
                <x-icons.ui-eye class="w-3.5 h-3.5" />
            </button>

            {{-- Change Button --}}
            <button type="button"
                class="p-2 bg-white/90 backdrop-blur-sm rounded-full shadow-sm text-slate-600 hover:text-brand-blue-dark hover:scale-105 transition-all w-8 h-8 flex items-center justify-center"
                @click.stop="$refs.photo_{{ $i }}.click()" title="Ganti Foto">
                <x-icons.ui-edit class="w-3.5 h-3.5" />
            </button>

            {{-- Delete Button --}}
            <button type="button"
                class="p-2 bg-white/90 backdrop-blur-sm rounded-full shadow-sm text-slate-600 hover:text-red-600 hover:scale-105 transition-all w-8 h-8 flex items-center justify-center"
                @click.stop="photoPreview = null; photoName = null; $refs.photo_{{ $i }}.value = ''"
                title="Hapus Foto">
                <x-icons.ui-delete class="w-3.5 h-3.5" />
            </button>
        </div>
    </div>

    {{-- Order Input --}}
    <div class="flex items-center gap-3 mt-4 pt-4 border-t border-gray-50">
        <label class="text-sm font-medium text-slate-500">Urutan Tampil:</label>
        <div class="flex-1">
            <x-ui.input variant="default" size="sm" type="number"
                name="order[{{ $i }}]" value="{{ $i }}" min="1"
                max="5"
                class="w-full max-w-[80px] text-center font-bold text-slate-700 !py-1.5" />
        </div>
    </div>

</div>
