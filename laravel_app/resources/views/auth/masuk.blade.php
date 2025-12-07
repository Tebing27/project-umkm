<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Usaha - UMKM Sasuma</title>
    <!-- Menggunakan Tailwind CSS CDN untuk preview instan -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

</head>

<body>

    <div class="min-h-screen flex flex-col justify-center items-center p-4">
        <div class="w-full max-w-[420px] bg-white rounded-2xl shadow-xl p-6 md:p-10 border border-gray-100">

            <!-- Judul -->
            <h1 class="text-center text-3xl md:text-4xl font-bold mb-8 text-gray-900 tracking-tight">
                Masuk Usaha
            </h1>

            <form action="#" method="POST" class="space-y-5">

                <!-- Input Email / No HP -->
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">
                        Email atau Nomor Handphone
                    </label>
                    <div class="relative group">
                        <!-- Icon -->
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <x-icons.mail
                                class="w-5 h-5 text-gray-400 group-focus-within:text-blue-600 transition-colors"
                                stroke-width="1.5" />
                        </div>
                        <!-- Input Field -->
                        <input type="text" placeholder="Contoh: tebing@gmail.com"
                            class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 text-gray-900 placeholder-gray-400 transition-all duration-200 text-sm font-medium">
                    </div>
                </div>

                <!-- Input Password -->
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">
                        Kata Sandi
                    </label>
                    <div class="relative group">
                        <!-- Icon -->
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <x-icons.key
                                class="w-5 h-5 text-gray-400 group-focus-within:text-blue-600 transition-colors" />
                        </div>
                        <!-- Input Field -->
                        <input type="password" placeholder="Masukkan kata sandi"
                            class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 text-gray-900 placeholder-gray-400 transition-all duration-200 text-sm font-medium">
                    </div>

                    <!-- Lupa Kata Sandi -->
                    <div class="flex justify-end mt-2">
                        <a href="#"
                            class="text-sm text-gray-500 hover:text-blue-600 transition-colors font-medium">
                            Lupa kata sandi?
                        </a>
                    </div>
                </div>

                <!-- Link Daftar & Tombol Masuk -->
                <div class="pt-2 space-y-6">
                    <button type="submit"
                        class="w-full bg-[#FFC107] hover:bg-[#ffcd38] text-lg font-medium py-3 px-8 rounded-xl transition-all duration-200 transform active:scale-[0.98] shadow-md hover:shadow-lg flex justify-center items-center gap-2">
                        Masuk
                    </button>

                    <p class="text-center text-gray-600 text-sm">
                        Belum memiliki akun?
                        <a href="/daftar" class="text-blue-600 hover:text-blue-700 font-semibold hover:underline">
                            Daftar Sekarang
                        </a>
                    </p>
                </div>

            </form>
        </div>

</body>

</html>
