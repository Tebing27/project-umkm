@props([
    'variant' => 'default',
    'icon' => null,
    'placeholder' => 'Select Date',
    'value' => null,
    'name' => null,
    'id' => null,
])

<div x-data="{ 
    value: @js($value),
    instance: null,
    init() {
        this.instance = flatpickr(this.$refs.input, {
            dateFormat: 'Y-m-d',
            altInput: true,
            altFormat: 'F j, Y',
            defaultDate: this.value,
            onChange: (selectedDates, dateStr) => {
                this.value = dateStr;
            }
        });
    }
}" class="w-full">
    <x-ui.input 
        {{ $attributes }}
        variant="{{ $variant }}"
        x-ref="input"
        :name="$name"
        :id="$id"
        :placeholder="$placeholder"
        :value="$value"
    >
        @if($icon)
            <x-slot:icon>
                {{ $icon }}
            </x-slot:icon>
        @endif
    </x-ui.input>
</div>
