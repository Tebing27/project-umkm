{{-- Welcome Section --}}
    <div class="relative overflow-hidden text-slate-900">
        <div class="relative z-10">
            <h2 class="text-3xl md:text-4xl font-extrabold tracking-tight mb-2">Hi, {{ Auth::user()->name }} 👋</h2>
            <p class="text-slate-900 text-lg font-medium max-w-2xl mb-4">{{translate('Selamat datang kembali! Berikut adalah ringkasan performa toko Anda hari ini.')}}</p>
        </div>

        {{-- Decorative Circles --}}
        <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
    </div>
