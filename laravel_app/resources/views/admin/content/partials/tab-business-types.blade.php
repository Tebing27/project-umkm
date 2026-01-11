<script>
    // Global function definition moved here to ensure availability
    window.initBusinessTypes = function(config) {
        return {
            showModal: false,
            editing: false,
            title: config.addTitle,
            id: null,
            value: '',
            markerUrl: '',
            markerPreview: null,
            removeMarker: false,
            logoUrl: '',
            logoPreview: null,
            removeLogo: false,
            config: config,

            openAdd() {
                this.showModal = true;
                this.editing = false;
                this.title = this.config.addTitle;
                this.id = null;
                this.value = '';
                this.markerUrl = '';
                this.markerPreview = null;
                this.removeMarker = false;
                this.logoUrl = '';
                this.logoPreview = null;
                this.removeLogo = false;
                
                // Safely reset inputs if they exist
                if(this.$refs.markerInput) this.$refs.markerInput.value = '';
                if(this.$refs.logoInput) this.$refs.logoInput.value = '';
            },

            openEdit(item) {
                this.showModal = true;
                this.editing = true;
                this.title = this.config.editTitle;
                this.id = item.id;
                this.value = item.value;
                
                this.markerUrl = item.icon_url;
                this.markerPreview = item.icon_url ? item.icon_url : null;
                this.removeMarker = false;

                this.logoUrl = item.logo_url;
                this.logoPreview = item.logo_url ? item.logo_url : null;
                this.removeLogo = false;
                
                if(this.$refs.markerInput) this.$refs.markerInput.value = '';
                if(this.$refs.logoInput) this.$refs.logoInput.value = '';
            },

            handleFile(event, type) {
                const file = event.target.files[0];
                if (file) {
                    const preview = URL.createObjectURL(file);
                    if(type === 'marker') {
                        this.markerPreview = preview;
                        this.removeMarker = false;
                    } else {
                        this.logoPreview = preview;
                        this.removeLogo = false;
                    }
                }
            },

            removeImage(type) {
                if(type === 'marker') {
                    this.markerPreview = null;
                    this.removeMarker = true;
                    if(this.$refs.markerInput) this.$refs.markerInput.value = '';
                } else {
                    this.logoPreview = null;
                    this.removeLogo = true;
                    if(this.$refs.logoInput) this.$refs.logoInput.value = '';
                }
            }
        }
    };

    window.businessTypesConfig = {
        addTitle: @json(translate('Tambah Jenis Usaha')),
        editTitle: @json(translate('Edit Jenis Usaha'))
    };
