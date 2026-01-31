@include('errors.layout', [
    'title' => translate('Waduh! Server Bermasalah.'),
    'code' => '500',
    'message' => translate('Sepertinya ada gangguan di server kami. Tim teknis sedang memperbaikinya. Coba refresh sebentar lagi ya.')
])
