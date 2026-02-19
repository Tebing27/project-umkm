<div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6" x-data="{ 
    showImage: {{ $logoShowImage && $logoShowImage->value == '1' ? 'true' : 'false' }},
    showText: {{ $logoShowText && $logoShowText->value == '1' ? 'true' : 'false' }},
    previewImage: '{{ $logoImage && $logoImage->value ? asset('storage/' . $logoImage->value) : '' }}',
    saveStatus: '', // 'saving', 'saved', 'error'
    debounceTimers: {},

    async saveSettings() {
        this.saveStatus = 'saving';
        
        try {
            // Update Show Image
            const formData1 = new FormData();
            formData1.append('_method', 'PUT');
            formData1.append('_token', document.querySelector('meta[name=\'csrf-token\']').getAttribute('content'));
            formData1.append('value', this.showImage ? '1' : '0');
            
            await fetch(`/admin/contents/{{ $logoShowImage->id ?? 0 }}`, {
                method: 'POST',
                body: formData1,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });

            // Update Show Text
            const formData2 = new FormData();
            formData2.append('_method', 'PUT');
            formData2.append('_token', document.querySelector('meta[name=\'csrf-token\']').getAttribute('content'));
            formData2.append('value', this.showText ? '1' : '0');

            await fetch(`/admin/contents/{{ $logoShowText->id ?? 0 }}`, {
                method: 'POST',
                body: formData2,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });

            this.saveStatus = 'saved';
            setTimeout(() => this.saveStatus = '', 2000);
        } catch (error) {
             this.saveStatus = 'error';
        }
    }
}">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h3 class="text-lg font-bold text-slate-900">{{ translate('Pengaturan Logo') }}</h3>
            <p class="text-slate-500 text-sm">{{ translate('Atur elemen logo yang ingin ditampilkan di navigasi.') }}</p>
        </div>
        
        {{-- Save Status Indicator --}}
        <div x-show="saveStatus" x-transition class="flex items-center gap-2 text-sm font-medium" style="display: none;">
            <template x-if="saveStatus === 'saving'">
                <span class="text-slate-500 flex items-center gap-2">
                    <x-icons.status-loading class="w-4 h-4 animate-spin" />
                    {{ translate('Menyimpan...') }}
                </span>
            </template>
            <template x-if="saveStatus === 'saved'">
                <span class="text-green-600 flex items-center gap-2">
                    <x-icons.ui-check class="w-4 h-4" />
                    {{ translate('Tersimpan') }}
                </span>
            </template>
            <template x-if="saveStatus === 'error'">
                <span class="text-red-500 flex items-center gap-2">
                    <x-icons.ui-close class="w-4 h-4" />
                    {{ translate('Gagal menyimpan') }}
                </span>
            </template>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
        
        {{-- Settings Section --}}
        <div class="space-y-8">
            
            {{-- Toggles Section --}}
    <form action="{{ route('admin.contents.update', $logoShowImage->id ?? 0) }}" method="POST" id="logoSettingsForm">
        @csrf @method('PUT')
        {{-- We will handle both toggles in one request ideally, or sequential via JS. 
             Since the backend might expect separate updates, we can keep the structure but trigger save manually.
             However, the user wants a "handle button". 
             A simple way is to use a form that submits the current state.
             But the backend (ContentController) updates one content item per request typically.
             Let's implement a JS handler that loops through the changes or submits two requests?
             Or simpler: Just make the button trigger the 'updateToggle' logic for both?
             The user request: "add button handle to accept changes so no longer use toggle".
             So the toggle just changes local x-data state.
             The button will trigger the save.
        --}}
        <div class="bg-gray-50 rounded-xl p-6 border border-gray-200 space-y-6">
            <h4 class="font-bold text-slate-900 text-sm mb-4 border-b border-gray-200 pb-2">{{ translate('Visibilitas Elemen') }}</h4>
            
            {{-- Toggle Show Image --}}
            <div class="flex items-center justify-between group cursor-pointer select-none" 
                 @click="showImage = !showImage">
                <div>
                    <span class="block font-bold text-slate-800">{{ translate('Tampilkan Gambar') }}</span>
                    <span class="block text-xs text-slate-500 group-hover:text-slate-600 transition-colors">{{ translate('Menampilkan file logo') }}</span>
                </div>
                
                <div class="relative inline-flex items-center pointer-events-none">
                    <input type="checkbox" x-model="showImage" class="sr-only peer">
                    <div class="w-14 h-8 bg-gray-200 rounded-full peer peer-checked:bg-brand-yellow peer-focus:ring-4 peer-focus:ring-brand-yellow/20 transition-all duration-300 ease-in-out"></div>
                    <div class="absolute left-[4px] top-[4px] bg-white w-6 h-6 rounded-full shadow-md transform transition-all duration-300 ease-[cubic-bezier(0.34,1.56,0.64,1)] peer-checked:translate-x-6 peer-checked:shadow-lg flex items-center justify-center"></div>
                </div>
            </div>

            {{-- Toggle Show Text --}}
            <div class="flex items-center justify-between group cursor-pointer select-none" 
                 @click="showText = !showText">
                <div>
                    <span class="block font-bold text-slate-800">{{ translate('Tampilkan Teks') }}</span>
                    <span class="block text-xs text-slate-500 group-hover:text-slate-600 transition-colors">{{ translate('Menampilkan teks branding') }}</span>
                </div>
                
                <div class="relative inline-flex items-center pointer-events-none">
                    <input type="checkbox" x-model="showText" class="sr-only peer">
                    <div class="w-14 h-8 bg-gray-200 rounded-full peer peer-checked:bg-brand-yellow peer-focus:ring-4 peer-focus:ring-brand-yellow/20 transition-all duration-300 ease-in-out"></div>
                    <div class="absolute left-[4px] top-[4px] bg-white w-6 h-6 rounded-full shadow-md transform transition-all duration-300 ease-[cubic-bezier(0.34,1.56,0.64,1)] peer-checked:translate-x-6 peer-checked:shadow-lg flex items-center justify-center"></div>
                </div>
            </div>

            {{-- Save Button --}}
            <div class="flex justify-end pt-4 border-t border-gray-200">
                <x-ui.button type="button" @click="saveSettings()"
                    class="font-medium rounded-lg">
                    <span>{{ translate('Simpan Perubahan') }}</span>
                </x-ui.button>
            </div>
        </div>
    </form>

            {{-- Input Forms --}}
            <div class="space-y-6">
                {{-- Image Setting --}}
                <div x-show="showImage" x-transition>
                    <form action="{{ route('admin.contents.update', $logoImage->id ?? 0) }}" method="POST" enctype="multipart/form-data">
                        @csrf @method('PUT')
                        <label class="block text-sm font-medium text-slate-700 mb-2">{{ translate('Upload Logo') }}</label>
                        <div class="border-2 border-dashed border-gray-200 rounded-xl p-8 text-center hover:bg-gray-50 transition-colors cursor-pointer relative group"
                             @click="$refs.fileInput.click()"
                             @dragover.prevent="$el.classList.add('border-primary', 'bg-primary/5')"
                             @dragleave.prevent="$el.classList.remove('border-primary', 'bg-primary/5')"
                             @drop.prevent="$el.classList.remove('border-primary', 'bg-primary/5'); $refs.fileInput.files = $event.dataTransfer.files; $refs.fileInput.dispatchEvent(new Event('change'))">
                            
                            <input type="file" x-ref="fileInput" name="image" class="hidden" accept="image/*"
                                   @change="
                                       const file = $event.target.files[0];
                                       if(file) {
                                           previewImage = URL.createObjectURL(file);
                                       }
                                   ">
                            
                            <div class="w-16 h-16 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-4 text-slate-400 group-hover:text-primary group-hover:bg-primary/10 transition-colors">
                                 <x-icons.ui-cloud-upload class="w-8 h-8" />
                            </div>
                            <p class="text-slate-900 font-medium">{{ translate('Ganti Gambar Logo') }}</p>
                            <div class="mt-4 text-right">
                                <x-ui.button type="submit" class="rounded-lg font-medium">{{ translate('Upload') }}</x-ui.button>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- Text Setting --}}
                <div x-show="showText" x-transition>
                    <form action="{{ route('admin.contents.update', $logoText->id ?? 0) }}" method="POST">
                        @csrf @method('PUT')
                        <x-ui.input 
                            variant="soft"
                            label="{{ translate('Edit Teks Logo') }}" 
                            name="value" 
                            value="{{ $logoText->value ?? '' }}"
                            placeholder="Contoh: UMKM Sasuma" 
                            class="text-lg"
                        />
                         <div class="mt-2 text-right">
                            <x-ui.button type="submit" class="rounded-lg font-medium">{{ translate('Simpan Teks') }}</x-ui.button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

       {{-- Live Preview --}}
