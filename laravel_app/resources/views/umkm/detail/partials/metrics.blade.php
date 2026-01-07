{{-- Omset --}}
@if($formattedOmset)
    <div class="border-t border-[#FFF0A6] pt-3">
        <h3 class="font-bold text-slate-900 text-base mb-1">{{translate('Omset Penjualan')}}</h3>
        <p class="text-slate-900 text-base">{{ $formattedOmset }}</p>
    </div>
@endif

{{-- Izin --}}
@if(!empty($licenses))
    <div class="border-t border-[#FFF0A6] pt-3">
        <h3 class="font-bold text-slate-900 text-base mb-2">{{translate('Izin Usaha')}}</h3>
        <ol class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-2 list-decimal list-inside text-base text-slate-900">
            @foreach($licenses as $license)
               <li>
                    <span class="font-semibold text-slate-900">{{ $license->type }}</span>
                    <span class="mx-1 text-slate-400">—</span>
                    <span class="font-medium text-slate-700">{{ $license->number }}</span>
                </li>
            @endforeach
        </ol>
    </div>
@endif
