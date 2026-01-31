<x-layouts.auth>
    <x-slot:title>
        {{ translate('Verifikasi Email - UMKM Sasuma') }}
    </x-slot:title>

    <div class="min-h-screen flex flex-col justify-center items-center p-4">
        <x-ui.card class="w-full max-w-[420px] p-6 md:p-10 shadow-xl border-gray-100">

            <!-- Judul -->
            <h1 class="text-center text-2xl md:text-3xl font-bold mb-4 text-slate-900 tracking-tight">
                Verifikasi Email
            </h1>

            <div class="mb-6 text-sm text-slate-600 text-center">
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
                        class="w-full py-2.5 md:py-3 px-4 rounded-lg transition-all shadow-md hover:shadow-lg">
                        {{ __('Kirim Ulang Email Verifikasi') }}
                    </x-ui.button>
                </form>

                <form method="POST" action="{{ route('logout') }}" class="text-center">
                    @csrf
                    <x-ui.button type="submit" variant="link-gray" size="compact" class="text-sm h-auto !p-0 !bg-transparent font-normal">
                        {{ __('Keluar') }}
                    </x-ui.button>
                </form>
            </div>
        </x-ui.card>
    </div>

</x-layouts.auth>
