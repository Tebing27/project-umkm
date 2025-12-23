<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Kata Sandi - UMKM Sasuma</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>

    <div class="min-h-screen flex flex-col justify-center items-center p-4">
        <x-ui.card class="w-full max-w-[420px] p-6 md:p-10 shadow-xl border-gray-100">

            <!-- Judul -->
            <h1 class="text-center text-2xl md:text-3xl font-bold mb-8 text-gray-900 tracking-tight">
                Reset Kata Sandi
            </h1>

            <form action="{{ route('password.store') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                @if ($errors->any())
                    <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg text-sm">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Email Address -->
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">Email</label>
                    <x-ui.input type="email" name="email" value="{{ old('email', $request->email) }}"
                        class="bg-gray-50" required autofocus autocomplete="username" readonly>
                        <x-slot:icon>
                            <x-icons.mail class="w-5 h-5" stroke-width="1.5" />
                        </x-slot:icon>
                    </x-ui.input>
                    @error('email')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">Kata Sandi Baru</label>
                    <x-ui.input type="password" name="password" placeholder="kata sandi baru"
                        class="bg-gray-50" required autocomplete="new-password">
                        <x-slot:icon>
                            <x-icons.key class="w-5 h-5" />
                        </x-slot:icon>
                    </x-ui.input>
                    @error('password')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">Konfirmasi Kata Sandi</label>
                    <x-ui.input type="password" name="password_confirmation" placeholder="Konfirmasi kata sandi"
                        class="bg-gray-50" required autocomplete="new-password">
                        <x-slot:icon>
                            <x-icons.key class="w-5 h-5" />
                        </x-slot:icon>
                    </x-ui.input>
                </div>

                <!-- Tombol Reset -->
                <div class="pt-2">
                    <x-ui.button type="submit" class="rounded-lg w-full text-lg py-2 shadow-md">
                        Reset Password
                    </x-ui.button>
                </div>

            </form>
        </x-ui.card>
    </div>

</body>

</html>
