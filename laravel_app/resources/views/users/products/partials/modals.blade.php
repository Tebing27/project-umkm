        {{-- === MODALS === --}}
        @include('users.products.partials.add-product-form')
        @include('users.products.partials.edit-product-form')

        {{-- Hidden Delete Form --}}
        <form id="delete-product-form" action="" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>

