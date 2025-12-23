<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email - UMKM Sasuma</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>

    <div class="min-h-screen flex flex-col justify-center items-center p-4">
        <x-ui.card class="w-full max-w-[420px] p-6 md:p-10 shadow-xl border-gray-100">

            <!-- Judul -->
            <h1 class="text-center text-2xl md:text-3xl font-bold mb-4 text-gray-900 tracking-tight">
                Verifikasi Email
            </h1>

            <div class="mb-6 text-sm text-gray-600 text-center">
                {{ __('Terima kasih telah mendaftar! Sebelum memulai, mohon verifikasi alamat email Anda dengan mengklik tautan yang baru saja kami barchan ke email Anda. Jika Anda tidak menerima email tersebut, kami dengan senang hati akan mengirimkan ulang.') }}
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="mb-6 font-medium text-sm text-green-600 bg-green-50 p-3 rounded-lg text-center">
                    {{ __('Tautan verifikasi baru telah dikirim ke alamat email yang Anda berikan saat pendaftaran.') }}
                </div>
            @endif

            <div class="space-y-4">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf

                    <x-ui.button type="submit"
                        class="w-full py-2.5 md:py-3 px-4 text-sm md:text-base font-semibold rounded-lg transition-all shadow-md hover:shadow-lg">
                        {{ __('Kirim Ulang Email Verifikasi') }}
                    </x-ui.button>
                </form>

                <form method="POST" action="{{ route('logout') }}" class="text-center">
                    @csrf
                    <button type="submit"
                        class="text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 underline underline-offset-4">
                        {{ __('Keluar') }}
                    </button>
                </form>
            </div>
        </x-ui.card>
    </div>

</body>

</html>
