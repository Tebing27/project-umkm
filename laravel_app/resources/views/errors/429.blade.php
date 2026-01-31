@include('errors.layout', [
    'title' => translate('Waduh! Terlalu Banyak Request.'),
    'code' => '429',
    'message' => translate('Mohon ditenangkan dulu jarinya. Silakan tunggu beberapa saat lagi sebelum mencoba akses kembali.')
])
