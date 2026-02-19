<div class="group relative bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden hover:shadow-[0_20px_25px_-5px_rgb(0_0_0/0.1),_0_8px_10px_-6px_rgb(0_0_0/0.1)] transition-all duration-500 hover:-translate-y-1"
    x-data="{ photoName: null, photoPreview: null }">

    <form action="{{ route('admin.regions.update_image', $region->id) }}" method="POST"
        enctype="multipart/form-data" class="h-full">
        @csrf @method('PUT')
        
        @include('admin.content.partials.featured-regions._region-image-display')
        @include('admin.content.partials.featured-regions._region-input-file')
    </form>
    
    {{-- Edit/Delete Buttons Removed as per request to disable CRUD --}}
</div>

