@include('errors.layout', [
    'title' => translate('Waduh! Belum Login.'),
    'code' => '401',
    'message' => translate('Silakan masuk (login) terlebih dahulu untuk melanjutkan akses ke halaman ini.')
])
