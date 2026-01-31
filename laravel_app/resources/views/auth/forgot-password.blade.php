<x-layouts.auth>
    <x-slot:title>
        {{ translate('Lupa Kata Sandi - UMKM Sasuma') }}
    </x-slot:title>

    <div class="min-h-screen flex flex-col justify-center items-center p-4">
        <x-ui.card class="w-full max-w-[420px] p-6 md:p-10 shadow-xl border-gray-100">

            <!-- Judul -->
            <h1 class="text-center text-2xl md:text-3xl font-bold mb-4 text-slate-900 tracking-tight">
                Lupa Kata Sandi
            </h1>

            <p class="text-center text-slate-600 mb-8 text-sm">
                Masukkan email Anda untuk kami kirimkan link reset kata sandi.
            </p>

            <form action="{{ route('password.email') }}" method="POST" class="space-y-5">
                @csrf
                @if (session('status'))
                    <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg text-sm">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg text-sm">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Input Email -->
                <div>
                    <label class="block mb-2 text-sm font-semibold text-slate-700">Email</label>
                    <x-ui.input type="email" name="email" value="{{ old('email') }}"
                        placeholder="Contoh: john@gmail.com"
                        class="bg-gray-50 rounded-lg border-gray-300 focus:ring-blue-500/20 focus:border-blue-500 font-normal"
                        required autofocus>
                        <x-slot:icon>
                            <x-icons.contact-mail class="w-5 h-5" stroke-width="1.5" />
                        </x-slot:icon>
                    </x-ui.input>
                </div>

                <!-- Tombol Kirim -->
                <div class="pt-2">
                    <x-ui.button type="submit"
                        class="w-full py-2.5 md:py-3 px-4 rounded-lg transition-all shadow-md hover:shadow-lg">
                        Kirim Link Reset
                    </x-ui.button>
                </div>

                <div class="text-center mt-4">
                    <a href="{{ route('login') }}"
                        class="text-sm text-blue-600 hover:text-blue-700 font-medium underline-offset-4 hover:underline">
                        Kembali ke Login
                    </a>
                </div>

            </form>
        </x-ui.card>
    </div>

</x-layouts.auth>
