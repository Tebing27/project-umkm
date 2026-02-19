<section>
    <header>
        <h2 class="text-lg font-medium text-slate-900">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-slate-600">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div x-data="{ show: false }">
            <x-ui.label for="update_password_current_password" :value="__('Current Password')" />
            <x-ui.input id="update_password_current_password" name="current_password" ::type="show ? 'text' : 'password'" class="mt-1 block w-full" autocomplete="current-password">
                <x-slot:icon>
                    <x-icons.auth-key class="w-5 h-5" />
                </x-slot:icon>
                <x-slot:suffix>
                     <button type="button" @click="show = !show" class="text-slate-400 hover:text-slate-600 focus:outline-none">
                        <x-icons.ui-eye x-show="!show" class="w-5 h-5" />
                        <x-icons.ui-eye-off x-show="show" class="w-5 h-5" />
                    </button>
                </x-slot:suffix>
            </x-ui.input>
            <x-ui.input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div x-data="{ show: false }">
            <x-ui.label for="update_password_password" :value="__('New Password')" />
            <x-ui.input id="update_password_password" name="password" ::type="show ? 'text' : 'password'" class="mt-1 block w-full" autocomplete="new-password">
                <x-slot:icon>
                    <x-icons.auth-key class="w-5 h-5" />
                </x-slot:icon>
                <x-slot:suffix>
                     <button type="button" @click="show = !show" class="text-slate-400 hover:text-slate-600 focus:outline-none">
                        <x-icons.ui-eye x-show="!show" class="w-5 h-5" />
                        <x-icons.ui-eye-off x-show="show" class="w-5 h-5" />
                    </button>
                </x-slot:suffix>
            </x-ui.input>
            <x-ui.input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div x-data="{ show: false }">
            <x-ui.label for="update_password_password_confirmation" :value="__('Confirm Password')" />
            <x-ui.input id="update_password_password_confirmation" name="password_confirmation" ::type="show ? 'text' : 'password'" class="mt-1 block w-full" autocomplete="new-password">
                <x-slot:icon>
                    <x-icons.auth-key class="w-5 h-5" />
                </x-slot:icon>
                <x-slot:suffix>
                     <button type="button" @click="show = !show" class="text-slate-400 hover:text-slate-600 focus:outline-none">
                        <x-icons.ui-eye x-show="!show" class="w-5 h-5" />
                        <x-icons.ui-eye-off x-show="show" class="w-5 h-5" />
                    </button>
                </x-slot:suffix>
            </x-ui.input>
            <x-ui.input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-ui.button variant="primary">{{ __('Save') }}</x-ui.button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-slate-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
