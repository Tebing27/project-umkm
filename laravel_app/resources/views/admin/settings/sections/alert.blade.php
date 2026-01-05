@if(session('success'))
    <div class="mb-6 p-4 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-700 flex items-center gap-3">
        <x-icons.ui-check class="w-5 h-5 shrink-0" />
        <p>{{ session('success') }}</p>
    </div>
@endif
