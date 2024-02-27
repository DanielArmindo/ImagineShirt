<section class="space-y-6">
    <header>
        <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Are you sure you want to delete your account?') }}
        </h4>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.destroy') }}" class="p-6" style="margin-top: 10px">
        @csrf
        @method('delete')

        <div class="mt-6">
            <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

            <x-text-input
                id="password"
                name="password"
                type="password"
                class="mt-1 block w-3/4"
                placeholder="{{ __('Password') }}"
            />
        </div>

        <div class="mt-6 flex justify-end">

            <x-danger-button class="ml-3" style="margin-top: 10px">
                {{ __('Delete Account') }}
            </x-danger-button>
        </div>
    </form>
</section>
