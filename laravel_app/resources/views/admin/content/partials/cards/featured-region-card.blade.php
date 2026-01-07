<div x-data="{
    open: false,
    selectedId: '{{ $region->featured_shop_id ?? '' }}',
    selectedName: '{{ addslashes($region->selected_shop_name) }}',
    filter: '',
    isLoading: false,

    submitForm() {
        this.isLoading = true;
        let formData = new FormData(this.$refs.form);
        formData.set('shop_id', this.selectedId);

        fetch(this.$refs.form.action, {
            method: 'POST', body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        })
        .then(response => response.json())
        .then(data => {
            this.isLoading = false;
            if (data.success) showToast(data.message, 'success');
            else showToast(data.message || 'Terjadi kesalahan', 'error');
        })
        .catch(error => {
            this.isLoading = false; console.error('Error:', error);
            showToast('Terjadi kesalahan jaringan', 'error');
        });
    }
}" 
@click.outside="open = false"
class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 hover:shadow-md transition-shadow relative"
:class="open ? 'z-50' : 'z-0 hover:z-10'">

<form x-ref="form" action="{{ route('admin.regions.update_featured_shop', $region->id) }}" method="POST" @submit.prevent="submitForm">
    @csrf @method('PUT')
    @include('admin.content.partials.cards.partials.featured-region-header')
    <div class="flex gap-2 items-center">
            @include('admin.content.partials.cards.partials.featured-region-dropdown')
            @include('admin.content.partials.cards.partials.featured-region-submit')
    </div>
</form>
</div>

