@if(in_array($group, ['home_hero', 'umkm_index']))
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
        {{-- Images --}}
         @foreach ($items->where('type', 'image') as $item)
            @include('admin.content.partials.content-items._content-item-card')
        @endforeach

        {{-- Texts --}}
         @foreach ($items->where('type', '!=', 'image') as $item)
            @include('admin.content.partials.content-items._content-item-card')
        @endforeach
    </div>
@else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($items as $item)
            @include('admin.content.partials.content-items._content-item-card')
        @endforeach
    </div>
@endif