<div class="sticky top-6">
    <label class="block text-sm font-medium text-slate-700 mb-2">{{ translate('Preview Tampilan') }}</label>
    
    {{-- Container Preview --}}
    <div class="relative bg-gray-100 rounded-xl p-8 border border-gray-200 overflow-hidden min-h-[300px] flex flex-col justify-center">
         
         {{-- Background decorative --}}
         <div class="absolute top-0 left-0 right-0 h-32 bg-gradient-to-b from-white to-transparent opacity-50"></div>
         
         {{-- Navbar Simulation --}}
         {{-- Note: 'max-w-md' dihapus pada md (desktop) agar navbar bisa melebar --}}
         <nav class="relative w-full bg-white rounded-full shadow-lg px-6 py-4 flex items-center justify-between max-w-[320px] md:max-w-full mx-auto transition-all duration-500 shadow-gray-200/50">
             
             {{-- Left Side: Logo --}}
             <div class="shrink-0 inline-flex items-center gap-3">
                 {{-- Image Element --}}
                 <template x-if="showImage">
                     <div class="h-8 md:h-10 relative transition-all">
                         <img loading="lazy" :src="previewImage" alt="Logo Preview" class="h-full w-auto object-contain">
                         <div x-show="!previewImage" class="absolute inset-0 bg-gray-100 flex items-center justify-center text-[10px] text-slate-400 rounded border border-gray-200 w-10">
                             IMG
                         </div>
                     </div>
                 </template>

                 {{-- Text Element --}}
                 <template x-if="showText">
                     <span class="text-lg md:text-2xl font-bold items-center text-slate-900 tracking-tight transition-all" x-text="'{{ $logoText->value ?? 'Logo' }}'"></span>
                 </template>

                 {{-- Empty State --}}
                 <template x-if="!showImage && !showText">
                     <span class="text-xs text-slate-400 italic bg-gray-100 px-2 py-1 rounded">{{ translate('Hidden') }}</span>
                 </template>
             </div>

             {{-- Right Side: Menu Items --}}
             
             {{-- 1. Desktop View (Menu Lines) --}}
             {{-- 'hidden md:flex' artinya: tersembunyi di mobile, muncul (flex) di layar medium ke atas --}}
             <div class="hidden md:flex items-center gap-4">
                 <div class="h-2.5 w-16 bg-gray-200 rounded-full"></div>
                 <div class="h-2.5 w-16 bg-gray-200 rounded-full"></div>
                 <div class="h-2.5 w-16 bg-gray-200 rounded-full"></div>
                 <div class="h-8 w-8 bg-gray-200 rounded-full ml-2"></div> {{-- Simulasi Profile Avatar --}}
             </div>

             {{-- 2. Mobile View (Hamburger) --}}
             {{-- 'flex md:hidden' artinya: muncul di mobile, tersembunyi di layar medium ke atas --}}
             <div class="flex md:hidden items-center justify-center w-8 h-8 bg-gray-50 rounded-lg text-slate-600">
                 <x-icons.ui-menu class="w-5 h-5" />
             </div>
         </nav>

         {{-- Resize Helper Text --}}
        {{-- Resize Helper Text --}}
<div class="absolute bottom-4 left-0 right-0 text-center">
    <p class="text-xs text-slate-400 flex items-center justify-center gap-2">
        
        {{-- 1. Icon Mobile (Muncul di Mobile, Hilang di Desktop) --}}
        <span class="md:hidden">
            {{-- Pastikan nama icon ini ada di projectmu, bisa ui-smartphone, ui-mobile, atau ui-device-mobile --}}
            <x-icons.ui-smartphone />
        </span>

        {{-- 2. Icon Desktop (Hilang di Mobile, Muncul di Desktop) --}}
        <span class="hidden md:block">
            <x-icons.ui-desktop />
        </span>

        {{-- Teks --}}
        <span class="md:hidden">{{ translate('Tampilan Mobile') }}</span>
        <span class="hidden md:inline">{{ translate('Tampilan Desktop') }}</span>
        
        <span class="hidden md:inline text-slate-300">|</span>
        <span class="hidden md:inline text-[10px] text-slate-400">{{ translate('Resize browser untuk melihat mode mobile') }}</span>
    </p>
</div>
    </div>
</div>
