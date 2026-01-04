<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Terkirim - UMKM Sasuma</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>

    <div class="min-h-screen flex flex-col justify-center items-center p-4">
        <x-ui.card class="w-full max-w-[420px] p-6 md:p-10 shadow-xl border-gray-100 text-center">

            <div class="mb-6 flex justify-center">
                <div class="bg-green-100 p-3 rounded-full">
                    <x-icons.ui-check class="w-8 h-8 text-green-600" />
                </div>
            </div>

            <!-- Judul -->
            <h1 class="text-2xl md:text-3xl font-bold mb-4 text-gray-900 tracking-tight">
                Sukses
            </h1>

            <p class="text-gray-600 mb-8 text-base">
                Tolong pergi ke email untuk melanjutkan nya
            </p>

            <div class="pt-2">
                <a href="{{ route('login') }}">
                    <x-ui.button class="rounded-lg w-full text-lg py-2 shadow-md">
                        Kembali ke Login
                    </x-ui.button>
                </a>
            </div>

        </x-ui.card>
    </div>

</body>

</html>
