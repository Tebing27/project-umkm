<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach ($items as $item)
        @include('admin.content.sections.cards.content-item-card')
    @endforeach
</div>
