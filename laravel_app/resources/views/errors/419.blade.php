@include('errors.layout', [
    'title' => translate('Waduh! Sesi Habis.'),
    'code' => '419',
    'message' => translate('Halaman telah kedaluwarsa karena tidak ada aktivitas. Silakan refresh halaman dan coba lagi.')
])
