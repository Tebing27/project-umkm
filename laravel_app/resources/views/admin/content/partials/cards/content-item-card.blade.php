<div class="bg-white rounded-3xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] border border-slate-100 overflow-hidden flex flex-col h-full hover:shadow-lg duration-300 {{ $item->type === 'image' ? $item->col_span_class : '' }}">
    <form action="{{ route('admin.contents.update', $item->id) }}" method="POST"
        enctype="multipart/form-data" class="flex flex-col h-full" x-data="{ photoName: null, photoPreview: null }">
        @csrf @method('PUT')

        <div class="p-6 flex flex-col h-full gap-4">
             @include('admin.content.partials.cards.partials.content-item-header')
             <div class="flex-1">
                 @if ($item->type === 'image')
                     @include('admin.content.partials.cards.partials.content-item-image')
                 @elseif ($item->type === 'textarea' || $item->key === 'home_hero_description')
                     <div class="relative group/input h-full">
                        <x-ui.textarea variant="soft" name="value" rows="5" class="h-full resize-none">{{ $item->value }}</x-ui.textarea>
                     </div>
                 @else
                     <div class="relative group/input">
                        <x-ui.input variant="soft" type="text" name="value" value="{{ $item->value }}" />
                     </div>
                 @endif
             </div>
             @include('admin.content.partials.cards.partials.content-item-footer')
        </div>
    </form>
</div>