</script>
<div x-data="initBusinessTypes(window.businessTypesConfig)">

    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
           {{-- Header handled by parent --}}
        </div>
        <x-ui.button @click="openAdd()" class="text-slate-900 rounded-lg font-medium">
            <x-icons.ui-plus />
            {{ translate('Tambah Jenis') }}
        </x-ui.button>
    </div>

    {{-- Grid List --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach ($businessTypes as $item)
            <div class="group relative bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden hover:shadow-lg transition-all duration-300 hover:-translate-y-1 p-5">
                
                {{-- Header --}}
                <div class="flex justify-between items-start mb-4">
                     <h3 class="font-bold text-slate-800 text-lg leading-tight">{{ $item->value }}</h3>
                     
                     {{-- Actions --}}
                     <div class="flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                        <button @click="openEdit({ 
                                id: {{ $item->id }}, 
                                value: '{{ addslashes($item->value) }}', 
                                icon_url: '{{ isset($item->icon_url) ? asset('storage/' . $item->icon_url) : '' }}',
                                logo_url: '{{ isset($item->logo_url) ? asset('storage/' . $item->logo_url) : '' }}'
                            })" 
                            class="p-1.5 bg-slate-100 rounded-lg text-slate-500 hover:text-primary hover:bg-primary/10 transition-colors"
                            title="{{ translate('Edit') }}">
                            <x-icons.ui-pencil class="w-4 h-4" />
                        </button>
                        
                        <form action="{{ route('admin.contents.destroy', $item->id) }}" method="POST" 
                            onsubmit="return confirm('{{ translate('Apakah Anda yakin ingin menghapus jenis usaha ini?') }}')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-1.5 bg-slate-100 rounded-lg text-slate-500 hover:text-red-500 hover:bg-red-50 transition-colors"
                                title="{{ translate('Hapus') }}">
                               <x-icons.ui-trash class="w-4 h-4" />
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Split View --}}
                <div class="flex items-center gap-4">
                    {{-- 1. Marker Section --}}
                    <div class="flex-1 flex flex-col items-center gap-2">
                        <div class="w-14 h-14 rounded-xl bg-blue-50/50 border border-blue-100 flex items-center justify-center text-blue-600 relative overflow-hidden group/marker">
                            @if(isset($item->icon_url) && $item->icon_url)
                                <img src="{{ asset('storage/' . $item->icon_url) }}" alt="Marker" class="w-8 h-8 object-contain drop-shadow-sm">
                            @else
                                <x-dynamic-component :component="'icons.' . $item->fallback_marker_icon" class="w-8 h-8" />
                            @endif
                        </div>
                        <span class="text-[10px] uppercase tracking-wider font-semibold text-slate-400">Peta</span>
                    </div>

                    {{-- Vertical Divider --}}
                    <div class="w-px h-12 bg-slate-100"></div>

                    {{-- 2. Logo Section --}}
                    <div class="flex-1 flex flex-col items-center gap-2">
                        <div class="w-14 h-14 rounded-xl bg-purple-50/50 border border-purple-100 flex items-center justify-center relative overflow-hidden p-2 group/logo">
                            @if(isset($item->logo_url) && $item->logo_url)
                                <img src="{{ asset('storage/' . $item->logo_url) }}" class="w-full h-full object-contain">
                            @else
                                <img src="{{ asset('images/' . $item->fallback_logo) }}" class="w-full h-full object-contain opacity-80" title="Default System Logo">
                            @endif
                        </div>
                        <span class="text-[10px] uppercase tracking-wider font-semibold text-slate-400">Toko</span>
                    </div>
                </div>

            </div>
        @endforeach
        
        @if($businessTypes->isEmpty())
             <div class="col-span-full py-12 text-center">
                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300">
                    <x-icons.content-tag class="w-8 h-8" />
                </div>
                <h3 class="text-lg font-medium text-slate-900">{{ translate('Belum ada jenis usaha') }}</h3>
                <p class="text-slate-500 mt-1">{{ translate('Tambahkan jenis usaha baru untuk memulai.') }}</p>
            </div>
        @endif
    </div>

    {{-- Modal (Optimized) --}}
    <div x-show="showModal" 
        class="fixed inset-0 z-50 flex items-center justify-center p-4" 
        style="display: none;"
        x-cloak>
        
        <div class="fixed inset-0 bg-slate-900/50 transition-opacity" 
            x-show="showModal"
            x-transition:enter="ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="showModal = false">
        </div>

        <div class="relative w-full max-w-lg bg-white rounded-2xl shadow-xl transition-all overflow-hidden"
            x-show="showModal"
            x-transition:enter="ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95">
            
            <div class="flex items-center justify-between p-5 border-b border-slate-100">
                <h3 class="text-lg font-bold text-slate-900" x-text="title"></h3>
                <button @click="showModal = false" class="text-slate-400 hover:text-slate-500">
                    <x-icons.ui-close class="w-5 h-5" />
                </button>
            </div>

            <form :action="editing ? '/admin/contents/' + id : '{{ route('admin.contents.store') }}'" method="POST" class="p-6 overflow-y-auto max-h-[80vh]" enctype="multipart/form-data">
                @csrf
                <template x-if="editing">
                    @method('PUT')
                </template>
                
                <input type="hidden" name="group" value="business_types">
                <input type="hidden" name="type" value="text">
                <input type="hidden" name="label" value="Jenis Usaha">
                <template x-if="!editing">
                    <input type="hidden" name="key" :value="'business_type_' + Math.random().toString(36).substr(2, 9)">
                </template>
                
                <div class="space-y-6">
                    <div>
                        <x-ui.input 
                            variant="soft"
                            label="{{ translate('Nama Jenis Usaha') }}" 
                            name="value" 
                            x-model="value" 
                            required 
                            placeholder="Contoh: Kuliner" 
                        />
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Field 1: Marker Peta --}}
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">{{ translate('Icon Peta (Marker)') }}</label>
                            <input type="hidden" name="remove_icon" :value="removeMarker ? 1 : 0">

                            <div class="flex flex-col gap-3">
                                <div class="w-full h-32 rounded-lg bg-slate-50 flex items-center justify-center border border-slate-200 overflow-hidden relative group">
                                    <template x-if="markerPreview">
                                        <img :src="markerPreview" class="w-12 h-12 object-contain">
                                    </template>
                                    <template x-if="!markerPreview">
                                        <div class="flex flex-col items-center gap-1 text-slate-300">
                                            <x-icons.map-pin class="w-8 h-8" />
                                            <span class="text-xs">No Marker</span>
                                        </div>
                                    </template>
                                    <template x-if="markerPreview">
                                        <div @click="removeImage('marker')" class="absolute inset-0 bg-black/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer">
                                            <x-icons.ui-trash class="w-6 h-6 text-white" />
                                        </div>
                                    </template>
                                </div>
                                <input type="file" name="icon" x-ref="markerInput" @change="handleFile($event, 'marker')" accept=".svg" class="block w-full text-xs text-slate-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20">
                                <span class="text-[10px] text-slate-400">SVG Only. Max 1MB.</span>
                            </div>
                        </div>

                        {{-- Field 2: Logo Toko Fallback --}}
                        <div>
                             <label class="block text-sm font-medium text-slate-700 mb-2">{{ translate('Default Logo Toko') }}</label>
                             <input type="hidden" name="remove_logo" :value="removeLogo ? 1 : 0">

                             <div class="flex flex-col gap-3">
                                 <div class="w-full h-32 rounded-lg bg-slate-50 flex items-center justify-center border border-slate-200 overflow-hidden relative group">
                                     <template x-if="logoPreview">
                                         <img :src="logoPreview" class="w-12 h-12 object-contain">
                                     </template>
                                     <template x-if="!logoPreview">
                                         <div class="flex flex-col items-center gap-1 text-slate-300">
                                            <x-icons.data-store class="w-8 h-8" />
                                            <span class="text-xs">No Logo</span>
                                         </div>
                                     </template>
                                     <template x-if="logoPreview">
                                         <div @click="removeImage('logo')" class="absolute inset-0 bg-black/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer">
                                             <x-icons.ui-trash class="w-6 h-6 text-white" />
                                         </div>
                                     </template>
                                 </div>
                                 <input type="file" name="logo_fallback" x-ref="logoInput" @change="handleFile($event, 'logo')" accept=".svg" class="block w-full text-xs text-slate-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20">
                                 <span class="text-[10px] text-slate-400">SVG Only. Max 1MB.</span>
                             </div>
                        </div>
                    </div>


                    <div class="flex justify-end gap-3 mt-6">
                        <x-ui.button type="button" @click="showModal = false" variant="ghost" class="rounded-lg text-slate-900">
                            {{ translate('Batal') }}
                        </x-ui.button>
                        <x-ui.button type="submit" class="rounded-lg">
                            {{ translate('Simpan') }}
                        </x-ui.button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


