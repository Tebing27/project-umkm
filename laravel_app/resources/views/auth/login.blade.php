<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Usaha - UMKM Sasuma</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>

    <div class="min-h-screen flex flex-col justify-center items-center p-4">
        <x-ui.card class="w-full max-w-[420px] p-6 md:p-10 shadow-xl border-gray-100">

            <!-- Judul -->
            <h1 class="text-center text-3xl md:text-4xl font-bold mb-8 text-gray-900 tracking-tight">
                Masuk Usaha
            </h1>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form action="{{ route('login') }}" method="POST" class="space-y-5">
                @csrf
                @if ($errors->any())
                    <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg text-sm">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Input Email / No HP -->
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">Email</label>
                    <x-ui.input type="email" name="email" value="{{ old('email') }}"
                        placeholder="Contoh: john@gmail.com"
                        class="bg-gray-50 rounded-lg border-gray-300 focus:ring-blue-500/20 focus:border-blue-500 font-normal"
                        required autofocus autocomplete="username">
                        <x-slot:icon>
                            <x-icons.mail class="w-5 h-5" stroke-width="1.5" />
                        </x-slot:icon>
                    </x-ui.input>
                    @error('email')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Input Password -->
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">Kata Sandi</label>
                    <x-ui.input type="password" name="password" placeholder="Masukkan kata sandi"
                        class="bg-gray-50 rounded-lg border-gray-300 focus:ring-blue-500/20 focus:border-blue-500 font-normal"
                        required autocomplete="current-password">
                        <x-slot:icon>
                            <x-icons.key class="w-5 h-5" />
                        </x-slot:icon>
                    </x-ui.input>
                    @error('password')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror

                    <!-- Lupa Kata Sandi -->
                    <div class="flex justify-end mt-2">
                        <a href="{{ route('password.request') }}"
                            class="text-xs text-gray-600 hover:text-blue-600 transition-colors font-medium underline-offset-4 hover:underline">
                            Lupa kata sandi?
                        </a>
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox"
                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                            name="remember">
                        <span class="ms-2 text-sm text-gray-600">{{ __('Ingat saya') }}</span>
                    </label>
                </div>

                <!-- Link Daftar & Tombol Masuk -->
                <div class="pt-2 space-y-6">
                    <x-ui.button type="submit"
                        class="w-full py-2.5 md:py-3 px-4 text-sm md:text-base font-semibold rounded-lg transition-all shadow-md hover:shadow-lg">
                        Masuk
                    </x-ui.button>

                    <p class="text-center text-gray-600 text-sm">
                        Belum memiliki akun?
                        <a href="{{ route('register') }}"
                            class="text-blue-600 hover:text-blue-700 font-medium p-0 h-auto underline-offset-4 hover:underline">
                            Daftar Sekarang
                        </a>
                    </p>
                </div>

            </form>
        </x-ui.card>
    </div>

</body>

</html>
