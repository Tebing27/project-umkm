        {{-- === MODALS === --}}
        @include('users.products.sections.add-product-form')
        @include('users.products.sections.edit-product-form')

        {{-- Hidden Delete Form --}}
        <form id="delete-product-form" action="" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
