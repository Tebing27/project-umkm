@include('errors.layout', [
    'title' => translate('Waduh! Dilarang Masuk.'),
    'code' => '403',
    'message' => translate('Maaf, Anda tidak memiliki izin untuk mengakses halaman ini. Silakan kembali ke jalan yang benar.')
])
