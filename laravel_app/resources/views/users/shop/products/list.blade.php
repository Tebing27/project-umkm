@foreach($products as $product)
    @include('users.shop.products.card', [
        'product' => $product,
        'initialActive' => $product->is_active ?? true,
        'image' => $product->image ? asset('storage/' . $product->image) : 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&w=500&q=80',
        'category' => $product->category,
        'name' => $product->name,
        'price' => 'Rp ' . number_format($product->price, 0, ',', '.')
    ])
@endforeach
