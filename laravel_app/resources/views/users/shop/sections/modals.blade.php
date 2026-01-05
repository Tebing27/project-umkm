        {{-- === MODALS === --}}
        @include('users.shop.products.form-add')
        @include('users.shop.products.form-edit')

        {{-- Hidden Delete Form --}}
        <form id="delete-product-form" action="" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
