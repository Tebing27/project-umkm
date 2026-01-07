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
