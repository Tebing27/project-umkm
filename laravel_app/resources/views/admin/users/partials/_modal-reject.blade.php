<x-ui.modal show="rejectModalOpen" maxWidth="lg">
    <form action="{{ route('admin.reject-shop', $shop->id) }}" method="POST">
        @csrf
        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            <div class="sm:flex sm:items-start">
                <div class="mx-auto shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                    <x-icons.status-warning-triangle class="h-6 w-6 text-red-600" />
                </div>
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                    <h3 class="text-lg leading-6 font-bold text-slate-900">{{ translate('Tolak Verifikasi') }}</h3>
                    <div class="mt-2">
                        <p class="text-sm text-slate-500 mb-4">
                            {{ translate('Apakah Anda yakin ingin menolak verifikasi user ini? Silakan berikan alasan penolakan.') }}
                        </p>
                        <x-ui.textarea name="reason" rows="6"
                            placeholder="Contoh: Tidak valid nomor surat izin nya"
                            class="bg-slate-50 text-sm rounded-lg border-slate-300 focus:ring-blue-500/20 focus:border-blue-500 font-normal whitespace-pre-line">
@if(!$shop->isComplete())
{{ translate('Data UMKM belum lengkap. Mohon lengkapi data berikut:') }}
@foreach($shop->getMissingFields() as $field)
- {{ $field }}
@endforeach
@endif
                        </x-ui.textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-slate-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
            <button type="submit"
                class="w-full inline-flex justify-center rounded-xl bg-red-600 hover:bg-red-700 text-white shadow-sm sm:w-auto sm:text-sm py-2 px-4 font-semibold">
                {{ translate('Tolak Pengguna') }}
            </button>
            <button @click="rejectModalOpen = false" type="button"
                class="mt-3 w-full inline-flex justify-center rounded-xl bg-white text-slate-700 hover:bg-slate-50 sm:mt-0 sm:w-auto sm:text-sm py-2 px-4 font-semibold border border-slate-300">
                {{ translate('Batal') }}
            </button>
        </div>
    </form>
</x-ui.modal>
