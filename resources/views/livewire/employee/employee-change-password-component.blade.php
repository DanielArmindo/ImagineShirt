<x-app-layout>
    <section class="pt-50 pb-50">
        <div class="container">
            <div class="row">
                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Password Updated') }}</p>
                @endif

                @include('profile.partials.update-password-form')
            </div>
        </div>
    </section>
</x-app-layout>
