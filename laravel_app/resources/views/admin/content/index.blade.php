<x-layouts.admin :title="translate('Manajemen Konten')" :header-title="translate('Manajemen Konten')"
    :header-subtitle="translate('Atur tampilan dan konten website')">

    <div x-data="{
        activeTab: new URLSearchParams(window.location.search).get('tab') || 'home_hero',
        showLeftArrow: false,
        showRightArrow: false,
        checkScroll() {
            const el = this.$refs.tabContainer;
            if (el) {
                this.showLeftArrow = el.scrollLeft > 0;
                this.showRightArrow = el.scrollLeft < (el.scrollWidth - el.clientWidth - 5);
            }
        },
        init() {
            this.$nextTick(() => this.checkScroll());
            window.addEventListener('resize', () => this.checkScroll());
        }
    }" class="w-full min-h-screen pb-24 bg-slate-50/50">

    <div x-data="{ 
            notifications: [],
            add(message, type = 'success') {
                const id = Date.now() + Math.random().toString(36).substr(2, 9);
                this.notifications.push({ id, message, type });
                setTimeout(() => this.remove(id), 5000);
            },
            remove(id) {
                this.notifications = this.notifications.filter(n => n.id !== id);
            },
            init() {
                @if (session('success'))
                    this.add('{{ addslashes(session('success')) }}', 'success');
                @endif
                @if (session('error'))
                    this.add('{{ addslashes(session('error')) }}', 'error');
                @endif
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        this.add('{{ addslashes($error) }}', 'error');
                    @endforeach
                @endif
            }
        }"
        @notify.window="add($event.detail.message, $event.detail.type)"
        class="fixed inset-0 z-[100] flex flex-col items-center justify-start pt-24 pointer-events-none gap-3 px-4">
        
        <template x-for="note in notifications" :key="note.id">
            <div x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 -translate-y-4"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 -translate-y-4"
                    class="pointer-events-auto max-w-xl w-full rounded-lg shadow-lg border p-4 flex items-center gap-3 relative"
                    :class="note.type === 'success' ? 'bg-green-50 text-green-700 border-green-200' : 'bg-red-50 text-red-700 border-red-200'">
                
                {{-- Icon --}}
                <div class="shrink-0">
                    <template x-if="note.type === 'success'">
                        <x-icons.info-circle class="w-6 h-6 text-green-500" />
                    </template>
                    <template x-if="note.type === 'error'">
                        <x-icons.info-circle class="w-6 h-6 text-red-500" />
                    </template>
                </div>
                
                {{-- Message --}}
                <div class="flex-1 text-sm font-medium">
                    <span x-text="note.message"></span>
                </div>

                {{-- Close Button --}}
                <button @click="remove(note.id)" 
                        class="shrink-0 p-1 rounded-md hover:bg-black/5 transition-colors"
                        :class="note.type === 'success' ? 'text-green-500' : 'text-red-500'">
                    <span class="sr-only">Close</span>
                    <x-icons.x-mark class="w-4 h-4" />
                </button>
            </div>
        </template>
    </div>

    <script>
        function showToast(message, type = 'success') {
            window.dispatchEvent(new CustomEvent('notify', { detail: { message, type } }));
        }
    </script>

        {{-- 1. Sticky Header (Static White - No Jitter) --}}
        <div class="sticky top-[73px] lg:top-0 z-30 -mx-4 sm:-mx-6 lg:-mx-8 px-4 sm:px-6 lg:px-8">
            <div class="relative max-w-7xl mx-auto">
                {{-- Fade Gradients --}}
                <div class="absolute left-0 top-0 bottom-0 w-12 bg-gradient-to-r from-white to-transparent z-10 pointer-events-none"
                    x-show="showLeftArrow"></div>
                <div class="absolute right-0 top-0 bottom-0 w-12 bg-gradient-to-l from-white to-transparent z-10 pointer-events-none"
                    x-show="showRightArrow"></div>

                {{-- Scroll Container --}}
                <div class="overflow-x-auto no-scrollbar snap-x scroll-smooth flex gap-3 pb-1" x-ref="tabContainer"
                    @scroll.debounce.10ms="checkScroll()">

                    @foreach ($tabs as $key => $data)
                        <button
                            @click="activeTab = '{{ $key }}'; window.scrollTo({top: 0, behavior: 'smooth'})"
                            class="shrink-0 snap-start flex items-center gap-2 px-4 py-2 rounded-full border text-base font-semibold whitespace-nowrap"
                            :class="activeTab === '{{ $key }}'
                                ?
                                'bg-[#004a85] text-white border-[#004a85] shadow-md' :
                                'bg-white text-slate-600 border-slate-200 hover:border-slate-300 hover:bg-slate-50'">
                            <span>
                                @if ($key === 'home_hero')
                                    <x-icons.home class="w-4 h-4" />
                                @elseif($key === 'home_wilayah')
                                    <x-icons.location class="w-4 h-4" />
                                @elseif($key === 'umkm_index')
                                    <x-icons.shopping-bag class="w-4 h-4" />
                                @else
                                    <x-icons.settings class="w-4 h-4" />
                                @endif
                            </span>
                            {{translate($data['label']) }}
                        </button>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- 2. Content Area --}}
        <div class="w-full max-w-7xl mx-auto mt-6">

            @foreach ($contents as $group => $items)
                <div x-show="activeTab === '{{ in_array($group, array_keys($tabs)) ? $group : 'other' }}'"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4"
                    x-transition:enter-end="opacity-100 translate-y-0" style="display: none;" class="space-y-8">

                    {{-- Section Header --}}
                    <div class="border-b border-slate-200 pb-4">
                        <h2 class="text-2xl font-bold text-slate-900">{{translate($tabs[$group]['label'] ?? 'Lainnya') }}</h2>
                        <p class="text-slate-500 text-base mt-1">{{translate('Kelola konten untuk bagian ini.')}}</p>
                    </div>

                    {{-- A. KHUSUS TAB WILAYAH: GRID REGIONS --}}
                    @if ($group === 'home_wilayah')
                        {{-- GRID WILAYAH REDESIGNED (Square Aspect Ratio, Modern Frosted Glass Label, Center Hover Action) --}}
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                            @foreach ($regions as $region)
                                {{-- Card Container --}}
                                <div class="group relative bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden hover:shadow-[0_20px_25px_-5px_rgb(0_0_0/0.1),_0_8px_10px_-6px_rgb(0_0_0/0.1)] transition-all duration-500 hover:-translate-y-1"
                                    x-data="{ photoName: null, photoPreview: null }">

                                    <form action="{{ route('admin.regions.update_image', $region->id) }}" method="POST"
                                        enctype="multipart/form-data" class="h-full">
                                        @csrf @method('PUT')

                                        {{-- Image Container (ASPECT SQUARE) --}}
                                        <div
                                            class="relative w-full h-48 md:h-64 aspect-square bg-slate-100 overflow-hidden relative">
                                            @if ($region->image)
                                                {{-- Original Image --}}
                                                <img src="{{ asset('storage/' . str_replace('\\', '/', $region->image)) }}"
                                                    x-show="!photoPreview"
                                                    class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                                            @else
                                                {{-- Placeholder --}}
                                                <div
                                                    class="absolute inset-0 flex flex-col items-center justify-center text-slate-300 gap-3 bg-slate-50">
                                                    <x-icons.photo class="w-10 h-10 opacity-50" />
                                                    <span class="text-base font-bold uppercase text-slate-400">{{translate('Tidak
                                                        Ada Gambar')}}</span>
                                                </div>
                                            @endif

                                            {{-- New Photo Preview --}}
                                            <div x-show="photoPreview"
                                                class="absolute inset-0 bg-cover bg-center z-10 transition-opacity duration-300"
                                                :style="'background-image: url(\'' + photoPreview + '\');'"></div>

                                            {{-- ================= OVERLAYS ================= --}}

                                            {{-- 1. Text Label (Frosted Glass Effect - Disappears on Hover/Edit) --}}
                                            <div class="absolute bottom-0 inset-x-0 p-4 bg-white/80 backdrop-blur-md border-t border-white/50 transition-all duration-300 group-hover:translate-y-full"
                                                :class="{ 'translate-y-full': photoPreview }">
                                                <h4 class="text-slate-900 font-bold text-base truncate">
                                                    {{ $region->name }}</h4>
                                                {{-- Optional: Add a small subtitle like "Wilayah" or region count if available --}}
                                                <div
                                                    class="text-base text-[#004a85] font-medium mt-0.5 flex items-center gap-1 opacity-70">
                                                    <x-icons.location class="w-3 h-3" /> <span>{{translate('Wilayah')}}</span>
                                                </div>
                                            </div>

                                            {{-- 2. Hover & Edit Overlay (Dark - Appears on Hover OR when previewing) --}}
                                            <div class="absolute inset-0 bg-slate-900/60 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col items-center justify-center p-4 backdrop-blur-[2px] z-20"
                                                :class="{ 'opacity-100': photoPreview }">

                                                {{-- State A: Normal Hover (Tombol Ubah) --}}
                                                <div x-show="!photoPreview"
                                                    class="text-center transform translate-y-4 group-hover:translate-y-0 transition-all duration-300 delay-100 relative">
                                                    
                                                    @if ($region->image)
                                                        <div class="absolute -top-12 -right-12">
                                                            <form action="{{ route('admin.regions.delete_image', $region->id) }}" method="POST" 
                                                                onsubmit="return confirm('{{ translate('Apakah Anda yakin ingin menghapus gambar ini?') }}');">
                                                                @csrf @method('DELETE')
                                                                <button type="submit" class="p-2 bg-red-500 rounded-full text-white hover:bg-red-600 transition-colors shadow-lg" title="{{ translate('Hapus Gambar') }}">
                                                                    <x-icons.trash class="w-4 h-4" />
                                                                </button>
                                                            </form>
                                                        </div>
                                                    @endif

                                                    <button type="button"
                                                        @click="$refs.photo_{{ $region->id }}.click()"
                                                        class="group/btn bg-white text-slate-900 rounded-full p-3 mb-3 hover:bg-[#004a85] hover:text-white transition-all shadow-lg hover:scale-110 hover:rotate-6">
                                                        <x-icons.photo
                                                            class="w-6 h-6 transition-transform group-hover/btn:scale-90" />
                                                    </button>
                                                    <p
                                                        class="text-white font-bold text-sm tracking-wide drop-shadow-sm">
                                                        {{translate('Ubah Foto')}}</p>
                                                </div>

                                                {{-- State B: File Selected (Tombol Simpan) --}}
                                                <div x-show="photoPreview" style="display: none;"
                                                    class="w-full text-center animate-fade-in-up">
                                                    <div
                                                        class="mb-3 px-4 py-1.5 bg-black/40 rounded-full inline-block backdrop-blur-sm">
                                                        <p class="text-white/90 text-base truncate max-w-[150px]"
                                                            x-text="photoName"></p>
                                                    </div>
                                                    <x-ui.button type="submit"
                                                        class="w-full font-medium py-3 px-6 rounded-lg shadow-lg active:scale-95 flex items-center justify-center gap-2 relative overflow-hidden group/save">
                                                        <span
                                                            class="absolute inset-0 w-full h-full bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover/save:animate-shimmer"></span>
                                                        <x-icons.check class="w-5 h-5 relative z-10" />
                                                        <span class="relative z-10">{{translate('Simpan Foto')}}</span>
                                                    </x-ui.button>
                                                    {{-- Tombol Batal (Optional UX Improvement) --}}
                                                    <button type="button"
                                                        @click="photoPreview = null; photoName = null; $refs.photo_{{ $region->id }}.value = null"
                                                        class="cursor-pointer text-white/70 text-base mt-3 hover:text-white transition-colors underline underline-offset-2">
                                                        {{translate('Batal')}}
                                                    </button>
                                                </div>
                                            </div>
                                            {{-- ================= END OVERLAYS ================= --}}

                                            <input type="file" name="image" class="hidden"
                                                x-ref="photo_{{ $region->id }}" accept="image/*"
                                                x-on:change="const file = $refs.photo_{{ $region->id }}.files[0]; 
                                                if(file){ 
                                                    if(file.size > 2097152) { 
                                                        showToast('{{ translate('Ukuran file maksimal 2MB') }}', 'error'); 
                                                        $refs.photo_{{ $region->id }}.value = null; 
                                                        return; 
                                                    }
                                                    photoName = file.name; 
                                                    const reader = new FileReader(); 
                                                    reader.onload = (e) => { photoPreview = e.target.result; }; 
                                                    reader.readAsDataURL(file); 
                                                }">
                                        </div>
                                    </form>
                                </div>
                            @endforeach
                        </div>

                        {{-- Divider untuk Wilayah --}}
                        <div class="relative py-4">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-slate-200"></div>
                            </div>
                            <div class="relative flex justify-center">
                                <span
                                    class="bg-slate-50/50 px-6 text-sm text-slate-400 font-bold tracking-widest uppercase">{{translate('Konfigurasi
                                    Halaman')}}</span>
                            </div>
                        </div>
                    @endif


                    {{-- B. STANDARD ITEMS LOOP (Hero, UMKM, Text Configs) --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($items as $item)
                            <div
                                class="bg-white rounded-3xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] border border-slate-100 overflow-hidden flex flex-col h-full hover:shadow-lg duration-300 {{ $item->type === 'image' ? $item->col_span_class : '' }}">

                                <form action="{{ route('admin.contents.update', $item->id) }}" method="POST"
                                    enctype="multipart/form-data" class="flex flex-col h-full" x-data="{ photoName: null, photoPreview: null }">
                                    @csrf @method('PUT')

                                    <div class="p-6 flex flex-col h-full gap-4">
                                        {{-- Header Card --}}
                                        <div class="flex items-start justify-between">
                                            <label
                                                class="font-bold text-slate-700 text-base">{{translate($item->label) }}</label>
                                            @if ($item->type !== 'image')
                                                <div
                                                    class="h-8 w-8 rounded-full bg-blue-50 text-[#004a85] flex items-center justify-center">
                                                    <x-icons.pencil class="w-4 h-4" />
                                                </div>
                                            @endif
                                        </div>

                                        {{-- Body --}}
                                        <div class="flex-1">
                                            @if ($item->type === 'image')
                                                {{-- LOGIKA DESIGN IMAGE BERDASARKAN HALAMAN --}}
                                                <div
                                                    class="relative group border border-slate-100 bg-slate-50 overflow-hidden mx-auto
                                                    {{-- 1. Design Hero (Portrait, max-w-md, rounded-lg) --}}
                                                    @if ($item->is_hero_image) rounded-lg w-full max-w-md object-cover aspect-[3/4] md:aspect-auto md:h-[550px]
                                                    {{-- 2. Design UMKM (Tall, rounded-3xl, shadow besar) --}}
                                                    @elseif($item->is_umkm_image) object-cover h-[400px] lg:h-[500px] w-full 
                                                    {{-- 3. Default Image --}}
                                                    @else w-full aspect-video rounded-2xl shadow-inner @endif">

                                                    @if ($item->value)
                                                        <img src="{{ asset('storage/' . str_replace('\\', '/', $item->value)) }}"
                                                            x-show="!photoPreview"
                                                            class="w-full h-full object-cover {{ $item->is_umkm_image ? 'object-center' : '' }}">
                                                    @else
                                                        <div class="absolute inset-0 flex flex-col items-center justify-center text-slate-300 gap-3 bg-slate-50"
                                                            x-show="!photoPreview">
                                                            <x-icons.photo class="w-10 h-10 opacity-50" />
                                                            <span
                                                                class="text-base font-bold uppercase tracking-widest text-slate-400">{{translate('Tidak
                                                                Ada Gambar')}}</span>
                                                        </div>
                                                    @endif

                                                    <div x-show="photoPreview"
                                                        class="absolute inset-0 bg-cover bg-center"
                                                        :style="'background-image: url(\'' + photoPreview + '\');'"
                                                        style="display: none;"></div>

                                                    {{-- Hover Action --}}
                                                    <div
                                                        class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col items-center justify-center backdrop-blur-[2px]">
                                                        
                                                        @if ($item->value)
                                                            <div class="absolute top-4 right-4 translate-y-[-10px] opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300 delay-75">
                                                                <form action="{{ route('admin.contents.delete_image', $item->id) }}" method="POST"
                                                                    onsubmit="return confirm('{{ translate('Apakah Anda yakin ingin menghapus gambar ini?') }}');">
                                                                    @csrf @method('DELETE')
                                                                    <button type="submit" class="bg-red-500/80 hover:bg-red-600 text-white p-2 rounded-full backdrop-blur-md shadow-lg transition-transform hover:scale-110" title="{{ translate('Hapus Gambar') }}">
                                                                        <x-icons.trash class="w-5 h-5" />
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        @endif

                                                        <button type="button"
                                                            @click="$refs.photo_{{ $item->id }}.click()"
                                                            class="bg-white text-slate-800 px-5 py-2.5 rounded-full font-bold text-base shadow-xl transform translate-y-4 group-hover:translate-y-0 duration-300">
                                                            {{ $item->value ? translate('Ganti Gambar') : translate('Unggah Foto') }}
                                                        </button>
                                                    </div>
                                                </div>

                                                <div class="mt-3 flex justify-between items-center px-1">
                                                    <span class="text-base text-slate-400 font-medium">
                                                        {{ translate($item->image_dimensions_label) }}
                                                    </span>
                                                    <button type="button"
                                                        @click="$refs.photo_{{ $item->id }}.click()"
                                                        class="lg:hidden text-base text-[#004a85] font-bold underline">{{translate('Unggah')}}</button>
                                                </div>
                                                <input type="file" name="image" class="hidden"
                                                    x-ref="photo_{{ $item->id }}" accept="image/*"
                                                    x-on:change="const file = $refs.photo_{{ $item->id }}.files[0]; 
                                                    if(file){ 
                                                        if(file.size > 5242880) { 
                                                            showToast('{{ translate('Ukuran file maksimal 5MB') }}', 'error'); 
                                                            $refs.photo_{{ $item->id }}.value = null; 
                                                            return; 
                                                        }
                                                        photoName = file.name; 
                                                        const reader = new FileReader(); 
                                                        reader.onload = (e) => { photoPreview = e.target.result; }; 
                                                        reader.readAsDataURL(file); 
                                                    }">
                                            @elseif ($item->type === 'textarea' || $item->key === 'home_hero_description')
                                                <div class="relative group/input h-full">
                                                    <x-ui.textarea variant="soft" name="value" rows="5"
                                                        class="h-full resize-none">{{ $item->value }}</x-ui.textarea>
                                                </div>
                                            @else
                                                <div class="relative group/input">
                                                    <x-ui.input variant="soft" type="text" name="value"
                                                        value="{{ $item->value }}" />
                                                </div>
                                            @endif
                                        </div>

                                        {{-- Footer Action --}}
                                        @if ($item->type !== 'image')
                                            <div class="pt-2 flex justify-center">
                                                <x-ui.button type="submit"
                                                    class="rounded-lg text-base font-medium">{{translate('Simpan Data')}}</x-ui.button>
                                            </div>
                                        @else
                                            <div x-show="photoPreview" style="display: none;"
                                                class="animate-fade-in-up">
                                                <x-ui.button type="submit"
                                                    class="w-full py-3 rounded-lg font-medium">
                                                    {{translate('Simpan Foto Baru')}}
                                                </x-ui.button>
                                                {{-- Tombol Batal --}}
                                                <button type="button"
                                                    @click="photoPreview = null; photoName = null; $refs.photo_{{ $item->id }}.value = null"
                                                    class="cursor-pointer w-full font-medium text-slate-900 text-sm mt-3 transition-colors underline underline-offset-2">
                                                    {{translate('Batal')}}
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                </form>
                            </div>
                        @endforeach
                    </div>

                    @if ($group === 'home_hero')
    {{-- Divider --}}
    <div class="relative py-8">
        <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-slate-200"></div>
        </div>
        <div class="relative flex justify-center">
            <span class="bg-slate-50/50 px-6 text-sm text-slate-400 font-bold tracking-widest uppercase">
                {{ translate('Konfigurasi Slider Region') }}
            </span>
        </div>
    </div>

    {{-- Grid Region --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 pb-24">
        @foreach ($regions as $region)
           
            <div x-data="{
                    open: false,
                    selectedId: '{{ $region->featured_shop_id ?? '' }}',
                    selectedName: '{{ addslashes($region->selected_shop_name) }}',
                    filter: '',
                    isLoading: false,

                    submitForm() {
                        this.isLoading = true;
                        let formData = new FormData(this.$refs.form);
                        
                        // Explicitly append selected shop_id because x-model doesn't automatically sync to hidden input value in FormData 
                        formData.set('shop_id', this.selectedId);

                        fetch(this.$refs.form.action, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            this.isLoading = false;
                            if (data.success) {
                                showToast(data.message, 'success');
                            } else {
                                showToast(data.message || 'Terjadi kesalahan', 'error');
                            }
                        })
                        .catch(error => {
                            this.isLoading = false;
                            console.error('Error:', error);
                            showToast('Terjadi kesalahan jaringan', 'error');
                        });
                    }
                }" 
                @click.outside="open = false"
                class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 hover:shadow-md transition-shadow relative"
                :class="open ? 'z-50' : 'z-0 hover:z-10'">

                <form x-ref="form" action="{{ route('admin.regions.update_featured_shop', $region->id) }}" method="POST" @submit.prevent="submitForm">
                    @csrf @method('PUT')

                    {{-- Header Card (Icon & Nama Region) --}}
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center gap-3">
                            {{-- Image Display Only (No Upload) --}}
                            @if ($region->image)
                                <img src="{{ asset('storage/' . str_replace('\\', '/', $region->image)) }}"
                                    class="w-10 h-10 rounded-md object-cover bg-slate-100 shadow-sm border border-slate-100">
                            @else
                                <div class="w-10 h-10 rounded-md bg-slate-50 border border-slate-100 flex items-center justify-center text-slate-400">
                                    <x-icons.location class="w-5 h-5" />
                                </div>
                            @endif
                            <label class="block text-base font-bold text-slate-700">{{ $region->name }}</label>
                        </div>
                        
                        <div class="flex flex-col items-end gap-1">
                            <label class="text-[10px] uppercase font-bold text-slate-500 tracking-widest">
                                {{ translate('Urutan') }}
                            </label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-2 pointer-events-none">
                                    <span class="text-slate-400 font-bold text-xs group-focus-within:text-[#004a85] transition-colors">#</span>
                                </div>
                                
                                <input type="number" name="hero_order" 
                                    value="{{ $region->hero_order }}" 
                                    class="w-20 h-9 pl-6 pr-2 text-right font-bold text-slate-700 bg-white border border-slate-200 rounded-lg 
                                            focus:ring-1 focus:ring-[#004a85] focus:border-[#004a85] 
                                            shadow-[0_2px_5px_-1px_rgba(0,0,0,0.05)] transition-colors outline-none [-moz-appearance:_textfield] [&::-webkit-inner-spin-button]:m-0 [&::-webkit-inner-spin-button]:appearance-none"
                                    placeholder="0">
                            </div>
                        </div>
                    </div>

                    <div class="flex gap-2 items-center">

                        {{-- Dropdown Container --}}
                        <div class="relative w-full">

                            {{-- INPUT HIDDEN: Nilai yang dikirim ke server --}}
                            <input type="hidden" name="shop_id" :value="selectedId">

                            {{-- TRIGGER BUTTON --}}
                            <button type="button" @click="open = !open"
                                class="w-full h-[40px] px-3 bg-white border border-slate-200 rounded-lg shadow-sm flex items-center justify-between gap-2 hover:border-[#004a85] transition-colors group text-left"
                                :class="open ? 'border-[#004a85] ring-1 ring-[#004a85]' : ''">

                                <span class="truncate text-sm font-medium"
                                    :class="selectedId ? 'text-[#004a85]' : 'text-slate-600'"
                                    x-text="selectedName"></span>

                                <x-icons.arrow-down
                                    class="w-4 h-4 text-slate-400 transition-transform duration-200 shrink-0"
                                    x-bind:class="open ? 'rotate-180 text-[#004a85]' : ''" />
                            </button>

                            {{-- DROPDOWN BODY --}}
                            <div x-show="open" x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 translate-y-1"
                                x-transition:enter-end="opacity-100 translate-y-0" style="display: none;"
                                class="absolute top-full left-0 right-0 mt-1 bg-white rounded-lg shadow-xl border border-slate-100 z-[60] overflow-hidden max-h-[250px] flex flex-col">

                                {{-- Search Filter (Always Visible) --}}
                                <div class="p-2 border-b border-slate-100 bg-slate-50 sticky top-0 z-10">
                                    <div class="relative group">
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                            <svg class="w-4 h-4 text-slate-400 group-focus-within:text-[#004a85] transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                            </svg>
                                        </div>
                                        
                                        <input type="text" 
                                            x-model="filter" 
                                            placeholder="{{ translate('Cari Nama Toko...') }}"
                                            x-ref="searchInput"
                                            x-init="$watch('open', value => { if (value) $nextTick(() => $refs.searchInput.focus()) })"
                                            class="w-full pl-9 pr-3 py-1.5 text-sm text-slate-700 bg-white border border-slate-200 rounded-md 
                                                    focus:outline-none focus:ring-1 focus:ring-[#004a85] focus:border-[#004a85] 
                                                    placeholder:text-slate-400 shadow-sm">
                                    </div>
                                </div>

                                {{-- List Items --}}
                                <div class="overflow-y-auto custom-scrollbar p-1">
                                    {{-- Option: Acak / Tidak Ada --}}
                                    <div @click="selectedId = ''; selectedName = '{{ translate('Acak / Tidak Ada') }}'; open = false"
                                        class="cursor-pointer px-3 py-2 rounded-md text-sm hover:bg-slate-50 transition-colors flex items-center justify-between group"
                                        :class="selectedId === '' ? 'bg-blue-50/50 text-[#004a85] font-semibold' :
                                            'text-slate-600'">
                                        <span>{{ translate('Acak / Tidak Ada') }}</span>
                                        <div x-show="selectedId === ''">
                                            <x-icons.check class="w-4 h-4 text-[#004a85]" />
                                        </div>
                                    </div>

                                    {{-- Options: Shops --}}
                                    @foreach ($region->shops as $shop)
                                        <div @click="selectedId = '{{ $shop->id }}'; selectedName = '{{ addslashes($shop->name) }}'; open = false"
                                            x-show="!filter || '{{ strtolower($shop->name) }}'.includes(filter.toLowerCase())"
                                            class="cursor-pointer px-3 py-2 z-50 rounded-md text-sm hover:bg-blue-50 transition-colors flex items-center justify-between group mt-0.5"
                                            :class="selectedId == '{{ $shop->id }}' ?
                                                'bg-blue-50 text-[#004a85] font-semibold' : 'text-slate-700'">
                                            <span class="truncate">{{ $shop->name }}</span>

                                            {{-- Check Icon if selected --}}
                                            <div x-show="selectedId == '{{ $shop->id }}'">
                                                <x-icons.check class="w-4 h-4 text-[#004a85]" />
                                            </div>
                                        </div>
                                    @endforeach

                                    {{-- Empty State for Filter --}}
                                    <div x-show="filter && $el.querySelectorAll('[x-show*=\'includes\']:not([style*=\'none\'])').length === 0"
                                        class="px-3 py-2 text-xs text-slate-400 text-center">
                                        {{ translate('Tidak ditemukan') }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Submit Button --}}
                        <button type="submit" 
                                :disabled="isLoading"
                                class="rounded-lg cursor-pointer px-3 h-[40px] flex items-center justify-center shrink-0 border border-transparent bg-[#FFC107] hover:bg-[#ffcd38] shadow-sm text-slate-900 disabled:opacity-75 disabled:cursor-not-allowed active:scale-95"
                                title="{{ translate('Simpan') }}">
                            
                            <template x-if="!isLoading">
                                <x-icons.check class="w-5 h-5" />
                            </template>
                            <template x-if="isLoading">
                                <x-icons.loading class="w-5 h-5" />
                            </template>
                        </button>
                    </div>
                </form>
            </div>
        @endforeach
    </div>
@endif
</div>
@endforeach
    </div>
</x-layouts.admin>
