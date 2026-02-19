<div x-data="{ 
    notifications: [],
    add(message, type = 'success') {
        const id = Date.now() + Math.random().toString(36).substr(2, 9);
        this.notifications.push({ id, message, type });
        setTimeout(() => this.remove(id), 5000);
    },
    remove(id) {
        this.notifications = this.notifications.filter(n => n.id !== id);
    },
    init() {
        @if (session('success'))
            this.add('{{ addslashes(session('success')) }}', 'success');
        @endif
        @if (session('error'))
            this.add('{{ addslashes(session('error')) }}', 'error');
        @endif
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                this.add('{{ addslashes($error) }}', 'error');
            @endforeach
        @endif
    }
}"
@notify.window="add($event.detail.message, $event.detail.type)"
class="fixed inset-0 z-[100] flex flex-col items-center justify-start pt-24 pointer-events-none gap-3 px-4">
@include('admin.content.partials._toast-template')
</div>

<script>
function showToast(message, type = 'success') {
    window.dispatchEvent(new CustomEvent('notify', { detail: { message, type } }));
}
</script>

