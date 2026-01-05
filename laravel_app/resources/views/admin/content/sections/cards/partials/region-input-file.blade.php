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
